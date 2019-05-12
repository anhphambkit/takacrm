<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 14:07
 */
?>
<div class="card customer-progress">
    <div class="card-header">
        <h4 class="card-title" id="relation-customer-info">{{ trans('plugins-customer::customer.finish_info') }}</h4>
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
        <div class="card-body text-center">
            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="80" aria-valuemin="80" aria-valuemax="100" style="width:80%">80%</div>
            </div>
        </div>
    </div>
</div>
