<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryDivisionSeeder extends Seeder
{
   public function run(): void
   {
      $csvFile = database_path('seeders/csv/library_divisions.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::table('library_divisions')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'division_acronym' => $row['division_acronym'],
               'division_code' => $row['division_code'] ?? null,
               'division_id' => $row['division_id'],
               'division' => $row['division'],
               'is_section' => isset($row['is_section']) ? (int) $row['is_section'] : 0,
               'parent_id' => (int) $row['parent_id'],
               'cluster_id' => (int) $row['cluster_id'],
               'is_cluster' => isset($row['is_cluster']) ? (int) $row['is_cluster'] : 0,
               'tags' => $row['tags'] ?? null,
               'is_verified' => isset($row['is_verified']) ? (int) $row['is_verified'] : 0,
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
