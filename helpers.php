<?php 
use Illuminate\Support\Facades\Cache;

if (!function_exists('get_file_data')) {
    /**
     * @param $file
     * @param $convert_to_array
     * @return bool|mixed
     * @author TrinhLe
     */
    function get_file_data($file, $convert_to_array = true)
    {
        $file = File::get($file);
        if (!empty($file)) {
            if ($convert_to_array) {
                return json_decode($file, true);
            } else {
                return $file;
            }
        }
        return [];
    }
}

if (!function_exists('json_encode_prettify')) {
    /**
     * @param $data
     * @return string
     */
    function json_encode_prettify($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('save_file_data')) {
    /**
     * @param $path
     * @param $data
     * @param $json
     * @return bool|mixed
     * @author TrinhLe
     */
    function save_file_data($path, $data, $json = true)
    {
        try {
            if ($json) {
                $data = json_encode_prettify($data);
            }
            File::put($path, $data);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}

if (!function_exists('scan_folder')) {
    /**
     * @param $path
     * @param array $ignore_files
     * @return array
     * @author TrinhLe
     */
    function scan_folder($path, $ignore_files = [])
    {
        try {
            if (is_dir($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..'], $ignore_files));
                natsort($data);
                return $data;
            }
            return [];
        } catch (Exception $ex) {
            return [];
        }
    }
}

if (function_exists('getPsr4Core') === false) {

    /**
     * Get packages from composer.json
     * @param type|bool $isCorePackages 
     * @param type|bool $bothSystem 
     * @author TrinhLe
     * @return mixed
     */
    function getPsr4Core(bool $bothSystem = true, bool $isCorePackages = true)
    {
        $composer = get_file_data(base_path() . '/composer.json');
        $listPsr4 = $composer['psr-4-core'];
        return $listPsr4;
    }
}

if (function_exists('loadPackages') === false) {

    /**
     * Load list package or plugin
     * @param type|string $pathSource 
     * @param type|bool $pathSource 
     * @author TrinhLe
     * @return array
     */
    function loadPackages(string $pathSource, bool $formatNamespace = true)
    {
        $listPackages = loadPackageAvailable();
        $listSourcePath = array();

        foreach ($listPackages as $namespace => $packageUrl) {
            if(is_dir($path = mergePathSource($packageUrl, $pathSource))){
                if($formatNamespace === true)
                    $group = str_replace('-src', '', trim(preg_replace('/\//', '-', $packageUrl)));
                else
                    $group = $namespace;
                $listSourcePath[$group] = $path;
            }
        }
        return $listSourcePath;
    }
}

if (function_exists('mergePathSource') === false) {

    /**
     * Load list package or plugin
     * @param type|string $pathSource 
     * @author TrinhLe
     * @return mixed
     */
    function mergePathSource(string $package, string $source)
    {
        if($source)
            return base_path("{$package}{$source}");

        return base_path($package);
    }
}

if (function_exists('getPackageNamespace') === false) {

    /**
     * Get prefix namespace for core or plugin
     * @param type|string $psr4 
     * @author TrinhLe
     * @return string
     */
    function getPackageNamespace(string $psr4)
    {
        $array = explode('-',$psr4);
        if(empty($array))
            throw new \Exception("Invalid package from composer.json", 1);
        return $array[1];
    }
}

if (function_exists('getDirectoryController') === false) {

    /**
     * Get directory controler
     * @param string $groupRoute 
     * @param string $routeDirectory 
     * @param string $routeFileName 
     * @author TrinhLe
     * @return string
     */
    function getDirectoryController(string $groupRoute, string $routeDirectory, string $routeFileName)
    {
        $rootDirectory        = explode('src', $routeDirectory)[0];
        $controllerFolderName = ucfirst($routeFileName);
        $controlerDirectory   = "{$rootDirectory}src/Controllers/{$controllerFolderName}";
        $controllerNamespace = "{$groupRoute}Controllers\\{$controllerFolderName}";
        if(!is_dir($controlerDirectory))
            throw new \Exception("Not found controller directory: {$controlerDirectory}");
        return $controllerNamespace;
    }
}

if (function_exists('getNamespaceMiddleware') === false) {

    /**
     * Get directory controler
     * @param string $groupRoute 
     * @param string $routeFileName 
     * @param string $routeDirectory 
     * @author TrinhLe
     * @return string
     */
    function getNamespaceMiddleware(string $groupRoute, string $routeFileName, string $routeDirectory)
    {
        $routeFileName = ucfirst($routeFileName);
        $rootDirectory = explode('src', $routeDirectory)[0];
        $middlewareNameDirectory = "{$rootDirectory}src/Middlewares/{$routeFileName}Middleware.php";
        $middlewareNamespace = "{$groupRoute}Middlewares\\{$routeFileName}Middleware";

        if(!file_exists($middlewareNameDirectory) || !class_exists($middlewareNamespace)) {
            throw new \Exception("Not found controller directory or namespace: {$middlewareNameDirectory}");   
        }

        return $middlewareNamespace;
    }
}

if (function_exists('getPrefixRoute') === false) {

    /**
     * Get prefix route
     * @param string $route 
     * @author TrinhLe
     * @return string
     */
    function getPrefixRoute(string $route)
    {
        $prefixs = config('core-base.cms.router-prefix');
        return array_get($prefixs, $route);
    }
}

if (function_exists('loadPackageAvailable') === false) {

    /**
     * Get prefix route
     * @param string $route 
     * @author TrinhLe
     * @return string
     */
    function loadPackageAvailable()
    {
        $psr4Core     = getPsr4Core();
        $mergePlugins = [];
        $plugins      = getAllPlugins(1) ?? [];

        foreach ($plugins as $key => $plugin) {
            $mergePlugins[$plugin->namespace] = $plugin->src;
        }

        return array_merge($psr4Core, $mergePlugins);
    }
}

if (!function_exists('getAllPlugins')) {
    /**
     * @param null $status
     * @return mixed
     * @author TrinhLe
     */
    function getAllPlugins($status = null)
    {
        if(checkDatabaseConnection() && Schema::hasTable('plugins')){
            if ($status !== null)
                $condition['status'] = $status;
            return DB::table('plugins')->where($condition ?? [])->get();
        }
    }
}

if (!function_exists('checkDatabaseConnection')) {
    /**
     * Check connection to DB
     * @return boolean
     * @author TrinhLe
     */
    function checkDatabaseConnection()
    {
        try {
            DB::connection()->reconnect();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}