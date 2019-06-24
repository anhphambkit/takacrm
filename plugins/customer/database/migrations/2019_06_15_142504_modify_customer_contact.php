<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCustomerContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('customer_contacts', 'email')) {
            Schema::table('customer_contacts', function (Blueprint $table) {
                $table->dropUnique('customer_contacts_email_unique');
                $table->string('email')->nullable(true)->change();
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
        if (Schema::hasColumn('customer_contacts', 'email')) {
            Schema::table('customer_contacts', function (Blueprint $table) {
                $table->string('email')->nullable(false)->change();
            });
        }
    }
}
