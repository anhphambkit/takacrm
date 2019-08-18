<?php

use Illuminate\Database\Seeder;
use Plugins\Order\Contracts\OrderConfigs;

class DataReferenceOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();

        /**
         * Order status reference
         */
        $orderStatus =[
            [
                'value' => OrderConfigs::STATUS_ORDER_NEW,
                'slug' => str_slug(OrderConfigs::STATUS_ORDER_NEW),
                'type' => OrderConfigs::STATUS_ORDER_TYPE,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => OrderConfigs::STATUS_ORDER_COMPLETED,
                'slug' => str_slug(OrderConfigs::STATUS_ORDER_COMPLETED),
                'type' => OrderConfigs::STATUS_ORDER_TYPE,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => OrderConfigs::STATUS_ORDER_CANCELLED,
                'slug' => str_slug(OrderConfigs::STATUS_ORDER_CANCELLED),
                'type' => OrderConfigs::STATUS_ORDER_TYPE,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        foreach ($orderStatus as $reference) {
            \Core\Setting\Models\Reference::updateOrCreate(
                [
                    'value' => $reference['value'],
                    'type' => $reference['type']
                ],
                [
                    'slug' => $reference['slug'],
                ]
            );
        }

        /**
         * Payment status reference:
         */
        $paymentStatus =[
            [
                'value' => OrderConfigs::STATUS_PAYMENT_ORDER_PAID,
                'slug' => str_slug(OrderConfigs::STATUS_PAYMENT_ORDER_PAID),
                'type' => OrderConfigs::STATUS_PAYMENT_ORDER_TYPE,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => OrderConfigs::STATUS_PAYMENT_ORDER_NOT_PAID,
                'slug' => str_slug(OrderConfigs::STATUS_PAYMENT_ORDER_NOT_PAID),
                'type' => OrderConfigs::STATUS_PAYMENT_ORDER_TYPE,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        foreach ($paymentStatus as $reference) {
            \Core\Setting\Models\Reference::updateOrCreate(
                [
                    'value' => $reference['value'],
                    'type' => $reference['type']
                ],
                [
                    'slug' => $reference['slug'],
                ]
            );
        }
    }
}
