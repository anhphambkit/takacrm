<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustomAttributeValueOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_attribute_value_option', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('custom_attribute_id');
            $table->integer('entity_id');
            $table->integer('value');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
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
        Schema::dropIfExists('custom_attribute_value_option');
    }
}
