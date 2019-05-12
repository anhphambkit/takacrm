<?php
return [
    'general' => [
        'name' => trans('core-setting::setting.general.general_block'),
        'settings' => [
            [
                'label' => trans('core-setting::setting.general.rich_editor'),
                'type' => 'select',
                'attributes' => [
                    'name' => 'rich_editor',
                    'list' => [
                        'ckeditor' => 'Ckeditor',
                        'tinymce' => 'Tinymce',
                    ],
                    'value' => 'ckeditor',
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'label' => trans('core-setting::setting.general.paypal_mode'),
                'type' => 'select',
                'attributes' => [
                    'name' => 'paypal_mode',
                    'list' => [
                        'sanbox' => 'Sanbox',
                        'live' => 'Live',
                    ],
                    'value' => 'sanbox',
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'label' => trans('core-setting::setting.general.site_title'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'site_title',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('core-setting::setting.general.placeholder.site_title'),
                        'data-counter' => 120,
                    ],
                ],
            ],
            [
                'label' => trans('core-setting::setting.general.banner_homepage_content'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'banner_homepage_content',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('core-setting::setting.general.placeholder.banner_homepage_content'),
                        'data-counter' => 120,
                    ],
                ],
            ],
        ]
    ],
    'seo' => [
        'name' => trans('core-setting::setting.general.seo_block'),
        'settings' => [
            [
                'label' => trans('core-setting::setting.general.seo_title'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'seo_title',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('core-setting::setting.general.placeholder.seo_title'),
                        'data-counter' => 120,
                    ],
                ],
            ],
            [
                'label' => trans('core-setting::setting.general.seo_description'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'seo_description',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('core-setting::setting.general.placeholder.seo_description'),
                        'data-counter' => 120,
                    ],
                ],
            ],
            [
                'label' => trans('core-setting::setting.general.seo_keywords'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'seo_keywords',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('core-setting::setting.general.placeholder.seo_keywords'),
                        'data-counter' => 60,
                    ],
                ],
            ],
        ]
    ],
    'webmaster_tools' => [
        'name' => trans('core-setting::setting.general.webmaster_tools_block'),
        'settings' => [
            [
                'label' => trans('core-setting::setting.general.google_analytics'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'google_analytics',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('core-setting::setting.general.placeholder.google_analytics'),
                    ],
                ],
            ],
            [
                'label' => trans('core-setting::setting.general.google_site_verification'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'google_site_verification',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('core-setting::setting.general.placeholder.google_site_verification'),
                    ],
                ],
            ],
            [
                'label' => trans('core-setting::setting.general.enable_captcha'),
                'type' => 'onOff',
                'attributes' => [
                    'name' => 'enable_captcha',
                    'value' => 1,
                ],
            ],
        ]
    ],
    'cache' => [
        'name' => 'Cache',
        'settings' => [
            [
                'label' => trans('core-setting::setting.general.cache_time_site_map'),
                'type' => 'number',
                'attributes' => [
                    'name' => 'cache_time_site_map',
                    'value' => 3600,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'label' => trans('core-setting::setting.general.enable_cache'),
                'type' => 'onOff',
                'attributes' => [
                    'name' => 'enable_cache',
                    'value' => 1,
                ],
            ],
        ]
    ]
];