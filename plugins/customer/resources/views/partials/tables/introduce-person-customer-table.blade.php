<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-07
 * Time: 11:00
 */
?>
<table id="customer-introduce-person-table" class="b-table-custom table table-bordered table-striped customer-introduce-person-table">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Email</th>
            <th>Relation Customer</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customerIntroduces as $customerIntroduce)
            <tr>
                <td>
                    <div class="media">
                        <div class="media-left pr-1">
                            <span class="avatar avatar-sm avatar-online rounded-circle">
                                <img src="{{ get_object_image($customerIntroduce->avatar, 'mediumThumb') }}" alt="avatar" class="avatar-table" />
                            </span>
                        </div>
                        <div class="media-body media-middle">
                            <a class="media-heading name" href="{{ route('admin.customer.detail', [ 'id' => $customerIntroduce->id ]) }}">{{ $customerIntroduce->full_name }}</a>
                        </div>
                    </div>
                </td>
                <td>{{ $customerIntroduce->email }}</td>
                <td>
                    <span class="minicolor-preview">
                        <span class="minicolor-square-box" style="background-color: {{ $customerIntroduce->customer_relation_color_code }};"></span>
                        </span>
                    <span class="customer-color-attr">{{ $customerIntroduce->customer_relation_name }}</span>
                </td>
                <td>{{ $customerIntroduce->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Customer</th>
            <th>Email</th>
            <th>Relation Customer</th>
            <th>Created At</th>
        </tr>
    </tfoot>
</table>
