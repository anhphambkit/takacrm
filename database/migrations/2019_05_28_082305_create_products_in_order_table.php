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
            $table->string('note');
            $table->string('unit_info');
            $table->integer('quantity')->default(1);
            $table->integer('price');
            $table->integer('vat_percent')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('discount_percent')->default(0);
            $table->integer('sum_price');
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
