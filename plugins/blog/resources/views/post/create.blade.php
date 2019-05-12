@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.blog.post.create']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, BLOG_POST_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-blog::posts.create') }}</h4>
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
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('slug')) has-error @endif">
                                        {!! apply_filters(BASE_FILTER_SLUG_AREA, BLOG_POST_MODULE_SCREEN_NAME) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('tag')) has-error @endif">
                                        <label for="name">{{ trans('plugins-blog::posts.form.tags_placeholder') }}</label>
                                        <div class="clearfix"></div>
                                        {!! Form::text('tag', old('tag'), ['class' => 'form-control', 'id' => 'tags', 'data-role' => 'tagsinput', 'placeholder' => trans('plugins-blog::posts.form.tags_placeholder')]) !!}
                                        {!! Form::error('tag', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                        <label for="name">{{ trans('Description') }}</label>
                                        {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 4, 'id' => 'description', 'placeholder' => trans('Description'), 'data-counter' => 400]) !!}
                                        {!! Form::error('description', $errors) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('content')) has-error @endif">
                                        <label for="content">{{ trans('plugins-faq::faq.forms.content') }}</label>
                                        {!! render_editor('content', old('content'), true) !!}
                                        {!! Form::error('content', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, BLOG_POST_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status')

                @include('plugins-blog::category.partials.categories-multi', [
                    'name' => 'categories[]',
                    'title' => trans('plugins-blog::posts.form.categories'),
                    'value' => old('categories', []),
                    'categories' => $categories,
                    'object' => null
                ])

                <div class="widget meta-boxes">
                    <div class="widget-title">
                        <h4><span class="required">Post Image</span></h4>
                    </div>
                    <div class="widget-body">
                        {!! Form::mediaImage('image', old('image')) !!}
                        {!! Form::error('image', $errors) !!}
                    </div>
                </div>

                @php do_action(BASE_ACTION_META_BOXES, BLOG_POST_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, BLOG_POST_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop