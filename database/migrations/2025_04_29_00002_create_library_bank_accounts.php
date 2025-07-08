<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_bank_accounts', function (Blueprint $table) {
            $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('bank_branch', 250)->nullable();
            $table->string('bank_account_no', 250)->nullable();
            $table->unsignedBigInteger('fund_id');
            $table->boolean('is_collection');
            $table->boolean('is_disbursement');
            $table->unsignedBigInteger('cash_fund_id')->nullable();
            $table->string('fund_cluster', 250)->nullable();
            $table->boolean('is_default')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->softDeletes()->nullable()->default(null);
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_bank_accounts');
    }
};
