<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyLookBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('look_books', 'type_layout')) {
            Schema::table('look_books', function (Blueprint $table) {
                $table->string('type_layout')->default('normal')->comment('normal|vertical');
            });
        }

        if (!Schema::hasColumn('look_books', 'is_main')) {
            Schema::table('look_books', function (Blueprint $table) {
                $table->boolean('is_main')->default(false);
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
        if (Schema::hasColumn('look_books', 'type_layout')) {
            Schema::table('look_books', function (Blueprint $table) {
                $table->dropColumn('type_layout');
            });
        }

        if (Schema::hasColumn('look_books', 'is_main')) {
            Schema::table('look_books', function (Blueprint $table) {
                $table->dropColumn('is_main');
            });
        }
    }
}
