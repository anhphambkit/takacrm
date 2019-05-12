<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('provider', 255);
            $table->string('author', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('version', 30)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('alias', 120)->nullable();
            $table->string('namespace', 120)->nullable();
            $table->string('src', 255)->nullable();
            $table->tinyInteger('status')->unsigined()->default(0);
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
        Schema::dropIfExists('plugins');
    }
}
