<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('cp_status', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('division_id');
         $table->string('year', 4);
         $table->unsignedBigInteger('status_id')->nullable();
         $table->unsignedBigInteger('status_by_user_id');
         $table->unsignedBigInteger('status_by_user_role_id');
         $table->unsignedBigInteger('status_by_user_division_id');
         $table->date('date')->nullable();
         $table->boolean('is_active')->default(true);
         $table->boolean('is_deleted')->default(false);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);

         $table->foreign('division_id')
            ->references('id')
            ->on('commonlibrariesdbv1.divisions')
            ->onDelete('restrict')
            ->onUpdate('restrict');

         $table->foreign('status_by_user_role_id')
            ->references('id')
            ->on('user_roles')
            ->onDelete('restrict')
            ->onUpdate('restrict');

         $table->foreign('status_by_user_id')
            ->references('id')
            ->on('users')
            ->onDelete('restrict')
            ->onUpdate('restrict');

         // Note: Your SQL didn't add foreign key for status_id or status_by_user_division_id,
         // so I am not adding those FK constraints here.
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('cp_status');
   }
};
