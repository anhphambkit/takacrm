<?php
/**
 * User: HT
 * Date: 30/8/18
 */

$title = isset($title) ? $title : env('APP_NAME');
$class = isset($class) ? $class : '';
$footer = isset($footer) ? $footer : '';
?>
<div id="{{ $id }}" class="modal fade modal-demo {{ $class }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" aria-label="Close" data-action="switch-mode" onclick="switchToEditMode('{{"#".$id }}')">
                    <span aria-hidden="true" class="la la-edit"></span>
                </button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left: -3px;">
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