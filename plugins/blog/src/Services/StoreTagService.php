<?php

namespace Plugins\Blog\Services;

use Core\Base\Events\CreatedContentEvent;
use Plugins\Blog\Models\Post;
use Illuminate\Http\Request;
use Auth;
use Plugins\Blog\Repositories\Interfaces\TagRepositories as TagInterface;

class StoreTagService
{
    /**
     * @var TagInterface
     */
    protected $tagRepository;

    /**
     * StoreTagService constructor.
     * @param TagInterface $tagRepository
     * @author TrinhLe
     */
    public function __construct(TagInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param Request $request
     * @param Post $post
     * @author TrinhLe
     * @return mixed|void
     */
    public function execute(Request $request, Post $post)
    {
        $tags = $post->tags->pluck('name')->all();

        if (implode(',', $tags) !== $request->input('tag')) {
            $post->tags()->detach();
            $tagInputs = explode(',', $request->input('tag'));
            foreach ($tagInputs as $tagName) {

                if (!trim($tagName)) {
                    continue;
                }

                $tag = $this->tagRepository->getFirstBy(['name' => $tagName]);

                if ($tag === null && !empty($tagName)) {
                    $tag = $this->tagRepository->createOrUpdate([
                        'name'      => $tagName,
                        'author_id' => Auth::user()->getKey(),
                    ]);

                    $request->merge(['slug' => $tagName]);

                    event(new CreatedContentEvent(BLOG_TAG_MODULE_SCREEN_NAME, $request, $tag));
                }

                if (!empty($tag)) {
                    $post->tags()->attach($tag->id);
                }
            }
        }
    }
}
