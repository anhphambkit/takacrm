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
        'id'          => 'menu-product-spaces',
        'priority'    => 4,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.space',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.space.list',
        'permissions' => ['product_spaces.list']
    ],
    [
        'id'          => 'menu-product-colors',
        'priority'    => 5,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.color',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.color.list',
        'permissions' => ['product_colors.list']
    ],
    [
        'id'          => 'menu-product-business-types',
        'priority'    => 6,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.business-type',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.business-type.list',
        'permissions' => ['product_business_types.list']
    ],
    [
        'id'          => 'menu-product-collections',
        'priority'    => 7,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.collection',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.collection.list',
        'permissions' => ['product_collections.list']
    ],
    [
        'id'          => 'menu-product-materials',
        'priority'    => 8,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.material',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.material.list',
        'permissions' => ['product_materials.list']
    ],
    [
        'id'          => 'menu-look-books',
        'priority'    => 9,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.look_book',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.look_book.list',
        'permissions' => ['product_look_books.list']
    ],
    [
        'id'          => 'menu-product-coupon',
        'priority'    => 10,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.coupon',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.coupon.list',
        'permissions' => ['product_coupon.list']
    ],
];