<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class HrmsUserSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION_HRMS', 'mysql');
      $csvFile = database_path('seeders/csv/hrmsdb/users.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('users')->updateOrInsert(
            ['id' => (int) $row['id']],
            [
               'dtr_exe' => isset($row['dtr_exe']) ? (int) $row['dtr_exe'] : null,
               'oic' => isset($row['oic']) ? (int) $row['oic'] : null,
               'lname' => $row['lname'] ?? null,
               'fname' => $row['fname'] ?? null,
               'mname' => $row['mname'] ?? null,
               'exname' => $row['exname'] ?? null,
               'birthdate' => $row['birthdate'] ?? null,
               'birthplace' => $row['birthplace'] ?? null,
               'username' => $row['username'] ?? null,
               'rfid' => $row['rfid'] ?? null,
               'usertype' => $row['usertype'] ?? null,
               'division' => $row['division'] ?? null,
               'division2' => $row['division2'] ?? null,
               'sex' => $row['sex'] ?? null,
               'employment_id' => isset($row['employment_id']) ? (int) $row['employment_id'] : null,
               'email' => $row['email'] ?? null,
               'email_verified_at' => $row['email_verified_at'] ?? null,
               'password' => $row['password'] ?? null,
               'remember_token' => $row['remember_token'] ?? null,
               'fldservice' => $row['fldservice'] ?? null,
               'pickup' => $row['pickup'] ?? null,
               'cellnum' => $row['cellnum'] ?? null,
               'image_path' => $row['image_path'] ?? null,
               'payroll' => isset($row['payroll']) ? (int) $row['payroll'] : null,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}
