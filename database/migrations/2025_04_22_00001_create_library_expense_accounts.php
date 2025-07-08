<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_expense_account', function (Blueprint $table) {
            $table->id();
            $table->string('expense_account', 100)->nullable();
            $table->string('expense_account_code', 50)->nullable();
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->unsignedBigInteger('subactivity_id')->nullable();
            $table->unsignedBigInteger('request_status_type_id')->nullable();
            $table->unsignedBigInteger('allotment_class_id');
            $table->text('tags')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->softDeletes()->nullable()->default(null);

            // Indexes
            $table->index('activity_id', 'FK_expense_accounts_activity_idx');
            $table->index('subactivity_id', 'FK_expense_accounts_subactivity_idx');
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_expense_account');
    }
};
