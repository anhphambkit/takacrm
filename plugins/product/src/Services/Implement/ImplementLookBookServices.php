<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-10
 * Time: 21:29
 */

namespace Plugins\Product\Services\Implement;

use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;
use Plugins\Product\Services\LookBookServices;

class ImplementLookBookServices implements LookBookServices {

    private $repository;

    /**
     * ImplementLookBookServices constructor.
     * @param LookBookRepositories $lookBookRepositories
     */
    public function __construct(LookBookRepositories $lookBookRepositories)
    {
        $this->repository = $lookBookRepositories;
    }

    /**
     * @param string $type
     * @param bool $isMain
     * @param int $take
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false, int $take = 0) {
        return $this->repository->getAllLookBookByTypeLayout($type, $isMain, $take);
    }

    /**
     * @param int $numberBlock
     * @param array $businessTypes
     * @param array $spaces
     * @param array $exceptBusinessType
     * @param bool $hasFirstMainBlock
     * @return array|mixed
     */
    public function getBlockRenderLookBook(int $numberBlock = 0, array $businessTypes = [], array $spaces = [], array $exceptBusinessType = [], bool $hasFirstMainBlock = true) {
        $takeNormalLookBook = $numberBlock*6;
        $takeVerticalLookBook = $numberBlock*3;
        $takeMainLookBook = $numberBlock*1;
        $mainLookBooks = $this->repository->getAllLookBookByTypeLayout(ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT_NORMAL, true, $takeMainLookBook, $businessTypes, $spaces, $exceptBusinessType)->toArray();
        $normalLookBooks = $this->repository->getAllLookBookByTypeLayout(ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT_NORMAL, false, $takeNormalLookBook, $businessTypes, $spaces, $exceptBusinessType)->toArray();
        $verticalLookBooks = $this->repository->getAllLookBookByTypeLayout(ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT_VERTICAL, false, $takeVerticalLookBook, $businessTypes, $spaces, $exceptBusinessType)->toArray();
        $listFullPercents = config('plugins-product.product.percent_layout_look_book.full');
        $listWeights = config('plugins-product.product.weight_layout_look_book');
        $blocks = array();
        $firstBlock = array();

        if ($hasFirstMainBlock)
            $firstBlock = $this->renderFirstBlock($listWeights, $normalLookBooks, $verticalLookBooks, $mainLookBooks, 6);

        if (!empty($firstBlock))
            array_push($blocks, $firstBlock);

        while (sizeof($normalLookBooks) >= 2 || sizeof($verticalLookBooks) >= 1 || sizeof($mainLookBooks) >= 1) {
            if (sizeof($normalLookBooks) >= 2 && sizeof($verticalLookBooks) >= 1 && sizeof($mainLookBooks) >= 1) {
                $randomBlockKeys = $this->generateRandomByPercent($listFullPercents, 3);
                $renderBlock = $this->renderBlockWithWeight($randomBlockKeys, $listWeights, $normalLookBooks, $verticalLookBooks, $mainLookBooks, 6);
                if ($renderBlock['total_weight'] < 6) {
                    $differentWight = 6 - $renderBlock['total_weight'];
                    $this->loopAddLookBookWeight($differentWight, $normalLookBooks, $verticalLookBooks, $mainLookBooks, $renderBlock, $listWeights);
                }
                array_push($blocks, $renderBlock['block']);


            }
            else if (sizeof($verticalLookBooks) >= 1 && sizeof($mainLookBooks) >= 1) {
                $listVerticalMainPercents = config('plugins-product.product.percent_layout_look_book.vertical_main');
                $randomBlockKeys = $this->generateRandomByPercent($listVerticalMainPercents, 2);
                $renderBlock = $this->renderBlockWithWeight($randomBlockKeys, $listWeights, $normalLookBooks, $verticalLookBooks, $mainLookBooks, 6);
                if ($renderBlock['total_weight'] < 6) {
                    $differentWight = 6 - $renderBlock['total_weight'];
                    $this->loopAddLookBookWeight($differentWight, $normalLookBooks, $verticalLookBooks, $mainLookBooks, $renderBlock, $listWeights);
                }
                array_push($blocks, $renderBlock['block']);
            }
            else if (sizeof($normalLookBooks) >= 2 && sizeof($verticalLookBooks) >= 1) {
                $listVerticalNormalPercents = config('plugins-product.product.percent_layout_look_book.vertical_normal');
                $randomBlockKeys = $this->generateRandomByPercent($listVerticalNormalPercents, 3);
                $renderBlock = $this->renderBlockWithWeight($randomBlockKeys, $listWeights, $normalLookBooks, $verticalLookBooks, $mainLookBooks, 6);
                if ($renderBlock['total_weight'] < 6) {
                    $differentWight = 6 - $renderBlock['total_weight'];
                    $this->loopAddLookBookWeight($differentWight, $normalLookBooks, $verticalLookBooks, $mainLookBooks, $renderBlock, $listWeights);
                }
                array_push($blocks, $renderBlock['block']);


            }
            else if (sizeof($normalLookBooks) >= 2 && sizeof($mainLookBooks) >= 1) {
                $listNormalMainPercents = config('plugins-product.product.percent_layout_look_book.normal_main');
                $randomBlockKeys = $this->generateRandomByPercent($listNormalMainPercents, 2);
                $renderBlock = $this->renderBlockWithWeight($randomBlockKeys, $listWeights, $normalLookBooks, $verticalLookBooks, $mainLookBooks, 6);
                if ($renderBlock['total_weight'] < 6) {
                    $differentWight = 6 - $renderBlock['total_weight'];
                    $this->loopAddLookBookWeight($differentWight, $normalLookBooks, $verticalLookBooks, $mainLookBooks, $renderBlock, $listWeights);
                }
                array_push($blocks, $renderBlock['block']);


            }
            else if (sizeof($mainLookBooks) >= 1) {
                $mainSingleBlocks = $this->renderSingleBlock($mainLookBooks, $normalLookBooks, $listWeights['main'], $listWeights['normal'], 6);
                $blocks = array_merge($blocks, $mainSingleBlocks);

            }
            else if (sizeof($verticalLookBooks) >= 1) {
                $verticalSingleBlocks = $this->renderSingleBlock($verticalLookBooks, $normalLookBooks, $listWeights['vertical'], $listWeights['normal'], 6);
                $blocks = array_merge($blocks, $verticalSingleBlocks);

            }
            else if (sizeof($normalLookBooks) >= 2) {
                $normalSingleBlocks = $this->renderSingleBlock($normalLookBooks, $normalLookBooks, $listWeights['normal'], $listWeights['normal'], 6);
                $blocks = array_merge($blocks, $normalSingleBlocks);

            }
        }

        // render last block:
        $lastMainSingleBlocks = $this->renderSingleBlock($mainLookBooks, $normalLookBooks, $listWeights['main'], $listWeights['normal'], 6);
        $lastVerticalSingleBlocks = $this->renderSingleBlock($verticalLookBooks, $normalLookBooks, $listWeights['vertical'], $listWeights['normal'], 6);
        $lastNormalSingleBlocks = $this->renderSingleBlock($normalLookBooks,$normalLookBooks,  $listWeights['normal'], $listWeights['normal'], 6);

        $blocks = array_merge($blocks, $lastNormalSingleBlocks, $lastVerticalSingleBlocks, $lastMainSingleBlocks);

        if ($numberBlock && !empty($blocks)) {
            if (sizeof($blocks) >= 2) {
                array_pop($blocks);
            }
            $result = array();
            if ($numberBlock > 1) {
                $randomBlockKeys = array_rand($blocks, $numberBlock);
                foreach ($randomBlockKeys as $randomBlockKey) {
                    array_push($result, $blocks[$randomBlockKey]);
                }
            }
            else {
                $randomBlockKey = array_rand($blocks);
                array_push($result, $blocks[$randomBlockKey]);
            }
            return $result;
        }
        return $blocks;
    }

    /**
     * @param array $listPercents
     * @param int $numberRandom
     * @return array
     */
    public function generateRandomByPercent(array $listPercents, int $numberRandom = 1) {
        $list = array();
        foreach ($listPercents as $item => $popular)
        {
            $list = array_merge($list, array_fill(0, $popular, $item));
        }

        $randomKeys = array_rand($list, $numberRandom);
        $result = array();

        foreach ($randomKeys as $randomKey)
        {
            array_push($result, $list[$randomKey]);
        }

        return $result;
    }

    /**
     * @param array $randomBlockKeys
     * @param array $listWeights
     * @param array $normalLookBooks
     * @param array $verticalLookBooks
     * @param array $mainLookBooks
     * @param int $maxWeight
     * @return array
     */
    public function renderBlockWithWeight(array $randomBlockKeys, array $listWeights, array &$normalLookBooks, array &$verticalLookBooks, array &$mainLookBooks, int $maxWeight) {
        $block = array();
        $totalWeight = 0;
        foreach ($randomBlockKeys as $typeRandom) {
            switch ($typeRandom) {
                case 'normal':
                    if (sizeof($normalLookBooks) >= 2 && ($totalWeight + 2*$listWeights[$typeRandom]) <= $maxWeight) {
                        $randomItemKeys = array_rand($normalLookBooks, 2);
                        foreach ($randomItemKeys as $randomItemKey) {
                            array_push($block, $normalLookBooks[$randomItemKey]);
                            unset($normalLookBooks[$randomItemKey]);
                            $totalWeight += $listWeights[$typeRandom];
                        }
                    }
                    break;
                case 'vertical':
                    if (sizeof($verticalLookBooks) >= 1 && ($totalWeight + $listWeights[$typeRandom]) <= $maxWeight) {
                        $randomItemKey = array_rand($verticalLookBooks);
                        array_push($block, $verticalLookBooks[$randomItemKey]);
                        unset($verticalLookBooks[$randomItemKey]);
                        $totalWeight += $listWeights[$typeRandom];
                    }
                    break;
                case 'main':
                    if (sizeof($mainLookBooks) >= 1 && ($totalWeight + $listWeights[$typeRandom]) <= $maxWeight) {
                        $randomItemKey = array_rand($mainLookBooks);
                        array_push($block, $mainLookBooks[$randomItemKey]);
                        unset($mainLookBooks[$randomItemKey]);
                        $totalWeight += $listWeights[$typeRandom];
                    }
                    break;
            }
        }
        return [
            'total_weight' => $totalWeight,
            'block' => $block
        ];
    }

    /**
     * @param array $listLookBooks
     * @param array $normalLookBooks
     * @param int $weights
     * @param int $weightSecondary
     * @param int $maxWeight
     * @return array
     */
    public function renderSingleBlock(array &$listLookBooks, array &$normalLookBooks, int $weights, int $weightSecondary, int $maxWeight) {
        $result = array();

        while (sizeof($listLookBooks) >= 1) {

            $block = array();
            $totalWeight = 0;
            while ($totalWeight < $maxWeight && sizeof($listLookBooks) >= 1) {

                $randomItemKey = array_rand($listLookBooks);
                array_push($block, $listLookBooks[$randomItemKey]);
                unset($listLookBooks[$randomItemKey]);
                $totalWeight += $weights;

                if (sizeof($normalLookBooks) >= 1 && ($totalWeight + 2*$weightSecondary) < $maxWeight) {
                    while ($totalWeight < $maxWeight && sizeof($normalLookBooks) >= 1) {
                        $randomItemKey = array_rand($normalLookBooks);
                        array_push($block, $normalLookBooks[$randomItemKey]);
                        unset($normalLookBooks[$randomItemKey]);
                        $totalWeight += $weightSecondary;
                    }
                }
            }
            array_push($result, $block);
        }
        return $result;
    }

    /**
     * @param array $listWeights
     * @param array $normalLookBooks
     * @param array $verticalLookBooks
     * @param array $mainLookBooks
     * @param int $maxWeight
     * @return array
     */
    public function renderFirstBlock(array $listWeights, array &$normalLookBooks, array &$verticalLookBooks, array &$mainLookBooks, int $maxWeight) {
        $block = array();
        if (sizeof($mainLookBooks) >= 1 && (sizeof($normalLookBooks) >= 2 || sizeof($verticalLookBooks) >= 1)) {
            $totalWeight = 0;
            $randomItemKeyMain = array_rand($mainLookBooks);
            array_push($block, $mainLookBooks[$randomItemKeyMain]);
            unset($mainLookBooks[$randomItemKeyMain]);
            $totalWeight += $listWeights['main'];
            $weightNeed = $maxWeight - $totalWeight;

            if ((sizeof($normalLookBooks) >= 2 || sizeof($verticalLookBooks) >= 1) && $totalWeight < $maxWeight) {
                $listVerticalNormalPercents = config('plugins-product.product.percent_layout_look_book.vertical_normal');
                $randomBlockKeys = $this->generateRandomByPercent($listVerticalNormalPercents, 2);
                $renderBlock = $this->renderBlockWithWeight($randomBlockKeys, $listWeights, $normalLookBooks, $verticalLookBooks, $mainLookBooks, $weightNeed);
                $block = array_merge($block, $renderBlock['block']);
                $totalWeight += $renderBlock['total_weight'];
            }
            else if (sizeof($verticalLookBooks) >= 1 && $totalWeight < $maxWeight) {
                $verticalSingleBlocks = $this->renderSingleBlock($verticalLookBooks, $listWeights['vertical'], $weightNeed);
                $block = array_merge($block, $verticalSingleBlocks);
                $totalWeight += $listWeights['vertical'];
            }
            else if (sizeof($normalLookBooks) >= 2 && $totalWeight < $maxWeight) {
                $normalSingleBlocks = $this->renderSingleBlock($normalLookBooks, $listWeights['normal'], $weightNeed);
                $block = array_merge($block, $normalSingleBlocks);
                $totalWeight += $listWeights['normal'];
            }
        }
        return $block;
    }

    /**
     * @param int $differentWight
     * @param array $normalLookBooks
     * @param array $verticalLookBooks
     * @param array $mainLookBooks
     * @param array $renderBlock
     * @param array $listWeights
     */
    public function loopAddLookBookWeight(int $differentWight, array &$normalLookBooks, array &$verticalLookBooks, array &$mainLookBooks, array &$renderBlock, array $listWeights) {
        $isExitLoop = false;
        while ($differentWight) {
            switch ($differentWight) {
                case 2:
                    if (sizeof($normalLookBooks) >= 2 && sizeof($verticalLookBooks) >= 1) {
                        $listVerticalNormalPercents = config('plugins-product.product.percent_layout_look_book.vertical_normal');
                        $randomBlockAddKeys = $this->generateRandomByPercent($listVerticalNormalPercents, 2);
                        $renderBlockAdd = $this->renderBlockWithWeight($randomBlockAddKeys, $listWeights, $normalLookBooks, $verticalLookBooks, $mainLookBooks, 2);
                        $renderBlock['block'] = array_merge($renderBlock['block'], $renderBlockAdd['block']);
                        $differentWight -= $renderBlockAdd['total_weight'];
                    }
                    else if (sizeof($normalLookBooks) >= 2) {
                        $randomItemKeys = array_rand($normalLookBooks, 2);
                        foreach ($randomItemKeys as $randomItemKey) {
                            array_push($renderBlock['block'], $normalLookBooks[$randomItemKey]);
                            unset($normalLookBooks[$randomItemKey]);
                            $differentWight -= $listWeights['normal'];
                        }
                    }
                    else if (sizeof($verticalLookBooks) >= 1) {
                        $randomItemKey = array_rand($verticalLookBooks);
                        array_push($renderBlock['block'], $verticalLookBooks[$randomItemKey]);
                        unset($verticalLookBooks[$randomItemKey]);
                        $differentWight -= $listWeights['vertical'];
                    }
                    $isExitLoop = true;
                    break;
                case 4:
                    if (sizeof($mainLookBooks) >= 1) {
                        $randomItemKey = array_rand($mainLookBooks);
                        array_push($renderBlock['block'], $mainLookBooks[$randomItemKey]);
                        unset($mainLookBooks[$randomItemKey]);
                        $differentWight -= $listWeights['main'];
                    }
                    else if (sizeof($normalLookBooks) >= 2 && sizeof($verticalLookBooks) >= 1) {
                        $listVerticalNormalPercents = config('plugins-product.product.percent_layout_look_book.vertical_normal');
                        $randomBlockAddKeys = $this->generateRandomByPercent($listVerticalNormalPercents, 2);
                        $renderBlockAdd = $this->renderBlockWithWeight($randomBlockAddKeys, $listWeights, $normalLookBooks, $verticalLookBooks, $mainLookBooks, 2);
                        $renderBlock['block'] = array_merge($renderBlock['block'], $renderBlockAdd['block']);
                        $differentWight -= $renderBlockAdd['total_weight'];
                    }
                    else if (sizeof($normalLookBooks) >= 2) {
                        $randomItemKeys = array_rand($normalLookBooks, 2);
                        foreach ($randomItemKeys as $randomItemKey) {
                            array_push($renderBlock['block'], $normalLookBooks[$randomItemKey]);
                            unset($normalLookBooks[$randomItemKey]);
                            $differentWight -= $listWeights['normal'];
                        }
                    }
                    else if (sizeof($verticalLookBooks) >= 1) {
                        $randomItemKey = array_rand($verticalLookBooks);
                        array_push($renderBlock['block'], $verticalLookBooks[$randomItemKey]);
                        unset($verticalLookBooks[$randomItemKey]);
                        $differentWight -= $listWeights['vertical'];
                    }
                    break;
            }
            if ($isExitLoop)
                break;
        }
    }

    /**
     * @param int $lookBookId
     * @return mixed
     */
    public function getDetailLookBook(int $lookBookId) {
        return $this->repository->findById($lookBookId, ['lookBookTags', 'lookBookSpacesBelong', 'lookBookBusiness'])->toArray();
    }
}