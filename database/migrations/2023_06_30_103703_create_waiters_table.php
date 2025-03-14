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
        Schema::create('waiters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('restaurant_id')->nullable()->index();
            $table->unsignedBigInteger('table_id')->nullable()->index();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            //  relation shift
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('restaurant_id')->on('restaurants')->references('id')->onDelete('cascade');
            $table->foreign('table_id')->on('tables')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waiters');
    }
};
