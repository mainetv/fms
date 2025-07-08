<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BankSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION_COMLIB', 'mysql');
      $csvFile = database_path('seeders/csv/banks.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setHeaderOffset(0); // Use first row as header

      foreach ($csv as $row) {
         DB::connection($connection)->table('banks')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'bank' => $row['bank'],
               'bank_acronym' => $row['bank_acronym'],
               'short_name' => $row['short_name'],
               'bank_code' => $row['bank_code'],
               'remarks' => $row['remarks'],
               'is_active' => (int) ($row['is_active'] ?? 1),
               'is_deleted' => (int) ($row['is_deleted'] ?? 0),
               'created_at' => $row['created_at'] ?? now(),
               'updated_at' => $row['updated_at'] ?? now(),
            ]
         );
      }
   }
}
