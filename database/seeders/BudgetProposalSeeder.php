<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BudgetProposalSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/budget_proposals.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('budget_proposals')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => isset($row['division_id']) ? (int)$row['division_id'] : null,
               'year' => parseNull('year', $row),
               'pap_id' => isset($row['pap_id']) ? (int)$row['pap_id'] : null,
               'activity_id' => isset($row['activity_id']) ? (int)$row['activity_id'] : null,
               'subactivity_id' => isset($row['subactivity_id']) ? (int)$row['subactivity_id'] : null,
               'expense_account_id' => isset($row['expense_account_id']) ? (int)$row['expense_account_id'] : null,
               'object_expenditure_id' => isset($row['object_expenditure_id']) ? (int)$row['object_expenditure_id'] : null,
               'object_specific_id' => isset($row['object_specific_id']) ? (int)$row['object_specific_id'] : null,
               'pooled_at_division_id' => isset($row['pooled_at_division_id']) ? (int)$row['pooled_at_division_id'] : null,
               'fy1_amount' => $row['fy1_amount'] !== '' ? (float)$row['fy1_amount'] : null,
               'fy2_amount' => $row['fy2_amount'] !== '' ? (float)$row['fy2_amount'] : null,
               'fy3_amount' => $row['fy3_amount'] !== '' ? (float)$row['fy3_amount'] : null,
               'is_active' => isset($row['is_active']) ? (int)$row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int)$row['is_deleted'] : 0,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
            ]
         );
      }
   }
}
