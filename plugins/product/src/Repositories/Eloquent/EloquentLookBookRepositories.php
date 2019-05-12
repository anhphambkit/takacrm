<?php
/**
 * LookBook repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentLookBookRepositories extends RepositoriesAbstract implements LookBookRepositories {
    /**
     * @param string $type
     * @param bool $isMain
     * @param int $take
     * @param array $businessTypes
     * @param array $spaces
     * @param array $exceptBusinessType
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false, int $take = 0, array $businessTypes = [], array $spaces = [], array $exceptBusinessType = []) {
        $query = $this->model
                    ->select('look_books.*')
                    ->leftJoin('look_book_business_type_space_relation', 'look_book_business_type_space_relation.look_book_id', '=', 'look_books.id')
                    ->where('look_books.type_layout', $type)
                    ->where('look_books.is_main', $isMain)
                    ->with('lookBookTags', 'lookBookSpacesBelong', 'lookBookBusiness')
                    ->orderBy('look_books.created_at', 'desc');

        if (!empty($spaces))
            $query = $query->whereIn('look_book_business_type_space_relation.space_id', $spaces);

        if (!empty($businessTypes))
            $query = $query->whereIn('look_book_business_type_space_relation.business_type_id', $businessTypes);

        if (!empty($exceptBusinessType))
            $query = $query->whereNotIn('look_book_business_type_space_relation.business_type_id', $exceptBusinessType);

        if ($take)
            $query = $query->take($take);
        return $query->distinct()->get();
    }
}