<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('bp_form205', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('division_id');
         $table->string('year', 4)->nullable();
         $table->string('fiscal_year', 4)->nullable();
         $table->unsignedBigInteger('retirement_law_id');
         $table->string('emp_code');
         $table->string('position_id_at_retirement_date', 10)->nullable();
         $table->double('highest_monthly_salary')->nullable();
         $table->string('sl_credits_earned', 20)->nullable();
         $table->string('vl_credits_earned', 20)->nullable();
         $table->double('leave_amount')->nullable();
         $table->double('total_creditable_service')->nullable();
         $table->string('num_gratuity_months', 10)->nullable();
         $table->double('gratuity_amount')->nullable();
         $table->text('remarks')->nullable();
         $table->boolean('is_gsis')->default(1);

         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         // Note: Foreign keys for `year` and `division_id` are referenced in the original SQL but no table structure given for year FK, so not added here.
         // Add foreign keys if needed like:
         // $table->foreign('division_id')->references('id')->on('commonlibrariesdb.pcaarrd_divisions');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('bp_form205');
   }
};
