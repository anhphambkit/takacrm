<?php

namespace Core\Media\Requests;

use Core\Master\Requests\CoreRequest;

class MediaFileRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
        $rules = [];
        $files = $this->file('file', []);

        if (!empty($files)) {
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $key => $file) {
                $rules['file.' . $key] = 'required|mimes:' . config('core-media.media.allowed_mime_types');
            }
        }

        return $rules;
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function attributes()
    {
        $files = $this->file('file', []);
        $attributes = [];
        if (!empty($files)) {
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $key => $file) {
                $attributes['file.' . $key] = 'file';
            }
        }

        return $attributes;
    }
}