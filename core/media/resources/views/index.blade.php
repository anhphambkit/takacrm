@extends('layouts.master')
@section('master-head')
	{!! BMedia::renderHeader() !!}
@endsection
@section('content')
	{!! BMedia::renderContent() !!}
@endsection

@section('master-footer')
    {!! BMedia::renderFooter() !!}
@endsection

<!-- Ignore media modal -->
@section('script-media')
@endsection