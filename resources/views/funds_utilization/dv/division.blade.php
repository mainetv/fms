@extends('layouts.app')

@php
	$month_selected = $data['month_selected'];
	$year_selected = $data['year_selected'];
	$division_id = $user_division_id;
	$getYears=getYears();
@endphp

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">Disbursement Voucher (DV)</h1>
				</div>
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Funds Utilization</li>
						<li class="breadcrumb-item active">Disbursement Voucher (DV)</li>
				</ol>
				</div>
			</div>
		</div>
	</div>
	
	<section class="content">  		
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
				<div class="row py-2">
					<div class="col table-responsive">
						<table id="dv_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								<th style="min-width: 6%; max-width: 6%"></th>
								<th style="min-width: 6%; max-width: 6%">DV Date</th>
								<th style="min-width: 20%; max-width: 20%">Payee</th>
								<th style="min-width: 30%; max-width: 30%">Particulars</th>
								<th nowrap style="min-width: 12%; max-width: 12%;">Amount</th>
								<th style="min-width: 5%; max-width: 5%;">DV No.</th>
								@if($user_role_id==4)
									<th style="min-width: 6%; max-width: 6%;">Check/ LDDAP Date</th>
									<th style="min-width: 12%; max-width: 12%;">Check/ LDDAP No.</th>
								@else
									<th style="min-width: 6%; max-width: 6%;">LDDAP Date</th>
									<th style="min-width: 12%; max-width: 12%;">LDDAP No.</th>
								@endif
								<th style="min-width: 6%; max-width: 6%;">Date Transferred</th>
								@role('Division Budget Controller')
									<th class="text-center" style="min-width: 3%; max-width: 3%">						
										<a href="{{ url('funds_utilization/dv/add') }}" data-toggle="tooltip" data-placement='left'
											title='Add DV' data-division-id="{{ $division_id }}" data-year="{{ $year_selected }}">								
										<button type="button" class="btn-xs btn btn-outline-primary"><i class="fa-solid fa-plus fa-lg"></i></button></a>														 
									</th>
								@endrole
							</thead>		
						</table>	 
					</div>    
				</div>					
			</div>
		</div>            
	</section>
	@include('funds_utilization.dv.modal')	
@endsection

@section('jscript')
   <script type="text/javascript">   
      $(document).ready(function(){ 
         @include('funds_utilization.dv.script')   
         @include('scripts.common_script')      
      }) 

		function changeFilter(){         
			month = $("#month_selected").val();
         year = $("#year_selected").val();
			window.location.replace("{{ url('funds_utilization/dv/division') }}/"+month+"/"+year);
		}	 

		function getCurrenURL() {
			return window.location.pathname.split('/');
		}

		$('#search_all').keyup(function() {
			loadRecords();
		});

		function loadRecords(){	
			var user_role_id = $('#user_role_id').val();
			var division_id = $('#division_id').val();
			
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

			var userRole = @json(auth()->user()->getRoleNames());

			var dv_table_columns = [
				{data: 'id', name: 'id', visible: false}, 
				{data: 'dv_date', name: 'DV Date', className: 'dt-center'}, 
				{data: 'payee', name: 'Payee',  className: 'dt-head-center'},
				{data: 'particulars', name: 'Particulars', className: 'dt-head-center'},
				{data: 'total_dv_gross_amount', name: 'Amount', className: 'dt-head-center dt-body-right',
					render: $.fn.dataTable.render.number(',', '.', 2, '')
				},
				{data: 'dv_no', name: 'DV No.',  className: 'dt-center td_red'},
				{data: 'lddap_date', name: 'LDDAP Date.',  className: 'dt-center'},
				{data: 'lddap_no', name: 'LDDAP No.', className: 'dt-center'},
				{data: 'date_transferred', name: 'Date Transferred', className: 'dt-center'},
			];

			if (userRole.includes('Division Budget Controller')) {
				dv_table_columns.push({
					data: null,
					className: 'dt-center',
					orderable: false,
					render: function (data, type, full, meta) {
						if (full.dv_no==null) {
							return '<button class="btn-xs btn_delete btn btn-outline-danger" type="button" data-id="' + full.id + '" data-toggle="tooltip" data-placement="left" title="Delete DV"><i class="fa-solid fa-trash-can fa-lg"></i> </button>';
						} else {
							return '<button class="btn-xs btn btn-outline-danger disabled"><i class="fa-solid fa-trash-can fa-lg gray"></i></button>';
						}
					}				
				});
			}

			var dv_table = $('#dv_table').DataTable({
				destroy: true,
				info: true,
				iDisplayLength: 50,
				scrollY: 530,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				processing: true,
				responsive: true,
				ajax: {
					url: "{{ route('show_dv_by_division_month_year') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'division_id' : division_id,
						'month_selected' : month_selected,
						'year_selected' : year_selected,
						'search' : search_filter,
					}      
				},
				columns: dv_table_columns,
			});
		}

		loadRecords();
   </script>  
@endsection

