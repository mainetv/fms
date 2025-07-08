<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class BpCommentSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/bp_comments.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('bp_comments')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_id' => isset($row['division_id']) ? (int)$row['division_id'] : null,
               'year' => parseNull('year', $row),
               'budget_proposal_id' => (int) $row['budget_proposal_id'],
               'comment' => parseNull('comment', $row),
               'comment_by' => parseNull('comment_by', $row),
               'comment_by_user_id' => (int) $row['comment_by_user_id'],
               'is_resolved' => isset($row['is_resolved']) ? (int)$row['is_resolved'] : 0,
               'is_active' => isset($row['is_active']) ? (int)$row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int)$row['is_deleted'] : 0,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
            ]
         );
      }
   }
}
