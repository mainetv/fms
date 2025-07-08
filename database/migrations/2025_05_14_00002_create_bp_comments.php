<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('bp_comments', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('division_id')->nullable();
         $table->string('year', 4)->nullable();
         $table->unsignedBigInteger('budget_proposal_id');
         $table->text('comment')->nullable();
         $table->string('comment_by', 20)->nullable();
         $table->unsignedBigInteger('comment_by_user_id');
         $table->boolean('is_resolved')->default(0);
         $table->boolean('is_active')->default(1);
         $table->boolean('is_deleted')->default(0);
         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->nullable()->default(null);

         $table->foreign('budget_proposal_id')
            ->references('id')
            ->on('budget_proposals')
            ->onUpdate('restrict')
            ->onDelete('restrict');

         $table->foreign('division_id')
            ->references('id')
            ->on('commonlibrariesdbv1.divisions')
            ->onDelete('restrict')
            ->onUpdate('restrict');
      });
   }

   public function down(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('bp_comments');
   }
};
