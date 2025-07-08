<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryActivitySeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/library_activity.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('library_activity')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'old_id' => isset($row['old_id']) ? (int) $row['old_id'] : null,
               'activity' => $row['activity'] ?? null,
               'activity_code' => $row['activity_code'] ?? null,
               'division_id' => isset($row['division_id']) ? (int) $row['division_id'] : null,
               'appropriation_id' => isset($row['appropriation_id']) ? (int) $row['appropriation_id'] : null,
               'request_status_type_id' => (int) $row['request_status_type_id'],
               'tags' => $row['tags'] ?? null,

               'is_program' => isset($row['is_program']) ? (int) $row['is_program'] : 0,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,

               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
            ]
         );
      }
   }
}
