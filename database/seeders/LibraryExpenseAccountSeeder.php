<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryExpenseAccountSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/library_expense_account.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('library_expense_account')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'expense_account' => $row['expense_account'] ?? null,
               'expense_account_code' => $row['expense_account_code'] ?? null,
               'activity_id' => isset($row['activity_id']) ? (int) $row['activity_id'] : null,
               'subactivity_id' => isset($row['subactivity_id']) ? (int) $row['subactivity_id'] : null,
               'request_status_type_id' => isset($row['request_status_type_id']) ? (int) $row['request_status_type_id'] : null,
               'allotment_class_id' => (int) $row['allotment_class_id'],
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
