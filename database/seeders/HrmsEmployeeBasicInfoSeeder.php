<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class HrmsEmployeeBasicInfoSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      $csvFile = database_path('seeders/csv/hrmsdb/employee_basicinfos.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('employee_basicinfos')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'user_id' => isset($row['user_id']) ? (int) $row['user_id'] : null,
               'empcode' => $row['empcode'] ?? null,
               'basicinfo_placeofbirth' => $row['basicinfo_placeofbirth'] ?? null,
               'basicinfo_sex' => $row['basicinfo_sex'] ?? null,
               'basicinfo_civilstatus' => $row['basicinfo_civilstatus'] ?? null,
               'basicinfo_citizenship' => $row['basicinfo_citizenship'] ?? null,
               'basicinfo_citizentype' => $row['basicinfo_citizentype'] ?? null,
               'basicinfo_height' => isset($row['basicinfo_height']) ? (float) $row['basicinfo_height'] : null,
               'basicinfo_weight' => isset($row['basicinfo_weight']) ? (float) $row['basicinfo_weight'] : null,
               'basicinfo_bloodtype' => $row['basicinfo_bloodtype'] ?? null,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}
