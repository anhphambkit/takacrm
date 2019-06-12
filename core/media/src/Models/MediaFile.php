<?php

namespace Core\Media\Models;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Core\Media\ValueObjects\MediaPath;

class MediaFile extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'media_files';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var type
     */
    protected $fillable = [
        'name'         ,
        'url'          ,
        'size'         ,
        'mime_type'    ,
        'folder_id'    ,
        'user_id'      ,
        'options'      ,
        'is_public'    ,
        'storage'      ,
        'real_filename',
    ];

    /**
     * @var type
     */
    protected $appends  = [ "media_path" ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author TrinhLe
     */
    public function folder()
    {
        /**
         * @var Model $this
         */
        return $this->belongsTo(MediaFolder::class, 'id', 'folder_id');
    }

    /**
     * @return int
     * @author TrinhLe
     */
    public function isShared()
    {
        return MediaShare::where('share_id', '=', $this->id)->where('share_type', '=', 'file')->count();
    }

    /**
     * Get full path media with storage
     * @author  TrinhLe
     * @return string
     */
    public function getMediaPathAttribute()
    {
        return new MediaPath($this->url, $this->storage);
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getTypeAttribute()
    {
        $type = 'document';
        if ($this->attributes['mime_type'] == 'youtube') {
            return 'video';
        }

        foreach (config('core-media.media.mime_types') as $key => $value) {
            if (in_array($this->attributes['mime_type'], $value)) {
                $type = $key;
                break;
            }
        }

        return $type;
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getHumanSizeAttribute()
    {
        return human_file_size($this->attributes['size']);
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getIconAttribute()
    {
        /**
         * @var Model $this
         */
        switch ($this->type) {
            case 'image':
                $icon = 'fas fa-image';
                break;
            case 'video':
                $icon = 'far fa-file-video';
                break;
            case 'pdf':
                $icon = 'far fa-file-pdf';
                break;
            case 'excel':
                $icon = 'far fa-file-excel';
                break;
            case 'youtube':
                $icon = 'fab fa-youtube';
                break;
            default:
                $icon = 'far fa-file-alt';
                break;
        }
        return $icon;
    }

    /**
     * @param $value
     * @return mixed
     * @author TrinhLe
     */
    public function getOptionsAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    /**
     * @author TrinhLe
     * @param $value
     */
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    /**
     * @var array
     * @author TrinhLe
     */
    public static $mimeTypes = [
        'zip' => 'application/zip',
        'mp3' => 'audio/mpeg',
        'bmp' => 'image/bmp',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'csv' => 'text/csv',
        'txt' => 'text/plain',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];

    /**
     * @author TrinhLe
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($file) {
            /**
             * @var MediaFile $file
             */
            if ($file->isForceDeleting()) {
                MediaShare::where('share_id', '=', $file->id)->where('share_type', '=', 'file')->forceDelete();
                \BFileService::deleteMedia($file);
            } else {
                MediaShare::where('share_id', '=', $file->id)->where('share_type', '=', 'file')->delete();
            }

            static::restoring(function ($file) {
                MediaShare::where('share_id', '=', $file->id)->where('share_type', '=', 'file')->restore();
            });
        });
    }

    /**
     * @param $value
     * @return array
     */
    public function getFocusAttribute($value)
    {
        try {
            return json_decode($value, true) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param $value
     * @author TrinhLe
     */
    public function setFocusAttribute($value)
    {
        $this->attributes['focus'] = json_encode($value);
    }

    /**
     * @author TrinhLe
     */
    public function __wakeup()
    {
        parent::boot();
    }
}
