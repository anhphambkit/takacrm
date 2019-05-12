<?php

namespace Core\Master\Supports;

class PageTitle
{
    protected $title;

    /**
     * @param $title
     * @author TrinhLe
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param bool $full
     * @return string
     * @author TrinhLe
     */
    public function getTitle($full = true)
    {
        if (empty($this->title)) {
            return config('core-base.cms.base_name');
        }

        if (!$full) {
            return $this->title;
        }
        
        return $this->title . ' | ' . config('core-base.cms.base_name');
    }
}