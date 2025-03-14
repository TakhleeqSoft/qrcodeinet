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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('plan_id');
            $table->string('payment_method')->nullable();
            $table->string('payment_type',150)->nullable();

            $table->dateTime('start_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->enum('is_current',['yes','no'])->default('no');

            $table->longText('details')->nullable();
            $table->longText('remark')->nullable();
            $table->double('amount')->default('0');
            $table->enum('type',['onetime','monthly','weekly','yearly','trial','free']);
            $table->integer('table_limit')->default(0);
            $table->integer('restaurant_limit')->default(0);
            $table->integer('item_limit')->default(0);
            $table->integer('staff_limit')->default(0);
            $table->enum('status',['pending','approved','rejected','canceled'])->default('pending');
            $table->enum('item_unlimited',['yes','no'])->default('no');
            $table->enum('restaurant_unlimited',['yes','no'])->default('no');
            $table->enum('table_unlimited',['yes','no'])->default('no');
            $table->enum('staff_unlimited',['yes','no'])->default('no');
            $table->string('transaction_id')->nullable();
            $table->longText('subscription_id')->nullable();
            $table->longText('json_response')->nullable();

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
        Schema::dropIfExists('subscriptions');
    }
};
