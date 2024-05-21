<?php

namespace App\Http\Controllers;

use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\LibraryActivityModel;
use App\Models\LibraryExpenseAccountModel;
use App\Models\LibraryObjectExpenditureModel;
use App\Models\LibraryPAPModel;
use App\Models\LibrarySubactivityModel;
use App\Models\QuarterlyObligationProgramModel;
use App\Models\User;
use App\Models\ViewUsersModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;

class ObligationProgramsController extends Controller
{
   /**
    * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index(Request $request, User $user, Role $role) 
   {        
      $user_role_id = auth()->user()->user_role_id; 
      $username = auth()->user()->username; 
      $user_id = auth()->user()->id;       
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();  
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();     
      $year = Carbon::now()->format('Y');
      $division_id = $request->division_id; 
      $division_code = $request->division_code; 
      $data = [
         "year_selected" => $year,
         "division_id" => $division_id,
         "division_code" => $division_code,
      ];
      if($emp_code=='0121-A2021'){
         $user_division_id = '9';
         $user_division_acronym = 'FAD-DO';
         $division_acronym = 'FAD-DO';
      }
      $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
      $fiscal_years = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'ASC')->get();
      $fiscal_year_selected = FiscalYearsModel::where('year', $year)->where("is_active", 1)->where("is_deleted", 0)->get();
      $getLibraryPAP = LibraryPAPModel::where("is_active", 1)->where("is_deleted", 0)->get();          
      $getLibraryActivities = LibraryActivityModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('activity')->get();
      $getLibrarySubactivities = LibrarySubactivityModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('subactivity')->get();
      $getLibraryExpenseAccounts = LibraryExpenseAccountModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('expense_account')->get();
      $getLibraryObjectExpenditures = LibraryObjectExpenditureModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('object_expenditure')->get(); 
      // if($user->hasAnyRole(['Super Administrator','Administrator','Budget','FAD Director','BPAC'])){ //Displays all divisions
      if($user_role_id == '0' || $user_role_id == '1' || $user_role_id == '3' || $user_role_id == '8' || $user_role_id == '9' || $user_role_id == '10'){
         $title = "Quarterly Obligation Programs";
         return view('programming_allocation.nep.quarterly_obligation_programs.index')
            ->with(compact('title'), $title)
            ->with(compact('data'),$data)
            ->with(compact('username'), $username)
            ->with(compact('user_id'), $user_id)
            ->with(compact('user_role'), $user_role)
            ->with(compact('user_role_id'), $user_role_id)
            ->with(compact('user_division_id'), $user_division_id)
            ->with(compact('user_fullname'), $user_fullname)
            ->with(compact('divisions'), $divisions)
            ->with(compact('getLibraryPAP'), $getLibraryPAP)
            ->with(compact('getLibraryActivities'), $getLibraryActivities)
            ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
            ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
            ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
            // ->with(compact('getLibraryObjectSpecifics'), $getLibraryObjectSpecifics)
            ->with(compact('year'), $year)
            ->with(compact('fiscal_years'), $fiscal_years)
            ->with(compact('fiscal_year_selected'), $fiscal_year_selected);
      } 
         
      elseif($user_role_id == '3'){ //Specific divisions under their cluster only
      // elseif($user->hasAnyRole('Cluster Budget Controller')){ //Specific divisions under their cluster only
         $title = "Quarterly Obligation Program";  
         return view('programming_allocation.nep.quarterly_obligation_programs.cluster.index')
            ->with(compact('title'), $title)
            ->with(compact('data'),$data)
            ->with(compact('username'), $username)
            ->with(compact('user_id'), $user_id)
            ->with(compact('user_role'), $user_role)
            ->with(compact('user_role_id'), $user_role_id)
            ->with(compact('user_division_id'), $user_division_id)
            ->with(compact('user_fullname'), $user_fullname)
            ->with(compact('user_division_acronym'), $user_division_acronym)
            ->with(compact('division_id'), $division_id)
            ->with(compact('getLibraryPAP'), $getLibraryPAP)
            ->with(compact('getLibraryActivities'), $getLibraryActivities)
            ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
            ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
            ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
            ->with(compact('year'), $year)
            ->with(compact('fiscal_years'), $fiscal_years)
            ->with(compact('fiscal_year_selected'), $fiscal_year_selected);
      } 
      
      // elseif($user->hasAnyRole(['Division Budget Controller','Division Director'])){ //User specific division only
      elseif($user_role_id == '6' || $user_role_id == '7'){ //User specific division only
         $title = "Quarterly Obligation Program";
         return view('programming_allocation.nep.quarterly_obligation_programs.division')
            ->with(compact('title'), $title)
            ->with(compact('data'),$data)
            ->with(compact('username'), $username)
            ->with(compact('user_id'), $user_id)
            ->with(compact('user_role'), $user_role)
            ->with(compact('user_role_id'), $user_role_id)
            ->with(compact('user_division_id'), $user_division_id)
            ->with(compact('user_fullname'), $user_fullname)
            ->with(compact('user_division_acronym'), $user_division_acronym)
            ->with(compact('division_id'), $division_id)
            ->with(compact('divisions'), $divisions)
            ->with(compact('getLibraryPAP'), $getLibraryPAP)
            ->with(compact('getLibraryActivities'), $getLibraryActivities)
            ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
            ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
            ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
            ->with(compact('year'), $year)
            ->with(compact('fiscal_years'), $fiscal_years)
            ->with(compact('fiscal_year_selected'), $fiscal_year_selected);
      }
   }

   /**
    * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      //
   }

   /**
    * Display the specified resource.
   *
   * @param  \App\Models\QuarterlyObligationProgramModel  $quarterlyObligationProgramModel
   * @return \Illuminate\Http\Response
   */
   public function show(QuarterlyObligationProgramModel $quarterlyObligationProgramModel)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
   *
   * @param  \App\Models\QuarterlyObligationProgramModel  $quarterlyObligationProgramModel
   * @return \Illuminate\Http\Response
   */
   public function edit(QuarterlyObligationProgramModel $quarterlyObligationProgramModel)
   {
      //
   }

   /**
    * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\QuarterlyObligationProgramModel  $quarterlyObligationProgramModel
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, QuarterlyObligationProgramModel $quarterlyObligationProgramModel)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
   *
   * @param  \App\Models\QuarterlyObligationProgramModel  $quarterlyObligationProgramModel
   * @return \Illuminate\Http\Response
   */
   public function destroy(QuarterlyObligationProgramModel $quarterlyObligationProgramModel)
   {
      //
   }
}
