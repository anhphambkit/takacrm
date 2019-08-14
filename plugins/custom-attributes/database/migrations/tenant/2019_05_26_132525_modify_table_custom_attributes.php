<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTableCustomAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('custom_attributes', 'is_unique')) {
            Schema::table('custom_attributes', function (Blueprint $table) {
                $table->boolean('is_unique')->default(false);
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
        if (Schema::hasColumn('custom_attributes', 'is_unique')) {
            Schema::table('custom_attributes', function (Blueprint $table) {
                $table->dropColumn('is_unique');
            });
        }
    }
}
