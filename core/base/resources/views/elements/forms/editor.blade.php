@if (!(isset($attributes['without-buttons']) && $attributes['without-buttons'] == true))
    <div style="height: 50px;">
        @php $result = !empty($attributes['id']) ? $attributes['id'] : $name; @endphp
        <span class="editor-action-item action-show-hide-editor">
            <button class="btn btn-light show-hide-editor-btn" type="button" data-result="{{ $result }}">
                <i class="la la-plug"></i> {{ trans('core-base::forms.show_hide_editor') }}</button>
        </span>
        <span class="editor-action-item">
            <a href="#" class="btn_gallery btn btn-warning"
               data-result="{{ $result }}"
               data-multiple="true"
               data-action="media-insert-{{ setting('rich_editor', config('core-base.cms.editor.primary')) }}">
                <i class="la la-camera"></i> {{ trans('core-media::media.add') }}
            </a>
        </span>
        {!! apply_filters(BASE_FILTER_FORM_EDITOR_BUTTONS, null) !!}
    </div>
    <div class="clearfix"></div>
@endif

{!! Form::textarea($name, $value, $attributes) !!}

@if (setting('rich_editor', config('core-base.cms.editor.primary')) === 'tinymce')
    @push('master-footer')
        <script>
            function setImageValue(file) {
                $('.mce-btn.mce-open').parent().find('.mce-textbox').val(file);
            }
        </script>
        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('media.files.upload.from.editor') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden;display: none;">
            {{ csrf_field() }}
            <input name="upload" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" value="tinymce" name="upload_type">
        </form>
    @endpush
@endif
