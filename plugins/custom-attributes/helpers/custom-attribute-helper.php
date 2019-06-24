<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 08:39
 */

if (!function_exists('table_attribute_actions')) {
    /**
     * @param $edit
     * @param $delete
     * @param $manage
     * @param $item
     * @return string
     * @throws Throwable
     */
    function table_attribute_actions($edit, $delete, $manage, $item)
    {
        return view('plugins-custom-attributes::tables.actions', compact('edit', 'delete', 'manage', 'item'))->render();
    }
}

if (!function_exists('table_custom_attribute_actions')) {
    /**
     * @param $edit
     * @param $delete
     * @param $item
     * @return string
     * @throws Throwable
     */
    function table_custom_attribute_actions($edit, $delete, $item)
    {
        return view('plugins-custom-attributes::tables.custom-attribute-actions', compact('edit', 'delete', 'item'))->render();
    }
}