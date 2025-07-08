<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_payees', function (Blueprint $table) {
         $table->id(); // bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
         $table->unsignedBigInteger('old_id')->nullable();
         $table->unsignedBigInteger('parent_id')->nullable();
         $table->unsignedBigInteger('payee_type_id')->nullable();
         $table->unsignedBigInteger('organization_type_id')->nullable();
         $table->string('payee', 500)->nullable();
         $table->string('previously_named', 250)->nullable();
         $table->string('organization_name', 500)->nullable();
         $table->string('organization_acronym', 50)->nullable();
         $table->string('title', 20)->nullable();
         $table->string('first_name', 150)->nullable();
         $table->string('middle_initial', 150)->nullable();
         $table->string('last_name', 150)->nullable();
         $table->string('suffix', 20)->nullable();
         $table->string('tin', 20)->nullable();
         $table->unsignedBigInteger('bank_id')->nullable();
         $table->string('bank_branch', 250)->nullable();
         $table->string('bank_account_name', 250)->nullable();
         $table->string('bank_account_name1', 250)->nullable();
         $table->string('bank_account_name2', 100)->nullable();
         $table->string('bank_account_no', 50)->nullable();
         $table->string('address', 500)->nullable();
         $table->string('office_address', 500)->nullable();
         $table->string('email_address', 100)->nullable();
         $table->string('contact_no', 50)->nullable();
         $table->boolean('for_remit')->default(0);
         $table->string('bg_color', 10)->nullable();
         $table->boolean('is_verified')->default(0);
         $table->boolean('is_lbp_enrolled')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);
         $table->softDeletes()->nullable()->default(null);

         $table->foreign('bank_id')->references('id')->on('commonlibrariesdbv1.banks')->onDelete('restrict')->onUpdate('restrict');
         $table->foreign('payee_type_id')->references('id')->on('library_payee_type')->onDelete('restrict')->onUpdate('restrict');
         $table->foreign('parent_id')->references('id')->on('library_payees')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_payees');
   }
};
