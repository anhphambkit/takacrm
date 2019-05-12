<?php

namespace Plugins\Customer\Middlewares;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'customer')
    {
        if (Auth::guard($guard)->check()) {
            return redirect(route('public.customer.dashboard'));
        }

        return $next($request);
    }
}
