<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_feedback', function (Blueprint $table) {
            $table->id();
            $table->integer('restaurant_id')->nullable();
            $table->integer('staff')->nullable();
            $table->integer('service')->nullable();
            $table->integer('hygiene')->nullable();
            $table->text('overall_experience')->nullable();
            $table->text('additional_comment')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_feedback');
    }
};
