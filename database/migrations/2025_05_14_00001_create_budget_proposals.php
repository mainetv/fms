<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('budget_proposals', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('division_id')->nullable();
         $table->string('year', 4)->nullable();
         $table->unsignedBigInteger('pap_id')->nullable();
         $table->unsignedBigInteger('activity_id')->nullable();
         $table->unsignedBigInteger('subactivity_id')->nullable();
         $table->unsignedBigInteger('expense_account_id')->nullable();
         $table->unsignedBigInteger('object_expenditure_id')->nullable();
         $table->unsignedBigInteger('object_specific_id')->nullable();
         $table->unsignedBigInteger('pooled_at_division_id')->nullable();
         $table->double('fy1_amount')->nullable();
         $table->double('fy2_amount')->nullable();
         $table->double('fy3_amount')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('budget_proposals');
   }
};
