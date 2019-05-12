<?php
namespace Core\Master\Requests;

use Illuminate\Support\Str;

trait FormatMessageTrait
{
	/**
     * Description
     * @param type &$errors 
     * @author TrinhLe
     * @return mixed
     */
    protected function customErrors($errors)
    {
        foreach($errors as $error => &$value)
        {
            $this->formatMessage($error, $value);
        }

        return $errors;
    }

    /**
     * Description
     * @param type $error 
     * @param type &$value 
     * @author TrinhLe
     * @return string
     */
    protected function formatMessage($error, &$value)
    {
        $str = '';
        $keys = explode('_', $error);
        $replace = '';
        foreach($keys as $key)
        {
            $replace .= ' ' . $key;
            $specialKey = explode('.', $key);
            if(count($specialKey) > 1)
            {
                foreach($specialKey as $key)
                {
                    $str  .= ' ' . Str::ucfirst($key);
                }
                continue;
            }
            $str .= ' ' . Str::ucfirst($key);
        }
        $value = str_replace(ltrim($replace),ltrim($str),$value);
    }
}