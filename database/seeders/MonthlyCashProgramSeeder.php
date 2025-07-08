<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class MonthlyCashProgramSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/monthly_cash_programs.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('monthly_cash_programs')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'reference_allotment_id' => isset($row['reference_allotment_id']) ? (int) $row['reference_allotment_id'] : null,
               'division_id' => isset($row['division_id']) ? (int) $row['division_id'] : null,
               'year' => $row['year'] ?? null,
               'pap_id' => isset($row['pap_id']) ? (int) $row['pap_id'] : null,
               'activity_id' => isset($row['activity_id']) ? (int) $row['activity_id'] : null,
               'subactivity_id' => isset($row['subactivity_id']) ? (int) $row['subactivity_id'] : null,
               'expense_account_id' => isset($row['expense_account_id']) ? (int) $row['expense_account_id'] : null,
               'object_expenditure_id' => isset($row['object_expenditure_id']) ? (int) $row['object_expenditure_id'] : null,
               'object_specific_id' => isset($row['object_specific_id']) ? (int) $row['object_specific_id'] : null,
               'pooled_at_division_id' => isset($row['pooled_at_division_id']) ? (int) $row['pooled_at_division_id'] : null,
               'jan_amount' => isset($row['jan_amount']) ? (float) $row['jan_amount'] : null,
               'feb_amount' => isset($row['feb_amount']) ? (float) $row['feb_amount'] : null,
               'mar_amount' => isset($row['mar_amount']) ? (float) $row['mar_amount'] : null,
               'apr_amount' => isset($row['apr_amount']) ? (float) $row['apr_amount'] : null,
               'may_amount' => isset($row['may_amount']) ? (float) $row['may_amount'] : null,
               'jun_amount' => isset($row['jun_amount']) ? (float) $row['jun_amount'] : null,
               'jul_amount' => isset($row['jul_amount']) ? (float) $row['jul_amount'] : null,
               'aug_amount' => isset($row['aug_amount']) ? (float) $row['aug_amount'] : null,
               'sep_amount' => isset($row['sep_amount']) ? (float) $row['sep_amount'] : null,
               'oct_amount' => isset($row['oct_amount']) ? (float) $row['oct_amount'] : null,
               'nov_amount' => isset($row['nov_amount']) ? (float) $row['nov_amount'] : null,
               'dec_amount' => isset($row['dec_amount']) ? (float) $row['dec_amount'] : null,

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
