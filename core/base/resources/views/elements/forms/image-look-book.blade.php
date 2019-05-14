<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-20
 * Time: 10:05
 */
$typeLayout = strtolower($typeLayout);
?>
<div class="look-book-area row">
    <div class="image-look-book form-group col-md-12 mb-2">
        <input type="hidden"
               name="{{ $name }}"
               value="{{ $value }}"
               class="image-data">
        <div class="look-book-box-preview {{ "{$typeLayout}-layout" }} {{ (sizeof($tags) > 0) ? 'look-book-box-tag' : '' }}">
            <img src="{{ get_object_image($value) }}" alt="preview image" class="preview_image {{ (sizeof($tags) > 0) ? 'preview-look-book-image' : '' }}">
            @foreach($tags as $tag)
                <div class="tt-hotspot tt-tag-{{ $tag['index'] }}" style="left: {{ $tag['left'] }}%; top: {{ $tag['top'] }}%;" data-left="{{ $tag['left'] }}" data-top="{{ $tag['top'] }}" data-tag-id="{{ $tag['index'] }}">
                    <div class="tt-btn">
                        <i class="icon-tag fas fa-tag"></i>
                    </div>
                    <input type="number" hidden name="tag[{{ $tag['index'] }}][left]" value="{{ $tag['left'] }}">
                    <input type="number" hidden name="tag[{{ $tag['index'] }}][top]" value="{{ $tag['top'] }}">
                    <input type="number" hidden name="tag[{{ $tag['index'] }}][product_id]" value="{{ $tag['product_id'] }}">
                    <input type="number" hidden name="tag[{{ $tag['index'] }}][product_category_id]" value="{{ $tag['product_category_id'] }}">
                </div>
            @endforeach
        </div>

        <div class="image-box-actions">
            <a class="btn_gallery" data-result="{{ $name }}" data-action="look-book-image" data-multiple="true">
                {{ trans('core-base::forms.choose_image') }}
            </a> |
            <a class="btn_remove_look_book_image">
                {{ trans('core-base::forms.remove_image') }}
            </a>
        </div>
    </div>
</div>
