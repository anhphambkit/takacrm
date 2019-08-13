<?php

return [
    [
        'id'          => 'menu-product-administrator',
        'priority'    => 1,
        'parent_id'   => null,
        'name'        => 'plugins-product::sidebar.administrator',
        'icon'        => 'fab fa-product-hunt',
        'url'         => null,
        'permissions' => ['products.list']
    ],
    [
        'id'          => 'menu-product-product',
        'priority'    => 1,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.product',
        'icon'        => 'fas fa-boxes',
        'url'         => 'admin.product.list',
        'permissions' => ['products.list']
    ],
    [
        'id'          => 'menu-product-categories',
        'priority'    => 2,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.category',
        'icon'        => 'fas fa-sitemap',
        'url'         => 'admin.product.category.list',
        'permissions' => ['product_categories.list']
    ],
    [
        'id'          => 'menu-product-manufacturers',
        'priority'    => 3,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.manufacturer',
        'icon'        => 'fas fa-industry',
        'url'         => 'admin.product.manufacturer.list',
        'permissions' => ['product_manufacturers.list']
    ],
    [
        'id'          => 'menu-product-units',
        'priority'    => 4,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.unit',
        'icon'        => 'fab fa-uniregistry',
        'url'         => 'admin.product.unit.list',
        'permissions' => ['product_units.list']
    ],
    [
        'id'          => 'menu-product-origins',
        'priority'    => 5,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.origin',
        'icon'        => 'fas fa-flag',
        'url'         => 'admin.product.origin.list',
        'permissions' => ['product_origins.list']
    ],
//    [
//        'id'          => 'menu-custom-attribute-product',
//        'priority'    => 7,
//        'parent_id'   => 'menu-product-administrator',
//        'name'        => 'plugins-custom-attributes::sidebar.custom_attributes',
//        'icon'        => 'far fa-list-alt',
//        'url'         => 'admin.custom-attributes.entity.list',
//        'params_url'  => [ 'typeEntity' => 'product' ],
//        'permissions' => ['custom-attributes.list']
//    ],
];
