<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class RsPapSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/rs_pap.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('rs_pap')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'rs_id' => isset($row['rs_id']) ? (int) $row['rs_id'] : null,
               'allotment_id' => isset($row['allotment_id']) ? (int) $row['allotment_id'] : null,
               'amount' => isset($row['amount']) ? (float) $row['amount'] : 0,
               'notice_adjustment_no' => $row['notice_adjustment_no'] ?? null,
               'notice_adjustment_date' => $row['notice_adjustment_date'] ?? null,
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
