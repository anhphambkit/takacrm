<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRelationShipOfCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_job_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->references('id')->on('customers')->index();
            $table->integer('customer_job_id')->unsigned()->references('id')->on('customer_jobs')->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('customer_group_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->references('id')->on('customers')->index();
            $table->integer('customer_group_id')->unsigned()->references('id')->on('group_customers')->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('customer_source_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->references('id')->on('customers')->index();
            $table->integer('customer_source_id')->unsigned()->references('id')->on('customer_sources')->index();
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
        Schema::dropIfExists('customer_source_relation');
        Schema::dropIfExists('customer_group_relation');
        Schema::dropIfExists('customer_job_relation');
    }
}
