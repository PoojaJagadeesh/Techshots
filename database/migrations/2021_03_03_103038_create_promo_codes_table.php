<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code_name')->nullable();
            $table->string('code')->nullable();
            $table->string('prefix')->nullable();
            $table->string('discount_percentage')->nullable();
            $table->foreignId('plan_id')->constrained('plans');
            $table->boolean('validity')->default(0);
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->boolean('reusable')->default(0);
            $table->integer('count_usage')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_codes');
    }
}
