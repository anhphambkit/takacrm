<?php

namespace Core\User\DataTables;

use Core\User\Repositories\Interfaces\UserInterface;
use Core\Base\DataTables\DataTableAbstract;
use AclManager;

class UserDataTable extends DataTableAbstract
{

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function ajax()
    {
        $data = $this->datatables
            ->eloquent($this->query())
            ->editColumn('checkbox', function ($item) {
                return $item->id;
            })
            ->editColumn('username', function ($item) {
                return $item->username;
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('role_name', function ($item) {
                return view('core-user::users.partials.role', compact('item'))->render();
            })
            ->editColumn('status', function ($item) {
                return table_status(AclManager::getActivationRepository()->completed($item) ? 1 : 0);
            })
            ->addColumn('operations', function ($item) {
                if (auth()->user()->id !== $item->id) {
                    return table_actions('admin.user.profile', 'admin.user.delete', $item);
                }
            })
            ->removeColumn('role_id')
            ->escapeColumns([])
            ->make(true);
        
        return $data;
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @author TrinhLe
     */
    public function query()
    {
        $model = app(UserInterface::class)->getModel();
        /**
         * @var \Eloquent $model
         */
        $query = $model
            ->select([
                'users.id',
                'users.username',
                'users.email',
                'roles.name as role_name',
                'roles.id as role_id',
                'users.updated_at',
                'users.created_at',
            ])
            ->leftJoin('role_users', 'users.id', '=', 'role_users.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_users.role_id')
            ->where('users.super_user', false);
        return $query;
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function columns()
    {
        return [
            'id' => [
                'name' => 'users.id',
                'title' => __('ID'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
                'footer' => __('ID')
            ],
            'username' => [
                'name' => 'users.username',
                'title' => __('Username'),
                'class' => 'text-left searchable',
                'footer' => __('Username')
            ],
            'email' => [
                'name' => 'users.email',
                'title' => __('Email'),
                'class' => 'searchable',
                'footer' => __('Email')
            ],
            'role_name' => [
                'name' => 'roles.name',
                'title' => __('Role'),
                'footer' => __('Role')
            ],
            'created_at' => [
                'name'  => 'users.created_at',
                'title' => __('CreatedAt'),
                'width' => '100px',
                'class' => 'searchable',
                'footer' => __('CreatedAt')
            ],
            'status' => [
                'name'       => 'users.status',
                'title'      => __('Status'),
                'width'      => '100px',
                'orderable'  => false,
                'searchable' => false,
                'exportable' => false,
                'printable'  => false,
                'footer' => __('Status')
            ],
        ];
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function buttons()
    {
        $buttons = [
            'create' => [
                'link' => route('admin.user.create'),
                'text' => view('core-base::elements.tables.actions.create')->render(),
            ]
        ];

        return $buttons;
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function actions()
    {
        return [
            'delete' => [
                'link' => route('admin.user.create'),
                'text' => view('core-base::elements.tables.actions.delete')->render(),
            ],
            'activate' => [
                'link' => route('admin.user.create'),
                'text' => view('core-base::elements.tables.actions.activate')->render(),
            ],
            'deactivate' => [
                'link' => route('admin.user.create'),
                'text' => view('core-base::elements.tables.actions.deactivate')->render(),
            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     * @author TrinhLe
     */
    protected function filename()
    {
        return USER_MODULE_SCREEN_NAME;
    }
}
