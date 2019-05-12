<?php

namespace Core\Master\Supports;

use Breadcrumbs;
use URL;

class AdminBreadcrumb
{
    /**
     * @return string
     * @author TrinhLe
     */
    public function render()
    {
        return Breadcrumbs::render('pageTitle', page_title()->getTitle(false), URL::full());
    }
}