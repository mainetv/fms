<?php

namespace App\Http\Controllers;

use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\FundsModel;
use App\Models\LibraryRsTypesModel;
use App\Models\ModulesModel;
use App\Models\NotificationsModel;
use App\Models\ParticularsTemplateModel;
use App\Models\PrefixNumberModel;
use App\Models\RSActivityModel;
use App\Models\RSModel;
use App\Models\RsPapModel;
use App\Models\RsTransactionTypeModel;
use App\Models\ViewAllotmentModel;
use App\Models\ViewLibraryPayeesModel;
use App\Models\ViewLibraryRsTransactionTypesModel;
use App\Models\ViewRSActivityModel;
use App\Models\ViewRsDocumentModel;
use App\Models\ViewRSModel;
use App\Models\ViewRsTransactionTypesModel;
use App\Models\ViewLibrarySignatoriesModel;
use App\Models\ViewRsPapModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Response;
use DataTables;

class RSController extends Controller
{
   public function index(Request $request, $url, $month_selected, $year_selected){    
      $username = auth()->user()->username; 
      $user_id = auth()->user()->id;        
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();   
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();     
      $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
      $years = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'ASC')->get();
      $data = [
         "month_selected" => $month_selected,
         "year_selected" => $year_selected,
      ];
      if($emp_code=='PS1908'){
         $user_division_id=3;
         $user_division_acronym='COA';
      }
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {     
         if (auth()->user()->hasAnyRole('Division Budget Controller|Division Director|Section Head')){  //User specific division only
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
               ->where(function ($query) {
                  $query->where('role_id','=',6)
                     ->orWhere('role_id','=',7);
               })
               ->where('role_id','!=',3)
               ->pluck('role_id')->first();               
            if($url=='ors'){  
               $title = "orsdivision"; 
               return view('funds_utilization.ors.division')
                  ->with(compact('title'), $title)
                  ->with(compact('data'), $data)
                  ->with(compact('username'), $username)
                  ->with(compact('user_id'), $user_id)
                  ->with(compact('user_role'), $user_role)
                  ->with(compact('user_role_id'), $user_role_id)
                  ->with(compact('user_division_id'), $user_division_id)
                  ->with(compact('user_division_acronym'), $user_division_acronym)
                  ->with(compact('user_fullname'), $user_fullname)
                  ->with(compact('divisions'), $divisions)
                  ->with(compact('years'), $years);
            }
            elseif($url=='burs'){
               $title = "bursdivision";
               return view('funds_utilization.burs.division')
                  ->with(compact('title'), $title)
                  ->with(compact('data'), $data)
                  ->with(compact('username'), $username)
                  ->with(compact('user_id'), $user_id)
                  ->with(compact('user_role'), $user_role)
                  ->with(compact('user_role_id'), $user_role_id)
                  ->with(compact('user_division_id'), $user_division_id)
                  ->with(compact('user_division_acronym'), $user_division_acronym)
                  ->with(compact('user_fullname'), $user_fullname)
                  ->with(compact('divisions'), $divisions)
                  ->with(compact('years'), $years);
            }
            elseif($url=='burs-cfitf'){
               $title = "burscdivision";
               return view('funds_utilization.burs_cfitf.division')
                  ->with(compact('title'), $title)
                  ->with(compact('data'), $data)
                  ->with(compact('username'), $username)
                  ->with(compact('user_id'), $user_id)
                  ->with(compact('user_role'), $user_role)
                  ->with(compact('user_role_id'), $user_role_id)
                  ->with(compact('user_division_id'), $user_division_id)
                  ->with(compact('user_division_acronym'), $user_division_acronym)
                  ->with(compact('user_fullname'), $user_fullname)
                  ->with(compact('divisions'), $divisions)
                  ->with(compact('years'), $years);
            }   
         }
      }
   }

   public function index_all(Request $request, $url, $month_selected, $year_selected){    
      $username = auth()->user()->username; 
      $user_id = auth()->user()->id;        
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();   
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();     
      $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
      $years = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'ASC')->get();
      $data = [
         "month_selected" => $month_selected,
         "year_selected" => $year_selected,
      ];
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {     
         if (auth()->user()->hasAnyRole('Administrator|Super Administrator|Budget Officer|Accounting Officer')){  
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
               ->where(function ($query) {
                  $query->where('role_id','=',0)
                     ->orWhere('role_id','=',1)
                     ->orWhere('role_id','=',3);
               })
               ->pluck('role_id')->first();   
            if($url=='ors'){ 
               $title = "ors"; 
               return view('funds_utilization.ors.all')
                  ->with(compact('title'), $title)
                  ->with(compact('data'), $data)
                  ->with(compact('username'), $username)
                  ->with(compact('user_id'), $user_id)
                  ->with(compact('user_role'), $user_role)
                  ->with(compact('user_role_id'), $user_role_id)
                  ->with(compact('user_division_id'), $user_division_id)
                  ->with(compact('user_division_acronym'), $user_division_acronym)
                  ->with(compact('user_fullname'), $user_fullname)
                  ->with(compact('divisions'), $divisions)
                  ->with(compact('years'), $years);
            }
            elseif($url=='burs'){
               $title = "burs";
               return view('funds_utilization.burs.all')
                  ->with(compact('title'), $title)
                  ->with(compact('data'), $data)
                  ->with(compact('username'), $username)
                  ->with(compact('user_id'), $user_id)
                  ->with(compact('user_role'), $user_role)
                  ->with(compact('user_role_id'), $user_role_id)
                  ->with(compact('user_division_id'), $user_division_id)
                  ->with(compact('user_division_acronym'), $user_division_acronym)
                  ->with(compact('user_fullname'), $user_fullname)
                  ->with(compact('divisions'), $divisions)
                  ->with(compact('years'), $years);
            }
            elseif($url=='burs-cfitf'){               
               $title = "bursc";
               return view('funds_utilization.burs_cfitf.all')
                  ->with(compact('title'), $title)
                  ->with(compact('data'), $data)
                  ->with(compact('username'), $username)
                  ->with(compact('user_id'), $user_id)
                  ->with(compact('user_role'), $user_role)
                  ->with(compact('user_role_id'), $user_role_id)
                  ->with(compact('user_division_id'), $user_division_id)
                  ->with(compact('user_division_acronym'), $user_division_acronym)
                  ->with(compact('user_fullname'), $user_fullname)
                  ->with(compact('divisions'), $divisions)
                  ->with(compact('years'), $years);
            }             
         }
      }
   }

   public function store(Request $request){       
      $user_id = auth()->user()->id; 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->pluck('role_id')->first();
      $now = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');        
      $date_now = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');  
      $rs_type_id = $request->rs_type_id;  
      $module_id = $request->module_id;  
      $rs_date = $request->rs_date;   
      $rs_type = $request->rs_type;
      // dd($request->all()); 
      if($user_id=='111'){
         $user_division_id=3;
         $user_division_acronym='COA';
      }
      if($user_id=='20' || $user_id=='14'){
         $user_division_id = '9';
         $user_division_acronym='FAD-DO';
      }
      if ($request->ajax()) {  
         $rs_id=$request->rs_id;
         $allotment_id=$request->allotment_id;
         if($request->add_rs==1){
            $message = array(    
               'rs_date.required' => 'Please select date.',
               'fund_id.required' => 'Please select fund.',
               'payee_id.required' => 'Please select payee.',
            );
            $validator =  Validator::make($request->all(), [
               'rs_date' => 'required',
               'fund_id' => 'required',
               'payee_id' => 'required',
            ], $message);
      
            if ($validator->passes()) {
               $signatory1 = $request->signatory1;
               $signatory2 = $request->signatory2;
               $signatory3 = $request->signatory3;
               $signatory4 = $request->signatory4; 
               $get_signatory1_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory1)
                  ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();   
               $get_signatory2_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory2)
                  ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first(); 
               $get_signatory3_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory3)
                  ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();         
               $get_signatory4_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory4)
                  ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first(); 
               $data = new RSModel([
                  'rs_type_id' => $rs_type_id,
                  'rs_date' => $rs_date,
                  'division_id' => $request->get('division_id'),
                  'fund_id' => $request->get('fund_id'),
                  'payee_id' => $request->get('payee_id'),
                  'particulars' => $request->get('particulars'),
                  'signatory1' => $signatory1,
                  'signatory2' => $signatory2,
                  'signatory3' => $signatory3,
                  'signatory4' => $signatory4,
                  'signatory1_position' => $get_signatory1_position,
                  'signatory2_position' => $get_signatory2_position,
                  'signatory3_position' => $get_signatory3_position,
                  'signatory4_position' => $get_signatory4_position,
                  'showall' => $request->showall,                 
                  'is_locked' => 0,                    
               ]);
               $data->save(); 
               $data->id;            
               $rs_transaction_type_id = $request->rs_transaction_type_id;
               if(isset($rs_transaction_type_id)){
                  $count = count($rs_transaction_type_id);  
                  for ($i=0; $i < $count; $i++) {   
                     $data1 = [
                        'rs_id' => $data->id,
                        'rs_transaction_type_id' => $rs_transaction_type_id[$i],
                     ];  
                     RsTransactionTypeModel::insert($data1);
                  }
               }
               $message = $user_division_acronym.' created new '.$rs_type.' [ID: '.$data->id.']';               
               $get_link = ModulesModel::where('id', $module_id)
                  ->where('is_active', 1)->where('is_deleted', 0)->pluck('link')->first();
               $get_month =  DB::table('request_status')
                  ->selectRaw('month(rs_date) as month')->where('id', $data->id)->pluck('month')->first(); 
               $get_year =  DB::table('request_status')
                  ->selectRaw('year(rs_date) as year')->where('id', $data->id)->pluck('year')->first(); 
               $get_budget_officer = ViewUsersHasRolesModel::where('role_id', 3)
                  ->where('id','!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->get();
               if($get_budget_officer->count()!=0){
                  foreach($get_budget_officer as $value){
                     $notification_to_budget_officer[] =[
                        'message' => $message,
                        'record_id' => $data->id,
                        'module_id' => $module_id,
                        'month' => $get_month,
                        'year' => $get_year,
                        'date' => $rs_date,    
                        'link' => $get_link, 
                        'division_id' => $user_division_id,
                        'division_id_from' => $user_division_id,
                        'division_id_to' => $value->division_id,
                        'user_id_from' => $user_id,
                        'user_id_to' => $value->id,
                        'user_role_id_from' => $user_role_id ?? '7', 
                        'user_role_id_to' => '3', 
                     ]; 
                  }           
                  NotificationsModel::insert($notification_to_budget_officer);
               } 
               return response()->json(array('success' => 1,'redirect_url' => route('rs.edit_division', [$data->id]),), 200);
            }
            return Response::json(['errors' => $validator->errors()]);   
         }       
         elseif($request->attach_rs_allotment==1){
            if($request->user_role_id==3){
               $rs_pap = RsPapModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get();         
               if($rs_pap->count() == 0){
                  $total_rs_activity_amount = $request->total_rs_activity_amount;
                  RSModel::find($rs_id)
                  ->update([                          
                     'is_locked' => '1',
                     'locked_at' => $now,                             
                  ]);
               }   
               
               $data = new RsPapModel([
                  'rs_id' => $rs_id,                              
                  'allotment_id' => $allotment_id,                              
                  'amount' => $total_rs_activity_amount ?? '0',                              
               ]);  
               $data->save(); 

               $total_rs_pap_amount = RsPapModel::where('rs_id', $rs_id)
                  ->where('is_active', 1)->where('is_deleted', 0)->sum('amount');       
               
               RSModel::find($rs_id)
                  ->update([            
                     'total_rs_pap_amount' => $total_rs_pap_amount ?? '0',                             
                  ]); 
            }
            else{
               $data = new RSActivityModel([
                  'rs_id' => $rs_id,                              
                  'allotment_id' => $allotment_id,                                
               ]);      
               $data->save();       
            } 
            $data->id;
            return response()->json(array('success' => 1,'rs_activity_id' => $data->id), 200);
         }
         elseif($request->add_notice_adjustment==1){
            // dd($request->all());            
            $data = new RsPapModel([
               'rs_id' => $rs_id,                              
               'allotment_id' => $allotment_id,                              
               'amount' => $request->notice_adjustment_amount ?? 0,                              
               'notice_adjustment_no' => $request->notice_adjustment_no ?? NULL,                              
               'notice_adjustment_date' => $date_now,                              
            ]); 
            $data->save(); 
            $data->id;
            return response()->json(array('success' => 1,'rs_activity_id' => $data->id), 200);
         }
      }
   }

   public function edit(Request $request){     
      $user_id = auth()->user()->id;       
      $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
         ->where('role_id',3)
         ->pluck('role_id')->first(); 
      $rs_id=$request->id;      
      $getRsDetails =  ViewRSModel::where('id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      $rs_type_id =  ViewRSModel::where('id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('rs_type_id')->first();
      $getFunds = FundsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fund')->get();      
      $getPayees = ViewLibraryPayeesModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('payee')->get();
      $getRsTransactionTypes = ViewLibraryRsTransactionTypesModel::where("is_active", 1)->where("is_deleted", 0)->get();
      $getRsSignatories = ViewLibrarySignatoriesModel::where('module_id', 5)->where("is_active", 1)->where("is_deleted", 0)->orderBy('fullname_first')->get();
      $getRsSignatory1b = ViewLibrarySignatoriesModel::where('module_id', 5)->where('is_default', 1)->where("is_active", 1)
         ->where("is_deleted", 0)->orderBy('fullname_first')->get(); 
      if($rs_type_id==1){
         $title = "ors";  
      }
      elseif($rs_type_id==2){
         $title = "burs";  
      }
      elseif($rs_type_id==3){
         $title = "bursc";  
      }
      $getAttachedAllotmentByRs =  ViewRsPapModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)
         ->whereNull('notice_adjustment_date')->get();
      $getAttachedActivityByRs =  ViewRSActivityModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get();      
      $getNoticeAdjustmentbyRS =  ViewRsPapModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)
         ->whereNotNull('notice_adjustment_date')->get();
      $getSelectedRsTransactionTypes = ViewRsTransactionTypesModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get(); 
      return view('funds_utilization.rs.edit')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('title'))
         ->with(compact('getRsDetails'))
         ->with(compact('getAttachedAllotmentByRs'))
         ->with(compact('getAttachedActivityByRs'))
         ->with(compact('getNoticeAdjustmentbyRS'))
         ->with(compact('getRsSignatory1b'))
         ->with(compact('getRsSignatories'))
         ->with(compact('getFunds'))
         ->with(compact('getPayees'))
         ->with(compact('getSelectedRsTransactionTypes'))
         ->with(compact('getRsTransactionTypes'));     
   }

   public function edit_division(Request $request){     
      $user_id = auth()->user()->id;       
      $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
         ->where(function ($query) {
            $query->where('role_id','=',7)
               ->orWhere('role_id','=',6);
         })
         ->pluck('role_id')->first(); 
      $rs_id=$request->id;      
      $getRsDetails =  ViewRSModel::where('id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      $rs_type_id =  ViewRSModel::where('id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('rs_type_id')->first();
      $getFunds = FundsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fund')->get();      
      $getPayees = ViewLibraryPayeesModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('payee')->get();
      $getRsTransactionTypes = ViewLibraryRsTransactionTypesModel::where("is_active", 1)->where("is_deleted", 0)->get();
      $getRsSignatories = ViewLibrarySignatoriesModel::where('module_id', 5)->where("is_active", 1)->where("is_deleted", 0)->orderBy('fullname_first')->get();
      $getRsSignatory1b = ViewLibrarySignatoriesModel::where('module_id', 5)->where('is_default', 1)->where("is_active", 1)
         ->where("is_deleted", 0)->orderBy('fullname_first')->get(); 
      if($rs_type_id==1){
         $title = "orsdivision";  
      }
      elseif($rs_type_id==2){
         $title = "bursdivision";  
      }
      elseif($rs_type_id==3){
         $title = "burscdivision";  
      }           
      $getAttachedAllotmentByRs =  ViewRsPapModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)
         ->whereNull('notice_adjustment_date')->get();
      $getAttachedActivityByRs =  ViewRSActivityModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get();      
      $getNoticeAdjustmentbyRS =  ViewRsPapModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)
         ->whereNotNull('notice_adjustment_date')->get();
      $getSelectedRsTransactionTypes = ViewRsTransactionTypesModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get(); 
      return view('funds_utilization.rs.edit_division')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('title'))
         ->with(compact('getRsDetails'))
         ->with(compact('getAttachedAllotmentByRs'))
         ->with(compact('getAttachedActivityByRs'))
         ->with(compact('getNoticeAdjustmentbyRS'))
         ->with(compact('getRsSignatory1b'))
         ->with(compact('getRsSignatories'))
         ->with(compact('getFunds'))
         ->with(compact('getPayees'))
         ->with(compact('getSelectedRsTransactionTypes'))
         ->with(compact('getRsTransactionTypes'));     
   }

   public function add($rs_type_id){     
      $user_id = auth()->user()->id;  
      $user_role_id = auth()->user()->user_role_id;       
      $rs_type_id =  LibraryRsTypesModel::where('id', $rs_type_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('id')->first();
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $getFunds = FundsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fund')->get();      
      $getPayees = ViewLibraryPayeesModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('first_name')->orderBy('organization_name')->get();
      $getRsTransactionTypes = ViewLibraryRsTransactionTypesModel::where("is_active", 1)->where("is_deleted", 0)->get();
      $getRsSignatories = ViewLibrarySignatoriesModel::where('module_id', 5)->where("is_active", 1)->where("is_deleted", 0)->orderBy('fullname_first')->get();
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();     
      if($emp_code=='PS1908'){
         $user_division_id=3;
         $user_division_acronym='COA';
      }
      foreach($user_roles as $row){
         if($row->role_id==3){
           $sup="as DBC";
         }
       }     
      if($rs_type_id==1){
         $title = "orsdivision";  
      }
      elseif($rs_type_id==2){
         $title = "bursdivision";  
      }
      elseif($rs_type_id==3){
         $title = "burscdivision";  
      }          
      return view('funds_utilization.rs.add')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('user_roles'))
         ->with(compact('user_division_id'))
         ->with(compact('user_division_acronym'))
         ->with(compact('title'))
         ->with(compact('rs_type_id'))
         ->with(compact('getRsSignatories'))
         ->with(compact('getFunds'))
         ->with(compact('getPayees'))
         ->with(compact('getRsTransactionTypes'));    
   }

   public function update(Request $request, RSModel $RSModel){
      if($request->ajax()) {  
         // dd($request->all());        
         $rs_id = $request->rs_id;             
         $rs_allotment_id=$request->rs_allotment_id; 
         $notice_adjustment_id=$request->notice_adjustment_id; 
         $rs_activity_id=$request->rs_activity_id;
         $user_role_id=$request->user_role_id; 
         $rs_activity_amount=removeComma($request->rs_activity_amount);
         $rs_allotment_amount=removeComma($request->rs_allotment_amount);
         $notice_adjustment_amount=removeComma($request->notice_adjustment_amount);   
         // dd($notice_adjustment_amount);      
         if($request->edit_rs==1) {             
            $message = array(    
               'rs_date.required' => 'Please select date.',
               'payee_id.required' => 'Please select payee.',
            );
            $validator =  Validator::make($request->all(), [
               'rs_date' => 'required',
               'payee_id' => 'required',
            ], $message);
                  
            if ($validator->passes()) {               
               if(isset($rs_activity_id)){
                  $activity_count = count($rs_activity_id);       
                  for ($i=0; $i < $activity_count; $i++) {   
                     RSActivityModel::find($rs_activity_id[$i])
                        ->update([ 
                           'amount'=>$rs_activity_amount[$i] 
                        ]); 
                  }  
                  
               } 
               $get_total_rs_activity_amount = RSActivityModel::where('rs_id', $rs_id)
                  ->where("is_active", 1)->where("is_deleted", 0)->sum('amount');   
               $signatory1 = $request->signatory1;
               $signatory2 = $request->signatory2;
               $signatory3 = $request->signatory3;
               $signatory4 = $request->signatory4; 
               $get_signatory1_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory1)
                  ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();   
               $get_signatory2_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory2)
                  ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first(); 
               $get_signatory3_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory3)
                  ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();         
               $get_signatory4_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory4)
                  ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();        
               RSModel::find($rs_id)
                  ->update([     
                     'rs_date' => $request->get('rs_date'),
                     'payee_id' => $request->get('payee_id'),
                     'total_rs_activity_amount' => $get_total_rs_activity_amount,
                     'particulars' => $request->get('particulars'),
                     'signatory1' => $signatory1,
                     'signatory2' => $signatory2,
                     'signatory3' => $signatory3,
                     'signatory4' => $signatory4,
                     'signatory1_position' => $get_signatory1_position,
                     'signatory2_position' => $get_signatory2_position,
                     'signatory3_position' => $get_signatory3_position,
                     'signatory4_position' => $get_signatory4_position,
                     'showall' => $request->showall,
                     'cancel_date' => $request->get('cancel_date'),                  
                  ]); 
                  $rs_transaction_type_id = $request->rs_transaction_type_id;
                  $get_rs_transaction_type = RsTransactionTypeModel::where('rs_id', $rs_id)
                     ->where('is_active', 1)->where('is_deleted', 0)->get();
                  if($get_rs_transaction_type->count() > 0){    
                     RsTransactionTypeModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)
                        ->update([     
                           'is_active' => 0,                                 
                           'is_deleted' => 1,                                 
                        ]);  
                  } 
                  if(isset($rs_transaction_type_id)){
                     $trans_count = count($rs_transaction_type_id);  
                     for ($i=0; $i < $trans_count; $i++) {   
                        $data1 = [
                           'rs_id' => $request->rs_id,
                           'rs_transaction_type_id' => $rs_transaction_type_id[$i],
                        ];  
                        RsTransactionTypeModel::insert($data1);
                     }
                  }              
               return response()->json(array('success' => 1, 200));     
            }                
            return Response::json(['errors' => $validator->errors()]);
         }   
         else if($request->update_rs==1) {             
            $message = array(    
               'rs_date.required' => 'Please select date.',
            );
            $validator =  Validator::make($request->all(), [
               'rs_date' => 'required',
            ], $message);
                  
            if ($validator->passes()) {
               if(isset($rs_activity_id)){
                  $activity_count = count($rs_activity_id);       
                  for ($i=0; $i < $activity_count; $i++) {   
                     RSActivityModel::find($rs_activity_id[$i])
                        ->update([ 
                           'amount'=>$rs_activity_amount[$i] 
                        ]); 
                  }  
                  
               } 
               
               if(isset($rs_allotment_id)){                  
                  $allotment_count = count($rs_allotment_id);  
                  for ($i=0; $i < $allotment_count; $i++) {   
                     RsPapModel::find($rs_allotment_id[$i])
                        ->update([ 
                           'amount'=>$rs_allotment_amount[$i],
                        ]);       
                  }  
               } 
               if(isset($notice_adjustment_id)){                  
                  $notice_adjustment_count = count($notice_adjustment_id);  
                  for ($i=0; $i < $notice_adjustment_count; $i++) {   
                     RsPapModel::find($notice_adjustment_id[$i])
                        ->update([ 
                           'amount'=>$notice_adjustment_amount[$i],
                           'notice_adjustment_no'=>$request->notice_adjustment_no[$i] ?? NULL,
                           'notice_adjustment_date'=>$request->notice_adjustment_date[$i] ?? NULL,
                        ]);       
                  }  
               } 
               $get_total_rs_activity_amount = RSActivityModel::where('rs_id', $rs_id)
                  ->where("is_active", 1)->where("is_deleted", 0)->sum('amount');                   
               $get_total_rs_pap_amount = RsPapModel::where('rs_id', $rs_id)
                  ->where("is_active", 1)->where("is_deleted", 0)->sum('amount');
               $signatory1b = $request->signatory1b;   
               $get_signatory1b_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory1b)
                  ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();  
               RSModel::find($rs_id)
                  ->update([     
                     'rs_date1' => $request->get('rs_date'),
                     'rs_no' => $request->get('rs_no'),
                     'total_rs_activity_amount' => $get_total_rs_activity_amount,
                     'total_rs_pap_amount' => $get_total_rs_pap_amount,
                     'particulars' => $request->get('particulars'),
                     'signatory1b' => $signatory1b,
                     'signatory1b_position' => $get_signatory1b_position,                    
                     'is_locked' => $request->is_locked,                    
                  ]);              
               
               return response()->json(array('success' => 1, 200));     
            }                
            return Response::json(['errors' => $validator->errors()]);
         } 
         else if($request->edit_attached_allotment==1){
            if($user_role_id!=3){
               RSActivityModel::find($rs_allotment_id)
                  ->update([ 
                     'allotment_id'=>$request->allotment_id 
                  ]); 
               return response()->json(array('success' => 1, 200));   
            }
            else{
               RsPapModel::find($rs_allotment_id)
                  ->update([ 
                     'allotment_id'=>$request->allotment_id 
                  ]); 
               return response()->json(array('success' => 1, 200)); 
            }
         }
         else if($request->edit_notice_adjustment==1){
            RsPapModel::find($rs_allotment_id)
               ->update([ 
                  'allotment_id'=>$request->allotment_id 
               ]); 
             return response()->json(array('success' => 1, 200));   
         }
      }
   }

   public function show(Request $request){
      $data = ViewRSModel::find($request->id); 
      if($data->count()) {
         return Response::json([
         'status' => '1',
         'rs' => $data               
         ]);
      } 
      else {
         return Response::json([
         'status' => '0'
         ]);
      } 
   } 

   public function delete(Request $request){
      if($request->ajax()) {
         // dd($request->all());
         $id=$request->id;
         $rs_id=$request->rs_id;
         if($request->delete_rs==1) { //updating budget proposal delete 1
            try {     
               RSModel::find($id)
                  ->update([
                  'is_deleted' => '1'
               ]);
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
         elseif($request->delete_rs_activity==1){            
            try {     
               RSActivityModel::find($id)
                  ->update([
                  'is_deleted' => '1'
               ]);
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
         elseif($request->remove_attached_allotment==1){
            try {     
               RsPapModel::find($id)
                  ->update([
                  'is_deleted' => '1'
               ]);
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
         elseif($request->remove_attached_activity==1){
            try {     
               RSActivityModel::find($id)
                  ->update([
                  'is_deleted' => '1'
               ]);
               
               $get_rs_activity_amount=RSActivityModel::where('rs_id', $rs_id)
               ->where('is_active',1)->where('is_deleted',0)->sum('amount');
               RSModel::find($rs_id)
                  ->update([
                  'total_rs_activity_amount' => $get_rs_activity_amount,
                  'total_rs_pap_amount' => $get_rs_activity_amount,
               ]);
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
      }
   }

   public function generate_rs_no(Request $request, RSModel $RSModel){   
      if($request->ajax()) { 
         // dd($request->all()); 
         $user_id = auth()->user()->id; 
         $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
         $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
         $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->pluck('role_id')->first();
         $module_id = $request->module_id;  
         $division_id = $request->division_id; 
         $rs_id=$request->rs_id;  
         $rs_type_id=$request->rs_type_id;          
         $rs_type=$request->rs_type;     
         $date_now = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');   
         $month_now = Carbon::now()->timezone('Asia/Manila')->format('m');   
         $year_now = Carbon::now()->timezone('Asia/Manila')->format('Y');   
         $prefix_code = PrefixNumberModel::where('rs_type_id', $rs_type_id)
            ->where('is_active', 1)->where('is_deleted',0)->pluck('prefix_code')->first();
         $aclass_prefix = ViewRSActivityModel::where('rs_id', $rs_id)
            ->where('is_active', 1)->where('is_deleted',0)->pluck('allotment_class_number')->first();         
         if($rs_type_id==1){
            $suffix = DB::table('request_status')
               ->select(DB::raw("LPAD(SUBSTR(rs_no,17,6)+1,6,0) as rs_no"))
               ->whereRaw('LENGTH(rs_no) > 17')->whereYear('rs_date1', $year_now)
               ->where('rs_type_id', $rs_type_id)->where('is_active', 1)->where('is_deleted',0)
               ->orderBY('rs_no','DESC')->pluck('rs_no')->first();
         }
         elseif($rs_type_id==2){
            $suffix = DB::table('request_status')
               ->select(DB::raw("LPAD(SUBSTR(rs_no,19,6)+1,5,0) as rs_no"))
               ->whereRaw('LENGTH(rs_no) > 17')->whereYear('rs_date1', $year_now)
               ->where('rs_type_id', $rs_type_id)->where('is_active', 1)->where('is_deleted',0)
               ->orderBY('rs_no','DESC')->pluck('rs_no')->first();
         }
         elseif($rs_type_id==3){
            $suffix = DB::table('request_status')
               ->select(DB::raw("LPAD(SUBSTR(rs_no,25,6)+1,5,0) as rs_no"))
               ->whereRaw('LENGTH(rs_no) > 17')->whereYear('rs_date1', $year_now)
               ->where('rs_type_id', $rs_type_id)->where('is_active', 1)->where('is_deleted',0)
               ->orderBY('rs_no','DESC')->pluck('rs_no')->first();
         }
         if($suffix==0 || $suffix==NULL) {
            $suffix="000001" ;
         }
         if($aclass_prefix==0 || $aclass_prefix==NULL){
            $aclass_prefix="";
         }     
         if($rs_type_id==1){
            $rs_no = $aclass_prefix.''.$prefix_code.$year_now.'-'.$month_now.'-'.$suffix;
         }
         elseif($rs_type_id==2){
            $rs_no = $aclass_prefix.'-'.$prefix_code.'-'.$year_now.'-'.$month_now.'-'.$suffix;
         }
         elseif($rs_type_id==3){
            $rs_no = $aclass_prefix.'-'.$prefix_code.'-'.$year_now.'-'.$month_now.'-'.$suffix;
         }
         // dd($rs_no);
         RSModel::find($rs_id)
            ->update([ 
               'rs_no'=>$rs_no,
               'rs_date1'=>$date_now 
            ]); 
         $message = $user_division_acronym.' updated the '.$rs_type.' [ID: '.$rs_id.']';          
         $get_link = ModulesModel::where('id', $module_id)
            ->where('is_active', 1)->where('is_deleted', 0)->pluck('link')->first();
         $get_month =  DB::table('request_status')
            ->selectRaw('month(rs_date1) as month')->where('id', $rs_id)->pluck('month')->first(); 
         $get_year =  DB::table('request_status')
            ->selectRaw('year(rs_date1) as year')->where('id', $rs_id)->pluck('year')->first(); 
         $get_date =  DB::table('request_status')->where('id', $rs_id)->pluck('rs_date1')->first(); 
         $get_division_budget_controller = ViewUsersHasRolesModel::where('role_id', 7)->where('division_id', $division_id)
            ->where('id','!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->get();  
         if($get_division_budget_controller->count() > 0){               
            foreach($get_division_budget_controller as $value){
               $notification_budget_controller[] =[
                  'message' => $message,
                  'record_id' => $rs_id,
                  'module_id' => $module_id,
                  'month' => $get_month,
                  'year' => $get_year,  
                  'date' => $get_date,  
                  'link' => $get_link, 
                  'division_id' => $division_id,
                  'division_id_from' => $user_division_id,
                  'division_id_to' => $value->division_id,
                  'user_id_from' => $user_id,
                  'user_id_to' => $value->id,
                  'user_role_id_from' => $user_role_id ?? '3', 
                  'user_role_id_to' => '7', 
               ]; 
            }                
            NotificationsModel::insert($notification_budget_controller);
         }                  
         return response()->json(array('success' => 1), 200);     
      }
   }

   //shows all allotments in the selected year for ors and all years for burs
   public function show_all_allotment(Request $request){ 
      //dd($request->all());
      $rs_type_id = $request->rs_type_id;
      $year = $request->year;
      $division_id = $request->division_id;
      if ($request->ajax() && isset($request->all()['rs_type_id']) && $request->all()['rs_type_id'] != null) {
         if(isset($request->all()['rs_type_id'])) {    
            if($request->showall==NULL || $request->showall==1){
               if($rs_type_id==1){
                  $data = ViewAllotmentModel::where('rs_type_id', $rs_type_id)->where('year', $year)
                     ->where('is_active', '1')->where('is_deleted', '0')->get();
                  $data1 = ViewAllotmentModel::where('rs_type_id', $rs_type_id)->where('year', $year)
                     ->where('is_active', '1')->where('is_deleted', '0')->groupBy('division_activity_subactivity_specific')->get();
               }
               else{
                  $data = ViewAllotmentModel::where('rs_type_id', $rs_type_id)
                     ->where('is_active', '1')->where('is_deleted', '0')->get();
                  $data1 = ViewAllotmentModel::where('rs_type_id', $rs_type_id)
                     ->where('is_active', '1')->where('is_deleted', '0')->groupBy('division_activity_subactivity_specific')->get();
               }
            }
            else{
               if($rs_type_id==1){
                  $data = ViewAllotmentModel::where('division_id', $division_id)->where('rs_type_id', $rs_type_id)->where('year', $year)
                     ->where('is_active', '1')->where('is_deleted', '0')->get();
                  $data1 = ViewAllotmentModel::where('division_id', $division_id)->where('rs_type_id', $rs_type_id)->where('year', $year)
                     ->where('is_active', '1')->where('is_deleted', '0')->groupBy('division_activity_subactivity_specific')->get();
               }
               else{
                  $data = ViewAllotmentModel::where('division_id', $division_id)->where('rs_type_id', $rs_type_id)
                     ->where('is_active', '1')->where('is_deleted', '0')->get();
                  $data1 = ViewAllotmentModel::where('division_id', $division_id)->where('rs_type_id', $rs_type_id)
                     ->where('is_active', '1')->where('is_deleted', '0')->groupBy('division_activity_subactivity_specific')->get();
               }
            }
         } 
         if($request->attach_allotment==1){
            if($rs_type_id==1){
               return DataTables::of($data)
                  ->setRowAttr([
                     'data-id' => function($rs_allotment) {
                     return $rs_allotment->id;
                     }
                  ])
                  ->addColumn('code_expenditure_specific', function($row){
                     $btn =
                        "<a href='#' data-allotment-id='". $row->id ."' class='attach_allotment_activity'>". $row->code_expenditure_specific ."</a>";
                     return $btn;
                  })
                  ->rawColumns(['code_expenditure_specific'])
                  ->make(true);
            }
            else{
               return DataTables::of($data)
               ->setRowAttr([
                  'data-id' => function($rs_allotment) {
                  return $rs_allotment->id;
                  }
               ])
               ->addColumn('expcode_expense_objcode_expenditure_specific', function($row){
                  $btn =
                     "<a href='#' data-allotment-id='". $row->id ."' class='attach_allotment_activity'>". $row->expcode_expense_objcode_expenditure_specific ."</a>";
                  return $btn;
               })
               ->rawColumns(['expcode_expense_objcode_expenditure_specific'])
               ->make(true);
            }
         }
         else if($request->edit_attached_allotment==1){
            if($rs_type_id==1){
               return DataTables::of($data)
                  ->setRowAttr([
                     'data-id' => function($rs_allotment) {
                     return $rs_allotment->id;
                     }
                  ])
                  ->addColumn('code_expenditure_specific', function($row){
                     $btn =
                        "<a href='#' data-allotment-id='". $row->id ."' class='edit_attached_allotment_activity'>". $row->code_expenditure_specific ."</a>";
                     return $btn;
                  })
                  ->rawColumns(['code_expenditure_specific'])
                  ->make(true);
            }
            else{
               return DataTables::of($data)
                  ->setRowAttr([
                     'data-id' => function($rs_allotment) {
                     return $rs_allotment->id;
                     }
                  ])
                  ->addColumn('expcode_expense_objcode_expenditure_specific', function($row){
                     $btn =
                        "<a href='#' data-allotment-id='". $row->id ."' class='edit_attached_allotment_activity'>". $row->expcode_expense_objcode_expenditure_specific ."</a>";
                     return $btn;
                  })
                  ->rawColumns(['expcode_expense_objcode_expenditure_specific'])
                  ->make(true);
            }
         }
         else if($request->notice_adjustment==1){
            if($rs_type_id==1){
               return DataTables::of($data)
                  ->setRowAttr([
                     'data-id' => function($rs_allotment) {
                     return $rs_allotment->id;
                     }
                  ])
                  ->addColumn('code_expenditure_specific', function($row){
                     $btn =
                        "<a href='#' data-allotment-id='". $row->id ."' class='add_notice_adjustment'>". $row->code_expenditure_specific ."</a>";
                     return $btn;
                  })
                  ->rawColumns(['code_expenditure_specific'])
                  ->make(true);
            }
            else{
               return DataTables::of($data)
                  ->setRowAttr([
                     'data-id' => function($rs_allotment) {
                     return $rs_allotment->id;
                     }
                  ])
                  ->addColumn('expcode_expense_objcode_expenditure_specific', function($row){
                     $btn =
                        "<a href='#' data-allotment-id='". $row->id ."' class='add_notice_adjustment'>". $row->expcode_expense_objcode_expenditure_specific ."</a>";
                     return $btn;
                  })
                  ->rawColumns(['expcode_expense_objcode_expenditure_specific'])
                  ->make(true);
            }
         }
         else if($request->edit_notice_adjustment==1){
            if($rs_type_id==1){
               return DataTables::of($data)
                  ->setRowAttr([
                     'data-id' => function($rs_allotment) {
                     return $rs_allotment->id;
                     }
                  ])
                  ->addColumn('code_expenditure_specific', function($row){
                     $btn =
                        "<a href='#' data-allotment-id='". $row->id ."' class='edit_notice_adjustment'>". $row->code_expenditure_specific ."</a>";
                     return $btn;
                  })
                  ->rawColumns(['code_expenditure_specific'])
                  ->make(true);
            }
            else{
               return DataTables::of($data)
                  ->setRowAttr([
                     'data-id' => function($rs_allotment) {
                     return $rs_allotment->id;
                     }
                  ])
                  ->addColumn('expcode_expense_objcode_expenditure_specific', function($row){
                     $btn =
                        "<a href='#' data-allotment-id='". $row->id ."' class='edit_notice_adjustment'>". $row->expcode_expense_objcode_expenditure_specific ."</a>";
                     return $btn;
                  })
                  ->rawColumns(['expcode_expense_objcode_expenditure_specific'])
                  ->make(true);
            }
         }
         else if($request->attach_activity==1){
            return DataTables::of($data1)
               ->setRowAttr([
                  'data-id' => function($rs_allotment) {
                  return $rs_allotment->id;
                  }
               ])
               ->addColumn('activity_subactivity_specific', function($row){
                  $btn =
                     "<a href='#' data-allotment-id='". $row->id ."' class='attach_activity'>". $row->activity_subactivity_specific ."</a>";
                  return $btn;
               })
               ->rawColumns(['activity_subactivity_specific'])
               ->make(true);
         }
         else if($request->edit_attached_activity==1){
            return DataTables::of($data1)
               ->setRowAttr([
                  'data-id' => function($rs_allotment) {
                  return $rs_allotment->id;
                  }
               ])
               ->addColumn('activity_subactivity_specific', function($row){
                  $btn =
                     "<a href='#' data-allotment-id='". $row->id ."' class='edit_attached_activity'>". $row->activity_subactivity_specific ."</a>";
                  return $btn;
               })
               ->rawColumns(['activity_subactivity_specific'])
               ->make(true);
         }         
      }
   }

   //shows all particulars template by rs type id
   public function show_particulars_template_by_rs_type(Request $request){   
      if ($request->ajax() && isset($request->all()['rs_type_id']) && $request->all()['rs_type_id'] != null) {
         if(isset($request->all()['rs_type_id'])) {  
            $data = ParticularsTemplateModel::where('rs_type_id', $request->rs_type_id)->where('is_active', '1')->where('is_deleted', '0')->get();
         } 
         return DataTables::of($data)
            ->setRowAttr([
               'data-id' => function($particulars_template) {
               return $particulars_template->id;
               }
            ])
            ->addColumn('transaction_detail', function($row){
               $btn =
                  "<a href='#' data-particulars='". $row->particulars ."' class='insert_particulars_template'>". $row->transaction_detail ."</a>";
               return $btn;
            })
            ->rawColumns(['transaction_detail'])
            ->make(true);      
      }
   }
   
   //show transaction type of the rs
   public function show_rs_transaction_type(Request $request){
      $data = ViewRsTransactionTypesModel::where('rs_id', $request->id)->where('is_active', 1)->where('is_deleted', 0)->get();     
      if($data->count()) {
         return Response::json([
         'status' => '1',
         'rs_transaction_types' => $data               
         ]);
      } 
      else {
         return Response::json([
         'status' => '0'
         ]);
      } 
   }

   //show attached activities per rs (division input)
   public function show_attached_activities_by_rs(Request $request){          
      $data = ViewRSActivityModel::where('rs_id', $request->id)->where('is_active', '1')->where('is_deleted', '0')->get();          
      if($data->count()) {      
         return Response::json([
            'status' => '1',     
            'rs_activity' => $data,           
            'rowCount' => $data->count(),          
         ]);
      }
   }

   public function show_rs_by_month_year(Request $request) {
      //dd($request->all());
      $rs_type_id=$request->rs_type_id;
      $month_selected=$request->month_selected;
      $year_selected=$request->year_selected;
      $search=$request->search;
      if ($request->ajax() && isset($month_selected) && $month_selected != null && ($search == null || $search == '')) {
         $data = DB::table('view_rs_only')->where('rs_type_id', $rs_type_id)->whereMonth('rs_date', $month_selected)->whereYear('rs_date', $year_selected)
            ->where('id','!=', 39857)->where('id','!=', 39875)->where('id','!=', 39876)
            ->where('id','!=',40177)->where('id','!=',40178)->where('id','!=',40179)
            ->where('id','!=',40376)->where('id','!=',40377)->where('id','!=',40378)
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('rs_no', 'ASC')->get();
      }
      else if ($request->ajax() && isset($search) && $search != null) {
         $data = DB::table('view_rs_only')->
            where(function ($query) use ($search) {
               $query->where('payee','like','%'.$search.'%')
                  ->orWhere('id','like','%'.$search.'%')
                  ->orWhere('rs_no','like','%'.$search.'%');
            })
            ->where('id','!=', 39857)->where('id','!=', 39875)->where('id','!=', 39876)
 ->whereYear('rs_date', $year_selected)
            ->where('rs_type_id', $rs_type_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('rs_no', 'ASC')->get();
      }
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->addColumn('payee', function($row){
            $btn =
               "<a data-id='". $row->id ."' href='".url('funds_utilization/rs/budget/edit/'.$row->id)."'>
               ". $row->payee ."</a>";
            return $btn;
         })
         ->rawColumns(['payee'])
         ->make(true); 
   }

   public function show_rs_by_division_month_year(Request $request) {
      $rs_type_id=$request->rs_type_id;
      $division_id=$request->division_id;
      $month_selected=$request->month_selected;
      $year_selected=$request->year_selected;
      $search=$request->search;
      // dd($request->all());
      if ($request->ajax() && isset($month_selected) && $month_selected != null && ($search == null || $search == '')) {
         $data=DB::table('view_request_status')->select('view_request_status.*', 'view_rs_pap.allotment_division_id','view_rs_pap.allotment_division_acronym')
            ->leftJoin('view_rs_pap','view_request_status.id','=','view_rs_pap.rs_id')
            ->where('view_request_status.month',$month_selected)
            ->where('view_request_status.year',$year_selected)
            ->where('view_request_status.rs_type_id',$rs_type_id)
            ->where('view_request_status.is_active','=',1)
            ->where('view_request_status.is_deleted','=',0)
            ->where(function ($query) use ($division_id) {
               $query->where('view_request_status.division_id',$division_id)
                  ->orWhere('allotment_division_id',$division_id);
            })
            ->groupBy('id')->orderBy('rs_date', 'ASC')->orderBy('payee', 'ASC')->get(); 
      }
      else if ($request->ajax() && isset($search) && $search != null) {
         $data=DB::table('view_request_status')->select('view_request_status.*', 'view_rs_pap.allotment_division_id','view_rs_pap.allotment_division_acronym')
            ->leftJoin('view_rs_pap','view_request_status.id','=','view_rs_pap.rs_id')
            ->where(function ($query) use ($search) {
               $query->where('view_request_status.payee','like','%'.$search.'%')
                  ->orWhere('view_request_status.id','like','%'.$search.'%')
                  ->orWhere('view_request_status.rs_no','like','%'.$search.'%');
            })
            ->where(function ($query) use ($division_id) {
               $query->where('view_request_status.division_id',$division_id)
                  ->orWhere('allotment_division_id',$division_id);
            })
            ->where('view_request_status.rs_type_id',$rs_type_id)
            ->where('view_request_status.is_active','=',1)
            ->where('view_request_status.is_deleted','=',0)
            ->orderBy('rs_no', 'ASC')->get();
      }
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($rs) {
            return $rs->id;
            }
         ])
         ->addColumn('payee', function($row){
            $btn =
               "<a data-id='".$row->id."' href='".url('funds_utilization/rs/division/edit/'.$row->id)."'>
               ". $row->payee ."</a>";
            return $btn;
         })
         ->addColumn('action', function($row){
            $btn =
               "<div>               
                  <button data-id='". $row->id ."' class='btn-xs btn_delete btn btn-outline-danger' 
                     type='button' data-toggle='tooltip' data-placement='left' title='Delete RS'>
                     <i class='fa-solid fa-trash-can fa-lg'></i>
                  </button>
               </div>
               ";
            return $btn;
         })
         ->rawColumns(['payee'], ['action'])
         ->make(true); 
   }   

   public function print_page1($rs_id) {
      $rs_data = ViewRSModel::where('id', $rs_id)->get();
      $rs_activity = ViewRSActivityModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      $rs_documents = ViewRsDocumentModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get();      
      return \View::make('funds_utilization.rs.print_rs_p1')
         ->with('rs_data', $rs_data)
         ->with('rs_activity', $rs_activity)
         ->with('rs_documents', $rs_documents);
   }

   public function print_page2($rs_id) {
      $rs_data = ViewRSModel::where('id', $rs_id)->get();
      $rs_allotment = ViewRsPapModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      $rs_documents = ViewRsDocumentModel::where('rs_id', $rs_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      return \View::make('funds_utilization.rs.print_rs_p2')
         ->with('rs_data', $rs_data)
         ->with('rs_allotment', $rs_allotment)
         ->with('rs_documents', $rs_documents);
   }

}
