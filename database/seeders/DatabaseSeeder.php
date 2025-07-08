<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // DB::table('library_allotment_funds')->truncate();
        // DB::table('library_funds')->truncate();
        // DB::table('library_allotment_classes')->truncate();
        // DB::table('library_fund_checks')->truncate();
        // DB::table('library_divisions')->truncate();
        // DB::table('library_adjustment_types')->truncate();
        // DB::table('library_request_status_types')->truncate();
        // DB::table('library_paps')->truncate();
        // DB::table('library_activities')->truncate();
        // DB::table('library_subactivities')->truncate();
        // DB::table('library_expense_accounts')->truncate();
        // DB::table('library_object_expenditures')->truncate();
        // DB::table('library_object_specifics')->truncate();
        // DB::table('library_banks')->truncate();
        // DB::table('library_bank_accounts')->truncate();
        // DB::table('library_dv_transaction_types')->truncate();
        // DB::table('library_dv_transaction_documents')->truncate();
        // DB::table('library_rs_transaction_types')->truncate();
        // DB::table('library_rs_transaction_documents')->truncate();
        // DB::table('library_modules')->truncate();
        // DB::table('library_tax_types')->truncate();
        // DB::table('library_pay_types')->truncate();
        // DB::table('library_payee_types')->truncate();
        // DB::table('library_payment_modes')->truncate();
        // DB::table('library_particulars_template')->truncate();
        // DB::table('library_prefix_nummber')->truncate();
        // DB::table('library_reports')->truncate();
        // DB::table('library_reports_signatories')->truncate();
        // DB::table('library_signatories')->truncate();
        // DB::table('library_payees')->truncate();

        // DB::table('budget_proposal_calls')->truncate();
        // DB::table('notificatiions')->truncate();
        // DB::table('allotments')->truncate();
        // DB::table('adjustments')->truncate();
        // DB::table('budget_proposal')->truncate();
        // DB::table('bp_comments')->truncate();
        // DB::table('bp_statuses')->truncate();
        // DB::table('bp_form3')->truncate();
        // DB::table('bp_form4')->truncate();
        // DB::table('bp_form5')->truncate();
        // DB::table('bp_form6')->truncate();
        // DB::table('bp_form7')->truncate();
        // DB::table('bp_form8')->truncate();
        // DB::table('bp_form9')->truncate();
        // DB::table('bp_form205')->truncate();
        // DB::table('bp_statuses')->truncate();
        // DB::table('monthly_cash_programs')->truncate();
        // DB::table('cp_comments')->truncate();
        // DB::table('cp_statuses')->truncate();        
        // DB::table('quarterly_obligation_programs')->truncate();
        // DB::table('qop_comments')->truncate();
        // DB::table('qop_statuses')->truncate();

        // DB::table('request_statuses')->truncate();
        // DB::table('rs_transaction_types')->truncate();
        // DB::table('rs_activities')->truncate();        
        // DB::table('rs_paps')->truncate();
        
        // DB::table('disbursement_vouchers')->truncate();
        // DB::table('dv_transaction_types')->truncate();
        // DB::table('dv_rs')->truncate();
        // DB::table('dv_rs_net')->truncate();        

        // DB::table('ncas')->truncate();
        // DB::table('checks')->truncate();        
        // DB::table('lddaps')->truncate();
        // DB::table('lddap_dvs')->truncate();
        // DB::table('adas')->truncate();
        // DB::table('ada_lddaps')->truncate();
        // DB::table('radais')->truncate();
        // DB::table('rcis')->truncate();

        // DB::table('user_roles')->truncate();
        // DB::table('users')->truncate();

        // $this->call(HrmsDesignationSeeder::class);
        // $this->call(HrmsDivisionSeeder::class);
        // $this->call(HrmsEmploymentSeeder::class);
        // $this->call(HrmsPositionSeeder::class);
        // $this->call(HrmsUserSeeder::class);
        // $this->call(HrmsPlantillaSeeder::class);
        // $this->call(HrmsEmployeeAddInfoSeeder::class);
        // $this->call(HrmsEmployeeBasicInfoSeeder::class);        

        $this->call(UserRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ModelHasUserRoleSeeder::class);

        $this->call(LibraryAllotmentFundSeeder::class);
        $this->call(FundSeeder::class);
        $this->call(AllotmentClassSeeder::class);
        $this->call(LibraryFundCheckSeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(LibraryAdjustmentTypeSeeder::class);
        $this->call(LibraryRequestStatusTypeSeeder::class);
        $this->call(LibraryPapSeeder::class);
        $this->call(LibraryActivitySeeder::class);
        $this->call(LibrarySubactivitySeeder::class);
        $this->call(LibraryExpenseAccountSeeder::class);
        $this->call(LibraryObjectExpenditureSeeder::class);
        $this->call(LibraryObjectSpecificSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(LibraryBankAccountSeeder::class);
        $this->call(LibraryDvTransactionTypeSeeder::class);
        $this->call(LibraryDvTransactionDocumentSeeder::class);
        $this->call(LibraryRsTransactionTypeSeeder::class);
        $this->call(LibraryRsTransactionDocumentSeeder::class);
        $this->call(LibraryModuleSeeder::class);
        $this->call(LibraryTaxTypeSeeder::class);
        $this->call(LibraryPayTypeSeeder::class);
        $this->call(LibraryPaymentModeSeeder::class);
        $this->call(LibraryParticularsTemplateSeeder::class);
        $this->call(LibraryPrefixNumberSeeder::class);
        $this->call(LibraryStatusSeeder::class);
        $this->call(LibraryReportSeeder::class);
        $this->call(LibraryReportsSignatorySeeder::class);        
        $this->call(LibrarySignatorySeeder::class);
        $this->call(LibraryPayeeSeeder::class);

        // $this->call(NotificationSeeder::class);
        $this->call(AllotmentSeeder::class);
        $this->call(AdjustmentSeeder::class);

        $this->call(BudgetProposalCallSeeder::class);
        $this->call(BudgetProposalSeeder::class);
        $this->call(BpCommentSeeder::class);
        $this->call(BpStatusSeeder::class);
        $this->call(BpForm3Seeder::class);
        $this->call(BpForm4Seeder::class);
        $this->call(BpForm5Seeder::class);
        $this->call(BpForm6Seeder::class);
        $this->call(BpForm7Seeder::class);
        $this->call(BpForm8Seeder::class);
        $this->call(BpForm9Seeder::class);
        $this->call(BpForm205Seeder::class);
        $this->call(MonthlyCashProgramSeeder::class);
        $this->call(CpCommentSeeder::class);
        $this->call(CpStatusSeeder::class);
        $this->call(QuarterlyObligationProgramSeeder::class);
        $this->call(QopCommentSeeder::class);
        $this->call(QopStatusSeeder::class);

        $this->call(RequestStatusSeeder::class);   
        $this->call(RsTransactionTypeSeeder::class);     
        $this->call(RsActivitySeeder::class);
        $this->call(RsPapSeeder::class);        

        $this->call(DisbursementVoucherSeeder::class);
        $this->call(DvTransactionTypeSeeder::class);
        $this->call(DvRsSeeder::class);
        $this->call(DvRsNetSeeder::class);
        $this->call(NcaSeeder::class);
        $this->call(CheckSeeder::class);
        $this->call(LddapSeeder::class);
        $this->call(LddapDvSeeder::class);
        $this->call(AdaSeeder::class);
        $this->call(AdaLddapSeeder::class);
        $this->call(RadaiSeeder::class);
        $this->call(RciSeeder::class);        
    }
}
