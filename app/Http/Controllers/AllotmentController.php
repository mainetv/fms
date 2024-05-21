<?php

namespace App\Http\Controllers;

use App\Models\AdjustmentTypesModel;
use App\Models\AdjustmentModel;
use App\Models\AllotmentFundModel;
use App\Models\AllotmentModel;
use App\Models\AllotmentStatusModel;
use App\Models\CashProgramsModel;
use App\Models\CpStatusModel;
use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\LibraryActivityModel;
use App\Models\LibraryExpenseAccountModel;
use App\Models\LibraryObjectExpenditureModel;
use App\Models\LibraryPAPModel;
use App\Models\LibrarySubactivityModel;
use App\Models\NotificationsModel;
use App\Models\QopStatusModel;
use App\Models\QuarterlyObligationProgramsModel;
use App\Models\RsTypesModel;
use App\Models\User;
use App\Models\ViewAdjustmentModel;
use App\Models\ViewAllotmentAdjustmentModel;
use App\Models\ViewAllotmentModel;
use App\Models\ViewRSModel;
use App\Models\ViewRsPapModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;
use Response;
use DataTables;

class AllotmentController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request, $rstype_id_selected, $year_selected, $view_selected)
   {     
      $username = auth()->user()->username; 
      $user_id = auth()->user()->id;       
      $user_role_id = auth()->user()->user_role_id;
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();     
      foreach($user_roles as $row){
         $user_roles_data []= [
            "user_role" => $row->user_role,
            "user_role_id" => $row->role_id,  
         ];
      }   
      // dd($user_roles_data);
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();   
      $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();   
      $data = [
         "year_selected" => $year_selected,
         "rstype_id_selected" => $rstype_id_selected,
         "view_selected" => $view_selected,
      ];   
      $years = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('year', 'ASC')->get();
      $rs_types = RsTypesModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('id', 'ASC')->get();
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
      $getAllotmentFund = AllotmentFundModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('fund_code')->get();
      $getLibraryPAP = LibraryPAPModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('pap_code')->get();
      $getLibraryActivities = LibraryActivityModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('activity')->get();
      $getLibrarySubactivities = LibrarySubactivityModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('subactivity')->get();
      $getLibraryExpenseAccounts = LibraryExpenseAccountModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('expense_account')->get();
      $getLibraryObjectExpenditures = LibraryObjectExpenditureModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('object_expenditure')->get(); 
      $getAdjustmentTypes = AdjustmentTypesModel::where("is_active", 1)->where("is_deleted", 0)->get(); 
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {    
         if (auth()->user()->hasAnyRole('Administrator|Super Administrator|Budget Officer')){     
            $title = "Allotment";                       
            $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
            Session::put('division', 'MISD');
            Session::put('year_selected', $year_selected);
            Session::put('rstype_id_selected', $rstype_id_selected);
            Session::put('view_selected', $view_selected);
            return view('programming_allocation.allotment.division_tabs')
               ->with(compact('title'), $title)
               ->with(compact('data'),$data)
               ->with(compact('username'), $username)
               ->with(compact('user_id'), $user_id)
               ->with(compact('user_role'), $user_role)
               ->with(compact('user_role_id'), $user_role_id)
               ->with(compact('user_roles_data'), $user_roles_data)
               ->with(compact('user_division_id'), $user_division_id)
               ->with(compact('user_fullname'), $user_fullname)
               ->with(compact('divisions'), $divisions)
               ->with(compact('getAllotmentFund'), $getAllotmentFund)
               ->with(compact('getLibraryPAP'), $getLibraryPAP)
               ->with(compact('getLibraryActivities'), $getLibraryActivities)
               ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
               ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
               ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
               ->with(compact('year_selected'), $year_selected)
               ->with(compact('years'), $years)
               ->with(compact('rs_types'), $rs_types)
               ->with(compact('getAdjustmentTypes'))
               ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
               ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical);
         }    
      }
   }

   public function store(Request $request){
      if ($request->ajax()) { 
         // dd($request->all());
         $user_id = auth()->user()->id;     
         $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();           
         $user_role_id_from = $request->user_role_id_from;
         $message = $request->message;
         $division_id = $request->division_id;
         $status_id = $request->status_id;
         $year = $request->year;
         $rs_type_id = $request->rs_type_id;
         $allotment_fund_id = $request->allotment_fund_id;
         $pap_id = $request->pap_id;
         $activity_id = $request->activity_id;
         $subactivity_id = $request->subactivity_id;
         $expense_account_id = $request->expense_account_id;
         $object_expenditure_id = $request->object_expenditure_id;
         $object_specific_id = $request->object_specific_id;
         if($request->add_allotment== 1) { //adding allotment
            if($rs_type_id==1){      
               $message = array(    
                  'allotment_fund_id.required' => 'Please select allotment fund.',
                  'pap_id.required' => 'Please select PAP.',
                  'activity_id.required' => 'Please select activity.',
                  'expense_account_id.required' => 'Please select expense account.',
                  'object_expenditure_id.required' => 'Please select object expenditure.',
               );
               $validator =  Validator::make($request->all(), [
                  'allotment_fund_id' => 'required',
                  'pap_id' => 'required',
                  'activity_id' => 'required',
                  'expense_account_id' => 'required',
                  'object_expenditure_id' => 'required',
               ], $message);
            }
            else{
               $message = array(    
                  'allotment_fund_id.required' => 'Please select allotment fund.',
                  'pap_id.required' => 'Please select PAP.',
                  'activity_id.required' => 'Please select activity.',
                  'expense_account_id.required' => 'Please select expense account.',                  
               );
               $validator =  Validator::make($request->all(), [
                  'allotment_fund_id' => 'required',
                  'pap_id' => 'required',
                  'activity_id' => 'required',
                  'expense_account_id' => 'required',
               ], $message);
            }
            $input = $request->all();         
            if ($validator->passes()) {
               $checkdata = AllotmentModel::where('is_active', 1)->where('is_deleted', 0)->get();
               $data = new AllotmentModel([
                  'division_id' => $division_id,
                  'year' => $year,
                  'rs_type_id' => $rs_type_id,
                  'allotment_fund_id' => $allotment_fund_id,
                  'pap_id' => $pap_id,
                  'activity_id' => $activity_id,
                  'subactivity_id' => $subactivity_id,
                  'expense_account_id' => $expense_account_id,
                  'object_expenditure_id' => $object_expenditure_id,
                  'object_specific_id' => $object_specific_id,
                  'pooled_at_division_id' => $request->pooled_at_division_id,
                  'q1_allotment' => $request->q1_allotment ?? 0,               
                  'q2_allotment' => $request->q2_allotment ?? 0,               
                  'q3_allotment' => $request->q3_allotment ?? 0,               
                  'q4_allotment' => $request->q4_allotment ?? 0,               
               ]);
               $data->save();   
               return Response::json(['success' => '1']); 
            }
            return Response::json(['errors' => $validator->errors()]);
         }  
         elseif($request->add_adjustment== 1) { //adding allotment  
            // dd($request->q1_adjustment); 
            $message = array(    
               'date.required' => 'Please input date.',
               'adjustment_type_id.required' => 'Please select allotment type.',
            );
            $validator =  Validator::make($request->all(), [
               'date' => 'required',
               'adjustment_type_id' => 'required',
            ], $message);
    
            if ($validator->passes()) {
               $data = new AdjustmentModel([
                  'allotment_id' => $request->allotment_id,
                  'date' => $request->date,
                  'adjustment_type_id' => $request->adjustment_type_id,
                  'reference_no' => $request->reference_no,
                  'q1_adjustment' => $request->q1_adjustment ?? 0,
                  'q2_adjustment' => $request->q2_adjustment ?? 0,          
                  'q3_adjustment' => $request->q3_adjustment ?? 0,          
                  'q4_adjustment' => $request->q4_adjustment ?? 0,          
                  'remarks' => $request->remarks,                     
               ]);
               // dd($data);
               $data->save();   
               return Response::json(['success' => '1']); 
            }
            return Response::json(['errors' => $validator->errors()]);
         }  
         elseif($request->forward== 1) {
            $get_allotment_ref = ViewAllotmentModel::where('year', $year)->where('rs_type_id', 1)
               ->where('is_active',1)->where('is_deleted',0)->get(); 
            foreach($get_allotment_ref as $value){                  
               $data[] =[
                  'reference_allotment_id' => $value->id,
                  'division_id' => $value->division_id,
                  'year' => $value->year,
                  'pap_id' => $value->pap_id,
                  'activity_id' => $value->activity_id,
                  'subactivity_id' => $value->subactivity_id ?? NULL,
                  'expense_account_id' => $value->expense_account_id,
                  'object_expenditure_id' => $value->object_expenditure_id ?? NULL,
                  'object_specific_id' => $value->object_specific_id ?? NULL,
               ];
            }
            CashProgramsModel::insert($data); 
            QuarterlyObligationProgramsModel::insert($data); 
            
            if (AllotmentStatusModel::where('year', $year)->count() > 0) {
               AllotmentStatusModel::where('year', $year)->where('is_active', '1')         
               ->update([
                  'is_active' => '0'
               ]); 
            }

            $all_divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->get(); 				
				foreach($all_divisions as $value)
				{
               //set allotment status to forwarded
					$data1[] =[
						'division_id' => $value->id,
						'year' => $year,
						'status_id' => $status_id,
						'status_by_user_id' => $user_id,
               	'status_by_user_role_id' => $user_role_id_from,
               	'status_by_user_division_id' => $user_division_id,
						'is_active' => '1',
					];	

					//add initial monthly cash program status for all division
					$data2[] =[
						'division_id' => $value->id,
						'year' => $year,
						'status_id' => '16',
						'status_by_user_id' => $user_id,
               	'status_by_user_role_id' => $user_role_id_from,
               	'status_by_user_division_id' => $user_division_id,
						'is_active' => '1',
					];	
               
               //add initial quarterly program status for all division
					$data3[] =[
						'division_id' => $value->id,
						'year' => $year,
						'status_id' => '37',
						'status_by_user_id' => $user_id,
               	'status_by_user_role_id' => $user_role_id_from,
               	'status_by_user_division_id' => $user_division_id,
						'is_active' => '1',
					];		
				}				
				AllotmentStatusModel::insert($data1); // Eloquent approach
				CpStatusModel::insert($data2); // Eloquent approach
				QopStatusModel::insert($data3); // Eloquent approach
            
            $get_division_budget_controllers = ViewUsersHasRolesModel::where('role_id', 7)
               ->where('id','!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->get();                    
            if($get_division_budget_controllers->count()!=0){
               foreach($get_division_budget_controllers as $value){
                  $data4[] =[
                     'module_id' => '2',
                     'year' => $year,
                     'message' => $message,
                     'link' => 'budget_preparation/monthly_cash_program/division/', 
                     'division_id' => $value->division_id,
                     'division_id_from' => $user_division_id,
                     'division_id_to' => $value->division_id,
                     'user_id_from' => $user_id,
                     'user_id_to' => $value->id,
                     'user_role_id_from' => $user_role_id_from ?? NULL, 
                     'user_role_id_to' => '7', 
                  ]; 

                  $data5[] =[
                     'module_id' => '3',
                     'year' => $year,
                     'message' => $message,
                     'link' => 'budget_preparation/quarterly_obligation_program/division/', 
                     'division_id' => $value->division_id,
                     'division_id_from' => $user_division_id,
                     'division_id_to' => $value->division_id,
                     'user_id_from' => $user_id,
                     'user_id_to' => $value->id,
                     'user_role_id_from' => $user_role_id_from ?? NULL, 
                     'user_role_id_to' => '7', 
                  ]; 
               }    
               NotificationsModel::insert($data4);
               NotificationsModel::insert($data5);
            }
            return Response::json(['success' => '1']); 
         }    
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\AllotmentModel  $allotmentModel
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {     
      $data = ViewAllotmentModel::find($id);
      if($data->count()) {
         return Response::json([
         'status' => '1',
         'allotment' => $data               
         ]);
      } 
      else {
         return Response::json([
         'status' => '0'
         ]);
      } 
   }

   public function show_adjustment($id)
   {    
      $data = ViewAdjustmentModel::find($id); 
      // dd($data);     
      if($data->count()) {
         return Response::json([
         'status' => '1',
         'adjustment' => $data               
         ]);
      } 
      else {
         return Response::json([
         'status' => '0'
         ]);
      } 
   }
 
   public function update(Request $request, User $user)
   {      
      if($request->ajax()) {    
         $rs_type_id=$request->rs_type_id;    
         $q1_allotment=removeComma($request->q1_allotment);    
         $q1_allotment=removeComma($request->q1_allotment);    
         $q2_allotment=removeComma($request->q2_allotment);    
         $q3_allotment=removeComma($request->q3_allotment);    
         $q4_allotment=removeComma($request->q4_allotment);    
         $total_allotment=removeComma($request->total_allotment);    
         if($request->edit_allotment==1) { //updating budget proposal item
            if($rs_type_id==1){
               $message = array(    
                  'allotment_fund_id.required' => 'Please select allotment fund.',
                  'pap_id.required' => 'Please select PAP.',
                  'activity_id.required' => 'Please select activity.',
                  'expense_account_id.required' => 'Please select expense account.',
                  'object_expenditure_id.required' => 'Please select object expenditure.',
               );
               $validator =  Validator::make($request->all(), [
                  'allotment_fund_id' => 'required',
                  'pap_id' => 'required',
                  'activity_id' => 'required',
                  'expense_account_id' => 'required',
                  'object_expenditure_id' => 'required',
               ], $message);
            }
            else{
               $message = array(    
                  'allotment_fund_id.required' => 'Please select allotment fund.',
                  'pap_id.required' => 'Please select PAP.',
                  'activity_id.required' => 'Please select activity.',
                  'expense_account_id.required' => 'Please select expense account.',                 
               );
               $validator =  Validator::make($request->all(), [
                  'allotment_fund_id' => 'required',
                  'pap_id' => 'required',
                  'activity_id' => 'required',
                  'expense_account_id' => 'required',
               ], $message);
            }
                  
            if ($validator->passes()) {
               AllotmentModel::find($request->get('id'))
                  ->update([     
                     'allotment_fund_id' => $request->get('allotment_fund_id'),
                     'pap_id' => $request->get('pap_id'),
                     'activity_id' => $request->get('activity_id'),
                     'subactivity_id' => $request->get('subactivity_id'),
                     'expense_account_id' => $request->get('expense_account_id'),
                     'object_expenditure_id' => $request->get('object_expenditure_id'),
                     'object_specific_id' => $request->get('object_specific_id'),
                     'pooled_at_division_id' => $request->get('pooled_at_division_id'),
                     'q1_allotment' => $q1_allotment ?? 0,               
                     'q2_allotment' => $q2_allotment ?? 0,               
                     'q3_allotment' => $q3_allotment ?? 0,               
                     'q4_allotment' => $q4_allotment ?? 0,    
                  ]);             
               return Response::json([
                  'success' => '1',          
                  'status' => '0'
               ]);
            }
            return Response::json(['errors' => $validator->errors()]);
         }
         elseif($request->edit_adjustment== 1) { //adding allotment  
            // dd($request->edit_adjustment); 
            // dd($request->get('id')); 
            $message = array(    
               'date.required' => 'Please input date.',
               'adjustment_type_id.required' => 'Please select allotment type.',
            );
            $validator =  Validator::make($request->all(), [
               'date' => 'required',
               'adjustment_type_id' => 'required',
            ], $message);
    
            if ($validator->passes()) {
               AdjustmentModel::find($request->get('id'))
                  ->update([  
                  'date' => $request->date,
                  'adjustment_type_id' => $request->adjustment_type_id,
                  'reference_no' => $request->reference_no,
                  'q1_adjustment' => $request->q1_adjustment,
                  'q2_adjustment' => $request->q2_adjustment,          
                  'q3_adjustment' => $request->q3_adjustment,          
                  'q4_adjustment' => $request->q4_adjustment,          
                  'remarks' => $request->remarks,                     
               ]);
               return Response::json([
                  'success' => '1',          
                  'status' => '0'
               ]);
            }
            return Response::json(['errors' => $validator->errors()]);
         }           
      }
   }
 
   public function delete(Request $request)
   {
      if($request->ajax()) {
         if($request->delete_allotment==1) { //updating budget proposal delete 1
            try {     
               AllotmentModel::find($request->get('id'))
                  ->update([
                  'is_deleted' => '1'
               ]);
            }catch (\Exception $e) {
            return Response::json([
               'status'=>'0'
            ]);
            } 
         }
         elseif($request->delete_adjustment==1) { //updating budget proposal delete 1
            try {     
               AdjustmentModel::find($request->get('id'))
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

   public function show_adjustments_by_allotment_id(Request $request) {
      // dd($request->allotment_id);
      // dd(isset($request->all()['allotment_id']));
      if ($request->ajax() && isset($request->all()['allotment_id']) && $request->all()['allotment_id'] != null) {
         if(isset($request->all()['allotment_id'])) {
            if($request->adjustment_table==1){
               $data = ViewAdjustmentModel::where('allotment_id', $request->allotment_id)->where('is_active', 1)->where('is_deleted', 0)->get();
            }
            elseif($request->allotment_adjustment_table==1){        
               $data = ViewAllotmentAdjustmentModel::where('allotment_id', $request->allotment_id)->where('is_active', 1)->where('is_deleted', 0)->get(); 
            }
         } 
         return DataTables::of($data)
            ->setRowAttr([
               'data-id' => function($adjustment) {
               return $adjustment->id;
               }
            ])
            ->addColumn('action', function($row){
               $btn =
               "<div>               
                 <button data-id='". $row->id ."' class='btn_edit_adjustment' type='button'>
                   <i class='fas fa-edit green'></i>
                 </button>
                 <button data-id='". $row->id ."' class='btn_delete_adjustment' type='button'>
                   <i class='fas fa-trash-alt red'></i>
                 </button>
               </div>
               ";
                 return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\AllotmentModel  $allotmentModel
    * @return \Illuminate\Http\Response
    */
   public function edit(AllotmentModel $allotmentModel)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\AllotmentModel  $allotmentModel
    * @return \Illuminate\Http\Response
    */
   public function destroy(AllotmentModel $allotmentModel)
   {
      //
   }
}
