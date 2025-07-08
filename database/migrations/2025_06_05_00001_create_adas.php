<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('ada', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->string('ada_no', 50)->nullable();
         $table->date('ada_date')->nullable();
         $table->unsignedBigInteger('fund_id')->nullable();
         $table->unsignedBigInteger('bank_account_id')->nullable();
         $table->string('check_no', 50)->nullable();
         $table->double('total_ps_amount')->default(0);
         $table->double('total_mooe_amount')->default(0);
         $table->double('total_co_amount')->default(0);
         $table->date('date_transferred')->nullable();
         $table->string('signatory1', 250)->nullable();
         $table->string('signatory1_position', 250)->nullable();
         $table->string('signatory2', 250)->nullable();
         $table->string('signatory2_position', 250)->nullable();
         $table->string('signatory3', 250)->nullable();
         $table->string('signatory3_position', 250)->nullable();
         $table->string('signatory4', 250)->nullable();
         $table->string('signatory4_position', 250)->nullable();
         $table->string('signatory5', 250)->nullable();
         $table->string('signatory5_position', 250)->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         // Indexes
         $table->index('fund_id', 'FK_ada_fund_idx');
         $table->index('bank_account_id', 'FK_ada_bank_account_idx');

         // Foreign keys
         $table->foreign('fund_id')->references('id')->on('commonlibrariesdbv1.funds')->onDelete('restrict')->onUpdate('restrict');
         $table->foreign('bank_account_id')->references('id')->on('library_bank_accounts')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('ada');
   }
};
