<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 14:06
 */
?>
<div class="card customer-relation-card">
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
            {{-- Relation Of Customer --}}
            <div class="row">
                <div class="form-group col-md-12 mb-2">
                    <label class="control-label required" for="select-customer_relationship_id-list">{{ trans('plugins-customer::customer.form.customer_relation') }}</label>
                    {!! Form::select('customer_relationship_id', $customerRelationshipIds, $customer->customer_relationship_id, ['class' => 'select2-placeholder-multiple form-control customer_relationship_id-list', "id" => "select-customer_relationship_id-list" ]) !!}
                    {!! Form::error('customer_relationship_id', $errors) !!}
                </div>
            </div>
            {{--End Relation Of Customer--}}
        </div>
    </div>
</div>
