<?php

namespace Core\Seo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MetaBox
 * @mixin \Eloquent
 */
class MetaBox extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'meta_boxes';

    /**
     * @param $value
     * @author Trinh Le
     */
    public function setMetaValueAttribute($value)
    {
        $this->attributes['meta_value'] = json_encode($value);
    }

    /**
     * @param $value
     * @return mixed
     * @author Trinh Le
     */
    public function getMetaValueAttribute($value)
    {
        return json_decode($value, true);
    }
}
