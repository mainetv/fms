<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('notifications', function (Blueprint $table) {
         $table->id();
         $table->text('message')->nullable();
         $table->unsignedBigInteger('record_id')->nullable();
         $table->unsignedBigInteger('module_id')->nullable();
         $table->string('link', 250)->nullable();
         $table->string('month', 5)->nullable();
         $table->string('year', 4)->nullable();
         $table->string('date', 20)->nullable();

         $table->unsignedBigInteger('division_id')->nullable();
         $table->unsignedBigInteger('division_id_from')->nullable();
         $table->unsignedBigInteger('division_id_to')->nullable();
         $table->unsignedBigInteger('user_id_from')->nullable();
         $table->unsignedBigInteger('user_id_to')->nullable();
         $table->unsignedBigInteger('user_role_id_from')->nullable();
         $table->unsignedBigInteger('user_role_id_to')->nullable();

         $table->text('remarks')->nullable();
         $table->boolean('is_read')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);

         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();

         // Foreign Keys (adjust DB names and constraints in a multi-DB setup)
         $table->foreign('division_id')->references('id')->on('commonlibrariesdb.pcaarrd_divisions')->restrictOnDelete()->restrictOnUpdate();
         $table->foreign('division_id_from')->references('id')->on('commonlibrariesdb.pcaarrd_divisions')->restrictOnDelete()->restrictOnUpdate();
         $table->foreign('division_id_to')->references('id')->on('commonlibrariesdb.pcaarrd_divisions')->restrictOnDelete()->restrictOnUpdate();

         $table->foreign('user_id_from')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
         $table->foreign('user_id_to')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
         $table->foreign('user_role_id_from')->references('id')->on('user_roles')->restrictOnDelete()->restrictOnUpdate();
         $table->foreign('user_role_id_to')->references('id')->on('user_roles')->restrictOnDelete()->restrictOnUpdate();
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('notifications');
   }
};
