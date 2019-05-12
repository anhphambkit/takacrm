<?php

namespace Core\Theme\Composers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use AssetPipeline;

class AssetsViewComposer
{
    /**
     * Register pipeline view admin
     * @param View $view 
     * @author TrinhLe
     * @return type
     */
    public function compose(View $view)
    {
        list($cssFiles,$jsFiles) = $this->bindAssets();
        $view->with('cssFiles',$cssFiles);
        $view->with('jsFiles', $jsFiles);
    }

    /**
     * Bind list assets
     * @author TrinhLe
     */
    protected function bindAssets()
    {
        return [AssetPipeline::allCss(),AssetPipeline::allJs()];
    }    
}
