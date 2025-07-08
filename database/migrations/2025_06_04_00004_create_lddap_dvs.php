<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('lddap_dv', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('lddap_id')->nullable();
         $table->unsignedBigInteger('dv_id')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         // Indexes
         $table->index('dv_id', 'FK_lddap_dv_dv_idx');
         $table->index('lddap_id', 'FK_lddap_dv_lddap_idx');

         // Foreign keys
         $table->foreign('dv_id')->references('id')->on('disbursement_vouchers')->onDelete('restrict')->onUpdate('restrict');
         $table->foreign('lddap_id')->references('id')->on('lddap')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('lddap_dv');
   }
};
