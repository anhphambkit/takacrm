<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->text('value_origin')->nullable();
            $table->text('value_current')->nullable();
            $table->string('field_name')->nullable();
            $table->string('table_name')->nullable();
            $table->string('path_session')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dropColumn(['value_origin','value_current','field_name','path_session','table_name']);
        });
    }
}
