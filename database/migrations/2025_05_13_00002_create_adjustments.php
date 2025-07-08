<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('adjustment', function (Blueprint $table) {
         $table->id(); // bigint AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('allotment_id')->nullable();
         $table->unsignedBigInteger('adjustment_type_id');
         $table->date('date')->nullable();
         $table->string('reference_no', 25)->nullable();
         $table->double('q1_adjustment')->default(0);
         $table->double('q2_adjustment')->default(0);
         $table->double('q3_adjustment')->default(0);
         $table->double('q4_adjustment')->default(0);
         $table->text('remarks')->nullable();
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
      Schema::connection($connection)->dropIfExists('adjustment');
   }
};
