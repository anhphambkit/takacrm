<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_spaces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('image_feature')->nullable();
            $table->string('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('business_type_space_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_type_id');
            $table->integer('space_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('look_book_business_type_space_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_type_id');
            $table->integer('space_id');
            $table->integer('look_book_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('product_spaces');
        Schema::dropIfExists('business_type_space_relation');
        Schema::dropIfExists('look_book_business_type_space_relation');
    }
}
