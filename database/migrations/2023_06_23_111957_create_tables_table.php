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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('restaurant_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->integer('no_of_capacity')->nullable();
            $table->string('position')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('lang_table_name')->nullable();
            $table->timestamps();

            //  relation shift
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('restaurant_id')->on('restaurants')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables');
    }
};
