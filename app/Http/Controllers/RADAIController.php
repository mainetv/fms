<?php

namespace App\Http\Controllers;

use App\Models\RADAIModel;
use App\Models\ViewAdaDvsModel;
use App\Models\ViewLddapAdaIssuedModel;
use App\Models\ViewLibraryBankAccountsModel;
use App\Models\ViewRADAIModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Response;
use DB;

class RADAIController extends Controller
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
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {    
         $title = "RADAI"; 
         return view('funds_utilization.radai.all')
            ->with(compact('title'), $title)
            ->with(compact('data'),$data)
            ->with(compact('username'), $username)
            ->with(compact('user_id'), $user_id)
            ->with(compact('user_role'), $user_role)
            ->with(compact('user_role_id'), $user_role_id)
            ->with(compact('user_division_id'), $user_division_id)
            ->with(compact('user_division_acronym'), $user_division_acronym)
            ->with(compact('user_fullname'), $user_fullname);
      }
   }

   public function store(Request $request){
      if ($request->ajax()) { 
         // dd($request->all());        
         $message = array(    
            'bank_account_id.required' => 'Please select bank account no.',
            'radai_date.required' => 'Please select date.',
         );
         $validator =  Validator::make($request->all(), [
            'bank_account_id' => 'required',
            'radai_date' => 'required',
         ], $message);
   
         if ($validator->passes()) {
            $fund_id=ViewLibraryBankAccountsModel::where('id', $request->bank_account_id)
               ->where('is_active', 1)->where('is_deleted', 0)->pluck('fund_id')->first();            
            $month=$request->month;
            $year=$request->year;
            $bank_account_id=$request->bank_account_id;
            $suffix = DB::table('radai')
               ->select(DB::raw("LPAD(SUBSTR(radai_no,9,3)+1,3,0) as radai_suffix_no"))->where('bank_account_id', $bank_account_id)
               ->whereYear('radai_date', $year)->where('is_active', 1)->where('is_deleted',0)
               ->orderBY('radai_no','DESC')->orderBY('radai_suffix_no','DESC')->pluck('radai_suffix_no')->first();
            if($suffix==0 || $suffix==NULL) {
               $suffix="0001" ;
            }
            $radai_no = $year.'-'.$month.'-'.$suffix;       
            // dd($fund_id);
            $data = new RADAIModel([               
               'radai_date' => $request->radai_date,
               'radai_no' => $radai_no,  
               'fund_id' => $fund_id,  
               'bank_account_id' => $bank_account_id,                          
            ]);
            $data->save(); 
            $data->id;    
            return Response::json(['success' => '1']); 
         }
         return Response::json(['errors' => $validator->errors()]);   
      }
   }

   public function show_radai_by_month_year(Request $request) {
      //   dd($request->all());
      $month_selected=$request->month_selected;
      $year_selected=$request->year_selected;
      $search=$request->search;
      if ($request->ajax() && ($search == null || $search == '')) {
         $data = ViewRADAIModel::whereMonth('radai_date', $month_selected)->whereYear('radai_date', $year_selected)
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('radai_date', 'ASC')->get();
      }
      else if ($request->ajax() && ($search != null || $search != '')) {
         $data = ViewRADAIModel::where('is_active', 1)->where('is_deleted', 0)
            ->where(function ($query) use ($search) {
               $query->where('radai_no','like','%'.$search.'%')
                  ->orWhere('id','like','%'.$search.'%')
                  ->orWhere('radai_date','like','%'.$search.'%')
                  ->orWhere('bank_account_no','like','%'.$search.'%');
            })
            ->orderBy('radai_date', 'ASC')->get();
      }
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($radai) {
            return $radai->id;
            }
         ])
         ->addColumn('radai_no', function($row){
            $btn =
               "<div>
                  <a data-id='". $row->id ."' data-no='". $row->id ."' href='#' class='btn_load_ada'>
               ". $row->radai_no ."</a>
               </div>";
            return $btn;
         })
         ->addColumn('action', function($row){
            //   $btn =
            //      "<div>               
            //         <button data-id='". $row->id ."' class='btn-xs btn_edit btn' 
            //             type='button' data-toggle='tooltip' data-placement='left' title='Edit RADAI'>
            //             <i class='fa-solid fa-edit green fa-lg'></i>					
            //         </button>            
            //         <button data-id='". $row->id ."' class='btn-xs btn_delete btn btn-outline-danger' 
            //             type='button' data-toggle='tooltip' data-placement='left' title='Delete RADAI'>
            //             <i class='fa-solid fa-trash-can fa-lg'></i>
            //         </button>
            //      </div>
            //      ";
            //   return $btn;
         })
         ->rawColumns(['radai_no'], ['action'])
         ->make(true);     
   }

   public function show_ada_dvs_by_radai(Request $request) {
      // dd($request->all());   
      $radai_id=$request->radai_id;
      $search=$request->search;
      $radai_date = RADAIModel::where('id', $radai_id)->pluck('radai_date')->first();
      $bank_account_id = RADAIModel::where('id', $radai_id)->pluck('bank_account_id')->first();
      if ($request->ajax() && ($search == null || $search == '')) {
         $data = ViewAdaDvsModel::where('ada_date', $radai_date)
               ->where('bank_account_id', $bank_account_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('payee', 'ASC')->get();
      }
      else if ($request->ajax() && ($search != null || $search != '')) {
         $data = ViewAdaDvsModel::where('is_active', 1)->where('is_deleted', 0)
            ->where(function ($query) use ($search) {
               $query->where('radai_no','like','%'.$search.'%')
                  ->orWhere('id','like','%'.$search.'%')
                  ->orWhere('radai_date','like','%'.$search.'%')
                  ->orWhere('bank_account_no','like','%'.$search.'%');
            })
            ->orderBy('radai_no', 'ASC')->get();
      }
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function($ada) {
            return $ada->id;
            }
         ])
         ->make(true);     
   }
   
   public function print_radai(Request $request, $radai_id) {
      $radai_no = RADAIModel::where('id', $radai_id)->pluck('radai_no')->first();
      $radai_date = RADAIModel::where('id', $radai_id)->pluck('radai_date')->first();
      $fund_id = RADAIModel::where('id', $radai_id)->pluck('fund_id')->first();
      $bank_account_id = RADAIModel::where('id', $radai_id)->pluck('bank_account_id')->first();
      $radai_data = ViewLddapAdaIssuedModel::where('ada_date',$radai_date)->where('fund_id',$fund_id)
         ->where('bank_account_id', $bank_account_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      return \View::make('funds_utilization.radai.print_radai')
         ->with('radai_no', $radai_no)
         ->with('radai_data', $radai_data);
   }
}
