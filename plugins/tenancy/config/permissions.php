<?php
return [
    [
        'name' => 'Tenancy',
        'flag' => 'tenancy.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'tenancy.create',
        'parent_flag' => 'tenancy.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'tenancy.edit',
        'parent_flag' => 'tenancy.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'tenancy.delete',
        'parent_flag' => 'tenancy.list',
    ]
];