<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('prefix_number', function (Blueprint $table) {
         $table->id(); // bigint AUTO_INCREMENT PRIMARY KEY
         $table->string('prefix_code', 50)->nullable();
         $table->unsignedBigInteger('rs_type_id')->nullable();
         $table->unsignedBigInteger('fund_id')->nullable();
         $table->text('tags')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->nullable()->default(null);
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         $table->foreign('rs_type_id')
            ->references('id')
            ->on('library_request_status_types')
            ->onUpdate('restrict')
            ->onDelete('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('prefix_number');
   }
};
