<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-10
 * Time: 18:04
 */

namespace Plugins\Product\Services\Implement;

use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Services\BusinessTypeServices;

class ImplementBusinessTypeServices implements BusinessTypeServices {

    private $repository;

    /**
     * ImplementBusinessTypeServices constructor.
     * @param BusinessTypeRepositories $businessTypeRepositories
     */
    public function __construct(BusinessTypeRepositories $businessTypeRepositories)
    {
        $this->repository = $businessTypeRepositories;
    }

    /**
     * @return mixed
     */
    public function getAllBusinessTypeGroupByParent() {
        return $this->repository->getAllBusinessTypeGroupByParent();
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function getBusinessTypeBySlug(string $slug) {
        return $this->repository->bySlug($slug);
    }

    /**
     * @param string $slug
     * @return array|mixed
     */
    public function getAllSpacesByBusinessTypeBySlug(string $slug) {
        $businessType = $this->repository->bySlug($slug);
        if ($businessType->spaces) {
            $allRoom = new \stdClass();
            $allRoom->id = 0;
            $allRoom->text = 'All Rooms';
            $allRoom->slug = 'all_rooms';

            $businessType->spaces->prepend($allRoom);
            return $businessType->spaces;
        }
        return [];
    }
}