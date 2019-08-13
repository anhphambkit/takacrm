<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-12
 * Time: 16:08
 */

namespace Plugins\Tenant\Middlewares;

use Closure;
use Auth;
use Illuminate\Support\Facades\DB;

class SwitchPortal
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $subDomain = function_exists('get_sub_domain') ? get_sub_domain() : null;

        if (empty($subDomain)) {
            return $next($request);
        }
        return $next($request);
    }
}