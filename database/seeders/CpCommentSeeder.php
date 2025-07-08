<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class CpCommentSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/cp_comments.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('cp_comments')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'cash_program_id' => (int) $row['cash_program_id'],
               'comment' => $row['comment'] ?? null,
               'comment_by' => $row['comment_by'] ?? null,
               'is_resolved' => isset($row['is_resolved']) ? (bool) $row['is_resolved'] : false,
               'is_active' => isset($row['is_active']) ? (bool) $row['is_active'] : true,
               'is_deleted' => isset($row['is_deleted']) ? (bool) $row['is_deleted'] : false,
               'created_at' => $row['created_at'] ?? now(),
               'updated_at' => $row['updated_at'] ?? null,
            ]
         );
      }
   }
}
