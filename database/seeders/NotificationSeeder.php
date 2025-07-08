<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class NotificationSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/notifications.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('notifications')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'message' => $row['message'] ?? null,
               'record_id' => $row['record_id'] ?? null,
               'module_id' => $row['module_id'] ?? null,
               'link' => $row['link'] ?? null,
               'month' => $row['month'] ?? null,
               'year' => $row['year'] ?? null,
               'date' => $row['date'] ?? null,
               'division_id' => $row['division_id'] ?? null,
               'division_id_from' => $row['division_id_from'] ?? null,
               'division_id_to' => $row['division_id_to'] ?? null,
               'user_id_from' => $row['user_id_from'] ?? null,
               'user_id_to' => $row['user_id_to'] ?? null,
               'user_role_id_from' => $row['user_role_id_from'] ?? null,
               'user_role_id_to' => $row['user_role_id_to'] ?? null,
               'remarks' => $row['remarks'] ?? null,
               'is_read' => isset($row['is_read']) ? (int) $row['is_read'] : 0,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
               'created_at' => formatDate($row['created_at'] ?? null) ?? now(),
               'updated_at' => formatDate($row['updated_at'] ?? null),
            ]
         );
      }
   }
}
