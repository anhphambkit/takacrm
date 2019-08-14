<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-08
 * Time: 16:01
 */

namespace Plugins\Tenancy\Services;

interface TenancyServices
{
    /**
     * @param array $data
     * @return TenancyServices
     */
    public function registerTenant(array $data): TenancyServices;
}