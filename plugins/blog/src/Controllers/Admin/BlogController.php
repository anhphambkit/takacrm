<?php

namespace Plugins\Blog\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Blog\Requests\BlogRequest;
use Plugins\Blog\Repositories\Interfaces\BlogRepositories;
use Plugins\Blog\DataTables\BlogDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;

class BlogController extends BaseAdminController
{
    /**
     * @var BlogRepositories
     */
    protected $blogRepository;

    /**
     * BlogController constructor.
     * @param BlogRepositories $blogRepository
     * @author TrinhLe
     */
    public function __construct(BlogRepositories $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display all blog
     * @param BlogDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(BlogDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-blog::blog.list'));

        return $dataTable->renderTable(['title' => trans('plugins-blog::blog.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-blog::blog.create'));

        return view('plugins-blog::create');
    }

    /**
     * Insert new Blog into database
     *
     * @param BlogRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(BlogRequest $request)
    {
        $blog = $this->blogRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, BLOG_MODULE_SCREEN_NAME, $request, $blog);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.blog.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.blog.edit', $blog->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $blog = $this->blogRepository->findById($id);
        if (empty($blog)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-blog::blog.edit') . ' #' . $id);

        return view('plugins-blog::edit', compact('blog'));
    }

    /**
     * @param $id
     * @param BlogRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, BlogRequest $request)
    {
        $blog = $this->blogRepository->findById($id);
        if (empty($blog)) {
            abort(404);
        }
        $blog->fill($request->input());

        $this->blogRepository->createOrUpdate($blog);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, BLOG_MODULE_SCREEN_NAME, $request, $blog);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.blog.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.blog.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $blog = $this->blogRepository->findById($id);
            if (empty($blog)) {
                abort(404);
            }
            $this->blogRepository->delete($blog);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, BLOG_MODULE_SCREEN_NAME, $request, $blog);

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
