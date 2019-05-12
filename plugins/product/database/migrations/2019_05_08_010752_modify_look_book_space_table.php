<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyLookBookSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('look_book_business_type_space_relation', 'apply_all')) {
            Schema::table('look_book_business_type_space_relation', function (Blueprint $table) {
                $table->boolean('apply_all')->default(false);
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
        if (Schema::hasColumn('look_book_business_type_space_relation', 'apply_all')) {
            Schema::table('look_book_business_type_space_relation', function (Blueprint $table) {
                $table->dropColumn('apply_all');
            });
        }
    }
}
