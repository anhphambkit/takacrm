<?php

namespace Core\Slug\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\Slug\Requests\SlugRequest;
use Core\Slug\Repositories\Interfaces\SlugRepositories as SlugInterface;
use Core\Slug\Services\SlugService;

class SlugController extends BaseAdminController
{
	/**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * @var SlugService
     */
    protected $slugService;

    /**
     * SlugController constructor.
     * @param SlugInterface $slugRepository
     * @param SlugService $slugService
     * @author TrinhLe
     */
    public function __construct(SlugInterface $slugRepository, SlugService $slugService)
    {
        $this->slugRepository = $slugRepository;
        $this->slugService = $slugService;
    }

    /**
     * @param SlugRequest $request
     * @return int|string
     */
    public function postCreate(SlugRequest $request)
    {
        return $this->slugService->create($request->input('name'), $request->input('slug_id') ?? 0, $request->input('screen'));
    }
}
