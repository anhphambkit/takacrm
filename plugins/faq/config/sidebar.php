<?php

return [
	[
		'id'          => 'menu-plugin-faq',
		'priority'    => 5,
		'parent_id'   => null,
		'name'        => 'plugins-faq::sidebar.faq',
		'icon'        => 'fas fa-question-circle',
		'url'         => 'admin.faq.list',
		'permissions' => ['faq.list']
    ],
];