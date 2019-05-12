<?php
//dd($dataTable);
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $title }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table-admin table table-striped table-bordered table-hover vertical-middle no-footer'], true) !!}
            </div>
        </div>
    </div>
</div>

@section('script-table')
    {!! $dataTable->scripts() !!}
@stop
