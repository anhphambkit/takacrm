<?php

namespace Core\User\Services;

use Storage;

/**
 * Class CropAvatar
 * @package Core\User\CropAvatar
 * @author TrinhLe
 */
class CropAvatar
{
    /**
     * @var mixed
     */
    protected $src;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var mixed
     */
    protected $dst;

    /**
     * @var mixed
     */
    protected $msg;

    /**
     * @var mixed
     */
    protected $props;

    /**
     * @param $src
     * @param $data
     * @param $file
     * @author TrinhLe
     */
    public function __construct($src, $data, $file)
    {
        $this->props = $file;
        $this->setData($data);
        $this->crop($this->data);
    }

    /**
     * @param $data
     * @author TrinhLe
     */
    protected function setData($data)
    {
        if (!empty($data)) {
            $this->data = json_decode(stripslashes($data));
        }
    }

    /**
     * Crop avatar and set URL, return message
     *
     * @param $data
     * @author TrinhLe
     */
    protected function crop($data)
    {
        if (!empty($data)) {
            $tmpFile = storage_path() . DIRECTORY_SEPARATOR . microtime(true) . '.' . $this->props['ext'];
            $tmpThumbFile = storage_path() . DIRECTORY_SEPARATOR . microtime(true) . '_thumb.' . $this->props['ext'];
            file_put_contents($tmpFile, Storage::read($this->props['path']));
            $type = exif_imagetype($tmpFile);
            $src_img = null;
            switch ($type) {
                case IMAGETYPE_GIF:
                    $src_img = imagecreatefromgif($tmpFile);
                    break;

                case IMAGETYPE_JPEG:
                    $src_img = imagecreatefromjpeg($tmpFile);
                    break;

                case IMAGETYPE_PNG:
                    $src_img = imagecreatefrompng($tmpFile);
                    break;
            }

            if (!$src_img) {
                $this->msg = trans('core-user::users.read_image_failed');
                return;
            }

            $dst_img = imagecreatetruecolor(220, 220);
            $result = imagecopyresampled(
                $dst_img,
                $src_img,
                0,
                0,
                $data->x,
                $data->y,
                220,
                220,
                $data->width,
                $data->height
            );

            if ($result) {
                switch ($type) {
                    case IMAGETYPE_GIF:
                        $result = imagegif($dst_img, $tmpThumbFile);
                        break;

                    case IMAGETYPE_JPEG:
                        $result = imagejpeg($dst_img, $tmpThumbFile);
                        break;

                    case IMAGETYPE_PNG:
                        $result = imagepng($dst_img, $tmpThumbFile);
                        break;
                }

                if (!$result) {
                    $this->msg = trans('core-user::profile.save_cropped_image_failed');
                    return;
                } else {
                    // cleanup
                    Storage::put($this->props['realPath'], file_get_contents($tmpThumbFile), 'public');
                    @unlink($tmpFile);
                    @unlink($tmpThumbFile);

                    $this->dst =  str_replace(basename(public_path()), '', $this->props['realPath']);
                    $this->msg = 'success';
                }
            } else {
                $this->msg = trans('core-user::profile.fail_to_crop_image');
                return;
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        } else {
            $this->msg = trans('core-user::profile.failed_to_load_data');
            return;
        }
    }

    /**
     * Get avatar URL uploaded
     * @return string
     * @author TrinhLe
     */
    public function getResult()
    {
        return !empty($this->data) ? $this->dst : $this->src;
    }

    /**
     * Get crop message: failed or successfully
     * @return string
     * @author TrinhLe
     */
    public function getMsg()
    {
        return $this->msg;
    }
}
