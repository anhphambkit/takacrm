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
    ]
];
