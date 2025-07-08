<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class HrmsDesignationSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      $csvFile = database_path('seeders/csv/hrmsdb/designations.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('designations')->updateOrInsert(
            ['designation_id' => (int) $row['designation_id']],
            [
               'designation_desc' => $row['designation_desc'] ?? null,
               'designation_abbr' => $row['designation_abbr'] ?? null,
               'designation_type' => $row['designation_type'] ?? null,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}
