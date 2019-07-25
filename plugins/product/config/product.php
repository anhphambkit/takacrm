<?php

return [
    'weight_layout_look_book' => [
        'vertical' => 2,
        'normal' => 1,
        'main' => 4,
    ],
    'percent_layout_look_book' => [
        'full' => [
            'vertical' => 30,
            'normal' => 60,
            'main' => 10,
        ],
        'vertical_normal' => [
            'vertical' => 35,
            'normal' => 65,
        ],
        'vertical_main' => [
            'vertical' => 65,
            'main' => 35,
        ],
        'normal_main' => [
            'normal' => 80,
            'main' => 20,
        ]
        ],
    'export_columns' =>[
        trans('plugins-product::product.product_code')                          => '',
            trans('plugins-product::product.product_name')                          => '',
            trans('plugins-product::product.form.category')                         => '',
            trans('plugins-product::product.form.units')                            => '',
            trans('plugins-product::product.form.manufacturer')                     => '',
            trans('plugins-product::product.form.origins')                          => '',
            trans('plugins-product::product.form.short_description')                => '',
            trans('plugins-product::product.form.long_desc')                        => '',
            trans('plugins-product::product.form.retail_price')                     => '',
            trans('plugins-product::product.form.wholesale_price')                  => '',
            trans('plugins-product::product.form.discount').'(%)'                   => '',
            trans('plugins-product::product.form.wholesale_discount').'(%)'         => '',
            trans('plugins-product::product.form.online_price')                     => '',
            trans('plugins-product::product.form.online_discount').'(%)'            => '',
            trans('plugins-product::product.form.purchase_price')                   => '',
            trans('plugins-product::product.form.purchase_discount').'(%)'          => '',
            trans('plugins-product::product.form.vat').'(%)'                        => ''
    ]
    
];
