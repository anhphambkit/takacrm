<?php
namespace Core\Dashboard\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;

class DashboardController extends BaseAdminController{
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show page dashboard admin
     * @return type
     */
    public function index()
    {
        return view('core-dashboard::admin.index');
    }
}