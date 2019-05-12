<?php

namespace Core\User\DataTables;

use Core\User\Repositories\Interfaces\UserInterface;
use Core\Base\DataTables\DataTableAbstract;

class SuperUserDataTable extends DataTableAbstract
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
            ->addColumn('operations', function ($item) {
                return table_actions('admin.user.profile', 'admin.user.delete', $item);
            })
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
        $query = $model->select(['users.id', 'users.username', 'users.email', 'users.last_login'])->where(['users.super_user' => 1]);
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
                'name'       => 'users.id',
                'title'      => __('ID'),
                'width'      => '20px',
                'class'      => 'searchable searchable_id',
                'footer'     => __('ID')
            ],
            'username' => [
                'name'   => 'users.username',
                'title'  => __('Username'),
                'class'  => 'text-left searchable',
                'footer' => __('Username')
            ],
            'email' => [
                'name'   => 'users.email',
                'title'  => __('Email'),
                'class'  => 'searchable',
                'footer' => __('Email')
            ],
            'last_login' => [
                'name'   => 'users.last_login',
                'title'  => __('Last Login'),
                'footer' => __('Last Login')
            ]
        ];
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function buttons()
    {
        $buttons = [
            'add-supper' => [
                'link' => '#',
                'text' => view('core-user::partials.add-super')->render(),
            ],
        ];
        return $buttons;
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function actions()
    {
        return [];
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
