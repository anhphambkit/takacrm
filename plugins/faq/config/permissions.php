<?php
return [
    [
        'name' => 'Faq',
        'flag' => 'faq.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'faq.create',
        'parent_flag' => 'faq.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'faq.edit',
        'parent_flag' => 'faq.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'faq.delete',
        'parent_flag' => 'faq.list',
    ]
];