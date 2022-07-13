<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentIdColumnToUserSubscribedPansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_subscribed_plans', function (Blueprint $table) {
            $table->string('payment_id')->nullable()->comment('razorpay_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscribed_plans', function (Blueprint $table) {
            $table->dropColumn('payment_id');
        });
    }
}
