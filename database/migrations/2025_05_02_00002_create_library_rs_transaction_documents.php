<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_rs_document', function (Blueprint $table) {
         $table->id(); // bigint AUTO_INCREMENT
         $table->string('document', 500)->nullable();
         $table->foreignId('rs_transaction_type_id')->nullable()->constrained('library_rs_transaction_types')->restrictOnDelete()->restrictOnUpdate();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_rs_document');
   }
};
