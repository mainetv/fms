<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class RequestStatusSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/request_status.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('request_status')->updateOrInsert(
            ['id' => (int)$row['id']],
            [
               'fais_id' => isset($row['fais_id']) ? (int)$row['fais_id'] : null,
               'rs_type_id' => isset($row['rs_type_id']) ? (int)$row['rs_type_id'] : null,
               'rs_no' => $row['rs_no'] ?? null,
               'rs_date' => $row['rs_date'] ?? null,
               'rs_date1' => $row['rs_date1'] ?? null,
               'division_id' => isset($row['division_id']) ? (int)$row['division_id'] : null,
               'fund_id' => isset($row['fund_id']) ? (int)$row['fund_id'] : null,
               'payee_id' => isset($row['payee_id']) ? (int)$row['payee_id'] : null,
               'particulars' => $row['particulars'] ?? null,
               'total_rs_activity_amount' => isset($row['total_rs_activity_amount']) ? (float)$row['total_rs_activity_amount'] : 0,
               'total_rs_pap_amount' => isset($row['total_rs_pap_amount']) ? (float)$row['total_rs_pap_amount'] : 0,
               'showall' => isset($row['showall']) ? (int)$row['showall'] : 0,
               'signatory1' => $row['signatory1'] ?? null,
               'signatory1_position' => $row['signatory1_position'] ?? null,
               'signatory1b' => $row['signatory1b'] ?? null,
               'signatory1b_position' => $row['signatory1b_position'] ?? null,
               'signatory2' => $row['signatory2'] ?? null,
               'signatory2_position' => $row['signatory2_position'] ?? null,
               'signatory3' => $row['signatory3'] ?? null,
               'signatory3_position' => $row['signatory3_position'] ?? null,
               'signatory4' => $row['signatory4'] ?? null,
               'signatory4_position' => $row['signatory4_position'] ?? null,
               'signatory5' => $row['signatory5'] ?? null,
               'signatory5_position' => $row['signatory5_position'] ?? null,
               'is_locked' => isset($row['is_locked']) ? (int)$row['is_locked'] : 0,
               'is_active' => isset($row['is_active']) ? (int)$row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int)$row['is_deleted'] : 0,
               'locked_at' => $row['locked_at'] ?? null,
               'cancelled_at' => $row['cancelled_at'] ?? null,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}
