<?php
namespace Core\Media\Requests;

use Core\Master\Requests\CoreRequest;

class MediaFolderRequest extends CoreRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[\pL\s\ \_\-0-9]+$/u'
        ];
    }
}