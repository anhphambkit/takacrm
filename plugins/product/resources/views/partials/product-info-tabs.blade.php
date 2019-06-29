<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 14:48
 */
?>
<div class="card product-info-tabs">
    <div class="card-header">
        <h4 class="card-title">{{ trans('plugins-product::product.advanced_info') }}</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link active" id="exchange-tab" data-toggle="tab" href="#exchange" aria-controls="exchange" aria-expanded="true">{{ trans('plugins-product::product.exchange') }}</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" id="introduce-tab" data-toggle="tab" href="#introduce" aria-controls="introduce" aria-expanded="false">{{ trans('plugins-product::product.introduce') }}</a>--}}
                {{--</li>--}}
            </ul>
            <div class="tab-content px-1 pt-1">
                {{--<div role="tabpanel" class="tab-pane active" id="exchange" aria-labelledby="exchange" aria-expanded="true">--}}
                    {{--<p>Exchange tab</p>--}}
                {{--</div>--}}
                {{--<div role="tabpanel" class="tab-pane" id="introduce" aria-labelledby="introduce" aria-expanded="false">--}}
                    {{--@include('plugins-product::partials.tables.introduce-person-product-table')--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>
