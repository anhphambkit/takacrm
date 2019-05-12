<?php
return [
    [
        'name' => 'Product',
        'flag' => 'plugins.product',
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

    // Color Attributes:
    [
        'name'        => 'Color Attributes',
        'flag'        => 'product_colors.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_colors.create',
        'parent_flag' => 'product_colors.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_colors.edit',
        'parent_flag' => 'product_colors.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_colors.delete',
        'parent_flag' => 'product_colors.list',
    ],

    // Business Type:
    [
        'name'        => 'Business Types',
        'flag'        => 'product_business_types.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_business_types.create',
        'parent_flag' => 'product_business_types.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_business_types.edit',
        'parent_flag' => 'product_business_types.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_business_types.delete',
        'parent_flag' => 'product_business_types.list',
    ],

    // Space:
    [
        'name'        => 'Spaces',
        'flag'        => 'product_spaces.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_spaces.create',
        'parent_flag' => 'product_spaces.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_spaces.edit',
        'parent_flag' => 'product_spaces.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_spaces.delete',
        'parent_flag' => 'product_spaces.list',
    ],

    // Collection:
    [
        'name'        => 'Collections',
        'flag'        => 'product_collections.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_collections.create',
        'parent_flag' => 'product_collections.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_collections.edit',
        'parent_flag' => 'product_collections.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_collections.delete',
        'parent_flag' => 'product_collections.list',
    ],

    // Material:
    [
        'name'        => 'Materials',
        'flag'        => 'product_materials.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_materials.create',
        'parent_flag' => 'product_materials.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_materials.edit',
        'parent_flag' => 'product_materials.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_materials.delete',
        'parent_flag' => 'product_materials.list',
    ],

    // Look Book:
    [
        'name'        => 'Look Books',
        'flag'        => 'product_look_books.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_look_books.create',
        'parent_flag' => 'product_look_books.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_look_books.edit',
        'parent_flag' => 'product_look_books.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_look_books.delete',
        'parent_flag' => 'product_look_books.list',
    ],
    //Coupon
    [
        'name'        => 'Coupon',
        'flag'        => 'product_coupon.list',
        'parent_flag' => 'plugins.product',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'product_coupon.create',
        'parent_flag' => 'product_coupon.list',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'product_coupon.edit',
        'parent_flag' => 'product_coupon.list',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'product_coupon.delete',
        'parent_flag' => 'product_coupon.list',
    ],
];