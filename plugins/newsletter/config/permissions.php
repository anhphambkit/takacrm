<?php
return [
    [
        'name' => 'Newsletter',
        'flag' => 'newsletter.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'newsletter.create',
        'parent_flag' => 'newsletter.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'newsletter.edit',
        'parent_flag' => 'newsletter.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'newsletter.delete',
        'parent_flag' => 'newsletter.list',
    ]
];