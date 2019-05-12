<?php
return [
    [
        'name' => trans('core-setting::permission.setting'),
        'flag' => 'setting.index',
    ],
    [
        'name' => trans('core-setting::permission.option'),
        'flag' => 'setting.option',
        'parent_flag' => 'setting.index',
    ],
    [
        'name' => trans('core-setting::permission.system'),
        'flag' => 'setting.system',
        'parent_flag' => 'setting.index',
    ],
];


