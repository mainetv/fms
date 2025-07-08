<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_pap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('old_id')->nullable();
            $table->string('pap', 250)->nullable();
            $table->string('pap_code', 30)->nullable()->unique();
            $table->string('description', 250)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('request_status_type_id');
            $table->unsignedBigInteger('division_id');
            $table->boolean('default_all')->default(0);
            $table->string('remarks', 250)->nullable();
            $table->string('tags', 250)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->softDeletes()->nullable()->default(null);

            // Indexes and constraints
            $table->index('parent_id', 'FK_library_pap_idx');
            $table->index('request_status_type_id', 'FK_library_pap_request_status_types_idx');
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_pap');
    }
};
