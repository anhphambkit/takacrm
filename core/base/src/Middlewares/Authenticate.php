<?php

namespace Core\Base\Middlewares;

use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;
use Closure;
use DashboardMenu;

class Authenticate extends BaseAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($guards);
        \DashboardMenu::init($request->user());
        return $next($request);
    }
}
