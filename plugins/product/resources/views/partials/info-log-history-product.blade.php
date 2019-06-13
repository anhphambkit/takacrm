<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 14:34
 */
?>
<div class="card log-info-product">
    <div class="card-header">
        <h4 class="card-title" id="relation-product-info">{{ trans('core-base::forms.log_info') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="info-item">
                <span class="info-title">
                    {{ trans('core-base::forms.created_by') }}:
                </span>
                <span class="value-info">
                    {{ $product->createdByUser ? $product->createdByUser->getFullName() : "" }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-title">
                    {{ trans('core-base::forms.created_at') }}:
                </span>
                <span class="value-info">
                    {{ $product->created_at }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card log-info-product">
    <div class="card-header">
        <h4 class="card-title" id="relation-product-info">{{ trans('Histories') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body" id="log-history-product">
            @if(!empty($histories))
                @foreach($histories as $log)
                    <div class="info-item">
                        <span class="info-title">
                            {{ $log->user->getFullName() ?? '' }} - {{ find_reference_by_id($log->type)->value }}:
                        </span>
                        <span class="value-info">
                            {{ $log->content }}
                        </span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>