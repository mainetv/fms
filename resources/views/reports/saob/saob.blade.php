@extends('layouts.app')

@php
	$getAllActiveDivisions=getAllActiveDivisions();
	$getRDDivisions=getRDDivisions();
	$getARMMSDivisions=getARMMSDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
@endphp

@section('content') 
	<section class="content">
		<div class="card text-left">
			<div class="card-header row">
				<div class="col-10">
					<h5 class="font-weight-bold">
						Statement of Allotment and Obligation (SAOB)
					</h5> 
				</div>
				<div class="col float-right">    
					{{-- <div class="col-2">
						<a target="_blank" href="{{ route('division_proposals.generatePDF', ['division_id'=>$division_id, 'year'=>$year_selected],'year'=>$year_selected) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
					</div> --}}
					<button class="print btn"  data-toggle="tooltip" data-placement='auto'title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button>
					<button class="export_to_excel btn" onclick="exportToExcel(this)" data-toggle="tooltip" data-placement='auto'title='Export to Excel'>
						<img src="{{ asset('/images/export-to-excel.png') }}" width="50px"></img></button>
				</div>    
			</div>   
			<div class="card-body">
				<div class="row">	
					<div class="col"> 			
						<label>Request and Status Type:</label>   
						<select name="rstype_id_selected" id="rstype_id_selected" onchange="changeFilter()">               
							@foreach ($getRSTypes as $row)
								<option value="{{ $row->id }}" @if(isset($row->id) && $rstype_id_selected==$row->id) selected @endif> 
									{{ $row->request_status_type }}</option>
							@endforeach    
						</select>&emsp;
						@role('Super Administrator|Administrator|Budget Officer|BPAC Chair')			
						<label>Responsibility Center: </label> 			
							<select name="division_id" id="division_id" onchange="changeFilter()">
								@if($user_division_id == 20)
									@foreach($getRDDivisions as $row)
										<option value="{{ $row->id }}" {{ $division_id == $row->id ? 'selected' : '' }}>
											{{ $row->division_acronym }}
										</option>
									@endforeach
								@elseif($user_division_id == 21)
									@foreach($getARMMSDivisions as $row)
										<option value="{{ $row->id }}" {{ $division_id == $row->id ? 'selected' : '' }}>
											{{ $row->division_acronym }}
										</option>
									@endforeach								
								@elseif($user_division_id == 7)
									@if($rstype_id_selected == 1)						
										<option value="all" {{ $division_id == 'all' ? 'selected' : '' }}>All</option>
									@endif
									@foreach($getAllActiveDivisions as $row)
										<option value="{{ $row->id }}" {{ $division_id == $row->id ? 'selected' : '' }}>
											{{ $row->division_acronym }}
										</option>
									@endforeach
								@endif
							</select>
						@else
							<input type="text" id="division_id" value="{{ $division_id }}" hidden>
						@endrole
						&nbsp;		
						<label>Year: </label>
						<select name="year_selected" id="year_selected" onchange="changeFilter()">    
							@if($rstype_id_selected!=1)
								<option value="all">All</option> 
							@else     
								@foreach ($getYears as $row)
									<option value="{{ $row->year }}" data-selected="{{ $row->id }}" 
										@if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif> {{ $row->year }}</option>
								@endforeach    
							@endif
						</select>&nbsp;
						<label>View: </label>
						<select name="view_selected" id="view_selected" onchange="changeFilter()">
							<option value="annual" @if ($view_selected == 'annual') selected @endif>Annual</option>
							@if($rstype_id_selected==1)
								<option value="q1" @if($view_selected == 'q1') selected @endif>1st Quarter</option>         
								<option value="q2" @if($view_selected == 'q2') selected @endif>2nd Quarter</option>         
								<option value="q3" @if($view_selected == 'q3') selected @endif>3rd Quarter</option>         
								<option value="q4" @if($view_selected == 'q4') selected @endif>4th Quarter</option>   
								<option value="01" @if($view_selected=='01') selected @endif>January</option>
								<option value="02" @if($view_selected=='02') selected @endif>February</option>
								<option value="03" @if($view_selected=='03') selected @endif>March</option>
								<option value="04" @if($view_selected=='04') selected @endif>April</option>
								<option value="05" @if($view_selected=='05') selected @endif>May</option>
								<option value="06" @if($view_selected=='06') selected @endif>June</option>
								<option value="07" @if($view_selected=='07') selected @endif>July</option>
								<option value="08" @if($view_selected=='08') selected @endif>August</option>
								<option value="09" @if($view_selected=='09') selected @endif>September</option>
								<option value="10" @if($view_selected=='10') selected @endif>October</option>
								<option value="11" @if($view_selected=='11') selected @endif>November</option>
								<option value="12" @if($view_selected=='12') selected @endif>December</option>
							@endif
							
						</select>
					</div>	
				</div>	

				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table width="100%" class="table-hover table2excel" id="saob_table" >
								<thead class="text-center">
									<th width="70%">ACTIVITY / Object of Expenditures</th>
									<th width="10%">Allotment</th>
									<th width="10%">Obligation</th>
									<th width="10%">Balance</th>
								</thead>	
								<tbody><?php			
									$total_allotment=0;														
									$total_obligation=0;														
									$total_balance=0;														
									$q1_adjustment=0;														
									$q2_adjustment=0;														
									$q3_adjustment=0;														
									$q4_adjustment=0;											
									if($rstype_id_selected==1 && $division_id==5){
										//All FAD and FAD pooled under FAD
										// $data = DB::table('view_saob')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
										// 	->where('is_active', 1)->where('is_deleted', 0)->where('parent_division_id', $division_id)
										// 	->where(function ($query) use ($division_id) {
										// 			$query->where('parent_pooled_at_division_id','=',$division_id)
										// 				->orWhereNull('pooled_at_division_id')
										// 				->orWhere('pooled_at_division_id','=',$division_id);
										// 		})
										// 	->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
										// 	->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
										// 	->groupBy('id')->get();

										$data = DB::table("view_allotment")->select("view_allotment.*",
											DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
											)									
											->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
											->where('parent_division_id', $division_id)
											->where(function ($query) use ($division_id) {
												$query->where('parent_pooled_at_division_id','=',$division_id)
													->orWhereNull('pooled_at_division_id')
													->orWhere('pooled_at_division_id','=',$division_id);
											})	
											->where('is_active', 1)->where('is_deleted', 0)
											->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
											->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
											->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
											->orderBy('pooled_at_division_id','ASC')
											->groupBy('id')->get();
					
										//All pooled at FAD even under FAD division
										// $data1 = DB::table('view_saob')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
										// 	->where('is_active', 1)->where('is_deleted', 0)
										// 	->where(function ($query) {
										// 			$query->where('pooled_at_division_id','=',5)
										// 				->orWhere('parent_pooled_at_division_id','=',5);
										// 		})
										// 	->orderBy('object_expenditure', 'ASC')->orderBy('division_acronym', 'ASC')->groupBy('id')->get();
										
										$data1 = DB::table("view_allotment")->select("view_allotment.*",
											DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
											)									
											->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
											->where(function ($query) {
													$query->where('pooled_at_division_id','=',5)
														->orWhere('parent_pooled_at_division_id','=',5);
												})
											->where('is_active', 1)->where('is_deleted', 0)
											->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
											->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
											->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
											->orderBy('pooled_at_division_id','ASC')
											->groupBy('id')->get();
										
										//Grand total of all FAD and FAD pooled under FAD
										// $data2 = DB::table('view_saob')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
										// 	->where('is_active', 1)->where('is_deleted', 0)->where('parent_division_id', $division_id)
										// 	->where(function ($query) use ($division_id){
										// 		$query->where(function ($query) use ($division_id){
										// 			$query->where('parent_pooled_at_division_id','=',$division_id)
										// 					->orWhereNull('pooled_at_division_id')
										// 					->orWhere('pooled_at_division_id','=',$division_id);
										// 			});
										// 	})
										// 	->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
										// 	->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
										// 	->groupBy('id')->get();
										
										$data2 = DB::table("view_allotment")->select("view_allotment.*",
											DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
											)									
											->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
											->where(function ($query) use ($division_id){
												$query->where(function ($query) use ($division_id){
													$query->where('parent_pooled_at_division_id','=',$division_id)
															->orWhereNull('pooled_at_division_id')
															->orWhere('pooled_at_division_id','=',$division_id);
													});
											})
											->where('is_active', 1)->where('is_deleted', 0)
											->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
											->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
											->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
											->orderBy('pooled_at_division_id','ASC')
											->groupBy('id')->get();
									}		
									elseif($rstype_id_selected==1 && $division_id=='all'){										
										// $data = DB::table('view_saob')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
										// 	->where('is_active', 1)->where('is_deleted', 0)
										// 	->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
										// 	->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
										// 	->orderByRaw('(object_specific_id is not null) ASC')
										// 	->orderBy('pooled_at_division_id','ASC')
										// 	->groupBy('id')->get();
										
										$data = DB::table("view_allotment")->select("view_allotment.*",
											DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
											)
											->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
											->where('is_active', 1)->where('is_deleted', 0)
											->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
											->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
											->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
											->orderBy('pooled_at_division_id','ASC')
											->groupBy('id')->get();
									}
									elseif($rstype_id_selected==1 && $division_id!='all'){										
										// $data = DB::table('view_saob')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
										// 	->where('is_active', 1)->where('is_deleted', 0)
										// 	->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
										// 	->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
										// 	->orderByRaw('(object_specific_id is not null) ASC')
										// 	->orderBy('pooled_at_division_id','ASC')
										// 	->groupBy('id')->get();
										
										$data = DB::table("view_allotment")->select("view_allotment.*",
											DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
											)
											->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)->where('division_id', $division_id)
											->where('is_active', 1)->where('is_deleted', 0)
											->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
											->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
											->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
											->orderBy('pooled_at_division_id','ASC')
											->groupBy('id')->get();
									}
									elseif($rstype_id_selected!=1 && $year_selected=='all'){
										// $data = DB::table('saob')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
										// 	->where('division_id', $division_id)
										// 	->where('is_active', 1)->where('is_deleted', 0)
										// 	->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
										// 	->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
										// 	->orderByRaw('(object_specific_id is not null) ASC')
										// 	->orderBy('pooled_at_division_id','ASC')
										// 	->groupBy('id')->get();
											
										$data = DB::table("view_allotment")->select("view_allotment.*",
											DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
												AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
												AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
												AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
												AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
											)
											->where('rs_type_id', $rstype_id_selected)->where('division_id', $division_id)
											->where('is_active', 1)->where('is_deleted', 0)
											->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
											->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
											->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
											->orderBy('pooled_at_division_id','ASC')
											->groupBy('id')->get();
									}
									// dd($data);
									if($rstype_id_selected==1){
										foreach($data->groupBY('pap_code') as $key1=>$row1){
											foreach($row1 as $item1) {} //item 1?>
											<tr>
												<td class="pap font-weight-bold gray2-bg" colspan="5">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
											</tr><?php 										
											foreach($data->where('pap_id', $item1->pap_id)
											->groupBY('activity_id') as $key2=>$row2){
												foreach($row2 as $item2) {} //item 2?>
												<tr>
													<td class="activity1 font-weight-bold" colspan="5">{{ $item2->activity }}</td>													
												</tr><?php 										
												foreach($data->where('pap_id', $item1->pap_id)
												->where('activity_id', $item2->activity_id)
												->groupBY('subactivity_id') as $key3=>$row3){
													foreach($row3 as $item3) {} 
													if(isset($item3->subactivity)){//item 3?>
														<tr class="text-right"><?php	
															if($item2->activity_id==24){
																$q1_allotment = $row3->sum('q1_allotment') + $row3->sum('q1_adjustment');
																$q2_allotment = $q1_allotment + $row3->sum('q2_allotment') + $row3->sum('q2_adjustment');
																$q3_allotment = $q2_allotment + $row3->sum('q3_allotment') + $row3->sum('q3_adjustment');
																$q4_allotment = $q3_allotment + $row3->sum('q4_allotment') + $row3->sum('q4_adjustment');
																$q1_obligation = $row3->sum('q1_obligation');
																$q2_obligation = $q1_obligation + $row3->sum('q2_obligation');
																$q3_obligation = $q2_obligation + $row3->sum('q3_obligation');
																$q4_obligation = $q3_obligation + $row3->sum('q4_obligation');
																$q1_balance = $q1_allotment - $q1_obligation;
																$q2_balance = $q2_allotment - $q2_obligation;
																$q3_balance = $q3_allotment - $q3_obligation;
																$q4_balance = $q4_allotment - $q4_obligation;
																$total_allotment = $q4_allotment;
																$total_obligation = $q4_obligation;
																$total_balance = $total_allotment - $total_obligation;?>
																	<td class="subactivity1 font-weight-bold gray3-bg">{{ $item3->subactivity }}</td>
																	@if($view_selected == 'annual')
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>														
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>													
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>		
																	@elseif($view_selected == 'q1')		
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q1_allotment, 2) }}</td>													
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q1_obligation, 2) }}</td>													
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q1_balance, 2) }}</td>		
																	@elseif($view_selected == 'q2')		
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q2_allotment, 2) }}</td>													
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q2_obligation, 2) }}</td>													
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q2_balance, 2) }}</td>	
																	@elseif($view_selected == 'q3')		
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q3_allotment, 2) }}</td>													
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q3_obligation, 2) }}</td>													
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q3_balance, 2) }}</td>	
																	@elseif($view_selected == 'q4')		
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q4_allotment, 2) }}</td>													
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q4_obligation, 2) }}</td>													
																		<td class="font-weight-bold gray3-bg">&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>		
																	@endif	
																<?php
															}
															else{?>
																<td class="subactivity1 font-weight-bold" colspan="5">{{ $item3->subactivity }}</td><?php
															}?>									
														</tr><?php 
													}										
													foreach($data->where('pap_id', $item1->pap_id)
													->where('activity_id', $item2->activity_id)
													->where('subactivity_id', $item3->subactivity_id)
													->groupBY('expense_account_id') as $key4=>$row4){
														foreach($row4 as $item4) {}//item 4
														$q1_allotment = $item4->q1_allotment + $item4->q1_adjustment;
														$q2_allotment = $q1_allotment + $item4->q2_allotment + $item4->q2_adjustment;
														$q3_allotment = $q2_allotment + $item4->q3_allotment + $item4->q3_adjustment;
														$q4_allotment = $q3_allotment + $item4->q4_allotment + $item4->q4_adjustment;											
														$q1_obligation = $item4->q1_obligation;
														$q2_obligation = $q1_obligation + $item4->q2_obligation;
														$q3_obligation = $q2_obligation + $item4->q3_obligation;
														$q4_obligation = $q3_obligation + $item4->q4_obligation;
														$q1_balance = $q1_allotment - $q1_obligation;
														$q2_balance = $q2_allotment - $q2_obligation;
														$q3_balance = $q3_allotment - $q3_obligation;
														$q4_balance = $q4_allotment - $q4_obligation;
														$total_allotment = $q4_allotment;
														$total_obligation = $q4_obligation;
														$total_balance = $total_allotment - $total_obligation;?>
														<tr>
															<td class="expense1 font-weight-bold" colspan="5">{{ $item4->expense_account }}</td>														
														</tr>
														<?php
														if($division_id==5 || $division_id=='All'){ //fad
															foreach($data->where('pap_id', $item1->pap_id)
																->where('activity_id', $item2->activity_id)
																->where('subactivity_id', $item3->subactivity_id)
																->where('expense_account_id', $item4->expense_account_id)
																->whereNull('object_specific_id')
																->groupBY('object_expenditure_id') as $key5=>$row5){
																foreach($row5 as $item5) {}//item 4
																$q1_allotment=$row5->sum('q1_allotment') + $row5->sum('q1_adjustment'); 
																$q2_allotment=$q1_allotment + $row5->sum('q2_allotment') + $row5->sum('q2_adjustment'); 
																$q3_allotment=$q2_allotment + $row5->sum('q3_allotment') + $row5->sum('q3_adjustment'); 
																$q4_allotment=$q3_allotment + $row5->sum('q4_allotment') + $row5->sum('q4_adjustment'); 													
																$q1_obligation=$row5->sum('q1_obligation'); 	
																$q2_obligation=$q1_allotment + $row5->sum('q2_obligation');	
																$q3_obligation=$q2_allotment + $row5->sum('q3_obligation');	
																$q4_obligation=$q3_allotment + $row5->sum('q4_obligation');	
																$q1_balance = $q1_allotment - $q1_obligation;
																$q2_balance = $q2_allotment - $q2_obligation;
																$q3_balance = $q3_allotment - $q3_obligation;
																$q4_balance = $q4_allotment - $q4_obligation;
																$total_allotment = $q4_allotment;
																$total_obligation = $q4_obligation;
																$total_balance = $total_allotment - $total_obligation;?>
																<tr class="text-right">
																	<td class="objexp1">{{ $item5->object_code }}: {{ $item5->object_expenditure }}
																		@if($item5->pooled_at_division_id != NULL) 
																		- Pooled at {{ $item5->pooled_at_division_acronym }} ({{ $item5->division_acronym }})@endif
																	</td>		
																	@if($view_selected == 'annual')
																		<td class="yellow-bg">{{ convert_number_format($total_allotment, 2) }}</td>															
																		<td class="lightgreen-bg">{{ convert_number_format($total_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($total_balance, 2) }}</td>		
																	@elseif($view_selected == 'q1')		
																		<td class="yellow-bg">{{ convert_number_format($q1_allotment, 2) }}</td>														
																		<td class="lightgreen-bg">{{ convert_number_format($q1_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($q1_balance, 2) }}</td>		
																	@elseif($view_selected == 'q2')		
																		<td class="yellow-bg">{{ convert_number_format($q2_allotment, 2) }}</td>														
																		<td class="lightgreen-bg">{{ convert_number_format($q2_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($q2_balance, 2) }}</td>	
																	@elseif($view_selected == 'q3')		
																		<td class="yellow-bg">{{ convert_number_format($q3_allotment, 2) }}</td>														
																		<td class="lightgreen-bg">{{ convert_number_format($q3_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($q3_balance, 2) }}</td>	
																	@elseif($view_selected == 'q4')		
																		<td class="yellow-bg">{{ convert_number_format($q4_allotment, 2) }}</td>														
																		<td class="lightgreen-bg">{{ convert_number_format($q4_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($q4_balance, 2) }}</td>		
																	@endif										
																</tr><?php
															}
															foreach($data->where('pap_id', $item1->pap_id)
																->where('activity_id', $item2->activity_id)
																->where('subactivity_id', $item3->subactivity_id)
																->where('expense_account_id', $item4->expense_account_id)
																->whereNotNull('object_specific_id')
																->groupBY('object_expenditure_id') as $key5=>$row5){
																foreach($row5 as $item5) {}//item 4
																$q1_allotment=$row5->sum('q1_allotment') + $row5->sum('q1_adjustment'); 
																$q2_allotment=$q1_allotment + $row5->sum('q2_allotment') + $row5->sum('q2_adjustment'); 
																$q3_allotment=$q2_allotment + $row5->sum('q3_allotment') + $row5->sum('q3_adjustment'); 
																$q4_allotment=$q3_allotment + $row5->sum('q4_allotment') + $row5->sum('q4_adjustment'); 													
																$q1_obligation=$row5->sum('q1_obligation'); 	
																$q2_obligation=$q1_allotment + $row5->sum('q2_obligation');	
																$q3_obligation=$q2_allotment + $row5->sum('q3_obligation');	
																$q4_obligation=$q3_allotment + $row5->sum('q4_obligation');	
																$q1_balance = $q1_allotment - $q1_obligation;
																$q2_balance = $q2_allotment - $q2_obligation;
																$q3_balance = $q3_allotment - $q3_obligation;
																$q4_balance = $q4_allotment - $q4_obligation;
																$total_allotment = $q4_allotment;
																$total_obligation = $q4_obligation;
																$total_balance = $total_allotment - $total_obligation;
																if($item5->object_specific_id != NULL){?>
																	<tr>
																		<td class="objexp1" colspan="5">{{ $item5->object_code }}: {{ $item5->object_expenditure }}</td>														
																	</tr><?php
																	foreach($data->where('pap_id', $item1->pap_id)
																	->where('activity_id', $item2->activity_id)
																	->where('subactivity_id', $item3->subactivity_id)
																	->where('expense_account_id', $item4->expense_account_id)
																	->where('object_expenditure_id', $item5->object_expenditure_id)
																	->whereNotNull('object_specific_id')
																	->groupBY('object_specific_id') as $key6=>$row6){
																		foreach($row6 as $item6) {}//item 4
																		$q1_allotment=$row6->sum('q1_allotment') + $row6->sum('q1_adjustment'); 
																		$q2_allotment=$q1_allotment + $row6->sum('q2_allotment') + $row6->sum('q2_adjustment'); 
																		$q3_allotment=$q2_allotment + $row6->sum('q3_allotment') + $row6->sum('q3_adjustment'); 
																		$q4_allotment=$q3_allotment + $row6->sum('q4_allotment') + $row6->sum('q4_adjustment'); 													
																		$q1_obligation=$row6->sum('q1_obligation'); 	
																		$q2_obligation=$q1_allotment + $row6->sum('q2_obligation');	
																		$q3_obligation=$q2_allotment + $row6->sum('q3_obligation');	
																		$q4_obligation=$q3_allotment + $row6->sum('q4_obligation');	
																		$q1_balance = $q1_allotment - $q1_obligation;
																		$q2_balance = $q2_allotment - $q2_obligation;
																		$q3_balance = $q3_allotment - $q3_obligation;
																		$q4_balance = $q4_allotment - $q4_obligation;
																		$total_allotment = $q4_allotment;
																		$total_obligation = $q4_obligation;
																		$total_balance = $total_allotment - $total_obligation;?>
																		<tr class="text-right">
																			<td class="objspe1 font-italic">{{ $item6->object_specific }}
																				@if($item6->pooled_at_division_id != NULL) 
																				- Pooled at {{ $item6->pooled_at_division_acronym }} ({{ $item6->division_acronym }})@endif
																			</td>		
																			@if($view_selected == 'annual')
																				<td class="yellow-bg ">{{ convert_number_format($total_allotment, 2) }}</td>															
																				<td class="lightgreen-bg">{{ convert_number_format($total_obligation, 2) }}</td>													
																				<td>{{ convert_number_format($total_balance, 2) }}</td>		
																			@elseif($view_selected == 'q1')		
																				<td class="yellow-bg">{{ convert_number_format($q1_allotment, 2) }}</td>														
																				<td class="lightgreen-bg">{{ convert_number_format($q1_obligation, 2) }}</td>													
																				<td>{{ convert_number_format($q1_balance, 2) }}</td>		
																			@elseif($view_selected == 'q2')		
																				<td class="yellow-bg">{{ convert_number_format($q2_allotment, 2) }}</td>														
																				<td class="lightgreen-bg">{{ convert_number_format($q2_obligation, 2) }}</td>													
																				<td>{{ convert_number_format($q2_balance, 2) }}</td>	
																			@elseif($view_selected == 'q3')		
																				<td class="yellow-bg">{{ convert_number_format($q3_allotment, 2) }}</td>														
																				<td class="lightgreen-bg">{{ convert_number_format($q3_obligation, 2) }}</td>													
																				<td>{{ convert_number_format($q3_balance, 2) }}</td>	
																			@elseif($view_selected == 'q4')		
																				<td class="yellow-bg">{{ convert_number_format($q4_allotment, 2) }}</td>														
																				<td class="lightgreen-bg">{{ convert_number_format($q4_obligation, 2) }}</td>													
																				<td>{{ convert_number_format($q4_balance, 2) }}</td>		
																			@endif	
																		</tr><?php
																	}
																}
															}
														}
														else{
															foreach($data->where('pap_id', $item1->pap_id)
															->where('activity_id', $item2->activity_id)
															->where('subactivity_id', $item3->subactivity_id)
															->where('expense_account_id', $item4->expense_account_id)
															->whereNull('object_specific_id')
															->groupBY('id') as $key5=>$row5){
																foreach($row5 as $item5) {}//item 4
																$q1_allotment = $item5->q1_allotment + $item5->q1_adjustment;
																$q2_allotment = $q1_allotment + $item5->q2_allotment + $item5->q2_adjustment;
																$q3_allotment = $q2_allotment + $item5->q3_allotment + $item5->q3_adjustment;
																$q4_allotment = $q3_allotment + $item5->q4_allotment + $item5->q4_adjustment;											
																$q1_obligation = $item5->q1_obligation;
																$q2_obligation = $q1_obligation + $item5->q2_obligation;
																$q3_obligation = $q2_obligation + $item5->q3_obligation;
																$q4_obligation = $q3_obligation + $item5->q4_obligation;
																$q1_balance = $q1_allotment - $q1_obligation;
																$q2_balance = $q2_allotment - $q2_obligation;
																$q3_balance = $q3_allotment - $q3_obligation;
																$q4_balance = $q4_allotment - $q4_obligation;
																$total_allotment = $q4_allotment;
																$total_obligation = $q4_obligation;
																$total_balance = $total_allotment - $total_obligation;?>
																<tr class="text-right">
																	<td class="objexp1">{{ $item5->object_code }}: {{ $item5->object_expenditure }}
																		@if($item5->pooled_at_division_id != NULL) 
																		- Pooled at {{ $item5->pooled_at_division_acronym }} ({{ $item5->division_acronym }})@endif
																	</td>		
																	@if($view_selected == 'annual')
																		<td class="yellow-bg">{{ convert_number_format($total_allotment, 2) }}</td>			
																		<td class="lightgreen-bg">
																			<a class="btn_obligation" data-id="{{ $item5->id }}" data-toggle="modal" data-target="#obligation_modal"
																				data-toggle="tooltip" data-placement='auto' title='View Obligations'>
																				{{ convert_number_format($total_obligation, 2) }}</a>
																		</td>													
																		<td>{{ convert_number_format($total_balance, 2) }}</td>		
																	@elseif($view_selected == 'q1')		
																		<td class="yellow-bg">{{ convert_number_format($q1_allotment, 2) }}</td>														
																		<td class="lightgreen-bg">{{ convert_number_format($q1_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($q1_balance) }}</td>		
																	@elseif($view_selected == 'q2')		
																		<td class="yellow-bg">{{ convert_number_format($q2_allotment, 2) }}</td>														
																		<td class="lightgreen-bg">{{ convert_number_format($q2_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($q2_balance, 2) }}</td>	
																	@elseif($view_selected == 'q3')		
																		<td class="yellow-bg">{{ convert_number_format($q3_allotment, 2) }}</td>														
																		<td class="lightgreen-bg">{{ convert_number_format($q3_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($q3_balance, 2) }}</td>	
																	@elseif($view_selected == 'q4')		
																		<td class="yellow-bg">{{ convert_number_format($q4_allotment, 2) }}</td>														
																		<td class="lightgreen-bg">{{ convert_number_format($q4_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($q4_balance, 2) }}</td>		
																	@elseif($view_selected == '07')		
																		<td class="yellow-bg">{{ convert_number_format($q4_allotment, 2) }}</td>														
																		<td class="lightgreen-bg">{{ convert_number_format($q4_obligation, 2) }}</td>													
																		<td>{{ convert_number_format($q4_balance, 2) }}</td>	
																	@endif													
																</tr><?php
															}
															foreach($data->where('pap_id', $item1->pap_id)
															->where('activity_id', $item2->activity_id)
															->where('subactivity_id', $item3->subactivity_id)
															->where('expense_account_id', $item4->expense_account_id)
															->whereNotNull('object_specific_id')
															->groupBY('object_expenditure_id') as $key5=>$row5){
																foreach($row5 as $item5) {}//item 4
																$q1_allotment = $item5->q1_allotment + $item5->q1_adjustment;
																$q2_allotment = $q1_allotment + $item5->q2_allotment + $item5->q2_adjustment;
																$q3_allotment = $q2_allotment + $item5->q3_allotment + $item5->q3_adjustment;
																$q4_allotment = $q3_allotment + $item5->q4_allotment + $item5->q4_adjustment;											
																$q1_obligation = $item5->q1_obligation;
																$q2_obligation = $q1_obligation + $item5->q2_obligation;
																$q3_obligation = $q2_obligation + $item5->q3_obligation;
																$q4_obligation = $q3_obligation + $item5->q4_obligation;
																$q1_balance = $q1_allotment - $q1_obligation;
																$q2_balance = $q2_allotment - $q2_obligation;
																$q3_balance = $q3_allotment - $q3_obligation;
																$q4_balance = $q4_allotment - $q4_obligation;
																$total_allotment = $q4_allotment;
																$total_obligation = $q4_obligation;
																$total_balance = $total_allotment - $total_obligation;
																if($item5->object_specific_id != NULL){?>
																	<tr>
																		<td class="objexp1" colspan="5">{{ $item5->object_code }}: {{ $item5->object_expenditure }}</td>														
																	</tr><?php
																	foreach($data->where('pap_id', $item1->pap_id)
																	->where('activity_id', $item2->activity_id)
																	->where('subactivity_id', $item3->subactivity_id)
																	->where('expense_account_id', $item4->expense_account_id)
																	->where('object_expenditure_id', $item5->object_expenditure_id)
																	->whereNotNull('object_specific_id')
																	->groupBY('id') as $key6=>$row6){
																		foreach($row6 as $item6) {}//item 4
																		$q1_allotment = $item6->q1_allotment + $item6->q1_adjustment;
																		$q2_allotment = $q1_allotment + $item6->q2_allotment + $item6->q2_adjustment;
																		$q3_allotment = $q2_allotment + $item6->q3_allotment + $item6->q3_adjustment;
																		$q4_allotment = $q3_allotment + $item6->q4_allotment + $item6->q4_adjustment;											
																		$q1_obligation = $item6->q1_obligation;
																		$q2_obligation = $q1_obligation + $item6->q2_obligation;
																		$q3_obligation = $q2_obligation + $item6->q3_obligation;
																		$q4_obligation = $q3_obligation + $item6->q4_obligation;
																		$q1_balance = $q1_allotment - $q1_obligation;
																		$q2_balance = $q2_allotment - $q2_obligation;
																		$q3_balance = $q3_allotment - $q3_obligation;
																		$q4_balance = $q4_allotment - $q4_obligation;
																		$total_allotment = $q4_allotment;
																		$total_obligation = $q4_obligation;
																		$total_balance = $total_allotment - $total_obligation;?>
																		<tr class="text-right">
																			<td class="objspe1 font-italic">{{ $item6->object_specific }}
																				@if($item6->pooled_at_division_id != NULL) 
																				- Pooled at {{ $item6->pooled_at_division_acronym }} ({{ $item6->division_acronym }})@endif
																			</td>		
																			@if($view_selected == 'annual')
																				<td class="yellow-bg ">{{ convert_number_format($total_allotment, 2) }}</td>	
																				<td class="lightgreen-bg">
																					<a class="btn_obligation" data-id="{{ $item6->id }}" data-toggle="modal" data-target="#obligation_modal"
																						data-toggle="tooltip" data-placement='auto' title='View Obligations'>
																						{{ convert_number_format($total_obligation, 2) }}</a>
																				</td>														
																				<td>{{ convert_number_format($total_balance, 2) }}</td>		
																			@elseif($view_selected == 'q1')		
																				<td class="yellow-bg">{{ convert_number_format($q1_allotment, 2) }}</td>														
																				<td class="lightgreen-bg">{{ convert_number_format($q1_obligation, 2) }}</td>													
																				<td>{{ convert_number_format($q1_balance, 2) }}</td>		
																			@elseif($view_selected == 'q2')		
																				<td class="yellow-bg">{{ convert_number_format($q2_allotment, 2) }}</td>														
																				<td class="lightgreen-bg">{{ convert_number_format($q2_obligation, 2) }}</td>													
																				<td>{{ convert_number_format($q2_balance, 2) }}</td>	
																			@elseif($view_selected == 'q3')		
																				<td class="yellow-bg">{{ convert_number_format($q3_allotment, 2) }}</td>														
																				<td class="lightgreen-bg">{{ convert_number_format($q3_obligation, 2) }}</td>													
																				<td>{{ convert_number_format($q3_balance, 2) }}</td>	
																			@elseif($view_selected == 'q4')		
																				<td class="yellow-bg">{{ convert_number_format($q4_allotment, 2) }}</td>															
																				<td class="lightgreen-bg">{{ convert_number_format($q4_obligation, 2) }}</td>													
																				<td>{{ convert_number_format($q4_balance, 2) }}</td>		
																			@endif			
																		</tr><?php
																	}
																}
															}
														}
													}			
												}
												if(isset($item2->activity)){
													$q1_allotment = $row2->sum('q1_allotment') + $row2->sum('q1_adjustment');
													$q2_allotment = $q1_allotment + $row2->sum('q2_allotment') + $row2->sum('q2_adjustment');
													$q3_allotment = $q2_allotment + $row2->sum('q3_allotment') + $row2->sum('q3_adjustment');
													$q4_allotment = $q3_allotment + $row2->sum('q4_allotment') + $row2->sum('q4_adjustment');
													$q1_obligation = $row2->sum('q1_obligation');
													$q2_obligation = $q1_obligation + $row2->sum('q2_obligation');
													$q3_obligation = $q2_obligation + $row2->sum('q3_obligation');
													$q4_obligation = $q3_obligation + $row2->sum('q4_obligation');
													$q1_balance = $q1_allotment - $q1_obligation;
													$q2_balance = $q2_allotment - $q2_obligation;
													$q3_balance = $q3_allotment - $q3_obligation;
													$q4_balance = $q4_allotment - $q4_obligation;
													$total_allotment = $q4_allotment;
													$total_obligation = $q4_obligation;
													$total_balance = $total_allotment - $total_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td class="font-weight-bold">Total Activity, {{ $item2->activity }}&nbsp;&nbsp;</td>
														@if($view_selected == 'annual')
															<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>														
															<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>													
															<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>		
														@elseif($view_selected == 'q1')		
															<td>&nbsp;&nbsp;{{ convert_number_format($q1_allotment, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q1_obligation, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q1_balance, 2) }}</td>		
														@elseif($view_selected == 'q2')		
															<td>&nbsp;&nbsp;{{ convert_number_format($q2_allotment, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q2_obligation, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q2_balance, 2) }}</td>	
														@elseif($view_selected == 'q3')		
															<td>&nbsp;&nbsp;{{ convert_number_format($q3_allotment, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q3_obligation, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q3_balance, 2) }}</td>	
														@elseif($view_selected == 'q4')		
															<td>&nbsp;&nbsp;{{ convert_number_format($q4_allotment, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q4_obligation, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>		
														@endif	
													</tr>
													<?php
												}
											}
											if(isset($item1->pap)){
												$q1_allotment = $row1->sum('q1_allotment') + $row1->sum('q1_adjustment');
												$q2_allotment = $q1_allotment + $row1->sum('q2_allotment') + $row1->sum('q2_adjustment');
												$q3_allotment = $q2_allotment + $row1->sum('q3_allotment') + $row1->sum('q3_adjustment');
												$q4_allotment = $q3_allotment + $row1->sum('q4_allotment') + $row1->sum('q4_adjustment');
												$q1_obligation = $row1->sum('q1_obligation');
												$q2_obligation = $q1_obligation + $row1->sum('q2_obligation');
												$q3_obligation = $q2_obligation + $row1->sum('q3_obligation');
												$q4_obligation = $q3_obligation + $row1->sum('q4_obligation');
												$q1_balance = $q1_allotment - $q1_obligation;
												$q2_balance = $q2_allotment - $q2_obligation;
												$q3_balance = $q3_allotment - $q3_obligation;
												$q4_balance = $q4_allotment - $q4_obligation;
												$total_allotment = $q4_allotment;
												$total_obligation = $q4_obligation;
												$total_balance = $total_allotment - $total_obligation;?>
												<tr class="text-right font-weight-bold gray-bg">
													<td class="font-weight-bold">TOTAL PAP, {{ $item1->pap_code }}</td>
													@if($view_selected == 'annual')
														<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>														
														<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>													
														<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>		
													@elseif($view_selected == 'q1')		
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_allotment, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_obligation, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_balance, 2) }}</td>		
													@elseif($view_selected == 'q2')		
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_allotment, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_obligation, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_balance, 2) }}</td>	
													@elseif($view_selected == 'q3')		
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_allotment, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_obligation, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_balance, 2) }}</td>	
													@elseif($view_selected == 'q4')		
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_allotment, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_obligation, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>		
													@endif	
												<?php 
											}
										}						
										
										if($division_id==5){
											if($view_selected=='annual'){
												foreach($data2->groupBy('year') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
														$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
														$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
														$total_allotment = $subtotal_allotment + $total_adjustment;
														$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
														$total_balance = $total_allotment - $total_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td class="font-weight-bold">FAD GRAND TOTAL</td>
														<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>
														<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>
														<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>
													</tr><?php
												}
											}
											?>
											<tr>
												<td class="font-weight-bold" colspan="4">POOLED AMOUNT</td>
											</tr><?php	
											foreach($data1->groupBY('object_expenditure_id') as $key=>$row){
												foreach($row as $item) {}?>
												<tr>
													<td class="expense font-weight-bold" colspan="4">{{ $item1->object_code }}: {{ $item->object_expenditure }}</td>
												</tr>
												<?php
												foreach($data1->where('object_expenditure_id', $item->object_expenditure_id)
												->groupBY('division_id')as $key1=>$row1){							
													foreach($row1 as $item1) {}
													$q1_allotment=$row1->sum('q1_allotment') + $row1->sum('q1_adjustment'); 
													$q2_allotment=$row1->sum('q2_allotment') + $row1->sum('q2_adjustment'); 
													$q3_allotment=$row1->sum('q3_allotment') + $row1->sum('q3_adjustment'); 
													$q4_allotment=$row1->sum('q4_allotment') + $row1->sum('q4_adjustment'); 
													$q1_obligation=$row1->sum('q1_obligation'); 	
													$q2_obligation=$row1->sum('q2_obligation');	
													$q3_obligation=$row1->sum('q3_obligation');	
													$q4_obligation=$row1->sum('q4_obligation');	
													$q1_balance = $q1_allotment - $q1_obligation;
													$q2_balance = $q2_allotment - $q2_obligation;
													$q3_balance = $q3_allotment - $q3_obligation;
													$q4_balance = $q4_allotment - $q4_obligation;
													$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
													$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
													$total_balance = $total_allotment - $total_obligation;?>
													<tr class="text-right">
														<td class="objspe1 font-italic">{{ $item1->division_acronym }}</td>		
														@if($view_selected == 'annual')
															<td class="yellow-bg">{{ convert_number_format($total_allotment, 2) }}</td>															
															<td class="lightgreen-bg">{{ convert_number_format($total_obligation, 2) }}</td>													
															<td>{{ convert_number_format($total_balance, 2) }}</td>		
														@elseif($view_selected == 'q1')		
															<td class="yellow-bg">{{ convert_number_format($q1_allotment, 2) }}</td>													
															<td class="lightgreen-bg">{{ convert_number_format($q1_obligation, 2) }}</td>													
															<td>{{ convert_number_format($q1_balance, 2) }}</td>		
														@elseif($view_selected == 'q2')		
															<td class="yellow-bg">{{ convert_number_format($q2_allotment, 2) }}</td>														
															<td class="lightgreen-bg">{{ convert_number_format($q2_obligation, 2) }}</td>													
															<td>{{ convert_number_format($q2_balance, 2) }}</td>	
														@elseif($view_selected == 'q3')		
															<td class="yellow-bg">{{ convert_number_format($q3_allotment, 2) }}</td>														
															<td class="lightgreen-bg">{{ convert_number_format($q3_obligation, 2) }}</td>													
															<td>{{ convert_number_format($q3_balance, 2) }}</td>	
														@elseif($view_selected == 'q4')		
															<td class="yellow-bg">{{ convert_number_format($q4_allotment, 2) }}</td>														
															<td class="lightgreen-bg">{{ convert_number_format($q4_obligation, 2) }}</td>													
															<td>{{ convert_number_format($q4_balance, 2) }}</td>		
														@endif										
													</tr><?php
												}
											}	
											if($view_selected=='annual'){
												foreach($data1->groupBy('year') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
														$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
														$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
														$total_allotment = $subtotal_allotment + $total_adjustment;
														$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
														$total_balance = $total_allotment - $total_obligation;?>
													<tr class="text-right gray-bg">
														<td class="font-weight-bold">POOLED TOTAL</td>
														<td class="font-weight-bold">&emsp;{{ convert_number_format($total_allotment, 2) }}</td>
														<td class="font-weight-bold">&emsp;{{ convert_number_format($total_obligation, 2) }}</td>
														<td class="font-weight-bold">&emsp;{{ convert_number_format($total_balance, 2) }}</td>
													</tr><?php
												}												
											}
										}
										elseif($division_id=='all'){
											if($view_selected=='annual'){
												foreach($data->groupBy('year') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
														$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
														$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
														$total_allotment = $subtotal_allotment + $total_adjustment;
														$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
														$total_balance = $total_allotment - $total_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>
													</tr><?php
												}
											}
											elseif($view_selected=='q1'){
												foreach($data->groupBy('year') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
													$q1_allotment = $rowSum->sum('q1_allotment');
													$q1_adjustment = $rowSum->sum('q1_adjustment');
													$q1_total_allotment = $q1_allotment + $q1_adjustment;
													$q1_obligation = $rowSum->sum('q1_obligation');
													$q1_balance = $q1_total_allotment - $q1_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_balance, 2) }}</td>
													</tr><?php
												}
											}
											elseif($view_selected=='q2'){
												foreach($data->groupBy('year') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
													$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment');
													$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment');
													$q2_total_allotment = $subtotal_allotment + $total_adjustment;
													$q2_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation');
													$q2_balance = $q2_total_allotment - $q2_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_balance, 2) }}</td>
													</tr><?php
												}
											}
											elseif($view_selected=='q3'){
												foreach($data->groupBy('year') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
													$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment');
													$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment');
													$q3_total_allotment = $subtotal_allotment + $total_adjustment;
													$q3_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation');
													$q3_balance = $q3_total_allotment - $q3_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_balance, 2) }}</td>
													</tr><?php
												}
											}
											elseif($view_selected=='q4'){
												foreach($data->groupBy('division_id') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
													$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
													$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
													$q4_total_allotment = $subtotal_allotment + $total_adjustment;
													$q4_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
													$q4_balance = $q4_total_allotment - $q4_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>
													</tr><?php
												}
											}
										}
										else{
											if($view_selected=='annual'){
												foreach($data->groupBy('division_id') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
														$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
														$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
														$total_allotment = $subtotal_allotment + $total_adjustment;
														$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
														$total_balance = $total_allotment - $total_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>
													</tr><?php
												}
											}
											elseif($view_selected=='q1'){
												foreach($data->groupBy('division_id') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
													$q1_allotment = $rowSum->sum('q1_allotment');
													$q1_adjustment = $rowSum->sum('q1_adjustment');
													$q1_total_allotment = $q1_allotment + $q1_adjustment;
													$q1_obligation = $rowSum->sum('q1_obligation');
													$q1_balance = $q1_total_allotment - $q1_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_balance, 2) }}</td>
													</tr><?php
												}
											}
											elseif($view_selected=='q2'){
												foreach($data->groupBy('division_id') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
													$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment');
													$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment');
													$q2_total_allotment = $subtotal_allotment + $total_adjustment;
													$q2_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation');
													$q2_balance = $q2_total_allotment - $q2_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_balance, 2) }}</td>
													</tr><?php
												}
											}
											elseif($view_selected=='q3'){
												foreach($data->groupBy('division_id') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
													$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment');
													$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment');
													$q3_total_allotment = $subtotal_allotment + $total_adjustment;
													$q3_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation');
													$q3_balance = $q3_total_allotment - $q3_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_balance, 2) }}</td>
													</tr><?php
												}
											}
											elseif($view_selected=='q4'){
												foreach($data->groupBy('division_id') as $keySum=>$rowSum){
													foreach($rowSum as $itemSum){}
													$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
													$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
													$q4_total_allotment = $subtotal_allotment + $total_adjustment;
													$q4_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
													$q4_balance = $q4_total_allotment - $q4_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td>GRAND TOTAL&nbsp;&nbsp;</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_total_allotment, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_obligation, 2) }}</td>
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>
													</tr><?php
												}
											}
										}	
									}	
									else{
										foreach($data->groupBY('pap_code') as $key1=>$row1){
											foreach($row1 as $item1) {} //item 1?>
											<tr>
												<td class="pap font-weight-bold gray2-bg" colspan="5">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
											</tr><?php 										
											foreach($data->where('pap_id', $item1->pap_id)->groupBY('activity_id') as $key2=>$row2){
												foreach($row2 as $item2) {} //item 2?>
												<tr>
													<td class="activity1 font-weight-bold" colspan="5">{{ $item2->activity }}</td>													
												</tr><?php 										
												foreach($data->where('pap_id', $item1->pap_id)->where('activity_id', $item2->activity_id)
													->groupBY('subactivity_id') as $key3=>$row3){
													foreach($row3 as $item3) {} 
													if(isset($item3->subactivity)){//item 3?>
														<tr class="text-right gray3-bg font-weight-bold">
															<td colspan="4" class="subactivity1">{{ $item3->subactivity }}</td>						
														</tr><?php 
													}										
													foreach($data->where('pap_id', $item1->pap_id)
														->where('activity_id', $item2->activity_id)
														->where('subactivity_id', $item3->subactivity_id)
														->groupBY('expense_account_id') as $key4=>$row4){
														foreach($row4 as $item4) {}//item 4
														$q1_allotment = $item4->q1_allotment + $item4->q1_adjustment;
														$q2_allotment = $q1_allotment + $item4->q2_allotment + $item4->q2_adjustment;
														$q3_allotment = $q2_allotment + $item4->q3_allotment + $item4->q3_adjustment;
														$q4_allotment = $q3_allotment + $item4->q4_allotment + $item4->q4_adjustment;											
														$q1_obligation = $item4->q1_obligation;
														$q2_obligation = $q1_obligation + $item4->q2_obligation;
														$q3_obligation = $q2_obligation + $item4->q3_obligation;
														$q4_obligation = $q3_obligation + $item4->q4_obligation;
														$q1_balance = $q1_allotment - $q1_obligation;
														$q2_balance = $q2_allotment - $q2_obligation;
														$q3_balance = $q3_allotment - $q3_obligation;
														$q4_balance = $q4_allotment - $q4_obligation;
														$total_allotment = $q4_allotment;
														$total_obligation = $q4_obligation;
														$total_balance = $total_allotment - $total_obligation;
														$total_allotment = $total_allotment - $total_obligation;
														foreach($data->where('pap_id', $item1->pap_id)
															->where('activity_id', $item2->activity_id)
															->where('subactivity_id', $item3->subactivity_id)
															->where('expense_account_id', $item4->expense_account_id)
															->groupBY('id') as $key5=>$row5){
															foreach($row5 as $item5) {}//item 4
															$q1_allotment = $item5->q1_allotment + $item5->q1_adjustment;
															$q2_allotment = $q1_allotment + $item5->q2_allotment + $item5->q2_adjustment;
															$q3_allotment = $q2_allotment + $item5->q3_allotment + $item5->q3_adjustment;
															$q4_allotment = $q3_allotment + $item5->q4_allotment + $item5->q4_adjustment;											
															$q1_obligation = $item5->q1_obligation;
															$q2_obligation = $q1_obligation + $item5->q2_obligation;
															$q3_obligation = $q2_obligation + $item5->q3_obligation;
															$q4_obligation = $q3_obligation + $item5->q4_obligation;
															$q1_balance = $q1_allotment - $q1_obligation;
															$q2_balance = $q2_allotment - $q2_obligation;
															$q3_balance = $q3_allotment - $q3_obligation;
															$q4_balance = $q4_allotment - $q4_obligation;
															$total_allotment = $q4_allotment;
															$total_obligation = $q4_obligation;
															$total_balance = $total_allotment - $total_obligation;?>
															<tr class="text-right">
																<td class="expense1">
																	@if($item5->object_expenditure!=NULL) {{ $item5->object_code }}: {{ $item5->object_expenditure }} 
																	@else	{{ $item5->expense_account_code }}: {{ $item5->expense_account }}												
																	@endif
																</td>	
																@if($view_selected == 'annual')
																	<td class="yellow-bg">{{ convert_number_format($total_allotment, 2) }}</td>			
																	<td class="lightgreen-bg">
																		<a class="btn_obligation" data-id="{{ $item5->id }}" data-toggle="modal" data-target="#obligation_modal"
																			data-toggle="tooltip" data-placement='auto' title='View Obligations'>
																			{{ convert_number_format($total_obligation, 2) }}</a>
																	</td>													
																	<td>{{ convert_number_format($total_balance, 2) }}</td>		
																{{-- @elseif($view_selected == 'q1')		
																	<td class="yellow-bg">{{ convert_number_format($q1_allotment, 2) }}</td>														
																	<td class="lightgreen-bg">{{ convert_number_format($q1_obligation, 2) }}</td>													
																	<td>{{ convert_number_format($q1_balance, 2) }}</td>		
																@elseif($view_selected == 'q2')		
																	<td class="yellow-bg">{{ convert_number_format($q2_allotment, 2) }}</td>														
																	<td class="lightgreen-bg">{{ convert_number_format($q2_obligation, 2) }}</td>													
																	<td>{{ convert_number_format($q2_balance, 2) }}</td>	
																@elseif($view_selected == 'q3')		
																	<td class="yellow-bg">{{ convert_number_format($q3_allotment, 2) }}</td>														
																	<td class="lightgreen-bg">{{ convert_number_format($q3_obligation, 2) }}</td>													
																	<td>{{ convert_number_format($q3_balance, 2) }}</td>	
																@elseif($view_selected == 'q4')		
																	<td class="yellow-bg">{{ convert_number_format($q4_allotment, 2) }}</td>														
																	<td class="lightgreen-bg">{{ convert_number_format($q4_obligation, 2) }}</td>													
																	<td>{{ convert_number_format($q4_balance, 2) }}</td>		
																@elseif($view_selected == '07')		
																	<td class="yellow-bg">{{ convert_number_format($q4_allotment, 2) }}</td>														
																	<td class="lightgreen-bg">{{ convert_number_format($july_obligation, 2) }}</td>													
																	<td>{{ convert_number_format($q4_balance, 2) }}</td>	 --}}
																@endif													
															</tr><?php
														}														
													}	
													if(isset($item3->subactivity)){
														$q1_allotment = $row3->sum('q1_allotment') + $row3->sum('q1_adjustment');
														$q2_allotment = $q1_allotment + $row3->sum('q2_allotment') + $row3->sum('q2_adjustment');
														$q3_allotment = $q2_allotment + $row3->sum('q3_allotment') + $row3->sum('q3_adjustment');
														$q4_allotment = $q3_allotment + $row3->sum('q4_allotment') + $row3->sum('q4_adjustment');
														$q1_obligation = $row3->sum('q1_obligation');
														$q2_obligation = $q1_obligation + $row3->sum('q2_obligation');
														$q3_obligation = $q2_obligation + $row3->sum('q3_obligation');
														$q4_obligation = $q3_obligation + $row3->sum('q4_obligation');
														$q1_balance = $q1_allotment - $q1_obligation;
														$q2_balance = $q2_allotment - $q2_obligation;
														$q3_balance = $q3_allotment - $q3_obligation;
														$q4_balance = $q4_allotment - $q4_obligation;				
														$july_obligation = $row3->sum('july_obligation');
														$total_allotment = $q4_allotment;
														$total_obligation = $q4_obligation;
														$total_balance = $total_allotment - $total_obligation;?>
														<tr class="text-right font-weight-bold gray-bg">
															<td class="font-weight-bold">Total Subactivity, {{ $item3->subactivity }}&nbsp;&nbsp;</td>
															@if($view_selected == 'annual')
																<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>														
																<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>													
																<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>		
															@elseif($view_selected == 'q1')		
																<td>&nbsp;&nbsp;{{ convert_number_format($q1_allotment, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($q1_obligation, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($q1_balance, 2) }}</td>		
															@elseif($view_selected == 'q2')		
																<td>&nbsp;&nbsp;{{ convert_number_format($q2_allotment, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($q2_obligation, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($q2_balance, 2) }}</td>	
															@elseif($view_selected == 'q3')		
																<td>&nbsp;&nbsp;{{ convert_number_format($q3_allotment, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($q3_obligation, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($q3_balance, 2) }}</td>	
															@elseif($view_selected == 'q4')		
																<td>&nbsp;&nbsp;{{ convert_number_format($q4_allotment, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($q4_obligation, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>	
															@elseif($view_selected == '07')		
																<td>&nbsp;&nbsp;{{ convert_number_format($q4_allotment, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($july_obligation, 2) }}</td>													
																<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>		
															@endif	
														</tr>
														<?php
													}
												}
												if(isset($item2->activity)){
													$q1_allotment = $row2->sum('q1_allotment') + $row2->sum('q1_adjustment');
													$q2_allotment = $q1_allotment + $row2->sum('q2_allotment') + $row2->sum('q2_adjustment');
													$q3_allotment = $q2_allotment + $row2->sum('q3_allotment') + $row2->sum('q3_adjustment');
													$q4_allotment = $q3_allotment + $row2->sum('q4_allotment') + $row2->sum('q4_adjustment');
													$q1_obligation = $row2->sum('q1_obligation');
													$q2_obligation = $q1_obligation + $row2->sum('q2_obligation');
													$q3_obligation = $q2_obligation + $row2->sum('q3_obligation');
													$q4_obligation = $q3_obligation + $row2->sum('q4_obligation');
													$q1_balance = $q1_allotment - $q1_obligation;
													$q2_balance = $q2_allotment - $q2_obligation;
													$q3_balance = $q3_allotment - $q3_obligation;
													$q4_balance = $q4_allotment - $q4_obligation;				
													$july_obligation = $row2->sum('july_obligation');
													$total_allotment = $q4_allotment;
													$total_obligation = $q4_obligation;
													$total_balance = $total_allotment - $total_obligation;?>
													<tr class="text-right font-weight-bold gray-bg">
														<td class="font-weight-bold">Total Activity, {{ $item2->activity }}&nbsp;&nbsp;</td>
														@if($view_selected == 'annual')
															<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>														
															<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>													
															<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>		
														@elseif($view_selected == 'q1')		
															<td>&nbsp;&nbsp;{{ convert_number_format($q1_allotment, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q1_obligation, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q1_balance, 2) }}</td>		
														@elseif($view_selected == 'q2')		
															<td>&nbsp;&nbsp;{{ convert_number_format($q2_allotment, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q2_obligation, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q2_balance, 2) }}</td>	
														@elseif($view_selected == 'q3')		
															<td>&nbsp;&nbsp;{{ convert_number_format($q3_allotment, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q3_obligation, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q3_balance, 2) }}</td>	
														@elseif($view_selected == 'q4')		
															<td>&nbsp;&nbsp;{{ convert_number_format($q4_allotment, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q4_obligation, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>	
														@elseif($view_selected == '07')		
															<td>&nbsp;&nbsp;{{ convert_number_format($q4_allotment, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($july_obligation, 2) }}</td>													
															<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>		
														@endif	
													</tr>
													<?php
												}
											}
											if(isset($item1->pap)){
												$q1_allotment = $row1->sum('q1_allotment') + $row1->sum('q1_adjustment');
												$q2_allotment = $q1_allotment + $row1->sum('q2_allotment') + $row1->sum('q2_adjustment');
												$q3_allotment = $q2_allotment + $row1->sum('q3_allotment') + $row1->sum('q3_adjustment');
												$q4_allotment = $q3_allotment + $row1->sum('q4_allotment') + $row1->sum('q4_adjustment');
												$q1_obligation = $row1->sum('q1_obligation');
												$q2_obligation = $q1_obligation + $row1->sum('q2_obligation');
												$q3_obligation = $q2_obligation + $row1->sum('q3_obligation');
												$q4_obligation = $q3_obligation + $row1->sum('q4_obligation');
												$q1_balance = $q1_allotment - $q1_obligation;
												$q2_balance = $q2_allotment - $q2_obligation;
												$q3_balance = $q3_allotment - $q3_obligation;
												$q4_balance = $q4_allotment - $q4_obligation;
												$july_obligation = $row1->sum('july_obligation');
												$total_allotment = $q4_allotment;
												$total_obligation = $q4_obligation;
												$total_balance = $total_allotment - $total_obligation;?>
												<tr class="text-right font-weight-bold gray-bg">
													<td class="font-weight-bold">TOTAL PAP, {{ $item1->pap_code }}</td>
													@if($view_selected == 'annual')
														<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>														
														<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>													
														<td class="font-weight-bold">&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>		
													@elseif($view_selected == 'q1')		
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_allotment, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_obligation, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q1_balance, 2) }}</td>		
													@elseif($view_selected == 'q2')		
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_allotment, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_obligation, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q2_balance, 2) }}</td>	
													@elseif($view_selected == 'q3')		
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_allotment, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_obligation, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q3_balance, 2) }}</td>	
													@elseif($view_selected == 'q4')		
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_allotment, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_obligation, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>	
													@elseif($view_selected == '07')		
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_allotment, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($july_obligation, 2) }}</td>													
														<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>		
													@endif	
												<?php 
											}
										}	
										//GRAND TOTAL
										if($view_selected=='annual'){
											foreach($data->groupBy('division_id') as $keySum=>$rowSum){
												foreach($rowSum as $itemSum){}
													$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
													$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
													$total_allotment = $subtotal_allotment + $total_adjustment;
													$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
													$total_balance = $total_allotment - $total_obligation;?>
												<tr class="text-right font-weight-bold gray-bg">
													<td>GRAND TOTAL&nbsp;&nbsp;</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($total_allotment, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($total_obligation, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($total_balance, 2) }}</td>
												</tr><?php
											}
										}
										elseif($view_selected=='q1'){
											foreach($data->groupBy('division_id') as $keySum=>$rowSum){
												foreach($rowSum as $itemSum){}
												$q1_allotment = $rowSum->sum('q1_allotment');
												$q1_adjustment = $rowSum->sum('q1_adjustment');
												$q1_total_allotment = $q1_allotment + $q1_adjustment;
												$q1_obligation = $rowSum->sum('q1_obligation');
												$q1_balance = $q1_total_allotment - $q1_obligation;?>
												<tr class="text-right font-weight-bold gray-bg">
													<td>GRAND TOTAL&nbsp;&nbsp;</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q1_total_allotment, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q1_obligation, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q1_balance, 2) }}</td>
												</tr><?php
											}
										}
										elseif($view_selected=='q2'){
											foreach($data->groupBy('division_id') as $keySum=>$rowSum){
												foreach($rowSum as $itemSum){}
												$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment');
												$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment');
												$q2_total_allotment = $subtotal_allotment + $total_adjustment;
												$q2_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation');
												$q2_balance = $q2_total_allotment - $q2_obligation;?>
												<tr class="text-right font-weight-bold gray-bg">
													<td>GRAND TOTAL&nbsp;&nbsp;</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q2_total_allotment, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q2_obligation, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q2_balance, 2) }}</td>
												</tr><?php
											}
										}
										elseif($view_selected=='q3'){
											foreach($data->groupBy('division_id') as $keySum=>$rowSum){
												foreach($rowSum as $itemSum){}
												$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment');
												$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment');
												$q3_total_allotment = $subtotal_allotment + $total_adjustment;
												$q3_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation');
												$q3_balance = $q3_total_allotment - $q3_obligation;?>
												<tr class="text-right font-weight-bold gray-bg">
													<td>GRAND TOTAL&nbsp;&nbsp;</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q3_total_allotment, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q3_obligation, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q3_balance, 2) }}</td>
												</tr><?php
											}
										}
										elseif($view_selected=='q4'){
											foreach($data->groupBy('division_id') as $keySum=>$rowSum){
												foreach($rowSum as $itemSum){}
												$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
												$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
												$q4_total_allotment = $subtotal_allotment + $total_adjustment;
												$q4_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
												$q4_balance = $q4_total_allotment - $q4_obligation;?>
												<tr class="text-right font-weight-bold gray-bg">
													<td>GRAND TOTAL&nbsp;&nbsp;</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q4_total_allotment, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q4_obligation, 2) }}</td>
													<td>&nbsp;&nbsp;{{ convert_number_format($q4_balance, 2) }}</td>
												</tr><?php
											}
										}			
									}															
									?>
								</tbody>
							</table>		
						</div>	
					</div>	
				</div>	
			</div>	
		</div>	
	</section> 	
	@include('reports.saob.modal')			
@endsection
	
@section('jscript')
   <script type="text/javascript" defer>
      $(document).ready(function(){
			@include('reports.saob.script')     
			@include('scripts.common_script') 
      });

		function exportToExcel() {
			$("#saob_table").table2excel({
				exclude: ".excludeThisClass",
				// name: $("#saob_table").data("tableName"),
				filename: "saob.xls",
				preserveColors: false
			});
		}

		function changeFilter()
		{     
			rstype_id_selected = $("#rstype_id_selected").val();
			division_id = $('#division_id').val(),
			year_selected = $("#year_selected").val();
			view_selected = $("#view_selected").val();
			if(rstype_id_selected==1 && year_selected=='all'){
				const d = new Date();
				year_selected = d.getFullYear();           
			}
			else if(rstype_id_selected!=1 && division_id!='all'){   
				year_selected = 'all';
			}  
			else if(rstype_id_selected!=1 && division_id=='all'){   
				division_id = 2;
				year_selected = 'all';
			}  
			window.location.replace("{{ url('reports/saob') }}/"+rstype_id_selected+"/"+division_id+"/"+year_selected+"/"+view_selected);
		}	
   </script>
@endsection
