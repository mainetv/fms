<?php

namespace App\Http\Controllers;

use App\Models\ViewAdaCheckIssuedModel;
use App\Models\ViewAdaCheckPerPayeeModel;
use App\Models\ViewAllotmentModel;
use App\Models\ViewCheckDVModel;
use App\Models\ViewDVAllDataModel;
use App\Models\ViewDVDataModel;
use App\Models\ViewDVModel;
use App\Models\ViewDVSummaryModel;
use App\Models\ViewFinancialSummary;
use App\Models\ViewLDDAPIssuedModel;
use App\Models\ViewLDDAPSummaryModel;
use App\Models\ViewRSBalanceModel;
use App\Models\viewRSwithTotalDVModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
	public function financial_summary(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
		$title = 'financialsummary'; 
		return view('reports.financial_summary')
			->with(compact('user_division_id'))
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	 public function dv_rs_particulars(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
		$title = 'dvrsparticulars'; 
		return view('reports.dv_rs_particulars')
			->with(compact('user_division_id'))
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	public function rs_by_division(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$title = 'rsbydivision'; 
		return view('reports.rs_by_division')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}	

	public function rs_per_activity(Request $request, $rstype_id_selected, $year_selected, $view_selected) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$data = ViewAllotmentModel::where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
			->where('is_active', 1)->where('is_deleted', 0)
			->orderBy('pap_code', 'ASC')->orderBy('division_acronym','ASC')->orderBy('activity','ASC')
			->orderBy('object_code','ASC')->get();
		$title = 'rsperactivity'; 
		return view('reports.rs_per_activity')
			->with('rstype_id_selected', $rstype_id_selected)
			->with('year_selected', $year_selected)
			->with('view_selected', $view_selected)
			->with(compact('data'))
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	public function rs_per_pap(Request $request, $rstype_id_selected, $start_date, $end_date) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		$title = 'rsperpap'; 
		return view('reports.rs_per_pap')
			->with('rstype_id_selected', $rstype_id_selected)
			->with('start_date', $start_date)
			->with('end_date', $end_date)
			->with(compact('user_division_id'))
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	public function rs_balance(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		$title = 'rsbalance';		
		return view('reports.rs_balance')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('user_division_id'))
			->with(compact('title'));
 	}

	 public function rs_balance_by_division(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		$title = 'rsbalancedivision';
		return view('reports.rs_balance_by_division')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('user_division_id'))
			->with(compact('title'));
 	}

	public function dv_by_division(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;		
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();			
		$title = 'dvbydivision'; 
		if($user_id==149 || $user_id==117){
         $user_division_id=3;
         $user_division_acronym='COA';
      }
		return view('reports.dv_by_division')
			->with(compact('user_role_id'))
			->with(compact('user_division_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	public function dv_per_division(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$title = 'dvperdivision'; 	
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		return view('reports.dv_per_division')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('user_division_id'))
			->with(compact('title'));
 	}

	public function received_dvs(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$title = 'receiveddvs'; 
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		return view('reports.received_dvs')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('user_division_id'))
			->with(compact('title'));
 	}

	public function dvrs_per_pap(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$title = 'dvrsperpap';
		return view('reports.dvrs_per_pap')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	public function lddap_check_per_pap(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$title = 'lddapcheckperpap'; 
		return view('reports.lddap_check_per_pap')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	public function ada_check_per_pap(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		$title = 'adacheckperpap'; 
		return view('reports.ada_check_per_pap')
			->with(compact('user_division_id'))
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	public function ada_check_issued(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		$title = 'adacheckissued'; 
		return view('reports.ada_check_issued')
			->with(compact('user_division_id'))
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}	

	public function ada_check_issued_per_payee(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$title = 'adacheckissuedperpayee'; 
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		return view('reports.ada_check_issued_per_payee')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('user_division_id'))
			->with(compact('title'));
 	}

	public function lddap_issued(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$title = 'lddapissued'; 
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		return view('reports.lddap_issued')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('user_division_id'))
			->with(compact('title'));
 	}

	public function checks_issued(Request $request) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$title = 'checksissued'; 
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		return view('reports.checks_issued')
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('user_division_id'))
			->with(compact('title'));
 	}	

	public function index_payment(Request $request, $payee_id_selected, $year_selected) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$data = ViewAdaCheckIssuedModel::where('payee_id', $payee_id_selected)->whereYear('dv_date', $year_selected)
			->where('is_active', 1)->where('is_deleted',0)->get();
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		$title = 'indexpayment'; 
		return view('reports.index_payment')
			->with('payee_id_selected', $payee_id_selected)
			->with('year_selected', $year_selected)
			->with(compact('user_role_id'))
			->with(compact('user_division_id'))
			->with(compact('user_id'))
			->with(compact('data'))
			->with(compact('title'));
 	}	

	public function saob(Request $request, $rstype_id_selected, $division_id, $year_selected, $view_selected) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();		
		if($user_role_id==3){
			$title = 'saob';
		}
		else{
			$title = 'saobdivision';			
		} 
		if($user_id==149 || $user_id==117){
         $user_division_id=3;
         $user_division_acronym='COA';
      }
		if($user_id=='20' || $user_id=='14'){
			$user_division_id = '9';
			$user_division_acronym='FAD-DO';
		}
		return view('reports.saob.saob')
			->with('rstype_id_selected', $rstype_id_selected)
			->with('division_id', $division_id)
			->with('year_selected', $year_selected)
			->with('view_selected', $view_selected)
			->with(compact('user_role_id'))
			->with(compact('user_division_id'))
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	 public function saob_summary(Request $request, $rstype_id_selected, $year_selected) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;	
		$title = 'saobsummary';	
		return view('reports.saob_summary')
			->with('rstype_id_selected', $rstype_id_selected)
			->with('year_selected', $year_selected)
			->with(compact('user_id'))
			->with(compact('title'));
 	}

	public function allotment_summary_per_division_per_object_code(Request $request, $rstype_id_selected, $year_selected) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$data = ViewAllotmentModel::where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
			->where('is_active', 1)->where('is_deleted', 0)
			->orderBy('pap_code', 'ASC')->orderBy('division_acronym','ASC')->orderBy('activity','ASC')
			->orderBy('object_code','ASC')->get();
		$title = 'allotmentsummaryperdivperobj'; 
		return view('reports.allotment_summary_per_division_per_object_code')
			->with('rstype_id_selected', $rstype_id_selected)
			->with('year_selected', $year_selected)
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('data'))
			->with(compact('title'));
 	}

	public function dv_summary(Request $request, $fund_id_selected, $year_selected) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$data = ViewDVSummaryModel::whereYear('dv_date',$year_selected)
			->where('is_active', 1)->where('is_deleted', 0)
			->orderBy('dv_date', 'ASC')->orderBy('payee','ASC')->get();
		$title = 'dvsummary'; 
		return view('reports.dv_summary')
			->with('fund_id_selected', $fund_id_selected)
			->with('year_selected', $year_selected)
			->with(compact('user_role_id'))
			->with(compact('user_id'))
			->with(compact('data'))
			->with(compact('title'));
 	}
	
	public function monthly_wtax(Request $request, $month_selected, $year_selected) {
		$user_id = auth()->user()->id;
		$title = 'monthlywtax'; 
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
		return view('reports.monthly_wtax')
			->with('month_selected', $month_selected)
			->with('year_selected', $year_selected)
			->with(compact('title'))
			->with(compact('user_id'))
			->with(compact('user_division_id'));
 	}

	public function monthly_wtax_by_payee(Request $request, $month_selected, $year_selected) {
		$user_id = auth()->user()->id;
		$title = 'monthlywtaxbypayee'; 
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
		return view('reports.monthly_wtax_by_payee')
			->with('month_selected', $month_selected)
			->with('year_selected', $year_selected)
			->with(compact('user_id'))
			->with(compact('title'))
			->with(compact('user_division_id'));
 	}

	public function lddap_summary(Request $request, $fund_id_selected, $start_date, $end_date) {
		$user_id = auth()->user()->id; 
		$user_role_id = auth()->user()->user_role_id;
		$data = ViewLDDAPSummaryModel::where('lddap_check_date','>=',$start_date)->where('lddap_check_date','<=', $end_date)
			->where('fund_id', $fund_id_selected)->where('is_active', 1)->where('is_deleted', 0)
			->orderBy('lddap_check_date', 'ASC')->orderBy('nca_no','ASC')->orderBy('payee','ASC')->get();	
		// $data = DB::table("view_lddap_summary")->select('view_lddap_summary.*', 'view_dv_rs_net.*')
		// 	->leftJoin('view_dv_rs_net','view_lddap_summary.dv_id','=','view_dv_rs_net.dv_id')
		// 	->where("view_lddap_summary.lddap_check_date",$start_date)
		// 	->where("view_lddap_summary.lddap_check_date", $end_date)
		// 	->where("view_lddap_summary.is_active", 1)
		// 	->where("view_lddap_summary.is_deleted", 0)
		// 	->where("view_lddap_summary.fund_id", $fund_id_selected)
		// 	->where("view_dv_rs_net.is_active", 1)
		// 	->where("view_dv_rs_net.is_deleted", 0)
		// 	->orderBy('view_lddap_summary.lddap_check_date', 'ASC')->orderBy('view_lddap_summary.nca_no','ASC')->orderBy('view_lddap_summary.payee','ASC')
		// 	->get();
		// dd($data);
		$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();	
		$title = 'lddapsummary'; 
		return view('reports.lddap_summary')
			->with('fund_id_selected', $fund_id_selected)
			->with('start_date', $start_date)
			->with('end_date', $end_date)
			->with(compact('user_role_id'))
			->with(compact('user_division_id'))
			->with(compact('user_id'))
			->with(compact('data'))
			->with(compact('title'));
 	}	
	
	public function show_rs_per_division(Request $request) {
      $rstype_id_selected=$request->rstype_id_selected;
      $start_date=$request->start_date;
      $end_date=$request->end_date;
      $division_id=$request->division_id;
		if($rstype_id_selected=='All'){
			$data = viewRSwithTotalDVModel::whereBetween('rs_date',[$start_date,$end_date])
				->where('division_id', $division_id)->whereNotNull('rs_no')
				->where('is_active', 1)->where('is_deleted', 0)->orderBy('rs_date', 'DESC')->get();
		}
		else{
			$data = viewRSwithTotalDVModel::whereBetween('rs_date',[$start_date,$end_date])
				->where('rs_type_id', $rstype_id_selected)
				->where('division_id', $division_id)->whereNotNull('rs_no')
				->where('is_active', 1)->where('is_deleted', 0)->orderBy('rs_date', 'DESC')->get();
		}
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);
      
   }

	public function show_rs_balance(Request $request) {
		// dd($request->all());
		$rstype_id_selected=$request->rstype_id_selected;
      $filter=$request->filter;
      $start_date=$request->start_date;
      $end_date=$request->end_date;
		if($rstype_id_selected=='All'){
			if($filter=='All'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();		
			}
			else if($filter=='NoDV'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('gross_amount','<=',0)->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
			else if($filter=='wDV'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('gross_amount', '>', 0)->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
			else if($filter=='NoPayment'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
				->whereNull('lddap_check_no')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
		}
		else{
			if($filter=='All'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_type_id', $rstype_id_selected)
					->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();		
			}
			else if($filter=='NoDV'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_type_id', $rstype_id_selected)
					->where('gross_amount','<=',0)->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
			else if($filter=='wDV'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_type_id', $rstype_id_selected)
					->where('gross_amount', '>', 0)->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
			else if($filter=='NoPayment'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
				->where('rs_type_id', $rstype_id_selected)
				->whereNull('lddap_check_no')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
		}
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);      
   }
	
	public function show_rs_balance_by_division(Request $request) {
		// dd($request->all());
		$user_id = Auth::user()->id; 
		$rstype_id_selected=$request->rstype_id_selected;
		$division_id=$request->division_id;
      $filter=$request->filter;
      $start_date=$request->start_date;
      $end_date=$request->end_date;
		if($user_id==149 || $user_id==117){
         $division_id=3;
      }
		if($rstype_id_selected=='All'){
			if($filter=='All'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_division_id', $division_id)->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();		
			}
			else if($filter=='NoDV'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_division_id', $division_id)->where('gross_amount','<=',0)->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
			else if($filter=='wDV'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_division_id', $division_id)->where('gross_amount', '>', 0)->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
			else if($filter=='NoPayment'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_division_id', $division_id)->whereNull('lddap_check_no')->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
		}
		else{
			if($filter=='All'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_division_id', $division_id)->where('rs_type_id', $rstype_id_selected)
					->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();		
			}
			else if($filter=='NoDV'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_division_id', $division_id)->where('rs_type_id', $rstype_id_selected)
					->where('gross_amount','<=',0)->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
			else if($filter=='wDV'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_division_id', $division_id)->where('rs_type_id', $rstype_id_selected)
					->where('gross_amount', '>', 0)->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
			else if($filter=='NoPayment'){
				$data = ViewRSBalanceModel::where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
					->where('rs_division_id', $division_id)->where('rs_type_id', $rstype_id_selected)
					->whereNull('lddap_check_no')->where('is_active', 1)->where('is_deleted', 0)
					->orderBy('allotment_division_acronym', 'ASC')->orderBy('payee', 'ASC')->get();	
			}
		}
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);      
   }	

	public function show_rs_per_activity(Request $request) {
		// dd($request->all());
      $rstype_id_selected=$request->rstype_id_selected;
      $year_selected=$request->year_selected;
		$data = ViewAllotmentModel::where('rs_type_id', $rstype_id_selected)->where('year', $year_selected)		
			->where('is_active', 1)->where('is_deleted', 0)			
			->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id', 'ASC')->orderBy('object_code', 'ASC')->orderBy('division_acronym', 'ASC')->get();	
			return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);      
   }

	public function show_dv_by_fund_division_daterange(Request $request) {
      $fund_id_selected=$request->fund_id_selected;
      $start_date=$request->start_date;
      $end_date=$request->end_date;
      $division_id=$request->division_id;
		if($fund_id_selected=='All'){
			$data = ViewDVModel::whereBetween('dv_date',[$start_date,$end_date])
				->where('division_id', $division_id)->whereNotNull('dv_no')
				->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_date', 'DESC')->get();
		}
		else{
			$data = ViewDVModel::whereBetween('dv_date',[$start_date,$end_date])
				->where('fund_id', $fund_id_selected)
				->where('division_id', $division_id)->whereNotNull('dv_no')
				->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_date', 'DESC')->get();
		}
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);      
   }

	public function show_dvs(Request $request) {
      $start_date=$request->start_date;
      $end_date=$request->end_date;
		$data = ViewDVAllDataModel::where('dv_date','>=',$start_date)->where('dv_date','<=', $end_date)
			->whereNotNull('dv_no')->where('is_active', 1)->where('is_deleted', 0)
			->orderBy('dv_no', 'DESC')->get();
		
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($dv) {
            return $dv->id;
            }
         ])
         ->make(true);      
   }

	public function show_financial_summary(Request $request) {
		function getFullSql($query)
		{
			$sql = $query->toSql();
			foreach ($query->getBindings() as $binding) {
				if (is_numeric($binding)) {
					$value = $binding;
				} elseif (is_null($binding)) {
					$value = 'NULL';
				} else {
					$value = "'" . str_replace("'", "''", $binding) . "'";
				}
				$sql = preg_replace('/\?/', $value, $sql, 1);
			}
			return $sql;
		}

		$fund_id_selected=$request->fund_id_selected;
      $start_date=$request->start_date;
      $end_date=$request->end_date;		
      $filter=$request->view_filter;		
      $date_range_filter=$request->date_range_filter;	
		$date_column = ($date_range_filter == 'rs') ? 'rs_date' : 'lddap_check_date';	
		$query = ViewFinancialSummary::where($date_column, '>=', $start_date)->where($date_column, '<=', $end_date);

		if ($fund_id_selected !== 'All') {
			$query->where('rs_type_id', $fund_id_selected);
	  	}
		switch ($filter) {
			case 'NoDV':
				$query->whereNull('dv_no');
				break;
		
			case 'wDVwLDDAPorCheck':
				$query->where(function ($q) {
					$q->whereNotNull('dv_no')
					->where('dv_no', '!=', '')
					->where('dv_no', '!=', ' '); // Ensure it's not blank
			
					$q->whereNotNull('lddap_check_no')
					->where('lddap_check_no', '!=', '')
					->where('lddap_check_no', '!=', ' '); // Ensure it's not blank
			});
				break;
		
			case 'wDVNoLDDAPorCheck':
				$query->where(function ($q) {
					$q->whereNotNull('dv_no')->where('dv_no', '!=', '');
				})
				->where(function ($q) {
					$q->whereNull('lddap_check_no')->orWhere('lddap_check_no', '');
				});
				break;
		}
	  
	  // Finalize query with grouping and ordering
	  $data = $query->groupBy('dv_id')
						 ->orderBy('dv_id', 'ASC')
						 ->orderBy('objcode', 'ASC')
						 ->orderBy('payee', 'ASC')
						 ->get();
		// dd([
		// 	'raw_sql' => getFullSql($query),
		// 	'sql_with_placeholders' => $query->toSql(),
		// 	'bindings' => $query->getBindings(),
		// 	'input_variables' => [
		// 		'fund_id_selected' => $fund_id_selected,
		// 		'start_date' => $start_date,
		// 		'end_date' => $end_date,
		// 		'filter' => $filter,
		// 		'date_range_filter' => $date_range_filter,
		// 		'date_column' => $date_column,
		// 	],
		// ]);
		// if($fund_id_selected=='All'){
		// 	if($filter=='All'){	
		// 		$data = ViewFinancialSummary::where($date_column, '>=', $start_date)->where($date_column, '<=', $end_date)
		// 			->groupBy('rs_id')->orderBy($date_column, 'ASC')->orderBy('objcode', 'ASC')->orderBy('payee', 'ASC')>get();	
		// 	}
		// 	else if($filter=='NoDV'){
		// 		$data = ViewFinancialSummary::where($date_column, '>=', $start_date)->where($date_column, '<=', $end_date)->whereNull('dv_no')
		// 			->groupBy('rs_id')->orderBy($date_column, 'ASC')->orderBy('objcode', 'ASC')->orderBy('payee', 'ASC')>get();			
		// 	}
		// 	else if($filter=='wDV'){	
		// 		$data = ViewFinancialSummary::where($date_column, '>=', $start_date)->where($date_column, '<=', $end_date)
		// 			->where(function($query) {
		// 				$query->where(function($q) {
		// 					$q->whereNotNull('dv_no')
		// 					->where('dv_no', '!=', '');
		// 				})
		// 				->orWhere(function($q) {
		// 					$q->whereNotNull('lddap_no')
		// 					->where('lddap_no', '!=', '');
		// 				});
		// 			})
		// 			->groupBy('rs_id')->orderBy($date_column, 'ASC')
		// 			->orderBy('objcode', 'ASC')->orderBy('payee', 'ASC')->get();
		// 	}
		// 	else if($filter=='NoPayment'){
		// 		$data = ViewFinancialSummary::where($date_column, '>=', $start_date)->where($date_column, '<=', $end_date)
					// ->where(function($query) {
					// 	$query->whereNotNull('dv_no')
					// 			->where('dv_no', '!=', '');
					// })
					// ->where(function($query) {
					// 		$query->whereNull('lddap_no')
					// 				->orWhere('lddap_no', '=', '');
					// })
		// 			->groupBy('rs_id')->orderBy('rs_date', 'ASC')->orderBy('objcode', 'ASC')->orderBy('payee', 'ASC')->get();		
		// 	}			
		// }
		// elseif($fund_id_selected!='All'){
		// 	if($filter=='All'){
		// 		$data = ViewFinancialSummary::where($date_column, '>=', $start_date)->where($date_column, '<=', $end_date)
		// 			->where('rs_type_id', $fund_id_selected)
		// 			->groupBy('rs_id')->orderBy('rs_date', 'ASC')->orderBy('objcode', 'ASC')->orderBy('payee', 'ASC')->get();	
		// 	}
		// 	else if($filter=='NoDV'){
		// 		$data = ViewFinancialSummary::where($date_column, '>=', $start_date)->where($date_column, '<=', $end_date)
		// 			->where('rs_type_id', $fund_id_selected)->whereNull('dv_no')
		// 			->groupBy('rs_id')->orderBy('rs_date', 'ASC')->orderBy('objcode', 'ASC')->orderBy('payee', 'ASC')->get();			
		// 	}
		// 	else if($filter=='wDV'){
		// 		$data = ViewFinancialSummary::where($date_column, '>=', $start_date)->where($date_column, '<=', $end_date)
		// 			->where('rs_type_id', $fund_id_selected)
		// 			->where(function($query) {
		// 				$query->whereNotNull('dv_no')
		// 						->where('dv_no', '!=', '');
		// 		  })
		// 		  ->where(function($query) {
		// 				$query->whereNotNull('lddap_no')
		// 						->where('lddap_no', '!=', '');
		// 		  })
		// 			->groupBy('rs_id')->orderBy('rs_date', 'ASC')->orderBy('objcode', 'ASC')->orderBy('payee', 'ASC')->get();		
		// 	}
		// 	else if($filter=='NoPayment'){
		// 		$data = ViewFinancialSummary::where($date_column, '>=', $start_date)->where($date_column, '<=', $end_date)
		// 			->where('rs_type_id', $fund_id_selected)
		// 			->where(function($query) {
		// 				$query->whereNotNull('dv_no')
		// 						->where('dv_no', '!=', '');
		// 			})
		// 			->where(function($query) {
		// 					$query->whereNull('lddap_no')
		// 							->orWhere('lddap_no', '=', '');
		// 			})
		// 			->groupBy('rs_id')->orderBy('rs_date', 'ASC')->orderBy('objcode', 'ASC')->orderBy('payee', 'ASC')->get();		
		// 	}				
		// }		
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);
      
   }

	public function show_ada_check(Request $request) {
		$payment_mode_selected=$request->payment_mode_selected;
		$fund_id_selected=$request->fund_id_selected;
      $start_date=$request->start_date;
      $end_date=$request->end_date;		
		if($fund_id_selected=='All' && $payment_mode_selected=='All'){
			$data = ViewAdaCheckIssuedModel::where('lddap_check_date','>=',$start_date)->where('lddap_check_date','<=', $end_date)
				->whereNotNull('lddap_check_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('lddap_check_date', 'ASC')->orderBy('expense_account_object_code', 'ASC')->orderBy('payee', 'ASC')->get();	
		}
		elseif($fund_id_selected!='All' && $payment_mode_selected=='All'){
			$data = ViewAdaCheckIssuedModel::where('lddap_check_date','>=',$start_date)->where('lddap_check_date','<=', $end_date)
				->where('fund_id', $fund_id_selected)
				->whereNotNull('lddap_check_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('lddap_check_date', 'ASC')->orderBy('expense_account_object_code', 'ASC')->orderBy('payee', 'ASC')->get();	
		}
		elseif($fund_id_selected=='All' && $payment_mode_selected!='All'){
			$data = ViewAdaCheckIssuedModel::where('lddap_check_date','>=',$start_date)->where('lddap_check_date','<=', $end_date)
				->where('payment_mode_id', $payment_mode_selected)
				->whereNotNull('lddap_check_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('lddap_check_date', 'ASC')->orderBy('expense_account_object_code', 'ASC')->orderBy('payee', 'ASC')->get();	
		}
		elseif($fund_id_selected!='All' && $payment_mode_selected!='All'){
			$data = ViewAdaCheckIssuedModel::where('lddap_check_date','>=',$start_date)->where('lddap_check_date','<=', $end_date)
				->where('fund_id', $fund_id_selected)->where('payment_mode_id', $payment_mode_selected)
				->whereNotNull('lddap_check_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('lddap_check_date', 'ASC')->orderBy('expense_account_object_code', 'ASC')->orderBy('payee', 'ASC')->get();	
		}		
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);
      
   }

	public function show_dvs_by_division(Request $request) {		
		$fund_id_selected=$request->fund_id_selected;
      $start_date=$request->start_date;
      $end_date=$request->end_date;		
      $division_id=$request->division_id;		
		if($fund_id_selected=='All'){
			$data = ViewDVDataModel::where('dv_date','>=',$start_date)->where('dv_date','<=', $end_date)
				->where('dv_division_id', $division_id)->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('dv_date', 'ASC')->orderBy('payee', 'ASC')->get();	
		}
		elseif($fund_id_selected!='All'){
			$data = ViewDVDataModel::where('dv_date','>=',$start_date)->where('dv_date','<=', $end_date)
				->where('dv_division_id', $division_id)->where('fund_id', $fund_id_selected)->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('dv_date', 'ASC')->orderBy('payee', 'ASC')->get();	
		}
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);
      
   }

	public function show_ada_check_per_payee(Request $request) {
		// dd($request->all());		
		$payment_mode_selected=$request->payment_mode_selected;
		$fund_id_selected=$request->fund_id_selected;
      $start_date=$request->start_date;
      $end_date=$request->end_date;
		if($fund_id_selected=='All' && $payment_mode_selected=='All'){
			$data = DB::table('view_ada_check_issued')->select(DB::raw("payee, dv_division_acronym, SUM(tax_one) as tax_one,
				SUM(tax_two) as tax_two,SUM(tax_twob) as tax_twob,SUM(tax_three) as tax_three,SUM(tax_five) as tax_five,
				SUM(tax_six) as tax_six,SUM(wtax) as wtax,SUM(liquidated_damages) as liquidated_damages,SUM(other_deductions) as other_deductions,
				SUM(total_dv_gross_amount) AS total_dv_gross_amount, SUM(total_dv_net_amount) AS total_dv_net_amount"))
				->where('lddap_check_date','>=',$start_date)->where('lddap_check_date','<=', $end_date)
				->whereNotNull('lddap_check_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('lddap_check_date', 'ASC')->orderBy('payee', 'ASC')->groupBy('payee_id')->get();	

		}
		elseif($fund_id_selected!='All' && $payment_mode_selected=='All'){
			$data = DB::table('view_ada_check_issued')->select(DB::raw("payee, dv_division_acronym, SUM(tax_one) as tax_one,
				SUM(tax_two) as tax_two,SUM(tax_twob) as tax_twob,SUM(tax_three) as tax_three,SUM(tax_five) as tax_five,
				SUM(tax_six) as tax_six,SUM(wtax) as wtax,SUM(liquidated_damages) as liquidated_damages,SUM(other_deductions) as other_deductions,
				SUM(total_dv_gross_amount) AS total_dv_gross_amount, SUM(total_dv_net_amount) AS total_dv_net_amount"))
				->where('lddap_check_date','>=',$start_date)->where('lddap_check_date','<=', $end_date)
				->where('fund_id', $fund_id_selected)
				->whereNotNull('lddap_check_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('lddap_check_date', 'ASC')->orderBy('payee', 'ASC')->groupBy('payee_id')->get();	
		}
		elseif($fund_id_selected=='All' && $payment_mode_selected!='All'){
			$data = DB::table('view_ada_check_issued')->select(DB::raw("payee, dv_division_acronym, SUM(tax_one) as tax_one,
				SUM(tax_two) as tax_two,SUM(tax_twob) as tax_twob,SUM(tax_three) as tax_three,SUM(tax_five) as tax_five,
				SUM(tax_six) as tax_six,SUM(wtax) as wtax,SUM(liquidated_damages) as liquidated_damages,SUM(other_deductions) as other_deductions,
				SUM(total_dv_gross_amount) AS total_dv_gross_amount, SUM(total_dv_net_amount) AS total_dv_net_amount"))
				->where('lddap_check_date','>=',$start_date)->where('lddap_check_date','<=', $end_date)
				->where('payment_mode_id', $payment_mode_selected)
				->whereNotNull('lddap_check_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('lddap_check_date', 'ASC')->orderBy('payee', 'ASC')->groupBy('payee_id')->get();	
		}
		elseif($fund_id_selected!='All' && $payment_mode_selected!='All'){
			$data = DB::table('view_ada_check_issued')->select(DB::raw("payee, dv_division_acronym, SUM(tax_one) as tax_one,
				SUM(tax_two) as tax_two,SUM(tax_twob) as tax_twob,SUM(tax_three) as tax_three,SUM(tax_five) as tax_five,
				SUM(tax_six) as tax_six,SUM(wtax) as wtax,SUM(liquidated_damages) as liquidated_damages,SUM(other_deductions) as other_deductions,
				SUM(total_dv_gross_amount) AS total_dv_gross_amount, SUM(total_dv_net_amount) AS total_dv_net_amount"))
				->where('lddap_check_date','>=',$start_date)->where('lddap_check_date','<=', $end_date)
				->where('fund_id', $fund_id_selected)->where('payment_mode_id', $payment_mode_selected)
				->whereNotNull('lddap_check_date')->where('is_active', 1)->where('is_deleted', 0)
				->groupBy('payee_id')->get();	
		}	
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($ada) {
            return $ada->payee;
            }
         ])
         ->make(true);
      
   }

	public function show_checks(Request $request) {
		$fund_id_selected=$request->fund_id_selected;
      $start_date=$request->start_date;
      $end_date=$request->end_date;
		if($fund_id_selected=='All'){
			$data = ViewCheckDVModel::where('check_date','>=',$start_date)->where('check_date','<=', $end_date)
				->whereNotNull('check_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('check_date', 'ASC')->orderBy('payee', 'ASC')->get();	
		}
		else{
			$data = ViewCheckDVModel::where('check_date','>=',$start_date)->where('check_date','<=', $end_date)
				->where('fund_id', $fund_id_selected)
				->whereNotNull('check_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('check_date', 'ASC')->orderBy('payee', 'ASC')->get();	
		}				
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);
      
   }

	public function show_lddaps(Request $request) {
		$fund_id_selected=$request->fund_id_selected;
      $start_date=$request->start_date;
      $end_date=$request->end_date;
		if($fund_id_selected=='All'){
			$data = ViewLDDAPIssuedModel::where('lddap_date','>=',$start_date)->where('lddap_date','<=', $end_date)
				->whereNotNull('lddap_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('lddap_date', 'ASC')->orderBy('payee', 'ASC')->get();	
		}
		else{
			$data = ViewLDDAPIssuedModel::where('lddap_date','>=',$start_date)->where('lddap_date','<=', $end_date)
				->where('fund_id', $fund_id_selected)
				->whereNotNull('lddap_date')->where('is_active', 1)->where('is_deleted', 0)
				->orderBy('lddap_date', 'ASC')->orderBy('payee', 'ASC')->get();	
		}				
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);
      
   }

	public function show_monthly_wtax(Request $request) {
		// dd($request->all());
      $rstype_id_selected=$request->rstype_id_selected;
      $year_selected=$request->year_selected;
		$data = ViewAllotmentModel::where('rs_type_id', $rstype_id_selected)->where('year', $year_selected)		
			->where('is_active', 1)->where('is_deleted', 0)			
			->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id', 'ASC')->orderBy('object_code', 'ASC')->orderBy('division_acronym', 'ASC')->get();	
			return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->make(true);      
   }
	
	public function print_rs_per_pap(Request $request, $rs_type_id, $start_date, $end_date) {
      return \View::make('reports.print_rs_per_pap')
         ->with('rs_type_id', $rs_type_id)
         ->with('start_date', $start_date)
         ->with('end_date', $end_date);
   }

public function print_saob(Request $request, $rstype_id_selected, $division_id, $year_selected, $view_selected) {
      return \View::make('reports.saob.print_saob')
         ->with('rstype_id_selected', $rstype_id_selected)
         ->with('division_id', $division_id)
         ->with('year_selected', $year_selected)
         ->with('view_selected', $view_selected);
   }
}
