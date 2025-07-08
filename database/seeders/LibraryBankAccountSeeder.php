<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryBankAccountSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/library_bank_accounts.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('library_bank_accounts')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'bank_id' => isset($row['bank_id']) ? (int) $row['bank_id'] : null,
               'bank_branch' => $row['bank_branch'] ?? null,
               'bank_account_no' => $row['bank_account_no'] ?? null,
               'fund_id' => (int) $row['fund_id'],
               'is_collection' => isset($row['is_collection']) ? (bool) $row['is_collection'] : false,
               'is_disbursement' => isset($row['is_disbursement']) ? (bool) $row['is_disbursement'] : false,
               'cash_fund_id' => isset($row['cash_fund_id']) ? (int) $row['cash_fund_id'] : null,
               'fund_cluster' => $row['fund_cluster'] ?? null,
               'is_default' => isset($row['is_default']) ? (bool) $row['is_default'] : false,
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
