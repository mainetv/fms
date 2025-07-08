<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibrarySubactivitySeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/library_subactivity.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('library_subactivity')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'old_id' => isset($row['old_id']) ? (int) $row['old_id'] : null,
               'subactivity' => $row['subactivity'] ?? null,
               'subactivity_code' => $row['subactivity_code'] ?? null,
               'activity_id' => isset($row['activity_id']) ? (int) $row['activity_id'] : null,
               'division_id' => isset($row['division_id']) ? (int) $row['division_id'] : null,
               'tier' => isset($row['tier']) ? (int) $row['tier'] : 0,
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
