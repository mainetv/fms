<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      // Add ada_id FK to disbursement_vouchers
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->table('lddap', function (Blueprint $table) {
         $table->foreign('ada_id', 'FK_lddap_adas_idx')
            ->references('id')->on('ada')
            ->onDelete('restrict')
            ->onUpdate('restrict');
      });

   
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->table('lddap', function (Blueprint $table) {
         $table->dropForeign(['ada_id']);
      });      
   }
};
