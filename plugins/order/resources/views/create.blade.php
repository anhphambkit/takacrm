@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.order.create']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, ORDER_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-order::order.create') }}</h4>
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
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tìm kiếm Khách hàng đã có trên hệ thống</label>
                                            <div class="input-group">
                                                <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                                                    <option selected>Choose...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label>Tên khách hàng</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Điện thoại</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label>Địa chỉ</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Người thực hiện (*)</label>
                                                    <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                                                        <option selected>Choose...</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Ngày đặt hàng</label>
                                                    <input type="text" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nguồn đơn hàng</label>
                                                    <div class="input-group">
                                                        <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                                                            <option selected>Choose...</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Mã ĐH</label>
                                                    <input type="text" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Phương thức thanh toán</label>
                                                    <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                                                        <option selected>Choose...</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Mã vận đơn</label>
                                                    <input type="text" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--div class="form-group col-md-12 mb-2 @if ($errors->has('name')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.name') }}</label>
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div-->
                                </div>

                                <div class="row">
                                    <div class="form-group" style="width: 100%">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                Show more
                                            </button>
                                        </div>
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="bg-success white">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Mã sản phẩm</th>
                                                            <th>Tên sản phẩm</th>
                                                            <th>Đơn vị tính</th>
                                                            <th>Số lượng</th>
                                                            <th>Đơn giá</th>
                                                            <th>VAT (%)</th>
                                                            <th>CK (%)</th>
                                                            <th>CK (đ)</th>
                                                            <th>Thành tiền</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>
                                                                <input type="text" class="form-control"/>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                                                                        <option selected>Choose...</option>
                                                                        <option value="1">One</option>
                                                                        <option value="2">Two</option>
                                                                        <option value="3">Three</option>
                                                                    </select>
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-outline-secondary" type="button">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>--</td>
                                                            <td>
                                                                <input type="text" class="form-control"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"/>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="11">
                                                                    <button type="button" class="btn btn-sm btn-primary">
                                                                        <i class="fa fa-plus"></i> Thêm sản phẩm
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <h5 class="uppercase font12 mg0 bold"><i class="fa fa-gift red pr5" aria-hidden="true"></i>&nbsp;Quà tặng</h5>
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Sản phẩm tặng</th>
                                                        <th>Số lượng</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bor-l" id="product_gifts">
                                                    <tr>
                                                        <td style="height:83px" colspan="3" class="tc">Không có tặng phẩm.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-4">
                                        <table class="table bor-r bor-l bor-bot">
                                            <tbody>
                                                <tr id="product_footer">
                                                    <td style="width:40%" class="font-bold order_footer">Tổng</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control footer tr" id="sum_amount" value="" disabled="disabled">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="font-bold order_footer">Phí Ship (%)</td>
                                                    <td style="width:30%">
                                                        <input type="text" class="form-control footer tc" id="discount" value="">
                                                    </td>
                                                    <td style="width:30%">
                                                        <input type="text" class="form-control footer tr" id="discount_amount" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="font-bold order_footer">VAT (%)</td>
                                                    <td style="width:30%">
                                                        <input type="text" class="form-control footer tc" id="vat" value="">
                                                    </td>
                                                    <td style="width:30%">
                                                        <input type="text" class="form-control footer tr" id="vat_amount" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="font-bold order_footer">Phí vận chuyển (%)</td>
                                                    <td style="width:30%">
                                                        <input type="text" class="form-control footer tc" id="transport" value="">
                                                    </td>
                                                    <td style="width:30%">
                                                        <input type="text" class="form-control footer tr" id="transport_amount" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="font-bold order_footer">Phí lắp đặt (%)</td>
                                                    <td style="width:30%">
                                                        <input type="text" class="form-control footer tc" id="installation" value="">
                                                    </td>
                                                    <td style="width:30%">
                                                        <input type="text" class="form-control footer tr" id="installation_amount" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="font-bold order_footer">Chiết khấu sau thuế</td>
                                                    <td colspan="2">
                                                        <div class="checker" id="uniform-afterVAT">
                                                            <span class="">
                                                                <input type="checkbox" id="afterVAT" style="opacity:1"></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="font-bold order_footer bold">Tổng cộng</td>
                                                    <td colspan="2">
                                                        <input disabled="disabled" type="text" class="form-control footer tr" id="total_amount" value="0"> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop
