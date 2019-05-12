<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-10
 * Time: 18:04
 */

namespace Plugins\Product\Services;

interface BusinessTypeServices {
    /**
     * @return mixed
     */
    public function getAllBusinessTypeGroupByParent();

    /**
     * @param string $slug
     * @return mixed
     */
    public function getBusinessTypeBySlug(string $slug);

    /**
     * @param string $slug
     * @return mixed
     */
    public function getAllSpacesByBusinessTypeBySlug(string $slug);
}