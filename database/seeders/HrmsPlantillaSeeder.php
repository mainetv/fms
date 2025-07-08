<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class HrmsPlantillaSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      $csvFile = database_path('seeders/csv/hrmsdb/plantillas.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('plantillas')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'user_id' => isset($row['user_id']) ? (int) $row['user_id'] : null,
               'username' => $row['username'] ?? null,
               'plantilla_division' => $row['plantilla_division'] ?? null,
               'plantilla_item_number' => $row['plantilla_item_number'] ?? null,
               'position_id' => $row['position_id'] ?? null,
               'designation_id' => isset($row['designation_id']) ? (int) $row['designation_id'] : null,
               'plantilla_step' => isset($row['plantilla_step']) ? (int) $row['plantilla_step'] : null,
               'employment_id' => isset($row['employment_id']) ? (int) $row['employment_id'] : null,
               'plantilla_salary' => isset($row['plantilla_salary']) ? (float) $row['plantilla_salary'] : null,
               'salary_grade' => isset($row['salary_grade']) ? (float) $row['salary_grade'] : null,
               'plantilla_date_from' => $row['plantilla_date_from'] ?? null,
               'plantilla_date_to' => $row['plantilla_date_to'] ?? null,
               'plantilla_special' => isset($row['plantilla_special']) ? (int) $row['plantilla_special'] : null,
               'plantilla_remarks' => $row['plantilla_remarks'] ?? null,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
               'ehrms_plantilla_id' => $row['ehrms_plantilla_id'] ?? null,
               'fk_position_id' => $row['fk_position_id'] ?? null,
            ]
         );
      }
   }
}
