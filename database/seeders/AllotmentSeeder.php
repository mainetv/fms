<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class AllotmentSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/allotment.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('allotment')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => $row['division_id'] ?? null,
               'reference_qop_id' => $row['reference_qop_id'] ?? null,
               'year' => $row['year'] ?? null,
               'rs_type_id' => $row['rs_type_id'] ?? null,
               'cost_type_id' => isset($row['cost_type_id']) ? (int) $row['cost_type_id'] : null,
               'allotment_fund_id' => $row['allotment_fund_id'] ?? null,
               'pap_id' => $row['pap_id'] ?? null,
               'activity_id' => $row['activity_id'] ?? null,
               'subactivity_id' => $row['subactivity_id'] ?? null,
               'expense_account_id' => $row['expense_account_id'] ?? null,
               'object_expenditure_id' => $row['object_expenditure_id'] ?? null,
               'object_specific_id' => $row['object_specific_id'] ?? null,
               'pooled_at_division_id' => $row['pooled_at_division_id'] ?? null,
               'q1_allotment' => isset($row['q1_allotment']) ? (float) $row['q1_allotment'] : 0,
               'q2_allotment' => isset($row['q2_allotment']) ? (float) $row['q2_allotment'] : 0,
               'q3_allotment' => isset($row['q3_allotment']) ? (float) $row['q3_allotment'] : 0,
               'q4_allotment' => isset($row['q4_allotment']) ? (float) $row['q4_allotment'] : 0,
               'q1_nca' => isset($row['q1_nca']) ? (float) $row['q1_nca'] : 0,
               'q2_nca' => isset($row['q2_nca']) ? (float) $row['q2_nca'] : 0,
               'q3_nca' => isset($row['q3_nca']) ? (float) $row['q3_nca'] : 0,
               'q4_nca' => isset($row['q4_nca']) ? (float) $row['q4_nca'] : 0,
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
