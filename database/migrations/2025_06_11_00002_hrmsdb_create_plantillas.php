<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->create('plantillas', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->integer('user_id')->nullable();
         $table->string('username')->nullable();
         $table->string('plantilla_division', 10)->nullable();
         $table->string('plantilla_item_number', 100)->nullable();
         $table->string('position_id', 10)->nullable();
         $table->integer('designation_id')->nullable();
         $table->integer('plantilla_step')->nullable();
         $table->integer('employment_id')->nullable();
         $table->double('plantilla_salary')->nullable();
         $table->float('salary_grade')->nullable();
         $table->date('plantilla_date_from')->nullable();
         $table->date('plantilla_date_to')->nullable();
         $table->integer('plantilla_special')->nullable();
         $table->string('plantilla_remarks')->nullable();
         $table->timestamps();
         $table->softDeletes();
         $table->string('ehrms_plantilla_id')->nullable();
         $table->string('fk_position_id', 10)->nullable();

         $table->index('plantilla_item_number');
         $table->index('user_id');
         $table->index('position_id');
         $table->index('designation_id');
         $table->index('fk_position_id');
      });
   }

   public function down()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->dropIfExists('plantillas');
   }
};
