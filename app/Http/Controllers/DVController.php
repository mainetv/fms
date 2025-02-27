<?php

namespace App\Http\Controllers;

use App\Models\DVModel;
use App\Models\DvRsModel;
use App\Models\DvRsNetModel;
use App\Models\DvTransactionTypeModel;
use App\Models\LDDAPModel;
use App\Models\ModulesModel;
use App\Models\NotificationsModel;
use App\Models\RSModel;
use App\Models\ViewDvDocumentModel;
use App\Models\ViewDVModel;
use App\Models\ViewDvRsModel;
use App\Models\ViewDvRsNetModel;
use App\Models\ViewDvTransactionTypeModel;
use App\Models\ViewLibraryPayeesModel;
use App\Models\ViewLDDAPDVModel;
use App\Models\ViewLibraryDvTransactionTypesModel;
use App\Models\ViewRSModel;
use App\Models\ViewLibrarySignatoriesModel;
use App\Models\ViewRSbyPayeeModel;
use App\Models\ViewRsPapModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;
use Validator;
use Response;
use Barryvdh\DomPDF\Facade\Pdf;

class DVController extends Controller
{
   public function index(Request $request, $month_selected, $year_selected){    
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
      if($user_id==149 || $user_id==117){
         $user_division_id=3;
         $user_division_acronym='COA';
      }
      if($user_id=='20' || $user_id=='14'){
         $user_division_id = '9';
         $user_division_acronym='FAD-DO';
      }
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {    
         if (auth()->user()->hasAnyRole('Division Budget Controller|Division Director|Section Head')){
            $title = "dv"; 
				return view('funds_utilization.dv.division')
					->with(compact('title'), $title)
					->with(compact('data'), $data)
					->with(compact('username'), $username)
					->with(compact('user_id'), $user_id)
					->with(compact('user_role'), $user_role)
					->with(compact('user_role_id'), $user_role_id)
					->with(compact('user_division_id'), $user_division_id)
					->with(compact('user_division_acronym'), $user_division_acronym)
					->with(compact('user_fullname'), $user_fullname);  
         }
      }
   }

   public function index_all_division(Request $request, $month_selected, $year_selected){  
      $user_role_id = auth()->user()->user_role_id; 
      $user_id = auth()->user()->id;     
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $data = [
         "month_selected" => $month_selected,
         "year_selected" => $year_selected,
      ];   
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {     
         if (auth()->user()->hasAnyRole('Cash Officer')){
            $title = "alldivisiondv"; 
            return view('funds_utilization.dv.all_division')
               ->with(compact('title'), $title)
               ->with(compact('data'), $data)
               ->with(compact('user_id'), $user_id)
               ->with(compact('user_division_id'), $user_division_id);
         }         
      }
   }
      
   public function index_all(Request $request, $date_selected){    
      $user_role_id = auth()->user()->user_role_id; 
      $username = auth()->user()->username; 
      $user_id = auth()->user()->id;     
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();   
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();    
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {     
         if (auth()->user()->hasAnyRole('Super Administrator|Administrator|Accounting Officer')){                                
				$title = "alldv"; 
				return view('funds_utilization.dv.all', ['date_selected' => 'dv_date'])
					->with(compact('title'), $title)
					->with(compact('username'), $username)
					->with(compact('user_id'), $user_id)
					->with(compact('user_role'), $user_role)
					->with(compact('user_role_id'), $user_role_id)
					->with(compact('user_division_id'), $user_division_id)
					->with(compact('user_division_acronym'), $user_division_acronym)
					->with(compact('user_fullname'), $user_fullname)
					->with(compact('date_selected'), $date_selected);
                      
         }
      }
   }  

   public function edit(Request $request){
      $user_id = auth()->user()->id;       
      $user_role_id = auth()->user()->user_role_id; 
      $dv_id=$request->id;
      $getDvDetails =  ViewDVModel::where('id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      $dv_payee_id =  ViewDVModel::where('id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('payee_id')->first();       
      $title = "alldv";
      $getAttachedRSbyDV =  ViewDvRsModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->get();   
      $getAttachedRsNetbyDV =  ViewDvRsNetModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->groupBy('id')->get(); 
      $getAllRSbyPayee =  ViewRSModel::where('payee_id', $dv_payee_id)->where('is_active', 1)->where('is_deleted', 0)->get();   
      $getDvTransactionTypes = ViewLibraryDvTransactionTypesModel::where("is_active", 1)->where("is_deleted", 0)
         ->orderBy('transaction_type')->get();
      $getSelectedDvTransactionTypes = ViewDvTransactionTypeModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->get(); 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      // dd($getAttachedRsNetbyDV);
      return view('funds_utilization.dv.edit')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('title'))
         ->with(compact('getDvDetails'))
         ->with(compact('getAllRSbyPayee'))
         ->with(compact('getAttachedRSbyDV'))
         ->with(compact('getAttachedRsNetbyDV'))
         ->with(compact('user_division_id'))
         ->with(compact('getSelectedDvTransactionTypes'));     
   }

   public function edit_division(Request $request){     
      $user_id = auth()->user()->id;       
      $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
         ->where(function ($query) {
            $query->where('role_id','=',7)
               ->orWhere('role_id','=',6);
         })
         ->pluck('role_id')->first(); 
      $dv_id=$request->id;    
      $getPayees = ViewLibraryPayeesModel::where('is_verified', 1)->where("is_active", 1)->where("is_deleted", 0)->orderBy('payee')->get();             
      $getDvDetails =  ViewDVModel::where('id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      $dv_payee_id =  ViewDVModel::where('id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('payee_id')->first();       
      $title = "dv";
      $getAttachedRSbyDV =  ViewDvRsModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->get();   
      $getAttachedRsNetbyDV =  ViewDvRsNetModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->groupBy('id')->get(); 
      $getAllRSbyPayee =  ViewRSModel::where('payee_id', $dv_payee_id)->where('is_active', 1)->where('is_deleted', 0)->get();   
      $getDvTransactionTypes = ViewLibraryDvTransactionTypesModel::where("is_active", 1)->where("is_deleted", 0)
         ->orderBy('transaction_type')->get();
      $getSelectedDvTransactionTypes = ViewDvTransactionTypeModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->get(); 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      // dd($getAttachedRsNetbyDV);
      return view('funds_utilization.dv.division.edit')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('title'))
         ->with(compact('getDvDetails'))
         ->with(compact('getAllRSbyPayee'))
         ->with(compact('getAttachedRSbyDV'))
         ->with(compact('getAttachedRsNetbyDV'))
         ->with(compact('user_division_id'))
         ->with(compact('getSelectedDvTransactionTypes'));        
   }

   public function add(Request $request){          
      $user_id = auth()->user()->id;       
      $user_role_id = auth()->user()->user_role_id; 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();    
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();         
      $title = "dv";
      if($user_id==149 || $user_id==117){
         $user_division_id=3;
         $user_division_acronym='COA';
      }
      return view('funds_utilization.dv.add')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('user_division_id'))
         ->with(compact('user_division_acronym'))
         ->with(compact('title'));    
   }

   public function store(Request $request){
      if ($request->ajax()) { 
         // dd($request->all());
         $user_id = auth()->user()->id; 
         $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
         $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
         $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->pluck('role_id')->first();
         $now = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');      
         $dv_id = $request->dv_id;  
         $rs_id = $request->rs_id;  
         $dv_date = $request->dv_date;  
         $module_id = $request->module_id;  
         $signatory1 = $request->signatory1;
         $signatory2 = $request->signatory2;
         $get_signatory1_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory1)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();   
         $get_signatory2_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory2)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first(); 
         if($request->add_dv==1){
            $message = array(    
               'dv_date.required' => 'Please select date.',
               'fund_id.required' => 'Please select fund.',
               'payee_id.required' => 'Please select payee.',
            );
            $validator =  Validator::make($request->all(), [
               'dv_date' => 'required',
               'fund_id' => 'required',
               'payee_id' => 'required',
            ], $message);
      
            if ($validator->passes()) {
               $data = new DVModel([
                  'dv_date' => $dv_date,
                  'division_id' => $request->division_id,
                  'fund_id' => $request->fund_id,
                  'payee_id' => $request->payee_id,
                  'particulars' => $request->particulars,
                  'signatory1' => $signatory1,
                  'signatory1_position' => $get_signatory1_position,
                  'signatory2' => $signatory2,
                  'signatory2_position' => $get_signatory2_position,         
                  'po_no' => $request->po_no,         
                  'po_date' => $request->po_date,         
                  'invoice_no' => $request->invoice_no,         
                  'invoice_date' => $request->invoice_date,         
                  'jobcon_no' => $request->jobcon_no,         
                  'jobcon_date' => $request->jobcon_date,         
                  'or_no' => $request->or_no,         
                  'or_date' => $request->or_date,         
               ]);
               $data->save(); 
               $data->id;               
               $dv_transaction_type_id = $request->dv_transaction_type_id;
               if(isset($dv_transaction_type_id)){
                  $count = count($dv_transaction_type_id);  
                  for ($i=0; $i < $count; $i++) {   
                     $data1 = [
                        'dv_id' => $data->id,
                        'dv_transaction_type_id' => $dv_transaction_type_id[$i],
                     ];  
                     DvTransactionTypeModel::insert($data1);
                  }
               }

               $message = $user_division_acronym.' created new DV [ID: '.$data->id.']';                
               $get_link = ModulesModel::where('id', $module_id)
                  ->where('is_active', 1)->where('is_deleted', 0)->pluck('link')->first();
               $get_month =  DB::table('disbursement_vouchers')
                  ->selectRaw('month(dv_date) as month')->where('id', $data->id)->pluck('month')->first(); 
               $get_year =  DB::table('disbursement_vouchers')
                  ->selectRaw('year(dv_date) as year')->where('id', $data->id)->pluck('year')->first(); 
               $get_accounting_officer = ViewUsersHasRolesModel::where('role_id', 2)
                  ->where('id','!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->get();
               if($get_accounting_officer->count()!=0){
                  foreach($get_accounting_officer as $value){
                     $notification_to_accounting_officer[] =[
                        'message' => $message,
                        'record_id' => $data->id,
                        'module_id' => $module_id,
                        'month' => $get_month,
                        'year' => $get_year,
                        'date' => $dv_date,    
                        'link' => $get_link, 
                        'division_id' => $user_division_id,
                        'division_id_from' => $user_division_id,
                        'division_id_to' => $value->division_id,
                        'user_id_from' => $user_id,
                        'user_id_to' => $value->id,
                        'user_role_id_from' => $user_role_id ?? '7', 
                        'user_role_id_to' => '2', 
                     ]; 
                  }           
                  NotificationsModel::insert($notification_to_accounting_officer);
               } 

               return response()->json(array('success' => 1,'redirect_url' => route('dv.edit_division', [$data->id]),), 200); 
            }
            return Response::json(['errors' => $validator->errors()]);   
         }
         elseif($request->attach_rs==1){
            $data = new DvRsModel([
               'dv_id' => $dv_id,
               'rs_id' => $rs_id,      
            ]);            
            $data->save(); 
            $data->id;

            //insert to dvrsnet
            $data1 = new DvRsNetModel([
               'dv_id' => $dv_id,
               'rs_id' => $rs_id,           
            ]);  
            $data1->save(); 

            $get_rs_particulars = RSModel::where('id', $rs_id)->pluck('particulars')->first();
            DVModel::find($dv_id)
               ->update([   
                  'dv_date' => $dv_date,                
                  'payee_id' => $request->payee_id,                
                  'fund_id' => $request->fund_id,        
                  'particulars' => $get_rs_particulars,                
               ]);             
            return response()->json(array('success' => 1,'dv_rs_id' => $data->id), 200); 
         }
         elseif($request->attach_rs_net==1){
            $dv_rs_net = DvRsNetModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->get();
            $allotment_class_id = ViewRsPapModel::where('rs_id', $rs_id)
               ->where('is_active', 1)->where('is_deleted', 0)->pluck('allotment_class_id')->first();
            // dd($request->all());
            if($dv_rs_net->count() == 0){
               $total_dv_gross_amount = $request->total_dv_gross_amount;
               DVModel::find($dv_id)
               ->update([   
                  'is_locked' => '1',
                  'locked_at' => $now,                             
               ]);
            }
            $data = new DvRsNetModel([
               'dv_id' => $dv_id,
               'rs_id' => $rs_id,      
               'gross_amount' => $total_dv_gross_amount ?? 0,      
               'net_amount' => $total_dv_gross_amount ?? 0,      
               'allotment_class_id' => $allotment_class_id,      
            ]);  
            $data->save(); 
            $data->id;

            DVModel::find($dv_id)
            ->update([    
               'total_dv_gross_amount' => $total_dv_gross_amount ?? 0, 
               'total_dv_net_amount' => $total_dv_gross_amount ?? 0,                             
            ]);

            return response()->json(array('success' => 1,'dv_rs_id' => $data->id), 200); 
         }
      }
   }

   public function delete(Request $request){
      if($request->ajax()) {
         // dd($request->all());
         $id=$request->id;
         $dv_id=$request->dv_id;
         $rs_id=$request->rs_id;
         $lddap_id=$request->lddap_id;
         if($request->delete_dv==1) {
            try {     
               DVModel::find($id)
                  ->update([
                  'is_deleted' => '1'
               ]);
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
         elseif($request->remove_attached_rs==1){            
            try {     
               DvRsModel::find($id)
                  ->update([
                  'is_deleted' => '1'
               ]);

               DvRsNetModel::where('dv_id', $dv_id)->where('rs_id',$rs_id)
                  ->update([
                  'is_deleted' => '1'
               ]);

               $get_total_dv_gross_amount=DvRsModel::where('dv_id', $dv_id)
               ->where('is_active',1)->where('is_deleted',0)->sum('amount');

               DVModel::find($dv_id)
                  ->update([
                  'total_dv_gross_amount' => $get_total_dv_gross_amount,
                  'total_dv_net_amount' => $get_total_dv_gross_amount,
               ]);
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
         elseif($request->remove_attached_rs_net==1){
            try {     
               DvRsNetModel::find($id)
                  ->update([
                  'is_deleted' => '1'
               ]);

               $get_total_dv_gross_amount=DvRsNetModel::where('dv_id', $dv_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('gross_amount');
               $get_total_dv_net_amount=DvRsNetModel::where('dv_id', $dv_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('net_amount');
                  // dd($get_total_dv_net_amount);
               DVModel::find($dv_id)
                  ->update([
                  'total_dv_gross_amount' => $get_total_dv_gross_amount,
                  'total_dv_net_amount' => $get_total_dv_net_amount,
               ]);

               $get_total_ddap_gross_amount=ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('total_dv_gross_amount');
               $get_total_lddap_net_amount=ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('total_dv_net_amount');

               if($lddap_id!=NULL){
                  LDDAPModel::find($lddap_id)
                     ->update([ 
                        'total_ddap__gross_amount'=>$get_total_ddap_gross_amount,
                        'total_lddap_net_amount'=>$get_total_lddap_net_amount,
                     ]); 
               }                  
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
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
      }
   }

   public function show(Request $request){
      $data = ViewDVModel::find($request->id);     
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

   public function update(Request $request, DVModel $dVModel){
      if($request->ajax()) { 
         // dd($request->all());
         $dv_id = $request->dv_id;             
         $lddap_id = $request->lddap_id;                 
         $dv_rs_id = $request->dv_rs_id;                 
         $rs_id = $request->rs_id;                                 
         $dv_rs_amount=removeComma($request->dv_rs_amount);
         $gross_amount=removeComma($request->gross_amount);        
         $tax_one=removeComma($request->tax_one);
         $tax_two=removeComma($request->tax_two);
         $tax_twob=removeComma($request->tax_twob);
         $tax_three=removeComma($request->tax_three);
         $tax_five=removeComma($request->tax_five);
         $tax_six=removeComma($request->tax_six);        
         $wtax=removeComma($request->wtax);        
         $other_tax=removeComma($request->other_tax);        
         $liquidated_damages=removeComma($request->liquidated_damages);        
         $other_deductions=removeComma($request->other_deductions);  
         $net_amount=removeComma($request->net_amount);      
         $signatory1 = $request->signatory1;
         $signatory2 = $request->signatory2;
         $get_signatory1_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory1)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();   
         $get_signatory2_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory2)
            ->where("is_active", 1)->where("is_deleted", 0)->pluck('position')->first();     
         if($request->edit_dv==1){  
            $message = array(    
               'dv_date.required' => 'Please select date.',
               'fund_id.required' => 'Please select fund.',
               'payee_id.required' => 'Please select payee.',
            );
            $validator =  Validator::make($request->all(), [
               'dv_date' => 'required',
               'fund_id' => 'required',
               'payee_id' => 'required',
            ], $message);
                  
            if ($validator->passes()) {
               if(isset($dv_rs_id)){                  
                  $rs_count = count($dv_rs_id);  
                  for ($i=0; $i < $rs_count; $i++) {   
                     DvRsModel::find($dv_rs_id[$i])
                        ->update([ 
                           'amount'=>$dv_rs_amount[$i],
                        ]); 
                     $allotment_class_id = ViewRsPapModel::where('rs_id', $rs_id)
                         ->where('is_active', 1)->where('is_deleted', 0)->pluck('allotment_class_id')->first();
                     //update dvrsnet       
                     DvRsNetModel::where(['dv_id'=>$dv_id,'rs_id'=>$rs_id[$i], 'is_active'=>1, 'is_deleted'=>0])
                        ->update([ 
                           'gross_amount'=>$dv_rs_amount[$i],                        
                           'net_amount'=>$dv_rs_amount[$i],
                           'allotment_class_id'=>$allotment_class_id,
                        ]); 
                  }      
               }               
               $get_total_dv_gross_amount = DvRsModel::where('dv_id', $dv_id)
                  ->where("is_active", 1)->where("is_deleted", 0)->sum('amount');          
               DVModel::find($dv_id)
                  ->update([     
                     'dv_date' => $request->dv_date,
                     'fund_id' => $request->fund_id,
                     'payee_id' => $request->payee_id,
                     'particulars' => $request->particulars,
                     'total_dv_gross_amount' => $get_total_dv_gross_amount,
                     'total_dv_net_amount' => $get_total_dv_gross_amount,
                     'signatory1' => $signatory1,
                     'signatory1_position' => $get_signatory1_position,
                     'signatory2' => $signatory2,
                     'signatory2_position' => $get_signatory2_position,           
                     'po_no' => $request->po_no,           
                     'po_date' => $request->po_date,                      
                     'invoice_no' => $request->invoice_no,                      
                     'invoice_date' => $request->invoice_date,                      
                     'jobcon_no' => $request->jobcon_no,                      
                     'jobcon_date' => $request->jobcon_date,                      
                     'or_no' => $request->or_no,                      
                     'or_date' => $request->or_date,                      
                  ]);     
                  $dv_transaction_type_id = $request->dv_transaction_type_id;
                  $get_dv_transaction_type = DvTransactionTypeModel::where('dv_id', $dv_id)
                     ->where('is_active', 1)->where('is_deleted', 0)->get();
                  if($get_dv_transaction_type->count() > 0){    
                     DvTransactionTypeModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)
                        ->update([     
                           'is_active' => 0,                                 
                           'is_deleted' => 1,                                 
                        ]);  
                  } 
                  if(isset($dv_transaction_type_id)){
                     $count = count($dv_transaction_type_id);  
                     for ($i=0; $i < $count; $i++) {   
                        $data1 = [
                           'dv_id' => $request->dv_id,
                           'dv_transaction_type_id' => $dv_transaction_type_id[$i],
                        ];  
                        DvTransactionTypeModel::insert($data1);
                     }
                  }    
               return response()->json(array('success' => 1, 200)); 
            }             
            return Response::json(['errors' => $validator->errors()]);
         }
         else if($request->update_dv==1){               
            $message = array(    
               'dv_date1.required' => 'Please select date.',  
            );
            $validator =  Validator::make($request->all(), [
               'dv_date1' => 'required',
            ], $message);
                  
            if ($validator->passes()) {
               if(isset($dv_rs_id)){                  
                  $rs_count = count($dv_rs_id); 
                  for ($i=0; $i < $rs_count; $i++) {   
                     DvRsNetModel::find($dv_rs_id[$i])
                        ->update([ 
                           'gross_amount'=>$gross_amount[$i],
                           'tax_one'=>$tax_one[$i],
                           'tax_two'=>$tax_two[$i],
                           'tax_twob'=>$tax_twob[$i],
                           'tax_three'=>$tax_three[$i],
                           'tax_five'=>$tax_five[$i],
                           'tax_six'=>$tax_six[$i],
                           'wtax'=>$wtax[$i],
                           'other_tax'=>$other_tax[$i],
                           'liquidated_damages'=>$liquidated_damages[$i],
                           'other_deductions'=>$other_deductions[$i],
                           'net_amount'=>$net_amount[$i],
                        ]);       
                  }  
               }
               $get_total_dv_gross_amount = DvRsNetModel::where('dv_id', $dv_id)
                  ->where("is_active", 1)->where("is_deleted", 0)->sum('gross_amount');
               $get_total_dv_net_amount = DvRsNetModel::where('dv_id', $dv_id)
                  ->where("is_active", 1)->where("is_deleted", 0)->sum('net_amount');      
               DVModel::find($dv_id)
                  ->update([     
                     'dv_no' => $request->dv_no,
                     'dv_date1' => $request->dv_date1,
                     'particulars' => $request->particulars,           
                     'total_dv_gross_amount' => $get_total_dv_gross_amount ?? 0,           
                     'total_dv_net_amount' => $get_total_dv_net_amount ?? 0,           
                     'tax_type_id' => $request->tax_type_id,           
                     'pay_type_id' => $request->pay_type_id,  
                     'po_no' => $request->po_no,           
                     'po_date' => $request->po_date,                      
                     'invoice_no' => $request->invoice_no,                      
                     'invoice_date' => $request->invoice_date,                      
                     'jobcon_no' => $request->jobcon_no,                      
                     'jobcon_date' => $request->jobcon_date,                      
                     'or_no' => $request->or_no,                      
                     'or_date' => $request->or_date,           
                     'is_locked' => $request->is_locked,               
                  ]);                   

               $get_total_lddap_gross_amount=ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('total_dv_gross_amount');
               $get_total_lddap_net_amount=ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                  ->where('is_active',1)->where('is_deleted',0)->sum('total_dv_net_amount');	
               if(isset($lddap_id)){
                  LDDAPModel::find($lddap_id)
                     ->update([ 
                        'total_lddap_gross_amount'=>$get_total_lddap_gross_amount,
                        'total_lddap_net_amount'=>$get_total_lddap_net_amount,
                     ]);      
               }           
               return response()->json(array('success' => 1, 200)); 
            }    
            return Response::json(['errors' => $validator->errors()]);
         }
         else if($request->edit_attached_rs==1){   
            DvRsModel::find($dv_rs_id)
               ->update([ 
                  'rs_id'=>$request->rs_id 
               ]); 
            return response()->json(array('success' => 1, 200)); 
         }
         else if($request->edit_attached_rs_net==1){  
            DvRsNetModel::find($dv_rs_id)
               ->update([ 
                  'rs_id'=>$request->rs_id 
               ]); 
            return response()->json(array('success' => 1, 200)); 
      }
      }  
   }
   
   public function generate_dv_no(Request $request){   
      if($request->ajax()) { 
         $user_id = auth()->user()->id; 
         $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
         $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
         $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->pluck('role_id')->first();
         $module_id = $request->module_id;  
         $division_id = $request->division_id;          
         $now = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');	
         $today = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');	         
         $year_now = Carbon::now()->year;                     
         $dv_id=$request->dv_id; 
         $year=$request->year; 
         $lastDay = Carbon::createFromDate($year, 12, 31);    
         if ($lastDay->isWeekend()) {
            // If it's a weekend, adjust to the nearest previous weekday
            $lastDay = $lastDay->previousWeekday();            
         } 
         $next_year=$year+1;
         $last_dv_id = DVModel::where(function ($query) use($year,$next_year) {
            $query->where(function ($query) use($year,$next_year){
                  $query->whereYear('dv_date1','=',$next_year)
                     ->whereYear('dv_date','=',$year);
               })
               ->orWhere(function ($query) use($year,$next_year) {
                  $query->whereYear('dv_date1','=',$year)
                     ->whereYear('dv_date','=',$year);
               });
            })
            ->where('is_active', 1)->where('is_deleted', 0)
            ->orderByRaw('CAST(dv_no AS UNSIGNED) desc, dv_no desc')->limit(1)->pluck('dv_no')->first();               
         $dv_no = $last_dv_id + 1;
         if($year_now == $year){
            DVModel::find($dv_id)
            ->update([ 
               'dv_date1'=>$today,
               'dv_no'=>$dv_no,
               'is_locked'=> 1, 
               'locked_at'=> $now, 
            ]); 
         }
         else{
            DVModel::find($dv_id)
            ->update([ 
               'dv_date1'=>$lastDay->format('Y-m-d'),
               'dv_no'=>$dv_no,
               'is_locked'=> 1, 
               'locked_at'=> $now, 
            ]); 
         }          
         $message = $user_division_acronym.' updated the DV [ID: '.$dv_id.']';          
         $get_link = ModulesModel::where('id', $module_id)
            ->where('is_active', 1)->where('is_deleted', 0)->pluck('link')->first();
         $get_month =  DB::table('request_status')
            ->selectRaw('month(rs_date) as month')->where('id', $dv_id)->pluck('month')->first(); 
         $get_year =  DB::table('request_status')
            ->selectRaw('year(rs_date) as year')->where('id', $dv_id)->pluck('year')->first(); 
         $get_division_budget_controller = ViewUsersHasRolesModel::where('role_id', 7)->where('division_id', $division_id)
            ->where('id','!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->get(); 
         if($get_division_budget_controller->count() > 0){               
            foreach($get_division_budget_controller as $value){
               $notification_budget_controller[] =[
                  'message' => $message,
                  'record_id' => $dv_id,
                  'module_id' => $module_id,
                  'month' => $get_month,
                  'year' => $get_year,  
                  'link' => $get_link, 
                  'division_id' => $division_id,
                  'division_id_from' => $user_division_id,
                  'division_id_to' => $value->division_id,
                  'user_id_from' => $user_id,
                  'user_id_to' => $value->id,
                  'user_role_id_from' => $user_role_id ?? '2', 
                  'user_role_id_to' => '7', 
               ]; 
            }                
            NotificationsModel::insert($notification_budget_controller);
         }
         return response()->json(array('success' => 1, 200));      
      }
   }

   public function show_dv_transaction_type(Request $request){
      $data = ViewDvTransactionTypeModel::where('dv_id', $request->id)->where('is_active', 1)->where('is_deleted', 0)->get();     
      if($data->count()) {
         return Response::json([
         'status' => '1',
         'dv_transaction_types' => $data               
         ]);
      } 
      else {
         return Response::json([
         'status' => '0'
         ]);
      } 
   }

   public function show_attached_rs_by_dv(Request $request) {
      if ($request->ajax() && isset($request->all()['dv_id']) && $request->all()['dv_id'] != null) {
         if(isset($request->all()['dv_id'])) {
            $data = ViewDvRsModel::where('dv_id', $request->dv_id)->where('is_active', 1)->where('is_deleted', 0)->get();
         } 
         return DataTables::of($data)
            ->setRowAttr([
               'data-id' => function($dv_rs) {
               return $dv_rs->id;
               }
            ])
            ->addColumn('action', function($row){
               $btn = "  
                  <button data-id='". $row->id ."' class='btn_remove_rs' type='button' data-toggle='tooltip' 
                     data-placement='auto' title='Remove attached request and status'>
                   <i class='fa-regular fa-square-minus red'></i>
                  </button>";
                 return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      $data =  ViewDvRsModel::where('dv_id', '')->where('is_active', 1)->where('is_deleted', 0)->get();
      return DataTables::of($data)
            ->make(true);
   }

   public function show_attached_rsnet_by_dv(Request $request) {
      if ($request->ajax() && isset($request->all()['dv_id']) && $request->all()['dv_id'] != null) {
         if(isset($request->all()['dv_id'])) {
            $data = ViewDvRsModel::where('dv_id', $request->dv_id)->where('is_active', 1)->where('is_deleted', 0)->get();
         } 
         return DataTables::of($data)
            ->setRowAttr([
               'data-id' => function($dv_rs) {
               return $dv_rs->id;
               }
            ])
            ->addColumn('action', function($row){
               $btn = "  
                  <button data-id='". $row->id ."' class='btn_remove_rs' type='button' data-toggle='tooltip' 
                     data-placement='auto' title='Remove attached request and status'>
                   <i class='fa-regular fa-square-minus red'></i>
                  </button>";
                 return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      $data =  ViewDvRsModel::where('dv_id', '')->where('is_active', 1)->where('is_deleted', 0)->get();
      return DataTables::of($data)
            ->make(true);
   }

   public function show_rs_by_dv(Request $request) {
      if ($request->ajax() && isset($request->all()['dv_id']) && $request->all()['dv_id'] != null) {
         if(isset($request->all()['dv_id'])) {
            $data = ViewDvRsModel::where('dv_id', $request->dv_id)->whereNotNull('rs_no')
               ->where('is_active', 1)->where('is_deleted', 0)->get();
         } 
         if($request->attach_rs_net==1){
            return DataTables::of($data)
               ->setRowAttr([
                  'data-id' => function($dv_rs) {
                  return $dv_rs->rs_id;
                  }
               ])
               ->addColumn('rs_id', function($row){
                  $btn =
                  "     
                  <a href='#' data-rs-id='". $row->rs_id ."' class='attach_rs_net'>". $row->rs_id ."</a>
                  
                  ";
                  return $btn;
               })
               ->rawColumns(['rs_id'])
               ->make(true);
         }
         else if($request->edit_attached_rs_net==1){
            return DataTables::of($data)
               ->setRowAttr([
                  'data-id' => function($dv_rs) {
                  return $dv_rs->rs_id;
                  }
               ])
               ->addColumn('rs_id', function($row){
                  $btn =
                  "     
                  <a href='#' data-rs-id='". $row->rs_id ."' class='edit_attached_rs_net'>". $row->rs_id ."</a>
                  
                  ";
                  return $btn;
               })
               ->rawColumns(['rs_id'])
               ->make(true);
         }
      }
   }

   public function show_rs_by_payee(Request $request) {
      $payee_id=$request->payee_id;
      $fund_id=$request->fund_id;
      if ($request->ajax() && isset($payee_id) && $payee_id != null) {
         if(isset($payee_id) && $payee_id!=3288 && $payee_id!=3289 && $payee_id!=3290 && $payee_id!=3616 && $payee_id!=3617 && $payee_id!=3618 && $payee_id!=3619 && $payee_id!=3620 && $payee_id!=3622 && $payee_id!=2789 && $payee_id!=3223 && $payee_id!=2623 && $payee_id!=2738 && $payee_id!=3267 && $payee_id!=2608 && $payee_id!=2754 && $payee_id!=3221 && $payee_id!=3268 && $payee_id!=3655 && $payee_id!=3656) {
            $data = ViewRSbyPayeeModel::where('fund_id', $fund_id)
               ->where(function ($query) use ($payee_id) {
                  $query->where('payee_id',$payee_id)
                     ->orWhere('payee_id','2738');
               })
            ->where('is_active', 1)->where('is_deleted', 0)->groupBy('id')->orderBy('id', 'DESC')->get(); 
         } 
         else if(isset($payee_id) && ($payee_id==3288 || $payee_id==3289 || $payee_id==3290 || $payee_id==3616 || $payee_id==3617 || $payee_id==3618 || $payee_id==3619 || $payee_id==3620 || $payee_id==3622 || $payee_id==2789 || $payee_id==3223 || $payee_id==2623 || $payee_id==2738 || $payee_id==3267 || $payee_id==2608 || $payee_id==2754 || $payee_id==3221 || $payee_id==3268 || $payee_id==3655 || $payee_id=3656)) {
            $data = ViewRSbyPayeeModel::where('fund_id', $fund_id)
               // ->where(function ($query) {
               //    $query->where('payee_id',3288)
               //       ->orWhere('payee_id',3289)
               //       ->orWhere('payee_id',3290)
               //       ->orWhere('payee_id',3616)
               //       ->orWhere('payee_id',3617)
               //       ->orWhere('payee_id',3618)
               //       ->orWhere('payee_id',3619)
               //       ->orWhere('payee_id',3620)
               //       ->orWhere('payee_id',3622)
               //       ->orWhere('payee_id',2789)
               //       ->orWhere('payee_id',3223)
               //       ->orWhere('payee_id',2623)
               //       ->orWhere('payee_id',2738)
               //       ->orWhere('payee_id',3267)
               //       ->orWhere('payee_id',2608)
               //       ->orWhere('payee_id',2754)
               //       ->orWhere('payee_id',3221)
               //       ->orWhere('payee_id',3656)
               //       ->orWhere('payee_id',3268);
               // })
               ->where('is_active', 1)->where('is_deleted', 0)->groupBy('id')->orderBy('id', 'DESC')->get();            
         } 
         if($request->attach_rs==1){
            return DataTables::of($data)
               ->setRowAttr([
                  'data-id' => function($dv_rs) {
                  return $dv_rs->id;
                  }
               ])
               ->addColumn('rs_id', function($row){
                  $btn =
                  "     
                  <a href='#' data-rs-id='". $row->id ."' class='attach_rs'>". $row->id ."</a>
                  
                  ";
                  return $btn;
               })
               ->rawColumns(['rs_id'])
               ->make(true);
         }
         else if($request->edit_attached_rs==1){
            return DataTables::of($data)
               ->setRowAttr([
                  'data-id' => function($dv_rs) {
                  return $dv_rs->id;
                  }
               ])
               ->addColumn('rs_id', function($row){
                  $btn =
                  "     
                  <a href='#' data-rs-id='". $row->id ."' class='edit_attached_rs'>". $row->id ."</a>
                  
                  ";
                  return $btn;
               })
               ->rawColumns(['rs_id'])
               ->make(true);
         }         
      }
   }

   public function show_dv_by_date(Request $request) {
      $date_selected=$request->date_selected;
      $search=$request->search;
      $accounting=$request->accounting;
      if ($request->ajax() && isset($date_selected) && $date_selected != null && ($search == null || $search == '')) {
         if($accounting==1){
            $data = ViewDVModel::where('dv_date1', $date_selected)
               ->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_no', 'ASC')->groupBy('id')->get();
         }
         else{
            $data = ViewDVModel::where('dv_date', $date_selected)
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_no', 'ASC')->groupBy('id')->get();
         }
      }
      else if ($request->ajax() && isset($search) && $search != null) {
         $data = ViewDVModel::
            where(function ($query) use ($search) {
               $query->where('payee','like','%'.$search.'%')
                  ->orWhere('id','like','%'.$search.'%')
                  ->orWhere('dv_no','like','%'.$search.'%')
                  ->orWhere('po_no','like','%'.$search.'%')
                  ->orWhere('lddap_no','like','%'.$search.'%');
            })
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_no', 'ASC')->groupBy('id')->get();
      }
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($dv) {
            return $dv->id;
            }
         ])
         ->addColumn('payee', function($row){
            $btn =
               "<a data-id='". $row->id ."' data-user-role-id='".$row->user_role_id."' href='".url('funds_utilization/dv/accounting/edit/'.$row->id)."'>
               ". $row->payee ."</a>";
            return $btn;
         })
         ->rawColumns(['payee'])
         ->make(true);
      
   }

   public function show_dv_by_month_year(Request $request) {
      $month_selected=$request->month_selected;
      $year_selected=$request->year_selected;
      $search=$request->search;
      // dd($request->all());
      if ($request->ajax() &&  ($search == null || $search == '')) {
         $data = ViewDVModel::whereMonth('dv_date', $month_selected)->whereYear('dv_date', $year_selected)
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_no', 'ASC')->get();
      }
      else if ($request->ajax() && ($search != null || $search != '')) {
         $data = ViewDVModel::
            where(function ($query) use ($search) {
               $query->where('payee','like','%'.$search.'%')
                  ->orWhere('id','like','%'.$search.'%')
                  ->orWhere('dv_no','like','%'.$search.'%')
                  ->orWhere('po_no','like','%'.$search.'%')
                  ->orWhere('lddap_no','like','%'.$search.'%');
            })
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_no', 'ASC')->get();
      }
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($dv) {
            return $dv->id;
            }
         ])
         ->make(true);     
   }

   public function show_dv_by_division_month_year(Request $request) {
      $division_id=$request->division_id;
      $month_selected=$request->month_selected;
      $year_selected=$request->year_selected;
      $search=$request->search;
      $user_id = auth()->user()->id; 
      // dd($user_id);    
      // dd($request->all());    
      if ($request->ajax() && ($search == null || $search == '')) {        
         $data = ViewDVModel::where('division_id', $division_id)->whereMonth('dv_date', $month_selected)->whereYear('dv_date', $year_selected)
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_no', 'ASC')->get();
      } 
      else if ($request->ajax() && ($search != null || $search != '')) {
         $data = ViewDVModel::
            where(function ($query) use ($search) {
               $query->where('payee','like','%'.$search.'%')
                  ->orWhere('id','like','%'.$search.'%')
                  ->orWhere('dv_no','like','%'.$search.'%')
                  ->orWhere('po_no','like','%'.$search.'%')
                  ->orWhere('lddap_no','like','%'.$search.'%');
            })
            ->where('division_id', $division_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_no', 'ASC')->get();
      }
      // dd($data);
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($dv) {
            return $dv->id;
            }
         ])
         ->addColumn('payee', function($row){
            $btn =
               "<a data-id='". $row->id ."' data-user-role-id='".$row->user_role_id."' href='".url('funds_utilization/dv/dvdivision/edit/'.$row->id)."'>
               ". $row->payee ."</a>";
            return $btn;
         })
         // ->addColumn('action', function($row){
         //    $btn =
         //       "<div>               
         //          <button data-id='". $row->id ."' class='btn-xs btn_delete btn btn-outline-danger' 
         //             type='button' data-toggle='tooltip' data-placement='left' title='Delete DV'>
         //             <i class='fa-solid fa-trash-can fa-lg'></i>
         //          </button>
         //       </div>
         //       ";
         //    return $btn;
         // })
         // ->rawColumns(['payee'], ['action'])
         ->rawColumns(['payee'])
         ->make(true);           
   }

   // public function print(Request $request) {
   public function print($dv_id) {
      // $dv_id=$request->dv_id;
      $dv_data = ViewDVModel::where('id', $dv_id)->get();
      $total_dv_amount = DB::table('view_dv_rs')->select(DB::raw("SUM(dv_amount) as 'total_dv_amount' "))
         ->where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('total_dv_amount')->first();
      $dv_rs = ViewDvRsModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      $dv_documents = ViewDvDocumentModel::where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      $now=Carbon::now()->setTimezone('Asia/Manila')->format('l jS \of F Y h:i:s A'); 
      // $data = [
      //    'dv_data' => $dv_data,
      //    'total_dv_amount' => $total_dv_amount,
      //    'dv_rs' => $dv_rs,
      //    'dv_documents' => $dv_documents,
      // ];

      return \View::make('funds_utilization.dv.print')
         ->with('now', $now)
         ->with('dv_data', $dv_data)
         ->with('total_dv_amount', $total_dv_amount)
         ->with('dv_rs', $dv_rs)
         ->with('dv_documents', $dv_documents);
      // $pdf = Pdf::loadView('pdf.invoice', $dv_data);
      // return $pdf->download('invoice.pdf');
   }

   public function show_all_dvs(Request $request) {
      if($request->attach_dv_lddap==1){
         // dd($request->attach_dv_lddap);
         if ($request->ajax() && isset($request->all()['fund_id']) && $request->all()['fund_id'] != null) {         
            $data = ViewDVModel::where('fund_id', $request->fund_id)
               ->whereNull('lddap_id')->whereNull('ada_check_no')
               ->where(function ($query) {
                     $query->whereNotNull('dv_no')
                        ->orWhere('dv_no','!=',' ');
               })
               ->where('is_active', 1)->where('is_deleted', 0)
               ->orderByRaw('CAST(dv_no AS UNSIGNED) asc, dv_no asc')->get();   
            return DataTables::of($data)
               ->setRowAttr([
                  'data-id' => function($dv) {
                  return $dv->id;
                  }
               ])
               ->addColumn('dv_id', function($row){
                  $btn =
                  "     
                  <a href='#' data-dv-id='". $row->id ."' class='attach_dv'>". $row->id ."</a>                  
                  ";
                  return $btn;
               })
               ->rawColumns(['dv_id'])
               ->make(true);      
         }
      }
      elseif($request->attach_dv_check==1){                 
         $data = ViewDVModel::where(function ($query) use ($request) {
            $query->whereYear('dv_date1', $request->year)
                  ->orWhereYear('dv_date1', $request->year - 1); // Include previous year
            })
            ->whereNull('lddap_id')->whereNull('ada_check_no')
            ->where(function ($query) {
                  $query->whereNotNull('dv_no')
                     ->orWhere('dv_no','!=',' ');
            })            
            ->where('is_active', 1)->where('is_deleted', 0)
            ->orderByRaw('CAST(dv_no AS UNSIGNED) asc, dv_no asc')->get();  
         if($request->add_check==1){
            return DataTables::of($data)
               ->setRowAttr([
                  'data-id' => function($dv) {
                  return $dv->id;
                  }
               ])
               ->addColumn('dv_id', function($row){
                  $btn =
                  "     
                  <a href='#' data-dv-id='". $row->id ."' class='add_check_attach_dv'>". $row->id ."</a>                  
                  ";
                  return $btn;
               })
               ->rawColumns(['dv_id'])
               ->make(true); 
         }
         else{
            return DataTables::of($data)
               ->setRowAttr([
                  'data-id' => function($dv) {
                  return $dv->id;
                  }
               ])
               ->addColumn('dv_id', function($row){
                  $btn =
                  "     
                  <a href='#' data-dv-id='". $row->id ."' class='attach_dv'>". $row->id ."</a>                  
                  ";
                  return $btn;
               })
               ->rawColumns(['dv_id'])
               ->make(true); 
         }
      }
   }
}
