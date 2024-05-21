@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getFunds=getFunds();
@endphp

@section('content')
	<section class="content">
		<div class="card text-left">
			<div class="card-header">
				<h5 class="font-weight-bold">
					Reports of Checks Issued
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
								<thead>
									<th>Date</th>
									<th>Check No.</th>
									<th>DV No.</th>
									<th>ORS/BURS No.</th>
									<th>Division</th>
									<th>Payee</th>
									<th>Amount</th>
								</thead>
								<tbody>
								</tbody>
								<tfoot>									
								</tfoot>
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
				scrollY: 590,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				ajax: {
					url: "{{ route('show_checks') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'fund_id_selected' : fund_id_selected,
						'start_date' : start_date,
						'end_date' : end_date,						
					}      
				},
				columns: [
					{data: 'check_date', name: 'Date', width: '7%', className: 'dt-center'},  
					{data: 'check_no', name: 'Check No.', width: '10%', className: 'dt-center'},
					{data: 'dv_no', name: 'DV No.', width: '10%', className: 'dt-center'},
					{data: 'rs_no', name: 'ORS/BURS No.', width: '25%', className: 'dt-center'},
					{data: 'dv_division_acronym', name: 'Division.', width: '8%', className: 'dt-center'},
					{data: 'payee', name: 'Payee', width: '30%', className: 'dt-head-center'},
					{data: 'total_dv_net_amount', name: 'Amount', width: '10%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},							
				],
				"footerCallback": function (row, data, start, end, display) {
					var api = this.api(),
						intVal = function (i) {
								return typeof i === 'string' ?
										i.replace(/[, Rs]|(\.\d{2})/g,"")* 1 :
										typeof i === 'number' ?
										i : 0;
						},
						total2 = api
								.column(6)
								.data()
								.reduce(function (a, b) {
									return intVal(a) + intVal(b);
								}, 0);
				
					$(api.column(6).footer()).html(
								' ( $' + total2 + ' total)'
								);
				}

			});				
		}		
	</script> 
@endsection	