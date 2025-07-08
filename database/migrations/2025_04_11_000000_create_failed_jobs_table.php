<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = env('DB_CONNECTION', 'mysql');
      Schema::connection($connection)->create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection1 = env('DB_CONNECTION', 'mysql');
        Schema::connection($connection1)->dropIfExists('failed_jobs');

        $connections = ['mysql', 'mysql_hrms', 'mysql_comlib'];
        foreach ($connections as $connection) {
          $databaseName = DB::connection($connection)->getDatabaseName();

          // Fetch all table names dynamically
          $tables = DB::connection($connection)->select('SHOW TABLES');

          // Key is "Tables_in_<databaseName>"
          $key = "Tables_in_{$databaseName}";

          foreach ($tables as $table) {
            $tableName = $table->$key;
            Schema::connection($connection)->dropIfExists($tableName);
          }
        }
    }
};
