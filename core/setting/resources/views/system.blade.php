@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.setting.system']]) !!}
    	<div class="col-xl-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('System Settings') }}</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<ul class="nav nav-tabs nav-linetriangle nav-justified">
							@foreach ($settings as $tab_id => $tab)
				                <li class="nav-item">
									<a class="nav-link @if ($loop->first) active @endif" id="tab-{{ $tab_id }}" data-toggle="tab" href="#{{ $tab_id }}" aria-controls="{{ $tab_id }}" aria-expanded="true">
										<i class="ft-heart"></i> {{ $tab['name'] }}
									</a>
								</li>
				            @endforeach
						</ul>
						<div class="tab-content px-1 pt-1">
							@foreach ($settings as $tab_id => $tab)
								<div role="tabpanel" class="tab-pane @if ($loop->first) active @endif" id="{{ $tab_id }}" aria-labelledby="tab-{{ $tab_id }}"  @if ($loop->first) aria-expanded="true" @endif>
									@foreach ($tab['settings'] as $key => $setting)
				                    <div class="col-md-6">
				                        <div class="form-group @if ($errors->has($setting['attributes']['name'])) has-error @endif">
				                            {!! Form::label($setting['attributes']['name'], $setting['label'], ['class' => 'control-label']) !!}
				                            {!! Setting::render($setting) !!}
				                            @if (array_key_exists('helper', $setting))
				                                <span class="help-block">{!! $setting['helper'] !!}</span>
				                            @endif
				                            {!! Form::error($setting['attributes']['name'], $errors) !!}
				                        </div>
				                        <div class="clearfix"></div>
				                    </div>
				                    @endforeach
								</div>
				            @endforeach
				            <div class="clearfix"></div>
				            <div class="text-center">
				                <button type="submit" name="submit" value="save" class="btn btn-info">
				                    <i class="fas fa-save"></i> {{ trans('core-base::forms.save') }}
				                </button>
				            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
    {!! Form::close() !!}
@stop