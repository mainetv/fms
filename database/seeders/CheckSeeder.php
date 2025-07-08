<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class CheckSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/checks.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('checks')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'dv_id' => isset($row['dv_id']) ? (int) $row['dv_id'] : null,
               'check_date' => $row['check_date'] ?? null,
               'check_no' => $row['check_no'] ?? null,
               'fund_id' => isset($row['fund_id']) ? (int) $row['fund_id'] : null,
               'bank_account_id' => isset($row['bank_account_id']) ? (int) $row['bank_account_id'] : null,
               'acic_id' => isset($row['acic_id']) ? (int) $row['acic_id'] : null,
               'date_released' => $row['date_released'] ?? null,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               // 'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}
