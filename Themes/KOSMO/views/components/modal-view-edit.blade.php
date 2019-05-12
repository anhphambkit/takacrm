<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 9/4/18
 * Time: 17:40
 */
$classIcon = isset($classIcon) ? $classIcon : 'la la-edit ks-icon';
$idModal = isset($idModal) ? $idModal : '';
$classModal = isset($classModal) ? $classModal : '';
$content = isset($content) ? $content : '';
$title = isset($title) ? $title : env('APP_NAME');
$footer = isset($footer) ? $footer : '';
$isLargeModal = isset($isLargeModal) ? $isLargeModal : true;
$hasViewEditMode = isset($hasViewEditMode) ? $hasViewEditMode : false;
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
        background-image: none;
    }
</style>
<div @if(isset($idModal)) id="{{ $idModal }}" @endif class="modal fade modal-custom {{ $classModal }} @if($hasViewEditMode) modal-edit-custom @endif">
    <div class="modal-dialog @if($isLargeModal) modal-lg @endif">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <div class="float-right btn-modal-actions">
                    @if($hasViewEditMode)
                        <span @if(isset($idBtnSwitch)) id="{{ $idBtnSwitch }}" @endif data-action="switch-mode" data-next-edit-mode="true" class="btn-switch-mode {{ $classIcon }}"></span>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -13px !important;">
                        <span aria-hidden="true" class="la la-close"></span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                {{ $content }}
            </div>
            <div class="modal-footer d-none">
                {!! $footer !!}
            </div>
        </div>
    </div>
</div>

