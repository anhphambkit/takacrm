<?php

return [
    [
        'id'          => 'menu-tenancy-administrator',
        'priority'    => 1,
        'parent_id'   => null,
        'name'        => 'plugins-tenancy::sidebar.administrator',
        'icon'        => 'fab fa-tenancy-hunt',
        'url'         => null,
        'permissions' => ['tenancy.list']
    ],
    [
        'id'          => 'menu-tenancy-tenancy',
        'priority'    => 1,
        'parent_id'   => 'menu-tenancy-administrator',
        'name'        => 'plugins-tenancy::sidebar.tenancy',
        'icon'        => 'fas fa-boxes',
        'url'         => 'admin.tenancy.list',
        'permissions' => ['tenancy.list']
    ],
];
