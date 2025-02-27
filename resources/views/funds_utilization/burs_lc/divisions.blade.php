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
		<div class="card refreshDiv">			
			<div class="card-header">
				<div class="row">
					<div class="col-10 float-left">            
						<h3 class="card-title">
							<i class="fas fa-edit"></i>
							<label for="year_selected">Year: </label>                        
							<?php $month_selected = $data['month_selected']; ?> 
                     <select name="month_selected" id="month_selected" onchange="changeMonth()">     
                           <option value="01" <?php if($month_selected=='01') { echo "selected='selected'" ; } ?>>January</option>
                           <option value="02" <?php if($month_selected=='02') { echo "selected='selected'" ; } ?>>February</option>
                           <option value="03" <?php if($month_selected=='03') { echo "selected='selected'" ; } ?>>March</option>
                           <option value="04" <?php if($month_selected=='04') { echo "selected='selected'" ; } ?>>April</option>
                           <option value="05" <?php if($month_selected=='05') { echo "selected='selected'" ; } ?>>May</option>
                           <option value="06" <?php if($month_selected=='06') { echo "selected='selected'" ; } ?>>June</option>
                           <option value="07" <?php if($month_selected=='07') { echo "selected='selected'" ; } ?>>July</option>
                           <option value="08" <?php if($month_selected=='08') { echo "selected='selected'" ; } ?>>August</option>
                           <option value="09" <?php if($month_selected=='09') { echo "selected='selected'" ; } ?>>September</option>
                           <option value="10" <?php if($month_selected=='10') { echo "selected='selected'" ; } ?>>October</option>
                           <option value="11" <?php if($month_selected=='11') { echo "selected='selected'" ; } ?>>November</option>
                           <option value="12" <?php if($month_selected=='12') { echo "selected='selected'" ; } ?>>December</option>
                         </select>
                     </select>
							<label for="year_selected">Year: </label>                        
                     <?php $year_selected = $data['year_selected']; ?> 
                     <select name="year_selected" id="year_selected" onchange="changeYear()">               
                        @foreach ($years as $row)
                           <option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
                        @endforeach    
                     </select>                                             
						</h3>
					</div>  
					<?php 
						$division_id = $user_division_id;									
					?> 					             
					<div class="col-2">
					</div>													    
				</div>
			</div>    

			<div class="card-body py-2">				
				<div class="content">					
					<div class="row">	
						<div class="col-4 float-left">
						</div>
						<div class="col-4 text-center">               
							{{-- <h2>{{ $user_division_acronym }}</h2>		   --}}
						</div>  
						<div class="col-4 py-2">	
									
						</div>
					</div>
				</div>
				<div class="row py-3">
					<div class="col table-responsive">
						<table id="ors_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								{{-- <th style="max-width: 30px;">Date/Time Created</th> --}}
								<th style="max-width: 28px;">ORS Date</th>
								<th>ORS No.</th>
								<th style="max-width: 30px;">Responsibility<br>Center</th>
								<th style="max-width: 150px;">Payee</th>
								<th style="max-width: 200px;">Particulars</th>
								<th>Amount</th>
							</thead>		
							<tbody><?php														
								$sqlActivityAllDivision = getRSActivityAllotmentAllDivision('1', $year_selected);
								$sqlActivityByDivision = getRSActivityAllotmentByDivision('1', $division_id, $year_selected);
								$sqlRS = getAllRS('1', $month_selected, $year_selected);
								foreach($sqlRS as $row){
									$id = $row->id;
									$created_at = $row->created_at;
									$rs_date = $row->rs_date;
									$rs_no = $row->rs_no;
									$is_locked = $row->is_locked;
									$payee = $row->payee;
									$division_acronym = $row->division_acronym;
									$particulars = $row->particulars;
									$total_amount = $row->total_amount; ?>
									<tr class="text-center">
										<td style="max-width: 15px;">{{ $rs_date }}</td>
										<td nowrap style="max-width: 75px;">{{ $rs_no }}</td>
										<td class="text-left" style="max-width: 30;">{{ $division_acronym }}</td>
										<td class="text-left" style="max-width: 150px;">
											<a data-id="{{ $id }}" data-user-role-id={{ $user_role_id }} href="{{ url('funds_utilization/rs/edit/'.$id) }}" >
											{{ $payee }}</a>
										</td>										
										<td class="text-left" style="max-width: 200px;">{{ $particulars }}</td>
										<td class="text-right" nowrap>{{ $total_amount }}</td>
										@role('Budget Officer')			
											<td class="text-center" style="max-width:22px">	
												<button type="button" data-id="{{ $id }}" data-toggle="modal" data-target="#ors_modal"
													data-division-id="{{ $division_id }}" data-toggle="tooltip" data-placement='auto' 
													title='View'class="btn-xs btn_view"><i class="fa-solid fa-eye"></i>																				
												</button>		
												{{-- <button type="button" class="btn-xs"><a data-id="{{ $id }}" data-user-role-id={{ $user_role_id }}
													data-toggle="tooltip" data-placement='auto' title='Edit' href="{{ url('funds_utilization/rs/'.$id) }}" >
													<i class="fa-solid fa-pen-to-square fa-lg green"></i>
												</a></button>													 --}}
												{{-- <button type="button" class="btn-xs btn_edit" data-id="{{ $id }}" data-user-role-id={{ $user_role_id }}
													data-toggle="modal" data-target="#ors_modal" data-toggle="tooltip" data-placement='auto' title='Edit'>
													<i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
												</button>	 --}}
												{{-- <button type="button" class="btn-xs btn_delete" data-id="{{ $id }}" 
													data-toggle="tooltip" data-placement='auto'title='Delete'>
													<i class="fa-solid fa-trash-can fa-lg red"></i>
												</button>																																																											  --}}
											</td>
										@endrole
									</tr><?php
								}	?>								 
							</tbody>
						</table>	 
					</div>    
				</div>					
			</div>
		</div>            
	</section>
	@include('funds_utilization.ors.modal')	
@endsection

@section('jscript')
   <script type="text/javascript">   
      $(document).ready(function(){ 
         @include('funds_utilization.ors.script')   
         @include('scripts.common_script')   

			$('.select2bs4').select2({
				theme: 'bootstrap4'
			})     

			$(document).on('select2:open', () => {
         	document.querySelector('.select2-search__field').focus();
      	});   
      }) 
		function changeMonth()
		{         
			month = $("#month_selected").val();
         year = $("#year_selected").val();
         hash = window.location.hash;
			window.location.replace("{{ url('funds_utilization/rs/ors') }}/"+month+"/"+year+"/"+hash);
		}
      function changeYear()
		{         
			month = $("#month_selected").val();
         year = $("#year_selected").val(); 
         hash = window.location.hash;
			window.location.replace("{{ url('funds_utilization/rs/ors') }}/"+month+"/"+year+"/"+hash);
		}		 
   </script>  
@endsection

