<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('bp_form8', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('division_id');
         $table->string('year', 4);
         $table->string('fiscal_year', 4)->nullable();
         $table->text('name')->nullable();
         $table->text('proposed_date')->nullable();
         $table->text('destination')->nullable();
         $table->double('amount')->nullable();
         $table->text('purpose_travel')->nullable();
         $table->text('remarks')->nullable();

         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         $table->foreign('division_id')->references('id')->on('commonlibrariesdb.pcaarrd_divisions')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('bp_form8');
   }
};
