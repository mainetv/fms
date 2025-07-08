<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('monthly_cash_programs', function (Blueprint $table) {
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
         $table->double('jan_amount')->nullable();
         $table->double('feb_amount')->nullable();
         $table->double('mar_amount')->nullable();
         $table->double('apr_amount')->nullable();
         $table->double('may_amount')->nullable();
         $table->double('jun_amount')->nullable();
         $table->double('jul_amount')->nullable();
         $table->double('aug_amount')->nullable();
         $table->double('sep_amount')->nullable();
         $table->double('oct_amount')->nullable();
         $table->double('nov_amount')->nullable();
         $table->double('dec_amount')->nullable();

         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         // Foreign keys (optional, add if needed):
         // $table->foreign('division_id')->references('id')->on('commonlibrariesdb.pcaarrd_divisions')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('reference_allotment_id')->references('id')->on('allotment')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('activity_id')->references('id')->on('library_activity')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('expense_account_id')->references('id')->on('library_expense_account')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('object_expenditure_id')->references('id')->on('library_object_expenditure')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('object_specific_id')->references('id')->on('library_object_specific')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('pooled_at_division_id')->references('id')->on('commonlibrariesdb.pcaarrd_divisions')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('subactivity_id')->references('id')->on('library_subactivity')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('monthly_cash_programs');
   }
};
