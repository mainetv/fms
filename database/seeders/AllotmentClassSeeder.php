<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class AllotmentClassSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION_COMLIB', 'mysql');
      $csvFile = database_path('seeders/csv/allotment_classes.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('allotment_classes')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'allotment_class' => $row['allotment_class'] ?? null,
               'allotment_class_acronym' => $row['allotment_class_acronym'] ?? null,
               'allotment_number' => $row['allotment_number'] ?? null,
               'allotment_class_number' => $row['allotment_class_number'] ?? null,
               'tags' => $row['tags'] ?? null,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
               'created_at' => $row['created_at'] ?? null,
               'updated_at' => $row['updated_at'] ?? null,
            ]
         );
      }
   }
}
