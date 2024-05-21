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
					LDDAP/Checks Issued
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">
					<div>
						{{-- <label>Request and Status Type:</label>  												
						<select name="rstype_id_selected" id="rstype_id_selected" class="select_filter">
							<option value="All">All</option>
							@foreach($getRSTypes as $row)
								<option value="{{ $row->id }}" data-selected="{{ $row->id }}">{{ $row->request_status_type }}</option>
							@endforeach
						</select> --}}
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
									<th>LDDAP/Check No.</th>
									<th>Payee</th>
									<th>DV Gross Amount</th>
									<th>Deduction</th>
									<th>ORS/BURS Amount</th>
									<th>ORS/BURS No.</th>
								</thead>
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
				loadRecords(rstypeid, start_date, end_date);
			},
		);

		var date = moment();
		var start_date = date.format('YYYY-MM-D');
		var end_date = date.format('YYYY-MM-D');
		var fund_id_selected=$('#fund_id_selected').val();	
		// if(rstypeid=='1'){
		// 	rs_type='ORS';
		// }
		// else if(rstypeid=='All'){
		// 	rs_type='RS';
		// }
		// else{
		// 	rs_type='BURS';
		// }
		// $(".rs_type").html(rs_type);
		loadRecords(fund_id_selected, start_date, end_date);

		$('.select_filter').on('change', function(){			
			var fund_id_selected=$('#fund_id_selected').val();	
			// if(rstypeid=='1'){
			// 	rs_type='ORS';
			// }
			// else if(rstypeid=='All'){
			// 	rs_type='RS';
			// }
			// else{
			// 	rs_type='BURS';
			// }
			// $(".rs_type").text(rs_type);
			// document.getElementByClass("rs_type").innerHTML=rs_type;
			// $('.rs_type span').text($('#totalCount').data('resultcount'))
			// $('.rs_type').each(function() { 
			// 	$(this).text(rs_type) 
			// });
			// alert(rstypeid);
			loadRecords(fund_id_selected, start_date, end_date);		
		})	

		function loadRecords(fund_id_selected, start_date, end_date){	
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
					url: "{{ route('show_lddap_check_by_fund_daterange') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'fund_id_selected' : fund_id_selected,
						'start_date' : start_date,
						'end_date' : end_date,						
					}      
				},
				columns: [
					{data: 'date', name: 'Date', width: '7%', className: 'dt-center'},  
					{data: 'ref_no', name: 'LDDAP/Check No.', width: '20%', className: 'dt-head-center'},
					{data: 'payee', name: 'Payee', width: '25%', className: 'dt-head-center'},
					{data: 'total_dv_net_amount', name: 'DV Gross Amount', width: '10%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},		
					{data: 'total_tax', name: 'Deduction', width: '10%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'total_rs_amount', name: 'ORS/BURS Amount', width: '10%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'rs_no', title: 'ORS/BURS No.', width: '7%', className: 'dt-center'},
				]
			});			
		}		
	</script> 
@endsection	