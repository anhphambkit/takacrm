<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-27
 * Time: 08:28
 */
?>
<div class="modal fade text-left" id="business-space-modal" tabindex="-1" role="dialog" aria-labelledby="businessSpaceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info white">
                <h4 class="modal-title white" id="business-space-modal-label"><i class="la la-tree"></i>{{ trans('plugins-product::look-book.modal_select_business_space') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#business-space-modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label required" for="role">{{ trans('core-base::forms.business_type') }}</label>
                            {!! Form::select('business_type_id', $categories, null, ['class' => 'select2-placeholder-multiple form-control business-type-list', "id" => "select-business-type-list" ]) !!}
                        </div>
                    </div>
                    {{-- Image--}}
                    <div class="row">
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label required" for="role">{{ trans('plugins-product::product.space') }}</label>
                            {!! Form::select('space_id', $products, null, ['class' => 'select2-placeholder-multiple form-control space-list', "id" => "select-space-list" ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">{{ trans('core-base::forms.cancel') }}</button>
                <button class="float-left btn btn-danger delete-space-business" id="delete-tag-item" href="#">{{ trans('core-base::forms.delete') }}</button>
                <button class="btn btn-info business-space-save" type="button">{{ trans('core-base::forms.save') }}</button>
            </div>
        </div>
    </div>
</div>
