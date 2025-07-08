<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('emp_code');
            $table->unsignedBigInteger('user_role_id')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('password');
            // $table->text('two_factor_secret')->nullable();
            // $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable()->default(null);
            $table->rememberToken();
            $table->unsignedBigInteger('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
            // Optional: Uncomment if soft deletes are needed
            // $table->softDeletes()->nullable()->default(null);

            $table->foreign('user_role_id')->references('id')->on('user_roles')->restrictOnDelete()->restrictOnUpdate();
            // No foreign key added for emp_code (assumed to be from external/HRMS system)
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('users');
    }
};
