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
        Schema::create('restaurant_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('restaurant_id')->nullable()->index();
            $table->boolean('allow_language_change')->default(true);
            $table->boolean('allow_dark_light_mode_change')->default(true);
            $table->boolean('allow_direction')->default(true);
            $table->boolean('allow_show_allergies')->default(true);
            $table->boolean('allow_show_calories')->default(true);
            $table->boolean('allow_show_preparation_time')->default(true);
            $table->boolean('allow_show_food_details_popup')->default(true);
            $table->boolean('allow_show_banner')->default(true);
            $table->boolean('allow_show_restaurant_name_address')->default(true);
            $table->boolean('call_the_waiter')->default(false);
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
        Schema::dropIfExists('restaurant_settings');
    }
};
