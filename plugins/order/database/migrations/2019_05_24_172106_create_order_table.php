<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->integer('customer_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('order_code', 120)->unique();
            $table->string('account_name', 255)->nullable();
            $table->string('account_phone', 20)->nullable();
            $table->string('order_address', 255)->nullable();
            $table->string('account_email', 50)->nullable();
            $table->date('order_date');
            $table->integer('payment_method_id');
            $table->integer('product_orginal_id');
            $table->string('lading_code', 120)->unique();
            $table->integer('campaign_id')->nullable();
            $table->integer('contacts_id')->nullable();
            $table->text('userfile')->nullable();
            $table->integer('time_complete')->nullable();
            $table->string('notes', 255)->nullable();
            $table->integer('comission')->nullable();
            $table->tinyInteger('date_of_shipment')->nullable();
            $table->tinyInteger('month_of_shipment')->nullable();
            $table->longText('products')->nullable();
            $table->text('conditions')->nullable();
            $table->tinyInteger('fees_ship')->default(0);
            $table->tinyInteger('fees_vat')->default(0);
            $table->tinyInteger('fees_shipping')->default(0);
            $table->tinyInteger('fees_installation')->default(0);
            $table->tinyInteger('uniform_afterVAT')->default(0);
            $table->tinyInteger('status')->unsigned()->default(1);
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
        Schema::dropIfExists('order');
    }
}
