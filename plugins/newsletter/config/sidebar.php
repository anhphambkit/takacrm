<?php
return [
	[
		'id'          => 'menu-plugin-newsletter',
		'priority'    => 4,
		'parent_id'   => null,
		'name'        => 'plugins-newsletter::sidebar.newsletter',
		'icon'        => 'fas fa-envelope',
		'url'         => 'admin.newsletter.list',
		'permissions' => ['newsletter.list']
    ],
];