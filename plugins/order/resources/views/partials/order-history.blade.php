<?php
    $colors = [
        'success',
        'info',
        'warning',
        'danger'
    ];
    $indexColor = 0;
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ trans('Histories') }}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body" id="log-history-order">
                    @if(!empty($histories))
                        @foreach($histories as $key => $groupHistory)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>FieldName</th>
                                            <th>TableName</th>
                                            <th>Action</th>
                                            <th>Origin</th>
                                            <th>Current</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($groupHistory))
                                            @foreach($groupHistory as $log)
                                                <tr>
                                                    <td>{{ $log->field_name }}</td>
                                                    <td>{{ $log->table_name }}</td>
                                                    <td>{{ find_reference_by_id($log->type)->value }}</td>
                                                    <td>{{ $log->value_origin }}</td>
                                                    <td>{{ $log->value_current }}</td>
                                                </tr>

                                                @if($loop->last)
                                                    <tr>
                                                        <th scope="row">Author</th>
                                                        <th scope="row" colspan="2" class="text-center">
                                                            <img class="media-object rounded-circle" src="{{ $log->user_image }}" alt="Generic placeholder image" style="width: 48px;height: 48px;">
                                                            {{ $log->username }}
                                                        </th>
                                                        <th scope="row">CreatedAt</th>
                                                        <th scope="row">{{ $log->created_at }}</th>
                                                    </tr>

                                                    @if($productsHistory[$log->path_session] ?? false)
                                                        <tr>
                                                            <th scope="row" colspan="5" class="text-center" >Origin Products</th>
                                                        </tr>
                                                        <thead>
                                                            <tr>
                                                                <th>#ID / Name</th>
                                                                <th>Quantity</th>
                                                                <th>Retail Price</th>
                                                                <th>Vat</th>
                                                                <th>Total Price</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach($productsHistory[$log->path_session] as $productLog)
                                                            @php
                                                                $productLogInfo = json_decode($productLog->json_product);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $productLogInfo->product_id }} / {{ $productLogInfo->name }}</td>
                                                                <td>{{ $productLogInfo->quantity }}</td>
                                                                <td>{{ $productLogInfo->retail_price }}</td>
                                                                <td>{{ $productLogInfo->vat }}</td>
                                                                <td>{{ $productLogInfo->total_price }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>