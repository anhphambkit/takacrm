<?php

return [
	[
		'id'          => 'menu-customer-administrator',
		'priority'    => 1,
		'parent_id'   => null,
		'name'        => 'plugins-customer::sidebar.administrator',
		'icon'        => 'fas fa-users-cog',
		'url'         => null,
		'permissions' => ['customer.index']
    ],
    [
		'id'          => 'menu-customer-customer',
		'priority'    => 1,
		'parent_id'   => 'menu-customer-administrator',
		'name'        => 'plugins-customer::sidebar.customer',
		'icon'        => 'fas fa-users-cog',
		'url'         => 'admin.customer.list',
		'permissions' => ['customer.list']
    ],
    [
        'id'          => 'menu-customer-group',
        'priority'    => 2,
        'parent_id'   => 'menu-customer-administrator',
        'name'        => 'plugins-customer::sidebar.group_customer',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.customer.group_customer.list',
        'permissions' => ['group_customer.list']
    ],
    [
        'id'          => 'menu-customer-source',
        'priority'    => 3,
        'parent_id'   => 'menu-customer-administrator',
        'name'        => 'plugins-customer::sidebar.customer_source',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.customer.customer_source.list',
        'permissions' => ['customer_source.list']
    ],
    [
        'id'          => 'menu-customer-job',
        'priority'    => 3,
        'parent_id'   => 'menu-customer-administrator',
        'name'        => 'plugins-customer::sidebar.customer_job',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.customer.customer_job.list',
        'permissions' => ['customer_job.list']
    ],
    [
        'id'          => 'menu-customer-relation',
        'priority'    => 4,
        'parent_id'   => 'menu-customer-administrator',
        'name'        => 'plugins-customer::sidebar.customer_relation',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.customer.customer_relation.list',
        'permissions' => ['customer_relation.list']
    ],
];