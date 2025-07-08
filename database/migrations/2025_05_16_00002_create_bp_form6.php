<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('bp_form6', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('division_id');
         $table->string('year', 4);
         $table->tinyInteger('tier')->default(1);
         $table->string('fiscal_year', 4)->nullable();
         $table->text('description')->nullable();
         $table->integer('quantity')->nullable();
         $table->double('unit_cost')->nullable();
         $table->double('total_cost')->nullable();
         $table->text('organizational_deployment')->nullable();
         $table->text('justification')->nullable();
         $table->text('remarks')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();

         $table->foreign('division_id')
            ->references('id')
            ->on('commonlibrariesdb.pcaarrd_divisions')
            ->onUpdate('restrict')
            ->onDelete('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('bp_form6');
   }
};
