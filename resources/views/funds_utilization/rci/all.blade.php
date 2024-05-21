@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
	$getAllBankAccounts=getAllBankAccounts();
@endphp

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">Report of Checks Issued (RCI)</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Funds Utilization</li>
						<li class="breadcrumb-item active">Report of Checks Issued (RCI)</li>
				</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	
	<section class="content">  
		@php
			$month_selected = $data['month_selected'];
			$year_selected = $data['year_selected'];
			$division_id = $user_division_id;
		@endphp
		<div class="card refreshDiv">			
			<div class="card-header">
				<div class="row">
					<div class="col float-left">            
						<h3 class="card-title">
							<i class="fas fa-edit"></i>
							<label for="year_selected">Month: </label> 
							<select name="month_selected" id="month_selected" onchange="changeFilter()">     
								<option value="01" @if($month_selected=='01') selected @endif>January</option>
								<option value="02" @if($month_selected=='02') selected @endif>February</option>
								<option value="03" @if($month_selected=='03') selected @endif>March</option>
								<option value="04" @if($month_selected=='04') selected @endif>April</option>
								<option value="05" @if($month_selected=='05') selected @endif>May</option>
								<option value="06" @if($month_selected=='06') selected @endif>June</option>
								<option value="07" @if($month_selected=='07') selected @endif>July</option>
								<option value="08" @if($month_selected=='08') selected @endif>August</option>
								<option value="09" @if($month_selected=='09') selected @endif>September</option>
								<option value="10" @if($month_selected=='10') selected @endif>October</option>
								<option value="11" @if($month_selected=='11') selected @endif>November</option>
								<option value="12" @if($month_selected=='12') selected @endif>December</option>
							</select>
							<label for="year_selected">Year: </label>      
							<select name="year_selected" id="year_selected" onchange="changeFilter()">               
								@foreach ($getYears as $row)
									<option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
								@endforeach    
							</select>                                             
						</h3>
					</div>  					             
					<label for="search_all" class="col-form-label"><i class="fas fa-edit"></i>Search (All)</label>		
					<div class="col-sm-2">															
						<input type="text" id="search_all" name="search_all" class="form-control">
						<input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
						<input type="text" id="division_id" name="division_id" value="{{ $division_id }}" hidden>
					</div>											    
				</div>
			</div>    
			
			<div class="card-body py-2">	
				<div class="row">
					<button class="print btn float-left"  data-toggle="tooltip" data-placement='auto'title='Generate PDF' disabled>
						<i class="fa-2xl fa-solid fa-print"></i></button>
					<input type="text" id="rci_id" name="rci_id" hidden>
				</div>
				
				<div class="row py-2">					
					<div class="col-4 table-responsive">
						<table id="rci_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								<th width="20%">RCI No.</th>
								<th width="20%">Date</th>
								<th width="15%">Fund</th>
								<th width="30%">Bank Account No.</th>
								@role('Cash Officer')
									<th width="15%">		
										<button class='btn_add btn-xs btn btn-outline-primary' type='button' data-toggle='tooltip' 
											data-placement='left' title='Add RCI' data-toggle="modal" data-target="#rci_modal">
											<i class="fa-solid fa-plus fa-lg"></i>					
									  </button>  																							 
									</th>
								@endrole								
							</thead>	
							<tbody>								
							</tbody>
						</table>	 
					</div>    
					<div class="col-8 table-responsive">						
						<table id="records_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								<th width="7%">Check No.</th>
								<th width="33%">Payee</th>
								<th width="50%">Particulars</th>
								<th width="10%">Amount</th>
							</thead>	
							<tbody>								
							</tbody>
						</table>	 
					</div>    
				</div>					
			</div>
		</div>            
	</section>
	@include('funds_utilization.rci.modal')	
@endsection

@section('jscript')
  <script type="text/javascript">   
		$(document).ready(function(){   
			@include('funds_utilization.rci.script')	
			@include('scripts.common_script')   
		}) 

    	function changeFilter()
		{         
			month = $("#month_selected").val();
      	year = $("#year_selected").val();
			window.location.replace("{{ url('funds_utilization/rci/all/') }}/"+month+"/"+year);
		}

		function getCurrenURL() {
			return window.location.pathname.split('/');
		}
		
		$('#search_all').keyup(function() {
			loadRCI();
		});

		loadRCI();

		function loadRCI(){
			$('.print').prop('disabled', true);
			if($('#search_all').val()!=""){
				var search_filter = $('#search_all').val();
				var month_selected = '';
				var year_selected = '';
			}
			else if($('#search_all').val()==""){
				var current_filter = getCurrenURL();
				var search_filter = '';	
				// server
				var month_selected = `${current_filter[5]}`; 
				var year_selected = `${current_filter[6]}`; 
				// local
				// var month_selected = `${current_filter[6]}`; 
				// var year_selected = `${current_filter[7]}`; 							
			}	
			var rci_table = $('#rci_table').DataTable({
				destroy: true,
				iDisplayLength: 50,
				scrollY: 530,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				processing: true,
				responsive: true,
				searching: false,
				paging:   false,
				ordering: false,
				info: false,
				ajax: {
					url: "{{ route('show_rci_by_month_year') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'month_selected' : month_selected,
						'year_selected' : year_selected,
						'search' : search_filter,
					}      
				},
				columns: [  
					{data: 'rci_no', name: 'RCI No.', className: 'dt-center'}, 
					{data: 'rci_date', name: 'Date',  className: 'dt-center'},
					{data: 'fund', title: 'Fund',  className: 'dt-center'},
					{data: 'bank_account_no', name: 'Bank Account No.', className: 'dt-center'},					
					{data: 'action', name: '', className: 'dt-center'},					
				],
			});	

		}

		$('#rci_table').on('click', '.btn_load_checks', function(e){  
			var rci_id = $(this).data('id');
			$('#rci_id').val(rci_id);
			loadRecords(rci_id);
		});

		function loadRecords(rci_id){
			$('.print').prop('disabled', false);
			nRow=0;
			var records_table = $('#records_table').DataTable({
				destroy: true,
				iDisplayLength: 50,
				scrollY: 530,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				processing: true,
				responsive: true,
				searching: false,
				paging:   false,
				ordering: false,
				info: false,
				ajax: {
					url: "{{ route('show_check_dvs_by_rci') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'rci_id' : rci_id,
					}      
				},
				columns: [  
					{data: 'check_no', name: 'Check No.', className: 'dt-center'}, 
					{data: 'payee', name: 'Payee',  className: 'dt-head-center'},
					{data: 'particulars', title: 'Nature of Payment',  className: 'dt-head-center'},				
					{data: 'total_dv_net_amount', name: 'Amount', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
				],	
			});				
		}
		
   </script>  
@endsection

