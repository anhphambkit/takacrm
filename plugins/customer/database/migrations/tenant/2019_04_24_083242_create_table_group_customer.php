<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroupCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique()->comment('Slug of business type');
            $table->integer('parent_id')->default(0)->comment('Id of business type parent');
            $table->string('description')->nullable();
            $table->integer('order')->default(0)->comment('Order of this business type (Just on the same level).');
            $table->boolean('status')->unsigned()->default(1);
            $table->boolean('is_root')->default(1);
            $table->integer('created_by')->default(1);
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
        Schema::dropIfExists('group_customers');
    }
}
