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
            $table->string('manufacturer_image', 255)->nullable();
            $table->text('policy')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        // Colors Table
        Schema::create('product_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('code', 20)->unique();
            $table->string('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_colors_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_color_id');
            $table->integer('product_id');
            $table->timestamps();
        });

        // Collections Table
        Schema::create('product_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique();
            $table->string('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_collections_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_collection_id');
            $table->integer('product_id');
            $table->timestamps();
        });

        // Materials Table
        Schema::create('product_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('slug', 150);
            $table->string('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_materials_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_material_id');
            $table->integer('product_id');
            $table->timestamps();
        });

        // Business Types Table
        Schema::create('product_business_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique()->comment('Slug of business type');
            $table->integer('parent_id')->default(0)->comment('Id of business type parent');
            $table->string('description')->nullable();
            $table->integer('order')->default(0)->comment('Order of this business type (Just on the same level).');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->boolean('is_root')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_business_types_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_business_type_id');
            $table->integer('product_id');
            $table->timestamps();
        });

        // Categories Tables:
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique()->comment('Slug of category');
            $table->integer('parent_id')->default(0)->comment('Id of category parent');
            $table->string('description')->nullable();
            $table->integer('order')->default(0)->comment('Order of this category (Just on the same level).');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_categories_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_category_id');
            $table->integer('product_id');
            $table->timestamps();
        });

        // Tags Table:
        Schema::create('product_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('description', 400)->nullable();
            $table->integer('parent_id')->unsigned()->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->default(true);
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
            $table->boolean('is_feature')->default(false)->comment('Product feature');
            $table->boolean('is_best_seller')->default(false)->comment('Product is best seller');
            $table->boolean('is_free_ship')->default(false)->comment('Product is free ship');
            $table->boolean('available_3d')->default(false)->comment('Product has free design');
            $table->boolean('is_outdoor')->default(false)->comment('Product is outdoor item');
            $table->boolean('has_assembly')->default(false)->comment('Product has assembly');
            $table->string('product_dimension', 30)->nullable()->comment('Product dimension WxDxH');
            $table->string('package_dimension', 30)->nullable()->comment('Package dimension WxDxH');
            $table->integer('product_weight')->nullable()->comment('Product weight');
            $table->integer('package_weight')->nullable()->comment('Package weight');
            $table->integer('price')->comment('Original price'); // Original price
            $table->integer('sale_price')->nullable()->comment('Sale Price'); // Price which client will pay to buy
            $table->integer('inventory')->nullable()->comment('Total items in stock'); // Original price
            $table->integer('rating')->default(5)->comment('Number of star for this product.');
            $table->string('keywords')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1)->comment('true: Published, false: Draft');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_tag_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id');
            $table->integer('product_id');
            $table->timestamps();
        });

        // Look Books Table
        Schema::create('look_books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->text('image');
            $table->string('permalink')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('look_book_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('look_book_id');
            $table->integer('product_id');
            $table->integer('product_category_id');
            $table->string('left');
            $table->string('top');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('look_book_business_types_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_type_id');
            $table->integer('look_book_id');
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
        Schema::dropIfExists('product_brands');
        Schema::dropIfExists('product_manufacturers');
        Schema::dropIfExists('product_manufacturers_relation');
        Schema::dropIfExists('product_colors');
        Schema::dropIfExists('product_colors_relation');
        Schema::dropIfExists('product_collections');
        Schema::dropIfExists('product_collections_relation');
        Schema::dropIfExists('product_materials');
        Schema::dropIfExists('product_materials_relation');
        Schema::dropIfExists('product_business_types');
        Schema::dropIfExists('product_business_types_relation');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_categories_relation');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('product_tag_relation');
        Schema::dropIfExists('look_books');
        Schema::dropIfExists('look_book_tags');
        Schema::dropIfExists('look_book_business_types_relation');
    }
}
