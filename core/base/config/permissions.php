<?php
return [
    # Base permission access admin
	[
        'name' => 'Dashboard',
        'flag' => 'dashboard.index',
    ],
    # Permission user
    [
    	'name' => 'User',
        'flag' => 'user.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'user.create',
        'parent_flag' => 'user.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'user.delete',
        'parent_flag' => 'user.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'user.edit',
        'parent_flag' => 'user.index',
    ],
    [
        'name' => 'Update Profile',
        'flag' => 'user.update-profile',
        'parent_flag' => 'user.index',
    ],
    #Permission role
    [
    	'name' => 'Role',
        'flag' => 'role.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'role.create',
        'parent_flag' => 'role.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'role.edit',
        'parent_flag' => 'role.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'role.delete',
        'parent_flag' => 'role.index',
    ],
    # permission media
    [
        'name' => 'Media',
        'flag' => 'media.index',
    ],
    [
        'name' => 'Folders Create',
        'flag' => 'folders.create',
        'parent_flag' => 'media.index',
    ],
    [
        'name' => 'Folders Edit',
        'flag' => 'folders.edit',
        'parent_flag' => 'media.index',
    ],
    [
        'name' => 'Folders Trash',
        'flag' => 'folders.trash',
        'parent_flag' => 'media.index',
    ],
    [
        'name' => 'Folders delete',
        'flag' => 'folders.delete',
        'parent_flag' => 'media.index',
    ],
    [
        'name' => 'Files Create',
        'flag' => 'files.create',
        'parent_flag' => 'media.index',
    ],
    [
        'name' => 'Files Edit',
        'flag' => 'files.edit',
        'parent_flag' => 'media.index',
    ],
    [
        'name' => 'Files Trash',
        'flag' => 'files.trash',
        'parent_flag' => 'media.index',
    ],
    [
        'name' => 'Files Delete',
        'flag' => 'files.delete',
        'parent_flag' => 'media.index',
    ],
];