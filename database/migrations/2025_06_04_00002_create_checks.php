<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('checks', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('dv_id')->nullable();
         $table->date('check_date')->nullable();
         $table->string('check_no', 100)->nullable();
         $table->unsignedBigInteger('fund_id')->nullable();
         $table->unsignedBigInteger('bank_account_id')->nullable();
         $table->unsignedBigInteger('acic_id')->nullable();
         $table->date('date_released')->nullable();
         $table->boolean('is_active')->default(true);
         $table->boolean('is_deleted')->default(false);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);

         // Indexes
         $table->index('dv_id', 'FK_checks_dv_idx');
         $table->index('fund_id', 'FK_checks_fund_idx');
         $table->index('bank_account_id', 'FK_checks_library_bank_accounts_idx');

         // Foreign keys
         $table->foreign('fund_id')->references('id')->on('commonlibrariesdbv1.funds')->onDelete('restrict')->onUpdate('restrict');
         $table->foreign('bank_account_id')->references('id')->on('library_bank_accounts')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('checks');
   }
};
