@extends('layouts.app')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">Disbursement Vouchers (DV)</h1>
				</div>
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Funds Utilization</li>
						<li class="breadcrumb-item active">Disbursement Vouchers (DV)</li>
				</ol>
				</div>
			</div>
		</div>
	</div>
	
	<section class="content">  
		@php
			// $date_selected = $data['date_selected'];
			$date_selected = $date_selected;
		@endphp
		<div class="card refreshDiv">			
			<div class="card-header">
				<div class="row">
					<div class="col float-left"> 	
						<div class="row">						
							<label for="activity_id" class="col-form-label"><i class="fas fa-edit"></i>DV Date by Accounting</label>
							<div class="col-sm-3"> 
								<input type="text" id="date_selected1" name="date_selected1" value="" class="form-control">   	
							</div>			
						</div>
					</div>
					<div class="col float-left"> 	
						<div class="row">						
							<label for="activity_id" class="col-form-label"><i class="fas fa-edit"></i>DV Date by Division</label>
							<div class="col-sm-3"> 
								<input type="text" id="date_selected" value="{{ date('Y-m-d') }}" name="date_selected" class="form-control">   	
							</div>			
						</div>
					</div>					
					<label for="search_all" class="col-form-label"><i class="fas fa-edit"></i>Search (All)</label>		
					<div class="col-sm-2">															
						<input type="text" id="search_all" name="search_all" class="form-control">
					</div>
				</div>
			</div>    			

			<div class="card-body py-2">			
				<div class="row py-2">
					<div class="col table-responsive">
						<table id="dv_table" class="table-bordered table-hover" style="width: 100%;">
							<tbody>
							</tbody>
						</table>	 
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

		function getCurrentURL() {
			return window.location.pathname.split("/").pop()	
		}
		
		$("#date_selected").datepicker({
			todayHighlight: true,
         changeMonth: true,
         changeYear: true,
			dateFormat: 'yy-mm-dd',
			onSelect: function(date_selected) {
				console.log("Selected date: " + date_selected + "; input's current value: " + this.value);	
				window.history.pushState('', '',date_selected);	
				loadRecordsbyDivision();
			}				
		});

		$("#date_selected1").datepicker({
			todayHighlight: true,
         changeMonth: true,
         changeYear: true,
			dateFormat: 'yy-mm-dd',
			onSelect: function(date_selected1) {
				console.log("Selected date: " + date_selected1 + "; input's current value: " + this.value);	
				window.history.pushState('', '',date_selected1);	
				loadRecords();
			}				
		});

		$('#search_all').keyup(function() {
			loadRecordsbyDivision();
		});

		function loadRecordsbyDivision(){
			if($('#search_all').val()!=""){				
				var search_filter = $('#search_all').val();
				var date_filter = '';
				$('#date_selected').val('');		
				$('#date_selected1').val('');		
			}
			else if($('#search_all').val()==""){
				var date_filter = getCurrentURL();
				var search_filter = '';		
				$('#date_selected1').val('');		
				$('#date_selected').val(date_filter);		
			}
			// $.fn.dataTable.ext.errMode = 'throw';
			var dv_table = $('#dv_table').DataTable({				
				destroy: true,
				deferRender: true,
				info: true,
				iDisplayLength: 50,
				scrollY: 570,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				ajax: {
					url: "{{ route('show_dv_by_date') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'date_selected' : date_filter,
						'search' : search_filter,
					}      
				},
				order: [[2, 'desc']],
				columns: [
					{data: 'id', title: 'DV ID', width: '5%', className: 'dt-center'},   
					{data: 'dv_date2', title: 'DV Date<br><sup>(by Division)</sup>', width: '7%', className: 'dt-center'},   
					{data: 'dv_date', title: 'DV Date<br><sup>(by Acctng)</sup>', width: '7%', className: 'dt-center'},   
					{data: 'dv_no', title: 'DV No.', width: '5%', className: 'dt-center td_red'},
					{data: 'po_no', title: 'PO No.', width: '7%', className: 'dt-center'},
					{data: 'payee', title: 'Payee', width: '20%', className: 'dt-head-center'},
					{data: 'division_acronym', title: 'Division', width: '7%', className: 'dt-center'},
					{data: 'total_dv_gross_amount', title: 'Gross Amount', width: '11%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'total_dv_net_amount', title: 'Net Amount', width: '11%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'lddap_no', title: 'LDDAP No.', width: '15%', className: 'dt-center'},
					{data: 'ada_check_no', title: 'ADA/Check No.', width: '5%', className: 'dt-center'},
				]
			});			
		}

		function loadRecords(){		
			if($('#search_all').val()!=""){
				var search_filter = $('#search_all').val();
				var date_filter = '';	
				$('#date_selected').val('');		
				$('#date_selected1').val('');		
			}
			else if($('#search_all').val()==""){
				var date_filter = getCurrentURL();
				var search_filter = '';		
				$('#date_selected').val('');		
				$('#date_selected1').val(date_filter);	
			}
			$.fn.dataTable.ext.errMode = 'throw';
			var dv_table = $('#dv_table').DataTable({				
				destroy: true,
				deferRender: true,
				info: true,
				iDisplayLength: 50,
				scrollY: 570,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				stateSave: true,
				autoWidth: true,
				scroller: true,
				ajax: {
					url: "{{ route('show_dv_by_date') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'date_selected' : date_filter,
						'search' : search_filter,
						'accounting' : 1,
					}      
				},
				order: [[2, 'desc']],
				columns: [
					{data: 'id', title: 'DV ID', width: '5%', className: 'dt-center'},   
					{data: 'dv_date2', title: 'DV Date<br><sup>(by Division)</sup>', width: '7%', className: 'dt-center'},   
					{data: 'dv_date', title: 'DV Date<br><sup>(by Acctng)</sup>', width: '7%', className: 'dt-center'},   
					{data: 'dv_no', title: 'DV No.', width: '5%', className: 'dt-center td_red'},
					{data: 'po_no', title: 'PO No.', width: '7%', className: 'dt-center'},
					{data: 'payee', title: 'Payee', width: '20%', className: 'dt-head-center'},
					{data: 'division_acronym', title: 'Division', width: '7%', className: 'dt-center'},
					{data: 'total_dv_gross_amount', title: 'Gross Amount', width: '10%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'total_dv_net_amount', title: 'Net Amount', width: '10%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'lddap_no', title: 'LDDAP No.', width: '15%', className: 'dt-center'},
					{data: 'ada_check_no', title: 'ADA/Check No.', width: '7%', className: 'dt-center'},
				]
			});			
		}

		loadRecords();
   </script>  
@endsection

