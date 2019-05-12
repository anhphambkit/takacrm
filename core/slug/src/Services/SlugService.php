<?php

namespace Core\Slug\Services;

use Core\Slug\Repositories\Interfaces\SlugRepositories as SlugInterface;
use Illuminate\Support\Str;

/**
 * Class SlugService
 *
 * @package Core\Slug\Services
 */
class SlugService
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * SlugService constructor.
     * @param SlugInterface $slugRepository
     * @author TrinhLe
     */
    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    /**
     * @param $name
     * @param int $slug_id
     * @return int|string
     * @author TrinhLe
     */
    public function create($name, $slug_id = 0, $screen = null)
    {
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->checkIfExistedSlug($slug, $slug_id, $screen)) {
            $slug = $baseSlug . '-' . $index++;
        }

        if (empty($slug)) {
            $slug = time();
        }

        return $slug;
    }

    /**
     * @param $slug
     * @param $slug_id
     * @param $screen
     * @return bool
     * @author TrinhLe
     */
    protected function checkIfExistedSlug($slug, $slug_id, $screen)
    {
        $prefix = null;
        if (!empty($screen)) {
            $prefix = config('core-slug.general.prefixes.' . $screen, '');
        }
        $count = $this->slugRepository
            ->getModel()
            ->where([
                'key'    => $slug,
                'prefix' => $prefix,
            ])
            ->where('id', '!=', $slug_id)
            ->count();

        return $count > 0;
    }
}
