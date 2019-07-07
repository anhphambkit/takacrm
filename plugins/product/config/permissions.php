<?php
return [
    [
        'name' => 'Product',
        'flag' => 'plugins.product',
        'is_feature' => true,
    ],

    // Products:
    [
        'name'        => 'Products',
        'flag'        => 'products.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'products.create',
        'parent_flag' => 'products.list',
    ],
    [
        'name'        => 'View',
        'flag'        => 'products.view',
        'parent_flag' => 'products.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'products.edit',
        'parent_flag' => 'products.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'products.delete',
        'parent_flag' => 'products.list',
    ],

    // Product Categories:
    [
        'name'        => 'Product Categories',
        'flag'        => 'product_categories.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_categories.create',
        'parent_flag' => 'product_categories.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_categories.edit',
        'parent_flag' => 'product_categories.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_categories.delete',
        'parent_flag' => 'product_categories.list',
    ],

    // Manufacturers:
    [
        'name'        => 'Manufacturers',
        'flag'        => 'product_manufacturers.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_manufacturers.create',
        'parent_flag' => 'product_manufacturers.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_manufacturers.edit',
        'parent_flag' => 'product_manufacturers.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_manufacturers.delete',
        'parent_flag' => 'product_manufacturers.list',
    ],

    // Unit:
    [
        'name'        => 'Product Unit',
        'flag'        => 'product_units.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_units.create',
        'parent_flag' => 'product_units.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_units.edit',
        'parent_flag' => 'product_units.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_units.delete',
        'parent_flag' => 'product_units.list',
    ],

    // Origins:
    [
        'name'        => 'Product Origins',
        'flag'        => 'product_origins.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_origins.create',
        'parent_flag' => 'product_origins.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_origins.edit',
        'parent_flag' => 'product_origins.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_origins.delete',
        'parent_flag' => 'product_origins.list',
    ],
];
