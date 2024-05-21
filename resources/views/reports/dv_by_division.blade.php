@extends('layouts.app')

@php
	$getAllActiveDivisions=getAllActiveDivisions();
	$getRDDivisions=getRDDivisions();
	$getARMMSDivisions=getARMMSDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
	$getFunds=getFunds();
	$getPaymentModes=getPaymentModes();	
@endphp

@section('content')
	<section class="content">
		<div class="card text-left">
			<div class="card-header">
				<h5 class="font-weight-bold">
					Report of Disbursement
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">
					<div>
						<label>Fund:</label>  
						<select name="fund_id_selected" id="fund_id_selected" onchange="changeFilter()">
							<option value="All">All</option>
							@foreach($getFunds as $row)
								<option value="{{ $row->id }}" data-selected="{{ $row->id }}">{{ $row->fund }}</option>
							@endforeach
						</select>
					</div>&emsp;
					<div> 		
						@role('Super Administrator|Administrator|Budget Officer|Cash Officer|Cluster Budget Controller')
						<label>Division: </label> 		
							<select name="division_id" id="division_id" onchange="changeFilter()">	
								@if($user_division_id==20)
									@foreach($getRDDivisions as $row)
										<option value="{{ $row->id }}" data-selected="{{ $row->id }}"
											@if($user_division_id == $row->id) selected @endif>{{ $row->division_acronym }}</option>
									@endforeach
								@elseif($user_division_id==21)
									@foreach($getARMMSDivisions as $row)
										<option value="{{ $row->id }}" data-selected="{{ $row->id }}"
											@if($user_division_id == $row->id) selected @endif>{{ $row->division_acronym }}</option>
									@endforeach
								@endif
							</select>
						@else
							<input type="text" id="division_id" value="{{ $user_division_id }}" hidden>
						@endrole
					</div>&emsp;					
					<div>
						<label>Date range:</label>  
						<input type="text" name="date_range" id="date_range" readonly/>
					</div> 
				</div>
				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table id="records_table" style="width: 100%;">
								{{-- <thead>
									<th>Date</th>
									<th>LDDAP/Check No.</th>
									<th>Payee</th>
									<th>DV Gross Amount</th>
									<th>Deduction</th>
									<th>ORS/BURS Amount</th>
									<th>ORS/BURS No.</th>
								</thead>
								<tbody>
								</tbody> --}}
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

		$('#date_range').daterangepicker(
			{
				locale: {
					format: 'YYYY-MM-DD',
				},
				showDropdowns: true,
				startDate: moment(),
				endDate: moment(),
			},
			function(start, end, label) {
				console.log(start.format('YYYY-MM-DD'));	
				console.log(end.format('YYYY-MM-DD'));	
				start_date = start.format('YYYY-MM-DD');
				end_date = end.format('YYYY-MM-DD');
				loadRecords(division_id, fund_id_selected, start_date, end_date);
			},
		);

		var date = moment();
		var start_date = date.format('YYYY-MM-D');
		var end_date = date.format('YYYY-MM-D');
		var fund_id_selected=$('#fund_id_selected').val();	
		var division_id=$('#division_id').val();	
		loadRecords(division_id, fund_id_selected, start_date, end_date);

		function changeFilter(){			
			var fund_id_selected=$('#fund_id_selected').val();				
			var division_id=$('#division_id').val();		
			loadRecords(division_id, fund_id_selected, start_date, end_date);		
		}	

		function loadRecords(division_id, fund_id_selected, start_date, end_date){	
			var records_table = $('#records_table').DataTable({				
				destroy: true,
				deferRender: true,
				info: true,
				searching: true,
				paging: false,
				scrollY: 540,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				ajax: {
					url: "{{ route('show_dvs_by_division') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'division_id' : division_id,
						'fund_id_selected' : fund_id_selected,
						'start_date' : start_date,
						'end_date' : end_date,						
					}      
				},
				columns: [
					{data: 'id', title: 'DV ID', width: '4%', className: 'dt-center'},  		
					{data: 'dv_date', title: 'DV Date', width: '8%', className: 'dt-center'},	
					{data: 'payee', title: 'Payee', width: '20%', className: 'dt-head-center'},  			
					// {data: 'particulars', title: 'Particulars', width: '20%', className: 'dt-head-center'},  			
					{data: 'rs_no', title: 'ORS/BURS No.', width: '10%', className: 'dt-center'},					
					{data: 'dv_division_acronym', title: 'Division', width: '4%', className: 'dt-center'},
					{data: 'total_dv_net_amount', title: 'DV Amount', width: '7%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'lddap_check_date', title: 'LDDAP/Check Date', width: '6%', className: 'dt-center'},
					{data: 'lddap_check_no', title: 'LDDAP/Check No.', width: '7%', className: 'dt-center'},
				]
			});			
		}		
	</script> 
@endsection	