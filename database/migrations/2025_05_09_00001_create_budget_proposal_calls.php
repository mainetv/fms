<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('fiscal_year', function (Blueprint $table) {
         $table->id();
         $table->string('year', 4)->nullable()->index();
         $table->string('fiscal_year1', 4)->nullable();
         $table->string('fiscal_year2', 4)->nullable();
         $table->string('fiscal_year3', 4)->nullable();
         $table->date('open_date_from')->nullable();
         $table->date('open_date_to')->nullable();
         $table->string('filename', 500)->nullable();
         $table->boolean('is_locked')->default(1)->comment('0-no, 1-yes');
         $table->boolean('is_active')->default(1)->comment('0-no, 1-yes');
         $table->boolean('is_deleted')->default(0)->comment('0-no, 1-yes');
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('fiscal_year');
   }
};
