<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('library_object_specific', function (Blueprint $table) {
            $table->id();
            $table->string('object_specific', 250);
            $table->unsignedBigInteger('object_expenditure_id');
            $table->text('tags')->nullable();

            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->index('object_expenditure_id', 'FK_library_object_specifics_library_object_expenditure_idx');

            // Foreign key constraint:
            // $table->foreign('object_expenditure_id')->references('id')->on('library_object_expenditures');
        });
    }

    public function down(): void
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->dropIfExists('library_object_specific');
    }
};
