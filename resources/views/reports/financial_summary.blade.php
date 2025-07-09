@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
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
					Financial Summary
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">
					<div class="col-1">
						<label>Fund:</label>  												
						<select name="fund_id_selected" id="fund_id_selected" class="select_filter">
							<option value="All">All</option>
							@foreach($getFunds as $row)
								<option value="{{ $row->id }}" data-selected="{{ $row->id }}">{{ $row->fund }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-2">    			
						<label>DV Filter:</label>  
						<select class="select_filter" id="view_filter">
							<option value="All">All</option>
							<option value="NoDV">No DV</option>
							<option value="wDVwLDDAPorCheck">With DV & LDDAP/Check</option>
							<option value="wDVNoLDDAPorCheck">With DV, No LDDAP/Check</option>
						</select>
					</div>
					<div class="col-5">
						<div class="col-12">
							<input type="radio" name="date_range_filter" id="rs_filter" value="rs"> <label>ORS/BURS date range:</label>
							<input type="text" name="rs_date_range" id="rs_date_range" readonly/>
						</div>
						<div class="col-12">
							<input type="radio" name="date_range_filter" id="lddap_check_filter" value="lddap"> <label>LDDAP date range:</label>
							<input type="text" name="lddap_check_date_range" id="lddap_check_date_range" readonly/>
						</div>
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
		$('input[name="date_range_filter"]').prop('checked', false);
		$('#rs_date_range, #lddap_check_date_range').prop('disabled', true).val('');

		// Initialize the date range pickers but don't set default values
		$('#rs_date_range, #lddap_check_date_range').daterangepicker({
        locale: { format: 'YYYY-MM-DD' },
        showDropdowns: true,
        autoUpdateInput: false // Prevents the field from auto-populating
    	});

		$('input[name="date_range_filter"]').change(function () {
        if ($('#rs_filter').is(':checked')) {
            $('#rs_date_range').prop('disabled', false);
            $('#lddap_check_date_range').prop('disabled', true).val(''); // Clear & disable LDDAP
        } else if ($('#lddap_check_filter').is(':checked')) {
            $('#lddap_check_date_range').prop('disabled', false);
            $('#rs_date_range').prop('disabled', true).val(''); // Clear & disable RS
        }
    	}); 

		// Handle date selection for RS
		$('#rs_date_range').on('apply.daterangepicker', function (ev, picker) {
		  if (!$(this).prop('disabled')) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            loadRecords(); // Load records only on date selection
        }
    	});

		// Handle date selection for LDDAP and Check
		$('#lddap_check_date_range').on('apply.daterangepicker', function (ev, picker) {
			if (!$(this).prop('disabled')) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            loadRecords(); // Load records only on date selection
        }
		});
		
		// Handle fund and view filter change
		$('#fund_id_selected, #view_filter').change(function () {
			loadRecords();
		});

		function updateDateRange() {
			let start_date = '';
			let end_date = '';
			let date_range_filter = $('input[name="date_range_filter"]:checked').val() || ''; // Get selected radio button value

			if ($('#rs_filter').is(':checked') && !$('#rs_date_range').prop('disabled')) {
					let dates = $('#rs_date_range').val().split(' - ');
					start_date = dates[0] || '';
					end_date = dates[1] || '';
			} else if ($('#lddap_check_filter').is(':checked') && !$('#lddap_check_date_range').prop('disabled')) {
					let dates = $('#lddap_check_date_range').val().split(' - ');
					start_date = dates[0] || '';
					end_date = dates[1] || '';
			}

			 // If either date is empty, default to today's date
			if (!start_date || !end_date) {
					const today = new Date();
					const formattedToday = today.toISOString().split('T')[0]; // "YYYY-MM-DD"					
					start_date = formattedToday;
					end_date = formattedToday;
					
					// If no operator is selected, default to '=' for a single-day filter
        if (!date_range_filter) {
            date_range_filter = '=';
        }
			}
			
			return { start_date, end_date, date_range_filter };
		}

		function getSelectedDateRange() {
			return updateDateRange();
		}

		function loadRecords(){	
			var fund_id_selected = $('#fund_id_selected').val();
			var view_filter = $('#view_filter').val();
			var { start_date, end_date, date_range_filter } = getSelectedDateRange(); 

			if (!start_date || !end_date || !date_range_filter) {
        console.warn("Date range is incomplete. Records not loaded.");
        return; // Exit the function early
    	}

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
					url: "{{ route('show_financial_summary') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'fund_id_selected' : fund_id_selected,
						'date_range_filter' : date_range_filter,
						'start_date' : start_date,
						'end_date' : end_date,						
						'view_filter' : view_filter,						
					}      
				},
				columns: [					
					{data: 'payee', title: 'Payee', width: '12%', className: 'dt-head-center'},  
					{data: 'activity', title: 'Activity', width: '12%', className: 'dt-head-center'},  
					{data: 'subactivity', title: 'Subactivity', width: '12%', className: 'dt-head-center'}, 
					{data: 'objcode', title: 'Object', width: '7%', className: 'dt-head-center'},
					{data: 'rs_date', title: 'ORS/BURS Date', width: '6%', className: 'dt-center'},
					{data: 'rs_no', title: 'ORS/BURS No.', width: '8%', className: 'dt-center'},
					{data: 'rs_division_acronym', title: 'Division', width: '4%', className: 'dt-center'},					
					{data: 'total_rs_pap_amount', title: 'ORS/BURS Amount', width: '7%', className: 'dt-head-center dt-body-right gray3-bg',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},					
					{data: 'dv_date', title: 'DV Date', width: '6%', className: 'dt-center'},
					{data: 'dv_no', title: 'DV No.', width: '6%', className: 'dt-center'},		
					{data: 'total_dv_gross_amount', title: 'DV Gross Amount', width: '7%', className: 'dt-head-center dt-body-right gray3-bg',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},			
					{data: 'total_dv_net_amount', title: 'DV Net Amount', width: '7%', className: 'dt-head-center dt-body-right gray3-bg',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'lddap_check_date', title: 'LDDAP/Check Date', width: '6%', className: 'dt-center'},
					{data: 'lddap_check_no', title: 'LDDAP/Check No.', width: '7%', className: 'dt-center'},
				]
			});			
		}		
	</script> 
@endsection	