<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 08:40
 */
?>

<div class="table-actions">
	<a href="{{ route($manage, [ 'attributeId' => $item->id ]) }}" class="btn btn-table-custom-actions btn-icon btn-pure info mr-1 tip" data-original-title="{{ __('Manage') }}">
        <i class="fas fa-list"></i>
	</a>
    <a href="{{ route($edit, $item->id) }}" class="btn btn-table-custom-actions btn-icon btn-pure success mr-1 tip" data-original-title="{{ __('Edit') }}">
        <i class="fas fa-edit"></i>
	</a>
	<button type="button" class="btn btn-table-custom-actions btn-icon btn-pure danger mr-1 deleteDialog tip" data-toggle="modal" data-section="{{ route($delete, $item->id) }}" role="button" data-original-title="{{ __('Delete') }}">
        <i class="far fa-trash-alt"></i>
    </button>
</div>