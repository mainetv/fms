<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_statuses', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT
         $table->string('status', 250)->nullable();
         $table->text('description')->nullable();
         $table->string('module_id', 10)->nullable();
         $table->string('role_id_from', 10)->nullable();
         $table->string('role_id_to', 10)->nullable();
         $table->text('tags')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_statuses');
   }
};
