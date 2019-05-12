<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 13:52
 */
?>
<div class="card customer-contacts">
    <div class="card-header">
        <h4 class="card-title" id="relation-customer-info">{{ trans('plugins-customer::customer.contacts') }}</h4>
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
            @foreach($customerContacts as $customerContact)
                <div class="card">
                    <div class="card-content">
                        <div class="media align-items-stretch">
                            <div class="p-2 text-center bg-danger rounded-left wrap-icon-card-info-custom">
                                <i class="far fa-user text-white font-large-2"></i>
                            </div>
                            <div class="px-2 media-body">
                                <h5 class="danger">{{ $customerContact->full_name }}</h5>
                                <h5 class="text-bold-400">
                                    <span class="info-title">{{ trans('plugins-customer::customer.form.gender') }}: </span>
                                    <span class="gender value-info">{{ $customerContact->gender }}</span>
                                </h5>
                                <h5 class="text-bold-400">
                                    <span class="info-title">{{ trans('plugins-customer::customer.form.dob') }}: </span>
                                    <span class="dob value-info">{{ $customerContact->dob }}</span>
                                </h5>
                                <h5 class="text-bold-400">
                                    <span class="info-title">{{ trans('plugins-customer::customer.form.email') }}: </span>
                                    <span class="email value-info">{{ $customerContact->email }}</span>
                                </h5>
                                <h5 class="text-bold-400">
                                    <span class="info-title">{{ trans('plugins-customer::customer.form.phone') }}: </span>
                                    <span class="phone value-info">{{ $customerContact->phone }}</span>
                                </h5>
                                <h5 class="text-bold-400">
                                    <span class="info-title">{{ trans('plugins-customer::customer.form.job_position') }}: </span>
                                    <span class="job_position value-info">{{ $customerContact->job_position }}</span>
                                </h5>
                                <h5 class="text-bold-400">
                                    <span class="info-title">{{ trans('plugins-customer::customer.form.note') }}: </span>
                                    <span class="note value-info">{{ $customerContact->note }}</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
