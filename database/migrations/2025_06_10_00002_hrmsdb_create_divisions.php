<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->create('divisions', function (Blueprint $table) {
         $table->id(); // Auto-incrementing primary key
         $table->string('division_id', 10)->nullable()->index();
         $table->string('division_acro', 20)->nullable();
         $table->string('division_desc', 100)->nullable();
         $table->char('cluster', 3)->nullable();
         $table->integer('type')->nullable();
         $table->char('code', 5)->nullable();
         $table->timestamps();
         $table->softDeletes(); // deleted_at
      });
   }

   public function down()
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      Schema::connection($connection)->dropIfExists('divisions');
   }
};
