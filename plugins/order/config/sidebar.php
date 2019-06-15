<?php

return [
    [

        'id'          => 'menu-order-administrator',
        'priority'    => 1,
        'parent_id'   => null,
        'name'        => 'plugins-order::sidebar.administrator',
        'icon'        => 'fas fa-users-cog',
        'url'         => null,
        'permissions' => ['orders.list']
    ],
    [
        'id'          => 'menu-order-order',
        'priority'    => 2,
        'parent_id'   => 'menu-order-administrator',
        'name'        => 'plugins-order::sidebar.order',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.order.list',
        'permissions' => ['orders.list']
    ],
    [
        'id'          => 'menu-order-payment',
        'priority'    => 3,
        'parent_id'   => 'menu-order-administrator',
        'name'        => 'plugins-order::sidebar.payment',
        'icon'        => 'fas fa-money-check',
        'url'         => 'admin.order.payment.method.list',
        'permissions' => ['order_payments.list']
    ],
    [
        'id'          => 'menu-order-source',
        'priority'    => 4,
        'parent_id'   => 'menu-order-administrator',
        'name'        => 'plugins-order::sidebar.source_order',
        'icon'        => 'fab fa-sourcetree',
        'url'         => 'admin.order.source.method.list',
        'permissions' => ['order_sources.list']
    ],
    [
        'id'          => 'menu-custom-attribute-order',
        'priority'    => 5,
        'parent_id'   => 'menu-order-administrator',
        'name'        => 'plugins-custom-attributes::sidebar.custom_attributes',
        'icon'        => 'far fa-list-alt',
        'url'         => 'admin.custom-attributes.entity.list',
        'params_url'  => [ 'typeEntity' => 'order' ],
        'permissions' => ['custom-attributes.list']
    ],
];
