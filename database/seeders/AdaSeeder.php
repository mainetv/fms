<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class AdaSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/ada.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('ada')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'ada_no' => $row['ada_no'] ?? null,
               'ada_date' => $row['ada_date'] ?? null,
               'fund_id' => isset($row['fund_id']) ? (int) $row['fund_id'] : null,
               'bank_account_id' => isset($row['bank_account_id']) ? (int) $row['bank_account_id'] : null,
               'check_no' => $row['check_no'] ?? null,
               'total_ps_amount' => isset($row['total_ps_amount']) ? (float) $row['total_ps_amount'] : 0,
               'total_mooe_amount' => isset($row['total_mooe_amount']) ? (float) $row['total_mooe_amount'] : 0,
               'total_co_amount' => isset($row['total_co_amount']) ? (float) $row['total_co_amount'] : 0,
               'date_transferred' => $row['date_transferred'] ?? null,
               'signatory1' => $row['signatory1'] ?? null,
               'signatory1_position' => $row['signatory1_position'] ?? null,
               'signatory2' => $row['signatory2'] ?? null,
               'signatory2_position' => $row['signatory2_position'] ?? null,
               'signatory3' => $row['signatory3'] ?? null,
               'signatory3_position' => $row['signatory3_position'] ?? null,
               'signatory4' => $row['signatory4'] ?? null,
               'signatory4_position' => $row['signatory4_position'] ?? null,
               'signatory5' => $row['signatory5'] ?? null,
               'signatory5_position' => $row['signatory5_position'] ?? null,
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
