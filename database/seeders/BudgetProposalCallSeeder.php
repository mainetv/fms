<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BudgetProposalCallSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/fiscal_year.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('fiscal_year')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'year' => $row['year'] ?? null,
               'fiscal_year1' => $row['fiscal_year1'] ?? null,
               'fiscal_year2' => $row['fiscal_year2'] ?? null,
               'fiscal_year3' => $row['fiscal_year3'] ?? null,
               'open_date_from' => $row['open_date_from'] ?? null,
               'open_date_to' => $row['open_date_to'] ?? null,
               'filename' => $row['filename'] ?? null,
               'is_locked' => isset($row['is_locked']) ? (int) $row['is_locked'] : 1,
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
