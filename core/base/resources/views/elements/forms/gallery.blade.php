<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-21
 * Time: 17:24
 */
$value = !empty($value) ? ((!is_array($value)) ? json_decode($value) : $value) : [];
?>
{!! Form::hidden($name, $value ? json_encode($value) : null, ['id' => 'gallery-data', 'class' => 'form-control']) !!}
<div>
    <div class="list-photos-gallery">
        <div class="row">
            @if (!empty($value))
                @foreach ($value as $key => $item)
                    <div class="col-md-2 col-sm-3 col-4 photo-gallery-item" data-id="{{ $key }}">
                        <div class="gallery_image_wrapper">
                            <img src="{{ get_object_image($item, 'mediumThumb') }}" alt="media">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
        <a href="#" class="btn_select_gallery">{{ trans('core-base::forms.choose_image') }}</a>&nbsp;
        <a href="#" class="text-danger reset-gallery @if (empty($value)) hidden @endif">{{ trans('core-base::forms.remove_image') }}</a>
    </div>
</div>

<div id="edit-gallery-item" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title"><i class="til_img"></i><strong>{{ trans('core-base::gallery.delete_image_gallery') }}</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-footer">
                <button class="float-left btn btn-danger" id="delete-gallery-item" href="#">{{ trans('core-base::gallery.delete_photo') }}</button>
                <button class="float-right btn btn-secondary" data-dismiss="modal">{{ trans('core-base::forms.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- end Modal -->
