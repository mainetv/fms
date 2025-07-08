<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class HrmsEmployeeAddInfoSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      $csvFile = database_path('seeders/csv/hrmsdb/employee_addinfos.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('employee_addinfos')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'user_id' => isset($row['user_id']) ? (int) $row['user_id'] : null,
               'empcode' => $row['empcode'] ?? null,
               'empcode_id' => $row['empcode_id'] ?? null,
               'addinfo_pagibig' => $row['addinfo_pagibig'] ?? null,
               'addinfo_philhealth' => $row['addinfo_philhealth'] ?? null,
               'addinfo_sss' => $row['addinfo_sss'] ?? null,
               'addinfo_tin' => $row['addinfo_tin'] ?? null,
               'addinfo_gsis_id' => $row['addinfo_gsis_id'] ?? null,
               'addinfo_gsis_policy' => $row['addinfo_gsis_policy'] ?? null,
               'addinfo_gsis_bp' => $row['addinfo_gsis_bp'] ?? null,
               'addinfo_partner' => $row['addinfo_partner'] ?? null,
               'addinfo_landbank' => $row['addinfo_landbank'] ?? null,
               'addinfo_atm' => $row['addinfo_atm'] ?? null,
               'addinfo_gov' => $row['addinfo_gov'] ?? null,
               'addinfo_gov_id' => $row['addinfo_gov_id'] ?? null,
               'addinfo_gov_place_date' => $row['addinfo_gov_place_date'] ?? null,
               'addinfo_ctc' => $row['addinfo_ctc'] ?? null,
               'addinfo_ctc_date' => $row['addinfo_ctc_date'] ?? null,
               'addinfo_ctc_place' => $row['addinfo_ctc_place'] ?? null,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
            ]
         );
      }
   }
}
