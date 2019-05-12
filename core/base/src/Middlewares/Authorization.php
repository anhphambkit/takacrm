<?php
namespace Core\Base\Middlewares;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Closure;

class Authorization {

    /**
     * @var Redirector
     */
    private $redirect;

    /**
     * Authorization constructor.
     * @param RoleServices $role
     */
    public function __construct(Redirector $redirect)
    {
        $this->redirect = $redirect;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $permission
     * @return mixed
     */
    public function handle($request, Closure $next, string $permission) 
    {
        if(!auth()->check())
            return $this->handleUnauthorizedRequest($request, $permission);

        if(!auth()->user()->hasPermission($permission)){

            return $this->handleUnauthorizedRequest($request, $permission);
        }
        
        return $next($request);
    }

    /**
     * @param Request $request
     * @param $permission
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    protected function handleUnauthorizedRequest(Request $request, $permission)
    {
        if ($request->expectsJson()) {
            return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
        }
        if ($request->user() === null) {
            return $this->redirect->route(HOME_ROUTE_FRONTEND);
        }

        return abort(404);
    }
}