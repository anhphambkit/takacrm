<?php
return [
    [
        'name' => 'Tenant',
        'flag' => 'tenant.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'tenant.create',
        'parent_flag' => 'tenant.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'tenant.edit',
        'parent_flag' => 'tenant.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'tenant.delete',
        'parent_flag' => 'tenant.list',
    ]
];