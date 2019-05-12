<?php
theme_option()->setSection([
    'title'      => __('General'),
    'desc'       => __('General settings'),
    'id'         => 'opt-text-subsection-general',
    'subsection' => true,
    'icon'       => 'fa fa-home',
    'fields' => [
        [
            'id' => 'header',
            'type' => 'text',
            'label' => __('Header'),
            'attributes' => [
                'name' => 'header',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 500,
                ]
            ],
        ],
        [
            'id' => 'name',
            'type' => 'text',
            'label' => __('Name'),
            'attributes' => [
                'name' => 'name',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'address',
            'type' => 'text',
            'label' => __('Address'),
            'attributes' => [
                'name' => 'address',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'phone',
            'type' => 'text',
            'label' => __('Phone'),
            'attributes' => [
                'name' => 'phone',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'fax',
            'type' => 'text',
            'label' => __('Fax'),
            'attributes' => [
                'name' => 'fax',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ]
    ],
]);

theme_option()->setSection([
    'title' => __('Logo'),
    'desc' => __('Change logo'),
    'id' => 'opt-text-subsection-logo',
    'subsection' => true,
    'icon' => 'fa fa-image',
    'fields' => [
        [
            'id' => 'logo',
            'type' => 'mediaImage',
            'label' => __('Logo'),
            'attributes' => [
                'name' => 'logo',
                'value' => null,
            ],
        ],
        [
            'id' => 'banner_homepage',
            'type' => 'mediaImage',
            'label' => __('Banner Homepage'),
            'attributes' => [
                'name' => 'banner_homepage',
                'value' => null,
            ],
        ],

        [
            'id' => 'logo_footer_1',
            'type' => 'mediaImage',
            'label' => __('Logo Footer 1'),
            'attributes' => [
                'name' => 'logo_footer_1',
                'value' => null,
            ],
        ],
        [
            'id' => 'logo_footer_2',
            'type' => 'mediaImage',
            'label' => __('Logo Footer 2'),
            'attributes' => [
                'name' => 'logo_footer_2',
                'value' => null,
            ],
        ],
        [
            'id' => 'logo_footer_3',
            'type' => 'mediaImage',
            'label' => __('Logo Footer 3'),
            'attributes' => [
                'name' => 'logo_footer_3',
                'value' => null,
            ],
        ],
        [
            'id' => 'logo_footer_4',
            'type' => 'mediaImage',
            'label' => __('Logo Footer 4'),
            'attributes' => [
                'name' => 'logo_footer_4',
                'value' => null,
            ],
        ],

        [
            'id' => 'logo_footer_link_1',
            'type' => 'text',
            'label' => __('Logo Footer Link 1'),
            'attributes' => [
                'name' => 'logo_footer_link_1',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'logo_footer_link_2',
            'type' => 'text',
            'label' => __('Logo Footer Link 2'),
            'attributes' => [
                'name' => 'logo_footer_link_2',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'logo_footer_link_3',
            'type' => 'text',
            'label' => __('Logo Footer Link 3'),
            'attributes' => [
                'name' => 'logo_footer_link_3',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'logo_footer_link_4',
            'type' => 'text',
            'label' => __('Logo Footer Link 4'),
            'attributes' => [
                'name' => 'logo_footer_link_4',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 120,
                ]
            ],
        ],
    ],
]);

theme_option()->setSection([
    'title' => __('Social'),
    'desc' => __('Social settings'),
    'id' => 'opt-text-subsection-social',
    'subsection' => true,
    'icon' => 'fa fa-users',
    'fields' => [
        [
            'id' => 'facebook',
            'type' => 'text',
            'label' => __('Facebook'),
            'attributes' => [
                'name' => 'facebook',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://www.facebook.com/',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'google_plus',
            'type' => 'text',
            'label' => __('Google+'),
            'attributes' => [
                'name' => 'google_plus',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://plus.google.com/',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'linkedin',
            'type' => 'text',
            'label' => __('Linkedin'),
            'attributes' => [
                'name' => 'linkedin',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://www.linkedin.com/',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'yelp',
            'type' => 'text',
            'label' => __('Yelp'),
            'attributes' => [
                'name' => 'yelp',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://www.yelp.com/',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'instagram',
            'type' => 'text',
            'label' => __('Instagram'),
            'attributes' => [
                'name' => 'instagram',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://www.instagram.com/',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'twitter',
            'type' => 'text',
            'label' => __('Twitter'),
            'attributes' => [
                'name' => 'twitter',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://twitter.com/',
                    'data-counter' => 120,
                ]
            ],
        ],
    ],
]);

/* theme option email of warehouse */
theme_option()->setSection([
    'title' => __('Email List'),
    'desc' => __('Email List Settings'),
    'id' => 'opt-text-subsection-email',
    'subsection' => true,
    'icon' => 'fa fa-envelope-o',
    'fields' => [
        [
            'id' => 'admin_email',
            'type' => 'text',
            'label' => __('Admin Email'),
            'attributes' => [
                'name' => 'admin_email',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'application_email',
            'type' => 'text',
            'label' => __('Application From Email (separated by ",")'),
            'attributes' => [
                'name' => 'application_email',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'amount_more_than_50_email',
            'type' => 'text',
            'label' => __('Customer Info Form - More than 50K'),
            'attributes' => [
                'name' => 'amount_more_than_50_email',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'amount_less_than_50_email',
            'type' => 'text',
            'label' => __('Customer Info Form - Less than 50K'),
            'attributes' => [
                'name' => 'amount_less_than_50_email',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'customer_service_email',
            'type' => 'text',
            'label' => __('Customer Service Email (separated by ",")'),
            'attributes' => [
                'name' => 'customer_service_email',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'order_inquires_email',
            'type' => 'text',
            'label' => __('Billing Email (separated by ",")'),
            'attributes' => [
                'name' => 'order_inquires_email',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'part_request_email',
            'type' => 'text',
            'label' => __('Part Request Email (separated by ",")'),
            'attributes' => [
                'name' => 'part_request_email',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'sale_quote_email',
            'type' => 'text',
            'label' => __('Sale Quote Email (separated by ",")'),
            'attributes' => [
                'name' => 'sale_quote_email',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
        [
            'id' => 'photo_submission_email',
            'type' => 'text',
            'label' => __('Photo Submission Email (separated by ",")'),
            'attributes' => [
                'name' => 'photo_submission_email',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => '',
                    'data-counter' => 120,
                ]
            ],
        ],
    ],
]);

theme_option()->setArgs(['debug' => false]);