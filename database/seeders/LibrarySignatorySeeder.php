<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibrarySignatorySeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/library_signatories.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('library_signatories')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'user_id' => parseNull('user_id', $row),
               'module_id' => parseNull('module_id', $row),
               'signatory_no' => parseNull('signatory_no', $row),
               'form_id' => parseNull('form_id', $row),
               'is_default' => isset($row['is_default']) ? (int) $row['is_default'] : 0,
               'tags' => $row['tags'] ?? null,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
            ]
         );
      }
   }
}
