<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 09:14
 */

namespace Plugins\Order\Services\Implement;

use Carbon\Carbon;
use Core\User\Repositories\Eloquent\UserRepository;
use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Plugins\Customer\Repositories\Interfaces\CustomerContactRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Order\Contracts\OrderConfigs;
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
     * ImplementOrderServices constructor.
     * @param OrderRepositories $orderRepositories
     * @param ProductsInOrderServices $productsInOrderServices
     * @param CustomerRepositories $customerRepositories
     * @param PaymentMethodRepositories $paymentMethodRepositories
     * @param OrderSourceRepositories $orderSourceRepositories
     * @param CustomerContactRepositories $customerContactRepositories
     * @param UserInterface $userRepository
     * @param ProductRepositories $productRepositories
     */
    public function __construct(OrderRepositories $orderRepositories, ProductsInOrderServices $productsInOrderServices,
                                CustomerRepositories $customerRepositories, PaymentMethodRepositories $paymentMethodRepositories,
                                OrderSourceRepositories $orderSourceRepositories, CustomerContactRepositories $customerContactRepositories,
                                UserInterface $userRepository, ProductRepositories $productRepositories)
    {
        $this->orderRepository = $orderRepositories;
        $this->productsInOrderServices = $productsInOrderServices;
        $this->customerRepositories = $customerRepositories;
        $this->paymentMethodRepositories = $paymentMethodRepositories;
        $this->orderSourceRepositories = $orderSourceRepositories;
        $this->userRepository = $userRepository;
        $this->customerContactRepositories = $customerContactRepositories;
        $this->productRepositories = $productRepositories;
    }

    /**
     * @param array $dataCheckouts
     * @return mixed
     */
    public function createNewOrder(array $dataCheckouts){
        $productsInOrder = $dataCheckouts['order_products'];

        $dataOrder = $this->prepareDataOrder($dataCheckouts);

        return DB::transaction(function () use ($dataOrder, $productsInOrder) {
            // Create new Order:
            $order = $this->orderRepository->createNewInvoiceOrder($dataOrder);
            // Products:
            $productsInOder = $this->prepareProductsDataInOrder($productsInOrder, $order->id);
            // Insert products in order:
            $this->productsInOrderServices->insertProductsInOrder($productsInOder);
            return $order;
        }, 3);
    }

    /**
     * @param array $data
     * @return array
     */
    public function prepareDataOrder(array $data) {
        $maxOrderId = $this->orderRepository->getMaxColumn();
        $data['created_by'] = Auth::id();

        if (!empty($data['customer_id']))
            $data['customer_info'] = json_encode($this->customerRepositories->findById($data['customer_id'])->toArray());
        else {
            $data['customer_name'] = (!empty($data['customer_info'])) ? $data['customer_info'] : OrderConfigs::GUEST;
        }

        $data['user_performed_info'] = json_encode($this->userRepository->findById($data['user_performed_id'])->toArray());

        if (!empty($data['payment_method_id']))
            $data['payment_method_info'] = json_encode($this->paymentMethodRepositories->findById($data['payment_method_id'])->toArray());

        if (!empty($data['order_source_id']))
            $data['order_source_info'] = json_encode($this->orderSourceRepositories->findById($data['order_source_id'])->toArray());

        if (!empty($data['customer_contact_id']))
            $data['customer_contact_info'] = json_encode($this->customerContactRepositories->findById($data['customer_contact_id'])->toArray());

        if (!empty($data['order_conditions']))
            $data['order_conditions'] = json_encode($data['order_conditions']);

        $data['order_code'] = (!empty($data['order_code'])) ? $data['order_code'] : OrderConfigs::ORDER_CODE_DEFAULT . "-{$maxOrderId}";
        $data['order_date'] = (!empty($data['order_date'])) ? $data['order_date'] : Carbon::now();

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

            $productsInOrder = [];
            foreach ($products as $index => $product) {
                $productsInOrder[$index]['order_id'] = $orderId;
                $productsInOrder[$index]['product_id'] = $product['id'];
                $productsInOrder[$index]['sku'] = $infoProducts[$product['id']]['sku'];
                $productsInOrder[$index]['name'] = $infoProducts[$product['id']]['name'];
                $productsInOrder[$index]['slug'] = $infoProducts[$product['id']]['slug'];
                $productsInOrder[$index]['short_description'] = $infoProducts[$product['id']]['short_description'];
                $productsInOrder[$index]['unit_name'] = $product['unit_name'];
                $productsInOrder[$index]['quantity'] = (int)$product['quantity'];
                $productsInOrder[$index]['retail_price'] = (int)$product['retail_price'];
                $productsInOrder[$index]['vat'] = (float)$product['vat'];
                $productsInOrder[$index]['discount'] = (int)$product['discount'];
                $productsInOrder[$index]['discount_percent'] = (float)$product['discount_percent'];
                $productsInOrder[$index]['total_price'] = (int)$product['total_price'];
                $productsInOrder[$index]['product_info'] = json_encode($infoProducts[$product['id']]);
                $productsInOrder[$index]['updated_at'] = $now;
                $productsInOrder[$index]['created_at'] = $now;
            }
            return $productsInOrder;
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
}