<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-30
 * Time: 22:13
 */

if (!function_exists('table_customer_checkbox')) {
    /**
     * @param $id
     * @param $colorCode
     * @return string
     * @throws Throwable
     */
    function table_customer_checkbox($id, $colorCode)
    {
        return view('plugins-customer::partials.tables.checkbox', compact('id', 'colorCode'))->render();
    }
}

if (!function_exists('table_customer_actions')) {
    /**
     * @param $view
     * @param $edit
     * @param $delete
     * @param $item
     * @return string
     * @throws Throwable
     */
    function table_customer_actions($view, $edit, $delete, $item)
    {
        return view('plugins-customer::partials.tables.actions', compact('view', 'edit', 'delete', 'item'))->render();
    }
}