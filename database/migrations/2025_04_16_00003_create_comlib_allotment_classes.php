<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION_COMLIB', 'mysql');
      Schema::connection($connection)->create('allotment_classes', function (Blueprint $table) {
            $table->id();
            $table->string('allotment_class', 100)->nullable();
            $table->string('allotment_class_acronym', 20)->nullable();
            $table->string('allotment_number', 20)->nullable();
            $table->string('allotment_class_number', 20)->nullable();
            $table->text('tags')->nullable();

            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION_COMLIB', 'mysql');
      Schema::connection($connection)->dropIfExists('allotment_classes');
    }
};
