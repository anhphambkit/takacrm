<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAddressVn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code');
            $table->string('name');
            $table->string('english_name')->nullable();
            $table->integer('country_code')->default(0);
            $table->string('type_level');
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code');
            $table->string('name');
            $table->string('english_name')->nullable();
            $table->integer('city_province_code');
            $table->string('type_level');
            $table->timestamps();
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code');
            $table->string('name');
            $table->string('english_name')->nullable();
            $table->integer('district_code');
            $table->string('type_level');
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
        Schema::dropIfExists('provinces_cities');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('wards');
    }
}
