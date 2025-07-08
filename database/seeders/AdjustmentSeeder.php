<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class AdjustmentSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/adjustment.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('adjustment')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'allotment_id' => isset($row['allotment_id']) ? (int) $row['allotment_id'] : null,
               'adjustment_type_id' => (int) $row['adjustment_type_id'],
               'date' => $row['date'] ?? null,
               'reference_no' => $row['reference_no'] ?? null,
               'q1_adjustment' => (float) $row['q1_adjustment'],
               'q2_adjustment' => (float) $row['q2_adjustment'],
               'q3_adjustment' => (float) $row['q3_adjustment'],
               'q4_adjustment' => (float) $row['q4_adjustment'],
               'remarks' => $row['remarks'] ?? null,
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
