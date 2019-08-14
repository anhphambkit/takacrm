<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyProductTableType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('products', 'discount')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('discount', 'discount_percent');
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
        if (Schema::hasColumn('products', 'discount_percent')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('discount_percent', 'discount');
            });
        }
    }
}
