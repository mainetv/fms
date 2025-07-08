<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BpForm9Seeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/bp_form9.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('bp_form9')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => isset($row['division_id']) ? (int) $row['division_id'] : null,
               'year' => $row['year'] ?? null,
               'fiscal_year' => $row['fiscal_year'] ?? null,
               'description' => $row['description'] ?? null,
               'quantity' => isset($row['quantity']) ? (int) $row['quantity'] : null,
               'unit_cost' => isset($row['unit_cost']) ? (float) $row['unit_cost'] : null,
               'total_cost' => isset($row['total_cost']) ? (float) $row['total_cost'] : null,
               'organizational_deployment' => $row['organizational_deployment'] ?? null,
               'justification' => $row['justification'] ?? null,
               'remarks' => $row['remarks'] ?? null,
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
