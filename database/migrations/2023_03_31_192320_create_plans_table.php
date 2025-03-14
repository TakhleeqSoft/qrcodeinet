<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id('plan_id');
            $table->string('title');
            $table->double('amount')->default('0');
            $table->enum('type',['onetime','monthly','day','weekly','yearly','trial']);
            $table->integer('table_limit')->default(0);
            $table->integer('restaurant_limit')->default(0);
            $table->integer('item_limit')->default(0);
            $table->integer('staff_limit')->default(0);
            $table->enum('status',['active','inactive'])->default('active');
            $table->string('stripe_product_id',150)->nullable();
            $table->string('paypal_product_id',150)->nullable();
            $table->string('paypal_plan_id',150)->nullable();
            $table->enum('item_unlimited',['yes','no'])->default('no');
            $table->enum('restaurant_unlimited',['yes','no'])->default('no');
            $table->enum('table_unlimited',['yes','no'])->default('no');
            $table->enum('staff_unlimited',['yes','no'])->default('no');
            $table->string('lang_plan_title')->nullable();
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
        Schema::dropIfExists('plans');
    }
};
