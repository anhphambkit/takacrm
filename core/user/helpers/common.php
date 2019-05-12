<?php

use Core\User\Models\UserMeta;
use Illuminate\Http\Request;
use Core\User\Models\Role;

if (!function_exists('render_login_form')) {
    /**
     * @return string
     * @author TrinhLe
     */
    function render_login_form() {
        return view('acl::partials.login-form')->render();
    }
}

if (!function_exists('get_user_meta')) {
    /**
     * @param $key
     * @param null $default
     * @return mixed
     * @author TrinhLe
     */
    function get_user_meta($key, $default = null) {
        return UserMeta::getMeta($key, $default);
    }
}

if (!function_exists('set_user_meta')) {
    /**
     * @param $key
     * @param null $value
     * @param int $user_id
     * @return mixed
     * @internal param null $default
     * @author TrinhLe
     */
    function set_user_meta($key, $value = null, $user_id = 0) {
        return UserMeta::setMeta($key, $value, $user_id);
    }
}

if (!function_exists('merge_permission_parent')) {

    /**
     * merge list permission
     * @param Role $role 
     * @param type $permissions 
     * @return array
     */
    function merge_permission_parent($parent, array $permissions):array 
    {
        if($parent instanceof Role) 
            $parentRole = $parent;
        else{
            $parentRole = Role::find((int)$parent);
            if(!$parentRole) return $permissions;
        }

        $parentPermissions = $parentRole->permissions;
        foreach ($permissions as $key => $value) {
            # code...
            if(($parentPermissions[$key] ?? false) == false)
                unset($permissions[$key]);
        }
        return $permissions;
    }
}