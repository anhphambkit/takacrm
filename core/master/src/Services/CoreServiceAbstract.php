<?php

namespace Core\Master\Services;

use Illuminate\Http\Request;

abstract class CoreServiceAbstract implements CoreServiceInterface
{
    /**
     * Execute produce an entity
     *
     * @param Request $request
     * @return mixed
     * @author TrinhLe
     */
    public function execute(Request $request){}
}
