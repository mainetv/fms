@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
@endphp

@section('content')
	<section class="content">
		<div class="card text-left">
			<div class="card-header">
				<h5 class="font-weight-bold">
					DV ORS/BURS per PAP
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">				
					<div>
						<label>Request and Status Type:</label>							  				
						<select name="rstype_id_selected" id="rstype_id_selected" class="select_filter">
							<option value="All">All</option>
							@foreach($getRSTypes as $row)
								<option value="{{ $row->id }}" data-selected="{{ $row->id }}">{{ $row->request_status_type }}</option>
							@endforeach
						</select>
					</div>&emsp;
					<div>
						<label>Date range:</label>   					
						<input type="text" name="date_range" id="date_range" readonly/>
					</div>		
					<div class="col-1">    			
						<select class="select_filter" id="view_filter">
							<option value="All">All</option>
							<option value="NoDV">No DV</option>
							<option value="wDV">With DV</option>
							<option value="NoPayment">No Payment</option>
						</select>
					</div>	
				</div>
				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table id="rs_table" style="width: 100%;">
								<tbody>
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
				loadRecords(start_date, end_date);
			},
		);		
		
		var date = moment();
		var start_date = date.format('YYYY-MM-D');
		var end_date = date.format('YYYY-MM-D');

		loadRecords(start_date, end_date);

		$('.select_filter').on('change', function(){
			loadRecords(start_date, end_date);
		})

		function loadRecords(start_date, end_date){		
			var rs_table = $('#rs_table').DataTable({				
				destroy: true,
				deferRender: true,
				info: true,
				searching: true,
				paging: false,
				scrollY: 550,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				ajax: {
					url: "{{ route('show_rs_balance') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',						
						'rstype_id_selected' : $('#rstype_id_selected').val(),
						'start_date' : start_date,
						'end_date' : end_date,
						'filter' : $('#view_filter').val(),
					}      
				},
				columns: [
					{data: 'rs_date', title: 'Date', width: '6%', className: 'dt-center'},   
					{data: 'allotment_division_acronym', title: 'Division', width: '6%', className: 'dt-center'},  
					{data: 'rs_no', title: 'ORS/BURS No.', width: '10%', className: 'dt-hcenter'},
					{data: 'payee', title: 'Payee', width: '20%', className: 'dt-head-center'},
					{data: 'pap_code', title: 'PAP Code', width: '6%', className: 'dt-center'},
					{data: 'expense_account_object_code', title: 'Account/Object Code', width: '8%', className: 'dt-center'},
					{data: 'expense_account_object_expenditure', title: 'Account/Object', width: '12%', className: 'dt-head-center'},
					{data: 'total_rs_pap_amount', title: 'ORS Amount', width: '8%', className: 'dt-head-center dt-body-right gray3-bg',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'dv_no', title: 'DV No.', width: '6%', className: 'dt-center'},
					{data: 'gross_amount', title: 'DV Gross Amount', width: '7%', className: 'dt-head-center dt-body-right gray3-bg',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'lddap_check_no', title: 'LDDAP/Check No.', width: '10%', className: 'dt-center'},
				]
			});			
		}		
	</script> 
@endsection	