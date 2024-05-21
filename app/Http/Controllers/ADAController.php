<?php

namespace App\Http\Controllers;

use App\Models\ADALDDAPModel;
use App\Models\ADAModel;
use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\FundsModel;
use App\Models\LDDAPModel;
use App\Models\LibraryReportsSignatoryModel;
use App\Models\PaymentModesModel;
use App\Models\ViewADAModel;
use App\Models\LibraryBankAccountsModel;
use App\Models\ViewADALDDAPModel;
use App\Models\ViewDVModel;
use App\Models\ViewLDDAPaClassModel;
use App\Models\ViewLDDAPModel;
use App\Models\ViewLibrarySignatoriesModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;
use Validator;
use Response;

class ADAController extends Controller
{
   public function index(Request $request, $fund_selected, $month_selected, $year_selected){     
      $user_role_id = auth()->user()->user_role_id; 
      $username = auth()->user()->username; 
      $user_id = auth()->user()->id;       
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();   
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();   
      $data = [
         "fund_selected" => $fund_selected,
         "month_selected" => $month_selected,
         "year_selected" => $year_selected,
      ];  
      $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
      $years = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'ASC')->get();
      $getFunds = FundsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fund')->get();
      $getSignatories = ViewLibrarySignatoriesModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fullname_first')->get();		
      
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {    
         $title = "Advice to Debit Accounts (ADA)"; 
         return view('funds_utilization.ada.all')
            ->with(compact('title'), $title)
            ->with(compact('data'),$data)
            ->with(compact('username'), $username)
            ->with(compact('user_id'), $user_id)
            ->with(compact('user_role'), $user_role)
            ->with(compact('user_role_id'), $user_role_id)
            ->with(compact('user_division_id'), $user_division_id)
            ->with(compact('user_division_acronym'), $user_division_acronym)
            ->with(compact('user_fullname'), $user_fullname)
            ->with(compact('divisions'), $divisions)
            ->with(compact('getFunds'), $getFunds)
            ->with(compact('getSignatories'), $getSignatories)
            ->with(compact('years'), $years);  
      }
   }

   public function add(Request $request){          
      $user_id = auth()->user()->id;       
      $user_role_id = auth()->user()->user_role_id; 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $getFunds = FundsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fund')->get();           
      $getBankAccounts = LibraryBankAccountsModel::where("is_active", 1)->where("is_deleted", 0)->get();      
      $getLDDAPSignatories = ViewLibrarySignatoriesModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fullname_first')->get();
      $getPaymentModes = PaymentModesModel::where("is_active", 1)->where("is_deleted", 0)->get();
      
      $title = "Add ADA";
      return view('funds_utilization.ada.add')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('user_division_id'))
         ->with(compact('title'))
         ->with(compact('getLDDAPSignatories'))
         ->with(compact('getPaymentModes'))
         ->with(compact('getFunds'))
         ->with(compact('getBankAccounts'));
   }
   
   public function edit(Request $request){        
      $user_id = auth()->user()->id;       
      $user_role_id = auth()->user()->user_role_id; 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $ada_id=$request->id;
      $getADADetails =  ViewADAModel::where('id', $ada_id)->where('is_active', 1)->where('is_deleted', 0)->get();		
      $getFunds = FundsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fund')->get();      
      $getBankAccounts = LibraryBankAccountsModel::where("is_active", 1)->where("is_deleted", 0)->get();      
      $getADASignatories = ViewLibrarySignatoriesModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fullname_first')->get();
      $getAttachedLDDAPbyADA = ViewADALDDAPModel::where('ada_id', $ada_id)->where("is_active", 1)->where("is_deleted", 0)->get();
      $title = "Edit ADA";
      return view('funds_utilization.ada.edit')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('user_division_id'))
         ->with(compact('title'))
         ->with(compact('getADADetails'))
         ->with(compact('getADASignatories'))
         ->with(compact('getFunds'))
         ->with(compact('getAttachedLDDAPbyADA'))
         ->with(compact('getBankAccounts'));     
   }

   public function store(Request $request){
      if ($request->ajax()) { 
         // dd($request->all());
         $report_id=$request->report_id;
         $get_signatory1 = LibraryReportsSignatoryModel::where('report_id', $report_id)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('signatory1')->first();   
         $get_signatory1_position = LibraryReportsSignatoryModel::where('report_id', $report_id)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('signatory1_position')->first();
         $get_signatory2=$request->signatory2;
         // $get_signatory2 = LibraryReportsSignatoryModel::where('report_id', $report_id)
         //    ->where("is_active", 1)->where("is_deleted", 0)->pluck('signatory2')->first();   
         $get_signatory2_position = ViewLibrarySignatoriesModel::where('fullname_first', $get_signatory2)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();
         $get_signatory3 = LibraryReportsSignatoryModel::where('report_id', $report_id)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('signatory3')->first();   
         $get_signatory3_position = LibraryReportsSignatoryModel::where('report_id', $report_id)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('signatory3_position')->first();
         $get_signatory4 = LibraryReportsSignatoryModel::where('report_id', $report_id)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('signatory4')->first();   
         $get_signatory4_position = LibraryReportsSignatoryModel::where('report_id', $report_id)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('signatory4_position')->first();
         $get_signatory5 = LibraryReportsSignatoryModel::where('report_id', $report_id)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('signatory1')->first();   
         $get_signatory5_position = LibraryReportsSignatoryModel::where('report_id', $report_id)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('signatory5_position')->first();
         if($request->add_ada==1){
            $message = array(    
               'ada_no.required' => 'Please generate/input sliiae no.',
               'ada_date.required' => 'Please select ada date.',
               'fund_id.required' => 'Please select fund.',
               'bank_account_id.required' => 'Please select bank account no.',
            );
            $validator =  Validator::make($request->all(), [
               'ada_no' => 'required',
               'ada_date' => 'required',
               'fund_id' => 'required',
               'bank_account_id' => 'required',
            ], $message);
      
            if ($validator->passes()) {
               $data = new ADAModel([
                  'ada_date' => $request->ada_date,
                  'ada_no' => $request->ada_no,
                  'fund_id' => $request->fund_id,
                  'bank_account_id' => $request->bank_account_id,
                  'check_no' => $request->check_no,
                  'date_transferred' => $request->date_transferred,
                  'signatory1' => $get_signatory1,
                  'signatory1_position' => $get_signatory1_position,
                  'signatory2' => $get_signatory2,
                  'signatory2_position' => $get_signatory2_position,
                  'signatory3' => $get_signatory3,
                  'signatory3_position' => $get_signatory3_position,
                  'signatory4' => $get_signatory4,
                  'signatory4_position' => $get_signatory4_position,   
                  'signatory5' => $get_signatory5,
                  'signatory5_position' => $get_signatory5_position,         
               ]);
               $data->save(); 
               $data->id;    
               return response()->json(array('success' => 1,'redirect_url' => route('ada.edit', [$data->id]),), 200); 
            }
            return Response::json(['errors' => $validator->errors()]);   
         }         
      }
   }

   public function show(Request $request){
      $data = ViewDVModel::find($request->id); 
      // dd($data);     
      if($data->count()) {
         return Response::json([
         'status' => '1',
         'dv' => $data               
         ]);
      } 
      else {
         return Response::json([
         'status' => '0'
         ]);
      } 
   }

   public function update(Request $request){
      if($request->ajax()) {    
         // dd($request->all()); 
         $lddap_id = $request->lddap_id;        
         $ada_id = $request->ada_id;   
         $signatory2 = $request->signatory2;   
         $signatory2_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory2)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();
         // dd($signatory2_position);
         $total_ada_amount=removeComma($request->total_ada_amount);  
         if($request->edit_ada==1){  
            $message = array(    
               'ada_date.required' => 'Please select lddap date.',
               'fund_id.required' => 'Please select fund.',
               'bank_account_id.required' => 'Please select bank account no.',
            );
            $validator =  Validator::make($request->all(), [
               'ada_date' => 'required',
               'fund_id' => 'required',
               'bank_account_id' => 'required',
            ], $message);
                  
            if ($validator->passes()) {
               ADAModel::find($ada_id)
                  ->update([     
                     'ada_date' => $request->ada_date,
                     'ada_no' => $request->ada_no,
                     'fund_id' => $request->fund_id,
                     'nca_no' => $request->nca_no,
                     'bank_account_id' => $request->bank_account_id,
                     'check_no' => $request->check_no,
                     'acic_no' => $request->acic_no,
                     'total_ada_amount' => $total_ada_amount,                                    
                     'date_transferred' => $request->date_transferred,                                    
                     'signatory2' => $signatory2,                                    
                     'signatory2_position' => $signatory2_position,                                    
                  ]);                      
               return response()->json(array('success' => 1, 200)); 
            }             
            return Response::json(['errors' => $validator->errors()]);
         }
         else if($request->attach_update_lddap==1){ 
            // dd($request->all());
            if(isset($lddap_id)){  
               LDDAPModel::find($lddap_id)
                  ->update([ 
                     'ada_id'=>$ada_id,
                  ]); 

               $ps_amount=ViewLDDAPaClassModel::where('lddap_id', $lddap_id)->sum('ps_amount');
               $mooe_amount=ViewLDDAPaClassModel::where('lddap_id', $lddap_id)->sum('mooe_amount');
               $co_amount=ViewLDDAPaClassModel::where('lddap_id', $lddap_id)->sum('co_amount');

               // $ps_amount = DB::table('view_dvs')
               //    ->select(DB::raw("
               //    (SELECT SUM(total_dv_net_amount) FROM dv_rs_net LEFT JOIN disbursement_vouchers ON dv_rs_net .dv_id=disbursement_vouchers.id
               //    LEFT JOIN view_rs_pap_total ON dv_rs_net .rs_id=view_rs_pap_total.rs_id 
               //    WHERE disbursement_vouchers.lddap_id=$lddap_id and dv_rs_net.is_active=1 and dv_rs_net.is_deleted=0
               //       and view_rs_pap_total.allotment_class_id=1) as ps_amount"))
               //    ->where('view_lddap.id', $lddap_id)->pluck('ps_amount')->first();
               // $mooe_amount = DB::table('view_lddap')
               //    ->select(DB::raw(" 
               //    (SELECT SUM(total_dv_net_amount) FROM dv_rs_net LEFT JOIN disbursement_vouchers ON dv_rs_net .dv_id=disbursement_vouchers.id
               //    LEFT JOIN view_rs_pap_total ON dv_rs_net .rs_id=view_rs_pap_total.rs_id 
               //    WHERE disbursement_vouchers.lddap_id=$lddap_id and dv_rs_net.is_active=1 and dv_rs_net.is_deleted=0
               //       and view_rs_pap_total.allotment_class_id=2) as mooe_amount"))
               //    ->where('view_lddap.id', $lddap_id)->pluck('mooe_amount')->first();
               // $co_amount = DB::table('view_lddap')
               //    ->select(DB::raw("
               //    (SELECT SUM(total_dv_net_amount) FROM dv_rs_net LEFT JOIN disbursement_vouchers ON dv_rs_net .dv_id=disbursement_vouchers.id
               //    LEFT JOIN view_rs_pap_total ON dv_rs_net .rs_id=view_rs_pap_total.rs_id 
               //    WHERE disbursement_vouchers.lddap_id=$lddap_id and dv_rs_net.is_active=1 and dv_rs_net.is_deleted=0
               //       and view_rs_pap_total.allotment_class_id=3) as co_amount"))
               //    ->where('view_lddap.id', $lddap_id)->pluck('co_amount')->first();                  
               // dd($ps_amount);
               // dd($mooe_amount);
               // dd($co_amount);
               $data = new ADALDDAPModel([
                  'ada_id' => $ada_id,
                  'lddap_id' => $lddap_id,
                  'ps_amount' => $ps_amount ?? 0,
                  'mooe_amount' => $mooe_amount ?? 0,
                  'co_amount' => $co_amount ?? 0,                      
               ]);
               // dd($data);
               $data->save(); 

               $total_ps_amount=ADALDDAPModel::where('ada_id', $ada_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('ps_amount');
               $total_mooe_amount=ADALDDAPModel::where('ada_id', $ada_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('mooe_amount');
               $total_co_amount=ADALDDAPModel::where('ada_id', $ada_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('co_amount');
               // $total=$total_ps_amount+$total_mooe_amount+$total_co_amount;
               // dd($total_mooe_amount);
               ADAModel::find($ada_id)
                  ->update([ 
                     'total_ps_amount'=>$total_ps_amount ?? 0,
                     'total_mooe_amount'=>$total_mooe_amount ?? 0,
                     'total_co_amount'=>$total_co_amount ?? 0,
                  ]); 
            }               
            return response()->json(array('success' => 1, 200));             
         }
      }  
   }

   public function delete(Request $request){
      if($request->ajax()) {
         // dd($request->all());
         $id=$request->id;
         $lddap_id=$request->lddap_id;
         $ada_id=$request->ada_id;
         if($request->delete_ada==1) { 
            try {     
               ADAModel::find($id)
                  ->update([
                  'is_deleted' => '1'
               ]);
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
         elseif($request->remove_attached_lddap==1){
            try {     
               ADALDDAPModel::find($id)
                  ->update([ 
                     'is_deleted'=>1,
                  ]);  
               
               LDDAPModel::find($lddap_id)
                  ->update([ 
                     'ada_id'=>NULL,
                  ]); 

               $total_ps_amount=ADALDDAPModel::where('ada_id', $ada_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('ps_amount');
               $total_mooe_amount=ADALDDAPModel::where('ada_id', $ada_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('mooe_amount');
               $total_co_amount=ADALDDAPModel::where('ada_id', $ada_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('co_amount');
               
               ADAModel::find($ada_id)
                  ->update([ 
                     'total_ps_amount'=>$total_ps_amount,
                     'total_mooe_amount'=>$total_mooe_amount,
                     'total_co_amount'=>$total_co_amount,
                  ]); 
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
      }
   } 

   public function show_lddap(Request $request) {
      if ($request->ajax() && isset($request->all()['fund_id']) && $request->all()['fund_id'] != null) {         
         $data = ViewLDDAPModel::where('fund_id', $request->fund_id)
            ->whereYear('lddap_date', $request->ada_year)
            ->whereNull('ada_id')
               ->where(function ($query) {
                  $query->whereNotNull('lddap_no')
                     ->orWhere('lddap_no','!=',' ');
            })
            ->where('payment_mode_id', 1)->where('is_active', 1)->where('is_deleted', 0)
            ->orderByRaw('CAST(lddap_no AS UNSIGNED) asc, lddap_no asc')->get();   
         if($request->attach_lddap==1){
            return DataTables::of($data)
               ->setRowAttr([
                  'data-id' => function($lddap) {
                  return $lddap->id;
                  }
               ])
               ->addColumn('lddap_id', function($row){
                  $btn =
                  "     
                  <a href='#' data-lddap-id='". $row->id ."' class='attach_lddap'>". $row->id ."</a>
                  
                  ";
                  return $btn;
               })
               ->rawColumns(['lddap_id'])
               ->make(true);
         }       
      }
   }

   public function show_ada_by_fund_month_year(Request $request) {
      // dd($request->all());
      $fund_selected=$request->fund_selected;
      $month_selected=$request->month_selected;
      $year_selected=$request->year_selected;
      $search=$request->search;
      if ($request->ajax() && isset($month_selected) && $month_selected != null && ($search == null || $search == '')) {
         $data = ViewADAModel::where('fund_id', $fund_selected)->whereMonth('ada_date', $month_selected)->whereYear('ada_date', $year_selected)
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('ada_no', 'ASC')->get();
      }
      else if ($request->ajax() && isset($search) && $search != null) {
         $data = ViewADAModel::
            where(function ($query) use ($search) {
               $query->where('ada_no','like','%'.$search.'%')
                  ->orWhere('bank_account_no','like','%'.$search.'%')
                  ->orWhere('date_transferred','like','%'.$search.'%')
                  ->orWhere('ada_date','like','%'.$search.'%')
                  ->orWhere('ada_no','like','%'.$search.'%');
            })
            ->where('fund_id', $fund_selected)->where('is_active', 1)->where('is_deleted', 0)->orderBy('ada_no', 'ASC')->get();
      }
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($ada) {
            return $ada->id;
            }
         ])
         ->addColumn('ada_no', function($row){
            $btn =
               "<a data-id='". $row->id ."' href='".url('funds_utilization/ada/edit/'.$row->id)."'>
               ". $row->ada_no ."</a>";
            return $btn;
         })
         ->rawColumns(['ada_no'])
         ->make(true);     
   }

   public function generate_ada_no(Request $request){   
      if($request->ajax()) { 
         // dd($request->all());
         $now = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');	
         $ada_id=$request->ada_id; 
         $year=$request->year;
         $fund_id=$request->fund_id;
         $add_ada=$request->add_ada;         
         $ada_no = DB::table('ada')
            ->select(DB::raw("(ada_no + 1) as ada_no"))->whereYear('ada_date', $year)
            ->where('fund_id', $fund_id)->where('is_active', 1)->where('is_deleted',0)
            ->orderByRaw('CAST(ada_no AS UNSIGNED) desc')->pluck('ada_no')->first();
         if($ada_no==0 || $ada_no==NULL) {
            $ada_no="1" ;
         }
         if($add_ada==1){           
            $data = new ADAModel([
               'fund_id' => $request->fund_id,               
               'bank_account_id' => $request->bank_account_id,                 
               'ada_no' => $ada_no,  
               'ada_date' => $request->ada_date,       
               'check_no' => $request->check_no,                      
            ]);
            // dd($data);
            $data->save(); 
            $data->id;   
            return response()->json(array('success' => 1,'redirect_url' => route('ada.edit', [$data->id]),), 200); 
         }
         else{
            ADAModel::find($ada_id)
            ->update([ 
               'ada_no'=>$ada_no,
               'is_locked'=> 1, 
               'locked_at'=> $now, 
            ]);           
            return response()->json(array('success' => 1, 200));
         }
      }
   }

   public function print_lddap_ada_summary($ada_id) {
      $ada_data = ViewADAModel::where('id', $ada_id)->get();
      $ada_lddap_data = ViewADALDDAPModel::where('ada_id', $ada_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      return \View::make('funds_utilization.ada.print_lddap_ada_summary')
         ->with('ada_data', $ada_data)
         ->with('ada_lddap_data', $ada_lddap_data);
   }
}
