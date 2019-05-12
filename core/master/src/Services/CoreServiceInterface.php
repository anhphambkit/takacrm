<?php

namespace Core\Master\Services;

use Illuminate\Http\Request;

interface CoreServiceInterface
{
    /**
     * Execute produce an entity
     *
     * @param Request $request
     * @return mixed
     * @author TrinhLe
     */
    public function execute(Request $request);
}
