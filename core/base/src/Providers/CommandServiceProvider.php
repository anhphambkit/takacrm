<?php
namespace Core\Base\Providers;
use Illuminate\Support\ServiceProvider;
use Core\Base\Commands\DumpAutoload;
use Core\Base\Commands\PluginCreateCommand;
use Core\Master\Supports\LoadRegisterTrait;

class CommandServiceProvider extends ServiceProvider
{
	use LoadRegisterTrait;

	/**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

	/**
	 * Boot containers
	 * @author TrinhLe
	 */
	public function boot()
	{
		$listCommands = array();
		$listPackages = $this->loadPackageAvailable();
		foreach ($listPackages as $namespace => $packageUrl) 
		{
			$fullPathKernel = "{$packageUrl}/Commands/Kernel.php";
			$fullNamespace = "\\{$namespace}Commands\\Kernel";
			if(file_exists(base_path($fullPathKernel)))
			{	
				$packageCommands = app("$fullNamespace")->getCommands();
				$listCommands    = array_merge($listCommands, $packageCommands);
			}
		}

		return $this->commands($listCommands);
	}
}