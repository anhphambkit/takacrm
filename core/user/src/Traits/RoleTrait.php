<?php

namespace Core\User\Traits;
use Illuminate\Support\Arr;

trait RoleTrait
{
	/**
     * @param int $parentId
     * @param array $allFlags
     * @return mixed
     * @author TrinhLe
     */
    protected function getChildren($parentId, $allFlags)
    {
        $newFlagArray = [];
        foreach ($allFlags as $flagDetails) {
            if (Arr::get($flagDetails, 'parent_flag', 'root') == $parentId) {
                $newFlagArray[] = $flagDetails['flag'];
            }
        }
        return $newFlagArray;
    }

    /**
     * @return array
     * @author TrinhLe
     */
    protected function getFlagsPermission(): array
    {
    	$allPackages = loadPackages('', true);
    	$flags = array();

    	foreach ($allPackages as $package => $path) {
    		$configuration = config("{$package}.permissions");
    		if($configuration && is_array($configuration)){
    			foreach ($configuration as $key => $config) {
    				$flags[$config['flag']] = $config;
    			}
    		}
    	}

    	$children = $this->getPermissionTree($flags);

        return [ $flags, $children ];
    }

    /**
     * @param array $permissions
     * @return array
     * @author TrinhLe
     */
    protected function getPermissionTree($permissions): array
    {
        $sortedFlag = $permissions;
        sort($sortedFlag);
        $children['root'] = $this->getChildren('root', $sortedFlag);

        foreach (array_keys($permissions) as $key) {
            $childrenReturned = $this->getChildren($key, $permissions);
            if (count($childrenReturned) > 0) {
                $children[$key] = $childrenReturned;
            }
        }

        return $children;
    }
}