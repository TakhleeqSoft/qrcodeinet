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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email')->unique();
            $table->tinyInteger('user_type')->comment('1 admin, 2 staff, 3 Vendor')->default(3);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 150)->nullable();
            $table->string('state', 150)->nullable();
            $table->string('country', 150)->nullable();
            $table->string('zip', 10)->nullable();
            $table->text('google_token')->nullable();
            $table->string('google_access_id')->nullable();
            $table->string('notification_token')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->string('profile_image')->nullable();
            $table->string('language')->default('English');
            $table->tinyInteger('status')->comment('0 - deactivated | 1 - activated');
            $table->rememberToken();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('is_trial_enabled')->default(false);
            $table->boolean('plan_purchased')->default(false);
            $table->boolean('free_forever')->default(false);
            $table->dateTime('trial_expire_at')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->string('user_ip',100)->nullable();
            $table->string('stripe_customer_id',100)->nullable();
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
        Schema::dropIfExists('users');
    }
};
