<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_object_expenditure', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('old_id')->nullable();
            $table->string('object_expenditure', 250);
            $table->string('object_code', 25)->nullable();
            $table->unsignedBigInteger('expense_account_id')->nullable();
            $table->unsignedBigInteger('allotment_class_id')->nullable();
            $table->boolean('is_gia')->default(0);
            $table->unsignedBigInteger('request_status_type_id')->nullable();
            $table->string('remarks', 500)->nullable();
            $table->string('tags', 500)->nullable();

            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('expense_account_id', 'FK_library_object_expenditures_library_expense_account_idx');
            $table->index('allotment_class_id', 'FK_library_object_expenditures_library_allotment_class_idx');

            // Foreign keys if desired:
            // $table->foreign('expense_account_id')->references('id')->on('library_expense_accounts');
            // $table->foreign('allotment_class_id')->references('id')->on('library_allotment_classes');
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_object_expenditure');
    }
};
