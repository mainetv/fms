<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BpForm3Seeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/bp_form3.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('bp_form3')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => (int) $row['division_id'],
               'year' => parseNull('year', $row),
               'tier' => (int) $row['tier'],
               'fiscal_year' => parseNull('fiscal_year', $row),
               'description' => parseNull('description', $row),
               'area_sqm' => parseNull('area_sqm', $row),
               'location' => parseNull('location', $row),
               'amount' => parseNull('amount', $row),
               'years_completion' => parseNull('years_completion', $row),
               'date_started' => formatDate(parseNull('date_started', $row)),
               'total_cost' => parseNull('total_cost', $row),
               'justification' => parseNull('justification', $row),
               'remarks' => parseNull('remarks', $row),
               'is_active' => isset($row['is_active']) ? (int)$row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int)$row['is_deleted'] : 0,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
            ]
         );
      }
   }
}
