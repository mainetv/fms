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
						LDDAP Summary
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
								<option value="{{ $row->id }}" @if(isset($row->id) && $fund_id_selected==$row->id){{"selected"}} @endif > {{ $row->fund }}</option>
							@endforeach    
						</select>
					</div> &emsp;
					<label>Date range:</label>   
					<div>&nbsp;
						<input type="text" name="date_range" id="date_range"/>						
					</div> 
				</div>
				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table id="records_table" style="width: 100%;">
								<thead class="text-center">
									<tr>
										<th colspan="8">CREDITOR</th>
										<th colspan="4">In PESOS</th>
									</tr>
									<tr>
										<th width="2%"></th>
										<th width="6%">LDDAP DATE</th>
										<th width="3%">Fund</th>
										<th width="7%">NCA No.</th>
										<th width="10%">LDDAP No.</th>
										<th width="26%">Name</th>
										<th width="15%">ORS No.</th>
										<th width="6%">Allotment Class/Object</th>
										<th width="7%">Gross Amount</th>
										<th width="6%">Other Deduction</th>
										<th width="5%">WTax</th>
										<th width="7%">Net Amount</th>
									</tr>
								</thead>
								<tbody><?php 
									$count=1;
									$gt_gross_amount=0;
									$gt_other_deductions=0;
									$gt_tax=0;
									$gt_net_amount=0;
									foreach($data as $row){
										$gross_amount=$row->gross_amount;
										$tax_one=$row->tax_one;
										$tax_two=$row->tax_two;
										$tax_twob=$row->tax_twob;
										$tax_three=$row->tax_three;
										$tax_five=$row->tax_five;
										$tax_six=$row->tax_six;
										$wtax=$row->wtax;
										$other_tax=$row->other_tax;
										$liquidated_damages=$row->liquidated_damages;
										$other_deductions=$row->other_deductions;
										$total_tax=$tax_one+$tax_two+$tax_twob+$tax_three+$tax_five+$tax_six+$wtax+$other_tax;
										$total_other_deductions=$liquidated_damages+$other_deductions;
										$total_deductions=$total_tax+$total_other_deductions;
										$net_amount=$gross_amount-$total_deductions;
										$gt_gross_amount+=$gross_amount;
										$gt_other_deductions+=$total_other_deductions;
										$gt_tax+=$total_tax;
										$gt_net_amount+=$net_amount;	
										// echo $data;
										$dv_id=$row->dv_id;?>
										<tr class="text-center">
											<td>{{ $count }}</td>
											<td>{{ $row->lddap_check_date }}</td>
											<td>{{ $row->fund }}</td>
											<td>{{ $row->nca_no }}</td>
											<td nowrap>{{ $row->lddap_check_no }}</td>
											<td class="text-left">{{ $row->payee_bank_account_name }}</td>				
											<td>{{ $row->rs_no }}</td>										
											<td>{{ $row->allotment_class_acronym }}</td>									
											<td class="text-right">{{ number_format($gross_amount,2) }}</td>										
											<td class="text-right">{{ number_format($total_other_deductions,2) }}</td>		
											<td class="text-right">{{ number_format($total_tax,2) }}</td>																	
											<td class="text-right">{{ number_format($net_amount,2) }}</td>
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

		function getCurrenURL() {
			return window.location.pathname.split('/');
		}
		var current_filter = getCurrenURL();
		//server
		var start_date = `${current_filter[5]}`; 
		var end_date = `${current_filter[6]}`; 
		//local
		// var start_date = `${current_filter[6]}`; 
		// var end_date = `${current_filter[7]}`; 

		$('#date_range').daterangepicker(
			{
				locale: {
					format: 'YYYY-MM-DD',
				},
				showDropdowns: true,
				startDate: start_date,
				endDate: end_date,
			},
			function(start, end) {
				console.log(start.format('YYYY-MM-DD'));	
				console.log(end.format('YYYY-MM-DD'));	
				start_date = start.format('YYYY-MM-DD');
				end_date = end.format('YYYY-MM-DD');
				changeFilter(start_date, end_date);		
			},	
		);

		function changeFilter(){
			fund_id_selected = $('#fund_id_selected').val(),
			window.location.replace("{{ url('reports/lddap_summary') }}/"+fund_id_selected+"/"+start_date+"/"+end_date);
		}

		// $('.print').on('click', function(e){ 
		// 	rstype_id_selected = $('#rstype_id_selected').val();
		// 	window.open("{{ url('/print_rs_per_pap') }}/"+rstype_id_selected+"/"+start_date+"/"+end_date);
		// })    
	</script> 
@endsection	