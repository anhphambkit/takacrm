<?php

use Core\Theme\Facades\ThemeOptionFacade;
use Core\Theme\Facades\AssetManagerFacade;
use Core\Theme\Facades\AssetPipelineFacade;
use Core\Theme\Facades\AssetTypeFactoryFacade;

if (!function_exists('theme_option')) {
    /**
     * @return mixed
     * @author TrinhLe
     */
    function theme_option($key = null, $default = null) {

        if (!empty($key)) {
            return ThemeOption::getOption($key, $default);
        }
        return ThemeOptionFacade::getFacadeRoot();
    }
}

if (!function_exists('asset_manager')) {
    /**
     * @return mixed
     * @author TrinhLe
     */
    function asset_manager() {
        
        return AssetManagerFacade::getFacadeRoot();
    }
}

if (!function_exists('asset_pipeline')) {
    /**
     * @return mixed
     * @author TrinhLe
     */
    function asset_pipeline() {

        return AssetPipelineFacade::getFacadeRoot();
    }
}

if (!function_exists('asset_type_factory')) {
    /**
     * @return mixed
     * @author TrinhLe
     */
    function asset_type_factory() {

        return AssetTypeFactoryFacade::getFacadeRoot();
    }
}

