<script type="text/javascript">
    var Lcms = Lcms || {};
    Lcms.routes = {
        home: '{{ url('/') }}',
        admin: '{{ route('admin.dashboard.index') }}',
        media: '{{ route('media.popup') }}',
        media_upload_from_editor: '{{ route('media.files.upload.from.editor') }}'
    };

    Lcms.languages = {
        'tables': {!! json_encode(trans('core-base::tables'), JSON_HEX_APOS) !!},
        'notices_msg': {!! json_encode(trans('core-base::notices'), JSON_HEX_APOS) !!},
        'pagination': {!! json_encode(trans('core-base::pagination'), JSON_HEX_APOS) !!},
        'system': {
            'character_remain': '{{ trans('core-base::forms.character_remain') }}'
        }
    };
    window.Lcms = Lcms;
</script>

@if (session()->has('success_msg') || session()->has('error_msg') || isset($errors) || isset($error_msg))
    <script type="text/javascript">
        $(document).ready(function () {
            @if (session()->has('success_msg'))
                Lcms.showNotice('success', '{{ session('success_msg') }}', Lcms.languages.notices_msg.success);
            @endif
            @if (session()->has('error_msg'))
                Lcms.showNotice('error', '{{ session('error_msg') }}', Lcms.languages.notices_msg.error);
            @endif
            @if (isset($error_msg))
                Lcms.showNotice('error', '{{ $error_msg }}', Lcms.languages.notices_msg.error);
            @endif
            @if (isset($errors))
                @foreach ($errors->all() as $error)
                   Lcms.showNotice('error', '{{ $error }}', Lcms.languages.notices_msg.error);
                @endforeach
            @endif
        });
    </script>
@endif

{!! Form::modalAction('delete-crud-modal', null , 'danger',  __('Do you want delete this item?'), 'delete-crud-entry', __('Delete')) !!}
