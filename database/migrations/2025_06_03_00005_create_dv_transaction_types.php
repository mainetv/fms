<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('dv_transaction_type', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('dv_id')->nullable();
         $table->unsignedBigInteger('dv_transaction_type_id')->nullable();

         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         $table->foreign('dv_id')
            ->references('id')
            ->on('disbursement_vouchers')
            ->onUpdate('restrict')
            ->onDelete('restrict');

         $table->foreign('dv_transaction_type_id')
            ->references('id')
            ->on('library_dv_transaction_types')
            ->onUpdate('restrict')
            ->onDelete('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('dv_transaction_type');
   }
};
