<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title>{{ trans('frontend::frontend.title_page.agoyu') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @foreach($cssFiles as $css)
        <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset($css) }}">
    @endforeach
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('styles')
</head>
<!-- END HEAD -->

<body class="ks-navbar-fixed ks-sidebar-default ks-sidebar-position-fixed ks-page-header-fixed ks-theme-primary ks-page-loading">

@section('content')
    <div id="theme-option-header">
        <div class="display_header">
            <h2>{{ __('Theme options') }}</h2>
            @if (ThemeOption::getArg('debug') == true) <span class="theme-option-dev-mode-notice">{{ __('Developer Mode Enabled') }}</span>@endif
        </div>
        <div class="clearfix"></div>
    </div>
    <div id="theme-option-intro-text">This is the theme option for the frontend UMH's website, please make sure that you can control what you changes.
    </div>
    <div class="theme-option-container">
        <div class="theme-option-sidebar">
            <ul class="nav nav-tabs tab-in-left">
                @foreach(ThemeOption::constructSections() as $section)
                    <li @if ($loop->first) class="active" @endif>
                        <a href="#tab_{{ $section['id'] }}" data-toggle="tab">@if (!empty($section['icon']))<i class="{{ $section['icon'] }}"></i> @endif {{ $section['title']  }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="theme-option-main">
            {!! Form::open([]) !!}
            <div class="tab-content tab-content-in-right">
                <div class="theme-option-sticky">
                    <div class="info_bar">
                        <div class="theme-option-action_bar">
                            <span class="fa fa-spin fa-spinner hidden"></span>
                            <input type="submit" class="btn btn-primary" value="Save Changes">
                            {{--<input type="submit" class="btn btn-info" value="Reset Section">
                            <input type="submit" class="btn btn-info" value="Reset All">--}}
                        </div>
                    </div>
                </div>
                @foreach(ThemeOption::constructSections() as $section)
                    <div class="tab-pane @if ($loop->first) active @endif" id="tab_{{ $section['id'] }}">
                        @foreach (ThemeOption::constructFields($section['id']) as $field)
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
                        @endforeach
                    </div>
                @endforeach
                <div class="theme-option-sticky sticky-bottom">
                    <div class="info_bar">
                        <div class="theme-option-action_bar">
                            <span class="fa fa-spin fa-spinner hidden"></span>
                            <input type="submit" class="btn btn-primary" value="Save Changes">
                            {{--<input type="submit" class="btn btn-info" value="Reset Section">
                            <input type="submit" class="btn btn-info" value="Reset All">--}}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@show
@foreach($jsFiles as $js)
    <script src="{{ URL::asset($js) }}" type="text/javascript"></script>
@endforeach
@yield('plugin-scripts')

@yield('scripts')
</body>
</html>