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
					Disbursement Voucher per Division
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
						<label>Division:</label>	
						<select name="division_id" id="division_id" class="select_filter">
							@foreach($getAllDivisions as $row)
								<option value="{{ $row->id }}" data-selected="{{ $row->id }}">{{ $row->division_acronym }}</option>
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
			var records_table = $('#records_table').DataTable({				
				destroy: true,
				deferRender: true,
				info: true,
				iDisplayLength: 50,
				scrollY: 580,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				serverSide: true,
				ajax: {
					url: "{{ route('show_dv_by_fund_division_daterange') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'fund_id_selected' : $('#fund_id_selected').val(),
						'division_id' : $('#division_id').val(),
						'start_date' : start_date,
						'end_date' : end_date,						
					}      
				},
				columns: [
					{data: 'division_acronym', title: 'Division', width: '8%', className: 'dt-center'},   
					{data: 'fund', title: 'Fund', width: '5%', className: 'dt-center'},  
					{data: 'dv_date', title: 'DV Date', width: '6%', className: 'dt-center'},
					{data: 'dv_no', title: 'DV No.', width: '6%', className: 'dt-center'},
					{data: 'payee', title: 'Payee', width: '40%', className: 'dt-head-center'},
					{data: 'total_dv_net_amount', title: 'DV Amount', width: '8%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},					
				]
			});			
		}		
	</script> 
@endsection	