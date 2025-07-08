<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class FundSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION_COMLIB', 'mysql');
      $csvFile = database_path('seeders/csv/funds.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('funds')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'fund' => $row['fund'] ?? null,
               'fund_prefix' => $row['fund_prefix'] ?? null,
               'destination' => $row['destination'] ?? null,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
               'created_at' => formatDate($row['created_at'] ?? null) ?? now(),
               'updated_at' => formatDate($row['updated_at'] ?? null),
            ]
         );
      }
   }
}
