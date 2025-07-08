<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION_COMLIB', 'mysql');
      Schema::connection($connection)->create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('division_acronym', 15);
            $table->string('division_code', 6)->nullable();
            $table->string('division_id', 5);
            $table->string('division', 500);
            $table->boolean('is_section')->default(0)->comment('0-no, 1-yes');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('cluster_id');
            $table->boolean('is_cluster')->default(0);
            $table->string('tags', 500)->nullable();
            $table->boolean('is_verified')->default(0)->comment('0-no, 1-yes');
            $table->boolean('is_active')->default(1)->comment('0-no, 1-yes');
            $table->boolean('is_deleted')->default(0)->comment('0-no, 1-yes');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->softDeletes()->nullable()->default(null);

            // Indexes
            $table->index('division_id');
            $table->index('parent_id', 'FK__divisions_parent_idx');
            $table->index('cluster_id', 'FK_divisions_cluster_idx');
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION_COMLIB', 'mysql');
      Schema::connection($connection)->dropIfExists('divisions');
    }
};
