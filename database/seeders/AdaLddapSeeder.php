<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class AdaLddapSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/ada_lddap.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('ada_lddap')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'ada_id' => isset($row['ada_id']) ? (int) $row['ada_id'] : null,
               'lddap_id' => isset($row['lddap_id']) ? (int) $row['lddap_id'] : null,
               'check_no' => $row['check_no'] ?? null,
               'ps_amount' => isset($row['ps_amount']) ? (float) $row['ps_amount'] : 0,
               'mooe_amount' => isset($row['mooe_amount']) ? (float) $row['mooe_amount'] : 0,
               'co_amount' => isset($row['co_amount']) ? (float) $row['co_amount'] : 0,
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
