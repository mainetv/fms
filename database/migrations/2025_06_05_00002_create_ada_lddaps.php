<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('ada_lddap', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('ada_id')->nullable();
         $table->unsignedBigInteger('lddap_id')->nullable();
         $table->string('check_no', 50)->nullable();
         $table->double('ps_amount')->default(0);
         $table->double('mooe_amount')->default(0);
         $table->double('co_amount')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         // Indexes
         $table->index('ada_id', 'FK_ada_lddap_ada_idx');
         $table->index('lddap_id', 'FK_ada_lddap_lddap_idx');

         // Foreign keys
         $table->foreign('ada_id')->references('id')->on('ada')->onDelete('restrict')->onUpdate('restrict');
         $table->foreign('lddap_id')->references('id')->on('lddap')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('ada_lddap');
   }
};
