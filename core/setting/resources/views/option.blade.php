@extends('layouts.master')
@section('content')
{!! Form::open(['route' => 'admin.setting.option']) !!}
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('Options') }}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <button type="submit" name="submit" value="save" class="btn btn-info">
                        <i class="fas fa-save"></i> {{ trans('core-base::forms.save') }}
                    </button>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="nav-vertical">
                        <ul class="nav nav-tabs nav-linetriangle nav-justified">
                            <?php
//                                dd(ThemeOption::constructSections());
                            ?>
                            @foreach(ThemeOption::constructSections() as $section)
                                <li class="nav-item">
                                    <a class="nav-link @if ($loop->first) active @endif" id="{{ $section['id'] }}-tab" data-toggle="tab" aria-controls="tab_{{ $section['id'] }}" href="#tab_{{ $section['id'] }}" aria-expanded="true">
                                        @if (!empty($section['icon']))<i class="{{ $section['icon'] }}"></i> @endif {{ $section['title']  }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            @foreach(ThemeOption::constructSections() as $section)
                                <div role="tabpanel" class="tab-pane @if ($loop->first) active @endif" id="tab_{{ $section['id'] }}" aria-labelledby="{{ $section['id'] }}-tab"  @if ($loop->first) aria-expanded="true" @endif>
                                    @foreach (ThemeOption::constructFields($section['id']) as $field)
                                        <div class="col-md-9">
                                            <div class="form-group @if ($errors->has($field['attributes']['name'])) has-error @endif">
                                            @if($field['type'] == 'editor')
                                                <label for="{{$field['attributes']['name']}}" class="control-label">{{ $field['label'] }}</label>
                                                {!! render_editor($field['attributes']['name'], theme_option($field['attributes']['name'])) !!}
                                                {!! Form::error($field['attributes']['name'], $errors) !!}
                                            @else
                                                {!! Form::label($field['attributes']['name'], $field['label'], ['class' => 'control-label']) !!}
                                                {!! ThemeOption::renderField($field) !!}
                                                @if (array_key_exists('helper', $field))
                                                    <span class="help-block">{!! $field['helper'] !!}</span>
                                                @endif
                                            @endif
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="clearfix"></div>
                            <div class="float-right">
                                <button type="submit" name="submit" value="save" class="btn btn-info">
                                    <i class="fas fa-save"></i> {{ trans('core-base::forms.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@stop