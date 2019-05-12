@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        @include('core-base::elements.tables.datatables', [get_defined_vars()['__data']])
    </div>
</div>
@endsection