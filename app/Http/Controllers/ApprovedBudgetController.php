<?php

namespace App\Http\Controllers;

use App\Models\ApprovedBudgetModel;
use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\LibraryActivityModel;
use App\Models\LibraryExpenseAccountModel;
use App\Models\LibraryObjectExpenditureModel;
use App\Models\LibraryPAPModel;
use App\Models\LibrarySubactivityModel;
use App\Models\ViewApprovedBudgetModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovedBudgetController extends Controller
{
   /**
    * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($year_selected)
   {
      $username = auth()->user()->username; 
      $user_id = auth()->user()->id;       
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();      
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();   
      $data = [
         "year_selected" => $year_selected,
         "division_id" => $user_division_id,         
      ];     
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();     
      foreach($user_roles as $row){
         $user_roles_data []= [
            "user_role" => $row->user_role,
            "user_role_id" => $row->role_id,  
         ];
      }         
      if($emp_code=='PS1286' || $emp_code=='MOL001'){
         $user_division_id = '9';
         $user_division_acronym = 'FAD-DO';
         $division_acronym = 'FAD-DO';
      }
      $years = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'ASC')->get();
      $fiscal_years_vertical = FiscalYearsModel::where('year', $year_selected)->where("is_active", 1)->where("is_deleted", 0)->get();
      $fy1 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year1 as fiscal_year')
         ->where('year','=',$year_selected)
         ->where('is_active','=',1)
         ->where('is_deleted','=',0);
      $fy2 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year2 as fiscal_year')
         ->where('year','=',$year_selected)
         ->where('.is_active','=',1)
         ->where('is_deleted','=',0);
      $fiscal_years_horizontal = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year3 as fiscal_year')
         ->where('year','=',$year_selected)->where('.is_active','=',1)->where('is_deleted','=',0)
         ->union($fy1)->union($fy2)->orderBy('fiscal_year', 'ASC')->get();
      $getLibraryPAP = LibraryPAPModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('pap_code')->get();
      $getLibraryActivities = LibraryActivityModel::where('division_id',$user_division_id)->orWhereNull('division_id')->where("is_active", 1)->where("is_deleted", 0)->orderBy('activity')->get();
      $getLibrarySubactivities = LibrarySubactivityModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('subactivity')->get();
      $getLibraryExpenseAccounts = LibraryExpenseAccountModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('expense_account')->get();
      $getLibraryObjectExpenditures = LibraryObjectExpenditureModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('object_expenditure')->get(); 
      // $active_status_id = BpStatusModel::where('division_id', $user_division_id)->where('year', $year_selected)
      //    ->where("is_active", 1)->where("is_deleted", 0)->pluck('status_id')->first(); 
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {    
         if (auth()->user()->hasAnyRole('Super Administrator|Administrator|Budget Officer')){  
            $title = "Approved Budget";  
            $user_role = ViewUsersHasRolesModel::where('id', $user_id)
               ->where(function ($query) {
                  $query->where('role_id','!=',5)
                     ->orWhere('role_id','!=',6)
                     ->orWhere('role_id','!=', 8)
                     ->orWhere('role_id','!=', 9)
                     ->orWhere('role_id','!=', 7)
                     ->orWhere('role_id','!=', 11);
               })
               ->pluck('user_role')->first(); 
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
               ->where(function ($query) {
                  $query->where('role_id','!=',5)
                     ->orWhere('role_id','!=',6)
                     ->orWhere('role_id','!=', 7)
                     ->orWhere('role_id','!=', 8)
                     ->orWhere('role_id','!=', 9)
                     ->orWhere('role_id','!=', 11);
               })
               ->pluck('role_id')->first();                  
            $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
            $getApprovedBudget = ViewApprovedBudgetModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
            // $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('year', $year_selected)->get();
            return view('programming_allocation.approved_budget.divisions')
               ->with(compact('title'), $title)
               ->with(compact('data'),$data)
               ->with(compact('data'),$data)
               ->with(compact('username'), $username)
               ->with(compact('user_id'), $user_id)
               ->with(compact('user_role'))
               ->with(compact('user_role_id'))
               ->with(compact('user_roles'))
               ->with(compact('user_roles_data'))
               ->with(compact('user_division_id'), $user_division_id)
               ->with(compact('user_division_acronym'), $user_division_acronym)
               ->with(compact('user_fullname'), $user_fullname)
               ->with(compact('divisions'), $divisions)
               ->with(compact('getLibraryPAP'), $getLibraryPAP)
               ->with(compact('getLibraryActivities'), $getLibraryActivities)
               ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
               ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
               ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
               ->with(compact('getApprovedBudget'))
               ->with(compact('year_selected'), $year_selected)
               ->with(compact('years'), $years)
               // ->with(compact('active_status_id'))
               ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
               ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical);
         } 
      }
   }

   public function store(Request $request)
   {
      if ($request->ajax()) {
         $user_id = auth()->user()->id;         
         $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->pluck('role_id')->first();
         $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
         $division_id = $request->division_id;  
         $year = $request->year;   
         $status_id = $request->status_id;  
         if($status_id==56){
            if (CpStatusModel::where('division_id', $division_id)->where('year', $year)->count() > 0) {
               CpStatusModel::where('division_id', $division_id)->where('year', $year)->where('is_active', '1')         
               ->update([
                  'is_active' => '0'
               ]); 
            }
               
            $cp_status_data = new CpStatusModel([
               'division_id' => $division_id,
               'year' => $year,
               'status_id' => '16',               
               'status_by_user_id' => $user_id,
               'status_by_user_role_id' => $user_role_id ?? NULL,
               'status_by_user_division_id' => $user_division_id,
               'is_active' => '1',
            ]);
            $cp_status_data->save();

            $get_ab_ref = ApprovedBudgetModel::where('division_id', $division_id)
               ->where('year', $year)->where('is_active',1)->where('is_deleted',0)->get(); 
            foreach($get_ab_ref as $value){                  
               $ab_data[] =[
                  'reference_ab_id' => $value->id,
                  'division_id' => $value->division_id,
                  'year' => $value->year,
                  'pap_id' => $value->pap_id,
                  'activity_id' => $value->activity_id,
                  'subactivity_id' => $value->subactivity_id ?? NULL,
                  'expense_account_id' => $value->expense_account_id,
                  'object_expenditure_id' => $value->object_expenditure_id,
                  'object_specific_id' => $value->object_specific_id ?? NULL,
                  'pooled_at_division_id' => $value->pooled_at_division_id ?? NULL,
                  'jan_amount' => $value->annual_amount ?? NULL,
               ];
            }
            CashProgramsModel::insert($ab_data);                 
         } 
      }
   }

   /**
    * Display the specified resource.
   *
   * @param  \App\Models\ApprovedBudgetModel  $approvedBudgetModel
   * @return \Illuminate\Http\Response
   */
   public function show(ApprovedBudgetModel $approvedBudgetModel)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ApprovedBudgetModel  $approvedBudgetModel
   * @return \Illuminate\Http\Response
   */
   public function edit(ApprovedBudgetModel $approvedBudgetModel)
   {
      //
   }

   /**
    * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ApprovedBudgetModel  $approvedBudgetModel
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, ApprovedBudgetModel $approvedBudgetModel)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
   *
   * @param  \App\Models\ApprovedBudgetModel  $approvedBudgetModel
   * @return \Illuminate\Http\Response
   */
   public function destroy(ApprovedBudgetModel $approvedBudgetModel)
   {
      //
   }
}
