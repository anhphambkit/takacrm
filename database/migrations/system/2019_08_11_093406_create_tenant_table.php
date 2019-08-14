<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTenantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host_name')->unique();
            $table->string('db_name')->unique();
            $table->string('db_ip')->nullable();
            $table->string('db_port')->nullable();
            $table->string('managed_by_database_connection')
                ->nullable()
                ->comment('References the database connection key in your database.php');
            $table->string('fqdn')->unique();
            $table->string('redirect_to')->nullable();
            $table->boolean('force_https')->default(false);
            $table->timestamp('under_maintenance_since')->nullable();
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
        Schema::dropIfExists('tenants');
    }
}
