<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_allotment_funds', function (Blueprint $table) {
            $table->id();
            $table->text('fund_code')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('request_status_type_id');
            $table->text('tags')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->softDeletes()->nullable()->default(null);
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_allotment_funds');
    }
};
