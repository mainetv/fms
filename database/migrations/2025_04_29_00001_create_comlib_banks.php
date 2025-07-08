<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION_COMLIB', 'mysql');
      Schema::connection($connection)->create('banks', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('bank', 250)->nullable();
            $table->string('bank_acronym', 20)->nullable();
            $table->string('short_name', 30)->nullable();
            $table->string('bank_code', 20)->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->softDeletes()->nullable()->default(null);
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION_COMLIB', 'mysql');
      Schema::connection($connection)->dropIfExists('banks');
    }
};
