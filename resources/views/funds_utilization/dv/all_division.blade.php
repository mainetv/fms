@extends('layouts.app')

@php
	$month_selected = $data['month_selected'];
	$year_selected = $data['year_selected'];
	$getUserDivisionID = getUserDivisionID($user_id);
	$division_id = getUserDivisionID($user_id);
	$getYears=getYears();
@endphp

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">Disbursement Voucher (DV)</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Funds Utilization</li>
						<li class="breadcrumb-item active">Disbursement Voucher (DV)</li>
				</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
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
						<input type="text" id="division_id" name="division_id" value="{{ $division_id }}" hidden>
					</div>													    
				</div>
			</div>    

			<div class="card-body py-2">	
				<div class="row py-2">
					<div class="col table-responsive">
						<table id="dv_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								<th style="min-width: 6%; max-width: 6%">DV Date</th>
								<th style="min-width: 16%; max-width: 16%">Payee</th>
								<th style="min-width: 27%; max-width: 27%">Particulars</th>
								<th nowrap style="min-width: 10%; max-width: 10%;">Gross Amount</th>
								<th nowrap style="min-width: 10%; max-width: 10%;">Net Amount</th>
								<th style="min-width: 5%; max-width: 5%;">DV No.</th>
								<th style="min-width: 6%; max-width: 6%;">Check/ LDDAP Date</th>
								<th style="min-width: 12%; max-width: 11%;">Check/ LDDAP No.</th>
								<th style="min-width: 6%; max-width: 6%;">Date Transferred</th>
							</thead>		
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

		function changeFilter(){         
			month = $("#month_selected").val();
         year = $("#year_selected").val();
			window.location.replace("{{ url('funds_utilization/dv/all_division') }}/"+month+"/"+year);
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
			var dv_table = $('#dv_table').DataTable({
				destroy: true,
				info: true,
				iDisplayLength: 50,
				scrollY: 550,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				processing: true,
				responsive: true,
dom: 'Bfrtip',
				ajax: {
					url: "{{ route('show_dv_by_month_year') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'month_selected' : month_selected,
						'year_selected' : year_selected,
						'search' : search_filter,
					}      
				},
				columns: [  
					{data: 'dv_date', name: 'DV Date', className: 'dt-center'}, 
					{data: 'payee', name: 'Payee',  className: 'dt-head-center'},
					{data: 'particulars', name: 'Particulars', className: 'dt-head-center'},
					{data: 'total_dv_gross_amount', name: 'Gross Amount', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'total_dv_net_amount', name: 'Net Amount', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},
					{data: 'dv_no', name: 'DV No.',  className: 'dt-center td_red'},
					{data: 'lddap_date', name: 'Check/ LDDAP Date',  className: 'dt-center'},
					{data: 'lddap_no', name: 'Check/ LDDAP No.', className: 'dt-center'},
					{data: 'date_transferred', name: 'Date Transferred', className: 'dt-center'},
				],
			});
			
		}

		loadRecords();
   </script>  
@endsection

