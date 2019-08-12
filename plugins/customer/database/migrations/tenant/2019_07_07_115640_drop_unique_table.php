<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUniqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('customer_sources', 'name')) {
            Schema::table('customer_sources', function (Blueprint $table) {
                $table->dropUnique('customer_sources_name_unique');
            });
        }

        if (Schema::hasColumn('group_customers', 'name')) {
            Schema::table('group_customers', function (Blueprint $table) {
                $table->dropUnique('group_customers_name_unique');
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
        //
    }
}
