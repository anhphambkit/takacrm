<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('orders', 'user_performed_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->integer('user_performed_id')->nullable(true)->change();
            });
        }

        if (Schema::hasColumn('orders', 'user_performed_info')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->text('user_performed_info')->nullable(true)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('orders', 'user_performed_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->integer('user_performed_id')->nullable(false)->change();
            });
        }

        if (Schema::hasColumn('orders', 'user_performed_info')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->text('user_performed_info')->nullable(false)->change();
            });
        }
    }
}
