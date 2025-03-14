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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            //  relation shift
            // $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->string('name', 150);
            $table->string('slug',150)->unique()->nullable();
            $table->string('type', 150)->nullable();
            $table->unsignedBigInteger('restaurant_type_id')->nullable()->index();
            $table->string('logo', 150)->nullable();
            $table->string('dark_logo')->nullable();
            $table->string('cover_image', 150)->nullable();
            $table->string('contact_email')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('state', 150)->nullable();
            $table->string('country', 150)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('currency', 20)->nullable();
            $table->longText('facebook_url')->nullable();
            $table->longText('instagram_url')->nullable();
            $table->longText('twitter_url')->nullable();
            $table->longText('youtube_url')->nullable();
            $table->longText('linkedin_url')->nullable();
            $table->longText('tiktok_url')->nullable();
            $table->json('qr_details')->nullable();
            $table->json('language')->nullable();
            $table->string('theme', 30)->nullable();
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
        Schema::dropIfExists('restaurants');
    }
};
