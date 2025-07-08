<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class DisbursementVoucherSeeder extends Seeder
{
   public function run(): void
   {
      $connection = env('DB_CONNECTION', 'mysql');
      $csvFile = database_path('seeders/csv/disbursement_vouchers.csv');

      if (!File::exists($csvFile)) {
         $this->command->error("CSV file not found: {$csvFile}");
         return;
      }

      $csv = Reader::createFromPath($csvFile, 'r');
      $csv->setDelimiter(',');
      $csv->setHeaderOffset(0);

      foreach ($csv as $row) {
         DB::connection($connection)->table('disbursement_vouchers')->updateOrInsert(
            ['id' => (int)$row['id']],
            [
               'fais_id' => isset($row['fais_id']) ? (int)$row['fais_id'] : null,
               'lddap_id' => isset($row['lddap_id']) ? (int)$row['lddap_id'] : null,
               'check_id' => isset($row['check_id']) ? (int)$row['check_id'] : null,
               'dv_no' => $row['dv_no'] ?? null,
               'dv_date' => $row['dv_date'] ?? null,
               'dv_date1' => $row['dv_date1'] ?? null,
               'division_id' => isset($row['division_id']) ? (int)$row['division_id'] : null,
               'fund_id' => isset($row['fund_id']) ? (int)$row['fund_id'] : null,
               'payee_id' => isset($row['payee_id']) ? (int)$row['payee_id'] : null,
               'total_dv_gross_amount' => isset($row['total_dv_gross_amount']) ? (float)$row['total_dv_gross_amount'] : 0,
               'total_dv_net_amount' => isset($row['total_dv_net_amount']) ? (float)$row['total_dv_net_amount'] : 0,
               'particulars' => $row['particulars'] ?? null,
               'signatory1' => $row['signatory1'] ?? null,
               'signatory1_position' => $row['signatory1_position'] ?? null,
               'signatory2' => $row['signatory2'] ?? null,
               'signatory2_position' => $row['signatory2_position'] ?? null,
               'signatory3' => $row['signatory3'] ?? null,
               'signatory3_position' => $row['signatory3_position'] ?? null,
               'tax_type_id' => isset($row['tax_type_id']) ? (int)$row['tax_type_id'] : null,
               'pay_type_id' => isset($row['pay_type_id']) ? (int)$row['pay_type_id'] : null,
               'date_out' => $row['date_out'] ?? null,
               'out_to' => $row['out_to'] ?? null,
               'received_from' => $row['received_from'] ?? null,
               'date_returned' => $row['date_returned'] ?? null,
               'po_no' => $row['po_no'] ?? null,
               'po_date' => $row['po_date'] ?? null,
               'invoice_no' => $row['invoice_no'] ?? null,
               'invoice_date' => $row['invoice_date'] ?? null,
               'jobcon_no' => $row['jobcon_no'] ?? null,
               'jobcon_date' => $row['jobcon_date'] ?? null,
               'or_no' => $row['or_no'] ?? null,
               'or_date' => $row['or_date'] ?? null,
               'cod_no' => $row['cod_no'] ?? null,
               'is_locked' => isset($row['is_locked']) ? (int)$row['is_locked'] : 0,
               'is_active' => isset($row['is_active']) ? (int)$row['is_active'] : 1,
               'is_deleted' => isset($row['is_deleted']) ? (int)$row['is_deleted'] : 0,
               'cancelled_at' => $row['cancelled_at'] ?? null,
               'locked_at' => $row['locked_at'] ?? null,
               'created_at' => formatDate(parseNull('created_at', $row)) ?? now(),
               'updated_at' => formatDate(parseNull('updated_at', $row)),
               'deleted_at' => formatDate(parseNull('deleted_at', $row)),
            ]
         );
      }
   }
}
