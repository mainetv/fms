<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryModuleSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/modules.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('modules')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'module' => $row['module'] ?? null,
               'link' => $row['link'] ?? null,
               'audit_type_link' => $row['audit_type_link'] ?? null,
               'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}

function parseNull(string $key, array $row): ?string
{
   return isset($row[$key]) && $row[$key] !== '' ? $row[$key] : null;
}

function formatDate(?string $date): ?string
{
   if (!$date) return null;
   $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
   return $dt ? $dt->format('Y-m-d H:i:s') : null;
}
