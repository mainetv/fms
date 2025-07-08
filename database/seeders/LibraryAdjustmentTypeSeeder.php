<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryAdjustmentTypeSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/library_adjustment_types.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('library_adjustment_types')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'adjustment_type' => $row['adjustment_type'] ?? null,
               'is_active' => isset($row['is_active']) ? (bool)$row['is_active'] : true,
               'is_deleted' => isset($row['is_deleted']) ? (bool)$row['is_deleted'] : false,
               'created_at' => $row['created_at'] ?? null,
               'updated_at' => $row['updated_at'] ?? null,
            ]
         );
      }
   }
}
