<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->table('user_roles', function (Blueprint $table) {
         $table->boolean('is_active')->default(1)->after('guard_name');
         $table->boolean('is_deleted')->default(1)->after('guard_name');
      });
   }

   public function down()
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->table('user_roles', function (Blueprint $table) {
         $table->dropColumn('is_active');
         $table->dropColumn('is_deleted');
      });
   }
};