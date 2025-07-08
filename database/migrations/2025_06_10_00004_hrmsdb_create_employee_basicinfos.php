<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->create('employee_basicinfos', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->integer('user_id')->nullable();
         $table->string('empcode', 50)->nullable();
         $table->text('basicinfo_placeofbirth')->nullable();
         $table->enum('basicinfo_sex', ['Male', 'Female'])->nullable();
         $table->string('basicinfo_civilstatus')->nullable();
         $table->string('basicinfo_citizenship')->nullable();
         $table->string('basicinfo_citizentype')->nullable();
         $table->float('basicinfo_height')->nullable();
         $table->float('basicinfo_weight')->nullable();
         $table->string('basicinfo_bloodtype', 5)->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }

   public function down()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->dropIfExists('employee_basicinfos');
   }
};
