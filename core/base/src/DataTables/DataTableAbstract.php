<?php
namespace Core\Base\DataTables;

use Yajra\DataTables\Services\DataTable as YajraTable;
use Yajra\Datatables\Datatables as YajraTables;
use Illuminate\Contracts\View\Factory;

abstract class DataTableAbstract extends YajraTable 
{

    /**
     * DataTable constructor.
     *
     * @param \Yajra\Datatables\Datatables $datatables
     * @param \Illuminate\Contracts\View\Factory $viewFactory
     */
    public function __construct(YajraTables $datatables, Factory $viewFactory)
    {
        $this->datatables  = $datatables;
        $this->viewFactory = $viewFactory;
    }

	/**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     * @author TrinhLe
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters([
                'dom' => $this->getDomParameter(),
                'paging' => true,
                'searching' => true,
                'info' => true,
                'searchDelay' => 350,
                'bStateSave' => true,
                'lengthMenu' => [
                    [10, 30, 50, -1],
                    [10, 30, 50, __('All')]
                ],
                'pageLength' => 10,
                'processing' => true,
                'serverSide' => true,
                'bServerSide' => true,
                'bDeferRender' => true,
                'bProcessing' => true,
                'buttons' => $this->getBuilderParameters(),
                'initComplete' => $this->htmlInitComplete(),
                'drawCallback' => $this->htmlDrawCallback(),
            ]);
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function htmlInitComplete()
    {
        return 'function () {
                $(".dataTables_wrapper").css({"width": $(".dataTable").width()});
                var index = 0;
                var totalLength = this.api().columns().count();
                var tr = document.createElement("tr");
                $(tr).prop("role", "row").addClass("dataTable-custom-filter").css({"display": "none"});
                this.api().columns().every(function () {
                    var column = this;
                
                    index++;
                    $(document.createElement("th")).appendTo($(tr)).addClass("text-center");
                    if (index == totalLength) {
                        var searchBtn = document.createElement("a");
                        $(searchBtn).addClass("btn btn-info btn-sm btn-search-table tip").attr("data-original-title", "Search").appendTo($(tr).find("th:nth-child(" + index + ")")).html("<i class=\'fa fa-search\'></i>").css("margin-right","5px");
                        var clearBtn = document.createElement("a");
                        $(clearBtn).addClass("btn btn-warning btn-sm btn-reset-table tip").attr("data-original-title", "Clear search").appendTo($(tr).find("th:nth-child(" + index + ")")).html("<i class=\'fa fa-times\'></i>");
                    } else if ($(column.footer()).hasClass("searchable")) {
                
                        var input = document.createElement("input");
                        $(input).addClass("form-control input-sm");
                
                        var placeholder = "Search...";
                        if ($(column.footer()).hasClass("searchable_id")) {
                            placeholder = "...";
                        }
                        $(input).prop("type", "text").css("width", "100%").prop("placeholder", placeholder).appendTo($(tr).find("th:nth-child(" + index + ")"))
                            .on("change", function () {
                                column.search($(this).val()).draw();
                            });
                    } else if ($(column.footer()).hasClass("column-select-search")) {
                        var select = $(\'<select class="form-control input-sm" data-placeholder="Select to filter"><option value="">Select to filter</option></select>\')
                            .appendTo($(tr).find("th:nth-child(" + index + ")"))
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                
                                column.search(val ? "^" + val + "$" : "", true, false).draw();
                            });
                
                        column.data().unique().sort().each(function (d, j) {
                            var value = $(d).data("value");
                            var text = $(d).data("text");
                            if (column.search() === "^" + value + "$") {
                                select.append(\'<option value="\' + value + \'" selected="selected">\' + text + \'</option>\')
                            } else {
                                select.append(\'<option value="\' + value + \'">\' + text + \'</option>\')
                            }
                        });
                    }
                });
                $(tr).appendTo($("#dataTableBuilder thead"));
                
                if (jQuery().select2) {
                    $(document).find(\'.select-multiple\').select2({
                        width: \'100%\',
                        allowClear: true,
                        placeholder: $(this).data(\'placeholder\')
                    });
                    $(document).find(\'.select-search-full\').select2({
                        width: \'100%\'
                    });
                    $(document).find(\'.select-full\').select2({
                        width: \'100%\',
                        minimumResultsForSearch: -1
                    });
                }
            }';
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function htmlDrawCallback()
    {
        return 'function () {
                var pagination = $(this).closest(\'.dataTables_wrapper\').find(\'.dataTables_paginate\');
                pagination.toggle(this.api().page.info().pages > 1);
                
                var data_count = this.api().data().count();
                
                var length_select = $(this).closest(\'.dataTables_wrapper\').find(\'.dataTables_length\');
                var length_info = $(this).closest(\'.dataTables_wrapper\').find(\'.dataTables_info\');
                length_select.toggle(data_count >= 10);
                length_info.toggle(data_count > 0);
                
                if (data_count > 0) {
                    $(".page-content .dataTables_wrapper").css("padding-bottom", "40px");
                }
                    
                $(document).on("click", ".btn-search-table", function () {
                    $("#dataTableBuilder tfoot tr input").trigger("change");
                });
                
                if (jQuery().select2) {
                    $(document).find(\'.select-multiple\').select2({
                        width: \'100%\',
                        allowClear: true,
                        placeholder: $(this).data(\'placeholder\')
                    });
                    $(document).find(\'.select-search-full\').select2({
                        width: \'100%\'
                    });
                    $(document).find(\'.select-full\').select2({
                        width: \'100%\',
                        minimumResultsForSearch: -1
                    });
                }
            }';
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function getBuilderParameters()
    {
        $buttons = array_merge($this->getButtons(), $this->getActionsButton());
        return [
            'stateSave' => true,
            'buttons' => array_merge($buttons, $this->getDefaultButtons()),
        ];
    }

    /**
     * [getDomParameter description]
     * @return [type] [description]
     */
    public function getDomParameter() {
        return !empty($this->domParameter()) ? $this->domParameter() : $this->getDefaultDomParameter();
    }

    /**
     * [getDefaultDomParameter description]
     * @return [type] [description]
     */
    public function getDefaultDomParameter() {
        return "Brt<'datatables__info_wrap'pli<'clearfix'>>";
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function getActionsButton()
    {
        return [];
        // return [
        //     [
        //         'extend' => 'collection',
        //         'text' => '<span>' . __('Actions') . ' <span class="caret"></span></span>',
        //         'buttons' => $this->getActions(),
        //     ],
        // ];
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function getDefaultButtons()
    {
        return [
             'export',
            // 'print',
            [
                'link' => '#',
                'text' => view('core-base::elements.tables.filter')->render(),
            ],
            'reset',
            // 'reload',
        ];
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    abstract function columns();

    /**
     * @return mixed
     * @author TrinhLe
     */
    abstract function buttons();

    /**
     * @return mixed
     * @author TrinhLe
     */
    abstract function actions();

    /**
     * @return mixed
     */
    public function domParameter(){}

    /**
     * @return array
     * @author TrinhLe
     */
    public function getButtons()
    {
        $buttons = [];
        foreach ($this->buttons() as $key => $button) {
            if (array_get($button, 'extend') == 'collection') {
                $buttons[] = $button;
            } else {
                $buttons[] = [
                    'className' => 'action-item',
                    'text' => '<span data-action="' . $key . '" data-href="' . $button['link'] . '"> ' . $button['text'] . '</span>',
                ];
            }
        }
        
        return $buttons;
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function getActions()
    {
        $actions = [];
        foreach ($this->actions() as $key => $action) {
            $actions[] = [
                'className' => 'action-item',
                'text' => '<span data-action="' . $key . '" data-href="' . $action['link'] . '"> ' . $action['text'] . '</span>',
            ];
        }
        return $actions;
    }

    /**
     * Get columns.
     *
     * @return array
     * @author TrinhLe
     */
    public function getColumns()
    {
        $headings = array_merge($this->getStatusColumnHeading(), $this->columns());

        return array_merge($headings, $this->getOperationsHeading());
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function getOperationsHeading()
    {
        return [
            'operations' => [
                'title' => __('Operations'),
                'width' => '134px',
                'class' => 'text-center',
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
                'footer' => __('Operations')
            ]
        ];
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function getStatusColumnHeading()
    {
        return [];
    }

    /**
     * @param array $data
     * @param array $mergeData
     * @param string $view
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author TrinhLe
     */
    public function renderTable($data = [], $mergeData = [], $view = 'core-base::elements.table')
    {
        return parent::render($view, $data, $mergeData);
    }
}
