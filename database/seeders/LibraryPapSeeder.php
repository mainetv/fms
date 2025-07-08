<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryPapSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/library_pap.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('library_pap')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'old_id' => isset($row['old_id']) ? (int) $row['old_id'] : null,
               'pap' => $row['pap'] ?? null,
               'pap_code' => $row['pap_code'] ?? null,
               'description' => $row['description'] ?? null,
               'parent_id' => isset($row['parent_id']) ? (int) $row['parent_id'] : null,
               'request_status_type_id' => (int) $row['request_status_type_id'],
               'division_id' => (int) $row['division_id'],
               'default_all' => isset($row['default_all']) ? (int) $row['default_all'] : 0,
               'remarks' => $row['remarks'] ?? null,
               'tags' => $row['tags'] ?? null,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}
