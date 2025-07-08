<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_subactivity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('old_id')->nullable();
            $table->string('subactivity', 350)->nullable();
            $table->string('subactivity_code', 250)->nullable();
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->tinyInteger('tier')->unsigned();
            $table->string('tags', 500)->nullable();

            // Preserved fields
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->softDeletes()->nullable()->default(null);

            // Indexes
            $table->index('activity_id', 'FK_library_subactivity_library_activity_idx');
            $table->index('division_id', 'FK_library_subactivity_pcaarrd_divisions_idx');

            // Foreign keys can be added if you want:
            // $table->foreign('activity_id')->references('id')->on('library_activity')->onDelete('restrict')->onUpdate('restrict');
            // $table->foreign('division_id')->references('id')->on('pcaarrd_divisions')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_subactivity');
    }
};
