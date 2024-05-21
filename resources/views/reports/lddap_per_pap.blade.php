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
					LDDAP per PAP/Account Code
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">
					<div>
						<label>Funds:</label>  			
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
				scrollY: 520,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				ajax: {
					url: "{{ route('show_lddap_by_fund_daterange') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'rstype_id_selected' : $('#rstype_id_selected').val(),
						'start_date' : start_date,
						'end_date' : end_date,
					}      
				},
				// order: [[5, 'desc']],
				columns: [
					{data: 'payee', title: 'Payee', width: '18%', className: 'dt-head-center'},   
					{data: 'pap_code', title: 'PAP Code', width: '7%', className: 'dt-center'},  
					{data: 'object_code', title: 'Object Code', width: '7%', className: 'dt-center'},
					{data: 'object_expenditure', title: 'Object Expenditure', width: '15%', className: 'dt-head-center'},
					{data: 'rs_no', title: 'ORS No.', width: '10%', className: 'dt-center'},
					{data: 'rs_date', title: 'Date', width: '6%', className: 'dt-center'},
					{data: 'division_acronym', title: 'Division', width: '5%', className: 'dt-center'},
					{data: 'total_rs_amount', title: 'ORS Amount', width: '10%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'total_tax', title: 'Tax', width: '5%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'other_deductions', title: 'Other Deduction', width: '5%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'date', title: 'LDDAP Date', width: '6%', className: 'dt-center'},
					{data: 'ref_no', title: 'LDDAP No.', width: '11%', className: 'dt-center'},
				]
			});			
		}		
	</script> 
@endsection	