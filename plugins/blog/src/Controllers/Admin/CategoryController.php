<?php

namespace Plugins\Blog\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Core\Base\Responses\BaseHttpResponse;
use Plugins\Blog\Models\Post;
use Plugins\Blog\Repositories\Interfaces\PostRepositories as PostInterface;
use Plugins\Blog\Repositories\Interfaces\CategoryRepositories as CategoryInterface;
use Plugins\Blog\Repositories\Interfaces\TagRepositories as TagInterface;
use Plugins\Blog\Services\StoreCategoryService;
use Plugins\Blog\Services\StoreTagService;
use Exception;
use Illuminate\Http\Request;
use Auth;
use Core\Base\Events\CreatedContentEvent;
use Core\Base\Events\DeletedContentEvent;
use Core\Base\Events\UpdatedContentEvent;
use Plugins\Blog\DataTables\CategoryDataTable;
use Plugins\Blog\Requests\CategoryRequest;
use AssetManager;
use AssetPipeline;

class CategoryController extends BaseAdminController
{

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * @param CategoryInterface $categoryRepository
     * @author TrinhLe
     */
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param PostTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     * @throws \Throwable
     */
    public function getList(CategoryDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-blog::categories.menu'));

        return $dataTable->renderTable(['title' => trans('plugins-blog::categories.menu')]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-blog::categories.create'));

        $list = get_categories();

        $categories = [];
        foreach ($list as $row) {
            $categories[$row->id] = $row->indent_text . ' ' . $row->name;
        }
        $categories = [0 => trans('plugins-blog::categories.none')] + $categories;

        return view('plugins-blog::category.create', compact('categories'));
    }

    /**
     * @param CategoryRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function postCreate(
        CategoryRequest $request,
        BaseHttpResponse $response
    ) {

        $category = $this->categoryRepository->createOrUpdate(array_merge($request->input(), [
            'author_id'   => Auth::user()->getKey(),
            'is_featured' => filter_var($request->input('is_featured', false), FILTER_VALIDATE_BOOLEAN),
            'is_default'  => filter_var($request->input('is_default', false), FILTER_VALIDATE_BOOLEAN),
        ]));

        event(new CreatedContentEvent(BLOG_CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('admin.blog.category.list'))
            ->setNextUrl(route('admin.blog.category.edit', $category->id))
            ->setMessage(trans('core-base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     * @author TrinhLe
     */
    public function getEdit($id, Request $request)
    {
        $category = $this->categoryRepository->findOrFail($id);

        page_title()->setTitle(trans('plugins-blog::categories.edit') . ' #' . $id);

        $list = get_categories();

        $categories = [];
        foreach ($list as $row) {
            $categories[$row->id] = $row->indent_text . ' ' . $row->name;
        }
        $categories = [0 => trans('plugins-blog::categories.none')] + $categories;

        return view('plugins-blog::category.edit', compact('categories', 'category'));
    }

    /**
     * @param int $id
     * @param CategoryRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function postEdit(
        $id,
        CategoryRequest $request,
        BaseHttpResponse $response
    ) {
        $category = $this->categoryRepository->findOrFail($id);

        $category->fill($request->input());
        $category->is_featured = filter_var($request->input('is_featured', false), FILTER_VALIDATE_BOOLEAN);
        $category->is_default = filter_var($request->input('is_default', false), FILTER_VALIDATE_BOOLEAN);

        $this->categoryRepository->createOrUpdate($category);

        event(new UpdatedContentEvent(BLOG_CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('admin.blog.category.list'))
            ->setMessage(trans('core-base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function getDelete(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $category = $this->categoryRepository->findOrFail($id);

            if (!$category->is_default) {
                $this->categoryRepository->delete($category);
                event(new DeletedContentEvent(BLOG_CATEGORY_MODULE_SCREEN_NAME, $request, $category));
                return $response->setMessage(trans('core-base::notices.delete_success_message'));
            }

            return $response->setError()
                            ->setMessage(trans('Category is default'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage(trans('core-base::notices.cannot_delete'));
        }
    }
}
