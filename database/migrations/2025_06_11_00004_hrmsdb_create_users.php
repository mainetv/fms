<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->create('users', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->integer('dtr_exe')->nullable();
         $table->integer('oic')->nullable();
         $table->string('lname')->nullable();
         $table->string('fname')->nullable();
         $table->string('mname')->nullable();
         $table->string('exname')->nullable();
         $table->date('birthdate')->nullable();
         $table->text('birthplace')->nullable();
         $table->string('username')->nullable();
         $table->string('rfid')->nullable();
         $table->enum('usertype', ['Administrator', 'Director', 'Marshal', 'Staff', 'COS Admin'])->nullable();
         $table->string('division', 10)->nullable();
         $table->string('division2', 10)->nullable();
         $table->enum('sex', ['Male', 'Female'])->nullable();
         $table->integer('employment_id')->nullable();
         $table->string('email')->nullable();
         $table->timestamp('email_verified_at')->nullable();
         $table->string('password')->nullable();
         $table->string('remember_token', 100)->nullable();
         $table->dateTime('fldservice')->nullable();
         $table->text('pickup')->nullable();
         $table->string('cellnum', 15)->nullable();
         $table->string('image_path')->nullable();
         $table->integer('payroll')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }

   public function down()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->dropIfExists('users');
   }
};
