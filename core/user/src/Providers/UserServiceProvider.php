<?php

namespace Core\User\Providers;
use Illuminate\Support\Facades\Auth;
#User
use Core\User\Repositories\Interfaces\UserInterface;
use Core\User\Repositories\Eloquent\UserRepository;

#Role
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Cache\RoleCacheDecorator;
use Core\User\Repositories\Eloquent\RoleRepository;

use Core\Base\Providers\CmsServiceProvider as CoreServiceProvider;

use Illuminate\Foundation\AliasLoader;
use Core\User\Facades\AclManagerFacade;

use Core\User\Repositories\Interfaces\ActivationRepositories;
use Core\User\Repositories\Eloquent\EloquentActivationRepositories;

/**
 * Class UserServiceProvider
 * @package Core\User
 */
class UserServiceProvider extends CoreServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listens = [
        \Core\User\Events\AuditHandlerEvent::class => [
            \Core\User\Events\Listeners\AuditHandlerListener::class,
        ],
        \Core\User\Events\RoleUpdateEvent::class => [
            \Core\User\Events\Listeners\RoleUpdateListener::class,
        ],
        \Core\User\Events\RoleAssignmentEvent::class => [
            \Core\User\Events\Listeners\RoleAssignmentListener::class,
        ],
    ];

    /**
     * register
     */
    public function register()
    {
        $this->reigsterServices();
        $this->reigsterRepositories();
        $this->registerEvents();
    }

    /**
     * Register list services
     * @return type
     */
    protected function reigsterServices()
    {
        $this->app->singleton(
            \Core\User\Services\Interfaces\CreateUserServiceInterface::class,
            \Core\User\Services\Excute\CreateUserServiceExcute::class
        );

        $this->app->singleton(
            \Core\User\Services\Interfaces\ChangePasswordServiceInterface::class,
            \Core\User\Services\Excute\ChangePasswordServiceExcute::class
        );

        $this->app->singleton(
            \Core\User\Services\Interfaces\UpdateProfileImageServiceInterface::class,
            \Core\User\Services\Excute\UpdateProfileImageServiceExcute::class
        );
    }

    /**
     * Register list repo
     * @author TrinhLe
     */
    protected function reigsterRepositories()
    {

        $this->app->singleton(UserInterface::class, function () {
            return new UserRepository(new \Core\User\Models\User());
        });

        $this->app->singleton(ActivationRepositories::class, function () {
            return new EloquentActivationRepositories(new \Core\User\Models\Activation());
        });

        if (setting('enable_cache', false)) {

            $this->app->singleton(RoleInterface::class, function () {
                return new RoleCacheDecorator(new RoleRepository(new \Core\User\Models\Role()));
            });
            
        } else {

            $this->app->singleton(RoleInterface::class, function () {
                return new RoleRepository(new \Core\User\Models\Role());
            });
        }
    }

    /**
     * Boot provider
     * @author TrinhLe
     */
    public function boot()
    {
        config()->set(['auth.providers.users.model' => \Core\User\Models\User::class]);

        $loader = AliasLoader::getInstance();
        $loader->alias('AclManager', AclManagerFacade::class);

        $this->app->register(HookServiceProvider::class);
    }
}
