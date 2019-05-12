<?php

return [

	[
		'id'          => 'cms-plugins-blog',
		'priority'    => 3,
		'parent_id'   => null,
		'name'        => 'plugins-blog::sidebar.blog',
		'icon'        => 'fas fa-edit',
		'url'         => null,
		'permissions' => ['posts.list']
	],
	[
		'id'          => 'cms-plugins-blog-post',
		'priority'    => 1,
		'parent_id'   => 'cms-plugins-blog',
		'name'        => 'plugins-blog::sidebar.post',
		'icon'        => null,
		'url'         => 'admin.blog.post.list',
		'permissions' => ['posts.list']
	],
	[
		'id'          => 'cms-plugins-blog-categories',
		'priority'    => 2,
		'parent_id'   => 'cms-plugins-blog',
		'name'        => 'plugins-blog::sidebar.category',
		'icon'        => null,
		'url'         => 'admin.blog.category.list',
		'permissions' => ['categories.list']
	],
	[
		'id'          => 'cms-plugins-blog-tags',
		'priority'    => 3,
		'parent_id'   => 'cms-plugins-blog',
		'name'        => 'plugins-blog::sidebar.tag',
		'icon'        => null,
		'url'         => 'admin.blog.tag.list',
		'permissions' => ['tags.list']
	],
];