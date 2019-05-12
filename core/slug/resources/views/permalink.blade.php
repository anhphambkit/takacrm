<div id="edit-slug-box" @if (empty($value) && !$errors->has($name)) class="hidden" @endif>
    <label class="control-label required" for="current-slug">{{ trans('core-base::forms.permalink') }}:</label>
    <span id="sample-permalink">
        <a class="permalink" target="_blank" href="{{ str_replace('--slug--', $value, url($prefix . '/' . config('core-slug.general.pattern'))) }}{{ $ending_url }}">
            <span class="default-slug">{{ url($prefix) }}/<span id="editable-post-name">{{ $value }}</span>{{ $ending_url }}</span>
        </a>
    </span>
    ‎<span id="edit-slug-buttons" class="btn-group btn-group-sm">
        <button type="button" class="btn btn-light" id="change_slug">{{ trans('core-base::forms.edit') }}</button>
        <button type="button" class="save btn btn-info" id="btn-ok">{{ trans('core-base::forms.ok') }}</button>
        <button type="button" class="cancel button-link btn btn-secondary">{{ trans('core-base::forms.cancel') }}</button>
    </span>
</div>
<input type="hidden" id="current-slug" name="{{ $name }}" value="{{ $value }}">
<div data-url="{{ route('admin.slug.create') }}" data-view="{{ rtrim(str_replace('--slug--', '', url($prefix . '/' . config('core-slug.general.pattern'))), '/') . '/' }}" id="slug_id" data-id="{{ $id }}"></div>
<input type="hidden" name="slug_id" value="{{ $id }}">

<style type="text/css">
    #edit-slug-buttons{
        margin-top: 5px;
        margin-left: 2px;
    }
</style>