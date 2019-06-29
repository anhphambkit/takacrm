<?php
return [
    [
        'name' => 'History',
        'flag' => 'history.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'history.create',
        'parent_flag' => 'history.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'history.edit',
        'parent_flag' => 'history.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'history.delete',
        'parent_flag' => 'history.list',
    ]
];