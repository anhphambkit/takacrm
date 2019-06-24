<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-27
 * Time: 11:27
 */
$attributeOptions = !empty(old('attribute_options')) ? old('attribute_options') : (!empty($attributeOptions) ? $attributeOptions : []);
$typeRenderAttribute = !empty(old('type_render')) ? old('type_render') : (!empty($typeRenderAttribute) ? $typeRenderAttribute : '');
$hasOptions = ($typeRenderAttribute === 'checkbox' || $typeRenderAttribute === 'radio' || $typeRenderAttribute === 'single_select' || $typeRenderAttribute === 'multiple_select');
?>
<div class="list-option-area @if ($errors->has('attribute_options')) has-error @endif" @if(!$hasOptions) style="display: none" @endif>
    {!! Form::error('attribute_options', $errors) !!}
    <div class="options-area">
        @foreach($attributeOptions as $key => $attributeOption)
            <div class="row option-attribute option-attribute-{{$key}}">
                <div class="form-group col-md-6 @if ($errors->has("attribute_options[{$key}]")) has-error @endif">
                    <label class="control-label required" for="role">{{ trans('plugins-custom-attributes::custom-attributes.form.option') }}</label>
                    {!! Form::text("attribute_options[{$key}]", !empty(old("attribute_options[{$key}]")) ? old("attribute_options[{$key}]") : $attributeOption, ['class' => "form-control option-attribute-name option-attribute-{$key}", 'id' => "option-attribute-{$key}", 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 250]) !!}
                    {!! Form::error("attribute_options.{$key}", $errors) !!}
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label" for="action-space">{{ trans('core-base::forms.action') }}</label>
                    <div class="action-option-area">
                        <a class="action-option delete-option-action delete-option delete-option-{{$key}}" data-option-index="{{$key}}">
                            <i class="far fa-trash-alt icon-option-delete"></i>
                            {{ trans('core-base::forms.delete') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="action-area">
        <div class="row">
            <div class="col-md-4 form-group action-add-option-attribute">
                <a class="action-option-attribute add-option">
                    <i class="fas fa-plus icon-add-option"></i>
                    {{ trans('core-base::forms.add') }}
                </a>
            </div>
        </div>
    </div>
</div>