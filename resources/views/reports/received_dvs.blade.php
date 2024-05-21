@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
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
						Received DVs
					</h5> 
				</div>
				{{-- <div class="col-1">    
					<button class="print btn float-left"  data-toggle="tooltip" data-placement='auto'title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button>
				</div>     --}}
			</div>   
			<div class="card-body">
				<div class="row">		
					<label>Date range:</label>   
					<div>&nbsp;
						<input type="text" name="date_range" id="date_range" readonly/>							
					</div> 
				</div>
				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table id="records_table" style="width: 100%;">
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

		function loadRecords(start_date, end_date){	
			var records_table = $('#records_table').DataTable({				
				destroy: true,
				deferRender: true,
				info: true,
				searching: true,
				paging: false,
				scrollY: 580,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				ajax: {
					url: "{{ route('show_dvs') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'start_date' : start_date,
						'end_date' : end_date,						
					}      
				},
				columns: [
					{data: 'dv_no', title: 'DV No.', type: 'num', width: '5%', className: 'dt-center'},  
					{data: 'dv_date', title: 'DV Date', width: '6%', className: 'dt-center'},
					{data: 'payee', title: 'Payee', width: '25%', className: 'dt-head-center'},
					{data: 'dv_division_acronym', title: 'Division', width: '6%', className: 'dt-center'},
					{data: 'total_dv_net_amount', title: 'DV Amount', width: '8%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},				
					{data: 'rs_no', title: 'ORS/BURS No.', width: '16%', className: 'dt-center'},
					{data: 'fund', title: 'Fund', width: '5%', className: 'dt-center'},
					{data: 'accnt_obj_code', title: 'Object Code', width: '8%', className: 'dt-center'},
					{data: 'tax_one', title: '1%', width: '3%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'tax_two', title: '2%', width: '3%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'tax_twob', title: '2%-b', width: '3%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'tax_three', title: '4%', width: '3%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'tax_five', title: '5%', width: '3%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'tax_six', title: '6%', width: '3%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'wtax', title: 'WTax', width: '3%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
				]
			});			
		}	
	</script> 
@endsection	