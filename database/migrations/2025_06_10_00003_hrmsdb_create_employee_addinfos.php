<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->create('employee_addinfos', function (Blueprint $table) {
         $table->id(); // Auto-incrementing primary key
         $table->integer('user_id')->nullable()->index();
         $table->string('empcode', 50)->nullable()->index();
         $table->string('empcode_id', 50)->nullable();
         $table->string('addinfo_pagibig')->nullable();
         $table->string('addinfo_philhealth')->nullable();
         $table->string('addinfo_sss')->nullable();
         $table->string('addinfo_tin')->nullable();
         $table->string('addinfo_gsis_id')->nullable();
         $table->string('addinfo_gsis_policy')->nullable();
         $table->string('addinfo_gsis_bp')->nullable();
         $table->string('addinfo_partner')->nullable();
         $table->string('addinfo_landbank', 50)->nullable();
         $table->string('addinfo_atm', 50)->nullable();
         $table->string('addinfo_gov')->nullable();
         $table->string('addinfo_gov_id')->nullable();
         $table->string('addinfo_gov_place_date')->nullable();
         $table->string('addinfo_ctc')->nullable();
         $table->string('addinfo_ctc_date')->nullable();
         $table->string('addinfo_ctc_place')->nullable();
         $table->timestamps();
      });
   }

   public function down()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->dropIfExists('employee_addinfos');
   }
};
