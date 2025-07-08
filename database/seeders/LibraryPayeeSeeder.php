<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class LibraryPayeeSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/library_payees.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('library_payees')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'old_id' => isset($row['old_id']) ? (int) $row['old_id'] : null,
               'parent_id' => isset($row['parent_id']) ? (int) $row['parent_id'] : null,
               'payee_type_id' => isset($row['payee_type_id']) ? (int) $row['payee_type_id'] : null,
               'organization_type_id' => isset($row['organization_type_id']) ? (int) $row['organization_type_id'] : null,
               'payee' => $row['payee'] ?? null,
               'previously_named' => $row['previously_named'] ?? null,
               'organization_name' => $row['organization_name'] ?? null,
               'organization_acronym' => $row['organization_acronym'] ?? null,
               'title' => $row['title'] ?? null,
               'first_name' => $row['first_name'] ?? null,
               'middle_initial' => $row['middle_initial'] ?? null,
               'last_name' => $row['last_name'] ?? null,
               'suffix' => $row['suffix'] ?? null,
               'tin' => $row['tin'] ?? null,
               'bank_id' => isset($row['bank_id']) ? (int) $row['bank_id'] : null,
               'bank_branch' => $row['bank_branch'] ?? null,
               'bank_account_name' => $row['bank_account_name'] ?? null,
               'bank_account_name1' => $row['bank_account_name1'] ?? null,
               'bank_account_name2' => $row['bank_account_name2'] ?? null,
               'bank_account_no' => $row['bank_account_no'] ?? null,
               'address' => $row['address'] ?? null,
               'office_address' => $row['office_address'] ?? null,
               'email_address' => $row['email_address'] ?? null,
               'contact_no' => $row['contact_no'] ?? null,
               'for_remit' => isset($row['for_remit']) ? (int) $row['for_remit'] : 0,
               'bg_color' => $row['bg_color'] ?? null,
               'is_verified' => isset($row['is_verified']) ? (int) $row['is_verified'] : 0,
               'is_lbp_enrolled' => isset($row['is_lbp_enrolled']) ? (int) $row['is_lbp_enrolled'] : 0,
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
