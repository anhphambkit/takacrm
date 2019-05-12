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
use Plugins\Blog\DataTables\PostDataTable;
use Plugins\Blog\Requests\PostRequest;

class PostController extends BaseAdminController
{

    /**
     * @var PostInterface
     */
    protected $postRepository;

    /**
     * @var TagInterface
     */
    protected $tagRepository;

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * @param PostInterface $postRepository
     * @param TagInterface $tagRepository
     * @param CategoryInterface $categoryRepository
     * @author TrinhLe
     */
    public function __construct(
        PostInterface $postRepository,
        TagInterface $tagRepository,
        CategoryInterface $categoryRepository
    ) {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param PostTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     * @throws \Throwable
     */
    public function getList(PostDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-blog::posts.menu_name'));

        return $dataTable->renderTable(['title' => trans('plugins-blog::posts.models')]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-blog::posts.create'));

        $categories = get_categories_with_children();

        return view('plugins-blog::post.create', compact('categories'));
    }

    /**
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function postCreate(
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        /**
         * @var Post $post
         */
        $post = $this->postRepository->createOrUpdate(array_merge($request->input(), [
            'author_id'   => Auth::user()->getKey(),
            'is_featured' => $request->input('is_featured', false),
        ]));

        event(new CreatedContentEvent(BLOG_POST_MODULE_SCREEN_NAME, $request, $post));

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('admin.blog.post.list'))
            ->setNextUrl(route('admin.blog.post.edit', $post->id))
            ->setMessage(trans('core-base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return Illuminate\View\View
     * @author TrinhLe
     */
    public function getEdit($id, Request $request)
    {
        $post = $this->postRepository->findOrFail($id);

        page_title()->setTitle(trans('plugins-blog::posts.edit') . ' #' . $id);

        $selected_categories = [];
        if ($post->categories != null) {
            $selected_categories = $post->categories->pluck('id')->all();
        }

        $tags       = $post->tags->pluck('name')->all();
        $tags       = implode(',', $tags);
        $categories = get_categories_with_children();
        
        return view('plugins-blog::post.edit', compact('post', 'selected_categories', 'categories', 'tags'));
    }

    /**
     * @param int $id
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function postEdit(
        $id,
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        $post = $this->postRepository->findOrFail($id);

        $post->fill($request->input());
        $post->is_featured = $request->input('is_featured', false);

        $this->postRepository->createOrUpdate($post);

        event(new UpdatedContentEvent(BLOG_POST_MODULE_SCREEN_NAME, $request, $post));

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('admin.blog.post.list'))
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
            $post = $this->postRepository->findOrFail($id);
            $this->postRepository->delete($post);

            event(new DeletedContentEvent(BLOG_POST_MODULE_SCREEN_NAME, $request, $post));

            return $response
                ->setMessage(trans('core-base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('core-base::notices.cannot_delete'));
        }
    }
}
