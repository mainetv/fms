@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
@endphp

@section('content')	
	<section class="content">
		<div class="card text-left">
			<SCRIPT LANGUAGE="JavaScript">
				function printThis()
				{
		
					window.print();
				}
			</script>
			<div class="card-header row">
				<div class="col-11">
					<h5 class="font-weight-bold">
						Allotment Summary
					</h5> 
				</div>
				<div class="col-1">    
					{{-- <button class="print btn float-left"  data-toggle="tooltip" data-placement='auto'title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button> --}}
				</div>    
			</div>   
			<div class="card-body">
				<div class="row">		
					<div>
						<label>Request and Status Type:</label> 							  			
						<select name="rstype_id_selected" id="rstype_id_selected" class="select_filter">               
							@foreach ($getRSTypes as $row)
								<option value="{{ $row->id }}" @if(isset($row->id) && $rstype_id_selected==$row->id){{"selected"}} @endif > {{ $row->request_status_type }}</option>
							@endforeach    
						</select>
					</div> &emsp;
					<div>
						<label>Year:</label>				
						<select name="year_selected" id="year_selected" class="select_filter">          
							@foreach ($getYears as $row)
								<option value="{{ $row->year }}" data-selected="{{ $row->id }}" 
									@if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif> {{ $row->year }}</option>
							@endforeach    
						</select> 
					</div>&emsp;
				</div>
				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table id="records_table" style="width: 100%;">
								<thead class="text-center gray2-bg">
									<th width="8%">Division</th>
									<th width="8%">PAP Code</th>
									<th width="6%">Object Code</th>
									<th width="18%">Object</th>
									<th width="25%">Activity-Subactivity</th>
									<th width="7%">Annual</th>
									<th width="7%">1st Quarter</th>
									<th width="7%">2nd Quarter</th>
									<th width="7%">3rd Quarter</th>
									<th width="7%">4th Quarter</th>
								</thead>
								<tbody><?php 
									$gt_q1_allotment=0;
									$gt_q2_allotment=0;
									$gt_q3_allotment=0;
									$gt_q4_allotment=0;
									$gt_allotment=0;
									foreach($data as $row){
										$activity_subactivity=$row->activity_subactivity;
										$q1_allotment=$row->q1_allotment;
										$q2_allotment=$row->q2_allotment;
										$q3_allotment=$row->q3_allotment;
										$q4_allotment=$row->q4_allotment;
										$q1_obligation=$row->q1_obligation;
										$q2_obligation=$row->q2_obligation;
										$q3_obligation=$row->q3_obligation;
										$q4_obligation=$row->q4_obligation;
										$q1_balance=$q1_allotment-$q1_obligation;
										$q2_balance=$q2_allotment-$q2_obligation;
										$q3_balance=$q3_allotment-$q3_obligation;
										$q4_balance=$q4_allotment-$q4_obligation;
										$annual_allotment=$q1_allotment+$q2_allotment+$q3_allotment+$q4_allotment;
										$annual_obligation=$q1_obligation+$q2_obligation+$q3_obligation+$q4_obligation;
										$annual_balance=$annual_allotment-$annual_obligation;
										$gt_q1_allotment+=$q1_allotment;
										$gt_q2_allotment+=$q2_allotment;
										$gt_q3_allotment+=$q3_allotment;
										$gt_q4_allotment+=$q4_allotment;
										$gt_allotment+=$annual_allotment;
										?>
									<tr>
										<td class="text-center">{{ $row->division_acronym }}</td>
										<td class="text-center">{{ $row->pap_code }}</td>
										<td class="text-center">{{ $row->object_code }}</td>
										<td>{{ $row->object_expenditure }}</td>
										<td>{{ $row->activity_subactivity }}</td>										
										<td class="text-right">{{ number_format($annual_allotment,2) }}</td>
										<td class="text-right">{{ number_format($q1_allotment,2) }}</td>
										<td class="text-right">{{ number_format($q2_allotment,2) }}</td>																			
										<td class="text-right">{{ number_format($q3_allotment,2) }}</td>																			
										<td class="text-right">{{ number_format($q4_allotment,2) }}</td>																			
									</tr>
									<?php
									}
								?>		
								<tr class="font-weight-bold text-right gray-bg">
									<td colspan="5">TOTAL</td>
									<td>&nbsp;{{ number_format($gt_allotment, 2) }}</td>
									<td>&nbsp;{{ number_format($gt_q1_allotment, 2) }}</td>
									<td>&nbsp;{{ number_format($gt_q2_allotment, 2) }}</td>
									<td>&nbsp;{{ number_format($gt_q3_allotment, 2) }}</td>
									<td>&nbsp;{{ number_format($gt_q4_allotment, 2) }}</td>
								</tr>							
								</tbody>
							</table>	 
						</div>    
					</div>					
				</div>				
			</div>	
		</div>	
	</section> 	
@endsection

@section('jscript')
	<script type="text/javascript">   
		$(document).ready(function(){    
			@include('scripts.common_script') 
		})

		$('.select_filter').on('change', function(){
			rstype_id_selected = $('#rstype_id_selected').val(),
			year_selected = $('#year_selected').val(),
			window.location.replace("{{ url('reports/allotment_summary') }}/"+rstype_id_selected+"/"+year_selected);
		})

		// $('.print').on('click', function(e){ 
		// 	rstype_id_selected = $('#rstype_id_selected').val();
		// 	window.open("{{ url('/print_rs_per_pap') }}/"+rstype_id_selected+"/"+start_date+"/"+end_date);
		// })    
	</script> 
@endsection	