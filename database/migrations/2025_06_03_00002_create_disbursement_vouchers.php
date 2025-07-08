<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('disbursement_vouchers', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('fais_id')->nullable();
         $table->unsignedBigInteger('lddap_id')->nullable();
         $table->unsignedBigInteger('check_id')->nullable();
         $table->string('dv_no', 30)->nullable();
         $table->date('dv_date')->nullable();
         $table->date('dv_date1')->nullable();
         $table->unsignedBigInteger('division_id')->nullable();
         $table->unsignedBigInteger('fund_id')->nullable();
         $table->unsignedBigInteger('payee_id')->nullable();
         $table->double('total_dv_gross_amount')->default(0);
         $table->double('total_dv_net_amount')->default(0);
         $table->text('particulars')->nullable();
         $table->string('signatory1', 35)->nullable();
         $table->string('signatory1_position', 50)->nullable();
         $table->string('signatory2', 35)->nullable();
         $table->string('signatory2_position', 50)->nullable();
         $table->string('signatory3', 35)->nullable();
         $table->string('signatory3_position', 50)->nullable();
         $table->unsignedBigInteger('tax_type_id')->nullable();
         $table->unsignedBigInteger('pay_type_id')->nullable();
         $table->date('date_out')->nullable();
         $table->string('out_to', 50)->nullable();
         $table->string('received_from', 50)->nullable();
         $table->date('date_returned')->nullable();
         $table->string('po_no', 50)->nullable();
         $table->date('po_date')->nullable();
         $table->string('invoice_no', 50)->nullable();
         $table->date('invoice_date')->nullable();
         $table->string('jobcon_no', 50)->nullable();
         $table->date('jobcon_date')->nullable();
         $table->string('or_no', 50)->nullable();
         $table->date('or_date')->nullable();
         $table->string('cod_no', 50)->nullable();
         $table->boolean('is_locked')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->dateTime('cancelled_at')->nullable();
         $table->dateTime('locked_at')->nullable();
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         $table->index('payee_id', 'FK_dv_payees_idx');
         $table->index('division_id', 'FK_dv_library_divisions_idx');
         $table->index('lddap_id', 'FK_dv_lddaps_idx');
         $table->index('check_id', 'FK_dv_checks_idx');

         $table->foreign('payee_id')
            ->references('id')->on('library_payees')
            ->onDelete('restrict')
            ->onUpdate('restrict');

         $table->foreign('division_id')
            ->references('id')
            ->on('commonlibrariesdbv1.divisions')
            ->onDelete('restrict')
            ->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('disbursement_vouchers');
   }
};
