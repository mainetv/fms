<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('rs_activity', function (Blueprint $table) {
         $table->id(); // bigint auto increment primary key 'id'
         $table->unsignedBigInteger('rs_id')->nullable();
         $table->unsignedBigInteger('allotment_id')->nullable();
         $table->double('amount')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();

         // Indexes
         $table->index('allotment_id', 'FK_rs_pap_allotment_idx');
         $table->index('rs_id', 'FK_rs_pap_request_status_idx');

         // Foreign key constraint on allotment_id
         $table->foreign('allotment_id')
            ->references('id')->on('allotment')
            ->onDelete('restrict')
            ->onUpdate('restrict');

         // Note: The original SQL did not specify a foreign key constraint for rs_id, 
         // so it's omitted here. Add if needed.
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('rs_activity');
   }
};
