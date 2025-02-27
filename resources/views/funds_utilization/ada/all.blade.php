@extends('layouts.app')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">{{ $title }}</h1>
				</div>
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Funds Utilization</li>
						<li class="breadcrumb-item active">{{ $title }}</li>
				</ol>
				</div>
			</div>
		</div>
	</div>
	
	<section class="content">  
		@php
			$fund_selected = $data['fund_selected'];
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
							<label for="year_selected">Fund: </label>      
							<select name="fund_selected" id="fund_selected" onchange="changeFilter()">               
								@foreach ($getFunds as $row)
									<option value="{{ $row->id }}" @if(isset($row->fund) && $fund_selected==$row->id){{"selected"}} @endif > {{ $row->fund }}</option>
								@endforeach    
							</select> 
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
								@foreach ($years as $row)
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
						<table id="ada_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								<th style="min-width: 6%; max-width: 6%"></th>
								<th style="min-width: 6%; max-width: 6%;">SLIIAE No.</th>
								<th style="min-width: 7%; max-width: 7%;">Date</th>
								<th style="min-width: 5%; max-width: 5%;">Fund</th>
								<th style="min-width: 13%; max-width: 13%;">Bank Account No.</th>
								<th style="min-width: 7%; max-width: 7%;">Date Transferred</th>
								<th nowrap style="min-width: 14%; max-width: 14%;">PS</th>
								<th nowrap style="min-width: 14%; max-width: 14%;">MOOE</th>
								<th nowrap style="min-width: 14%; max-width: 14%;">CO</th>
								<th nowrap style="min-width: 14%; max-width: 14%;">Total</th>
								@role('Cash Officer')
									<th class="text-center" style="min-width: 3%; max-width: 3%;">						
										<a href="{{ url('funds_utilization/ada/add') }}" data-toggle="tooltip" data-placement='left'
											title='Add ADA' data-division-id="{{ $division_id }}" data-year="{{ $year_selected }}">								
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
	@include('funds_utilization.ada.modal')	
@endsection

@section('jscript')
  <script type="text/javascript">   
		$(document).ready(function(){ 
		@include('funds_utilization.ada.script')   
		@include('scripts.common_script')   
		}) 

    	function changeFilter()
		{         
			fund = $("#fund_selected").val();
			month = $("#month_selected").val();
      	year = $("#year_selected").val();
			window.location.replace("{{ url('funds_utilization/ada') }}/"+fund+"/"+month+"/"+year);
		}

		function getCurrenURL() {
			return window.location.pathname.split('/');
		}

		function getCurrenURL() {
			return window.location.pathname.split('/');
		}

		$('#search_all').keyup(function() {
			loadRecords();
		});

		function loadRecords(){
			if($('#search_all').val()!=""){
				var search_filter = $('#search_all').val();
				var fund_selected = '';
				var month_selected = '';
				var year_selected = '';
			}
			else if($('#search_all').val()==""){
				var current_filter = getCurrenURL();
				var search_filter = '';	
				// server
				// var fund_selected = `${current_filter[4]}`;
				// var month_selected = `${current_filter[5]}`; 
				// var year_selected = `${current_filter[6]}`; 
				// local
				var fund_selected = `${current_filter[5]}`;
				var month_selected = `${current_filter[6]}`; 
				var year_selected = `${current_filter[7]}`; 
							
			}	
			// alert(fund_selected);
			var ada_table = $('#ada_table').DataTable({
				destroy: true,
				info: true,
				iDisplayLength: 50,
				scrollY: 510,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				processing: true,
				responsive: true,
				ajax: {
					url: "{{ route('show_ada_by_fund_month_year') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'fund_selected' : fund_selected,
						'month_selected' : month_selected,
						'year_selected' : year_selected,
						'search' : search_filter,
					}      
				},
				columns: [  
					{data: 'id', name: 'id', visible: false}, 
					{data: 'ada_no', name: 'SLIIAE No.', className: 'dt-center'}, 
					{data: 'ada_date', name: 'Date',  className: 'dt-center'},
					{data: 'fund', name: 'Fund',  className: 'dt-center'},
					{data: 'bank_account_no', name: 'Bank Account No.', className: 'dt-center'},
					{data: 'date_transferred', name: 'Date Transferred', className: 'dt-center'},
					{data: 'total_ps_amount', name: 'PS', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'total_mooe_amount', name: 'MOOE', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'total_co_amount', name: 'CO', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'total_ada_amount', name: 'Total', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: null,className: 'dt-center', orderable: false,
						render: function ( data, type, full, meta ) {
							if (full.total_ada_amount == '0') {
								return '<button class="btn-xs btn_delete btn btn-outline-danger" type="button" data-id="' + full.id + '" data-toggle="tooltip" data-placement="left" title="Delete ADA"><i class="fa-solid fa-trash-can fa-lg"></i> </button>';
							} else {
								return '<button class="btn-xs btn btn-outline-danger disabled"><i class="fa-solid fa-trash-can fa-lg gray"></i></button>';
							}
						}				
					},					
				],				
			});	
		}

		loadRecords();
   </script>  
@endsection

