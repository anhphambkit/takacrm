<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Core\Setting\Repositories\Interfaces\ReferenceRepositories;
use Plugins\Order\Contracts\OrderConfigs;

class AddColumnPaymentStatusOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
        if (Schema::hasColumn('orders', 'payment_status')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_status');
            });
        }
    }
}
