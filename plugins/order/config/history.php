<?php
return [
	'order' => [
		'display_attributes' => [
			'order_code'                => 'Order Code',
	        'customer_name'             => 'Customer Name',
	        'customer_code'             => 'Customer Code',
	        'customer_phone'            => 'Customer Phone',
	        'customer_address'          => 'Customer Address',
	        'customer_email'            => 'Customer Email',
	        'customer_id'               => 'Customer Id',
	        'customer_info'             => 'Customer Info',
	        'user_performed_id'         => 'User Performed Id',
	        'user_performed_info'       => 'User Performed Info',
	        'order_date'                => 'Order Date',
	        'payment_method_id'         => 'Payment Method Id',
	        'payment_method_info'       => 'Payment Method Info',
	        'order_source_id'           => 'Order Source Id',
	        'order_source_info'         => 'Order Source Info',
	        'lading_code'               => 'Lading Code',
	        'campaign_id'               => 'Campaign Id',
	        'customer_contact_id'       => 'Customer Contact Id',
	        'customer_contact_info'     => 'Customer Contact Info',
	        'order_file'                => 'Order File',
	        'order_conditions'          => 'Order Conditions',
	        'fees_ship'                 => 'Fees Ship',
	        'fees_vat'                  => 'Fees Vat',
	        'fees_shipping'             => 'Fees Shipping',
	        'fees_installation'         => 'Fees Installation',
	        'fees_ship_percent'         => 'Fees Ship Percent',
	        'fees_vat_percent'          => 'Fees Vat Percent',
	        'fees_shipping_percent'     => 'Fees Shipping Percent',
	        'fees_installation_percent' => 'Fees Installation Percent',
	        'is_discount_after_tax'     => 'Discount After Tax',
	        'sale_order'                => 'Sale Order',
	        'discount_order'            => 'Discount Order',
	        'vat_order'                 => 'Vat Order',
	        'sub_total'                 => 'Sub Total',
	        'total_order'               => 'Total Order',
	        'order_status'              => 'Order Status',
	        'payment_status'            => 'Payment Status',
	        'status'                    => 'Status'
		],
		'ignore_attributes' => [
			'updated_at',
	        'updated_by',
	        'deleted_at',
	        'user_performed_info',
	        'payment_method_info',
	        'order_source_info'
		],
		'relationship_attributes' => [
			'customer_id' => [
	            'mapTable'  => 'customers',
	            'mapColumn' => 'id',
	            'mapResult' => 'full_name'
	        ],
	        'order_status' => [
	            'mapTable'  => 'references',
	            'mapColumn' => 'id',
	            'mapResult' => 'value'
	        ],
	        'payment_status' => [
	            'mapTable'  => 'references',
	            'mapColumn' => 'id',
	            'mapResult' => 'value'
	        ],
		]
	]
];