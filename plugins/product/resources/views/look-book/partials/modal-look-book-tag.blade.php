<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-21
 * Time: 10:20
 */
?>

<div class="modal fade text-left" id="look-book-tag-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info white">
            <h4 class="modal-title white" id="look-book-tag-modal-label"><i class="la la-tree"></i>{{ trans('plugins-product::look-book.modal_select_product_look_book') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#look-book-tag-modal">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-body">
                <div class="row">
                    <div class="form-group col-md-12 mb-2">
                        <label class="control-label required" for="role">{{ trans('core-base::forms.category') }}</label>
                        {!! Form::select('category_id', $categories, null, ['class' => 'select2-placeholder-multiple form-control category-list', "id" => "select-category-list" ]) !!}
                    </div>
                </div>
                {{-- Image--}}
                <div class="row">
                    <div class="form-group col-md-12 mb-2">
                        <label class="control-label required" for="role">{{ trans('plugins-product::product.name') }}</label>
                        {!! Form::select('product_id', $products, null, ['class' => 'select2-placeholder-multiple form-control product-list', "id" => "select-product-list" ]) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label" for="role">Position of Tag:</label>
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">X</span>
                            </div>
                            <input type="number" min="0" max="100" step="0.01" class="form-control position-dataX" placeholder="x">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Y</span>
                            </div>
                            <input type="number" min="0" max="100" step="0.01" class="form-control position-dataY" placeholder="y">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-light" type="button" data-dismiss="modal">{{ trans('core-base::forms.cancel') }}</button>
            <button class="float-left btn btn-danger delete-look-book-tag" id="delete-tag-item" href="#">{{ trans('core-base::forms.delete') }}</button>
            <button class="btn btn-info look-book-tag-save" type="button">{{ trans('core-base::forms.save') }}</button>
        </div>
    </div>
  </div>
</div>