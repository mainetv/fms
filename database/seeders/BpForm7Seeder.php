<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BpForm7Seeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/bp_form7.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('bp_form7')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => isset($row['division_id']) ? (int) $row['division_id'] : null,
               'year' => $row['year'] ?? null,
               'fiscal_year' => $row['fiscal_year'] ?? null,
               'program' => $row['program'] ?? null,
               'project' => $row['project'] ?? null,
               'location_id' => isset($row['location_id']) ? (int) $row['location_id'] : null,
               'beneficiaries' => $row['beneficiaries'] ?? null,
               'start_date' => $row['start_date'] ?? null,
               'end_date' => $row['end_date'] ?? null,
               'total_project_cost' => isset($row['total_project_cost']) ? (float) $row['total_project_cost'] : null,
               'implementing_agency_id' => isset($row['implementing_agency_id']) ? (int) $row['implementing_agency_id'] : null,
               'monitoring_agency_id' => isset($row['monitoring_agency_id']) ? (int) $row['monitoring_agency_id'] : null,
               'fund_allocation_fiscal_year1' => isset($row['fund_allocation_fiscal_year1']) ? (float) $row['fund_allocation_fiscal_year1'] : null,
               'fund_allocation_fiscal_year2' => isset($row['fund_allocation_fiscal_year2']) ? (float) $row['fund_allocation_fiscal_year2'] : null,
               'fund_allocation_fiscal_year3' => isset($row['fund_allocation_fiscal_year3']) ? (float) $row['fund_allocation_fiscal_year3'] : null,
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
