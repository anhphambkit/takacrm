<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('gender', 20)->nullable();
            $table->string('customer_code', 50)->nullable();
            $table->string('tax_code', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('email')->unique();
            $table->string('value')->nullable();
            $table->text('avatar')->nullable();
            $table->text('description')->nullable();
            $table->date('dob')->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('province_city_code')->nullable();
            $table->integer('district_code')->nullable();
            $table->integer('ward_code')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->integer('user_manage_id')->nullable();
            $table->integer('customer_relationship_id')->nullable();
            $table->string('note')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('customer_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->references('id')->on('customers')->index();
            $table->string('full_name');
            $table->string('job_position', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->string('note', 400)->nullable();
            $table->boolean('is_receive_email')->unsigned()->default(1);
            $table->boolean('is_primary_contact')->unsigned()->default(0);
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
        Schema::dropIfExists('customer_contacts');
        Schema::dropIfExists('customers');
    }
}
