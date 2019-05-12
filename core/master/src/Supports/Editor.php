<?php

namespace Core\Master\Supports;

use Assets;
use Illuminate\Support\Arr;

class Editor
{
    /**
     * @param $name
     * @param null $value
     * @param bool $with_short_code
     * @param array $attributes
     * @return string
     * @author TrinhLe
     * @throws \Throwable
     */
    public function render($name, $value = null, $with_short_code = false, array $attributes = [])
    {
        $attributes['class'] = Arr::get($attributes, 'class', '') .
            ' editor-' .
            setting('rich_editor', config('core-base.cms.editor.primary'));

        $attributes['id'] = Arr::has($attributes, 'id') ? $attributes['id'] : $name;
        $attributes['with-short-code'] = $with_short_code;
        $attributes['rows'] = Arr::get($attributes, 'rows', 10);

        return view('core-base::elements.forms.editor', compact('name', 'value', 'attributes'))
            ->render();
    }
}
