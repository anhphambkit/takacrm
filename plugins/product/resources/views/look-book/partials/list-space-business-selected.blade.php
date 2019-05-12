<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-27
 * Time: 08:28
 */
$businessTypesArray = $businessTypes;
reset($businessTypesArray);
$defaultBusinessType = key($businessTypesArray);
$businessSpaces = !empty($businessSpaces) ? $businessSpaces : [];

$allSpaces = !empty($allSpaces) ? $allSpaces : [];
?>
<div class="space-business-select-area">
    <div class="render-space-apply-all-selected render-space-selected mb-2 border" style="{{ (empty($allSpaces)) ? 'display: none;' : '' }}">
        <h4 class="card-title" id="title-space-apply-all">{{ trans('plugins-product::look-book.space_for_apply_all') }}</h4>
        @foreach($allSpaces as $keyAll => $allSpace)
            <div class="row all-space-row all-space-row-{{$keyAll}}">
                <div class="form-group col-md-5 mb-2 @if ($errors->has('space_id')) has-error @endif">
                    <label class="control-label required" for="select-space">{{ trans('plugins-product::product.form.space') }}</label>
                    {!! Form::select("all_space[{$keyAll}][space_id]", $spaces, $allSpace['space_id'], ['class' => "select2-placeholder-multiple form-control select-all-space-{$keyAll} select-all-space-list", 'data-all-space-index' => $keyAll, 'data-init-all-space-id' => $allSpace['space_id'] ]) !!}
                    {!! Form::error("all_space[{$keyAll}][space_id]", $errors) !!}
                </div>
                <div class="form-group col-md-2 mb-2">
                    <label class="control-label" for="action-space">{{ trans('plugins-product::space.form.action') }}</label>
                    <div class="action-space-area">
                        <a class="action-space delete-space-action delete-all-space delete-all-space-{{$keyAll}}" data-all-space-index="{{$keyAll}}">
                            <i class="far fa-trash-alt icon-business-space-delete"></i>
                            {{ trans('core-base::forms.delete') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="render-space-business-specific-selected render-space-selected mb-2 border" style="{{ (empty($businessSpaces)) ? 'display: none;' : '' }}">
        <h4 class="card-title" id="title-specific-space">{{ trans('plugins-product::look-book.specific_space') }}</h4>
        @foreach($businessSpaces as $key => $businessSpace)
            <div class="row business-space-row business-space-row-{{$key}}">
                <div class="form-group col-md-5 mb-2 @if ($errors->has('business_type_id')) has-error @endif">
                    <label class="control-label required" for="select-business-type">{{ trans('plugins-product::product.form.business_type') }}</label>
                    {!! Form::select("space_business[{$key}][business_type_id]", $businessTypes, $businessSpace['business_type_id'], ['class' => "select2-placeholder-multiple form-control select-business-type-{$key} select-business-type-list", 'data-business-type-index' => $key ]) !!}
                    {!! Form::error("space_business[{$key}][business_type_id]", $errors) !!}
                </div>
                <div class="form-group col-md-5 mb-2 @if ($errors->has('space_id')) has-error @endif">
                    <label class="control-label required" for="select-space">{{ trans('plugins-product::product.form.space') }}</label>
                    {!! Form::select("space_business[{$key}][space_id]", $spaces, $businessSpace['space_id'], ['class' => "select2-placeholder-multiple form-control select-space-{$key} select-space-list", 'data-space-index' => $key, 'data-init-space-id' => $businessSpace['space_id'] ]) !!}
                    {!! Form::error("space_business[{$key}][space_id]", $errors) !!}
                </div>
                <div class="form-group col-md-2 mb-2">
                    <label class="control-label" for="action-space">{{ trans('plugins-product::space.form.action') }}</label>
                    <div class="action-space-area">
                        {{--<a class="action-space edit-business-space edit-business-space-{{$key}}" data-business-space-index="{{$key}}">--}}
                            {{--<i class="far fa-edit icon-business-space-edit"></i>--}}
                            {{--{{ trans('core-base::forms.edit') }}--}}
                        {{--</a>--}}
                        <a class="action-space delete-space-action delete-business-space delete-business-space-{{$key}}" data-business-space-index="{{$key}}">
                            <i class="far fa-trash-alt icon-business-space-delete"></i>
                            {{ trans('core-base::forms.delete') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="form-group col-md-3 mb-2">
            <button type="button" class="btn btn-info add-space-business dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ trans('plugins-product::space.form.add_space') }}
            </button>
            <div class="dropdown-menu arrow">
                <button class="dropdown-item add-space-apply-all" type="button">Space Apply All</button>
                <button class="dropdown-item add-specific-space" type="button">Specific Space</button>
            </div>
        </div>
    </div>
</div>
