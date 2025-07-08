<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;

class RsActivitySeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/rs_activity.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      // Get list of columns in the table
      $columns = Schema::getColumnListing('rs_activity');

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         $data = [
            'rs_id' => isset($row['rs_id']) ? (int) $row['rs_id'] : null,
            'allotment_id' => isset($row['allotment_id']) ? (int) $row['allotment_id'] : null,
            'amount' => isset($row['amount']) ? (float) $row['amount'] : 0,
            'is_active' => isset($row['is_active']) ? (int) $row['is_active'] : 1,
            'is_deleted' => isset($row['is_deleted']) ? (int) $row['is_deleted'] : 0,
            'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
            'updated_at' => formatDate(parseNull('updated_at', $row)),
         ];

         // Conditionally add deleted_at
         if (in_array('deleted_at', $columns)) {
            $data['deleted_at'] = formatDate(parseNull('deleted_at', $row));
         }

         DB::table('rs_activity')->updateOrInsert(
            ['id' => (int)$row['id']],
            $data
         );
         
      }
   }
}
