<?php
/**
 * MediaFile repository implemented
 */
namespace Core\Media\Repositories\Eloquent;
use Core\Media\Repositories\Interfaces\MediaFileRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Request;
use Exception;
use DB;

class EloquentMediaFileRepositories extends RepositoriesAbstract implements MediaFileRepositories 
{
	/**
     * @return mixed
     * @author TrinhLe
     */
    public function getSpaceUsed($userId)
    {
        $data = $this->model->withTrashed();

        if (config('core-media.media.mode') != 'simple') {
            $data = $data->where('user_id', '=', $userId);
        }
        return $data->sum('size');
    }

    /**
     * @return int
     * @author TrinhLe
     */
    public function getSpaceLeft($userId)
    {
        return $this->getQuota() - $this->getSpaceUsed($userId);
    }

    /**
     * @return int
     * @author TrinhLe
     */
    public function getQuota($userId)
    {
    	if($user = DB::table('users')->where('id', $userId)->first())
    		return $user->personal_quota;
    	return;
    }

    /**
     * @return float
     * @author TrinhLe
     */
    public function getPercentageUsed($userId)
    {
    	$quota = $this->getQuota($userId);

        if ($quota === 0 || empty($quota)) {
            return round(100, 2);
        } else {
            return round(($this->getSpaceUsed($userId) / $quota) * 100, 2);
        }
    }

    /**
     * @param $name
     * @param $folder
     * @return mixed
     * @author TrinhLe
     */
    public function createName($name, $folder, $userId)
    {
        $index = 1;
        $baseName = $name;
        while ($this->checkIfExistsName($name, $folder, $userId)) {
            $name = $baseName . '-' . $index++;
        }
        return $name;
    }

    /**
     * @param $name
     * @param $folder
     * @return mixed
     * @author TrinhLe
     */
    protected function checkIfExistsName($name, $folder, $userId)
    {
        $count = $this->model->where('name', '=', $name)->where('folder_id', '=', $folder)->withTrashed();
        if (config('core-media.media.mode') != 'simple') {
            $count = $count->where('user_id', '=', $userId);
        }

        $count = $count->count();

        return $count > 0;
    }

    /**
     * @param $name
     * @param $extension
     * @param $folderPath
     * @return mixed
     * @author TrinhLe
     */
    public function createSlug($name, $extension, $folderPath)
    {
        $slug = str_slug($name);
        $index = 1;
        $baseSlug = $slug;
        while (file_exists($folderPath . '/' . $slug . '.' . $extension)) {
            $slug = $baseSlug . '-' . $index++;
        }

        if (empty($slug)) {
            $slug = $slug . '-' . time();
        }

        return $slug . '.' . $extension;
    }

    /**
     * @param $folderId
     * @param array $params
     * @return mixed
     * @author TrinhLe
     */
    public function getFilesByFolderId($folderId, $userId, array $params = [])
    {
        $params = array_merge([
            'order_by' => [
                'real_filename' => 'ASC',
                'name' => 'ASC',
            ],
            'select' => [
                'id',
                'name',
                'url',
                'mime_type',
                'size',
                'created_at',
                'updated_at',
                'focus',
                'options',
                'folder_id',
                'is_public',
                'real_filename',
                'storage'
            ],
            'where' => [],
            'is_public' => false,
        ], $params);

        $files = $this->model->where($params['where']);

        if (config('core-media.media.mode') != 'simple') {
            if ($params['is_public'] == true) {
                $files = $files->where('is_public', '=', 1);
            } else {
                $files = $files->where('user_id', '=', $userId);
            }
        }

        if ($folderId != -1) {
            $files = $files->where('folder_id', '=', $folderId);
        }

        if (isset($params['recent_items'])) {
            $files = $files->whereIn('id', array_get($params, 'recent_items', []));
        }

        $files = $files->select($params['select']);

        foreach ($params['order_by'] as $by => $direction) {
            $files = $files->orderBy($by, strtoupper($direction));
        }

        if (Request::has('selected_file_id')) {
            $files->where('id', '<>', Request::input('selected_file_id'));
            if (!Request::has('paged') || Request::input('paged') == 1) {
                $current_file = $this->model->where('folder_id', '=', $folderId)->whereId(Request::input('selected_file_id'))->first();
            }
        }
        $posts_per_page = Request::has('posts_per_page') && Request::input('posts_per_page') > 0 ? Request::input('posts_per_page') : config('core-media.media.pagination.per_page');
        $paged = Request::has('paged') && Request::input('paged') > 0 ? Request::input('paged') : config('core-media.media.pagination.per_page');
        $files->skip(($paged - 1) * $posts_per_page)->limit($posts_per_page);

        $data = $files->get();

        if (isset($current_file)) {
            try {
                $data->prepend($current_file);
            } catch (Exception $e) {
                info('Error when prepend data');
            }
        }
        return $data;
    }

    /**
     * @param $folderId
     * @param array $params
     * @return mixed
     */
    public function getTrashed($folderId, $userId, array $params = [])
    {
        $params = array_merge([
            'order_by' => [
                'real_filename' => 'ASC',
                'name' => 'ASC',
            ],
            'select' => [
                'id',
                'name',
                'url',
                'mime_type',
                'size',
                'created_at',
                'updated_at',
                'options',
                'folder_id',
                'real_filename',
                'storage'
            ],
            'where'      => [],
            'whereNotIn' => []
        ], $params);

        $files = $this->model
            ->where(function ($query) use ($params, $folderId) {
                return $query->orWhere('folder_id', $folderId)
                    ->orWhereNotIn('folder_id', $params['whereNotIn']);
            })
            ->where($params['where']);

        if (config('core-media.media.mode') != 'simple') {
            $files = $files->where('user_id', $userId);
        }

        $files = $files->select($params['select']);

        foreach ($params['order_by'] as $by => $direction) {
            $files = $files->orderBy($by, strtoupper($direction));
        }

        return $files->onlyTrashed()->get();
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function emptyTrash($userId)
    {
        $files = $this->model->onlyTrashed();

        if (config('core-media.media.mode') != 'simple') {
            $files = $files->where('user_id',$userId);
        }

        $files = $files->get();

        foreach ($files as $file) {
            $file->forceDelete();
        }
        return true;
    }
}