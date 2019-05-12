<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="from-actions-bottom-right">
            @if (isset($icon) && !empty($icon))
                <i class="{{ $icon }}"></i>
            @endif
            <span>{{ isset($title) ? $title : apply_filters(BASE_ACTION_FORM_ACTIONS_TITLE, trans('core-base::forms.status')) }}</span>
        </h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
    </div>
    <div class="card-content collpase show">
        <div class="card-body">
            <div class="row">
                {!! Form::select(isset($name) ? $name : 'status', isset($values) ? $values : [1 => trans('core-base::system.activated'), 0 => trans('core-base::system.disabled')], isset($selected) ? $selected : old(isset($name) ? $name : 'status', 1), ['class' => 'form-control select-full']) !!}
            </div>
        </div>
    </div>
</div>