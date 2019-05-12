<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('roles', 'is_default')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->tinyInteger('is_default')->unsigned()->default(0);
            });
        }

        if (!Schema::hasColumn('roles', 'parent_id')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->integer('parent_id')->unsigned()->default(0);
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
        if (Schema::hasColumn('roles', 'is_default')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('is_default');
            });
        }

        if (Schema::hasColumn('roles', 'parent_id')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('parent_id');
            });
        }
    }
}
