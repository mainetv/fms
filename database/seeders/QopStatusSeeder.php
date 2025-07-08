<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class QopStatusSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/qop_status.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('qop_status')->updateOrInsert(
            ['id' => (int)$row['id']],
            [
               'division_id' => isset($row['division_id']) ? (int)$row['division_id'] : null,
               'year' => $row['year'] ?? null,
               'status_id' => isset($row['status_id']) ? (int)$row['status_id'] : null,
               'status_by_user_id' => isset($row['status_by_user_id']) ? (int)$row['status_by_user_id'] : null,
               'status_by_user_role_id' => isset($row['status_by_user_role_id']) ? (int)$row['status_by_user_role_id'] : null,
               'status_by_user_division_id' => isset($row['status_by_user_division_id']) ? (int)$row['status_by_user_division_id'] : null,
               'date' => $row['date'] ?? null,
               'is_active' => isset($row['is_active']) ? (int)$row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int)$row['is_deleted'] : 0,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}
