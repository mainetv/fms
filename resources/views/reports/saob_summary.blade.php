@extends('layouts.app')

@php
	$getAllActiveDivisions=getAllActiveDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
@endphp

@section('content') 
	<section class="content">
		<div class="card text-left">
			<div class="card-header row">
				<div class="col-10">
					<h5 class="font-weight-bold">
						Statement of Allotments, Obligations, and Balance Summary (SAOB Summary)
					</h5> 
				</div>
				<div class="col float-right">    
					{{-- <div class="col-2">
						<a target="_blank" href="{{ route('division_proposals.generatePDF', ['division_id'=>$division_id, 'year'=>$year_selected],'year'=>$year_selected) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
					</div> --}}
					{{-- <button class="print btn"  data-toggle="tooltip" data-placement='auto'title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button> --}}
					{{-- <button class="export_to_excel btn" onclick="exportToExcel(this)" data-toggle="tooltip" data-placement='auto'title='Export to Excel'>
						<img src="{{ asset('/images/export-to-excel.png') }}" width="50px"></img></button> --}}
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
						
					</div>	
				</div>	

				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table width="100%" class="table-hover table2excel" id="saob_table" >
								<thead class="text-center">
									<tr>
										<th rowspan="2" width="7%">Object Code</th>
										<th rowspan="2">Object</th>
										<th colspan="5">Allotment</th>
										<th rowspan="2">Total Obligation</th>
										<th rowspan="2">Balance</th>
									</tr>
									<tr>
										<th>1st Quarter</th>
										<th>2nd Quarter</th>
										<th>3rd Quarter</th>
										<th>4th Quarter</th>
										<th>Annual</th>
									</tr>
								</thead>	
								<tbody><?php			
									$total_allotment=0;														
									$total_obligation=0;														
									$total_balance=0;														
									$q1_adjustment=0;														
									$q2_adjustment=0;														
									$q3_adjustment=0;														
									$q4_adjustment=0;
									
									$q2_adjustment_1=0;														
									$q3_adjustment_1=0;														
									$q4_adjustment_1=0;	
									if($rstype_id_selected==1){										
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
									elseif($rstype_id_selected!=1){
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
											->where('rs_type_id', $rstype_id_selected)
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
												<td class="pap font-weight-bold gray2-bg" colspan="9">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
											</tr><?php 										
											foreach($data->where('pap_id', $item1->pap_id)
											->groupBY('object_expenditure_id') as $key2=>$row2){
												foreach($row2 as $item2) {} //item 2
												$q1_allotment = $row2->sum('q1_allotment') + $row2->sum('q1_adjustment');
												$q2_allotment = $q1_allotment + $row2->sum('q2_allotment') + $row2->sum('q2_adjustment');
												$q3_allotment = $q2_allotment + $row2->sum('q3_allotment') + $row2->sum('q3_adjustment');
												$q4_allotment = $q3_allotment + $row2->sum('q4_allotment') + $row2->sum('q4_adjustment');

												$q2_allotment_1 = $row2->sum('q2_allotment') + $row2->sum('q2_adjustment');
												$q3_allotment_1 = $row2->sum('q3_allotment') + $row2->sum('q3_adjustment');
												$q4_allotment_1 = $row2->sum('q4_allotment') + $row2->sum('q4_adjustment');

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
												$total_balance = $total_allotment - $total_obligation;
												?>
												<tr class="text-right">
													<td class="text-center">{{ $item2->object_code }}</td>													
													<td class="text-left">{{ $item2->object_expenditure }}</td>													
													<td nowrap>{{ convert_number_format($q1_allotment, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q2_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q3_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q4_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_allotment, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_obligation, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_balance, 2) }}</td>													
												</tr><?php 		
											}
											if(isset($item1->pap)){
												$q1_allotment = $row1->sum('q1_allotment') + $row1->sum('q1_adjustment');
												$q2_allotment = $q1_allotment + $row1->sum('q2_allotment') + $row1->sum('q2_adjustment');
												$q3_allotment = $q2_allotment + $row1->sum('q3_allotment') + $row1->sum('q3_adjustment');
												$q4_allotment = $q3_allotment + $row1->sum('q4_allotment') + $row1->sum('q4_adjustment');

												$q2_allotment_1 = $row1->sum('q2_allotment') + $row1->sum('q2_adjustment');
												$q3_allotment_1 = $row1->sum('q3_allotment') + $row1->sum('q3_adjustment');
												$q4_allotment_1 = $row1->sum('q4_allotment') + $row1->sum('q4_adjustment');

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
													<td colspan="2" class="font-weight-bold">TOTAL PAP, {{ $item1->pap }}&nbsp;&nbsp;</td>													
													<td nowrap>{{ convert_number_format($q1_allotment, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q2_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q3_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q4_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_allotment, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_obligation, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_balance, 2) }}</td>													
												</tr>
												<?php 
											}
										}				
										
										foreach($data->groupBy('year') as $keySum=>$rowSum){
											foreach($rowSum as $itemSum){}
												$q1_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q1_adjustment');
												$q2_allotment = $rowSum->sum('q2_allotment') + $rowSum->sum('q2_adjustment');
												$q3_allotment = $rowSum->sum('q3_allotment') + $rowSum->sum('q3_adjustment');
												$q4_allotment = $rowSum->sum('q4_allotment') + $rowSum->sum('q4_adjustment');

												$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
												$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
												$total_allotment = $subtotal_allotment + $total_adjustment;
												$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
												$total_balance = $total_allotment - $total_obligation;?>
											<tr class="text-right font-weight-bold gray-bg">
												<td colspan="2">GRAND TOTAL&nbsp;&nbsp;</td>
												<td nowrap>{{ convert_number_format($q1_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($q2_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($q3_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($q4_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($total_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($total_obligation, 2) }}</td>													
												<td nowrap>{{ convert_number_format($total_balance, 2) }}</td>
											</tr><?php
										}
																			
									}	
									else{
										foreach($data->groupBY('pap_code') as $key1=>$row1){
											foreach($row1 as $item1) {} //item 1?>
											<tr>
												<td class="pap font-weight-bold gray2-bg" colspan="9">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
											</tr><?php 										
											foreach($data->where('pap_id', $item1->pap_id)->groupBY('object_expenditure_id') as $key2=>$row2){
												foreach($row2 as $item2) {} //item 2
												$q1_allotment = $row2->sum('q1_allotment') + $row2->sum('q1_adjustment');
												$q2_allotment = $q1_allotment + $row2->sum('q2_allotment') + $row2->sum('q2_adjustment');
												$q3_allotment = $q2_allotment + $row2->sum('q3_allotment') + $row2->sum('q3_adjustment');
												$q4_allotment = $q3_allotment + $row2->sum('q4_allotment') + $row2->sum('q4_adjustment');

												$q2_allotment_1 = $row2->sum('q2_allotment') + $row2->sum('q2_adjustment');
												$q3_allotment_1 = $row2->sum('q3_allotment') + $row2->sum('q3_adjustment');
												$q4_allotment_1 = $row2->sum('q4_allotment') + $row2->sum('q4_adjustment');

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
												$total_balance = $total_allotment - $total_obligation;
												?>
												<tr class="text-right">
													<td class="text-center">{{ $item2->object_code }}</td>													
													<td class="text-left">{{ $item2->object_expenditure }}</td>													
													<td nowrap>{{ convert_number_format($q1_allotment, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q2_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q3_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q4_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_allotment, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_obligation, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_balance, 2) }}</td>													
												</tr><?php 	
											}
											if(isset($item1->pap)){
												$q1_allotment = $row1->sum('q1_allotment') + $row1->sum('q1_adjustment');
												$q2_allotment = $q1_allotment + $row1->sum('q2_allotment') + $row1->sum('q2_adjustment');
												$q3_allotment = $q2_allotment + $row1->sum('q3_allotment') + $row1->sum('q3_adjustment');
												$q4_allotment = $q3_allotment + $row1->sum('q4_allotment') + $row1->sum('q4_adjustment');

												$q2_allotment_1 = $row1->sum('q2_allotment') + $row1->sum('q2_adjustment');
												$q3_allotment_1 = $row1->sum('q3_allotment') + $row1->sum('q3_adjustment');
												$q4_allotment_1 = $row1->sum('q4_allotment') + $row1->sum('q4_adjustment');

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
												$total_balance = $total_allotment - $total_obligation;
												?>
												<tr class="text-right font-weight-bold gray-bg">
													<td colspan="2" class="font-weight-bold">TOTAL PAP, {{ $item1->pap }}&nbsp;&nbsp;</td>													
													<td nowrap>{{ convert_number_format($q1_allotment, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q2_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q3_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($q4_allotment_1, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_allotment, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_obligation, 2) }}</td>													
													<td nowrap>{{ convert_number_format($total_balance, 2) }}</td>												
												<?php 
											}
										}	
										//GRAND TOTAL
										foreach($data->groupBy('ID') as $keySum=>$rowSum){
											foreach($rowSum as $itemSum){}
												$q1_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q1_adjustment');
												$q2_allotment = $rowSum->sum('q2_allotment') + $rowSum->sum('q2_adjustment');
												$q3_allotment = $rowSum->sum('q3_allotment') + $rowSum->sum('q3_adjustment');
												$q4_allotment = $rowSum->sum('q4_allotment') + $rowSum->sum('q4_adjustment');

												$subtotal_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
												$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
												$total_allotment = $subtotal_allotment + $total_adjustment;
												$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
												$total_balance = $total_allotment - $total_obligation;?>
											<tr class="text-right font-weight-bold gray-bg">
												<td colspan="2">GRAND TOTAL&nbsp;&nbsp;</td>
												<td nowrap>{{ convert_number_format($q1_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($q2_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($q3_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($q4_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($total_allotment, 2) }}</td>													
												<td nowrap>{{ convert_number_format($total_obligation, 2) }}</td>													
												<td nowrap>{{ convert_number_format($total_balance, 2) }}</td>
											</tr><?php
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
			year_selected = $("#year_selected").val();
			if(rstype_id_selected!=1){   
				year_selected = 'all';
			} 
			// alert(rstype_id_selected);
			// alert(year_selected);
			window.location.replace("{{ url('reports/saob_summary') }}/"+rstype_id_selected+"/"+year_selected);
		}	
   </script>
@endsection
