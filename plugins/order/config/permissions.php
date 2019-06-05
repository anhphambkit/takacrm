<?php
return [
    [
        'name' => 'Order',
        'flag' => 'plugins.order',
    ],

    [
        'name'        => 'Manage Orders',
        'flag'        => 'order.list',
        'parent_flag' => 'plugins.order',
    ],
    [
        'name' => 'Create',
        'flag' => 'order.create',
        'parent_flag' => 'order.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'order.edit',
        'parent_flag' => 'order.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'order.delete',
        'parent_flag' => 'order.list',
    ],

    //Payment
    [
        'name'        => 'Payments',
        'flag'        => 'order.payments.list',
        'parent_flag' => 'plugins.order',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'order.payments.create',
        'parent_flag' => 'order_payments.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'order.payments.edit',
        'parent_flag' => 'order_payments.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'order.payments.delete',
        'parent_flag' => 'order_payments.list',
    ],

    //Order
    [
        'name'        => 'Sources Order',
        'flag'        => 'order.sources.list',
        'parent_flag' => 'plugins.order',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'order.sources.create',
        'parent_flag' => 'order_sources.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'order.sources.edit',
        'parent_flag' => 'order_sources.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'order.sources.delete',
        'parent_flag' => 'order_sources.list',
    ],
];