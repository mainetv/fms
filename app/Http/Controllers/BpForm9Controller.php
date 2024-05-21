<?php

namespace App\Http\Controllers;

use App\Models\BpForm9Model;
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

class BpForm9Controller extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($year_selected)
   {
      $title = "BP Forms";   
      $subtitle = "BP Form 9";   
      $username = auth()->user()->username;
      $user_id = auth()->user()->id;  
      $user_role_id = auth()->user()->user_role_id; 
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
      $years = FiscalYearsModel::orderBy('year', 'ASC')->get();
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();     
      foreach($user_roles as $row){
         $user_roles_data []= [
            "user_role" => $row->user_role,
            "user_role_id" => $row->role_id,  
         ];
      }
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
      $bp_form9 = BpForm9Model::where('year', $year_selected)->where("is_active", 1)->where("is_deleted", 0)->get();   
      return view('budget_preparation.bp_forms.bp_form9.fy_tabs')
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
         ->with(compact('bp_form9'), $bp_form9);
   }

   public function table(Request $request)
   {
      $year = Carbon::now()->format('Y');
      if ($request->ajax()) { 
         if(!empty($request->year_selected)){
            $data = BpForm9Model::where('year', $request->year_selected)
               ->where('is_deleted', 0)->latest();		
         }   
         else{
            $data = BpForm9Model::where('year', $year)
               ->where('is_deleted', 0)->latest();
         }
         return DataTables::of($data)
            ->addIndexColumn()
            ->setRowAttr([
               'data-id' => function($bp_form9) {
               return $bp_form9->id;
               }
            ])
            ->addColumn('action', function($row){
               $btn =
               "<div>
                  <button class='actionbtn view-bp-form9' type='button'> 
                  <i class='fas fa-eye'></i></a>                    
                  </button>
                  <button class='actionbtn update-bp-form9' type='button'>
                  <i class='fas fa-edit blue'></i>
                  </button>
                  <button class='actionbtn delete-bp-form9 red' type='button'>
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
         $message = array(    
            'description.required' => 'Description field is required.',      
            'quantity.required' => 'Quantity needed field is require and should be a number',      
            'unit_cost.required' => 'Unit cost field is required and should be a number.', 
            'total_cost.required' => 'Total cost field is required.', 
            'organizational_deployment.required' => 'Organizational Deployment field is required.', 
            'justification.required' => 'Justification field is required.', 
         );
         $validator =  Validator::make($request->all(), [
            'description' => 'required',
            'quantity' => 'required', 'integer',
            'unit_cost' => 'required', 'integer',
            'total_cost' => 'required', 'integer',
            'organizational_deployment' => 'required',
            'justification' => 'required',
         ], $message);

         $input = $request->all();
         if ($validator->passes()) {
            $data = new BpForm9Model([
               'division_id' => $request->get('division_id'),
               'year' => $request->get('year'),
               'fiscal_year' => $request->get('fiscal_year'),
               'description' => $request->get('description'),
               'quantity' => $request->get('quantity'),
               'unit_cost' => $request->get('unit_cost'),
               'total_cost' => $request->get('total_cost'),
               'organizational_deployment' => $request->get('organizational_deployment'),
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
    * @param  \App\Models\BpForm9Model  $BpForm9Model
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request)
   {
      if($request->ajax()){
         $data = BpForm9Model::find($request->get('id'));
         if($data->count()) {
            return Response::json([
            'status' => '1',
            'bp_form9' => $data
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
    * @param  \App\Models\BpForm9Model  $BpForm9Model
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request)
   {
      if ($request->ajax()) {
         // dd($request->all()); exit();
         $message = array(
            'description.required' => 'Description field is required.',      
            'quantity.required' => 'Quantity needed field is require and should be a number',      
            'unit_cost.required' => 'Unit cost field is required and should be a number.', 
            'total_cost.required' => 'Total cost field is required.', 
            'organizational_deployment.required' => 'Organizational Deployment field is required.', 
            'justification.required' => 'Justification field is required.', 
         );
         $validator =  Validator::make($request->all(), [
            'description' => 'required',
            'quantity' => 'required', 'integer',
            'unit_cost' => 'required', 'integer',
            'total_cost' => 'required', 'integer',
            'organizational_deployment' => 'required',
            'justification' => 'required',
         ], $message);
         
         $input = $request->all();
         
         if ($validator->passes()) {
            BpForm9Model::find($request->get('id'))
               ->update([
                  'description' => $request->get('description'),
                  'quantity' => $request->get('quantity'),
                  'unit_cost' => $request->get('unit_cost'),
                  'total_cost' => $request->get('total_cost'),
                  'organizational_deployment' => $request->get('organizational_deployment'),
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
    * @param  \App\Models\BpForm9Model  $BpForm9Model
    * @return \Illuminate\Http\Response
    */
   public function delete(Request $request, BpForm9Model $BpForm9Model)
   {
      if($request->ajax()) {
         try {     
            BpForm9Model::find($request->get('id'))
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
