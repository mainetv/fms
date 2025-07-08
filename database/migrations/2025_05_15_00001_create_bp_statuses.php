<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('bp_status', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('division_id');
         $table->string('year', 4);
         $table->unsignedBigInteger('status_id')->nullable();
         $table->unsignedBigInteger('status_by_user_id');
         $table->unsignedBigInteger('status_by_user_role_id');
         $table->unsignedBigInteger('status_by_user_division_id');
         $table->date('date')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);

         $table->foreign('division_id')
            ->references('id')
            ->on('commonlibrariesdb.pcaarrd_divisions')
            ->onUpdate('restrict')
            ->onDelete('restrict');

         $table->foreign('status_id')
            ->references('id')
            ->on('library_statuses')
            ->onUpdate('restrict')
            ->onDelete('restrict');

         $table->foreign('status_by_user_id')
            ->references('id')
            ->on('users')
            ->onUpdate('restrict')
            ->onDelete('restrict');

         $table->foreign('status_by_user_role_id')
            ->references('id')
            ->on('user_roles')
            ->onUpdate('restrict')
            ->onDelete('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('bp_status');
   }
};
