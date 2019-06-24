<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-10
 * Time: 23:22
 */
$routeEdit = !empty($routeEdit) ? $routeEdit : '#';
?>
<div class="card">
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="btn-set">
                <a href="{{ $routeEdit }}" class="btn btn-info btn-edit-order">
                    <i class="fas fa-edit"></i> {{ trans('core-base::forms.edit') }}
                </a>
            </div>
        </div>
    </div>
</div>
