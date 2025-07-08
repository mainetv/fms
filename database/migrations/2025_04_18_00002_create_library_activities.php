<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_activity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('old_id')->nullable();
            $table->string('activity', 500)->nullable();
            $table->string('activity_code', 100)->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('appropriation_id')->nullable();
            $table->unsignedBigInteger('request_status_type_id');
            $table->string('tags', 500)->nullable();

            $table->boolean('is_program')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);

            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(null);

            $table->index('request_status_type_id', 'FK_library_activities_request_status_types_idx');
            $table->index('division_id', 'FK_library_activities_pcaarrd_divisions_idx');

            // Add foreign key constraints if needed (optional, but recommended):
            // $table->foreign('division_id')->references('id')->on('pcaarrd_divisions')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_activity');
    }
};
