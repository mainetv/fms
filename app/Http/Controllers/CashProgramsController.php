<?php

namespace App\Http\Controllers;

use App\Models\DivisionsModel;
use App\Models\CashProgramsModel;
use App\Models\CpCommentsModel;
use App\Models\CpStatusModel;
use App\Models\NotificationsModel;
use App\Models\ViewCashProgramsModel;
use App\Models\ViewCpCommentsModel;
use App\Models\ViewCpStatusModel;
use App\Models\User;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Response;
use Spatie\Permission\Traits\HasRoles;
use App\Models\LibraryStatusesModel;
use App\Models\ViewUsersHasRolesModel;
use Illuminate\Support\Facades\DB;

class CashProgramsController extends Controller
{
   use HasRoles;
   public function index($year_selected){
      $user_id = auth()->user()->id;       
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      if(isset(request()->url)){
         return redirect(request()->url);         
      }
      else
      {      
         $title = "mcpdivision";       
         //User specific division only
         if (auth()->user()->hasAnyRole('Division Budget Controller|Division Director|Section Head')){                
            $user_role = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [7,6,11])
               ->pluck('user_role')->first(); 
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [7,6,11])
               ->pluck('role_id')->first();  
               // dd($user_role_id); 
            return view('programming_allocation.nep.monthly_cash_programs.division')
               ->with(compact('title'))
               ->with(compact('user_id'))
               ->with(compact('user_division_id'))
               ->with(compact('year_selected'));
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
         $title = "mcp";    
         if (auth()->user()->hasAnyRole('Super Administrator|Administrator|Budget Officer|BPAC Chair|Executive Director|BPAC')){  
            $user_role = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [0,1,3,8,9,10])
               ->pluck('user_role')->first(); 
            $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->whereIn('role_id', [0,1,3,8,9,10])
               ->pluck('role_id')->first();                  
            $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('division_acronym', 'asc')->get();
            return view('programming_allocation.nep.monthly_cash_programs.division_tabs')
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
            return view('programming_allocation.nep.monthly_cash_programs.division_tabs')
               ->with(compact('title'))
               ->with(compact('user_id'))
               ->with(compact('user_division_id'))
               ->with(compact('divisions'))
               ->with(compact('year_selected'));
         }       
      }
   } 

   public function generatePDF(Request $request, $division_id, $year){      
      // dd($division_id);
      // if ($request->ajax()) {
            // $year = $request->year;
            // $division_id = $request->division_id;
            // view()->share('year', $year);
            // view()->share('division_id', $division_id);
            // $pdf = App::make('dompdf.wrapper');
            // $pdf->loadView('monthly_cash_programs.division_print')
            //    ->set_paper('letter', 'landscape');
            // return $pdf->stream(); 
      // }
      // else{
            return view('programming_allocation.nep.monthly_cash_programs.division_print')
               ->with('division_id', $division_id)
               ->with('year', $year);
      // }
   }

   public function postAction(Request $request, User $user){       
      if ($request->ajax()) {
         // dd($request->all());         
         $now = Carbon::now()->timezone('Asia/Manila')->format('Ymd.His');	
		   $created_at = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');
         $user_id = auth()->user()->id;
         $status_id = $request->status_id;
         $comment_active_status_id = $request->comment_active_status_id; 
         $cash_program_id = $request->cash_program_id;
         $user_role_id = $request->user_role_id;
         $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();  
         if($user_id=='20' || $user_id=='14'){
            $division_id = '9';
            $division_code = 'D4';
            $user_division_id = '9';
         }
         if($user_id=='111'){
            $division_id = '3';
            $division_code = 'Q';
            $user_division_id = '3';
         }         if($request->add_cash_program == 1) { //adding cash program item
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
               $data = new CashProgramsModel([
                  'division_id' => $request->division_id,
                  'year' => $request->year,
                  'pap_id' => $request->pap_id,
                  'activity_id' => $request->activity_id,
                  'subactivity_id' => $request->subactivity_id,
                  'expense_account_id' => $request->expense_account_id,
                  'object_expenditure_id' => $request->object_expenditure_id,
                  'object_specific_id' => $request->object_specific_id,
                  'pooled_at_division_id' => $request->pooled_at_division_id,
                  'jan_amount' => $request->jan_amount,
                  'feb_amount' => $request->feb_amount,
                  'mar_amount' => $request->mar_amount,
                  'apr_amount' => $request->apr_amount,
                  'may_amount' => $request->may_amount,
                  'jun_amount' => $request->jun_amount,
                  'jul_amount' => $request->jul_amount,
                  'aug_amount' => $request->aug_amount,
                  'sep_amount' => $request->sep_amount,
                  'oct_amount' => $request->oct_amount,
                  'nov_amount' => $request->nov_amount,
                  'dec_amount' => $request->dec_amount,
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
               $get_details = ViewCpCommentsModel::where('division_id', $division_id)->where('year', $year)
                  ->where('is_active', 1)->where('is_deleted', 0)->where('is_resolved', 0)->get();
               if($get_details->count()>0){
                  foreach($get_details as $value){     
                     CpCommentsModel::find($value->id)
                        ->update([                  
                           'is_resolved' => 1,
                        ]);
                  }     
               }              
            }        
            if (CpStatusModel::where('division_id', $division_id)->where('year', $year)->count() > 0) {
               CpStatusModel::where('division_id', $division_id)->where('year', $year)->where('is_active', '1')         
               ->update([
                  'is_active' => '0'
               ]); 
            }
            
            $status_data = new CpStatusModel([
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
                     'module_id' => '2',
                     'year' => $year,
                     'message' => $message,
                     'link' => 'programming_allocation/nep/monthly_cash_program/divisions/'.$year.'#'.$division_code, 
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
                     'module_id' => '2',
                     'year' => $year,
                     'message' => $message,
                     'link' => 'programming_allocation/nep/monthly_cash_program/division/'.$year, 
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
               CpCommentsModel::where('cash_program_id', $cash_program_id)->where('is_active', 1)->where('is_deleted', 0)
                  ->where('is_resolved', 0)->delete();          
               foreach($comment_by as $key => $value) {  
                  $comments[] = [                 
                     'cash_program_id' => $cash_program_id,
                     'comment' => $comment_by[$key],
                     'comment_by' => $user_role_id,                        
                     'is_resolved' => 0,
                  ];       
               }
               // dd($comments);
               CpCommentsModel::insert($comments);              
               return response()->json(array('success' => 1, 200));   
            }                      
            return Response::json(['errors' => $validator->errors()]);             
         }
      }  
   } 

   public function update(Request $request, User $user){      
      if ($request->ajax()) {   
         // dd($request->all());  
         $comment_by = $request->comment_by;
         $comment_by_division_director = $request->comment_by_division_director;   
         $comment_by_fad_budget = $request->comment_by_fad_budget;   
         $comment_by_bpac = $request->comment_by_bpac;    
         $comment_id = $request->comment_id; 
         $cash_program_id = $request->cash_program_id;   
         if($request->edit_cash_program==1) { //updating cash program item
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
               CashProgramsModel::find($request->get('id'))
                  ->update([                  
                     'pap_id' => $request->get('pap_id'),
                     'activity_id' => $request->get('activity_id'),
                     'subactivity_id' => $request->get('subactivity_id'),
                     'expense_account_id' => $request->get('expense_account_id'),
                     'object_expenditure_id' => $request->get('object_expenditure_id'),
                     'object_specific_id' => $request->get('object_specific_id'),
                     'pooled_at_division_id' => $request->get('pooled_at_division_id'),
                     'jan_amount' => $request->get('jan_amount'),
                     'feb_amount' => $request->get('feb_amount'),
                     'mar_amount' => $request->get('mar_amount'),
                     'apr_amount' => $request->get('apr_amount'),
                     'may_amount' => $request->get('may_amount'),
                     'jun_amount' => $request->get('jun_amount'),
                     'jul_amount' => $request->get('jul_amount'),
                     'aug_amount' => $request->get('aug_amount'),
                     'sep_amount' => $request->get('sep_amount'),
                     'oct_amount' => $request->get('oct_amount'),
                     'nov_amount' => $request->get('nov_amount'),
                     'dec_amount' => $request->get('dec_amount'),
                  ]);             
               return Response::json([
                  'success' => '1',          
                  'status' => '0'
               ]);
            }
            return Response::json(['errors' => $validator->errors()]);
         } 
         elseif($comment_by <> '') { 
            // dd($request->comment_id);
            // dd(isset($comment_by_fad_budget));
            // dd(isset($comment_by_division_director));
            // dd(isset($comment_by_bpac));
            if(isset($comment_by_division_director)){
               $count = count($comment_by_division_director); 
               dd($count);
               for ($i=0; $i < $count; $i++) {
                  $data = [
                     'comment_by_division_director' => $comment_by_division_director[$i],
                  ];
                  // dd($data);
               }  
               $messages = array(    
                  'comment_by_division_director.required' => 'Please input comment.',              
               );
               $validator =  Validator::make($data, [
                  'comment_by_division_director' => 'required',               
               ], $messages); 
              
               if ($validator->passes()) {                    
                  $with_existing=CpCommentsModel::where('id', $comment_id)->where('is_active', 1)->where('is_deleted', 0)->get(); 
                  $count1 = count($with_existing); 
                  dd(isset($with_existing));
                  // dd($with_existing);
                  if(isset($with_existing)){    
                     $count1 = count($comment_id);  
                     for ($i=0; $i < $count1; $i++) {    
                        CpCommentsModel::find($comment_id[$i])
                           ->update([ 
                              'comment' => $comment_by_division_director[$i],
                           ]);       
                     }  
                  }   
                  // else{
                  //    foreach($comment_by_division_director as $key => $value) {      
                  //       $comments[] = [                     
                  //          'cash_program_id' => $cash_program_id,
                  //          'comment' => $comment_by_division_director[$key],
                  //          'comment_by' => $comment_by,                        
                  //          'is_resolved' => 0,
                  //       ];                     
                  //    }
                  //    CpCommentsModel::insert($comments);   
                  // }
                  return response()->json(array('success' => 1, 200));     
               }       
               return Response::json(['errors' => $validator->errors()]);
            }
            elseif(isset($comment_by_fad_budget)){               
               $count = count($comment_by_fad_budget); 
               for ($i=0; $i < $count; $i++) {
                  $data = [
                     'comment_by_fad_budget' => $comment_by_fad_budget[$i],
                  ];
               }  
               $messages = array(    
                  'comment_by_fad_budget.required' => 'Please input comment.',              
               );
               $validator =  Validator::make($data, [
                  'comment_by_fad_budget' => 'required',               
               ], $messages); 
               // dd($data);
               if ($validator->passes()) {           
                  $count = count($request->comment_id);
                  // dd($request->comment_id);
                  // dd($request->comment_by_fad_budget);
                  for ($i=0; $i < $count; $i++) {   
                     // dd($request->comment_id[$i]); 
                     BpCommentsModel::find($request->comment_id[$i])
                        ->update([ 
                           'comment' => $request->comment_by_fad_budget[$i],
                        ]);       
                  }      
                  return response()->json(array('success' => 1, 200));     
               }       
               return Response::json(['errors' => $validator->errors()]);
            }
            elseif(isset($comment_by_bpac)){               
               $count = count($comment_by_bpac); 
               for ($i=0; $i < $count; $i++) {
                  $data = [
                     'comment_by_bpac' => $comment_by_bpac[$i],
                  ];
               }  
               $messages = array(    
                  'comment_by_bpac.required' => 'Please input comment.',              
               );
               $validator =  Validator::make($data, [
                  'comment_by_bpac' => 'required',               
               ], $messages); 
               // dd($data);
               if ($validator->passes()) {           
                  $count = count($request->comment_id);
                  // dd($request->comment_id);
                  // dd($request->comment_by_fad_budget);
                  for ($i=0; $i < $count; $i++) {   
                     // dd($request->comment_id[$i]); 
                     BpCommentsModel::find($request->comment_id[$i])
                        ->update([ 
                           'comment' => $request->comment_by_bpac[$i],
                        ]);       
                  }      
                  return response()->json(array('success' => 1, 200));     
               }       
               return Response::json(['errors' => $validator->errors()]);
            }
            else{
               return response()->json(array('success' => 1, 200));
            }
         }         
      }
   }

   public function show($id){ 
      $data = ViewCashProgramsModel::find($id);
      if($data->count()) {
         return Response::json([
         'status' => '1',
         'cash_program' => $data               
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
         if($request->delete_cash_program==1) { //updating cash program delete 1
            try {     
               CashProgramsModel::find($request->get('id'))
                  ->update([
                  'is_deleted' => '1'
               ]);
            }catch (\Exception $e) {
            return Response::json([
               'status'=>'0'
            ]);
            } 
         }
         elseif($request->delete_comment==1) { //updating cash program delete 1
            try {     
               CpCommentsModel::find($request->get('id'))
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
      $data = ViewCpCommentsModel::where('cash_program_id', $id)
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

   public function save_comment(Request $request){      
      // if ($request->ajax()) {   
         // if(isset($request->comment_by_division_director)){
            $comments = [];
            foreach($request->comment_by_division_director as $index => $value) {
            $comments[] = [
               'cash_program_id' => $request->cash_program_id,
               // 'comment_by_division_director' => $request->comment_by_division_director,
               'comment_by_division_director' => $request->comment_by_division_director[$index],
               // 'comment_by_division_director' => $request->comment_by_division_director,
            ];
            }
            // CpCommentsModel::insert($comments);
            dd($comments);
            // dd($request->all());
         // }
         // CpCommentsModel::insert($comments);
         // dd($comments);
         // $input = $request->all();
         // $comments = $request->input('comment_by_division_director');
         // $count = $comments->count();
         // dd($count);
         // foreach 
         //    $comment = new Comment;
         //    $comment->cash_program_id = $request->cash_program_id;
         //    $comment->comment_by_division_director = $comments[$i];              
         //    $comment->save();
         // }
         // if ($validator->passes()) {
         //    $data = new CpCommentsModel([
         //       'cash_program_id' => $request->cash_program_id,                  
         //       'comment_by_division_director' => $request->comment_by_division_director,
         //       'by_director_is_resolved' => $request->y_director_is_resolved ?? 0,
         //    ]);
         //    $data->save();   
         //    return Response::json(['success' => '1']); 
         // }
         return;         
      // }
   }
}
