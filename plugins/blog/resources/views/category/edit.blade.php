@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.blog.category.edit', $category->id]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, BLOG_CATEGORY_MODULE_SCREEN_NAME, request(), $category) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-blog::categories.edit') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('name')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.name') }}</label>
                                        {!! Form::text('name', $category->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>

                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('slug')) has-error @endif">
                                        {!! apply_filters(BASE_FILTER_SLUG_AREA, BLOG_CATEGORY_MODULE_SCREEN_NAME, $category) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-6">
                                        <label class="control-label required" for="role">Is Default</label>
                                        {!! Form::onOff('is_default', $category->is_default) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-6">
                                        <label class="control-label required" for="role">Is Featured</label>
                                        {!! Form::onOff('is_featured', $category->is_featured) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('parent_id')) has-error @endif">
                                        <label class="control-label required" for="role">Parent</label>
                                        {!! Form::select('parent_id', $categories, $category->parent_id, ['class' => 'form-control roles-list']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                        <label for="name">{{ trans('Description') }}</label>
                                        {!! Form::textarea('description', $category->description, ['class' => 'form-control', 'rows' => 4, 'id' => 'description', 'placeholder' => trans('Description'), 'data-counter' => 400]) !!}
                                        {!! Form::error('description', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, BLOG_CATEGORY_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status', ['selected' => $category->status])
                @php do_action(BASE_ACTION_META_BOXES, BLOG_CATEGORY_MODULE_SCREEN_NAME, 'top', $category) @endphp
                @php do_action(BASE_ACTION_META_BOXES, BLOG_CATEGORY_MODULE_SCREEN_NAME, 'side', $category) @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop