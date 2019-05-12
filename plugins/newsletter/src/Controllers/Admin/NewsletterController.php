<?php

namespace Plugins\Newsletter\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Newsletter\Requests\NewsletterRequest;
use Plugins\Newsletter\Requests\UpdateLetterRequest;
use Plugins\Newsletter\Repositories\Interfaces\NewsletterRepositories;
use Plugins\Newsletter\DataTables\NewsletterDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class NewsletterController extends BaseAdminController
{
    /**
     * @var NewsletterRepositories
     */
    protected $newsletterRepository;

    /**
     * NewsletterController constructor.
     * @param NewsletterRepositories $newsletterRepository
     * @author TrinhLe
     */
    public function __construct(NewsletterRepositories $newsletterRepository)
    {
        $this->newsletterRepository = $newsletterRepository;
    }

    /**
     * Display all newsletter
     * @param NewsletterDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(NewsletterDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-newsletter::newsletter.list'));

        return $dataTable->renderTable(['title' => trans('plugins-newsletter::newsletter.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-newsletter::newsletter.create'));

        return view('plugins-newsletter::create');
    }

    /**
     * Insert new Newsletter into database
     *
     * @param NewsletterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(NewsletterRequest $request)
    {
        $newsletter = $this->newsletterRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, NEWSLETTER_MODULE_SCREEN_NAME, $request, $newsletter);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.newsletter.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.newsletter.edit', $newsletter->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $newsletter = $this->newsletterRepository->findById($id);
        if (empty($newsletter)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-newsletter::newsletter.edit') . ' #' . $id);

        return view('plugins-newsletter::edit', compact('newsletter'));
    }

    /**
     * @param $id
     * @param NewsletterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, UpdateLetterRequest $request)
    {
        $newsletter = $this->newsletterRepository->findById($id);
        if (empty($newsletter)) {
            abort(404);
        }
        $newsletter->fill($request->input());

        $this->newsletterRepository->createOrUpdate($newsletter);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, NEWSLETTER_MODULE_SCREEN_NAME, $request, $newsletter);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.newsletter.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.newsletter.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $newsletter = $this->newsletterRepository->findById($id);
            if (empty($newsletter)) {
                abort(404);
            }
            $this->newsletterRepository->delete($newsletter);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, NEWSLETTER_MODULE_SCREEN_NAME, $request, $newsletter);

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
