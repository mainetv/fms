<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('nca', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('fund_id');
         $table->integer('year');
         $table->double('jan_nca')->default(0);
         $table->double('feb_nca')->default(0);
         $table->double('mar_nca')->default(0);
         $table->double('apr_nca')->default(0);
         $table->double('may_nca')->default(0);
         $table->double('jun_nca')->default(0);
         $table->double('jul_nca')->default(0);
         $table->double('aug_nca')->default(0);
         $table->double('sep_nca')->default(0);
         $table->double('oct_nca')->default(0);
         $table->double('nov_nca')->default(0);
         $table->double('dec_nca')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);

         // Add indexes or foreign keys if needed (not present in original)
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('nca');
   }
};
