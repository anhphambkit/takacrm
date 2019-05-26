<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 13:58
 */
?>
<div class="table-actions">
    <a href="{{ $edit }}" class="btn btn-table-custom-actions btn-icon btn-pure success mr-1 tip" data-original-title="{{ __('Edit') }}">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-table-custom-actions btn-icon btn-pure danger mr-1 deleteDialog tip" data-toggle="modal" data-section="{{ $delete }}" role="button" data-original-title="{{ __('Delete') }}">
        <i class="far fa-trash-alt"></i>
    </button>
</div>
