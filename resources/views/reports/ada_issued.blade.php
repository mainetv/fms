@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
	$getFunds=getFunds();
@endphp

@section('content')
	<section class="content">
		<div class="card text-left">
			<div class="card-header">
				<h5 class="font-weight-bold">
					Report pf LDDAP-ADA Issued
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">
					<div>
						<label>Fund:</label>  												
						<select name="fund_id_selected" id="fund_id_selected" class="select_filter">
							<option value="All">All</option>
							@foreach($getFunds as $row)
								<option value="{{ $row->id }}" data-selected="{{ $row->id }}">{{ $row->fund }}</option>
							@endforeach
						</select>
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
									<th><span class="rs_type"></span> Amount</th>
									<th><span class="rs_type"></span> No.</th>
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
				loadRecords(fund_id_selected, start_date, end_date);
			},
		);

		var date = moment();
		var start_date = date.format('YYYY-MM-D');
		var end_date = date.format('YYYY-MM-D');
		var fund_id_selected=$('#fund_id_selected').val();	
		loadRecords(fund_id_selected, start_date, end_date);

		$('.select_filter').on('change', function(){	
			var fund_id_selected=$('#fund_id_selected').val();	
			loadRecords(fund_id_selected, start_date, end_date);		
		})	

		function loadRecords(fund_id_selected, start_date, end_date){	
			var records_table = $('#records_table').DataTable({				
				destroy: true,
				deferRender: true,
				info: true,
				searching: true,
				paging: false,
				scrollY: 600,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				ajax: {
					url: "{{ route('show_lddaps') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'fund_id_selected' : fund_id_selected,
						'start_date' : start_date,
						'end_date' : end_date,						
					}      
				},
				columns: [
					{data: 'lddap_date', title: 'Date', width: '7%', className: 'dt-center'},  
					{data: 'lddap_no', title: 'LDDAP No.', width: '10%', className: 'dt-center'},
					{data: 'dv_no', title: 'DV No.', width: '10%', className: 'dt-center'},
					{data: 'rs_no', title: 'ORS/BURS No.', width: '25%', className: 'dt-center'},
					// {data: 'division_acronym', title: 'Division.', width: '8%', className: 'dt-center'},
					{data: 'payee', title: 'Payee', width: '30%', className: 'dt-head-center'},
					// {data: 'nature_of_payment', name: 'nature_of_payment', width: '25%', className: 'dt-head-center'},
					{data: 'total_dv_net_amount', title: 'Amount', width: '10%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},							
				]
			});			
		}			
	</script> 
@endsection	