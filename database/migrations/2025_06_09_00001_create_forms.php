<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('forms', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED with AUTO_INCREMENT
         $table->string('form', 50)->nullable();
         $table->string('desription', 100)->nullable(); // Note: spelling preserved from SQL
         $table->timestamp('tags')->nullable(); // This appears to be a timestamp in SQL
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('forms');
   }
};
