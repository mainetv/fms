<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('dv_rs_net', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('dv_id');
         $table->unsignedBigInteger('rs_id');
         $table->double('gross_amount')->default(0);
         $table->double('tax_one')->default(0);
         $table->double('tax_two')->default(0);
         $table->double('tax_twob')->default(0);
         $table->double('tax_three')->default(0);
         $table->double('tax_four')->default(0);
         $table->double('tax_five')->default(0);
         $table->double('tax_six')->default(0);
         $table->double('wtax')->default(0);
         $table->double('other_tax')->default(0);
         $table->double('liquidated_damages')->default(0);
         $table->double('other_deductions')->default(0);
         $table->double('net_amount')->default(0);
         $table->unsignedBigInteger('allotment_class_id')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         $table->index('rs_id', 'FK_dv_rs_net_rs_idx');
         $table->index('dv_id', 'FK_dv_rs_net_dv_idx');
         $table->index('allotment_class_id', 'FK_dv_rs_net_allotment_class_idx');

         $table->foreign('allotment_class_id')
            ->references('id')->on('commonlibrariesdbv1.allotment_classes')
            ->onDelete('restrict')
            ->onUpdate('restrict');

         $table->foreign('dv_id')
            ->references('id')->on('disbursement_vouchers')
            ->onDelete('restrict')
            ->onUpdate('restrict');

         $table->foreign('rs_id')
            ->references('id')->on('request_status')
            ->onDelete('restrict')
            ->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('dv_rs_net');
   }
};
