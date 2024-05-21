@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getFunds=getFunds();
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
						Disbursement Summary
					</h5> 
				</div>
				<div class="col-1">    
					{{-- <button class="print btn float-left"  data-toggle="tooltip" data-placement='auto'title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button> --}}
				</div>    
			</div>   
			<div class="card-body">
				<div class="row">		
					<div>
						<label>Fund:</label> 							  			
						<select name="fund_id_selected" id="fund_id_selected" onChange="changeFilter();">               
							@foreach ($getFunds as $row)
								<option value="{{ $row->id }}" @if(isset($row->id) && $fund_id_selected==$row->id) selected @endif > {{ $row->fund }}</option>
							@endforeach    
						</select>
					</div> &emsp;					
					<label>Year:</label>   
					<div>&nbsp;
						<select name="fund_id_selected" id="fund_id_selected" onChange="changeFilter();">               
							@foreach ($getYears as $row)
								<option value="{{ $row->id }}" @if(isset($row->id) && $year_selected==$row->year) selected @endif > {{ $row->year }}</option>
							@endforeach    
						</select>				
					</div> 
				</div>
				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table id="records_table" style="width: 100%;">
								<thead class="text-center">
									<tr>
										<th width="2%">Object Code</th>
										<th width="3%">Object</th>										
										<th width="6%">1st Quarter</th>
										<th width="6%">2nd Quarter</th>
										<th width="6%">3rd Quarter</th>
										<th width="6%">4th Quarter</th>
										<th width="7%">Total</th>
									</tr>
								</thead>
								<tbody><?php 
									$count=1;
									$gt_gross_amount=0;
									$gt_other_deductions=0;
									$gt_tax=0;
									$gt_net_amount=0;
									foreach($data as $row){
										$total_dv_gross_amount=$row->total_dv_gross_amount;
										$total_tax=$row->total_tax;
										$other_deductions=$row->other_deductions;
										$total_dv_net_amount=$row->total_dv_net_amount;	
										$gt_gross_amount+=$total_dv_gross_amount;
										$gt_other_deductions+=$other_deductions;
										$gt_tax+=$total_tax;
										$gt_net_amount+=$total_dv_net_amount;									
										?>
									<tr class="text-center">										
										<td>{{ $row->object_code }}</td>										
										{{-- <td class="text-right">{{ number_format($total_dv_gross_amount,2) }}</td>										
										<td class="text-right">{{ number_format($other_deductions,2) }}</td>		
										<td class="text-right">{{ number_format($total_tax,2) }}</td>																	
										<td class="text-right">{{ number_format($total_dv_net_amount,2) }}</td>																	 --}}
									</tr>
									<?php
									$count=$count+1;
									}	?>		
									<tr class="text-right font-weight-bold">
										<td colspan="8"></td>
										<td>{{  number_format($gt_gross_amount,2) }}</td>	
										<td>{{  number_format($gt_other_deductions,2) }}</td>	
										<td>{{  number_format($gt_tax,2) }}</td>	
										<td>{{  number_format($gt_net_amount,2) }}</td>	
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

		// function getCurrenURL() {
		// 	return window.location.pathname.split('/');
		// }
		// var current_filter = getCurrenURL();
		//server
		// var start_date = `${current_filter[5]}`; 
		// var end_date = `${current_filter[6]}`; 
		//local
		// var start_date = `${current_filter[6]}`; 
		// var end_date = `${current_filter[7]}`; 

		// $('#date_range').daterangepicker(
		// 	{
		// 		locale: {
		// 			format: 'YYYY-MM-DD',
		// 		},
		// 		showDropdowns: true,
		// 		startDate: start_date,
		// 		endDate: end_date,
		// 	},
		// 	function(start, end) {
		// 		console.log(start.format('YYYY-MM-DD'));	
		// 		console.log(end.format('YYYY-MM-DD'));	
		// 		start_date = start.format('YYYY-MM-DD');
		// 		end_date = end.format('YYYY-MM-DD');
		// 		changeFilter(start_date, end_date);		
		// 	},	
		// );

		function changeFilter(){
			fund_id_selected = $('#fund_id_selected').val(),
			year_selected = $('#year_selected').val(),
			window.location.replace("{{ url('reports/lddap_summary') }}/"+fund_id_selected+"/"+year_selected);
		}

		// $('.print').on('click', function(e){ 
		// 	rstype_id_selected = $('#rstype_id_selected').val();
		// 	window.open("{{ url('/print_rs_per_pap') }}/"+rstype_id_selected+"/"+start_date+"/"+end_date);
		// })    
	</script> 
@endsection	