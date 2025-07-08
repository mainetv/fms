<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('allotment', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('division_id')->nullable();
         $table->unsignedBigInteger('reference_qop_id')->nullable();
         $table->string('year', 4)->nullable();
         $table->unsignedBigInteger('rs_type_id')->nullable();
         $table->integer('cost_type_id')->nullable();
         $table->unsignedBigInteger('allotment_fund_id')->nullable();
         $table->unsignedBigInteger('pap_id')->nullable();
         $table->unsignedBigInteger('activity_id')->nullable();
         $table->unsignedBigInteger('subactivity_id')->nullable();
         $table->unsignedBigInteger('expense_account_id')->nullable();
         $table->unsignedBigInteger('object_expenditure_id')->nullable();
         $table->unsignedBigInteger('object_specific_id')->nullable();
         $table->unsignedBigInteger('pooled_at_division_id')->nullable();
         $table->double('q1_allotment')->default(0);
         $table->double('q2_allotment')->default(0);
         $table->double('q3_allotment')->default(0);
         $table->double('q4_allotment')->default(0);
         $table->double('q1_nca')->default(0);
         $table->double('q2_nca')->default(0);
         $table->double('q3_nca')->default(0);
         $table->double('q4_nca')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         // Uncomment if you want to add foreign keys (make sure referenced tables exist)
         // $table->foreign('allotment_fund_id')->references('id')->on('allotment_funds')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('year')->references('year')->on('fiscal_years')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('activity_id')->references('id')->on('library_activities')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('expense_account_id')->references('id')->on('library_expense_accounts')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('object_expenditure_id')->references('id')->on('library_object_expenditures')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('object_specific_id')->references('id')->on('library_object_specifics')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('pap_id')->references('id')->on('library_paps')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('subactivity_id')->references('id')->on('library_subactivities')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('division_id')->references('id')->on('pcaarrd_divisions')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('pooled_at_division_id')->references('id')->on('pcaarrd_divisions')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('rs_type_id')->references('id')->on('request_status_types')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('allotment');
   }
};
