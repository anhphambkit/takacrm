<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-12
 * Time: 10:38
 */

namespace Plugins\Tenant\Services;


use Plugins\Tenant\Models\Tenant;

interface ServerServices
{
    /**
     * @param Tenant $tenant
     * @return bool
     */
    public function generate(Tenant $tenant);
}