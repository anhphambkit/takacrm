<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsInOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_in_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->string('sku');
            $table->string('name');
            $table->string('slug');
            $table->string('short_description')->nullable();
            $table->string('unit_name')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('retail_price');
            $table->float('vat')->default(0);
            $table->integer('discount')->default(0);
            $table->float('discount_percent')->default(0);
            $table->integer('total_price');
            $table->longText('product_info');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_in_order');
    }
}
