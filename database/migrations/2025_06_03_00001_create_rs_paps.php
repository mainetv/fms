<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('rs_pap', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('rs_id')->nullable();
         $table->unsignedBigInteger('allotment_id')->nullable();
         $table->double('amount')->default(0);
         $table->string('notice_adjustment_no', 100)->nullable();
         $table->date('notice_adjustment_date')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         $table->index('rs_id', 'FK_rs_pap_request_statuses_idx');
         $table->index('allotment_id', 'FK_rs_pap_allotments_idx');

         $table->foreign('allotment_id')
            ->references('id')->on('allotment')
            ->onDelete('restrict')
            ->onUpdate('restrict');

         $table->foreign('rs_id')
            ->references('id')->on('request_status')
            ->onDelete('restrict')
            ->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('rs_pap');
   }
};
