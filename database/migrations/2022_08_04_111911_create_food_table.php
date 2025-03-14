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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id')->nullable()->index();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->double('price');

            $table->longText('allergy')->nullable();
            $table->json('lang_allergy')->nullable();

            $table->longText('calories')->nullable();
            $table->json('lang_calories')->nullable();

            $table->json('ingredient')->nullable();
            $table->string('preparation_time', 40)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_out_of_sold')->default(false);
            $table->double('discount_price')->nullable();
            $table->enum('discount_type',['fixed','percentage'])->nullable();
            $table->string('label_image', 150)->nullable();
            $table->string('food_image', 150)->nullable();
            $table->json('lang_name')->nullable();
            $table->json('lang_description')->nullable();
            $table->unique(['restaurant_id', 'name']);
            $table->boolean('is_default_image')->default(false);
            $table->json('gallery_images')->nullable();
            $table->longText('custom_field')->nullable();
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
        Schema::dropIfExists('food');
    }
};
