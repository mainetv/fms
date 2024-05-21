<?php

namespace App\Http\Controllers;

use App\Models\BpForm4Model;
use App\Models\FiscalYearsModel;
use App\Models\ViewFiscalYearsModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;
use Validator;
use Response;
use Redirect;
use Session;
use View;

class BpForm4Controller extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($year_selected)
   {
      $title = "BP Forms";   
      $subtitle = "BP Form 4";   
      $username = auth()->user()->username;
      $user_id = auth()->user()->id;  
      $user_role_id = auth()->user()->user_role_id; 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();     
      foreach($user_roles as $row){
         $user_roles_data []= [
            "user_role" => $row->user_role,
            "user_role_id" => $row->role_id,  
         ];
      }
      $years = FiscalYearsModel::orderBy('year', 'ASC')->get();
      $data = [
         "year_selected" => $year_selected,
      ];   
      $fy1 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year1 as fiscal_year')
         ->where('year','=',$year_selected)
         ->where('is_active','=',1)
         ->where('is_deleted','=',0);
      $fy2 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year2 as fiscal_year')
         ->where('year','=',$year_selected)
         ->where('.is_active','=',1)
         ->where('is_deleted','=',0);
      $fiscal_years = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year3 as fiscal_year')
         ->where('year','=',$year_selected)->where('.is_active','=',1)->where('is_deleted','=',0)
         ->union($fy1)->union($fy2)->orderBy('fiscal_year', 'ASC')->get();
      $bp_form4 = BpForm4Model::where('year', $year_selected)->where("is_active", 1)->where("is_deleted", 0)->get();   
      // dd($data);
      return view('budget_preparation.bp_forms.bp_form4.fy_tabs')
         ->with(compact('title'), $title)
         ->with(compact('subtitle'), $subtitle)
         ->with(compact('data'),$data)
         ->with(compact('username'), $username)
         ->with(compact('user_id'))
         ->with(compact('user_roles'))
         ->with(compact('user_role'), $user_role)
         ->with(compact('user_role_id'), $user_role_id)
         ->with(compact('user_division_id'), $user_division_id)
         ->with(compact('user_fullname'), $user_fullname)   
         ->with(compact('fiscal_years'), $fiscal_years)      
         ->with(compact('years'), $years)      
         ->with(compact('bp_form4'), $bp_form4); 
   }

   public function generatePDF(Request $request, $division_id, $year)
   {      
      if ($request->ajax()) {
         $year = $request->year;
         view()->share('year', $year);
         $pdf = App::make('dompdf.wrapper');
         $pdf->loadView('budget_preparation.bp_form.bp_form_pdf')
            ->set_paper('letter', 'portait');
         return $pdf->stream(); 
      }
      else{
         return view('budget_preparation.bp_forms.bp_form4.pdf')
            ->with('division_id', $division_id)
            ->with('year', $year);
      }
   } 

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {      
      if ($request->ajax()) {
         // dd($request);
         $message = array(    
            'tier.required' => 'Please select tier.',      
            'description.required' => 'Description field is required.',      
            'amount.required' => 'Amount needed field is require and should be a number',      
            'num_years_completion.required' => 'No. of Years of Completion field is required and should be a number.', 
            'date_started.required' => 'Date started field is required.', 
            'total_cost.required' => 'Total cost field is required and should be a number.', 
            'justification.required' => 'Justification field is required.', 
         );
         $validator =  Validator::make($request->all(), [
            'tier' => 'required',
            'description' => 'required',
            'amount' => 'required', 'integer',
            'num_years_completion' => 'required',
            'date_started' => 'required',
            'total_cost' => 'required', 'integer',
            'justification' => 'required',
         ], $message);

         $input = $request->all();
         if ($validator->passes()) {
            $data = new BpForm4Model([
               'division_id' => $request->get('division_id'),
               'year' => $request->get('year'),
               'tier' => $request->get('tier'),
               'fiscal_year' => $request->get('fiscal_year'),
               'description' => $request->get('description'),
               'amount' => $request->get('amount'),
               'num_years_completion' => $request->get('num_years_completion'),
               'date_started' => $request->get('date_started'),
               'total_cost' => $request->get('total_cost'),
               'justification' => $request->get('justification'),
               'remarks' => $request->get('remarks'),
            ]);
            $data->save();   
            return Response::json(['success' => '1']); 
         }
         return Response::json(['errors' => $validator->errors()]);
      }
   } 

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\BpForm4Model  $BpForm4Model
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request)
   {
      if($request->ajax()){
         $data = BpForm4Model::find($request->get('id'));
         if($data->count()) {
            return Response::json([
            'status' => '1',
            'bp_form4' => $data
            ]);
         } 
         else {
            return Response::json([
            'status' => '0'
            ]);
         } 
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\BpForm4Model  $BpForm4Model
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request)
   {
      if ($request->ajax()) {
         // dd($request->all()); exit();
         $message = array(
            'tier.required' => 'Please select tier.',      
            'description.required' => 'Description field is required.',      
            'amount.required' => 'Amount needed field is require and should be a number',      
            'num_years_completion.required' => 'No. of Years of Completion field is required and should be a number.', 
            'date_started.required' => 'Date started field is required.', 
            'total_cost.required' => 'Total cost field is required and should be a number.', 
            'justification.required' => 'Justification field is required.', 
         );
         $validator =  Validator::make($request->all(), [
            'tier' => 'required',
            'description' => 'required',
            'amount' => 'required', 'integer',
            'num_years_completion' => 'required',
            'date_started' => 'required',
            'total_cost' => 'required', 'integer',
            'justification' => 'required',
         ], $message);
         
         $input = $request->all();
         
         if ($validator->passes()) {
            BpForm4Model::find($request->get('id'))
               ->update([
                  'tier' => $request->get('tier'),
                  'description' => $request->get('description'),
                  'amount' => $request->get('amount'),
                  'num_years_completion' => $request->get('num_years_completion'),
                  'date_started' => $request->get('date_started'),
                  'total_cost' => $request->get('total_cost'),
                  'justification' => $request->get('justification'),
                  'remarks' => $request->get('remarks'),
               ]);             
            return Response::json([
               'success' => '1',          
               'status' => '0'
               ]);
         }     
         return Response::json(['errors' => $validator->errors()]);
         }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\BpForm4Model  $BpForm4Model
    * @return \Illuminate\Http\Response
    */
   public function delete(Request $request, BpForm4Model $BpForm4Model)
   {
      if($request->ajax()) {
         try {     
            BpForm4Model::find($request->get('id'))
             ->update([
             'is_deleted' => '1'
           ]);
         }catch (\Exception $e) {
           return Response::json([
             'status'=>'0'
           ]);
         }
         return Response::json([
           'status'=>'1'
         ]);
       }
   }
}
