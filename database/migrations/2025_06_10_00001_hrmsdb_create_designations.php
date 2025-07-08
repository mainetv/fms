<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->create('designations', function (Blueprint $table) {
         $table->bigIncrements('designation_id');
         $table->string('designation_desc')->nullable();
         $table->string('designation_abbr')->nullable()->index();
         $table->string('designation_type')->nullable();
         $table->timestamps();
         $table->softDeletes();

         $table->index('designation_id');
      });
   }

   public function down()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->dropIfExists('designations');
   }
};
