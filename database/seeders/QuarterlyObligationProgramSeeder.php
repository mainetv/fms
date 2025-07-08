<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;

class QuarterlyObligationProgramSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/quarterly_obligation_programs.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      // Get list of columns in the table
      $columns = Schema::getColumnListing('quarterly_obligation_programs');

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         $data = [
            'reference_allotment_id' => isset($row['reference_allotment_id']) ? (int)$row['reference_allotment_id'] : null,
            'division_id' => isset($row['division_id']) ? (int)$row['division_id'] : null,
            'year' => $row['year'] ?? null,
            'pap_id' => isset($row['pap_id']) ? (int)$row['pap_id'] : null,
            'activity_id' => isset($row['activity_id']) ? (int)$row['activity_id'] : null,
            'subactivity_id' => isset($row['subactivity_id']) ? (int)$row['subactivity_id'] : null,
            'expense_account_id' => isset($row['expense_account_id']) ? (int)$row['expense_account_id'] : null,
            'object_expenditure_id' => isset($row['object_expenditure_id']) ? (int)$row['object_expenditure_id'] : null,
            'object_specific_id' => isset($row['object_specific_id']) ? (int)$row['object_specific_id'] : null,
            'pooled_at_division_id' => isset($row['pooled_at_division_id']) ? (int)$row['pooled_at_division_id'] : null,
            'q1_amount' => isset($row['q1_amount']) ? (float)$row['q1_amount'] : null,
            'q2_amount' => isset($row['q2_amount']) ? (float)$row['q2_amount'] : null,
            'q3_amount' => isset($row['q3_amount']) ? (float)$row['q3_amount'] : null,
            'q4_amount' => isset($row['q4_amount']) ? (float)$row['q4_amount'] : null,
            'is_active' => isset($row['is_active']) ? (int)$row['is_active'] : 1,
            'is_deleted' => isset($row['is_deleted']) ? (int)$row['is_deleted'] : 0,
            'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
            'updated_at' => formatDate(parseNull('updated_at', $row)),
         ];

         // Conditionally add deleted_at
         if (in_array('deleted_at', $columns)) {
            $data['deleted_at'] = formatDate(parseNull('deleted_at', $row));
         }

         DB::table('quarterly_obligation_programs')->updateOrInsert(
            ['id' => (int)$row['id']],
            $data
         );
      }
   }
}
