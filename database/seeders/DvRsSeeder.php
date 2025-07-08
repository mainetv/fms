<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class DvRsSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/dv_rs.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('dv_rs')->updateOrInsert(
            ['id' => (int)$row['id']],
            [
               'dv_id' => isset($row['dv_id']) ? (int)$row['dv_id'] : null,
               'rs_id' => isset($row['rs_id']) ? (int)$row['rs_id'] : null,
               'amount' => isset($row['amount']) ? (float)$row['amount'] : 0,
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
