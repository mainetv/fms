<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class CpStatusSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/cp_status.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('cp_status')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => (int) $row['division_id'],
               'year' => $row['year'],
               'status_id' => isset($row['status_id']) ? (int) $row['status_id'] : null,
               'status_by_user_id' => (int) $row['status_by_user_id'],
               'status_by_user_role_id' => (int) $row['status_by_user_role_id'],
               'status_by_user_division_id' => (int) $row['status_by_user_division_id'],
               'date' => $row['date'] ?? null,
               'is_active' => isset($row['is_active']) ? (bool) $row['is_active'] : true,
               'is_deleted' => isset($row['is_deleted']) ? (bool) $row['is_deleted'] : false,
               'created_at' => $row['created_at'] ?? now(),
               'updated_at' => $row['updated_at'] ?? null,
            ]
         );
      }
   }
}
