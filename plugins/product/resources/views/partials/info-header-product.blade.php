<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 14:04
 */
?>
<div class="card info-header-product">
    <div class="card-header">
        <div class="card-title row" id="from-actions-bottom-right">
            <div class="col-md-4">
                <div class="product-avatar-info">
                    <span class="product-avatar">
                        <img src="{{ get_object_image($product->image_feature, 'mediumThumb') }}" alt="avatar">
                    </span>
                    <span class="product-name-info">
                        <span class="product-name text-bold-700">{{ $product->name }}</span>
                        <span class="edit-action btn-action-product-custom ">
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-icon btn-pure success tip" data-original-title="{{ __('Edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </span>
                        <span class="delete-action btn-action-product-custom ">
                            <button type="button" class="btn btn-icon btn-pure danger deleteDialog tip" data-toggle="modal" data-section="{{ route('admin.product.delete', $product->id) }}" role="button" data-original-title="{{ __('Delete') }}">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-8">
            </div>
        </div>
    </div>
</div>
