<?php
return [
	[
		'id'          => 'menu-core-setting',
		'priority'    => 1,
		'parent_id'   => null,
		'name'        => 'core-setting::sidebar.setting',
		'icon'        => 'fas fa-wrench',
		'url'         => null,
		'permissions' => ['setting.index']
    ],
    [
		'id'          => 'cms-setting-system',
		'priority'    => 1,
		'parent_id'   => 'menu-core-setting',
		'name'        => 'core-setting::sidebar.system',
		'icon'        => 'fas fa-users',
		'url'         => 'admin.setting.system',
		'permissions' => ['setting.system']
    ],
    [
		'id'          => 'cms-setting-option',
		'priority'    => 2,
		'parent_id'   => 'menu-core-setting',
		'name'        => 'core-setting::sidebar.option',
		'icon'        => 'fas fa-cogs',
		'url'         => 'admin.setting.option',
		'permissions' => ['setting.option']
    ],
];