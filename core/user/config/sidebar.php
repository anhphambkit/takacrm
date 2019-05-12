<?php
return [
	[
		'id'          => 'cms-core-administrator',
		'priority'    => 1,
		'parent_id'   => null,
		'name'        => 'core-user::sidebar.administrators',
		'icon'        => 'fas fa-users-cog',
		'url'         => null,
		'permissions' => ['user.index']
    ],
    [
		'id'          => 'cms-core-user',
		'priority'    => 1,
		'parent_id'   => 'cms-core-administrator',
		'name'        => 'core-user::sidebar.user',
		'icon'        => 'fas fa-users',
		'url'         => 'admin.user.index',
		'permissions' => ['user.index']
    ],
    [
		'id'          => 'cms-core-role',
		'priority'    => 2,
		'parent_id'   => 'cms-core-administrator',
		'name'        => 'core-user::sidebar.role',
		'icon'        => 'fas fa-cogs',
		'url'         => 'admin.role.index',
		'permissions' => ['role.index']
    ],
    [
		'id'          => 'cms-core-super-user',
		'priority'    => 3,
		'parent_id'   => 'cms-core-administrator',
		'name'        => 'core-user::sidebar.super-user',
		'icon'        => 'fas fa-cogs',
		'url'         => 'admin.super-user.index',
		'permissions' => ['superuser']
    ]
];