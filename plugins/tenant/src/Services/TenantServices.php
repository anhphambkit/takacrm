<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-08
 * Time: 16:01
 */

namespace Plugins\Tenant\Services;

use Plugins\Tenant\Models\Tenant;

interface TenantServices
{
    /**
     * @param array $data
     * @return mixed
     */
    public function registerTenant(array $data);

    /**
     * @param array $data
     * @param Tenant $currentTenant
     * @return mixed
     */
    public function updateTenant(array $data, Tenant $currentTenant);
}