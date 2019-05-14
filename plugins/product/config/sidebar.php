<?php

return [
    [
        'id'          => 'menu-product-administrator',
        'priority'    => 1,
        'parent_id'   => null,
        'name'        => 'plugins-product::sidebar.administrator',
        'icon'        => 'fas fa-users-cog',
        'url'         => null,
        'permissions' => ['products.list']
    ],
    [
        'id'          => 'menu-product-product',
        'priority'    => 1,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.product',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.list',
        'permissions' => ['products.list']
    ],
    [
        'id'          => 'menu-product-categories',
        'priority'    => 2,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.category',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.category.list',
        'permissions' => ['product_categories.list']
    ],
    [
        'id'          => 'menu-product-manufacturers',
        'priority'    => 3,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.manufacturer',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.manufacturer.list',
        'permissions' => ['product_manufacturers.list']
    ],
    [
        'id'          => 'menu-product-units',
        'priority'    => 3,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.unit',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.unit.list',
        'permissions' => ['product_units.list']
    ],
    [
        'id'          => 'menu-product-origins',
        'priority'    => 3,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.origin',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.origin.list',
        'permissions' => ['product_origins.list']
    ],
];