<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('bp_form7', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('division_id');
         $table->string('year', 4);
         $table->string('fiscal_year', 4)->nullable();
         $table->text('program')->nullable();
         $table->text('project')->nullable();
         $table->unsignedBigInteger('location_id')->nullable();
         $table->text('beneficiaries')->nullable();
         $table->date('start_date')->nullable();
         $table->date('end_date')->nullable();
         $table->double('total_project_cost')->nullable();
         $table->unsignedBigInteger('implementing_agency_id')->nullable();
         $table->unsignedBigInteger('monitoring_agency_id')->nullable();
         $table->double('fund_allocation_fiscal_year1')->nullable();
         $table->double('fund_allocation_fiscal_year2')->nullable();
         $table->double('fund_allocation_fiscal_year3')->nullable();
         $table->text('remarks')->nullable();
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable();

         // Foreign keys
         $table->foreign('division_id')
            ->references('id')
            ->on('commonlibrariesdbv1.divisions')
            ->onUpdate('restrict')->onDelete('restrict');

         // $table->foreign('location_id')
         //    ->references('id')->on('commonlibrariesdb.location')
         //    ->onUpdate('restrict')->onDelete('restrict');

         // $table->foreign('monitoring_agency_id')
         //    ->references('id')->on('commonlibrariesdb.agency')
         //    ->onUpdate('restrict')->onDelete('restrict');

         // Note: implementing_agency_id does not have a FK in the original definition, so I left it nullable without FK.
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('bp_form7');
   }
};
