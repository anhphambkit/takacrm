<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 8/8/18
 * Time: 15:34
 */

$title = isset($title) ? $title : env('APP_NAME');
$class = isset($class) ? $class : '';
$footer = isset($footer) ? $footer : '';
$isLargeModal = isset($isLargeModal) ? $isLargeModal : true;
?>
<div id="{{ $id }}" class="modal fade modal-custom {{ $class }}">
    <div class="modal-dialog @if($isLargeModal) modal-lg @endif">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-close"></span>
                </button>
            </div>
            <div class="modal-body">
          
                {!! $content !!}
            </div>
            <div class="modal-footer d-none">
                {!! $footer !!}
            </div>
        </div>
    </div>
</div>