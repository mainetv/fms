<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class HrmsPositionSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      $csvFile = database_path('seeders/csv/hrmsdb/positions.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('positions')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'position_id' => $row['position_id'] ?? null,
               'position_abbr' => $row['position_abbr'] ?? null,
               'position_desc' => $row['position_desc'] ?? null,
               'position_class' => $row['position_class'] ?? null,
               'stepincrement_id' => isset($row['stepincrement_id']) ? (int) $row['stepincrement_id'] : null,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}
