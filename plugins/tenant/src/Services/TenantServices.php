<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-08
 * Time: 16:01
 */

namespace Plugins\Tenant\Services;

interface TenantServices
{
    /**
     * @param array $data
     * @return mixed
     */
    public function registerTenant(array $data);
}