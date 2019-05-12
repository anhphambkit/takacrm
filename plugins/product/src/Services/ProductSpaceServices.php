<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-11
 * Time: 13:46
 */

namespace Plugins\Product\Services;

interface ProductSpaceServices {

    /**
     * @param string $slug
     * @return mixed
     */
    public function getSpaceBySlug(string $slug);
}