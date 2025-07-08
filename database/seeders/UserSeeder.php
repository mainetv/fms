<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class UserSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/users.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('users')->insert([
            'id' => $row['id'],
            'username' => $row['username'],
            'emp_code' => $row['emp_code'],
            'user_role_id' => parseNull('user_role_id', $row),
            'email' => parseNull('email', $row),
            'email_verified_at' => formatDate(parseNull('email_verified_at', $row)),
            'password' => $row['password'],
            'two_factor_secret' => parseNull('two_factor_secret', $row),
            'two_factor_recovery_codes' => parseNull('two_factor_recovery_codes', $row),
            'two_factor_confirmed_at' => formatDate(parseNull('two_factor_confirmed_at', $row)),
            'remember_token' => parseNull('remember_token', $row),
            'current_team_id' => parseNull('current_team_id', $row),
            'profile_photo_path' => parseNull('profile_photo_path', $row),
            'is_active' => (int)($row['is_active'] ?? 1),
            'is_deleted' => (int)($row['is_deleted'] ?? 0),
            'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
            'updated_at' => formatDate(parseNull('updated_at', $row)),
            // 'deleted_at' => formatDate(parseNull('deleted_at', $row)), // Uncomment if soft deletes used
         ]);
      }
   }
}
