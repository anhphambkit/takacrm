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
        'flag'        => 'payments.list',
        'parent_flag' => 'plugins.order',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'payments.create',
        'parent_flag' => 'payments.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'payments.edit',
        'parent_flag' => 'payments.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'payments.delete',
        'parent_flag' => 'payments.list',
    ],
];