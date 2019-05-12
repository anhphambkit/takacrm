<?php

namespace Plugins\Faq\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Faq\Requests\FaqRequest;
use Plugins\Faq\Repositories\Interfaces\FaqRepositories;
use Plugins\Faq\DataTables\FaqDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class FaqController extends BaseAdminController
{
    /**
     * @var FaqRepositories
     */
    protected $faqRepository;

    /**
     * FaqController constructor.
     * @param FaqRepositories $faqRepository
     * @author TrinhLe
     */
    public function __construct(FaqRepositories $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * Display all faq
     * @param FaqDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(FaqDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-faq::faq.list'));

        return $dataTable->renderTable(['title' => trans('plugins-faq::faq.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-faq::faq.create'));

        return view('plugins-faq::create');
    }

    /**
     * Insert new Faq into database
     *
     * @param FaqRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(FaqRequest $request)
    {
        $faq = $this->faqRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, FAQ_MODULE_SCREEN_NAME, $request, $faq);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.faq.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.faq.edit', $faq->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $faq = $this->faqRepository->findById($id);
        if (empty($faq)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-faq::faq.edit') . ' #' . $id);

        return view('plugins-faq::edit', compact('faq'));
    }

    /**
     * @param $id
     * @param FaqRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, FaqRequest $request)
    {
        $faq = $this->faqRepository->findById($id);
        if (empty($faq)) {
            abort(404);
        }
        $faq->fill($request->input());

        $this->faqRepository->createOrUpdate($faq);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, FAQ_MODULE_SCREEN_NAME, $request, $faq);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.faq.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.faq.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
        $faq = $this->faqRepository->findById($id);
        if (empty($faq)) {
            abort(404);
        }
        $this->faqRepository->delete($faq);

        do_action(BASE_ACTION_AFTER_DELETE_CONTENT, FAQ_MODULE_SCREEN_NAME, $request, $faq);

        return [
            'error' => false,
            'message' => trans('core-base::notices.deleted'),
        ];
        
        try {
            $faq = $this->faqRepository->findById($id);
            if (empty($faq)) {
                abort(404);
            }
            $this->faqRepository->delete($faq);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, FAQ_MODULE_SCREEN_NAME, $request, $faq);

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
