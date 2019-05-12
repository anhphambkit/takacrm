<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-01
 * Time: 21:04
 */
?>

<div class="card customer-list-table-card">
    <div class="card-header">
        <button type="button" class="btn btn-info mr-1">
            <a href="{{ route('admin.customer.create') }}" class="link-create-new-customer">
                <i class="fas fa-user"></i> {{ trans('plugins-customer::customer.create') }}
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
            <table id="customer-table" class="b-table-custom table table-bordered table-striped customer-list-table" width="100%">
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Actions</th>
                        <th>Status</th>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Gender</th>
                        <th>Customer Code</th>
                        <th>Phone</th>
                        <th>Fax</th>
                        <th>Email</th>
                        <th>Relation Customer</th>
                        <th>Customer Group</th>
                        <th>Customer Job</th>
                        <th>Customer Source</th>
                        <th>Value</th>
                        <th>Birthday</th>
                        <th>Address</th>
                        <th>Ward</th>
                        <th>District</th>
                        <th>Province/City</th>
                        <th>Website</th>
                        <th>Facebook</th>
                        <th>Note</th>
                        <th>Introduce Person</th>
                        <th>Personal Manage</th>
                        <th>Created by</th>
                        <th>Created at</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
