@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getFunds=getFunds();
	$getPayees=getPayees();
@endphp

@section('content')
	<section class="content">
		<div class="card text-left">
			<div class="card-header">
				<h5 class="font-weight-bold">
					Index of Payment
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">
							<label for="payee_id" class="col-form-label">Payee:</label>
							<div class="col-sm-6">
								<select id="payee_id_selected" name="payee_id_selected" class="select2bs4" style="width: 100%;" onChange="changeFilter();">   
									<option value="" selected hidden>Select Payee</option>
									@foreach ($getPayees as $row)
										<option value="{{ $row->id }}" data-id="{{ $row->id }}" 
											@if(isset($row->id) && $payee_id_selected==$row->id) selected @endif>
											{{ $row->payee }} [{{ $row->bank_acronym }}: {{ $row->bank_account_no }}]
										</option>
									@endforeach                           
								</select>
							</div>&emsp;							
							<label for="payee_id" class="col-form-label">Year:</label>
							<div class="col-sm-1">
								<select id="year_selected" name="year_selected" class="form-control" style="width: 100%;" onChange="changeFilter();">   
									@foreach ($getYears as $row)
										<option value="{{ $row->year }}" data-id="{{ $row->year }}" @if($year_selected==$row->year) selected @endif>
											{{ $row->year }}</option>
									@endforeach                           
								</select>
							</div> 
				</div>
				<div class="row py-2">
					<div class="col table-responsive">
						@php
							foreach ($data as $row) {
								$payee=$row->payee;
								$address=$row->address;
								$tin=$row->tin;
							}
						@endphp
						<br>
						<table width="100%" id="records_table" border="1" class="text-center" cellpadding="2" cellspacing="0">
							<thead>
								<tr class="text-left">
									<td colspan="3" valign="top">Creditor:<br /><strong>{{ $payee ?? NULL }}</strong></td>
									<td colspan="4" valign="top">Address:<br /><strong>{{ $address ?? NULL }}</strong></td>
									<td colspan="3" valign="top">TIN: <br /><strong>{{ $tin ?? NULL }}</strong></td>
								</tr>
								<tr class="text-left">
									<td width="53" rowspan="3" class="text-center">Date</td>
									<td width="108" rowspan="3" class="text-center">Reference/DV No.</td>
									<td width="290" rowspan="3" class="text-center">Particulars</td>
									<td colspan="2" class="text-center">Check/LDDAP-ADA</td>
									<td colspan="5" class="text-center">AMOUNT</td>
								</tr>
								<tr>
									<td width="75" rowspan="2" class="text-center">Date</td>
									<td width="75" rowspan="2" class="text-center">No.</td>
									<td width="79" rowspan="2" class="text-center">Gross Amount</td>
									<td colspan="3" class="text-center">Deductions</td>
									<td width="77" rowspan="2" class="text-center">Net Amount</td>
								</tr>
								<tr>
									<td width="76" class="text-center">W/Tax</td>
									<td width="73" class="text-center">Other Deductions</td>
									<td width="72" class="text-center">Total</td>
								</tr>
							</thead>
							<tbody><?php
								foreach ($data as $row){	
									$total_deductions = $row->total_other_deductions + $row->total_tax;
									?>					
									<tr>
										<td>{{ $row->dv_date }}</td>
										<td>{{ $row->dv_no }}</td>
										<td>{{ $row->particulars }}</td>
										<td>{{ $row->lddap_check_date }}</td>
										<td>{{ $row->lddap_check_no }}</td>
										<td class="text-right">{{ number_format($row->total_dv_gross_amount,2) }}</td>
										<td class="text-right">{{ number_format($row->total_tax,2) }}</td>
										<td class="text-right">{{ number_format($row->total_other_deductions,2) }}</td>
										<td class="text-right">{{ number_format($total_deductions,2) }}</td>
										<td class="text-right">{{ number_format($row->total_dv_net_amount,2) }}</td>
									</tr><?php
								}  ?>
							</tbody>
						</table>	 
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

		function changeFilter()
		{     
			payee_id_selected = $("#payee_id_selected").val();
			year_selected = $("#year_selected").val();
			window.location.replace("{{ url('reports/index_payment') }}/"+payee_id_selected+"/"+year_selected);
			// loadRecords(payee_id_selected, year_selected);
		}	

		// function loadRecords(payee_id_selected, year_selected){	
		// 	// alert(payee_id_selected);		
		// 	// alert(year_selected);		
		// 	var records_table = $('#records_table').DataTable({				
		// 		destroy: true,
		// 		deferRender: true,
		// 		info: false,
		// 		orderable: false,
		// 		searching: false,
		// 		paging: false,
		// 		fixedColumns: true,
		// 		stateSave: true,
		// 		autoWidth: true,
		// 		scroller: true,
		// 		ajax: {
		// 			url: "{{ route('show_index_payment') }}",
		// 			method: "GET",
		// 			data : {
		// 				'_token': '{{ csrf_token() }}',
		// 				'payee_id_selected' : payee_id_selected,
		// 				'year_selected' : year_selected,						
		// 			}      
		// 		},
		// 		columns: [
		// 			{data: 'payee', name: 'Creditor', width: '6%', className: 'dt-center'},					
		// 			{data: 'address', name: 'Address', width: '6%', className: 'dt-center'},					
		// 			{data: 'tin', name: 'TIN', width: '6%', className: 'dt-center'},					
		// 		]
		// 	});			
		// }	
	</script> 
@endsection	