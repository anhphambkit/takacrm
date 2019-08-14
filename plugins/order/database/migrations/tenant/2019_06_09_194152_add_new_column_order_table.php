<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Core\Setting\Repositories\Interfaces\ReferenceRepositories;
use Plugins\Order\Contracts\OrderConfigs;

class AddNewColumnOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (!Schema::hasColumn('orders', 'sale_order')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->integer('sale_order')->default(0);
            });
        }

        if (!Schema::hasColumn('orders', 'discount_order')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->integer('discount_order')->default(0);
            });
        }

        if (!Schema::hasColumn('orders', 'vat_order')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->integer('vat_order')->default(0);
            });
        }

        $notPaidStatus = app()->make(ReferenceRepositories::class)->bySlug(str_slug(OrderConfigs::STATUS_PAYMENT_ORDER_NOT_PAID));
        $notPaidStatusId = ($notPaidStatus) ? $notPaidStatus->id : NULL;
        if (!Schema::hasColumn('orders', 'payment_status')) {
            Schema::table('orders', function (Blueprint $table) use ($notPaidStatusId) {
                $table->integer('payment_status')->default($notPaidStatusId);
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
        if (Schema::hasColumn('orders', 'sale_order')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('sale_order');
            });
        }

        if (Schema::hasColumn('orders', 'discount_order')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('discount_order');
            });
        }

        if (Schema::hasColumn('orders', 'vat_order')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('vat_order');
            });
        }

        if (Schema::hasColumn('orders', 'payment_status')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_status');
            });
        }
    }
}
