<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 9/3/18
 * Time: 22:25
 */
$classIconSwitch = isset($classIconSwitch) ? $classIconSwitch : 'la la-edit ks-icon';
$classCard = isset($classCard) ? $classCard : '';
$idCard = isset($idCard) ? $idCard : '';
$classForm = isset($classForm) ? $classForm : '';
$btnDefaultActions = isset($btnDefaultActions) ? $btnDefaultActions : true;
?>
<style>
    .btn-switch-mode {
        cursor: pointer;
    }
    .view-mode-custom > label {
        margin-bottom: 0.5rem !important;
    }
    .view-mode-custom > input, .view-mode-custom > select, .view-mode-custom > textarea {
        border: none !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        background-color: inherit !important;
        resize: none !important;
        -webkit-appearance: none !important;
        height: fit-content !important;
    }
</style>
<div class="card-view-edit card ks-card-widget ks-widget-payment-table {{ $classCard }}" id="{{ $idCard }}">
    <h5 class="card-header">
        <span class="ks-text">{{ $title }}</span>
        <span data-action="switch-mode" data-next-edit-mode="true" class="btn-switch-mode {{ $classIconSwitch }}"></span>
    </h5>
    <div class="card-block">
        <form id="{{ $idForm }}" class="form-view-edit-mode {{ $classForm }}'">
            {{ $contentForm }}
            @if($btnDefaultActions)
                <div class="row row-actions">
                    <fieldset class="form-group form-button text-right col-md-12">
                        <button class="btn btn-primary" type="button" data-btn-action="edit" data-control="submit">{{ trans('theme::theme.default_title.update') }}</button>
                        <button class="btn btn-cancel" type="button" data-btn-action="edit" data-control="cancel">{{ trans('theme::theme.default_title.cancel') }}</button>
                    </fieldset>
                </div>
            @endif
        </form>
    </div>
</div>

