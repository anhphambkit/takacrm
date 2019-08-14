<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-12
 * Time: 10:49
 */

namespace Plugins\Tenant\Services;


use Plugins\Tenant\Models\Tenant;

interface VhostGenerator
{
    /**
     * @param Tenant $tenant
     * @return string
     */
    public function generate(Tenant $tenant): string;

    /**
     * @param Tenant $tenant
     * @return string
     */
    public function targetPath(Tenant $tenant): string;

    public function reload() : bool;
}