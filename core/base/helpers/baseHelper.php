<?php
use Carbon\Carbon;

if (!function_exists('format_time')) {
    /**
     * @param DateTime $timestamp
     * @param $format
     * @return mixed
     * @author TrinhLe
     */
    function format_time(DateTime $timestamp, $format = 'j M Y H:i')
    {
        $first = Carbon::create(0000, 0, 0, 00, 00, 00);
        if ($timestamp->lte($first)) {
            return '';
        }

        return $timestamp->format($format);
    }
}

if (!function_exists('format_date_time')) {
    /**
     * @param $datetime
     * @param string $timezone
     * @param string $format
     * @param string $formatOutput
     * @return Carbon
     */
    function format_date_time($datetime, string $timezone = 'Asia/Ho_Chi_Minh', string $format = 'Y-m-d H:i:s', string $formatOutput = "Y-m-d")
    {
        $serverTimezone = \Config::get('app.timezone');
        return Carbon::createFromFormat($format, $datetime, $timezone)->setTimezone($serverTimezone)->format($formatOutput);
    }
}

if (!function_exists('date_from_database')) {
    /**
     * @param $time
     * @param string $format
     * @return mixed
     * @author TrinhLe
     */
    function date_from_database($time, $format = 'Y-m-d')
    {
        return format_time(Carbon::parse($time), $format);
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
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return number_format($bytes, $precision, ',', '.') . ' ' . $units[$pow];
    }
}

if (!function_exists('string_limit_words')) {
    /**
     * @param $string
     * @param $limit
     * @return string
     * @author TrinhLe
     */
    function string_limit_words($string, $limit)
    {
        $ext = null;
        if (strlen($string) > $limit) {
            $ext = '...';
        }
        $string = substr($string, 0, $limit);
        return $string . $ext;
    }
}

if (!function_exists('testHelper')) {
    /**
     * @author TrinhLe
     */
    function testHelper()
    {
        return view('core-base::base')->render();
    }
}

if (function_exists('showImgStorage') === false) {
	/**
	 * Get image
	 * @param type $image 
	 * @param type|string $default
	 * @author TrinhLe 
	 * @return string
	 */
    function showImgStorage($image, $default = 'system/images/default-avatar.png')
    {
        if(!empty($image))
        	return "/storage/{$image}";

        if($default !== false)
            return "/storage/{$default}";
    }
}

if (!function_exists('table_status')) {
    /**
     * @param $selected
     * @param array $statuses
     * @return string
     * @internal param $status
     * @internal param null $activated_text
     * @internal param null $deactivated_text
     * @author TrinhLe
     */
    function table_status($selected, $statuses = [])
    {
        if (empty($statuses) || !is_array($statuses)) {
            $statuses = [
                0 => [
                    'class' => 'btn-danger',
                    'text' => __('Deactivated'),
                ],
                1 => [
                    'class' => 'btn-info',
                    'text' => __('Activated'),
                ],
            ];
        }
        return view('core-base::elements.tables.status', compact('selected', 'statuses'))->render();
    }
}