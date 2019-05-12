<?php
/**
 * MediaFolder repository implemented
 */
namespace Core\Media\Repositories\Eloquent;
use Core\Media\Repositories\Interfaces\MediaFolderRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Request;

class EloquentMediaFolderRepositories extends RepositoriesAbstract implements MediaFolderRepositories 
{
	
	/**
     * @param $folderId
     * @param array $params
     * @param bool $withTrash
     * @return mixed
     */
    public function getFolderByParentId($folderId, $userId, array $params = [], $withTrash = false)
    {
        if (Request::input('load_more_file') == 'true') {
            return [];
        }

        $params = array_merge([
            'where' => [],
        ], $params);
        $data = $this->model
            ->where($params['where']);
        if ($folderId != -1) {
            $data = $data->where('parent_id', '=', $folderId);
        }

        if (config('core-media.media.mode') != 'simple') {
            if (array_get($params, 'is_public') == true) {
                $data = $data->where('is_public', '=', 1);
            } else {
                $data = $data->where('user_id', '=', $userId);
            }
        }

        if ($withTrash) {
            $data = $data->withTrashed();
        }
        return $data->orderBy('name', 'asc')
            ->get();
    }

    /**
     * @param $name
     * @param $parentId
     * @return mixed
     * @author TrinhLe
     */
    public function createSlug($name, $parentId, $userId)
    {
        $slug = str_slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->checkIfExists('slug', $slug, $parentId, $userId)) {
            $slug = $baseSlug . '-' . $index++;
        }

        return $slug;
    }

    /**
     * @param $name
     * @param $parentId
     * @return mixed
     * @author TrinhLe
     */
    public function createName($name, $parentId, $userId)
    {
        $newName = $name;
        $index = 1;
        $baseSlug = $newName;
        while ($this->checkIfExists('name', $newName, $parentId, $userId)) {
            $newName = $baseSlug . '-' . $index++;
        }

        return $newName;
    }

    /**
     * @param $key
     * @param $value
     * @param $parentId
     * @return mixed
     * @internal param $slug
     * @author TrinhLe
     */
    protected function checkIfExists($key, $value, $parentId, $userId)
    {
        $count = $this->model->where($key, '=', $value)->where('parent_id', $parentId)->withTrashed();
        if (config('core-media.media.mode') != 'simple') {
            $count = $count->where('user_id', '=', $userId);
        }

        $count = $count->count();

        return $count > 0;
    }

    /**
     * @param $parentId
     * @param array $breadcrumbs
     * @return array
     * @author TrinhLe
     */
    public function getBreadcrumbs($parentId, $breadcrumbs = [])
    {
        if ($parentId == 0) {
            return $breadcrumbs;
        }

        $folder = $this->getFirstByWithTrash(['id' => $parentId]);

        if (empty($folder)) {
            return $breadcrumbs;
        }

        $child = $this->getBreadcrumbs($folder->parent_id, $breadcrumbs);
        return array_merge($child, [
            [
                'id' => $folder->id,
                'name' => $folder->name,
            ]
        ]);
    }

    /**
     * @param $parentId
     * @param array $params
     * @return mixed
     * @author TrinhLe
     */
    public function getTrashed($parentId, $userId, array $params = [])
    {
        $params = array_merge([
            'where' => [],
        ], $params);
        $data = $this->model
            ->where('parent_id', '=', $parentId)
            ->where($params['where'])
            ->orderBy('name', 'asc')
            ->onlyTrashed();

        if (config('core-media.media.mode') != 'simple') {
            $data = $data->where(function ($query) use ($userId){
                $query->orWhere('user_id', '=', $userId)
                    ->orWhere('user_id', '=', 0);
            });
        }

        return $data->get();
    }

    /**
     * @param $folderId
     * @param bool $force
     * @author TrinhLe
     */
    public function deleteFolder($folderId, $userId, $force = false)
    {
        $child = $this->getFolderByParentId($folderId, $userId, [], $force);
        foreach ($child as $item) {
            $this->deleteFolder($item->id, $force);
        }

        if ($force) {
            $this->forceDelete(['id' => $folderId]);
        } else {
            $this->deleteBy(['id' => $folderId]);
        }
    }

    /**
     * @param $parentId
     * @param array $child
     * @return array
     * @internal param $folderId
     * @author TrinhLe
     */
    public function getAllChildFolders($parentId, $child = [])
    {
        if ($parentId == 0) {
            return $child;
        }

        $folders = $this->allBy(['parent_id' => $parentId]);

        if (!empty($folders)) {
            foreach ($folders as $folder) {
                $child[$parentId][] = $folder;
                return $this->getAllChildFolders($folder->id, $child);
            }
        }

        return $child;
    }

    /**
     * @param $folderId
     * @param string $path
     * @return string
     * @author TrinhLe
     */
    public function getFullPath($folderId, $userId, $path = '')
    {
        if ($folderId == 0) {
            return $userId . $path;
        }

        $folder = $this->getFirstByWithTrash(['id' => $folderId]);

        if (empty($folder)) {
            return $userId . $path;
        }

        $child = $this->getFullPath($folder->parent_id, $userId, $path);

        return $child . '/' . $folder->slug;
    }

    /**
     * @param $folderId
     * @author TrinhLe
     */
    public function restoreFolder($folderId, $userId)
    {
        $child = $this->getFolderByParentId($folderId, $userId, [], true);
        foreach ($child as $item) {
            $this->restoreFolder($item->id);
        }

        $this->restoreBy(['id' => $folderId]);
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function emptyTrash($userId)
    {
        $folders = $this->model->onlyTrashed();

        if (config('core-media.media.mode') != 'simple') {
            $folders = $folders->where('user_id', '=', $userId);
        }
        $folders = $folders->get();
        foreach ($folders as $folder) {
            $folder->forceDelete();
        }
        return true;
    }	
}