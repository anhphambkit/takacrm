<?php

namespace Plugins\History\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\History\Requests\HistoryRequest;
use Plugins\History\Repositories\Interfaces\HistoryRepositories;
use Plugins\History\DataTables\HistoryDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class HistoryController extends BaseAdminController
{
    /**
     * @var HistoryRepositories
     */
    protected $historyRepository;

    /**
     * HistoryController constructor.
     * @param HistoryRepositories $historyRepository
     * @author TrinhLe
     */
    public function __construct(HistoryRepositories $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    /**
     * Display all history
     * @param HistoryDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(HistoryDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-history::history.list'));

        return $dataTable->renderTable(['title' => trans('plugins-history::history.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-history::history.create'));

        return view('plugins-history::create');
    }

    /**
     * Insert new History into database
     *
     * @param HistoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(HistoryRequest $request)
    {
        $history = $this->historyRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, HISTORY_MODULE_SCREEN_NAME, $request, $history);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.history.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.history.edit', $history->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getEdit($id)
    {
        $history = $this->historyRepository->findById($id);
        if (empty($history)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-history::history.edit') . ' #' . $id);

        return view('plugins-history::edit', compact('history'));
    }

    /**
     * @param $id
     * @param HistoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, HistoryRequest $request)
    {
        $history = $this->historyRepository->findById($id);
        if (empty($history)) {
            abort(404);
        }
        $history->fill($request->input());

        $this->historyRepository->createOrUpdate($history);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, HISTORY_MODULE_SCREEN_NAME, $request, $history);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.history.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.history.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author TrinhLe
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $history = $this->historyRepository->findById($id);
            if (empty($history)) {
                abort(404);
            }
            $this->historyRepository->delete($history);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, HISTORY_MODULE_SCREEN_NAME, $request, $history);

            return [
                'error' => false,
                'message' => trans('core-base::notices.deleted'),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => trans('core-base::notices.cannot_delete'),
            ];
        }
    }
}
