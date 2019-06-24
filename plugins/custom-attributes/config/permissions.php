<?php
return [
    [
        'name' => 'CustomAttributes',
        'flag' => 'custom-attributes.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'custom-attributes.create',
        'parent_flag' => 'custom-attributes.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'custom-attributes.edit',
        'parent_flag' => 'custom-attributes.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'custom-attributes.delete',
        'parent_flag' => 'custom-attributes.list',
    ]
];