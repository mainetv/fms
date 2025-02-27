@extends('layouts.app')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">Budget Utilization Request and Status <br>- Coconut Trust Fund - Admin Cost (BURS-CFITF-AC)</h1>
				</div>
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
					<li class="breadcrumb-item active">Funds Utilization</li>
					<li class="breadcrumb-item active">Budget Utilization Request and Status <br>- Coconut Trust Fund - Admin Cost (BURS-CFITF-AC)</li>
				</ol>
				</div>
			</div>
		</div>
	</div>
	
	<section class="content"> 
		@php
			$month_selected = $data['month_selected'];
			$year_selected = $data['year_selected'];
			$division_id = $user_division_id;
			$rs_type_id = 4;	
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
						<table id="rs_table" class="table-bordered table-hover" style="width: 100%;">
							
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

			$('.select2bs4').select2({
				theme: 'bootstrap4'
			})     

			$(document).on('select2:open', () => {
         	document.querySelector('.select2-search__field').focus();
      	});   
      }) 		

		function changeFilter(){         
			month = $("#month_selected").val();
         year = $("#year_selected").val();
			window.location.replace("{{ url('funds_utilization/rs/all/burs-cfitf-ac') }}/"+month+"/"+year);
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
				var month_selected = `${current_filter[6]}`; 
				var year_selected = `${current_filter[7]}`; 
				// local
				// var month_selected = `${current_filter[7]}`; 
				// var year_selected = `${current_filter[8]}`; 				
			}			
			var rs_table = $('#rs_table').DataTable({
				destroy: true,
				info: true,
				iDisplayLength: 100,
				scrollY: 520,
				scrollX: true,
				scrollCollapse: true,
				fixedColumns: true,
				processing: true,
				responsive: true,
				ajax: {
					url: "{{ route('show_rs_by_month_year') }}",
					method: "GET",
					data : {
						'_token': '{{ csrf_token() }}',
						'rs_type_id' : '4',
						'rs_type' : 'BURS-CFITF-AC',
						'month_selected' : month_selected,
						'year_selected' : year_selected,
						'search' : search_filter,
					}      
				},
				columns: [  
					{data: 'rs_date', title: 'BURS Date', width: '7%',className: 'dt-center'}, 
					{data: 'rs_no', title: 'BURS No.', width: '16%', className: 'dt-center'},
					{data: 'division_acronym', title: 'Responsibility Center', width: '8%', className: 'dt-center'},
					{data: 'payee', title: 'Payee', width: '20%', className: 'dt-head-center'},
					{data: 'particulars', title: 'Particulars', width: '38%', className: 'dt-head-center'},
					{data: 'total_rs_pap_amount', title: 'Amount', width: '11%', className: 'dt-head-center dt-body-right',
						render: $.fn.dataTable.render.number(',', '.', 2, '')
					},					
				],
			});			
		}

		loadRecords();	 
   </script>  
@endsection

