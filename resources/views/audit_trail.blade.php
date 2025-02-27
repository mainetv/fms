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
					Audit Trail
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">
					<div>	 
						<label>Type:</label>  
						<select name="type_selected" id="type_selected" class="select_filter">
							<option value="All">All</option>
							<option value="App\Models\RSModel">Request and Status</option>
							<option value="App\Models\DVModel">Disbursement Voucher</option>
							<option value="App\Models\LDDAPModel">LDDAP</option>
							<option value="App\Models\ADAModel">ADA</option>
							<option value="App\Models\CheckModel">Check</option>
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
							<table id="audits_table" style="width: 100%;">
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
			var audits_table = $('#audits_table').DataTable({				
				destroy: true,
				deferRender: true,
				info: true,
				iDisplayLength: 50,
				scrollY: 520,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				serverSide: true,
				ajax: {
					url: "{{ route('show_audits_by_filter') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'type' : $('#type_selected').val(),
						'start_date' : start_date,
						'end_date' : end_date,						
					}      
				},
				columns: [
					{data: 'fullname_last', title: 'User', width: '11%', className: 'dt-center'},   
					{data: 'event', title: 'Action', width: '5%', className: 'dt-center'},   
					{data: 'auditable_id', title: 'Record ID', width: '3%', className: 'dt-center'},   
					{data: 'auditable_type', title: 'Module', width: '7%', className: 'dt-center'},   
					{data: 'old_values', title: 'Old Values', width: '30%', className: 'dt-center'},   
					{data: 'new_values', title: 'New Values', width: '30%', className: 'dt-center'},   
					{data: 'url', title: 'URL', width: '7%', className: 'dt-center'},   
					{data: 'created_at', title: 'Date Created', width: '7%', className: 'dt-center'},   
				]
			});			
		}		
	</script> 
@endsection	