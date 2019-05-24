<?php
return [
    [
        'name' => 'Order',
        'flag' => 'order.list',
        'is_feature' => true,
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
    ]
];