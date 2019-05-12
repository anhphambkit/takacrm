<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 14:48
 */
?>
<div class="card customer-info-tabs">
    <div class="card-header">
        <h4 class="card-title">{{ trans('plugins-customer::customer.advanced_info') }}</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                <li class="nav-item">
                    <a class="nav-link active" id="exchange-tab" data-toggle="tab" href="#exchange" aria-controls="exchange" aria-expanded="true">{{ trans('plugins-customer::customer.exchange') }}</a>
                </li>
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" id="customer-feedback-tab" data-toggle="tab" href="#customer-feedback" aria-controls="customer-feedback" aria-expanded="false">{{ trans('plugins-customer::customer.feedback') }}</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item dropdown">--}}
                    {{--<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">--}}
                        {{--{{ trans('plugins-customer::customer.transaction') }}--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-menu">--}}
                        {{--<a class="dropdown-item" id="dropdownOpt1-tab1" href="#dropdownOpt11" data-toggle="tab" aria-controls="dropdownOpt11" aria-expanded="true">dropdown 1</a>--}}
                        {{--<a class="dropdown-item" id="dropdownOpt2-tab1" href="#dropdownOpt12" data-toggle="tab" aria-controls="dropdownOpt12" aria-expanded="true">dropdown 2</a>--}}
                    {{--</div>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" id="transaction-tab" data-toggle="tab" href="#transaction" aria-controls="transaction" aria-expanded="false">{{ trans('plugins-customer::customer.transaction') }}</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" id="customer-feedback-tab" data-toggle="tab" href="#customer-feedback" aria-controls="customer-feedback" aria-expanded="false">{{ trans('plugins-customer::customer.feedback') }}</a>--}}
                {{--</li>--}}
                <li class="nav-item">
                    <a class="nav-link" id="introduce-tab" data-toggle="tab" href="#introduce" aria-controls="introduce" aria-expanded="false">{{ trans('plugins-customer::customer.introduce') }}</a>
                </li>
            </ul>
            <div class="tab-content px-1 pt-1">
                <div role="tabpanel" class="tab-pane active" id="exchange" aria-labelledby="exchange" aria-expanded="true">
                    <p>Exchange tab</p>
                </div>
                {{--<div class="tab-pane" id="link1" role="tabpanel" aria-labelledby="link-tab1" aria-expanded="false">--}}
                    {{--<p>Chocolate bar gummies sesame snaps. Liquorice cake sesame snaps cotton candy cake sweet brownie. Cotton candy candy canes brownie. Biscuit pudding sesame snaps pudding pudding sesame snaps biscuit tiramisu.</p>--}}
                {{--</div>--}}
                {{--<div class="tab-pane" id="dropdownOpt11" role="tabpanel" aria-labelledby="dropdownOpt1-tab1" aria-expanded="false">--}}
                    {{--<p>Fruitcake marshmallow donut wafer pastry chocolate topping cake. Powder powder gummi bears jelly beans. Gingerbread cake chocolate lollipop. Jelly oat cake pastry marshmallow sesame snaps.</p>--}}
                {{--</div>--}}
                {{--<div class="tab-pane" id="dropdownOpt12" role="tabpanel" aria-labelledby="dropdownOpt2-tab1" aria-expanded="false">--}}
                    {{--<p>Soufflé cake gingerbread apple pie sweet roll pudding. Sweet roll dragée topping cotton candy cake jelly beans. Pie lemon drops sweet pastry candy canes chocolate cake bear claw cotton candy wafer.</p>--}}
                {{--</div>--}}
                {{--<div class="tab-pane" id="linkOpt1" role="tabpanel" aria-labelledby="linkOpt-tab1" aria-expanded="false">--}}
                    {{--<p>Cookie icing tootsie roll cupcake jelly-o sesame snaps. Gummies cookie dragée cake jelly marzipan donut pie macaroon. Gingerbread powder chocolate cake icing. Cheesecake gummi bears ice cream marzipan.</p>--}}
                {{--</div>--}}
                <div role="tabpanel" class="tab-pane" id="introduce" aria-labelledby="introduce" aria-expanded="false">
                    @include('plugins-customer::partials.tables.introduce-person-customer-table')
                </div>
            </div>
        </div>
    </div>
</div>
