<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 14:43
 */
?>
<div class="table-actions row">
    <a href="{{ route($view, $item->id) }}" class="btn btn-table-actions btn-icon btn-pure info mr-1 tip" data-original-title="{{ __('View') }}">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route($edit, $item->id) }}" class="btn btn-table-actions btn-icon btn-pure success mr-1 tip" data-original-title="{{ __('Edit') }}">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-table-actions btn-icon btn-pure danger mr-1 deleteDialog tip" data-toggle="modal" data-section="{{ route($delete, $item->id) }}" role="button" data-original-title="{{ __('Delete') }}">
        <i class="far fa-trash-alt"></i>
    </button>
</div>
