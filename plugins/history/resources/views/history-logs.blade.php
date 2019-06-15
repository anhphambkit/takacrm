<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-15
 * Time: 16:15
 */
?>
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
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body" id="log-history-order">
                    @if(!empty($histories))
                        @foreach($histories as $key => $groupHistory)
                            @if(!empty($groupHistory))
                                <div class="log-history-item">
                                    <div class="user-avatar-info mb-2">
                                        <div class="user-avatar">
                                            <img class="media-object rounded-circle" src="{{ $groupHistory[0]->user_image }}" alt="{{ $groupHistory[0]->user_image }}">
                                        </div>
                                        <div class="user-name-info">
                                            <div class="user-name text-bold-700">{{ $groupHistory[0]->username }}</div>
                                            <div class="created-at-log">{{ $groupHistory[0]->created_at }}</div>
                                        </div>
                                    </div>
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
                                            @foreach($groupHistory as $log)
                                                <tr>
                                                    <td>{{ $log->field_name }}</td>
                                                    <td>{{ $log->table_name }}</td>
                                                    <td>{{ find_reference_by_id($log->type)->value }}</td>
                                                    <td>{{ $log->value_origin }}</td>
                                                    <td>{{ $log->value_current }}</td>
                                                </tr>

                                                @if($loop->last)
                                                    @if($productsHistory[$log->path_session] ?? false)
                                                        <tr>
                                                            <th scope="row" colspan="5" class="text-center origin-product-logs" >Origin Products</th>
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
                                                </tbody>
                                        </table>
                                    </div>
                                    <hr />
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
