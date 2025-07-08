<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_signatories', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT
         $table->foreignId('user_id')->nullable()->constrained('users')->restrictOnDelete()->restrictOnUpdate();
         $table->unsignedBigInteger('module_id')->nullable();
         $table->tinyInteger('signatory_no')->nullable();
         $table->unsignedBigInteger('form_id')->nullable();
         $table->boolean('is_default')->default(0);
         $table->text('tags')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();

         // $table->index('form_id', 'FK_signatories_forms_idx');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_signatories');
   }
};
