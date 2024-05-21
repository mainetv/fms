@extends('layouts.app')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">{{ $title }}</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Programming & Allocation</li>
						<li class="breadcrumb-item active">NEP</li>
						<li class="breadcrumb-item active">{{ $title }}</li>
				</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	
	<section class="content">  
		<div class="card refreshDiv">			
			<div class="card-header">
				<div class="row">
					<div class="col-10 float-left">  
							@csrf              
							<h3 class="card-title float-left">
								<i class="fas fa-edit"></i>
								<label for="year_selected">Year: </label>                        
								<?php $year = $data['year_selected']; ?> 
								<select name="year_selected" id="year_selected" onchange="changeYear()">               
									@foreach ($years as $row)
										<option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
									@endforeach    
								</select>                                              
							</h3>				
					</div>  			
					<?php 
						// $cash_program_id = 0;
						// $division_acronym = '';
						// $status_id = 0;
						// $fiscal_year1 = '';
						// $fiscal_year2 = '';
						// $fiscal_year3 = '';
						// $get_user_details = getUserDetails1($user_id);
						// foreach ($get_user_details as $key => $value) {
						// 	$parent_division_id = $value->parent_division_id;
						// 	$division_id = $value->division_id;
						// 	$division_acronym = $value->division_acronym;
						// 	$cluster_id = $value->cluster_id;
						// }
						// $sqlAB = getApprovedBudget($division_id, $year_selected);	
						// $sqlAbStatus = getApprovedBudgetStatus($division_id, $year_selected);	
						foreach($getApprovedBudget as $row){
							$division_acronym=$row->division_acronym;
							$fiscal_year1 = $row->fiscal_year1;
						}
						// foreach($sqlAB as $row){
						// 	$year=$row->year;
						// 	$fiscal_year1 = $row->fiscal_year1;
						// 	$fiscal_year2 = $row->fiscal_year2;
						// 	$fiscal_year3 = $row->fiscal_year3;
						// }					
					?> 	
					{{-- <div class="col-2 float-right"> 
						<a target="_blank" href="{{ route('monthly_cash_programs.generatePDF', ['division_id'=>$division_id, 'year'=>$year_selected]) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
					</div>													     --}}
				</div>
			</div>    

			<div class="card-body py-2">		
				<div class="row">
					<div class="col-4 float-left">
						{{-- <h5>FY {{ $fiscal_year1 }}</h5> --}}
						<span class='badge badge-success' style='font-size:15px'>{{ $status ?? ""}}</span>
					</div>
					<div class="col-4 text-center">
						<h2>FY {{ $fiscal_year1 }}</h2>
					</div>	
					<div class="col-4 py-2 float-right">
						{{-- @role('Division Director|Section Head')											
							<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year }}" 
								data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $status_id }}" data-toggle="modal" 									
								@if($status_id==17) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"								
								@elseif(($status_id==18) && ($dir_comment_count <> 0)) class="btn btn-primary float-right btn_forward_comment" 
									data-target="#forward_comment_modal"
								@elseif(($status_id==18) && ($dir_comment_count == 0)) class="btn btn-primary float-right btn_forward" 
									data-target="#forward_modal"							
								@else class="btn-xs d-none" @endif>
								@if($status_id==17) Receive Monthly Cash Program	
								@elseif(($status_id==18) && ($dir_comment_count <> 0)) Forward Comment/s to Division Budget Controller
								@elseif(($status_id==18) && ($dir_comment_count == 0)) Forward Monthly Cash Program to FAD-Budget									
								@endif								
							</button>
						@endrole		
						@role('Division Budget Controller')
							<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year }}" data-parent-division-id="{{ $parent_division_id }}"
								data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $status_id }}" data-toggle="modal"
								@if($status_id==16 || $status_id==20 || $status_id==22 || $status_id==32) class="btn btn-primary float-right btn_forward" data-target="#forward_modal"	
								@elseif($status_id==19 || $status_id==21 || $status_id==31) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"
								@else class="btn-xs d-none" @endif>
								@if($status_id==16 || $status_id==20 || $status_id==22 || $status_id==32) 		
									@if($parent_division_id==0) Forward Monthly Cash Program to Division Director	
									@else Forward Monthly Cash Program to Section Head
									@endif				
								@elseif($status_id==19) 
									@if($parent_division_id==0) Receive Comment/s from Division Director
									@else Receive Comment/s from Section Head
									@endif		
								@elseif($status_id==31) Receive Comment/s from BPAC Chair			
								@elseif($status_id==21) Receive Comment/s from FAD-Budget @endif								
							</button>
						@endrole		 --}}
					</div>	  
				</div>			
				<div class="row py-3">
					<div class="col-2"></div>
					<div class="col table-responsive">												
						<table id="monthly_cash_program_table" class="table-bordered table-hover" style="width: 70%;">
							<thead class="text-center">
								<th style="min-width:18%">Division</th> 
								<th style="min-width:50%">{{ $fiscal_year1 }} Approved Budget</th>									
								{{-- @role('Division Budget Controller')
									@if($status_id==55)
										<td class="text-center" style="min-width:60px">										
											<button type="button" class="btn-xs btn_add" data-division-id="{{ $division_id }}"
												data-year="{{ $year }}" data-toggle="modal" data-target="#cp_modal" data-toggle="tooltip" 
												data-placement='auto' title='Add New Cash Program Item'><i class="fa-solid fa-plus fa-lg blue"></i>
											</button>&nbsp;																			 
										</td>
									@endif
								@endrole --}}
							</thead>		
							<tbody><?php
								// if($division_id==5){
									$data = DB::table('view_approved_budget')->where('year', $year_selected)
										->where('is_active', 1)->where('is_deleted', 0)->get();	
								// }
								// else{
								// 	$data = DB::table('view_approved_budget')->where('year', $year_selected)
								// 		->where(function ($query) use ($division_id){
								// 			$query->where(function ($query) use ($division_id){
								// 					$query->where('division_id', $division_id)
								// 						->whereNull('pooled_at_division_id');
								// 				})
								// 				->orWhere(function ($query) use ($division_id){
								// 					$query->where('pooled_at_division_id',$division_id)
								// 						->where('division_id','!=', $division_id);
								// 				});
								// 		})
								// 		->where('is_active', 1)->where('is_deleted', 0)
								// 		->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
								// 		->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_specific','ASC')->groupBy('id')->get();	
								// } 
								foreach($getApprovedBudget as $row){?>
									<tr class="text-center">
										<td>{{ $row->division_acronym }}</td>
										<td class="text-right">{{ number_format($row->amount, 2) }}</td>
										<td style="width:2%;"><button type="button" class="btn-xs btn_edit" data-division-id="{{ $row->division_id }}"
											data-year="{{ $year }}" data-toggle="modal" data-target="#cp_modal" data-toggle="tooltip" 
											data-placement='auto' title='Edit approved budget'><i class="fa-solid fa-edit green fa-lg"></i>
										</button></td>
									</tr>
									<?php
								}
								?>								
								<tr>

								</tr>
							</tbody>
						</table>	 
					</div>    
				</div>					
			</div>
		</div>            
	</section>
	@include('programming_allocation.nep.monthly_cash_programs.modal')	
@endsection

@section('jscript')
   <script type="text/javascript">     
      $(document).ready(function(){   
         @include('programming_allocation.nep.monthly_cash_programs.script')   
         @include('scripts.common_script')   

			$('.select2bs4').select2({
				theme: 'bootstrap4'
			})     

			$(document).on('select2:open', () => {
				document.querySelector('.select2-search__field').focus();
			});   
      })  
		function changeYear()
		{
			year = $("#year_selected").val();
			window.location.replace("{{ url('programming_allocation/nep/monthly_cash_programs/division') }}/"+year);
		}	
   </script>  
@endsection

