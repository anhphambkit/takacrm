<?php

return [
    [
        'id'          => 'menu-tenant-administrator',
        'priority'    => 1,
        'parent_id'   => null,
        'name'        => 'plugins-tenant::sidebar.administrator',
        'icon'        => 'fab fa-tenant-hunt',
        'url'         => null,
        'permissions' => ['tenant.list']
    ],
    [
        'id'          => 'menu-tenant-tenant',
        'priority'    => 1,
        'parent_id'   => 'menu-tenant-administrator',
        'name'        => 'plugins-tenant::sidebar.tenant',
        'icon'        => 'fas fa-boxes',
        'url'         => 'admin.tenant.list',
        'permissions' => ['tenant.list']
    ],
];