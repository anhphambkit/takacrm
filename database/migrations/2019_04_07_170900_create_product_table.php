<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        // manufacturer Table:
        Schema::create('product_manufacturers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique();
            $table->text('logo')->nullable();
            $table->text('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        // Unit Table
        Schema::create('product_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        // Origins Table
        Schema::create('product_origins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique();
            $table->text('logo')->nullable();
            $table->text('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        // Categories Tables:
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique()->comment('Slug of category');
            $table->text('description')->nullable();
            $table->integer('parent_id')->comment('Id of parent category');
            $table->integer('order')->comment('Order of category');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->timestamps();
        });

        // Products Table
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('slug', 150);
            $table->string('upc', 150)->unique();
            $table->string('sku', 30);
            $table->text('image_feature');
            $table->string('short_description', 255)->nullable();
            $table->text('long_desc')->nullable();
            $table->integer('manufacturer_id')->comment('Id of manufacturer');
            $table->integer('unit_id')->comment('Id of unit');
            $table->integer('origin_id')->comment('Id of origin');
            $table->integer('category_id')->comment('Id of category');
            $table->integer('retail_price')->comment('retail price'); // retail price
            $table->integer('wholesale_price')->comment('wholesale price'); // wholesale price
            $table->integer('online_price')->comment('online price'); // online price
            $table->integer('purchase_price')->comment('purchase price'); // purchase price

            $table->float('discount')->comment('discount'); // discount
            $table->float('wholesale_discount')->comment('wholesale discount'); // wholesale discount
            $table->float('purchase_discount')->comment('purchase discount'); // purchase discount
            $table->float('online_discount')->comment('online discount'); // online discount
            $table->float('vat')->nullable()->comment('VAT'); // VAT

            $table->boolean('is_feature')->default(false)->comment('Product feature');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1)->comment('true: Published, false: Draft');
            $table->softDeletes();
            $table->timestamps();
        });

        // Media Gallery
        Schema::create('product_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->text('media');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('product_manufacturers');
        Schema::dropIfExists('product_units');
        Schema::dropIfExists('product_origins');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_galleries');
    }
}
