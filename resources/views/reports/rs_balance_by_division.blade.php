@extends('layouts.app')

@php
	$getAllActiveDivisions=getAllActiveDivisions();
	$getRDDivisions=getRDDivisions();
	$getARMMSDivisions=getARMMSDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
@endphp

@section('content')
	<section class="content">
		<div class="card text-left">
			<div class="card-header">
				<h5 class="font-weight-bold">
					ORS/BURS Balance
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">				
					<div>
						<label>Request and Status Type:</label>						  				
						<select name="rstype_id_selected" id="rstype_id_selected" onchange="changeFilter()">
							<option value="All">All</option>
							@foreach($getRSTypes as $row)
								<option value="{{ $row->id }}" data-selected="{{ $row->id }}">{{ $row->request_status_type }}</option>
							@endforeach
						</select>
					</div>&emsp;
					@role('Super Administrator|Administrator|Budget Officer|Cash Officer|Cluster Budget Controller')
						<div> 								
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
						</div>&emsp;
					@else
						<input type="text" id="division_id" value="{{ $user_division_id }}" hidden>
					@endrole

					<div>
						<label>Date range:</label>   					
						<input type="text" name="date_range" id="date_range" readonly/>
					</div>		
					<div class="col-1">    			
						<select id="view_filter"  onchange="changeFilter()">
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
								{{-- <tbody>
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
				loadRecords(division_id, rstype_id_selected, start_date, end_date,view_filter);
			},
		);	
		
		var date = moment();
		var start_date = date.format('YYYY-MM-D');
		var end_date = date.format('YYYY-MM-D');
		var rstype_id_selected=$('#rstype_id_selected').val();	
		var division_id=$('#division_id').val();	
		var view_filter=$('#view_filter').val();	
		loadRecords(division_id, rstype_id_selected, start_date, end_date,view_filter);

		function changeFilter(){		
			var rstype_id_selected=$('#rstype_id_selected').val();				
			var division_id=$('#division_id').val();		
			var view_filter=$('#view_filter').val();	
			loadRecords(division_id, rstype_id_selected, start_date, end_date,view_filter);		
		}	

		function loadRecords(division_id, rstype_id_selected, start_date, end_date,view_filter){		
			var rs_table = $('#rs_table').DataTable({				
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
					url: "{{ route('show_rs_balance_by_division') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',						
						// 'rstype_id_selected' : $('#rstype_id_selected').val(),
						// 'division_id' : $('#division_id').val(),
						'rstype_id_selected' : rstype_id_selected,
						'division_id' : division_id,
						'start_date' : start_date,
						'end_date' : end_date,
						'filter' : view_filter,
						// 'filter' : $('#view_filter').val(),
					}      
				},
				columns: [
					{data: 'allotment_division_acronym', title: 'Allottment Division', width: '8%', className: 'dt-center'},   
					{data: 'rs_division_acronym', title: 'ORS/BURS Division', width: '8%', className: 'dt-center'},   
					{data: 'rs_date', title: 'Date', width: '6%', className: 'dt-center'},  
					{data: 'rs_no', title: 'ORS/BURS No.', width: '14%', className: 'dt-center'},
					{data: 'payee', title: 'Payee', width: '25%', className: 'dt-head-center'},
					{data: 'total_rs_pap_amount', title: 'ORS Amount', width: '9%', className: 'dt-head-center dt-body-right gray3-bg',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'dv_no', title: 'DV No.', width: '6%', className: 'dt-center'},
					{data: 'gross_amount', title: 'DV Gross Amount', width: '9%', className: 'dt-head-center dt-body-right gray3-bg',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'balance', title: 'Balance', width: '9%', className: 'dt-head-center dt-body-right gray3-bg',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'lddap_check_no', title: 'Check/ADA No.', width: '14%', className: 'dt-center'},
				]
			});			
		}		
	</script> 
@endsection	