<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class NcaSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/nca.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('nca')->updateOrInsert(
            ['id' => (int)$row['id']],
            [
               'fund_id' => isset($row['fund_id']) ? (int)$row['fund_id'] : null,
               'year' => isset($row['year']) ? (int)$row['year'] : null,
               'jan_nca' => isset($row['jan_nca']) ? (float)$row['jan_nca'] : 0,
               'feb_nca' => isset($row['feb_nca']) ? (float)$row['feb_nca'] : 0,
               'mar_nca' => isset($row['mar_nca']) ? (float)$row['mar_nca'] : 0,
               'apr_nca' => isset($row['apr_nca']) ? (float)$row['apr_nca'] : 0,
               'may_nca' => isset($row['may_nca']) ? (float)$row['may_nca'] : 0,
               'jun_nca' => isset($row['jun_nca']) ? (float)$row['jun_nca'] : 0,
               'jul_nca' => isset($row['jul_nca']) ? (float)$row['jul_nca'] : 0,
               'aug_nca' => isset($row['aug_nca']) ? (float)$row['aug_nca'] : 0,
               'sep_nca' => isset($row['sep_nca']) ? (float)$row['sep_nca'] : 0,
               'oct_nca' => isset($row['oct_nca']) ? (float)$row['oct_nca'] : 0,
               'nov_nca' => isset($row['nov_nca']) ? (float)$row['nov_nca'] : 0,
               'dec_nca' => isset($row['dec_nca']) ? (float)$row['dec_nca'] : 0,
               'is_active' => isset($row['is_active']) ? (int)$row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int)$row['is_deleted'] : 0,
               'created_at' => $row['created_at'] ?? now(),
               'updated_at' => $row['updated_at'] ?? null,
            ]
         );
      }
   }
}
