<?php

namespace Core\Base\Providers;

use Illuminate\Support\Facades\Route;
use Core\Base\Middlewares\Authenticate;
use Core\Base\Middlewares\RedirectIfAuthenticated;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use File;
use Plugins\Tenant\Middlewares\SwitchPortal;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    protected $middlewares = [
        'web'   => ['web'],
        'admin' => ['web','auth-admin'],
        'ajax'  => ['web'],
        'api'   => ['api'],
    ];

    /**
     * {@inheritDoc}
     */
    protected $appendMiddlewares = [
        'Core' => [
            'Base' => [
                'access' => 'Authorization'
            ],
        ]
    ];

    /**
     * {@inheritDoc}
     */
    protected $applyAllRouteMiddleware = [
    ];

    /**
     * @var array
     */
    protected $routeSources = [];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function register()
    {
        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        
        $router->aliasMiddleware('auth-admin', Authenticate::class);
        $router->aliasMiddleware('switch-portal', SwitchPortal::class);
        $router->aliasMiddleware('guest', RedirectIfAuthenticated::class);
        
        $this->registerMiddleware($router);

    }

    /**
     * Register middleware append system
     * @author TrinhLe
     */
    public function registerMiddleware(Router $router)
    {
        foreach ($this->appendMiddlewares as $rootNamespace => $packages) {
            # code...
            foreach ($packages as $packageNamespace => $middlewares) {
                # code...
                foreach ($middlewares as $alias => $middlewareClass) {
                    # code...
                    if(!class_exists($class = "{$rootNamespace}\\{$packageNamespace}\\Middlewares\\{$middlewareClass}")) {
                        throw new \Exception("Not found middleware namespace is {$middlewareClass}");   
                    }
                    $router->aliasMiddleware($alias, $class);
                }
            }
        }
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->routeSources = loadPackages(SOURCE_ROUTERS, false);
        
        foreach ($this->routeSources as $group => $directory) 
        {   
            if(is_dir($directory))
            {
                $routePaths = File::glob($directory . '/*.php');
                foreach ($routePaths as $routeDirectory) {
                    $this->registerRouterPackage($routeDirectory, $group);
                }
            }
        }
    }

    /**
     * Register routes
     * @param string $routeDirectory
     * @param string $group
     * @author TrinhLe
     */
    public function registerRouterPackage(string $routeDirectory, string $group)
    {
        $routeFileName = pathinfo($routeDirectory, PATHINFO_FILENAME);
        $middleware = array_get($this->middlewares,$routeFileName);

        if(!is_array($middleware))
            throw new \Exception("System not support route type is {$routeFileName}", 1);
        
        $route               = Route::prefix(getPrefixRoute($routeFileName));
        $controlerDirectory  = getDirectoryController($group, $routeDirectory, $routeFileName);
        $middlewareNamespace = getNamespaceMiddleware($group, $routeFileName, $routeDirectory);
        $middleware[]        = $middlewareNamespace;
        $middleware = array_merge($this->applyAllRouteMiddleware, $middleware);

        return $route->middleware($middleware)->namespace($controlerDirectory)->group($routeDirectory);
    }
}
