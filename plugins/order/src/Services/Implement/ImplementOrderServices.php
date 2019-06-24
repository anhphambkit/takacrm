<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 09:14
 */

namespace Plugins\Order\Services\Implement;

use Carbon\Carbon;
use Core\Setting\Repositories\Interfaces\ReferenceRepositories;
use Core\User\Repositories\Eloquent\UserRepository;
use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Services\CustomAttributeServices;
use Plugins\Customer\Repositories\Interfaces\CustomerContactRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Order\Contracts\OrderConfigs;
use Plugins\Order\Models\ProductsInOrder;
use Plugins\Order\Repositories\Interfaces\OrderRepositories;
use Plugins\Order\Repositories\Interfaces\OrderSourceRepositories;
use Plugins\Order\Repositories\Interfaces\PaymentMethodRepositories;
use Plugins\Order\Services\OrderServices;
use Plugins\Order\Services\ProductsInOrderServices;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;

class ImplementOrderServices implements OrderServices {

    /**
     * @var OrderRepositories
     */
    private $orderRepository;

    /**
     * @var ProductsInOrderServices
     */
    private $productsInOrderServices;

    /**
     * @var CustomerRepositories
     */
    private $customerRepositories;

    /**
     * @var PaymentMethodRepositories
     */
    private $paymentMethodRepositories;

    /**
     * @var OrderSourceRepositories
     */
    private $orderSourceRepositories;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CustomerContactRepositories
     */
    private $customerContactRepositories;

    /**
     * @var ProductRepositories
     */
    private $productRepositories;

    /**
     * @var ReferenceRepositories
     */
    private $referenceRepositories;

    /**
     * @var CustomAttributeServices
     */
    private $customAttributeServices;

    /**
     * ImplementOrderServices constructor.
     * @param OrderRepositories $orderRepositories
     * @param ProductsInOrderServices $productsInOrderServices
     * @param CustomerRepositories $customerRepositories
     * @param PaymentMethodRepositories $paymentMethodRepositories
     * @param OrderSourceRepositories $orderSourceRepositories
     * @param CustomerContactRepositories $customerContactRepositories
     * @param UserInterface $userRepository
     * @param ProductRepositories $productRepositories
     * @param ReferenceRepositories $referenceRepositories
     * @param CustomAttributeServices $customAttributeServices
     */
    public function __construct(OrderRepositories $orderRepositories, ProductsInOrderServices $productsInOrderServices,
                                CustomerRepositories $customerRepositories, PaymentMethodRepositories $paymentMethodRepositories,
                                OrderSourceRepositories $orderSourceRepositories, CustomerContactRepositories $customerContactRepositories,
                                UserInterface $userRepository, ProductRepositories $productRepositories,
                                ReferenceRepositories $referenceRepositories, CustomAttributeServices $customAttributeServices)
    {
        $this->orderRepository = $orderRepositories;
        $this->productsInOrderServices = $productsInOrderServices;
        $this->customerRepositories = $customerRepositories;
        $this->paymentMethodRepositories = $paymentMethodRepositories;
        $this->orderSourceRepositories = $orderSourceRepositories;
        $this->userRepository = $userRepository;
        $this->customerContactRepositories = $customerContactRepositories;
        $this->productRepositories = $productRepositories;
        $this->referenceRepositories = $referenceRepositories;
        $this->customAttributeServices = $customAttributeServices;
    }

    /**
     * @param array $dataCheckouts
     * @param int|null $orderId
     * @return mixed
     */
    public function createNewOrUpdateOrder(array $dataCheckouts, int $orderId = null){
        $isModeCreate = true;
        if ($orderId)
            $isModeCreate = false;

        $productsInOrder = $dataCheckouts['order_products'];

        $dataOrder = $this->prepareDataOrder($dataCheckouts, $isModeCreate);

        $allCustomAttributes = $this->customAttributeServices->getAllCustomAttributeByConditions([
            [
                'type_entity', '=', strtolower(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_ORDER)
            ]
        ], ['attributeOptions']);

        $order = null;
        if ($orderId) {
            $order = $this->orderRepository->findById($orderId);
            if (empty($order)) {
                abort(404);
            }
        }

        return DB::transaction(function () use ($order, $dataOrder, $productsInOrder, $allCustomAttributes) {
            if ($order) { // Update order
                $order->fill($dataOrder);

                $this->orderRepository->createOrUpdate($order);
            }
            else // Create new Order:
                $order = $this->orderRepository->createOrUpdate($dataOrder);

            // Products:
            $infoOrder = $this->prepareProductsDataInOrder($productsInOrder, $order->id);

            // Update Sale amount + discount order:
            $dataOrderUpdate = [
                'sale_order' => $infoOrder['sale_order'],
                'discount_order' => $infoOrder['discount_order'] + $order->fees_ship,
                'vat_order' => $infoOrder['vat_order'] + $order->fees_vat,
            ];
            $this->orderRepository->update([
                [
                    'id', '=', $order->id
                ]
            ], $dataOrderUpdate);

            $productsOrder = ProductsInOrder::with('order')->where('order_id', $order->id)->get();
            //IMPORTANT To tracking log history
            foreach ($productsOrder as $item) {
                $item->delete();
            }

            $order->products()->createMany($infoOrder['products']);

            $this->customAttributeServices->createOrUpdateDataEntityCustomAttributes($order, $allCustomAttributes, $dataOrder);

            $order->save();
            return $order;
        }, 3);
    }

    /**
     * @param array $data
     * @param bool $isModeCreate
     * @return array
     */
    public function prepareDataOrder(array $data, $isModeCreate = true) {
        $maxOrderId = (int)$this->orderRepository->getMaxColumn() + 1;

        if ($isModeCreate)
            $data['created_by'] = Auth::id();
        else
            $data['updated_by'] = Auth::id();

        if (!empty($data['customer_id']))
            $data['customer_info'] = $this->customerRepositories->findById($data['customer_id'])->toArray();
        else {
            $data['customer_name'] = (!empty($data['customer_name'])) ? $data['customer_name'] : OrderConfigs::GUEST;
        }

        if (!empty($data['user_performed_id']))
            $data['user_performed_info'] = $this->userRepository->findById($data['user_performed_id'], ['getRole'])->toArray();

        if (!empty($data['payment_method_id']))
            $data['payment_method_info'] = $this->paymentMethodRepositories->findById($data['payment_method_id'])->toArray();

        if (!empty($data['order_source_id']))
            $data['order_source_info'] = $this->orderSourceRepositories->findById($data['order_source_id'])->toArray();

        if (!empty($data['customer_contact_id']))
            $data['customer_contact_info'] = $this->customerContactRepositories->findById($data['customer_contact_id'])->toArray();

        $data['order_code'] = (!empty($data['order_code'])) ? $data['order_code'] : OrderConfigs::ORDER_CODE_DEFAULT . "-{$maxOrderId}";
        $data['order_date'] = (!empty($data['order_date'])) ? $data['order_date'] : Carbon::now();

        $notPaidStatus = $this->referenceRepositories->bySlug(str_slug(OrderConfigs::STATUS_PAYMENT_ORDER_NOT_PAID));
        $notPaidStatusId = ($notPaidStatus) ? $notPaidStatus->id : NULL;

        $newOrderStatus = $this->referenceRepositories->bySlug(str_slug(OrderConfigs::STATUS_ORDER_NEW));
        $newOrderStatusId = ($newOrderStatus) ? $newOrderStatus->id : NULL;

        $data['order_status'] = $newOrderStatusId;
        $data['payment_status'] = $notPaidStatusId;

        unset($data['order_products'], $data['_token'], $data['submit']);
        return $data;
    }

    /**
     * @param array $products
     * @param int $orderId
     * @return array
     * @throws \Exception
     */
    public function prepareProductsDataInOrder(array $products, int $orderId) {
        try {
            $now = Carbon::now();
            $productIds = collect($products)->pluck('id')->toArray();

            $infoProducts = $this->productRepositories->getByWhereIn('id', $productIds)->mapWithKeys(function ($item) {
                return [$item['id'] => $item];
            })->toArray();

            $salesOrder = 0;
            $vatOrder = 0;
            $discountOrder = 0;
            $productsInOrder = [];
            foreach ($products as $index => $product) {
                $productsInOrder[$index]['order_id'] = $orderId;
                $productsInOrder[$index]['product_id'] = $product['id'];
                $productsInOrder[$index]['sku'] = $infoProducts[$product['id']]['sku'];
                $productsInOrder[$index]['name'] = $infoProducts[$product['id']]['name'];
                $productsInOrder[$index]['slug'] = $infoProducts[$product['id']]['slug'];
                $productsInOrder[$index]['short_description'] = !empty($product['short_description']) ? $product['short_description'] : $infoProducts[$product['id']]['short_description'];
                $productsInOrder[$index]['unit_name'] = !empty($product['unit_name']) ? $product['unit_name'] : $infoProducts[$product['id']]['unit_name'];
                $productsInOrder[$index]['quantity'] = (int)$product['quantity'];
                $productsInOrder[$index]['retail_price'] = (int)$product['retail_price'];
                $productsInOrder[$index]['vat'] = !empty($product['vat']) ? (float)$product['vat'] : 0;
                $productsInOrder[$index]['discount'] = !empty($product['discount']) ? (int)$product['discount'] : 0;
                $productsInOrder[$index]['discount_percent'] = (float)$product['discount_percent'];
                $productsInOrder[$index]['total_price'] = (int)$product['total_price'];
                $productsInOrder[$index]['product_info'] = json_encode($infoProducts[$product['id']]);
                $productsInOrder[$index]['updated_at'] = $now;
                $productsInOrder[$index]['created_at'] = $now;
                $salesOrder += $productsInOrder[$index]['retail_price'];
                $vatOrder += ($productsInOrder[$index]['retail_price']*$productsInOrder[$index]['vat'])/100;
                $discountOrder += ($productsInOrder[$index]['discount']) ? $productsInOrder[$index]['discount'] : 0;
            }
            return [
                'products' => $productsInOrder,
                'sale_order' => round($salesOrder),
                'discount_order' => round($discountOrder),
                'vat_order' => round($vatOrder),
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $conditions
     * @param array $data
     * @return mixed
     */
    public function updateOrder(array $conditions, array $data) {
        return $this->orderRepository->update($conditions, $data);
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function searchListOrder(array $request)
    {
        return $this->orderRepository->searchListOrder($request);
    }
}