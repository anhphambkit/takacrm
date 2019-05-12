<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-05
 * Time: 08:41
 */
?>
<div class="modal fade text-left" id="update-query-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info white">
                <h4 class="modal-title white" id="update-query-modal-label"><i class="la la-tree"></i>{{ trans('plugins-customer::customer.update_query') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#update-query-modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label required" for="role">{{ trans('plugins-customer::customer.query_name') }}</label>
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'update_query_name', 'data-counter' => 255, 'placeholder' => trans('plugins-customer::customer.query_name')]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">{{ trans('core-base::forms.cancel') }}</button>
                <button class="btn btn-info update-query-btn-modal" type="button">{{ trans('core-base::forms.update') }}</button>
            </div>
        </div>
    </div>
</div>
