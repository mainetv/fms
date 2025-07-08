<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryObjectExpenditureSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/library_object_expenditure.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('library_object_expenditure')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'old_id' => isset($row['old_id']) ? (int) $row['old_id'] : null,
               'object_expenditure' => $row['object_expenditure'],
               'object_code' => $row['object_code'] ?? null,
               'expense_account_id' => isset($row['expense_account_id']) ? (int) $row['expense_account_id'] : null,
               'allotment_class_id' => isset($row['allotment_class_id']) ? (int) $row['allotment_class_id'] : null,
               'is_gia' => isset($row['is_gia']) ? (int) $row['is_gia'] : 0,
               'request_status_type_id' => isset($row['request_status_type_id']) ? (int) $row['request_status_type_id'] : null,
               'remarks' => $row['remarks'] ?? null,
               'tags' => $row['tags'] ?? null,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
               'created_at' => $row['created_at'] ?? null,
               'updated_at' => $row['updated_at'] ?? null,
            ]
         );
      }
   }
}
