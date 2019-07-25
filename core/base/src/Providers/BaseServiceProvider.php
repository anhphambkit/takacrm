<?php 
namespace Core\Base\Providers;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Core\Master\Supports\Helper;
use Core\Master\Providers\MasterServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Core\Base\Exceptions\Handler;
use Core\Master\Supports\LoadRegisterTrait;
use FloatingPoint\Stylist\StylistServiceProvider;
use Core\Setting\Providers\SettingServiceProvider;
use Core\Theme\Providers\AssetServiceProvider;
use Core\Theme\Providers\ThemeServiceProvider;
use Core\User\Providers\UserServiceProvider;
use Core\Media\Providers\MediaServiceProvider;
use Core\Slug\Providers\SlugServiceProvider;
use Illuminate\Routing\Events\RouteMatched;
use Core\Base\Repositories\Interfaces\PluginRepositories;
use Core\Base\Repositories\Eloquent\EloquentPluginRepositories;
use Core\Base\Repositories\Cache\CachePluginRepositories;
use Illuminate\Support\Facades\Validator;
use Event;

class BaseServiceProvider extends ServiceProvider
{	
	use LoadRegisterTrait;

	/**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
	 * Register anothers services
	 * @return type
	 */
	public function register()
	{
		Helper::autoloadHelpers();
		
		/**
         * @var Router $router
         */
        $router = $this->app['router'];

		$this->app->register(AssetServiceProvider::class);
		$this->app->register(StylistServiceProvider::class);
		$this->app->register(MasterServiceProvider::class);
		$this->app->register(SettingServiceProvider::class);
		
		$this->app->singleton(ExceptionHandler::class, Handler::class);

		$this->app->singleton(PluginRepositories::class, function () {
            $repository = new EloquentPluginRepositories(new \Core\Base\Models\Plugin());

            if (! setting('enable_cache', false)) {
                return $repository;
            }
            return new CachePluginRepositories($repository);
        });

        $this->app->register(PluginServiceProvider::class);
	}
    
	/**
	 * Binding containers
	 * @return type
	 */
	public function boot()
	{	
		# load config important use helper.
		$this->cmsLoadTranslates();
		$this->cmsLoadConfigs();
		$this->cmsLoadViews();
		$this->publishMigration();
		$this->pushlishData();
		$this->publishesAssetRegister();

		$this->app->register(CommandServiceProvider::class);
		$this->app->register(BreadcrumbsServiceProvider::class);
		$this->app->register(RouteServiceProvider::class);
		$this->app->register(ThemeServiceProvider::class);
		$this->app->register(FormServiceProvider::class);
		$this->app->register(UserServiceProvider::class);
		$this->app->register(MediaServiceProvider::class);
		$this->app->register(SlugServiceProvider::class);
		
        add_filter(DASHBOARD_FILTER_MENU_NAME, [\Core\Dashboard\Hooks\DashboardMenuHook::class, 'renderMenuDashboard']);
        add_filter(BASE_FILTER_GET_LIST_DATA, [$this, 'addLanguageColumn'], 50, 2);
        
        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->loadRegisterMenus();
        });

        $this->registerValidation();
	}

	/**
     * @param $data
     * @param $screen
     * @return mixed
     * @author TrinhLe
     */
    public function addLanguageColumn($data, $screen)
    {
        return $data;
    }

    /**
     * Register list extend validation
     * @author TrinhLe
     */
    protected function registerValidation()
    {
    	/**
         * Create validation mutiple level
         * @author TrinhLe
         * @return boolean
         */
        Validator::extend('mutiple_level_parent', function ($attribute, $value, $parameters, $validator) {
			$primaryKey = $parameters[0] ?? 0;
			$collection = app($parameters[1])->all();
			$parents    = get_array_parent_object($collection, $value);
			return !in_array((int)$primaryKey, $parents);
        });

        /**
         * Replace validation mutiple level
         * @author TrinhLe
         * @return String
         */
        Validator::replacer('mutiple_level_parent', function ($message, $attribute, $rule, $parameters) {
        	return trans('core-base::validation.mutiple_level_parent');
        });
    }
}
