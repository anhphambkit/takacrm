@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        @include('core-base::elements.tables.datatables', ['title' => __('Users'), 'dataTable' => $dataTable ])
    </div>

    <!-- Form modal -->
    <div id="add_super_user" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info white">
                    	<h4 class="modal-title white" id="myModalLabel11"><i class="la la-tree"></i>{{ trans('core-base::system.user.add_user') }}</h4>
			            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#add_super_user">
			                <span aria-hidden="true">&times;</span>
			            </button>
                    </div>

                    {!! Form::open(['route' => ['admin.super-user.create']]) !!}
                    <div class="modal-body with-padding">
                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                            <label>{{ trans('core-base::system.user.email') }}</label>
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            {!! Form::error('email', $errors) !!}
                        </div>

                        <div class="form-actions text-right">
                            <button data-dismiss="modal"
                                    class="btn btn-light">{{ trans('core-base::system.user.cancel') }}</button>
                            <button type="submit" class="btn btn-info">{{ trans('core-base::system.user.create') }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /form modal -->

</div>
@endsection