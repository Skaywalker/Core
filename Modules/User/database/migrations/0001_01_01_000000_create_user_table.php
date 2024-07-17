<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();

            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();

            if (Fortify::confirmsTwoFactorAuthentication()) {
                $table->timestamp('two_factor_confirmed_at')
                    ->after('two_factor_recovery_codes')
                    ->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {if (Schema::hasTable('users')&& DB::table('users')->count()) {
            Schema::dropIfExists('old_users');
            Schema::rename('users', 'old_users');
        }
        if (Schema::hasTable('password_reset_tokens')&& DB::table('password_reset_tokens')->count()) {
            Schema::dropIfExists('old_users');
            Schema::rename('users', 'old_users');
            Schema::dropIfExists('old_password_reset_tokens');
            Schema::rename('password_reset_tokens', 'old_password_reset_tokens');
        }
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
