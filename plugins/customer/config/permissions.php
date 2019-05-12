<?php
return [
    [
        'name' => 'Customer',
        'flag' => 'customer.index',
        'is_feature' => true,
    ],
    [
        'name' => 'Customer',
        'flag' => 'customer.list',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'customer.create',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'customer.edit',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'customer.delete',
        'parent_flag' => 'customer.index',
    ],

    // Group Customer:
    [
        'name' => 'Group Customer',
        'flag' => 'group_customer.list',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'group_customer.create',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'group_customer.edit',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'group_customer.delete',
        'parent_flag' => 'customer.index',
    ],

    // Customer Source:
    [
        'name' => 'Customer Source',
        'flag' => 'customer_source.list',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'customer_source.create',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'customer_source.edit',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'customer_source.delete',
        'parent_flag' => 'customer.index',
    ],

    // Customer Jobs:
    [
        'name' => 'Customer Jobs',
        'flag' => 'customer_job.list',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'customer_job.create',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'customer_job.edit',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'customer_job.delete',
        'parent_flag' => 'customer.index',
    ],

    // Customer Relations:
    [
        'name' => 'Customer Relation',
        'flag' => 'customer_relation.list',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'customer_relation.create',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'customer_relation.edit',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'customer_relation.delete',
        'parent_flag' => 'customer.index',
    ]
];