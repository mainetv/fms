<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryParticularsTemplateSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/particulars_template.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('particulars_template')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'rs_type_id' => (int) $row['rs_type_id'],
               'transaction_type' => $row['transaction_type'] ?? null,
               'transaction_detail' => $row['transaction_detail'] ?? null,
               'particulars' => $row['particulars'] ?? null,
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
