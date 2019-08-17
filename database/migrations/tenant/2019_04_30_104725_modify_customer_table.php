<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('customers', 'type_reference_data')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('type_reference_data', 10)->nullable();
            });
        }

        if (!Schema::hasColumn('customers', 'introduce_person_id')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->integer('introduce_person_id')->nullable();
            });
        }

        if (!Schema::hasColumn('customers', 'created_by')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->integer('created_by')->nullable();
            });
        }

        if (!Schema::hasColumn('customers', 'updated_by')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->integer('updated_by')->nullable();
            });
        }

        // Customer Group
        if (!Schema::hasColumn('group_customers', 'updated_by')) {
            Schema::table('group_customers', function (Blueprint $table) {
                $table->integer('updated_by')->nullable();
            });
        }

        if (!Schema::hasColumn('group_customers', 'status')) {
            Schema::table('group_customers', function (Blueprint $table) {
                $table->boolean('status')->unsigned()->default(1);
            });
        }

        // Customer Contact
        if (!Schema::hasColumn('customer_contacts', 'created_by')) {
            Schema::table('customer_contacts', function (Blueprint $table) {
                $table->integer('created_by')->nullable();
            });
        }

        if (!Schema::hasColumn('customer_contacts', 'updated_by')) {
            Schema::table('customer_contacts', function (Blueprint $table) {
                $table->integer('updated_by')->nullable();
            });
        }

        if (!Schema::hasColumn('customer_contacts', 'status')) {
            Schema::table('customer_contacts', function (Blueprint $table) {
                $table->boolean('status')->unsigned()->default(1);
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
        if (Schema::hasColumn('customers', 'type_reference_data')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('type_reference_data');
            });
        }

        if (Schema::hasColumn('customers', 'introduce_person_id')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('introduce_person_id');
            });
        }

        if (Schema::hasColumn('customers', 'created_by')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('created_by');
            });
        }

        if (Schema::hasColumn('customers', 'updated_by')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('updated_by');
            });
        }

        // Customer Group
        if (Schema::hasColumn('group_customers', 'updated_by')) {
            Schema::table('group_customers', function (Blueprint $table) {
                $table->dropColumn('updated_by');
            });
        }

        if (Schema::hasColumn('group_customers', 'status')) {
            Schema::table('group_customers', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        // Customer Contact
        if (Schema::hasColumn('customer_contacts', 'created_by')) {
            Schema::table('customer_contacts', function (Blueprint $table) {
                $table->dropColumn('created_by');
            });
        }

        if (Schema::hasColumn('customer_contacts', 'updated_by')) {
            Schema::table('customer_contacts', function (Blueprint $table) {
                $table->dropColumn('updated_by');
            });
        }

        if (Schema::hasColumn('customer_contacts', 'status')) {
            Schema::table('customer_contacts', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
