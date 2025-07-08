<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      $sql = file_get_contents(database_path('sql/hrmsdb-views.sql'));

      // Split statements safely by semicolon followed by a newline
      $statements = array_filter(array_map('trim', preg_split('/;\s*[\r\n]+/', $sql)));

      foreach ($statements as $statement) {
         DB::connection($connection)->statement($statement);
      }
   }

   public function down(): void
   {
      // Optionally add logic to drop the views on the same connection
      // DB::connection('second_mysql')->statement('DROP VIEW IF EXISTS your_view_name');
   }

};
