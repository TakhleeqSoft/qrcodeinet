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
        Schema::create('vendor_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->longText('default_food_image')->nullable();
            $table->longText('default_category_image')->nullable();
            $table->string('default_currency',50)->default('USD');
            $table->string('default_currency_symbol',50)->default('$');
            $table->string('default_currency_position',50)->default('left');

            $table->longText('pusher_appid')->nullable();
            $table->longText('pusher_key')->nullable();
            $table->longText('pusher_secret')->nullable();
            $table->longText('pusher_cluster')->nullable();

            $table->timestamps();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_settings');
    }
};
