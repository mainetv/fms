<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('request_status', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('fais_id')->nullable();
         $table->unsignedBigInteger('rs_type_id')->nullable();
         $table->string('rs_no', 100)->nullable();
         $table->date('rs_date')->nullable();
         $table->date('rs_date1')->nullable();
         $table->unsignedBigInteger('division_id')->nullable();
         $table->unsignedBigInteger('fund_id')->nullable();
         $table->unsignedBigInteger('payee_id')->nullable();
         $table->text('particulars')->nullable();
         $table->double('total_rs_activity_amount')->default(0);
         $table->double('total_rs_pap_amount')->default(0);
         $table->boolean('showall')->default(0);
         $table->string('signatory1', 150)->nullable();
         $table->string('signatory1_position', 100)->nullable();
         $table->string('signatory1b', 150)->nullable();
         $table->string('signatory1b_position', 100)->nullable();
         $table->string('signatory2', 150)->nullable();
         $table->string('signatory2_position', 100)->nullable();
         $table->string('signatory3', 150)->nullable();
         $table->string('signatory3_position', 100)->nullable();
         $table->string('signatory4', 150)->nullable();
         $table->string('signatory4_position', 100)->nullable();
         $table->string('signatory5', 150)->nullable();
         $table->string('signatory5_position', 100)->nullable();
         $table->boolean('is_locked')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->dateTime('locked_at')->nullable();
         $table->dateTime('cancelled_at')->nullable();
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         // Foreign keys (commented, add if needed)
         // $table->foreign('fund_id')->references('id')->on('commonlibrariesdb.funds')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('payee_id')->references('id')->on('library_payees')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('division_id')->references('id')->on('commonlibrariesdb.pcaarrd_divisions')->onDelete('restrict')->onUpdate('restrict');
         // $table->foreign('rs_type_id')->references('id')->on('commonlibrariesdb.request_status_types')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('request_status');
   }
};
