<?php
namespace Core\Media\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
#Interface Media
use Core\Media\Repositories\Interfaces\MediaSettingRepositories;
use Core\Media\Repositories\Interfaces\MediaFileRepositories;
use Core\Media\Repositories\Interfaces\MediaFolderRepositories;
use Core\Media\Repositories\Interfaces\MediaShareRepositories;
#Service
use Core\Media\Services\UploadsManager;
use Carbon\Carbon;
use Exception;
use File;
use Illuminate\Http\Request;
use Image;
use BMedia;
use ZipArchive;

class MediaController extends BaseAdminController{
    
    /**
     * @var MediaFileRepositories
     */
    protected $fileRepository;

    /**
     * @var MediaFolderRepositories
     */
    protected $folderRepository;

    /**
     * @var MediaShareRepositories
     */
    protected $mediaShareRepository;

    /**
     * @var UploadsManager
     */
    protected $uploadManager;

    /**
     * @var MediaSettingRepositories
     */
    protected $mediaSettingRepository;

    /**
     * MediaController constructor.
     * @param MediaFileRepositories $fileRepository
     * @param MediaFolderRepositories $folderRepository
     * @param MediaShareRepositories $mediaShareRepository
     * @param MediaSettingRepositories $mediaSettingRepository
     * @param UploadsManager $uploadManager
     * @author TrinhLe
     */
    public function __construct(
        MediaFileRepositories $fileRepository,
        MediaFolderRepositories $folderRepository,
        MediaShareRepositories $mediaShareRepository,
        MediaSettingRepositories $mediaSettingRepository,
        UploadsManager $uploadManager
    )
    {
		$this->fileRepository         = $fileRepository;
		$this->folderRepository       = $folderRepository;
		$this->mediaShareRepository   = $mediaShareRepository;
		$this->mediaSettingRepository = $mediaSettingRepository;
		$this->uploadManager          = $uploadManager;

        parent::__construct();
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getMedia()
    {
        return view('core-media::index');
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getPopup()
    {
        return view('core-media::popup')->render();
    }

    /**
     * Get list files & folders
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function getList(Request $request)
    {
        $userId      = auth()->id();
        $files       = [];
        $folders     = [];
        $breadcrumbs = [];

        $orderBy = $this->transformOrderBy($request->input('sort_by'));

        if ($request->has('is_popup') && $request->has('selected_file_id') && $request->input('selected_file_id') != null) {
            $current_file = $this->fileRepository->getFirstBy(['id' => $request->input('selected_file_id')], ['folder_id']);
            if ($current_file) {
                $request->merge(['folder_id' => $current_file->folder_id]);
            }
        }
        
        switch ($request->input('view_in')) {
            case 'my_media':
                $breadcrumbs = [
                    [
                        'id' => 0,
                        'name' => trans('core-media::media.my_media'),
                        'icon' => 'fa fa-user-secret',
                    ],
                ];

                foreach ($this->fileRepository->getFilesByFolderId($request->input('folder_id'), $userId, [
                    'order_by' => [
                        $orderBy[0] => $orderBy[1],
                    ],
                    'where' => [
                        ['name', 'LIKE', '%' . $request->input('search') . '%',]
                    ],
                ]) as $file) {
                    if ($request->input('filter') == 'everything' || $request->input('filter') == $file->type) {
                        $files[] = $this->getResponseFileData($file);
                    }
                }

                foreach ($this->folderRepository->getFolderByParentId($request->input('folder_id'), $userId, [
                    'where' => [
                        ['name', 'LIKE', '%' . $request->input('search') . '%',]
                    ],
                ]) as $folder) {
                    $folders[] = $this->getResponseFolderData($folder);
                }

                break;

            case 'public':
                $breadcrumbs = [
                    [
                        'id' => 0,
                        'name' => trans('core-media::media.public'),
                        'icon' => 'fa fa-home',
                    ],
                ];

                foreach ($this->fileRepository->getFilesByFolderId($request->input('folder_id'), $userId, [
                    'order_by' => [
                        $orderBy[0] => $orderBy[1],
                    ],
                    'where' => [
                        ['name', 'LIKE', '%' . $request->input('search') . '%',]
                    ],
                    'is_public' => true,
                ]) as $file) {
                    if ($request->input('filter') == 'everything' || $request->input('filter') == $file->type) {
                        $files[] = $this->getResponseFileData($file);
                    }
                }

                foreach ($this->folderRepository->getFolderByParentId($request->input('folder_id'), $userId, [
                    'where' => [
                        ['name', 'LIKE', '%' . $request->input('search') . '%',]
                    ],
                    'is_public' => true,
                ]) as $folder) {
                    $folders[] = $this->getResponseFolderData($folder);
                }

                break;

            case 'shared_with_me':
                $breadcrumbs = [
                    [
                        'id' => 0,
                        'name' => trans('core-media::media.shared_with_me'),
                        'icon' => 'fa fa-share-alt-square',
                    ],
                ];

                if ($request->input('folder_id') == 0) {
                    foreach ($this->mediaShareRepository->getSharedWithMeFolders($userId, $request->input('folder_id')) as $folder) {
                        $folders[] = $this->getResponseFolderData($folder);
                    }

                    foreach ($this->mediaShareRepository->getShareWithMeFiles($userId, $request->input('folder_id')) as $shareItem) {
                        $file = $shareItem->file()->first();
                        if (!empty($file)) {
                            $files[] = $this->getResponseFileData($file);
                        }
                    }
                } else {
                    foreach ($this->fileRepository->getFilesByFolderId($request->input('folder_id'), $userId, [
                        'order_by' => [
                            $orderBy[0] => $orderBy[1],
                        ],
                        'where' => [
                            ['name', 'LIKE', '%' . $request->input('search') . '%',]
                        ],
                    ]) as $file) {
                        if ($request->input('filter') == 'everything' || $request->input('filter') == $file->type) {
                            $files[] = $this->getResponseFileData($file);
                        }
                    }

                    foreach ($this->folderRepository->getFolderByParentId($request->input('folder_id'), $userId, [
                        'where' => [
                            ['name', 'LIKE', '%' . $request->input('search') . '%',]
                        ],
                    ]) as $folder) {
                        $folders[] = $this->getResponseFolderData($folder);
                    }
                }
                break;

            case 'shared':
                $breadcrumbs = [
                    [
                        'id' => 0,
                        'name' => trans('core-media::media.shared'),
                        'icon' => 'fa fa-share-square',
                    ],
                ];

                if ($request->input('folder_id') == 0) {
                    foreach ($this->fileRepository->getFilesByFolderId($request->input('folder_id'), $userId, [
                        'order_by' => [
                            $orderBy[0] => $orderBy[1],
                        ],
                        'where' => [
                            ['name', 'LIKE', '%' . $request->input('search') . '%',]
                        ],
                        'is_public' => true,
                    ]) as $file) {
                        if ($request->input('filter') == 'everything' || $request->input('filter') == $file->type) {
                            $files[] = $this->getResponseFileData($file);
                        }
                    }

                    foreach ($this->folderRepository->getFolderByParentId($request->input('folder_id'), $userId, [
                        'where' => [
                            ['name', 'LIKE', '%' . $request->input('search') . '%',]
                        ],
                        'is_public' => true,
                    ]) as $folder) {
                        $folders[] = $this->getResponseFolderData($folder);
                    }

                    foreach ($this->mediaShareRepository->getSharedFolders($userId, $request->input('folder_id')) as $folder) {
                        $folders[] = $this->getResponseFolderData($folder);
                    }

                    foreach ($this->mediaShareRepository->getSharedFiles($userId, $request->input('folder_id')) as $shareItem) {
                        $files[] = $this->getResponseFileData($shareItem->file()->first());
                    }
                } else {
                    foreach ($this->fileRepository->getFilesByFolderId($request->input('folder_id'), $userId, [
                        'order_by' => [
                            $orderBy[0] => $orderBy[1],
                        ],
                        'where' => [
                            ['name', 'LIKE', '%' . $request->input('search') . '%',]
                        ],
                    ]) as $file) {
                        if ($request->input('filter') == 'everything' || $request->input('filter') == $file->type) {
                            $files[] = $this->getResponseFileData($file);
                        }
                    }

                    foreach ($this->folderRepository->getFolderByParentId($request->input('folder_id'), $userId, [
                        'where' => [
                            ['name', 'LIKE', '%' . $request->input('search') . '%',]
                        ],
                    ]) as $folder) {
                        $folders[] = $this->getResponseFolderData($folder);
                    }
                }
                break;

            case 'trash':
                $breadcrumbs = [
                    [
                        'id' => 0,
                        'name' => trans('core-media::media.trash'),
                        'icon' => 'fa fa-trash-o',
                    ],
                ];

                $trashed_folders = $this->folderRepository->getTrashed($request->input('folder_id'), $userId, [
                    'where' => [
                        ['name', 'LIKE', '%' . $request->input('search') . '%',]
                    ],
                ]);

                foreach ($trashed_folders as $folder) {
                    $folders[] = $this->getResponseFolderData($folder);
                }

                foreach ($this->fileRepository->getTrashed($request->input('folder_id'), $userId, [
                    'order_by' => [
                        $orderBy[0] => $orderBy[1],
                    ],
                    'where' => [
                        [
                            'name', 'LIKE', '%' . $request->input('search') . '%',
                        ],
                        [
                            'folder_id', '=', $request->input('folder_id'),
                        ],
                    ],
                    'whereNotIn' => $trashed_folders->pluck('id')->all(),
                ]) as $file) {
                    if ($request->input('filter') == 'everything' || $request->input('filter') == $file->type) {
                        $files[] = $this->getResponseFileData($file);
                    }
                }

                break;

            case 'recent':
                $breadcrumbs = [
                    [
                        'id' => 0,
                        'name' => trans('core-media::media.recent'),
                        'icon' => 'fa fa-clock-o',
                    ],
                ];

                $params = [
                    'order_by' => [
                        $orderBy[0] => $orderBy[1],
                    ],
                    'where' => [
                        ['name', 'LIKE', '%' . $request->input('search') . '%',],
                    ],
                    'recent_items' => $request->input('recent_items', []),
                ];

                foreach ($this->fileRepository->getFilesByFolderId(-1, $userId, $params) as $file) {
                    if ($request->input('filter') == 'everything' || $request->input('filter') == $file->type) {
                        $files[] = $this->getResponseFileData($file);
                    }
                }

                break;
            case 'favorites':
                $breadcrumbs = [
                    [
                        'id' => 0,
                        'name' => trans('core-media::media.favorites'),
                        'icon' => 'fa fa-star',
                    ],
                ];

                $favorite_items = $this->mediaSettingRepository->getFirstBy(['key' => 'favorites', 'user_id' => auth()->id()]);
                if (!empty($favorite_items)) {
                    $file_ids = collect($favorite_items->value)->where('is_folder', 'false')->pluck('id')->all();
                    if (!empty($file_ids)) {
                        foreach ($this->fileRepository->getFilesByFolderId($request->input('folder_id'), $userId,[
                            'order_by' => [
                                $orderBy[0] => $orderBy[1],
                            ],
                            'where' => [
                                [
                                    'name', 'LIKE', '%' . $request->input('search') . '%',
                                ]
                            ],
                        ]) as $file) {
                            if (in_array($file->id, $file_ids)) {
                                if ($request->input('filter') == 'everything' || $request->input('filter') == $file->type) {
                                    $files[] = $this->getResponseFileData($file);
                                }
                            }
                        }
                    }

                    $folder_ids = collect($favorite_items->value)->where('is_folder', 'true')->pluck('id')->all();

                    if (!empty($folder_ids)) {
                        foreach ($this->folderRepository->getFolderByParentId($request->input('folder_id'), $userId, [
                            'where' => [
                                [
                                    'name', 'LIKE', '%' . $request->input('search') . '%',
                                ]
                            ],
                        ]) as $folder) {
                            if (in_array($folder->id, $folder_ids)) {
                                $folders[] = $this->getResponseFolderData($folder);
                            }
                        }
                    }

                }

                break;
        }

        $breadcrumbs = array_merge($breadcrumbs, $this->getBreadcrumbs($request));
        $selected_file_id = $request->input('selected_file_id');
        return BMedia::responseSuccess(compact('files', 'folders', 'breadcrumbs', 'selected_file_id'));
    }

    /**
     * @param $folder
     * @return array
     * @author TrinhLe
     */
    protected function getResponseFolderData($folder)
    {
        if (empty($folder)) {
            return [];
        }

        return [
            'id' => $folder->id,
            'name' => $folder->name,
            'is_public' => $folder->is_public,
            'created_at' => date_from_database($folder->created_at, config('cms.date_format.date_time', 'Y-m-d H:i:s')),
            'updated_at' => date_from_database($folder->updated_at, config('cms.date_format.date_time', 'Y-m-d H:i:s')),
        ];
    }

    /**
     * @param $file
     * @return array
     * @author TrinhLe
     */
    protected function getResponseFileData($file)
    {
        if (empty($file)) {
            return [];
        }

        return [
            'id'         => $file->id,
            'name'       => $file->real_filename,
            'basename'   => File::basename($file->url),
            'url'        => \BFileService::getMediaUrl($file), // value insert from modal
            'full_url'   => url(\BFileService::getMediaUrl($file)),
            'type'       => $file->type,
            'icon'       => $file->icon,
            'thumb'      => $file->type == 'image' ? app('imagy')->getThumbnail($file, 'mediumThumb') : null,
            'size'       => $file->human_size,
            'mime_type'  => $file->mime_type,
            'created_at' => date_from_database($file->created_at, config('cms.date_format.date_time', 'Y-m-d H:i:s')),
            'updated_at' => date_from_database($file->updated_at, config('cms.date_format.date_time', 'Y-m-d H:i:s')),
            'focus'      => $file->focus,
            'is_public'  => $file->is_public,
            'options'    => $file->options,
            'folder_id'  => $file->folder_id,

        ];
    }

    /**
     * @param Request $request
     * @return array
     * @author TrinhLe
     */
    protected function getBreadcrumbs(Request $request)
    {
        if ($request->input('folder_id') == 0) {
            return [];
        }

        if ($request->input('view_in') == 'trash') {
            $folder = $this->folderRepository->getFirstByWithTrash(['id' => $request->input('folder_id')]);
        } else {
            $folder = $this->folderRepository->getFirstBy(['id' => $request->input('folder_id')]);
        }
        if (empty($folder)) {
            return [];
        }

        if (empty($breadcrumbs)) {
            $breadcrumbs = [
                [
                    'name' => $folder->name,
                    'id' => $folder->id,
                ]
            ];
        }

        $child = $this->folderRepository->getBreadcrumbs($folder->parent_id);
        if (!empty($child)) {
            return array_merge($child, $breadcrumbs);
        }

        return $breadcrumbs;
    }

    /**
     * Get user quota
     *
     * @return \Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function getQuota()
    {
        $userId      = auth()->id();
        return BMedia::responseSuccess([
            'quota' => human_file_size($this->fileRepository->getQuota($userId)),
            'used'  => human_file_size($this->fileRepository->getSpaceUsed($userId)),
            'percent' => $this->fileRepository->getPercentageUsed($userId),
        ]);
    }

    /**
     * @param string $orderBy
     * @return array
     */
    protected function transformOrderBy($orderBy)
    {
        $result = explode('-', $orderBy);
        if (!count($result) == 2) {
            return ['name', 'asc'];
        }
        return $result;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postGlobalActions(Request $request)
    {
        $userId = auth()->id();
        $type = $request->input('action');
        switch ($type) {
            case 'trash':
                $error = false;
                foreach ($request->input('selected') as $item) {
                    $id = $item['id'];
                    if ($item['is_folder'] == 'false') {
                        try {
                            $this->fileRepository->deleteBy(['id' => $id]);
                        } catch (Exception $e) {
                            info($e->getMessage());
                            $error = true;
                        }
                    } else {

                        $this->folderRepository->deleteFolder($id, $userId);
                    }
                }

                if ($error) {
                    return BMedia::responseError(trans('core-media::media.trash_error'));
                }

                return BMedia::responseSuccess([], trans('core-media::media.trash_success'));

                break;

            case 'restore':
                $error = false;
                foreach ($request->input('selected') as $item) {
                    $id = $item['id'];
                    if ($item['is_folder'] == 'false') {
                        try {
                            $this->fileRepository->restoreBy(['id' => $id]);
                        } catch (Exception $e) {
                            info($e->getMessage());
                            $error = true;
                        }
                    } else {
                        $this->folderRepository->restoreFolder($id, $userId);
                    }
                }

                if ($error) {
                    return BMedia::responseError(trans('core-media::media.restore_error'));
                }

                return BMedia::responseSuccess([], trans('core-media::media.restore_success'));

                break;

            case 'make_copy':
                foreach ($request->input('selected', []) as $item) {
                    $id = $item['id'];
                    if ($item['is_folder'] == 'false') {
                        $file = $this->fileRepository->getFirstBy(['id' => $id]);
                        $this->copyFile($file);

                    } else {
                        $old_folder = $this->folderRepository->getFirstBy(['id' => $id]);
                        $folder = $old_folder->replicate();
                        $folder->slug = $this->folderRepository->createSlug($folder->name, $folder->parent_id);
                        $folder->name = $folder->name . '-(copy)';
                        $folder->user_id = auth()->id();
                        $folder = $this->folderRepository->createOrUpdate($folder);

                        $files = $this->fileRepository->getFilesByFolderId($id);
                        foreach ($files as $file) {
                            $this->copyFile($file, $folder->id);
                        }

                        $children = $this->folderRepository->getAllChildFolders($id);
                        foreach ($children as $parent_id => $child) {

                            if ($parent_id != $old_folder->id) {
                                /**
                                 * @var MediaFolder $child
                                 */
                                $folder = $this->folderRepository->getFirstBy(['id' => $parent_id]);
                                $folder = $folder->replicate();
                                $folder->user_id = auth()->id();
                                $folder->parent_id = $folder->id;
                                $folder = $this->folderRepository->createOrUpdate($folder);

                                $parent_files = $this->fileRepository->getFilesByFolderId($parent_id);
                                foreach ($parent_files as $parent_file) {
                                    $this->copyFile($parent_file, $folder->id);
                                }
                            }

                            foreach ($child as $sub) {
                                $sub_files = $this->fileRepository->getFilesByFolderId($sub->id);

                                /**
                                 * @var MediaFolder $sub
                                 */
                                $sub = $sub->replicate();
                                $sub->user_id = auth()->id();
                                $sub->parent_id = $folder->id;
                                $sub = $this->folderRepository->createOrUpdate($sub);
                                foreach ($sub_files as $sub_file) {
                                    $this->copyFile($sub_file, $sub->id);
                                }
                            }
                        }

                        File::copyDirectory($this->uploadManager->uploadPath($this->folderRepository->getFullPath($old_folder->id)), $this->uploadManager->uploadPath($this->folderRepository->getFullPath($folder->id)));
                    }
                }

                return BMedia::responseSuccess([], trans('core-media::media.copy_success'));

                break;
            case 'share':
                $users = $request->input('users', []);

                if ($request->input('share_option') == 'user') {
                    if (!count($users)) {
                        return BMedia::responseError(trans('core-media::media.no_user_selected'));
                    }
                }

                foreach ($request->input('selected') as $item) {

                    $id = $item['id'];

                    if ($item['is_folder'] == 'false') {

                        if ($request->input('share_option') == 'no_share') {

                            $this->mediaShareRepository->forceDelete(['share_id' => $id, 'shared_by' => auth()->id(), 'share_type' => 'file']);
                            $this->fileRepository->update(['id' => $id, 'user_id' => auth()->id()], ['is_public' => 0]);

                        } elseif ($request->input('share_option') == 'user') {
                            foreach ($users as $user_id) {
                                $this->mediaShareRepository->firstOrCreate([
                                    'share_type' => 'file',
                                    'share_id' => $id,
                                    'shared_by' => auth()->id(),
                                    'user_id' => $user_id,
                                ]);
                            }
                            $this->fileRepository->update(['id' => $id, 'user_id' => auth()->id()], ['is_public' => 0]);
                        } else {
                            $this->fileRepository->update(['id' => $id], ['is_public' => 1]);
                        }

                    } else {

                        if ($request->input('share_option') == 'no_share') {
                            $this->mediaShareRepository->forceDelete(['share_id' => $id, 'shared_by' => auth()->id(), 'share_type' => 'folder']);
                            $this->folderRepository->update(['id' => $id, 'user_id' => auth()->id()], ['is_public' => 0]);
                        } elseif ($request->input('share_option') == 'user') {
                            foreach ($users as $user_id) {
                                $this->mediaShareRepository->firstOrCreate([
                                    'share_type' => 'folder',
                                    'share_id' => $id,
                                    'shared_by' => auth()->id(),
                                    'user_id' => $user_id,
                                ]);

                                $files = $this->fileRepository->getFilesByFolderId($id);

                                foreach ($files as $file) {
                                    $this->mediaShareRepository->firstOrCreate([
                                        'share_type' => 'file',
                                        'share_id' => $file->id,
                                        'shared_by' => auth()->id(),
                                        'user_id' => $user_id,
                                    ]);
                                }
                            }
                            $this->folderRepository->update(['id' => $id, 'user_id' => auth()->id()], ['is_public' => 0]);
                        } else {
                            $this->folderRepository->update(['id' => $id], ['is_public' => 1]);

                            $files = $this->fileRepository->getFilesByFolderId($id);
                            foreach ($files as $file) {
                                $file->is_public = 1;
                                $this->fileRepository->createOrUpdate($file);
                            }
                        }
                    }
                }

                return BMedia::responseSuccess([], trans('core-media::media.share_success'));
                break;

            case 'un_share':
                foreach ($request->input('selected') as $item) {
                    if ($item['is_folder'] == 'false') {
                        $this->mediaShareRepository->forceDelete(['id' => $item['id'], 'share_by' => auth()->id(), 'share_type' => 'file']);
                    } else {
                        $this->mediaShareRepository->forceDelete(['id' => $item['id'], 'share_by' => auth()->id(), 'share_type' => 'folder']);
                    }
                }

                return BMedia::responseSuccess([], trans('core-media::media.un_share_success'));

                break;

            case 'remove_share':
                foreach ($request->input('selected') as $item) {
                    if ($item['is_folder'] == 'false') {
                        $this->mediaShareRepository->forceDelete(['share_id' => $item['id'], 'user_id' => auth()->id(), 'share_type' => 'file']);
                    } else {
                        $this->mediaShareRepository->forceDelete(['share_id' => $item['id'], 'user_id' => auth()->id(), 'share_type' => 'folder']);
                    }
                }

                return BMedia::responseSuccess([], trans('core-media::media.remove_share_success'));

                break;

            case 'set_focus_point':
                $item = array_first($request->input('selected'));
                if (empty($item) || $item['is_folder'] == 'true') {
                    return BMedia::responseError('Invalid item selected!');
                }
                $meta = $this->fileRepository->getFirstBy(['id' => $item['id']]);
                $meta->focus = [
                    'data_attribute' => $request->input('data_attribute'),
                    'css_bg_position' => $request->input('css_bg_position'),
                    'retice_css' => $request->input('retice_css'),
                ];
                $this->mediaSettingRepository->createOrUpdate($meta);

                return BMedia::responseSuccess($meta, trans('core-media::media.set_focus_success'));

                break;

            case 'delete':
                foreach ($request->input('selected') as $item) {
                    $id = $item['id'];
                    if ($item['is_folder'] == 'false') {
                        try {
                            $this->fileRepository->forceDelete(['id' => $id]);
                        } catch (Exception $e) {
                            info($e->getMessage());
                        }
                    } else {
                        $this->folderRepository->forceDelete(['id' => $id]);
                    }
                }

                return BMedia::responseSuccess([], trans('core-media::media.delete_success'));

                break;
            case 'favorite':
                $meta = $this->mediaSettingRepository->firstOrCreate(['key' => 'favorites', 'user_id' => auth()->id()]);
                if (!empty($meta->value)) {
                    $meta->value = array_merge($meta->value, $request->input('selected', []));
                } else {
                    $meta->value = $request->input('selected', []);
                }

                $this->mediaSettingRepository->createOrUpdate($meta);

                return BMedia::responseSuccess([], trans('core-media::media.favorite_success'));
                break;

            case 'remove_favorite':
                $meta = $this->mediaSettingRepository->firstOrCreate(['key' => 'favorites', 'user_id' => auth()->id()]);
                if (!empty($meta)) {
                    $value = $meta->value;
                    if (!empty($value)) {
                        foreach ($value as $key => $item) {
                            foreach ($request->input('selected') as $selected_item) {
                                if ($item['is_folder'] == $selected_item['is_folder'] && $item['id'] == $selected_item['id']) {
                                    unset($value[$key]);
                                }
                            }
                        }
                        $meta->value = $value;

                        $this->mediaSettingRepository->createOrUpdate($meta);
                    }

                }

                return BMedia::responseSuccess([], trans('core-media::media.remove_favorite_success'));
                break;

            case 'rename':
                $error = false;
                $in_reserved_name = '';
                foreach ($request->input('selected') as $item) {
                    $id = $item['id'];
                    if ($item['is_folder'] == 'false') {
                        $file = $this->fileRepository->getFirstBy(['id' => $id]);

                        if (!empty($file)) {
                            $file->real_filename = $this->fileRepository->createName($item['name'], $file->folder_id, $userId);
                            $this->fileRepository->createOrUpdate($file);
                        }
                    } else {
                        $name = $item['name'];
                        if (in_array($name, config('core-media.media.upload.reserved_names', []))) {
                            if (!empty($in_reserved_name)) {
                                $in_reserved_name .= ', ';
                            }
                            $in_reserved_name .= $name;
                            $error[] = (int)$id;
                        } else {
                            $folder = $this->folderRepository->getFirstBy(['id' => $id]);

                            if (!empty($folder)) {
                                $folder->name = $this->folderRepository->createName($name, $folder->parent_id, $userId);
                                $this->folderRepository->createOrUpdate($folder);
                            }
                        }

                    }
                }

                if (!empty($error)) {

                    if (!empty($in_reserved_name)) {
                        return BMedia::responseError(trans('core-media::media.is_reserved_name', ['name' => $in_reserved_name]), $error);
                    }

                    return BMedia::responseError(trans('core-media::media.rename_error'));
                }

                return BMedia::responseSuccess([], trans('core-media::media.rename_success'));

                break;

            case 'empty_trash':
                $this->folderRepository->emptyTrash($userId);
                $this->fileRepository->emptyTrash($userId);

                return BMedia::responseSuccess([], trans('core-media::media.empty_trash_success'));
                break;
        }

        return BMedia::responseError(trans('core-media::media.invalid_action'));
    }

    /**
     * @param $file
     * @param int $new_folder_id
     */
    protected function copyFile($file, $new_folder_id = null)
    {
        /**
         * @var MediaFile $file ;
         */
        // $file = $file->replicate();
        // $file->user_id = auth()->id();

        // if ($new_folder_id == null) {
        //     $file->name = $file->name . '-(copy)';

        //     if (!in_array($file->type, array_merge(['video', 'youtube'], config('core-media.media.external_services')))) {
        //         $folder_path = str_finish($this->folderRepository->getFullPath($file->folder_id), '/');
        //         $path = $folder_path . File::name($file->url) . '-(copy)' . '.' . File::extension($file->url);
        //         if (file_exists(public_path($file->url))) {
        //             $content = File::get(public_path($file->url));

        //             $this->uploadManager->saveFile($path, $content);
        //             $data = $this->uploadManager->fileDetails($path);
        //             $file->url = $data['url'];

        //             if (is_image($this->uploadManager->fileMimeType($path))) {
        //                 foreach (config('core-media.media.sizes') as $size) {
        //                     $readable_size = explode('x', $size);
        //                     Image::make(ltrim($file->url, '/'))->fit($readable_size[0], $readable_size[1])
        //                         ->save($this->uploadManager->uploadPath($folder_path) . File::name($file->url) . '-' . $size . '.' . File::extension($file->url));
        //                 }
        //             }
        //         }
        //     }

        // } else {
        //     $file->url = str_replace($this->uploadManager->uploadPath($this->folderRepository->getFullPath($file->folder_id)),
        //         $this->uploadManager->uploadPath($this->folderRepository->getFullPath($new_folder_id)), $file->url);
        //     $file->folder_id = $new_folder_id;
        // }

        // $this->fileRepository->createOrUpdate($file);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function download(Request $request)
    {
        $items = $request->input('selected', []);

        if (count($items) == 1 && $items['0']['is_folder'] == 'false') {
            $file = $this->fileRepository->getFirstByWithTrash(['id' => $items[0]['id']]);
            if (!empty($file) && $file->type != 'video') {
                if(\BFileService::isExists($file)){
                    return \BFileService::downloadFile($file);
                }
                return BMedia::responseError(trans('core-media::media.file_not_exists'));
            }
        } else {
            if (class_exists('ZipArchive', false)) {
                $zip = new ZipArchive();
                $file_name = public_path('download-' . Carbon::now()->format('Y-m-d-h-i-s') . '.zip');
                if ($zip->open($file_name, ZipArchive::CREATE) == true) {
                    foreach ($items as $item) {
                        $id = $item['id'];
                        if ($item['is_folder'] == 'false') {
                            $file = $this->fileRepository->getFirstByWithTrash(['id' => $id]);
                            if (!empty($file) && $file->type != 'video') {
                                $arr_src = explode(DIRECTORY_SEPARATOR, $this->uploadManager->uploadPath('/'));
                                $path_length = strlen(implode(DIRECTORY_SEPARATOR, $arr_src) . DIRECTORY_SEPARATOR);
                                $zip->addFile(public_path($file->url), substr($file->url, $path_length));
                            }
                        } else {
                            $folder = $this->folderRepository->getFirstByWithTrash(['id' => $id]);
                            if (!empty($folder)) {
                                $path = $this->uploadManager->uploadPath($this->folderRepository->getFullPath($folder->id));
                                $arr_src = explode(DIRECTORY_SEPARATOR, $path);
                                $path_length = strlen(implode(DIRECTORY_SEPARATOR, $arr_src) . DIRECTORY_SEPARATOR);
                                $this->recurseZip($path, $zip, $path_length);
                            }
                        }
                    }
                    $zip->close();
                    if (File::exists($file_name)) {
                        return response()->download($file_name)->deleteFileAfterSend(true);
                    }
                }
                return BMedia::responseError(trans('core-media::media.download_file_error'));
            } else {
                return BMedia::responseError(trans('core-media::media.mMissing_zip_archive_extension'));
            }

        }
        return BMedia::responseError(trans('core-media::media.can_not_download_file'));
    }

    /**
     * @param $src
     * @param ZipArchive $zip
     * @param $pathLength
     * @author TrinhLe
     */
    protected function recurseZip($src, &$zip, $pathLength)
    {
        foreach (scan_folder($src) as $item) {
            $item = $src . DIRECTORY_SEPARATOR . $item;
            if (File::isDirectory($item)) {
                $this->recurseZip($item, $zip, $pathLength);
            } else {
                if (class_exists('ZipArchive', false)) {
                    $is_thumb = false;
                    if (in_array(mime_content_type($item), ['image/jpeg', 'image/gif', 'image/png', 'image/bmp'])) {
                        foreach (config('core-media.media.sizes') as $size) {
                            $size_detect = '-' . $size . '.' . File::extension($item);
                            if (strpos($item, $size_detect) !== false) {
                                $is_thumb = true;
                            }
                        }
                    }
                    if (!$is_thumb) {
                        $zip->addFile($item, substr($item, $pathLength));
                    }
                }
            }
        }
    }
}