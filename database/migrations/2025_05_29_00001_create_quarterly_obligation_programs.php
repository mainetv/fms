<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('quarterly_obligation_programs', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('reference_allotment_id');
         $table->unsignedBigInteger('division_id')->nullable();
         $table->string('year', 4)->nullable();
         $table->unsignedBigInteger('pap_id')->nullable();
         $table->unsignedBigInteger('activity_id')->nullable();
         $table->unsignedBigInteger('subactivity_id')->nullable();
         $table->unsignedBigInteger('expense_account_id')->nullable();
         $table->unsignedBigInteger('object_expenditure_id')->nullable();
         $table->unsignedBigInteger('object_specific_id')->nullable();
         $table->unsignedBigInteger('pooled_at_division_id')->nullable();
         $table->double('q1_amount')->nullable();
         $table->double('q2_amount')->nullable();
         $table->double('q3_amount')->nullable();
         $table->double('q4_amount')->nullable();
         $table->boolean('is_active')->default(true);
         $table->boolean('is_deleted')->default(false);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();

         // You may want to add foreign keys here if applicable, e.g.:
         // $table->foreign('reference_allotment_id')->references('id')->on('allotment')->onDelete('restrict')->onUpdate('restrict');
         // ... add others as needed ...
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('quarterly_obligation_programs');
   }
};
