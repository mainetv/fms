<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->create('employments', function (Blueprint $table) {
         $table->bigIncrements('employment_id');
         $table->string('employment_desc', 100)->nullable()->index();
         $table->timestamps();
         $table->softDeletes();
         $table->index('employment_id');
      });
   }

   public function down()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->dropIfExists('employments');
   }
};
