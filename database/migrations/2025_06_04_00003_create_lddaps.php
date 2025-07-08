<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('lddap', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('ada_id')->nullable();
         $table->string('lddap_no', 30)->nullable();
         $table->date('lddap_date')->nullable();
         $table->unsignedBigInteger('payment_mode_id')->nullable();
         $table->unsignedBigInteger('fund_id');
         $table->string('nca_no', 15)->nullable();
         $table->unsignedBigInteger('bank_account_id')->nullable();
         $table->string('check_no', 250)->nullable();
         $table->string('acic_no', 15)->nullable();
         $table->double('total_lddap_gross_amount')->default(0);
         $table->double('total_lddap_net_amount')->default(0);
         $table->string('signatory1', 35)->nullable();
         $table->string('signatory1_position', 50)->nullable();
         $table->string('signatory2', 35)->nullable();
         $table->string('signatory2_position', 50)->nullable();
         $table->string('signatory3', 35)->nullable();
         $table->string('signatory3_position', 50)->nullable();
         $table->string('signatory4', 35)->nullable();
         $table->string('signatory4_position', 50)->nullable();
         $table->string('signatory5', 35)->nullable();
         $table->string('signatory5_position', 50)->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         // Indexes
         $table->index('ada_id', 'FK_lddap_adas_idx');
         $table->index('bank_account_id', 'FK_lddap_bank_account_idx');
         $table->index('fund_id', 'FK_lddap_fund_idx');

         // Foreign keys
         $table->foreign('bank_account_id')->references('id')->on('library_bank_accounts')->onDelete('restrict')->onUpdate('restrict');
         $table->foreign('fund_id')->references('id')->on('commonlibrariesdbv1.funds')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('lddap');
   }
};
