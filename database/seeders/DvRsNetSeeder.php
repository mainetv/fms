<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class DvRsNetSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/dv_rs_net.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('dv_rs_net')->updateOrInsert(
            ['id' => (int)$row['id']],
            [
               'dv_id' => isset($row['dv_id']) ? (int)$row['dv_id'] : null,
               'rs_id' => isset($row['rs_id']) ? (int)$row['rs_id'] : null,
               'gross_amount' => isset($row['gross_amount']) ? (float)$row['gross_amount'] : 0,
               'tax_one' => isset($row['tax_one']) ? (float)$row['tax_one'] : 0,
               'tax_two' => isset($row['tax_two']) ? (float)$row['tax_two'] : 0,
               'tax_twob' => isset($row['tax_twob']) ? (float)$row['tax_twob'] : 0,
               'tax_three' => isset($row['tax_three']) ? (float)$row['tax_three'] : 0,
               'tax_four' => isset($row['tax_four']) ? (float)$row['tax_four'] : 0,
               'tax_five' => isset($row['tax_five']) ? (float)$row['tax_five'] : 0,
               'tax_six' => isset($row['tax_six']) ? (float)$row['tax_six'] : 0,
               'wtax' => isset($row['wtax']) ? (float)$row['wtax'] : 0,
               'other_tax' => isset($row['other_tax']) ? (float)$row['other_tax'] : 0,
               'liquidated_damages' => isset($row['liquidated_damages']) ? (float)$row['liquidated_damages'] : 0,
               'other_deductions' => isset($row['other_deductions']) ? (float)$row['other_deductions'] : 0,
               'net_amount' => isset($row['net_amount']) ? (float)$row['net_amount'] : 0,
               'allotment_class_id' => isset($row['allotment_class_id']) ? (int)$row['allotment_class_id'] : null,
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
