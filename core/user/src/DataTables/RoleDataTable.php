<?php

namespace Core\User\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\UserInterface;

class RoleDataTable extends DataTableAbstract
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
            ->editColumn('name', function ($item) {
                return $item->name;
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('created_by', function ($item) {
                /**
                 * @var User $user
                 */
                if($user = $item->userCreated)
                    return $user->getFullName();
                return null;
            });

        return $data->addColumn('operations', function ($item) {
                return table_actions('admin.role.edit', 'admin.role.delete', $item);
            })
            ->escapeColumns([])
            ->make(true);

        
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @author TrinhLe
     */
    public function query()
    {
        $model = app(RoleInterface::class)->getModel();
        /**
         * @var \Eloquent $model
         */
        $query = $model->select(['roles.id', 'roles.name', 'roles.description', 'roles.created_at', 'roles.created_by']);
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
                'name' => 'roles.id',
                'title' => __('ID'),
                'width' => '20px',
                'searchable' => false,
                'class' => 'text-center',
                'footer' => __('ID')
            ],
            'name' => [
                'name' => 'roles.name',
                'title' => __('Role Name'),
                'footer' => __('Role Name'),
                'class' => 'searchable',
            ],
            'description' => [
                'name' => 'roles.description',
                'title' => __('Description'),
                'footer' => __('Description'),
                'class' => 'searchable',
            ],
            'created_at' => [
                'name' => 'roles.created_at',
                'title' => __('CreatedAt'),
                'footer' => __('CreatedAt'),
                'width' => '100px',
                'searchable' => false,
                'class' => 'searchable',
            ],
            'created_by' => [
                'name' => 'roles.created_by',
                'title' => __('CreatedBy'),
                'footer' => __('CreatedBy'),
                'searchable' => false,
                'width' => '100px',
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
                'link' => route('admin.role.create'),
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
        return ROLE_MODULE_SCREEN_NAME;
    }
}
