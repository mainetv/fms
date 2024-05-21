<?php

namespace App\Http\Controllers;

use App\Models\ChecksModel;
use App\Models\DivisionsModel;
use App\Models\DVModel;
use App\Models\FiscalYearsModel;
use App\Models\FundsModel;
use App\Models\LibraryBankAccountsModel;
use App\Models\ViewChecksModel;
use App\Models\ViewCheckDVModel;
use App\Models\ViewDVModel;
use App\Models\ViewLibrarySignatoriesModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use Response;

class ChecksController extends Controller
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
      $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
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
      
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {    
         $title = "Checks"; 
         return view('funds_utilization.checks.all')
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
            ->with(compact('year_selected'), $year_selected)
            ->with(compact('years'), $years)
            ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
            ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical);  
      }
   }

   public function add(Request $request){          
      $user_id = auth()->user()->id;       
      $user_role_id = auth()->user()->user_role_id; 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $getFunds = FundsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fund')->get();           
      $getBankAccounts = LibraryBankAccountsModel::where("is_active", 1)->where("is_deleted", 0)->get();      
      // dd($getBankAccounts);
      $getLDDAPSignatories = ViewLibrarySignatoriesModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fullname_first')->get();
      $title = "Add Check";
      return view('funds_utilization.checks.add')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('user_division_id'))
         ->with(compact('title'))
         ->with(compact('getLDDAPSignatories'))
         ->with(compact('getFunds'))
         ->with(compact('getBankAccounts'));
   }
   
   public function edit(Request $request){        
      $user_id = auth()->user()->id;       
      $user_role_id = auth()->user()->user_role_id; 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $check_id=$request->id;
      $check_date=$request->date;	
      $getAttachedDVbyCheckDatebyBankAccount =  ViewCheckDVModel::where('check_date', $check_date)
         ->where('is_active', 1)->where('is_deleted', 0)->groupBy('bank_account_id')->get();	
      $title = "Edit Check";
      return view('funds_utilization.checks.edit')
         ->with(compact('user_id'))
         ->with(compact('user_role_id'))
         ->with(compact('user_division_id'))
         ->with(compact('title'))
         ->with(compact('check_date'))
         ->with(compact('getAttachedDVbyCheckDatebyBankAccount'));
   }

   public function store(Request $request){
      if ($request->ajax()) { 
         // dd($request->all());       
         $check_date=$request->check_date;         
         $dv_id=$request->dv_id;         
         if($request->add_check_attach_dv==1){
            $message = array(    
               'check_date.required' => 'Please select check date.',
            );
            $validator =  Validator::make($request->all(), [
               'check_date' => 'required',
            ], $message);
      
            if ($validator->passes()) {
               $get_fund_id = DVModel::where('id', $dv_id)->pluck('fund_id')->first();
               $get_default_bank_account=LibraryBankAccountsModel::where('fund_id', $get_fund_id)
                  ->where('is_default', 1)->where('is_active', 1)->where('is_deleted', 0)
                  ->pluck('id')->first();   
                  
               $data = new ChecksModel([
                  'dv_id' => $dv_id,
                  'check_date' => $check_date,
                  'fund_id' => $get_fund_id,      
                  'bank_account_id' => $get_default_bank_account ?? NULL,      
               ]);
               // dd($data);
               $data->save(); 
               $data->id;    

               DVModel::find($dv_id)
                  ->update([ 
                     'check_id'=> $data->id,
                  ]);  

               return response()->json(array('success' => 1,'redirect_url' => route('checks.edit', [$check_date]),), 200);
            }
            return Response::json(['errors' => $validator->errors()]);   
         }
         elseif($request->attach_dv==1){           
            $data = new ChecksModel([
               'dv_id' => $request->get('dv_id'),
               'check_date' => $check_date,
               'fund_id' => $request->get('fund_id'),
               'bank_account_id' => $request->get('bank_account_id'),
               'acic_id' => $request->get('acic_id'),
               'net_amount' => $request->get('net_amount'),       
            ]);
            $data->save(); 
            $data->id;    
            return response()->json(array('success' => 1, 200));
            // return Response::json();   
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
      // dd($request->all());
      if($request->ajax()) {     
         $dv_id = $request->dv_id;  
         $dv_check_id = $request->dv_check_id;  
         $check_date = $request->check_date;  
         $date_released = $request->date_released;          
         $check_no = $request->check_no;          
         $bank_account_id = $request->bank_account_id; 
         $get_fund_id = DVModel::where('id', $dv_id)->pluck('fund_id')->first();
         $get_default_bank_account=LibraryBankAccountsModel::where('fund_id', $get_fund_id)
            ->where('is_default', 1)->where('is_active', 1)->where('is_deleted', 0)
            ->pluck('id')->first();         
         if($request->edit_check_dv==1){
            if(isset($dv_check_id)){                  
               $dv_count = count($dv_check_id);  
               for ($i=0; $i < $dv_count; $i++) {   
                  ChecksModel::find($dv_check_id[$i])
                     ->update([ 
                        'check_no'=>$check_no[$i],
                        'date_released'=>$date_released[$i],
                     ]);       
               }  
            };                      
            return response()->json(array('success' => 1, 200)); 
         }    
         elseif($request->update_attach_dv==1){              
            $data = new ChecksModel([
               'dv_id' => $dv_id,
               'check_date' => $check_date,                
               'fund_id' => $get_fund_id,                
               'bank_account_id' => $get_default_bank_account ?? NULL,                
            ]);
            $data->save(); 
            $data->id;   
            
            DVModel::find($dv_id)
               ->update([ 
                  'check_id'=> $data->id,
               ]);  
            return response()->json(array('success' => 1), 200);   
         }  
         elseif($request->update_bank_account_no==1){  
            ChecksModel::find($dv_check_id)
            ->update([ 
               'bank_account_id'=>$bank_account_id,
            ]);           
            return response()->json(array('success' => 1), 200);   
         }       
         return Response::json();         
      }  
   }

   public function delete(Request $request){
      if($request->ajax()) {
         // dd($request->all());
         $id=$request->id;
         $dv_id=$request->dv_id;
         if($request->delete_check==1) { 
            try {     
               ChecksModel::find($id)
                  ->update([
                  'is_deleted' => '1'
               ]);
               DVModel::find($dv_id)
                  ->update([
                  'check_id' => NULL,
               ]); 
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
         elseif($request->remove_attached_dv==1){
            try {     
               ChecksModel::find($id)
                  ->update([ 
                     'is_deleted'=>1,
                  ]);   
               DVModel::find($dv_id)
                  ->update([
                  'check_id' => NULL,
               ]);              
            }catch (\Exception $e) {
               return Response::json([
                  'status'=>'0'
               ]);
            } 
         }
      }
   } 

   public function show_checks_by_month_year(Request $request) {
      // dd($request->all());
      $month_selected=$request->month_selected;
      $year_selected=$request->year_selected;
      $search=$request->search;
      if ($request->ajax() && isset($month_selected) && $month_selected != null && ($search == null || $search == '')) {
         $data = ViewChecksModel::whereMonth('check_date', $month_selected)->whereYear('check_date', $year_selected)
            ->whereNotNull('dv_id')->where('is_active', 1)->where('is_deleted', 0)->orderBy('check_no', 'ASC')->get();
      }
      else if ($request->ajax() && isset($search) && $search != null) {
         $data = ViewChecksModel::
            where(function ($query) use ($search) {
               $query->where('check_no','like','%'.$search.'%')
                  ->orWhere('bank_account_no','like','%'.$search.'%')
                  ->orWhere('date_released','like','%'.$search.'%')
                  ->orWhere('check_date','like','%'.$search.'%')
                  ->orWhere('payee','like','%'.$search.'%')
                  ->orWhere('particulars','like','%'.$search.'%');
            })
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('check_no', 'ASC')->get();
      }
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($check) {
            return $check->id;
            }
         ])
         ->addColumn('check_date', function($row){
            $btn =
               "<a data-date='". $row->check_date ."' href='".url('funds_utilization/checks/edit/'.$row->check_date)."'>
               ". $row->check_date ."</a>";
            return $btn;
         })
         ->addColumn('action', function($row){
            $btn =
               "<div>               
                  <button data-id='". $row->id ."' class='btn-xs btn_delete btn btn-outline-danger' 
                     type='button' data-toggle='tooltip' data-placement='left' title='Delete Check'>
                     <i class='fa-solid fa-trash-can fa-lg'></i>
                  </button>
               </div>
               ";
            return $btn;
         })
         ->rawColumns(['check_date'], ['action'])
         ->make(true);     
   }
}
