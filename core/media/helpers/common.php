<?php

if (!function_exists('is_image')) {
    /**
     * Is the mime type an image
     *
     * @param $mimeType
     * @return bool
     * @author TrinhLe
     */
    function is_image($mimeType)
    {
        return starts_with($mimeType, 'image/');
    }
}

if (!function_exists('get_image_url')) {
    /**
     * @param $url
     * @param $size
     * @param bool $relative_path
     * @param null $default
     * @return mixed
     * @author TrinhLe
     */
    function get_image_url($url, $thumbnail = null, $relative_path = false, $default = null)
    {
        if (empty($url)) {
            return $default;
        }

        if($thumbnail && \BFileService::isImage($url))
        {
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            $dirname   = pathinfo($url, PATHINFO_DIRNAME);
            $filename  = pathinfo($url, PATHINFO_FILENAME);
            $url = "{$dirname}/{$filename}_{$thumbnail}.{$extension}";
        }

        if ($relative_path) {
            return $url;
        }
        return url($url);
    }
}

if (!function_exists('get_object_image')) {
    /**
     * @param $image
     * @param null $size
     * @param bool $relative_path
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function get_object_image($image, $size = null, $relative_path = false)
    {
        if (!empty($image)) {
            if (empty($size) || $image == '__value__') {
                if ($relative_path) {
                    return $image;
                }
                return url($image);
            }
            return get_image_url($image, $size, $relative_path);
        } else {
            return get_image_url(config('core-media.media.default-img'), $size, $relative_path);
        }
    }
}

if (!function_exists('rv_media_handle_upload')) {
    /**
     * @param $fileUpload
     * @param int $folder_id
     * @author TrinhLe
     * @return array|\Illuminate\Http\JsonResponse
     */
    function rv_media_handle_upload($fileUpload, $folder_id = 0) {
        return RvMedia::handleUpload($fileUpload, $folder_id);
    }
}

if (!function_exists('rv_get_image_list')) {
    /**
     * @param array $imagesList
     * @param array $sizes
     * @return array
     */
    function rv_get_image_list(array $imagesList, array $sizes)
    {
        $result = [];
        foreach ($sizes as $size) {
            $images = [];

            foreach ($imagesList as $url) {
                $images[] = get_image_url($url, $size);
            }

            $result[$size] = $images;
        }

        return $result;
    }
}

if (!function_exists('human_file_size')) {
    /**
     * @param $bytes
     * @param int $precision
     * @return string
     * @author TrinhLe
     */
    function human_file_size($bytes, $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return number_format($bytes, $precision, ',', '.') . ' ' . $units[$pow];
    }
}