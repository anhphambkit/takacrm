<?php
namespace Core\Dashboard\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Core\User\Models\User;
use Illuminate\Validation\ValidationException;
use Plugins\Tenancy\Models\Hostname;
use Plugins\Tenancy\Repositories\HostnameRepository;

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
//        $model = app(HostnameRepository::class);
//        /**
//         * @var \Eloquent $model
//         */
//        $query = $model->getAll([
//            'hostnames.id',
//            'hostnames.fqdn',
//            'hostnames.force_https',
//            'hostnames.under_maintenance_since',
//            'hostnames.redirect_to',
//            'hostnames.created_at'
//        ], [
//            'website'
//        ]);
//        dd($query);
//
////        dd(User::all());
        return view('core-dashboard::admin.index');
    }
}