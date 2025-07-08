<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('cp_comments', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('cash_program_id');
         $table->text('comment')->nullable();
         $table->string('comment_by', 20)->nullable();
         $table->boolean('is_resolved')->default(false);
         $table->boolean('is_active')->default(true);
         $table->boolean('is_deleted')->default(false);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);

         $table->foreign('cash_program_id')
            ->references('id')
            ->on('monthly_cash_programs')
            ->onDelete('restrict')
            ->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('cp_comments');
   }
};
