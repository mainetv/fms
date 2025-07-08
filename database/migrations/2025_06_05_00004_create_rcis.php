<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('rci', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->date('rci_date')->nullable();
         $table->string('rci_no', 30)->nullable();
         $table->unsignedBigInteger('fund_id')->nullable();
         $table->unsignedBigInteger('bank_account_id')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         // Indexes
         // $table->unique(['rci_date', 'fund_id', 'bank_account_id'], 'rcidate');
         $table->index('rci_no');
         $table->index('fund_id');
         $table->index('bank_account_id');
         $table->index('rci_date');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('rci');
   }
};
