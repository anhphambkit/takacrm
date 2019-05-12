<?php
namespace Core\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Blade;

class CmsServiceProvider extends ServiceProvider
{
	/**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listens = [];

    /**
     * The components mappings for the application.
     *
     * @var array
     */
    protected $component = [];

    /**
     * Auto Register Events
     * @author TrinhLe
     */
	protected function registerEvents()
	{
		foreach ($this->listens() as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
	}

	/**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listens;
    }

    /**
     * Register alias components
     * @author TrinhLe
     */
    protected function registerComponents()
    {
        foreach ($this->components() as $component => $alias)
        {
            Blade::component($component,$alias);
        }
            
    }

    /**
     * Get the components and alias.
     * @author TrinhLe
     * @return array
     */
    public function components()
    {
        return $this->component;
    }
}