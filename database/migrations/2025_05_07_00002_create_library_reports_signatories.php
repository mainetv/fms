<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_reports_signatory', function (Blueprint $table) {
         $table->id(); // bigint AUTO_INCREMENT
         $table->unsignedBigInteger('report_id');
         $table->string('signatory1')->nullable();
         $table->string('signatory1_position')->nullable();
         $table->string('signatory2')->nullable();
         $table->string('signatory2_position')->nullable();
         $table->string('signatory3')->nullable();
         $table->string('signatory3_position')->nullable();
         $table->string('signatory4')->nullable();
         $table->string('signatory4_position')->nullable();
         $table->string('signatory5')->nullable();
         $table->string('signatory5_position')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_reports_signatory');
   }
};
