<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSuccessScratchLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_success_scratch_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->foreignId('scratch_card_id')->constrained('scratch_cards');
            $table->boolean('scratch_type')->nullable()->comment= "0 stands for offer 1 stands for coin";
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
        Schema::dropIfExists('user_success_scratch_logs');
    }
}
