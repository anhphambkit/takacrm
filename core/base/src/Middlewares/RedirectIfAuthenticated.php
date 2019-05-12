<?php

namespace Core\Base\Middlewares;

use Closure;
use Core\User\Models\User;
use Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            /**
             * @var User $user
             */
            $user = Auth::user();
            if ($user->hasPermission('dashboard.index')) {
                return redirect(route('admin.dashboard.index'));
            }

            return redirect()->to('/');
        }

        return $next($request);
    }
}
