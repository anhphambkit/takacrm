<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('order');
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code', 120)->unique();
            $table->string('customer_name', 255)->nullable();
            $table->string('customer_code', 255)->nullable();
            $table->string('customer_phone', 20)->nullable();
            $table->string('customer_address', 255)->nullable();
            $table->string('customer_email', 50)->nullable();
            $table->integer('customer_id')->nullable();
            $table->text('customer_info')->nullable();
            $table->integer('user_performed_id');
            $table->text('user_performed_info');
            $table->date('order_date');
            $table->integer('payment_method_id')->nullable();
            $table->text('payment_method_info')->nullable();
            $table->integer('order_source_id')->nullable();
            $table->text('order_source_info')->nullable();
            $table->string('lading_code', 120)->nullable();
            $table->integer('campaign_id')->nullable();
            $table->integer('customer_contact_id')->nullable();
            $table->text('customer_contact_info')->nullable();
            $table->text('order_file')->nullable();
            $table->text('order_conditions')->nullable();
            $table->integer('fees_ship')->nullable();
            $table->integer('fees_vat')->nullable();
            $table->integer('fees_shipping')->nullable();
            $table->integer('fees_installation')->nullable();
            $table->float('fees_ship_percent')->nullable();
            $table->float('fees_vat_percent')->nullable();
            $table->float('fees_shipping_percent')->nullable();
            $table->float('fees_installation_percent')->nullable();
            $table->boolean('is_discount_after_tax')->default(false);
            $table->integer('sub_total');
            $table->integer('total_order');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('order_status')->nullable();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
