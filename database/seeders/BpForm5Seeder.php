<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BpForm5Seeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/bp_form5.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('bp_form5')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => (int) $row['division_id'],
               'year' => $row['year'],
               'tier' => (int) $row['tier'],
               'fiscal_year' => $row['fiscal_year'] ?: null,
               'description' => $row['description'] ?: null,
               'quantity' => isset($row['quantity']) ? (int) $row['quantity'] : null,
               'unit_cost' => isset($row['unit_cost']) ? (float) $row['unit_cost'] : null,
               'total_cost' => isset($row['total_cost']) ? (float) $row['total_cost'] : null,
               'organizational_deployment' => $row['organizational_deployment'] ?: null,
               'justification' => $row['justification'] ?: null,
               'remarks' => $row['remarks'] ?: null,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
               'created_at' => $row['created_at'] ?? now(),
               'updated_at' => $row['updated_at'] ?? null,
            ]
         );
      }
   }
}
