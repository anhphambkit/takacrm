<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 21:04
 */
?>

<div class="card order-list-table-card">
    <div class="card-header">
        <button type="button" class="btn btn-info mr-1">
            <a href="{{ route('admin.order.create') }}" class="link-create-new-order text-white">
                <i class="fas fa-user"></i> {{ trans('plugins-order::order.create') }}
            </a>
        </button>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collpase show">
        <div class="card-body">
            <div class="row filter-status">
                <div class="col-md-6 row-filter-status">
                    <button type="button" class="btn btn-dark mr-1 btn-filter-status-all btn-filter-status btn-filter-custom" data-filter-type="all">
                        {{ trans('plugins-order::order.all') }}
                    </button>
                    @foreach($orderStatuses as $orderStatus)
                        <button type="button" class="btn btn-light mr-1 btn-filter-status btn-filter-custom" data-filter-type="order_status" data-filter-value="{{ $orderStatus->id }}">
                            {{ $orderStatus->value }}
                        </button>
                    @endforeach
                        @foreach($paymentOrderStatuses as $paymentOrderStatus)
                            <button type="button" class="btn btn-light mr-1 btn-filter-status btn-filter-custom" data-filter-type="payment_status" data-filter-value="{{ $paymentOrderStatus->id }}">
                                {{ $paymentOrderStatus->value }}
                            </button>
                        @endforeach
                </div>
                <div class="col-md-6 row-filter-status">

                </div>
            </div>
            <table id="order-table" class="b-table-custom table table-bordered table-striped order-list-table" width="100%">
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Order Date</th>
                        <th>Order Code</th>
                        <th>Customer Code</th>
                        <th>Customer Name</th>
                        <th>Customer Address</th>
                        <th>Sales</th>
                        <th>VAT</th>
                        <th>Discount</th>
                        <th>Revenue</th>
                        <th>Paid</th>
                        <th>Remaining Amount</th>
                        <th>Profit</th>
                        <th>Lading Code</th>
                        <th>Created by</th>
                        <th>Created at</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
