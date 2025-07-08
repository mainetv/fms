<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('dv_rs', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('dv_id');
         $table->unsignedBigInteger('rs_id');
         $table->double('amount')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         $table->index('dv_id', 'FK_dv_rs_dv_idx');
         $table->index('rs_id', 'FK_dv_rs_rs_idx');

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
      Schema::connection($connection)->dropIfExists('dv_rs');
   }
};
