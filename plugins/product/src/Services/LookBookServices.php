<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-10
 * Time: 21:29
 */

namespace Plugins\Product\Services;

interface LookBookServices {
    /**
     * @param string $type
     * @param bool $isMain
     * @param int $take
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false, int $take = 0);

    /**
     * @param int $numberBlock
     * @param array $businessTypes
     * @param array $spaces
     * @param array $exceptBusinessType
     * @param bool $hasFirstMainBlock
     * @return array|mixed
     */
    public function getBlockRenderLookBook(int $numberBlock = 0, array $businessTypes = [], array $spaces = [], array $exceptBusinessType = [], bool $hasFirstMainBlock = true);

    /**
     * @param int $lookBookId
     * @return mixed
     */
    public function getDetailLookBook(int $lookBookId);
}