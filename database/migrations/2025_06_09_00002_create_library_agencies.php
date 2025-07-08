<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('agency', function (Blueprint $table) {
         $table->id();
         $table->string('agency', 500);
         $table->string('acronym', 500)->nullable();
         $table->string('street', 50)->nullable();
         $table->foreignId('barangay_id')->nullable()->comment('location_barangay');
         $table->foreignId('municipality_id')->nullable()->comment('location_municipality');
         $table->foreignId('province_id')->nullable()->comment('location_province');
         $table->string('telno', 50)->nullable();
         $table->string('faxno', 50)->nullable();
         $table->string('email', 50)->nullable();
         $table->string('website', 100)->nullable();
         $table->foreignId('head_agency_id')->nullable()->comment('agency.id');
         $table->foreignId('consortium_id')->nullable()->comment('consortium.id');
         $table->foreignId('consortium_type_id')->nullable()->comment('consortium_type.id');
         $table->foreignId('agency_category_id')->nullable()->comment('agency_category.id');
         $table->foreignId('agency_class_id')->nullable()->comment('agency_class.id');
         $table->foreignId('agency_group_id')->nullable()->comment('agency_group.id');
         $table->foreignId('agency_subgroup_id')->nullable()->comment('agency_subgroup.id');
         $table->foreignId('agency_type_id')->nullable()->comment('agency_type.id');
         $table->string('tags', 500)->nullable();
         $table->boolean('is_verified')->default(false)->comment('0-no, 1-yes');
         $table->boolean('is_active')->default(true)->comment('0-no, 1-yes');
         $table->boolean('is_deleted')->default(false)->comment('0-no, 1-yes');
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->useCurrent();
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('agency');
   }
};
