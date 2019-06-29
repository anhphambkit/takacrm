<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-11
 * Time: 20:11
 */
?>
<div class="card product-relation-card">
    <div class="card-header">
        <h4 class="card-title" id="relation-product-info">{{ trans('plugins-product::product.form.image_gallery') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="row gallery-detail">
                @foreach($galleries as $gallery)
                    <div class="col-md-3 mb-2">
                        <a href="javascript:void(0);" class="item">
                            <img src="{{ asset($gallery) }}" alt="{{ $gallery }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
