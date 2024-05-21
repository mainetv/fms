<?php

namespace App\Http\Controllers;

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
use App\Models\User;
use App\Models\ViewQopCommentsModel;
use App\Models\ViewQuarterlyObligationProgramsModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Validator;
use Response;
use App;
use App\Models\LibraryStatusesModel;
use App\Models\QopCommentsModel;
use App\Models\ViewUsersHasRolesModel;
use Illuminate\Support\Facades\DB;

class QuarterlyObligationProgramsController extends Controller
{
	public function index($year_selected){
      $user_id = auth()->user()->id;       
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {      
         $title = "qopdivision";            
         //User specific division only
         if (auth()->user()->hasAnyRole('Division Budget Controller|Division Director|Section Head')){          
            $user_role = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [7,6,11])
               ->pluck('user_role')->first(); 
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [7,6,11])
               ->pluck('role_id')->first();  
               // dd($user_role_id); 
            return view('programming_allocation.nep.quarterly_obligation_programs.division')
               ->with(compact('title'))
               ->with(compact('user_id'))
               ->with(compact('year_selected'))
               ->with(compact('user_division_id'));
         }
      }
   } 

   public function index_divisions($year_selected){      
      $user_id = auth()->user()->id;       
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {      
         $title = "qop";
         if (auth()->user()->hasAnyRole('Super Administrator|Administrator|Budget Officer|BPAC Chair|Executive Director|BPAC')){  
            $user_role = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [0,1,3,8,9,10])
               ->pluck('user_role')->first(); 
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [0,1,3,8,9,10])
               ->pluck('role_id')->first();                  
            $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
            return view('programming_allocation.nep.quarterly_obligation_programs.division_tabs')
               ->with(compact('title'))
               ->with(compact('user_id'))
               ->with(compact('user_division_id'))
               ->with(compact('divisions'))
               ->with(compact('year_selected'));           
         }  
         //Specific divisions under their cluster only
         else if (auth()->user()->hasAnyRole('Cluster Budget Controller')){
            $user_role = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [5])
               ->pluck('user_role')->first(); 
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [5])
               ->pluck('role_id')->first();  
            $divisions = DivisionsModel::where('cluster_id', $user_division_id)-> where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
            return view('programming_allocation.nep.quarterly_obligation_programs.division_tabs')
               ->with(compact('title'))
               ->with(compact('user_id'))
               ->with(compact('user_division_id'))
               ->with(compact('divisions'))
               ->with(compact('year_selected'));
         }         
      }
   } 

	public function generatePDF(Request $request, $division_id, $year){      
		if ($request->ajax()) {
					$year = $request->year;
					view()->share('year', $year);
					$pdf = App::make('dompdf.wrapper');
					$pdf->loadView('programming_allocation.nep.quarterly_obligation_programs.division_print')
					->set_paper('letter', 'portait');
					return $pdf->stream(); 
		}
		else{
					return view('programming_allocation.nep.quarterly_obligation_programs.division_print')
					->with('division_id', $division_id)
					->with('year', $year);
		}
	}

	public function postAction(Request $request, User $user){       
      if ($request->ajax()) {
         // dd($request->all());
         $user_id = auth()->user()->id;
         $status_id = $request->status_id;
         $comment_active_status_id = $request->comment_active_status_id; 
         $qop_id = $request->qop_id;
         $user_role_id = $request->user_role_id;
         $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();  
         if($request->add_qop == 1) { //adding quarterly obligation program item
            $message = array(    
               'pap_id.required' => 'Please select PAP.',
               'activity_id.required' => 'Please select activity.',
               'expense_account_id.required' => 'Please select expense account.',
               'object_expenditure_id.required' => 'Please select object expenditure.',
            );
            $validator =  Validator::make($request->all(), [
               'pap_id' => 'required',
               'activity_id' => 'required',
               'expense_account_id' => 'required',
               'object_expenditure_id' => 'required',
            ], $message);
     
            if ($validator->passes()) {
               $data = new QuarterlyObligationProgramsModel([
                  'division_id' => $request->division_id,
                  'year' => $request->year,
                  'pap_id' => $request->pap_id,
                  'activity_id' => $request->activity_id,
                  'subactivity_id' => $request->subactivity_id,
                  'expense_account_id' => $request->expense_account_id,
                  'object_expenditure_id' => $request->object_expenditure_id,
                  'object_specific_id' => $request->object_specific_id,
                  'pooled_at_division_id' => $request->pooled_at_division_id,
                  'q1_amount' => $request->q1_amount,
                  'q2_amount' => $request->q2_amount,
                  'q3_amount' => $request->q3_amount,
                  'q4_amount' => $request->q4_amount,
               ]);
               $data->save();   
               return Response::json(['success' => '1']); 
            }
            return Response::json(['errors' => $validator->errors()]);
         } 
         elseif($status_id <> "") {              
            $division_id = $request->division_id;
            $year = $request->year;            
            $message = $request->message;
            $user_role_id_from = $request->user_role_id_from;
            $status_details = LibraryStatusesModel::where('id', $status_id)->get(); 
            $division_code = DivisionsModel::where('id', $division_id)
               ->where('is_active', 1)->where('is_deleted',0)->pluck('division_code')->first();            
            if($status_id==2){
               $get_details = ViewQopCommentsModel::where('division_id', $division_id)->where('year', $year)
                  ->where('is_active', 1)->where('is_deleted', 0)->where('is_resolved', 0)->get();
               if($get_details->count()>0){
                  foreach($get_details as $value){     
                     QopCommentsModel::find($value->id)
                        ->update([                  
                           'is_resolved' => 1,
                        ]);
                  }     
               }              
            }        
            if (QopStatusModel::where('division_id', $division_id)->where('year', $year)->count() > 0) {
               QopStatusModel::where('division_id', $division_id)->where('year', $year)->where('is_active', '1')         
               ->update([
                  'is_active' => '0'
               ]); 
            }
            
            $status_data = new QopStatusModel([
               'division_id' => $division_id,
               'year' => $year,
               'status_id' => $status_id,               
               'status_by_user_id' => $user_id,
               'status_by_user_role_id' => $user_role_id_from,
               'status_by_user_division_id' => $user_division_id,
               'is_active' => '1',
            ]);
            // dd($status_data);
            $status_data->save();  
            foreach ($status_details as $value) {  
               $arr_role_ids=$value->role_id_to;
            }
            $role_ids = explode(',', $arr_role_ids); 
            // dd($role_ids); 
            $get_notif_to = ViewUsersHasRolesModel::whereIn('role_id', $role_ids)->whereIn('role_id', [3, 9, 10])
               ->where('id','!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->get();
            // dd($division_code);
            if(isset($get_notif_to)){
               foreach($get_notif_to as $value){                  
                  $notif_to[] =[
                     'module_id' => '3',
                     'year' => $year,
                     'message' => $message,
                     'link' => 'programming_allocation/nep/quarterly_obligation_program/divisions/'.$year.'#'.$division_code, 
                     'division_id' => $division_id,
                     'division_id_from' => $user_division_id,
                     'division_id_to' => $value->division_id,
                     'user_id_from' => $user_id,
                     'user_id_to' => $value->id,
                     'user_role_id_from' => $user_role_id_from, 
                     'user_role_id_to' => $value->user_role_id,
                  ];                                         
               }
               // dd($notif_to);
               if(isset($notif_to)){
                  NotificationsModel::insert($notif_to); 
               }
            }
            
            $get_notif_division_to = ViewUsersHasRolesModel::whereIn('role_id', $role_ids)->whereIn('role_id', [7, 6, 11])
               ->where('division_id', $division_id)->where('id','!=', $user_id)
               ->where('is_active', 1)->where('is_deleted', 0)->get();
            // dd($get_notif_division_to);
            if(isset($get_notif_division_to)){
               foreach($get_notif_division_to as $value){  
                  $notif_division_to[] =[
                     'module_id' => '3',
                     'year' => $year,
                     'message' => $message,
                     'link' => 'programming_allocation/nep/quarterly_obligation_program/division/'.$year, 
                     'division_id' => $division_id,
                     'division_id_from' => $user_division_id,
                     'division_id_to' => $value->division_id,
                     'user_id_from' => $user_id,
                     'user_id_to' => $value->id,
                     'user_role_id_from' => $user_role_id_from, 
                     'user_role_id_to' => $value->user_role_id,
                  ];                                         
               }       
               // dd(isset($notif_division_to));           
               if(isset($notif_division_to)){
                  NotificationsModel::insert($notif_division_to); 
               }
            }        
            return Response::json(['success' => '1']); 
         } 
         elseif(isset($comment_active_status_id)) { //adding/editing/deleting/resolving comments   
            if($user_role_id==6 || $user_role_id==11){
               $comment_by = $request->comment_by_division_director;   
               $count = count($comment_by);  
               for ($i=0; $i < $count; $i++) {
                  $data = [
                     'comment_by_division_director' => $comment_by[$i],
                  ];
               }
               $messages = array(    
                  'comment_by_division_director.required' => 'Please input comment.',              
               );
               $validator =  Validator::make($data, [
                  'comment_by_division_director' => 'required',               
               ], $messages);  
            }
            else if($user_role_id==3){
               $comment_by = $request->comment_by_budget_officer;   
               $count = count($comment_by);  
               for ($i=0; $i < $count; $i++) {
                  $data = [
                     'comment_by_budget_officer' => $comment_by[$i],
                  ];
               }
               $messages = array(    
                  'comment_by_budget_officer.required' => 'Please input comment.',              
               );
               $validator =  Validator::make($data, [
                  'comment_by_budget_officer' => 'required',               
               ], $messages);  
            }
            else if($user_role_id==9){
               $comment_by = $request->comment_by_bpac;   
               $count = count($comment_by);  
               for ($i=0; $i < $count; $i++) {
                  $data = [
                     'comment_by_bpac' => $comment_by[$i],
                  ];
               }
               $messages = array(    
                  'comment_by_bpac.required' => 'Please input comment.',              
               );
               $validator =  Validator::make($data, [
                  'comment_by_bpac' => 'required',               
               ], $messages);  
            }
         
            if ($validator->passes()) {
               QopCommentsModel::where('qop_id', $qop_id)->where('is_active', 1)->where('is_deleted', 0)
                  ->where('is_resolved', 0)->delete();          
               foreach($comment_by as $key => $value) {  
                  $comments[] = [                 
                     'qop_id' => $qop_id,
                     'comment' => $comment_by[$key],
                     'comment_by' => $user_role_id,                        
                     'is_resolved' => 0,
                  ];       
               }
               // dd($comments);
               QopCommentsModel::insert($comments);              
               return response()->json(array('success' => 1, 200));   
            }                      
            return Response::json(['errors' => $validator->errors()]);             
         }
      } 
   }

   public function show($id){ 
      $data = ViewQuarterlyObligationProgramsModel::find($id);
      if($data->count()) {
         return Response::json([
         'status' => '1',
         'quarterly_obligation_program' => $data               
         ]);
      } 
      else {
         return Response::json([
         'status' => '0'
         ]);
      }     
   }
   
	public function update(Request $request, User $user){      
      if ($request->ajax()) {     
         // dd($request->all());       
         if($request->edit_qop==1) { //updating quarterly obligation program item
            $message = array(    
               'pap_id.required' => 'Please select PAP.',
               'activity_id.required' => 'Please select activity.',
               'expense_account_id.required' => 'Please select expense account.',
               'object_expenditure_id.required' => 'Please select object expenditure.',
            );
            $validator =  Validator::make($request->all(), [
               'pap_id' => 'required',
               'activity_id' => 'required',
               'expense_account_id' => 'required',
               'object_expenditure_id' => 'required',
            ], $message);
                   
            if ($validator->passes()) {
               QuarterlyObligationProgramsModel::find($request->get('id'))
                  ->update([                  
                     'pap_id' => $request->get('pap_id'),
                     'activity_id' => $request->get('activity_id'),
                     'subactivity_id' => $request->get('subactivity_id'),
                     'expense_account_id' => $request->get('expense_account_id'),
                     'object_expenditure_id' => $request->get('object_expenditure_id'),
                     'object_specific_id' => $request->get('object_specific_id'),
                     'pooled_at_division_id' => $request->get('pooled_at_division_id'),
                     'q1_amount' => (float) str_replace(',', '', $request->q1_amount),
                     'q2_amount' => (float) str_replace(',', '', $request->q2_amount),
                     'q3_amount' => (float) str_replace(',', '', $request->q3_amount),
                     'q4_amount' => (float) str_replace(',', '', $request->q4_amount),
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

	public function delete(Request $request){
      if($request->ajax()) {
         if($request->delete_qop==1) { //updating qop program delete 1
            try {     
               QuarterlyObligationProgramsModel::find($request->get('id'))
                  ->update([
                  'is_deleted' => '1'
               ]);
            }catch (\Exception $e) {
            return Response::json([
               'status'=>'0'
            ]);
            } 
         }
         elseif($request->delete_comment==1) { //updating qop program delete 1
            try {     
               QopCommentsModel::find($request->get('id'))
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

	public function show_comment($id){
      $data = ViewQopCommentsModel::where('qop_id', $id)
         ->where('is_active', '1')->where('is_deleted', '0')->get();   
      // dd($data); 
      if($data->count()) {
         return Response::json([
            'status' => '1',
            'comment' => $data,
            'rowCount' => $data->count(),
         ]);
      } 
      else {
         return Response::json([
         'status' => '0'
         ]);
      } 
   }
}
