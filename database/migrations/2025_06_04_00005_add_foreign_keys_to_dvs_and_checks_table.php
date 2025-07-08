<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      // Add check_id FK to disbursement_vouchers
      Schema::table('disbursement_vouchers', function (Blueprint $table) {
         $table->foreign('check_id', 'FK_dv_checks_idx')
            ->references('id')->on('checks')
            ->onDelete('restrict')
            ->onUpdate('restrict');
      });

      // Add dv_id FK to checks
      Schema::table('checks', function (Blueprint $table) {
         $table->foreign('dv_id', 'FK_checks_dv_idx')
            ->references('id')->on('disbursement_vouchers')
            ->onDelete('restrict')
            ->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      Schema::table('disbursement_vouchers', function (Blueprint $table) {
         $table->dropForeign(['check_id']);
      });

      Schema::table('checks', function (Blueprint $table) {
         $table->dropForeign(['dv_id']);
      });
   }
};
