<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="from-actions-bottom-right">
            @if (isset($icon) && !empty($icon))
                <i class="{{ $icon }}"></i>
            @endif
            <span>{{ isset($title) ? $title : apply_filters(BASE_ACTION_FORM_ACTIONS_TITLE, trans('core-base::forms.publish')) }}</span>
        </h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
    </div>
    <div class="card-content collpase show">
        <div class="card-body">
            <div class="btn-set">
                @php do_action(BASE_ACTION_FORM_ACTIONS, 'default') @endphp
                <button type="submit" name="submit" value="save" class="btn btn-info">
                    <i class="fa fa-save"></i> {{ trans('core-base::forms.save') }}
                </button>
                @if (!isset($only_save) || $only_save == false)
                <button type="submit" name="submit" value="apply" class="btn btn-success">
                    <i class="fa fa-check-circle"></i> {{ trans('core-base::forms.save_and_continue') }}
                </button>
                @endif
            </div>
        </div>
    </div>
</div>