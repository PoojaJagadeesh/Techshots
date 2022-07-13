<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoinReedemTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coin_reedem_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('type')->nullable()->comment = "0 stands for coupon reedem and 1 stands for cash reeedem";
            $table->unsignedInteger('coins_reedemed')->nullable();
            $table->unsignedInteger('instant_coins')->nullable();
            $table->string('amount')->nullable()->comment = "this field is used only for storing amount of reedem cash";
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_coin_reedem_transactions');
    }
}
