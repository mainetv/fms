<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class ModelHasUserRoleSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/model_has_user_roles.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('model_has_user_roles')->updateOrInsert(
            [
               'role_id' => (int) $row['role_id'],
               'model_id' => (int) $row['model_id'],
               'model_type' => $row['model_type'],
            ],
            [] // No updatable fields, since all are part of the composite primary key
         );
      }
   }
}
