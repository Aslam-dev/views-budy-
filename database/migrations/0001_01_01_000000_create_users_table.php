<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('mobile_number')->unique();  // Sri Lankan mobile number (eg +947xxxxxxxx)
            $table->string('password')->nullable();     // Nullable for OTP login only users
            $table->string('otp_code')->nullable();     // For OTP verification code
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('is_verified')->default(false);  // Mobile verified or not

            $table->string('name')->nullable();        // Optional user name
            $table->string('slug')->nullable();
            $table->string('image')->nullable();

            $table->string('role')->default('User');
            $table->timestamp('last_seen')->nullable();

            $table->decimal('wallet', 10, 2)->default(0);
            $table->decimal('earnings', 10, 3)->default(0);  // Total earnings
            $table->decimal('earnings_this_month', 10, 2)->default(0); // Monthly earnings

            $table->boolean('creator')->default(false);

            $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete(); // User upgrade plan

            $table->integer('payout_id')->nullable();
            $table->string('payout_details')->nullable();

            $table->string('referral_code')->unique()->nullable();  // Unique referral code for user
            $table->string('referred_by')->nullable();              // Referral code who invited this user

            $table->string('google_id')->unique()->nullable();
            $table->string('facebook_id')->unique()->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('mobile_number')->primary();  // Changed from email to mobile number
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // You will need additional tables like:
        // plans, wallet_transactions, withdrawals, referrals, videos, video_views
        // Let me know if you want migrations for those too!
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
