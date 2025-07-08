<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->create('positions', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->string('position_id', 10)->nullable()->index();
         $table->string('position_abbr', 50)->nullable();
         $table->string('position_desc', 255)->nullable();
         $table->enum('position_class', ['Technical', 'Administrative'])->nullable();
         $table->integer('stepincrement_id')->nullable();
         $table->timestamps();
         $table->softDeletes();
      });
   }

   public function down()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->dropIfExists('positions');
   }
};
