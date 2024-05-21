<?php

use App\Http\Controllers\AgencyBudgetProposalController;
use App\Http\Controllers\AgencyCashProgramsController;
use App\Http\Controllers\AgencyQuarterlyObligationProgramsController;
use App\Http\Controllers\AllotmentController;
use App\Http\Controllers\ApprovedBudgetController;
use App\Http\Controllers\BpForm205Controller;
use App\Http\Controllers\BudgetProposalsController;
use App\Http\Controllers\CashProgramsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RSController;
use App\Http\Controllers\PPMPController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BpForm3Controller;
use App\Http\Controllers\BpForm4BController;
use App\Http\Controllers\BpForm4Controller;
use App\Http\Controllers\BpForm5Controller;
use App\Http\Controllers\BpForm6Controller;
use App\Http\Controllers\BpForm7Controller;
use App\Http\Controllers\BpForm8Controller;
use App\Http\Controllers\BpForm9Controller;
use App\Http\Controllers\ChecksController;
use App\Http\Controllers\ClusterCashProgramsController;
use App\Http\Controllers\LibraryPAPController;
use App\Http\Controllers\FiscalYearsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\LibraryActivityController;
use App\Http\Controllers\PhysicalTargetsController;
use App\Http\Controllers\LibrarySubactivityController;
use App\Http\Controllers\ClusterProposalsController;
use App\Http\Controllers\ClusterQuarterlyObligationProgramsController;
use App\Http\Controllers\DVController;
use App\Http\Controllers\LDDAPController;
use App\Http\Controllers\LibraryObjectExpenditureController;
use App\Http\Controllers\LibraryPayeesController;
use App\Http\Controllers\NcaController;
use App\Http\Controllers\QuarterlyObligationProgramsController;
use App\Http\Controllers\RADAIController;
use App\Http\Controllers\RCIController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserRolesController;
use App\Models\LibraryPayeesModel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check()){       
        return Redirect::to('dashboard');
    }
    return view('auth.login');
});

Route::middleware(['auth','role:Super Administrator|Administrator|Accounting Officer|Budget Officer'])->controller(GlobalController::class)->group(function () {
    Route::get('/administration', 'administration')->name('global.administration');
    Route::get('/libraries', 'libraries')->name('global.libraries'); 
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer'])->controller(GlobalController::class)->group(function () { 
    Route::get('/budget/maintenance', 'budget_maintenance')->name('global.budget_maintenance');      
});

Route::middleware(['auth'])->controller(GlobalController::class)->group(function () { 
    Route::get('/budget_preparation/bp_forms/{year}', 'bp_forms_byYear')->name('bp_forms_byYear');  
    Route::get('/show_activity_by_division', 'show_activity_by_division')->name('show_activity_by_division'); 
    Route::get('/show_subactivity_by_activity_id', 'show_subactivity_by_activity_id')->name('show_subactivity_by_activity_id'); 
    Route::get('/show_object_expenditure_by_expense_account_id', 'show_object_expenditure_by_expense_account_id')->name('show_object_expenditure_by_expense_account_id'); 
    Route::get('/show_object_specific_by_object_expenditure_id', 'show_object_specific_by_object_expenditure_id')->name('show_object_specific_by_object_expenditure_id');     
    Route::get('/show_position_by_emp_code', 'show_position_by_emp_code')->name('show_position_by_emp_code');    
    Route::get('/show_bank_account_by_fund', 'show_bank_account_by_fund')->name('show_bank_account_by_fund'); 
    Route::get('/show_sidemenu_by_user_role', 'show_sidemenu_by_user_role')->name('show_sidemenu_by_user_role');     
    Route::get('/show_bank_accounts_by_payee', 'show_bank_accounts_by_payee')->name('show_bank_accounts_by_payee'); 
    Route::get('/show_bank_account_no', 'show_bank_account_no')->name('show_bank_account_no'); 

    Route::get('/show_obligations_by_allotment_id', 'show_obligations_by_allotment_id')->name('show_obligations_by_allotment_id');  
});

Route::middleware(['auth'])->controller(ReportsController::class)->group(function () {     
    Route::get('/reports/rs_per_division', 'rs_per_division')->name('rs_per_division');    
    Route::get('/reports/rs_per_activity/{rs}/{year}/{view}', 'rs_per_activity')->name('rs_per_activity'); 
    Route::get('/reports/rs_per_pap/{rs}/{start}/{end}', 'rs_per_pap')->name('rs_per_pap');  
    Route::get('/reports/rs_balance', 'rs_balance')->name('rs_balance'); 
    Route::get('/reports/rs_balance_by_division', 'rs_balance_by_division')->name('rs_balance_by_division'); 
    
    Route::get('/reports/lddap_check_per_pap', 'lddap_check_per_pap')->name('lddap_check_per_pap');
    Route::get('/reports/ada_check_per_pap', 'ada_check_per_pap')->name('ada_check_per_pap');
    Route::get('/reports/ada_check_issued', 'ada_check_issued')->name('ada_check_issued'); 
    Route::get('/reports/ada_check_issued_per_payee', 'ada_check_issued_per_payee')->name('ada_check_issued_per_payee'); 

    Route::get('/reports/dv_by_division', 'dv_by_division')->name('dv_by_division');
    Route::get('/reports/received_dvs', 'received_dvs')->name('received_dvs');
    Route::get('/reports/dv_per_division', 'dv_per_division')->name('dv_per_division'); 
    Route::get('/reports/dvrs_per_pap', 'dvrs_per_pap')->name('dvrs_per_pap'); 

    Route::get('/reports/ada_issued', 'ada_issued')->name('ada_issued');
    Route::get('/reports/checks_issued', 'checks_issued')->name('checks_issued');     
    Route::get('/reports/index_payment/{payee}/{year}', 'index_payment')->name('index_payment');    

    Route::get('/reports/dv_summary/{fund}/{year}', 'dv_summary')->name('dv_summary');  
    Route::get('/reports/saob/{rs}/{division}/{year}/{view}', 'saob')->name('saob'); 
    Route::get('/reports/allotment_summary/{rs}/{year}', 'allotment_summary')->name('allotment_summary');     
    Route::get('/reports/lddap_summary/{fund}/{start}/{end}', 'lddap_summary')->name('lddap_summary'); 

    Route::get('/reports/monthly_wtax/{month}/{year}', 'monthly_wtax')->name('monthly_wtax');    
    Route::get('/reports/monthly_wtax_by_payee/{month}/{year}', 'monthly_wtax_by_payee')->name('monthly_wtax_by_payee');         

    Route::get('/show_dvs_by_division', 'show_dvs_by_division')->name('show_dvs_by_division');     
    Route::get('/show_rs_per_division', 'show_rs_per_division')->name('show_rs_per_division');     
    Route::get('/show_ada_check', 'show_ada_check')->name('show_ada_check'); 
    Route::get('/show_ada_check_per_payee', 'show_ada_check_per_payee')->name('show_ada_check_per_payee'); 
    Route::get('/show_rs_balance', 'show_rs_balance')->name('show_rs_balance'); 
    Route::get('/show_rs_balance_by_division', 'show_rs_balance_by_division')->name('show_rs_balance_by_division'); 
    Route::get('/show_checks', 'show_checks')->name('show_checks'); 
    Route::get('/show_lddaps', 'show_lddaps')->name('show_lddaps'); 
    Route::get('/show_index_payment', 'show_index_payment')->name('show_index_payment'); 

    Route::get('/show_dv_by_fund_division_daterange', 'show_dv_by_fund_division_daterange')->name('show_dv_by_fund_division_daterange'); 
    Route::get('/show_dvs', 'show_dvs')->name('show_dvs'); 

    Route::get('/print_rs_per_pap/{rs}/{start}/{end}', 'print_rs_per_pap')->name('print_rs_per_pap'); 
Route::get('/reports/print_saob/{rstype_id}/{division_id}/{yead}/{view}', 'print_saob')->name('print_saob'); 
});

Route::middleware(['auth'])->controller(NotificationsController::class)->group(function(){
    Route::get('/notifications', 'index')->name('notifications.index');    
    Route::patch('', 'update')->name('notifications.update');    
});

Route::controller(DashboardController::class)->group(function(){
    $value = session('set_user_role_id');
    session(['set_user_role_id' => 'value']);
    Route::get('/dashboard', 'index')->name('dashboard.index');    
});

Route::middleware(['auth','role:Super Administrator|Administrator'])->controller(UsersController::class)->group(function(){   
    Route::get('/users/table', 'table')->name('users.table');    
    Route::get('/users/show', 'show')->name('users.show');    
    Route::post('/users/store', 'store')->name('users.store');    
    Route::patch('/users/update', 'update')->name('users.update');    
    Route::patch('/users/delete', 'delete')->name('users.delete');    
});

Route::middleware(['auth','role:Super Administrator|Administrator'])->controller(UserRolesController::class)->group(function(){   
    Route::middleware(['auth','role:Super Administrator|Administrator'])->get('/user_roles/table', 'table')->name('user_roles.table');    
    // Route::get('/user_roles/show', 'show')->name('user_roles.show');    
    Route::middleware(['auth','role:Super Administrator'])->post('/user_roles/store', 'store')->name('user_roles.store');    
    // Route::patch('/user_roles/update', 'update')->name('user_roles.update');    
    // Route::patch('/user_roles/delete', 'delete')->name('user_roles.delete');    
});

Route::middleware(['auth','role:Super Administrator|Administrator|Accounting Officer'])->controller(LibraryPayeesController::class)->group(function(){   
    Route::get('/library_payees/table', 'table')->name('library_payees.table');    
    Route::get('/library_payees/show', 'show')->name('payee.show');    
    Route::post('/library_payees/store', 'store')->name('library_payees.store');    
    Route::patch('/library_payees/update', 'update')->name('library_payees.update');    
    Route::patch('/library_payees/delete', 'delete')->name('library_payees.delete');    
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer'])->controller(LibraryPAPController::class)->group(function(){   
    Route::get('/library_pap/table', 'table')->name('library_pap.table');    
    Route::get('/library_pap/show', 'show')->name('library_pap.show');    
    Route::post('/library_pap/store', 'store')->name('library_pap.store');    
    Route::patch('/library_pap/update', 'update')->name('library_pap.update');    
    Route::patch('/library_pap/delete', 'delete')->name('library_pap.delete');    
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer'])->controller(LibraryActivityController::class)->group(function(){   
    Route::get('/library_activity/table', 'table')->name('library_activity.table');    
    Route::get('/library_activity/show', 'show')->name('library_activity.show');    
    Route::post('/library_activity/store', 'store')->name('library_activity.store');    
    Route::patch('/library_activity/update', 'update')->name('library_activity.update');    
    Route::patch('/library_activity/delete', 'delete')->name('library_activity.delete');    
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer'])->controller(LibrarySubactivityController::class)->group(function(){   
    Route::get('/library_subactivity/table', 'table')->name('library_subactivity.table');    
    Route::get('/library_subactivity/show', 'show')->name('library_subactivity.show');    
    Route::post('/library_subactivity/store', 'store')->name('library_subactivity.store');    
    Route::patch('/library_subactivity/update', 'update')->name('library_subactivity.update');    
    Route::patch('/library_subactivity/delete', 'delete')->name('library_subactivity.delete');    
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer'])->controller(LibraryObjectExpenditureController::class)->group(function(){   
    Route::get('/library_object_expenditure/table', 'table')->name('library_object_expenditure.table');    
    Route::get('/library_object_expenditure/show', 'show')->name('library_object_expenditure.show');    
    Route::post('/library_object_expenditure/store', 'store')->name('library_object_expenditure.store');    
    Route::patch('/library_object_expenditure/update', 'update')->name('library_object_expenditure.update');    
    Route::patch('/library_object_expenditure/delete', 'delete')->name('library_object_expenditure.delete');    
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer'])->controller(FiscalYearsController::class)->group(function(){ 
    Route::get('/fiscal_years/index', 'index')->name('fiscal_years.index');  
    Route::get('/fiscal_years/table', 'table')->name('fiscal_years.table');  
    Route::get('/fiscal_years/show', 'show')->name('fiscal_years.show');   
    Route::post('/fiscal_years/store', 'store')->name('fiscal_years.store');   
    Route::patch('/fiscal_years/update', 'update')->name('fiscal_years.update');  
    Route::patch('/fiscal_years/delete', 'delete')->name('fiscal_years.delete');
    Route::patch('/fiscal_years/close', 'close')->name('fiscal_years.close');
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer'])->controller(ApprovedBudgetController::class)->group(function(){
    Route::get('/programming_allocation/approved_budget/divisions/{year}', 'index')->name('budget.index');   
    Route::post('/programming_allocation/approved_budget/store', 'store')->name('budget.store');   
    Route::get('/programming_allocation/approved_budget/show/{id}', 'show')->name('budget.show');
    Route::patch('/programming_allocation/approved_budget/update', 'update')->name('budget.update');
    Route::patch('/programming_allocation/approved_budget/delete', 'delete')->name('budget.delete');   
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer|Division Budget Controller|Accounting Officer'])->controller(AllotmentController::class)->group(function(){
    Route::get('/programming_allocation/allotment/{rs}/{year}/{view}', 'index')->name('allotment.index');   
    Route::post('/programming_allocation/allotment/store', 'store')->name('allotment.store');   
    Route::get('/programming_allocation/allotment/show/{id}', 'show')->name('allotment.show');
    Route::get('/programming_allocation/allotment/show_adjustment/{id}', 'show_adjustment')->name('allotment.show_adjustment');
    Route::patch('/programming_allocation/allotment/update', 'update')->name('allotment.update');
    Route::patch('/programming_allocation/allotment/delete', 'delete')->name('allotment.delete');   
    
    Route::get('/show_adjustments_by_allotment_id', 'show_adjustments_by_allotment_id')->name('show_adjustments_by_allotment_id');   
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer|Division Budget Controller|Division Director|Section Head|Accounting Officer'])
->controller(RSController::class)->group(function(){
    Route::get('/funds_utilization/rs/all/{rs}/{month}/{year}', 'index_all')->name('rs.index_all');
    Route::get('/funds_utilization/rs/division/{rs}/{month}/{year}', 'index')->name('rs.index');
    Route::get('/funds_utilization/rs/budget/edit/{id}', 'edit')->name('rs.edit');
    Route::get('/funds_utilization/rs/division/edit/{id}', 'edit_division')->name('rs.edit_division');
    Route::get('/funds_utilization/rs/add/{rs}', 'add')->name('rs.add');    
    Route::get('/request_and_status/print_rs_page1/{id}', 'print_page1')->name('rs.print_page1');    
    Route::get('/request_and_status/print_rs_page2/{id}', 'print_page2')->name('rs.print_page2');      
        
    Route::get('/show_attached_allotment_by_rs', 'show_attached_allotment_by_rs')->name('show_attached_allotment_by_rs');    
    Route::get('/show_attached_activities_by_rs', 'show_attached_activities_by_rs')->name('show_attached_activities_by_rs');         
       
    Route::patch('/generate_rs_no', 'generate_rs_no')->name('generate_rs_no'); 

    Route::get('/show_particulars_template_by_rs_type', 'show_particulars_template_by_rs_type')->name('show_particulars_template_by_rs_type'); 
    Route::get('/show_all_allotment', 'show_all_allotment')->name('show_all_allotment');   
    Route::get('/show_rs_transaction_type', 'show_rs_transaction_type')->name('show_rs_transaction_type');        
    Route::get('/show_rs_by_month_year', 'show_rs_by_month_year')->name('show_rs_by_month_year');               
    Route::get('/show_rs_by_division_month_year', 'show_rs_by_division_month_year')->name('show_rs_by_division_month_year');               

    Route::post('/funds_utilization/rs/store', 'store')->name('rs.store');   
    Route::get('/funds_utilization/rs/show', 'show')->name('rs.show');    
    Route::patch('/funds_utilization/rs/update', 'update')->name('rs.update');
    Route::patch('/funds_utilization/rs/delete', 'delete')->name('rs.delete');      
});

Route::middleware(['auth','role:Super Administrator|Administrator|Accounting Officer|Division Budget Controller|Division Director|Cash Officer|Section Head'])
->controller(DVController::class)->group(function(){
    Route::get('/funds_utilization/dv/division/{month}/{year}', 'index')->name('dv.index');          
    Route::get('/funds_utilization/dv/all_division/{month}/{year}', 'index_all_division')->name('dv.index_all_division');          
    Route::get('/funds_utilization/dv/all/{date}', 'index_all')->name('dv.index_all');    
    Route::get('/funds_utilization/dv/dvdivision/edit/{id}', 'edit_division')->name('dv.edit_division');
    Route::get('/funds_utilization/dv/accounting/edit/{id}', 'edit')->name('dv.edit');
    Route::get('/funds_utilization/dv/add', 'add')->name('dv.add');             
    Route::get('/disbursement_voucher/print_dv/{id}', 'print')->name('dv.print'); 
     
    Route::get('/show_attached_rs_by_dv', 'show_attached_rs_by_dv')->name('show_attached_rs_by_dv');  
    Route::get('/show_attached_rsnet_by_dv', 'show_attached_rsnet_by_dv')->name('show_attached_rsnet_by_dv');   
    Route::get('/show_all_dvs', 'show_all_dvs')->name('show_all_dvs');   
    Route::patch('/generate_dv_no', 'generate_dv_no')->name('generate_dv_no');   

    Route::get('/show_dv_by_date', 'show_dv_by_date')->name('show_dv_by_date');
    Route::get('/show_dv_by_month_year', 'show_dv_by_month_year')->name('show_dv_by_month_year');
    Route::get('/show_dv_by_division_month_year', 'show_dv_by_division_month_year')->name('show_dv_by_division_month_year');
    Route::get('/show_rs_by_payee', 'show_rs_by_payee')->name('show_rs_by_payee'); 
    Route::get('/show_rs_by_dv', 'show_rs_by_dv')->name('show_rs_by_dv'); 
    Route::get('/show_dv_transaction_type', 'show_dv_transaction_type')->name('show_dv_transaction_type');      
   
    Route::post('/funds_utilization/dv/store', 'store')->name('dv.store');   
    Route::get('/funds_utilization/dv/show', 'show')->name('dv.show'); 
    Route::patch('/funds_utilization/dv/update', 'update')->name('dv.update');
    Route::patch('/funds_utilization/dv/delete', 'delete')->name('dv.delete');         
});

Route::middleware(['auth','role:Super Administrator|Administrator|Accounting Officer|Cash Officer'])
->controller(LDDAPController::class)->group(function(){
    Route::get('/funds_utilization/lddap/{fund}/{month}/{year}', 'index')->name('lddap.index');    
    Route::get('/funds_utilization/lddap/add', 'add')->name('lddap.add');    
    Route::get('/funds_utilization/lddap/edit/{id}', 'edit')->name('lddap.edit');   
    Route::get('/funds_utilization/checks/view/{id}', 'view_check')->name('checks.view_check');   
    Route::get('/lddap/print_lddap/{id}', 'print_lddap'); 
    Route::get('/lddap/print_lddap_ada_summary/{id}', 'print_lddap_ada_summary'); 
   
    Route::get('/show_lddap_by_fund_month_year', 'show_lddap_by_fund_month_year')->name('show_lddap_by_fund_month_year'); 
    Route::patch('/generate_lddap_no', 'generate_lddap_no')->name('generate_lddap_no');

    Route::post('/funds_utilization/lddap/store', 'store')->name('lddap.store');   
    Route::get('/funds_utilization/lddap/show', 'show')->name('lddap.show'); 
    Route::patch('/funds_utilization/lddap/update', 'update')->name('lddap.update');
    Route::patch('/funds_utilization/lddap/delete', 'delete')->name('lddap.delete');         
});

Route::middleware(['auth','role:Super Administrator|Administrator|Cash Officer'])
->controller(ADAController::class)->group(function(){
    Route::get('/funds_utilization/ada/{fund}/{month}/{year}', 'index')->name('ada.index'); 
    Route::get('/funds_utilization/ada/add', 'add')->name('ada.add');    
    Route::get('/funds_utilization/ada/edit/{id}', 'edit')->name('ada.edit');   
    Route::get('/ada/print_lddap_ada_summary/{id}', 'print_lddap_ada_summary'); 

    Route::get('/show_lddap', 'show_lddap')->name('show_lddap'); 
    Route::get('/show_ada_by_fund_month_year', 'show_ada_by_fund_month_year')->name('show_ada_by_fund_month_year'); 
    Route::get('/show_check_by_fund_month_year', 'show_check_by_fund_month_year')->name('show_check_by_fund_month_year'); 
    Route::patch('/generate_ada_no', 'generate_ada_no')->name('generate_ada_no');

    Route::post('/funds_utilization/ada/store', 'store')->name('ada.store');   
    Route::get('/funds_utilization/ada/show', 'show')->name('ada.show'); 
    Route::patch('/funds_utilization/ada/update', 'update')->name('ada.update');
    Route::patch('/funds_utilization/ada/delete', 'delete')->name('ada.delete');         
});

Route::middleware(['auth','role:Super Administrator|Administrator|Cash Officer'])
->controller(RADAIController::class)->group(function(){
    Route::get('/funds_utilization/radai/all/{month}/{year}', 'index')->name('radai.index');    
    Route::get('/funds_utilization/radai/add', 'add')->name('radai.add');    
    Route::get('/funds_utilization/radai/edit', 'edit')->name('radai.edit'); 
    Route::get('/radai/print_radai/{id}', 'print_radai'); 

    Route::get('/show_radai_by_month_year', 'show_radai_by_month_year')->name('show_radai_by_month_year');
    Route::get('/show_ada_dvs_by_radai', 'show_ada_dvs_by_radai')->name('show_ada_dvs_by_radai');
   
    Route::post('/funds_utilization/radai/store', 'store')->name('radai.store'); 
    Route::patch('/funds_utilization/radai/update', 'update')->name('radai.update');
    Route::patch('/funds_utilization/radai/delete', 'delete')->name('radai.delete');         
});

Route::middleware(['auth','role:Super Administrator|Administrator|Cash Officer'])
->controller(ChecksController::class)->group(function(){
    Route::get('/funds_utilization/checks/all/{month}/{year}', 'index')->name('checks.index');    
    Route::get('/funds_utilization/checks/add/{date}', 'add')->name('checks.add');    
    Route::get('/funds_utilization/checks/edit/{date}', 'edit')->name('checks.edit'); 

    Route::get('/show_checks_by_month_year', 'show_checks_by_month_year')->name('show_checks_by_month_year');
   
    Route::post('/funds_utilization/checks/store', 'store')->name('checks.store');   
    Route::get('/funds_utilization/checks/show', 'show')->name('checks.show'); 
    Route::patch('/funds_utilization/checks/update', 'update')->name('checks.update');
    Route::patch('/funds_utilization/checks/delete', 'delete')->name('checks.delete');         
});

Route::middleware(['auth','role:Super Administrator|Administrator|Cash Officer'])
->controller(RCIController::class)->group(function(){
    Route::get('/funds_utilization/rci/all/{month}/{year}', 'index')->name('rci.index');    
    Route::get('/funds_utilization/rci/add', 'add')->name('rci.add');    
    Route::get('/funds_utilization/rci/edit', 'edit')->name('rci.edit'); 
    Route::get('/rci/print_rci/{id}', 'print_rci'); 

    Route::get('/show_rci_by_month_year', 'show_rci_by_month_year')->name('show_rci_by_month_year');
    Route::get('/show_check_dvs_by_rci', 'show_check_dvs_by_rci')->name('show_check_dvs_by_rci');
    Route::patch('/generate_rci_no', 'generate_rci_no')->name('generate_rci_no');   
   
    Route::post('/funds_utilization/rci/store', 'store')->name('rci.store'); 
    Route::patch('/funds_utilization/rci/update', 'update')->name('rci.update');
    Route::patch('/funds_utilization/rci/delete', 'delete')->name('rci.delete');         
});

Route::middleware(['auth','role:Super Administrator|Administrator|Accounting Officer'])
->controller(NcaController::class)->group(function(){
    Route::get('/programming_allocation/nca/{fund}/{year}', 'index')->name('nca.index');   
    Route::post('/programming_allocation/nca/store', 'store')->name('nca.store');   
    Route::get('/programming_allocation/nca/show', 'show')->name('nca.show'); 
    Route::patch('/programming_allocation/nca/update', 'update')->name('nca.update');
    Route::patch('/programming_allocation/nca/delete', 'delete')->name('nca.delete');       
});

Route::middleware(['auth'])->controller(BudgetProposalsController::class)->group(function(){
    Route::get('/budget_preparation/budget_proposal/division/{year}', 'index')->name('division_proposals.index');          
    Route::get('/budget_preparation/budget_proposal/divisions/{year}', 'index_divisions')->name('division_proposals.index_divisions');          
    Route::post('/budget_preparation/budget_proposal/division/postAction', 'postAction')->name('division_proposals.postAction');   
    Route::get('/budget_preparation/budget_proposal/division/generatePDF/{division_id}/{year}', 'generatePDF')->name('division_proposals.generatePDF'); 
    Route::patch('/budget_preparation/budget_proposal/division/update', 'update')->name('division_proposals.update');
    Route::get('/budget_preparation/budget_proposal/division/show/{id}', 'show')->name('division_proposals.show');
    Route::patch('/budget_preparation/budget_proposal/division/delete', 'delete')->name('division_proposals.delete');   
    Route::get('/budget_preparation/budget_proposal/division/show_comment/{id}', 'show_comment')->name('division_proposals.show_comment');  
});

Route::middleware(['auth'])->controller(CashProgramsController::class)->group(function(){
    Route::get('/programming_allocation/nep/monthly_cash_program/division/{year}', 'index')->name('monthly_cash_program.index');  
    Route::get('/programming_allocation/nep/monthly_cash_program/divisions/{year}', 'index_divisions')->name('monthly_cash_program.index_divisions');  
    Route::post('/programming_allocation/nep/monthly_cash_program/division/postAction', 'postAction')->name('monthly_cash_program.postAction');    
    Route::get('/programming_allocation/nep/monthly_cash_program/division/generatePDF/{division_id}/{year}', 'generatePDF')->name('monthly_cash_program.generatePDF');    
    Route::patch('/programming_allocation/nep/monthly_cash_program/division/update', 'update')->name('monthly_cash_program.update');
    Route::get('/programming_allocation/nep/monthly_cash_program/division/show/{id}', 'show')->name('monthly_cash_program.show');
    Route::patch('/programming_allocation/nep/monthly_cash_program/division/delete', 'delete')->name('monthly_cash_program.delete');
    Route::get('/programming_allocation/nep/monthly_cash_program/division/show_comment/{id}', 'show_comment')->name('monthly_cash_program.show_comment');            
});

Route::middleware(['auth'])->controller(QuarterlyObligationProgramsController::class)->group(function(){
    Route::get('/programming_allocation/nep/quarterly_obligation_program/division/{year}', 'index')->name('quarterly_obligation_program.index'); 
    Route::get('/programming_allocation/nep/quarterly_obligation_program/divisions/{year}', 'index_divisions')->name('quarterly_obligation_program.index_divisions'); 
    Route::post('/programming_allocation/nep/quarterly_obligation_program/division/postAction', 'postAction')->name('quarterly_obligation_program.postAction');    
    Route::get('/programming_allocation/nep/quarterly_obligation_program/division/generatePDF/{division_id}/{year}', 'generatePDF')->name('quarterly_obligation_program.generatePDF');    
    Route::patch('/programming_allocation/nep/quarterly_obligation_program/division/update', 'update')->name('quarterly_obligation_program.update');
    Route::get('/programming_allocation/nep/quarterly_obligation_program/division/show/{id}', 'show')->name('quarterly_obligation_program.show');
    Route::patch('/programming_allocation/nep/quarterly_obligation_program/division/delete', 'delete')->name('quarterly_obligation_program.delete');
    Route::get('/programming_allocation/nep/quarterly_obligation_program/division/show_comment/{id}', 'show_comment')->name('quarterly_obligation_program.show_comment');           
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer|Executive Director|Cluster Budget Controller|BPAC|BPAC Chair'])
->controller(ClusterProposalsController::class)->group(function(){
    Route::get('/budget_preparation/budget_proposal/cluster/{year}', 'index')->name('cluster_proposal.index');    
    Route::get('/generatePDF/{cluster_id}/{year}', 'generatePDF')->name('cluster_proposal.generatePDF');          
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer|Cluster Budget Controller|BPAC Chair|Executive Director'])
->controller(ClusterCashProgramsController::class)->group(function(){
    Route::get('/programming_allocation/nep/monthly_cash_program/cluster/{year}', 'index')->name('cluster_mcp.index');      
    Route::get('/programming_allocation/nep/monthly_cash_program/cluster/generatePDF/{division_id}/{year}', 'generatePDF')->name('cluster_mcp.generatePDF');       
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer|BPAC Chair|Cluster Budget Controller|Executive Director'])
->controller(ClusterQuarterlyObligationProgramsController::class)->group(function(){
    Route::get('/programming_allocation/nep/quarterly_obligation_program/cluster/{year}', 'index')->name('cluster_qop.index'); 
    Route::post('/programming_allocation/nep/quarterly_obligation_program/cluster/postAction', 'postAction')->name('cluster_qop.postAction');    
    Route::get('/programming_allocation/nep/quarterly_obligation_program/cluster/generatePDF/{division_id}/{year}', 'generatePDF')->name('cluster_qop.generatePDF');  
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer|Executive Director|BPAC|BPAC Chair'])
->controller(AgencyBudgetProposalController::class)->group(function(){
    Route::get('/budget_preparation/budget_proposal/agency_by_expenditure/{year}', 'agency_by_expenditure')->name('agency_proposal.agency_by_expenditure');    
    Route::get('/budget_preparation/budget_proposal/agency_by_activity/{year}', 'agency_by_activity')->name('agency_proposal.agency_by_activity');    
    Route::get('/budget_preparation/budget_proposal/agency_by_expenditurey/generatePDF/{year}', 'generatePDF_by_expenditure')->name('agency_proposal.generatePDF_by_expenditure');  
    Route::get('/budget_preparation/budget_proposal/agency_by_activity/generatePDF/{year}', 'generatePDF_by_activity')->name('agency_proposal.generatePDF_by_activity');  
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer|Executive Director|BPAC|BPAC Chair'])
->controller(AgencyCashProgramsController::class)->group(function(){
    Route::get('/programming_allocation/nep/monthly_cash_program/agency/{year}', 'index')->name('agency_mcp.index');  
    Route::post('/programming_allocation/nep/monthly_cash_program/agency/postAction', 'postAction')->name('agency_mcp.postAction');    
    Route::get('/programming_allocation/nep/monthly_cash_program/agency/generatePDF/{year}', 'generatePDF')->name('agency_mcp.generatePDF');     
});

Route::middleware(['auth','role:Super Administrator|Administrator|Budget Officer|Executive Director|BPAC|BPAC Chair'])
->controller(AgencyQuarterlyObligationProgramsController::class)->group(function(){
    Route::get('/programming_allocation/nep/quarterly_obligation_program/agency/{year}', 'index')->name('agency_qop.index'); 
    Route::post('/programming_allocation/nep/quarterly_obligation_program/agency/postAction', 'postAction')->name('agency_qop.postAction');    
    Route::get('/programming_allocation/nep/quarterly_obligation_program/agency/generatePDF/{year}', 'generatePDF')->name('agency_qop.generatePDF'); 
});

Route::middleware(['auth'])->controller(PhysicalTargetsController::class)->group(function(){
    Route::get('/budget_preparation/physical_targets/division/{year}', 'index')->name('physical_targets.index');  
    Route::get('/budget_preparation/physical_targets/division/generatePDF/{division_id}/{year}', 'generatePDF')->name('physical_targets.generatePDF');
    Route::get('/budget_preparation/physical_targets/division/store', 'store')->name('physical_targets.store'); 
    Route::get('/budget_preparation/physical_targets/division/update', 'update')->name('physical_targets.update'); 
    Route::get('/budget_preparation/physical_targets/division/show', 'show')->name('physical_targets.show'); 
    Route::get('/budget_preparation/physical_targets/division/delete', 'delete')->name('physical_targets.delete'); 
});

Route::middleware(['auth'])->controller(AgencyPhysicalTargetsController::class)->group(function(){
    Route::get('/budget_preparation/physical_targets/agency/{year}', 'index')->name('agency_pt.index');  
    Route::get('/budget_preparation/physical_targets/agency/generatePDF/{division_id}/{year}', 'generatePDF')->name('agency_pt.generatePDF');
});

Route::middleware(['auth'])->controller(BpForm3Controller::class)->group(function(){
    Route::get('/budget_preparation/bp_forms/{year}/bp_form3', 'index')->name('bp_form3.index');  
    Route::get('/bp_forms/bp_form3/show', 'show')->name('bp_form3.show');   
    Route::post('/bp_forms/bp_form3/store', 'store')->name('bp_form3.store');   
    Route::patch('/bp_forms/bp_form3/update', 'update')->name('bp_form3.update');  
    Route::patch('/bp_forms/bp_form3/delete', 'delete')->name('bp_form3.delete');  
    Route::get('/bp_form3/generatePDF/{division_id}/{year}', 'generatePDF')->name('bp_form3.generatePDF');  
});

Route::middleware(['auth'])->controller(BpForm4Controller::class)->group(function(){
    Route::get('/budget_preparation/bp_forms/{year}/bp_form4', 'index')->name('bp_form4.index'); 
    Route::get('/bp_form4/show', 'show')->name('bp_form4.show');   
    Route::post('/bp_form4/store', 'store')->name('bp_form4.store');   
    Route::patch('/bp_form4/update', 'update')->name('bp_form4.update');  
    Route::patch('/bp_form4/delete', 'delete')->name('bp_form4.delete');   
    Route::get('/bp_form4/generatePDF/{division_id}/{year}', 'generatePDF')->name('bp_form4.generatePDF');  
});

Route::middleware(['auth'])->controller(BpForm5Controller::class)->group(function(){
    Route::get('/budget_preparation/bp_forms/{year}/bp_form5', 'index')->name('bp_form5.index'); 
    Route::get('/bp_form5/show', 'show')->name('bp_form5.show');   
    Route::post('/bp_form5/store', 'store')->name('bp_form5.store');   
    Route::patch('/bp_form5/update', 'update')->name('bp_form5.update');  
    Route::patch('/bp_form5/delete', 'delete')->name('bp_form5.delete');  
    Route::get('/bp_form5/generatePDF/{division_id}/{year}', 'generatePDF')->name('bp_form5.generatePDF');  
});

Route::middleware(['auth'])->controller(BpForm6Controller::class)->group(function(){
    Route::get('/budget_preparation/bp_forms/{year}/bp_form6', 'index')->name('bp_form6.index'); 
    Route::get('/bp_form6/show', 'show')->name('bp_form6.show');   
    Route::post('/bp_form6/store', 'store')->name('bp_form6.store');   
    Route::patch('/bp_form6/update', 'update')->name('bp_form6.update');  
    Route::patch('/bp_form6/delete', 'delete')->name('bp_form6.delete');  
    Route::get('/bp_form6/generatePDF/{division_id}/{year}', 'generatePDF')->name('bp_form6.generatePDF');  
});

Route::middleware(['auth'])->controller(BpForm7Controller::class)->group(function(){
    Route::get('/budget_preparation/bp_forms/{year}/bp_form7', 'index')->name('bp_form7.index'); 
    Route::post('/bp_form7/store', 'store')->name('bp_form7.store');  
    Route::patch('/bp_form7/update', 'update')->name('bp_form7.update'); 
    Route::get('/bp_form7/generatePDF/{division_id}/{year}', 'generatePDF')->name('bp_form7.generatePDF');  
});

Route::middleware(['auth'])->controller(BpForm8Controller::class)->group(function(){
    Route::get('/budget_preparation/bp_forms/{year}/bp_form8', 'index')->name('bp_form8.index'); 
    Route::get('/bp_form8/show', 'show')->name('bp_form8.show');   
    Route::post('/bp_form8/store', 'store')->name('bp_form8.store');   
    Route::patch('/bp_form8/update', 'update')->name('bp_form8.update');  
    Route::patch('/bp_form8/delete', 'delete')->name('bp_form8.delete');  
    Route::get('/bp_form8/generatePDF/{division_id}/{year}', 'generatePDF')->name('bp_form8.generatePDF');  
});

Route::middleware(['auth'])->controller(BpForm9Controller::class)->group(function(){
    Route::get('/budget_preparation/bp_forms/{year}/bp_form9', 'index')->name('bp_form9.index'); 
    Route::get('/bp_form9/show', 'show')->name('bp_form9.show');   
    Route::post('/bp_form9/store', 'store')->name('bp_form9.store');   
    Route::patch('/bp_form9/update', 'update')->name('bp_form9.update');  
    Route::patch('/bp_form9/delete', 'delete')->name('bp_form9.delete'); 
    Route::get('/bp_form9/generatePDF/{division_id}/{year}', 'generatePDF')->name('bp_form9.generatePDF');   
});

Route::middleware(['auth'])->controller(BpForm205Controller::class)->group(function(){
    Route::get('/budget_preparation/bp_forms/{year}/bp_form205', 'index')->name('bp_form205.index'); 
    Route::get('/bp_form205/show', 'show')->name('bp_form205.show');   
    Route::post('/bp_form205/store', 'store')->name('bp_form205.store');   
    Route::patch('/bp_form205/update', 'update')->name('bp_form205.update');  
    Route::patch('/bp_form205/delete', 'delete')->name('bp_form205.delete');  
    Route::get('/bp_form205/generatePDF/{division_id}/{year}', 'generatePDF')->name('bp_form205.generatePDF');  
});

Route::middleware(['auth'])->controller(BpForm4BController::class)->group(function(){
    Route::get('/budget_preparation/bp_forms/bp_form4B', 'index')->name('bp_form4B.index'); 
    Route::get('/bp_form4B/show', 'show')->name('bp_form4B.show');   
    Route::post('/bp_form4B/store', 'store')->name('bp_form4B.store');   
    Route::patch('/bp_form4B/update', 'update')->name('bp_form4B.update');  
    Route::patch('/bp_form4B/delete', 'delete')->name('bp_form4B.delete');  
});

Route::middleware(['auth'])->controller(PPMPController::class)->group(function(){
    Route::get('/budget_preparation/ppmp', 'index')->name('ppmp.index');  
    Route::post('/budget_preparation/ppmp', 'postAction')->name('ppmp.postAction');
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
