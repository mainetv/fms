<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BpStatusSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/bp_status.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('bp_status')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => (int) $row['division_id'],
               'year' => $row['year'],
               'status_id' => parseNull('status_id', $row),
               'status_by_user_id' => (int) $row['status_by_user_id'],
               'status_by_user_role_id' => (int) $row['status_by_user_role_id'],
               'status_by_user_division_id' => (int) $row['status_by_user_division_id'],
               'date' => formatDate(parseNull('date', $row)),
               'is_active' => isset($row['is_active']) ? (int)$row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int)$row['is_deleted'] : 0,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
            ]
         );
      }
   }
}
