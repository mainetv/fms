<?php

namespace App\Http\Controllers;

use App\Models\BpStatusModel;
use App\Models\BudgetProposalsModel;
use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\NotificationsModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Response;
use Carbon\Carbon;

class FiscalYearsController extends Controller
{	
	public function table(Request $request)
	{			
		if ($request->ajax()) { 			
			$data = FiscalYearsModel::where('is_deleted', 0)->orderby('year', 'ASC')->get();
			return DataTables::of($data)
				->addIndexColumn()
				->setRowAttr([
					// $lock='',
					'data-id' => function($fiscal_years) {
						return $fiscal_years->id;
					},
					'data-year' => function($fiscal_years) {
						return $fiscal_years->year;
				  	},
					'data-lock' => function($fiscal_years) {
						return $fiscal_years->lock;
				  	}		
				])
				->addColumn('file', function($row){
					if(!empty($row->filename)){
						$btn = "<a href=".asset('/uploads/files/'.$row->filename)." 
							target='_blank' data-toggle='tooltip' data-placement='auto' title='View File'><i class='fas fa-paperclip'></i></a>";
					}
					else{
						$btn = "";
					}
					return $btn;
				})
				->addColumn('action', function($row){
					$divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->get();					
					$options = '';
					foreach($divisions as $value){
						$options .= '<option id="all_divisions" value='.$value->id.' hidden>'.$value->id.'</option>';
				  	}
					$btn =
					"<div>
						<button class='actionbtn view-fiscal-years' type='button' data-toggle='tooltip' data-placement='top' title='View'> 
							<i class='fas fa-eye'></i></a>           
						</button>
						<button class='actionbtn update-fiscal-years' type='button' data-toggle='tooltip' data-placement='top' title='Update'>
							<i class='fas fa-edit blue'></i>
						</button>
						<button class='actionbtn delete-fiscal-years red' type='button' data-toggle='tooltip' data-placement='top' title='Delete'>
							<i class='fas fa-trash-alt red'></i>
						</button>
						<button class='actionbtn open-budget-proposal' type='button' data-toggle='tooltip' data-placement='top'					
						 title='Open Call For Budget Proposal'>
							<i class='fa-solid fa-bullhorn green'></i>
							<form action=".route('fiscal_years.store')." method='POST'>
								$options
							</form>
						</button>
						<button class='actionbtn close-budget-proposal' type='button'
						data-toggle='tooltip' data-placement='top' title='Close Call For Budget Proposal'>
						<i class='fa-solid fa-lock red'></i>
							<form action=".route('fiscal_years.close')." method='PATCH'>
								$options
							</form>
						</button>
					</div>
					";
					return $btn;
				})
				->rawColumns(['file'], ['action'])
				->make(true);
		}      
	}

	/**
	 * Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{   	     
		$now = Carbon::now()->timezone('Asia/Manila')->format('Ymd.His');	
		$created_at = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');
		if ($request->ajax()) { //post fiscal years
         $message = array(    
            'year.required' => 'Please select year.',      
            'fiscal_year1.required' => 'Please select fiscal year 1',      
            'fiscal_year2.required' => 'Please select fiscal year 2.', 
            'fiscal_year3.required' => 'Please select fiscal year 3.',             
            'open_date_from.required' => 'Open date from field is required.', 
            'open_date_to.required' => 'Open date to field is required.', 
         );
         $validator =  Validator::make($request->all(), [
            'year' => 'required',
            'fiscal_year1' => 'required',
            'fiscal_year2' => 'required',
            'fiscal_year3' => 'required',
            'open_date_from' => 'required',
            'open_date_to' => 'required',
				'filename' => 'mimes:doc,docx,csv,txt,xlx,xlsm,xlsx,pdf|max:2048'
         ], $message);

         $input = $request->all();
         if ($validator->passes()) {
				$year = $request->get('year');	
				$fiscal_year1 = $request->get('fiscal_year1');	
				$fiscal_year3 = $request->get('fiscal_year3');	
				$open_date_from = $request->get('open_date_from');	
				$open_date_to = $request->get('open_date_to');	

				if($request->hasFile('upload_file')){			
					$file = $request->file('upload_file');		
					// $filename = $file->getClientOriginalName();
					$filename = $now . '_Y'.$year.'.' . $file->getClientOriginalExtension();	
					$path = public_path('uploads/files');									
					//save the file to my path
					$file->move($path , $filename);
					// $file->storeAs($path, $filename);
				}

            $data = new FiscalYearsModel([
               'year' => $year,
               'fiscal_year1' => $fiscal_year1,
               'fiscal_year2' => $request->get('fiscal_year2'),
               'fiscal_year3' => $fiscal_year3,
               'open_date_from' => $open_date_from,
               'open_date_to' => $open_date_to,  
					'filename' => $filename ?? '',
               'is_active' => $request->get('is_active'),
            ]);		
            $data->save(); 			

				$all_divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->get(); 
				$user_id = auth()->user()->id; 
				$user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first(); 
				
				foreach($all_divisions as $value)
				{
					//add initial budget proposal status for all division
					$data1[] =[
						'division_id' => $value->id,
						'year' => $year,
						'status_id' => '1',
						'status_by_user_id' => auth()->user()->id,
               	'status_by_user_role_id' => auth()->user()->user_role_id,
						'is_active' => '1',
					];

					//add notifications for division budget officers user for all divisions
					$data2[] =[
						'message' => 'Call for submission of Budget Proposal FY '.$fiscal_year1.'-'.$fiscal_year3.' is now open from '.$open_date_from.' to '.$open_date_to,
						'module_id' => '2',
						'year' => $year,
						'division_id_from' => $user_division_id,
						'division_id_to' => $value->id,
						'user_id_from' => auth()->user()->id, //user id from
						'user_role_id_to' => '7', //division budget controllers user role id
					];
					
					//add notifications for division director user for all divisions
					$data3[] =[
						'message' => 'Call for submission of Budget Proposal FY '.$fiscal_year1.'-'.$fiscal_year3.' is now open from '.$open_date_from.' to '.$open_date_to,
						'module_id' => '2',
						'year' => $year,
						'division_id_from' => $user_division_id,
						'division_id_to' => $value->id,
						'user_id_from' => auth()->user()->id, //user id from
						'user_role_id_to' => '6', //division director user role id
					];

					
				}				
				BpStatusModel::insert($data1); // Eloquent approach
				NotificationsModel::insert($data2); // Eloquent approach  
				NotificationsModel::insert($data3); // Eloquent approach  

            return Response::json(['success' => '1']); 
         }
			// return Response::json(['success' => '1']); 
         return Response::json(['errors' => $validator->errors()]);
      }		
   } 

	/**
	 * Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show(Request $request)
	{
		if($request->ajax()){
		  $fiscal_years = FiscalYearsModel::find($request->get('id'));
		  if($fiscal_years->count()) {
			 return Response::json([
				'status' => '1',
				'fiscal_years' => $fiscal_years
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
	* @param  \App\Models\FiscalYearsModel  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request)
   {
      if ($request->ajax()) {
         $message = array(    
            'year.required' => 'Please select year.',      
            'fiscal_year1.required' => 'Please select fiscal year 1',      
            'fiscal_year2.required' => 'Please select fiscal year 2.', 
            'fiscal_year3.required' => 'Please select fiscal year 3.', 
            'open_date_from.required' => 'Open date from field is required.', 
            'open_date_to.required' => 'Open date to field is required.', 
         );
         $validator =  Validator::make($request->all(), [
            'year' => 'required',
            'fiscal_year1' => 'required',
            'fiscal_year2' => 'required',
            'fiscal_year3' => 'required',
            'open_date_from' => 'required',
            'open_date_to' => 'required',
         ], $message);
         
         $input = $request->all();
         
         if ($validator->passes()) {
            FiscalYearsModel::find($request->get('id'))
               ->update([                  
                  'year' => $request->get('year'),
						'fiscal_year1' => $request->get('fiscal_year1'),
						'fiscal_year2' => $request->get('fiscal_year2'),
						'fiscal_year3' => $request->get('fiscal_year3'),
						'open_date_from' => $request->get('open_date_from'),
						'open_date_to' => $request->get('open_date_to'),
						'is_locked' => $request->get('is_locked'),
						'is_active' => $request->get('is_active'),
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
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete(Request $request)
	{
		if($request->ajax()) {
			try {     
			FiscalYearsModel::find($request->get('id'))
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

	public function close(Request $request)
	{
		if($request->ajax()) {			
			$all_divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->get();
			try {    				
				FiscalYearsModel::find($request->get('id'))
					->update([
						'is_locked' => '1'
					
					]);				
				foreach($all_divisions as $value)
				{			
					BudgetProposalsModel::where('is_locked',0)->where('year',$request->year)
						->update([
							'is_locked' => '1'				
						]);
				}	
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
