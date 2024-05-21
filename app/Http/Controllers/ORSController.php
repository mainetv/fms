<?php

namespace App\Http\Controllers;

use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\FundsModel;
use App\Models\LibraryActivityModel;
use App\Models\LibraryExpenseAccountModel;
use App\Models\LibraryObjectExpenditureModel;
use App\Models\LibraryPAPModel;
use App\Models\LibrarySubactivityModel;
use App\Models\ORSModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ORSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request, $month_selected, $year_selected)
   {    
      $user_role_id = auth()->user()->user_role_id; 
      $username = auth()->user()->username; 
      $user_id = auth()->user()->id;       
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();   
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();   
      $data = [
         "month_selected" => $month_selected,
         "year_selected" => $year_selected,
      ];   
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
      // $getFunds = FundsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fund_code')->get();
      $getLibraryPAP = LibraryPAPModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('pap_code')->get();
      $getLibraryActivities = LibraryActivityModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('activity')->get();
      $getLibrarySubactivities = LibrarySubactivityModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('subactivity')->get();
      $getLibraryExpenseAccounts = LibraryExpenseAccountModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('expense_account')->get();
      $getLibraryObjectExpenditures = LibraryObjectExpenditureModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('object_expenditure')->get(); 
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {         
         if($user_role_id == '0' || $user_role_id == '1' || $user_role_id == '3' || $user_role_id == '8' || $user_role_id == '9' || $user_role_id == '10'){
            $title = "ORS";                       
            $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
            Session::put('division', 'MISD');
            Session::put('year_selected', $year_selected);
            Session::put('month_selected', $month_selected);
            return view('funds_utilization.ors.division_tabs')
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
               ->with(compact('year_selected'), $year_selected)
               ->with(compact('years'), $years)
               ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
               ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical);
         }       
         // elseif($user_role_id == '5'){ //Specific divisions under their cluster only
         //    $title = "Division Budget Proposals"; 
         //    $divisions = DivisionsModel::where('cluster_id', $user_division_id)-> where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
         //    $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('division_id',$user_division_id)->where('year', $year_selected)->get();
         //    return view('allotment.division_tabs')
         //       ->with(compact('title'), $title)
         //       ->with(compact('data'),$data)
         //       ->with(compact('username'), $username)
         //       ->with(compact('user_id'), $user_id)
         //       ->with(compact('user_role'), $user_role)
         //       ->with(compact('user_role_id'), $user_role_id)
         //       ->with(compact('user_division_id'), $user_division_id)
         //       ->with(compact('user_fullname'), $user_fullname)
         //       ->with(compact('user_division_acronym'), $user_division_acronym)
         //       ->with(compact('divisions'), $divisions)
         //       ->with(compact('getLibraryPAP'), $getLibraryPAP)
         //       ->with(compact('getLibraryActivities'), $getLibraryActivities)
         //       ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
         //       ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
         //       ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
         //       ->with(compact('year_selected'), $year_selected)
         //       ->with(compact('years'), $years)
         //       ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
         //       ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical)
         //       ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
         // }
         // elseif($user_role_id == '6' || $user_role_id == '7'){ //User specific division only
         //    $title = "Division Budget Proposal"; 
         //    $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
         //    $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('division_id',$user_division_id)->where('year', $year_selected)->get();
         //    return view('allotment.division')
         //    ->with(compact('title'), $title)
         //    ->with(compact('data'),$data)
         //    ->with(compact('username'), $username)
         //    ->with(compact('user_id'), $user_id)
         //    ->with(compact('user_role'), $user_role)
         //    ->with(compact('user_role_id'), $user_role_id)
         //    ->with(compact('user_division_id'), $user_division_id)
         //    ->with(compact('user_division_acronym'), $user_division_acronym)
         //    ->with(compact('user_fullname'), $user_fullname)
         //    ->with(compact('divisions'), $divisions)
         //    ->with(compact('getLibraryPAP'), $getLibraryPAP)
         //    ->with(compact('getLibraryActivities'), $getLibraryActivities)
         //    ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
         //    ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
         //    ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
         //    ->with(compact('year_selected'), $year_selected)
         //    ->with(compact('years'), $years)
         //    ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
         //    ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical)
         //    ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
         // }
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
     * @param  \App\Models\ORSModel  $oRSModel
     * @return \Illuminate\Http\Response
     */
    public function show(ORSModel $oRSModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ORSModel  $oRSModel
     * @return \Illuminate\Http\Response
     */
    public function edit(ORSModel $oRSModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ORSModel  $oRSModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ORSModel $oRSModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ORSModel  $oRSModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ORSModel $oRSModel)
    {
        //
    }
}
