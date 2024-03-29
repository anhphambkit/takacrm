<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Notification
    |--------------------------------------------------------------------------
    |
    | This is the notification class that will be sent to users when they receive
    | a confirmation code.
    |
    */
    // 'notification' => ConfirmEmail::class,

    'verify_email' => env('CMS_CUSTOMER_VERIFY_EMAIL', true),

    'avatar' => [
        'folder' => [
            'upload'        => public_path('uploads'),
            'container_dir' => 'members/avatars',
        ],
    ],
];