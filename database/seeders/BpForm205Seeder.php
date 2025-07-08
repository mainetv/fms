<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BpForm205Seeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/bp_form205.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('bp_form205')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => isset($row['division_id']) ? (int) $row['division_id'] : null,
               'year' => $row['year'] ?? null,
               'fiscal_year' => $row['fiscal_year'] ?? null,
               'retirement_law_id' => isset($row['retirement_law_id']) ? (int) $row['retirement_law_id'] : null,
               'emp_code' => $row['emp_code'] ?? null,
               'position_id_at_retirement_date' => $row['position_id_at_retirement_date'] ?? null,
               'highest_monthly_salary' => isset($row['highest_monthly_salary']) ? (float) $row['highest_monthly_salary'] : null,
               'sl_credits_earned' => $row['sl_credits_earned'] ?? null,
               'vl_credits_earned' => $row['vl_credits_earned'] ?? null,
               'leave_amount' => isset($row['leave_amount']) ? (float) $row['leave_amount'] : null,
               'total_creditable_service' => isset($row['total_creditable_service']) ? (float) $row['total_creditable_service'] : null,
               'num_gratuity_months' => $row['num_gratuity_months'] ?? null,
               'gratuity_amount' => isset($row['gratuity_amount']) ? (float) $row['gratuity_amount'] : null,
               'remarks' => $row['remarks'] ?? null,
               'is_gsis' => isset($row['is_gsis']) ? (int) $row['is_gsis'] : 1,

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
