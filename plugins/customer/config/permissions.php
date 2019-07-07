<?php
return [
    [
        'name' => 'Customer',
        'flag' => 'plugins.customer',
        'is_feature' => true,
    ],

    // Customer
    [
        'name' => 'Customer',
        'flag' => 'customer.list',
        'parent_flag' => 'plugins.customer',
    ],
    [
        'name' => 'Create',
        'flag' => 'customer.create',
        'parent_flag' => 'customer.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'customer.edit',
        'parent_flag' => 'customer.list',
    ],
    [
        'name' => 'View',
        'flag' => 'customer.view',
        'parent_flag' => 'customer.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'customer.delete',
        'parent_flag' => 'customer.list',
    ],

    // Group Customer:
    [
        'name' => 'Group Customer',
        'flag' => 'group_customer.list',
        'parent_flag' => 'plugins.customer',
    ],
    [
        'name' => 'Create',
        'flag' => 'group_customer.create',
        'parent_flag' => 'group_customer.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'group_customer.edit',
        'parent_flag' => 'group_customer.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'group_customer.delete',
        'parent_flag' => 'group_customer.list',
    ],

    // Customer Source:
    [
        'name' => 'Customer Source',
        'flag' => 'customer_source.list',
        'parent_flag' => 'plugins.customer',
    ],
    [
        'name' => 'Create',
        'flag' => 'customer_source.create',
        'parent_flag' => 'customer_source.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'customer_source.edit',
        'parent_flag' => 'customer_source.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'customer_source.delete',
        'parent_flag' => 'customer_source.list',
    ],

    // Customer Jobs:
    [
        'name' => 'Customer Jobs',
        'flag' => 'customer_job.list',
        'parent_flag' => 'plugins.customer',
    ],
    [
        'name' => 'Create',
        'flag' => 'customer_job.create',
        'parent_flag' => 'customer_job.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'customer_job.edit',
        'parent_flag' => 'customer_job.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'customer_job.delete',
        'parent_flag' => 'customer_job.list',
    ],

    // Customer Relations:
    [
        'name' => 'Customer Relation',
        'flag' => 'customer_relation.list',
        'parent_flag' => 'plugins.customer',
    ],
    [
        'name' => 'Create',
        'flag' => 'customer_relation.create',
        'parent_flag' => 'customer_relation.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'customer_relation.edit',
        'parent_flag' => 'customer_relation.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'customer_relation.delete',
        'parent_flag' => 'customer_relation.list',
    ]
];