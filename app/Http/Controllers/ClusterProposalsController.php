<?php

namespace App\Http\Controllers;

use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\ViewBudgetProposalsModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClusterProposalsController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($year_selected) 
   {   
      $user_role_id = auth()->user()->user_role_id; 
      $username = auth()->user()->username; 
      $user_id = auth()->user()->id; 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();      
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();     
      foreach($user_roles as $row){
         $user_roles_data []= [
            "user_role" => $row->user_role,
            "user_role_id" => $row->role_id,  
         ];
      } 
      $data = [
         "year_selected" => $year_selected,
         "division_id" => $user_division_id,
      ];   
      $years = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'DESC')->get();
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
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {
         if (auth()->user()->hasAnyRole('Cluster Budget Controller')){
            $title = "Cluster Budget Proposal";   
            $user_role = ViewUsersHasRolesModel::where('id', $user_id)
               ->where(function ($query) {
                  $query->where('role_id','=', 5);
               })
               ->pluck('user_role')->first(); 
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
               ->where(function ($query) {
                  $query->where('role_id','=',5);
               })
               ->pluck('role_id')->first();  
               // dd($user_role);
            $divisions = DivisionsModel::where("cluster_id", $user_division_id)->where("is_active", 1)
               ->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();            
            $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('year', $year_selected)->where("is_deleted", 0)->get();
            return view('budget_preparation.budget_proposals.cluster')
               ->with(compact('title'), $title)
               ->with(compact('data'),$data)
               ->with(compact('username'), $username)
               ->with(compact('user_id'))
               ->with(compact('user_role'))
               ->with(compact('user_role_id'))
               ->with(compact('user_roles'))
               ->with(compact('user_division_id'), $user_division_id)
               ->with(compact('user_fullname'), $user_fullname)
               ->with(compact('user_division_acronym'), $user_division_acronym)
               ->with(compact('divisions'), $divisions)
               ->with(compact('years'), $years)
               ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical)
               ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
         } 
         elseif (auth()->user()->hasAnyRole('Super Administrator|Administrator|BPAC|BPAC Chair|Budget Officer|Executive Director')){
         // elseif($user_role_id == '0' || $user_role_id == '1' || $user_role_id == '3' || $user_role_id == '8' || $user_role_id == '9' || $user_role_id == '10'){
            $title = "Cluster Budget Proposal";   
            $user_role = ViewUsersHasRolesModel::where('id', $user_id)
               ->where(function ($query) {
                  $query->where('role_id','!=',11)
                     ->orWhere('role_id','!=',6)
                     ->orWhere('role_id','!=', 7)
                     ->orWhere('role_id','!=', 5);
               })
               ->get();
               // ->pluck('user_role')->first(); 
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
               ->where(function ($query) {
                  $query->where('role_id','!=',11)
                     ->orWhere('role_id','!=',6)
                     ->orWhere('role_id','!=', 7)
                     ->orWhere('role_id','!=', 5);
               })
               ->pluck('role_id')->first();  
               // dd($user_role);
            $clusters = DivisionsModel::where('is_cluster', 1)->where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();            
            $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('year', $year_selected)->where("is_deleted", 0)->get();
            return view('budget_preparation.budget_proposals.cluster_tabs')
               ->with(compact('title'), $title)
               ->with(compact('data'),$data)
               ->with(compact('username'), $username)
               ->with(compact('user_id'))
               ->with(compact('user_role'))
               ->with(compact('user_roles'))
               ->with(compact('user_role_id'))
               ->with(compact('user_division_id'), $user_division_id)
               ->with(compact('user_fullname'), $user_fullname)
               ->with(compact('user_division_acronym'), $user_division_acronym)
               ->with(compact('clusters'), $clusters)
               ->with(compact('years'), $years)
               ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical)
               ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
                            
            // $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
            // $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('year', $year_selected)->get();
            // return view('budget_preparation.budget_proposals.division_tabs')
            //    ->with(compact('title'), $title)
            //    ->with(compact('data'),$data)
            //    ->with(compact('username'), $username)
            //    ->with(compact('user_id'), $user_id)
            //    ->with(compact('user_role'), $user_role)
            //    ->with(compact('user_role_id'), $user_role_id)
            //    ->with(compact('user_division_id'), $user_division_id)
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
         } 
      }
   }

   public function generatePDF(Request $request, $cluster_id, $year)
   {      
      if ($request->ajax()) {
         $year = $request->year;
         view()->share('year', $year);
         $pdf = App::make('dompdf.wrapper');
         $pdf->loadView('division_proposals.budget_proposals.cluster_pdf')
            ->set_paper('letter', 'portait');
         return $pdf->stream(); 
      }
      else{
            return view('budget_preparation.budget_proposals.cluster_pdf')
               ->with('cluster_id', $cluster_id)
               ->with('year', $year);
      }
   }
}
