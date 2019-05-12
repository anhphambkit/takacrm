@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        @include('core-base::elements.tables.datatables', ['title' => __('Roles'), 'dataTable' => $dataTable ])
    </div>
</div>
@endsection