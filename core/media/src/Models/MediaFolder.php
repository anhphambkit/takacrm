<?php

namespace Core\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use Eloquent;

class MediaFolder extends Eloquent
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'media_folders';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return int
     * @author Trinh Le
     */
    public function isShared()
    {
        return MediaShare::where('share_id', '=', $this->id)->where('share_type', '=', 'folder')->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Trinh Le
     */
    public function files()
    {
        /**
         * @var Model $this
         */
        return $this->hasMany(MediaFile::class, 'folder_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author Trinh Le
     */
    public function parentFolder()
    {
        /**
         * @var Model $this
         */
        return $this->hasOne(MediaFolder::class, 'id', 'parent');
    }

    /**
     * @author Trinh Le
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($folder) {

            $share_folders = MediaShare::where('share_id', '=', $folder->id)->where('share_type', '=', 'folder')->get();
            $files         = MediaFile::where('folder_id', '=', $folder->id)->get();
            $share_files   = MediaShare::join('media_files', 'media_files.id', '=', 'media_shares.share_id')
                            ->where('share_type', '=', 'file')
                            ->where('folder_id', '=', $folder->id)->get();

            /**
             * @var MediaFolder $folder
             */
            if ($folder->isForceDeleting()) {
                foreach ($share_folders as $share_folder) {
                    $share_folder->forceDelete();
                }

                foreach ($files as $file) {
                    $file->forceDelete();
                }

                foreach ($share_files as $share_file) {
                    $share_file->forceDelete();
                }

                \BFileService::cleanFolder($folder);

            } else {

                foreach ($share_folders as $share_folder) {
                    $share_folder->delete();
                }

                foreach ($files as $file) {
                    $file->delete();
                }

                foreach ($share_files as $share_file) {
                    $share_file->delete();
                }
            }
        });

        static::restoring(function ($folder) {

            MediaShare::where('share_id', '=', $folder->id)->where('share_type', '=', 'folder')->restore();
            MediaFile::where('folder_id', '=', $folder->id)->restore();

            $share_files = MediaShare::join('media_files', 'media_files.id', '=', 'media_shares.share_id')
                ->where('share_type', '=', 'file')
                ->where('folder_id', '=', $folder->id)->get();

            foreach ($share_files as $share_file) {
                $share_file->delete();
            }
        });
    }

    /**
     * @author Trinh Le
     */
    public function __wakeup()
    {
        parent::boot();
    }
}
