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
						$cash_program_id = 0;
						$division_acronym = '';
						$status_id = 0;
						$fiscal_year1 = '';
						$fiscal_year2 = '';
						$fiscal_year3 = '';
						$get_user_details = getUserDetails1($user_id);
						foreach ($get_user_details as $key => $value) {
							$parent_division_id = $value->parent_division_id;
							$division_id = $value->division_id;
							$division_acronym = $value->division_acronym;
							$cluster_id = $value->cluster_id;
						}
						$sqlCP = getMonthlyCashProgram($division_id, $year);			
						$sqlCpCommentsbyDirector = getCpCommentsbyDirector($division_id, $year);
						$dir_comment_count = getCpCommentsbyDirectorCount($division_id, $year) ?? NULL;
						$sqlCpCommentsbyFADBudget = getBpCommentsbyFADBudget($division_id, $year);
						$budget_comment_count = getCpCommentsbyFADBudgetCount($division_id, $year);
						$sqlCpStatus = getCashProgramStatus($division_id, $year);
						foreach($sqlCpCommentsbyDirector as $row){
							$director_comments=$row->comment;
							$cash_program_id=$row->cash_program_id;
						}
						foreach($sqlCpCommentsbyFADBudget as $row){
							$fad_budget_comments=$row->comment;
							$cash_program_id=$row->cash_program_id;
						}
						foreach($sqlCpStatus as $row){	
							$division_acronym=$row->division_acronym;
							$status=$row->status;
							$status_id=$row->status_id;
							$status_by_user_role_id=$row->status_by_user_role_id;
						}
						foreach($sqlCP as $row){
							$fiscal_year1 = $row->fiscal_year1;
							$fiscal_year2 = $row->fiscal_year2;
							$fiscal_year3 = $row->fiscal_year3;
						}						
					?> 	
					<div class="col-2 float-right"> 
						<a target="_blank" href="{{ route('monthly_cash_programs.generatePDF', ['division_id'=>$division_id, 'year'=>$year_selected]) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
					</div>													    
				</div>
			</div>    

			<div class="card-body py-2">		
				<div class="row">
					<div class="col-4 float-left">
						<h5>FY {{ $fiscal_year1 }}</h5>
						<span class='badge badge-success' style='font-size:15px'>{{ $status ?? ""}}</span>
					</div>
					<div class="col-4 text-center">
						<h2>{{ $user_division_acronym }}</h2>
					</div>	
					<div class="col-4 py-2 float-right">
						@role('Division Director|Section Head')											
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
						@endrole		
					</div>	  
				</div>			
				<div class="row py-3">
					<div class="col table-responsive">						
						<table id="monthly_cash_program_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								<th>P/A/P / Object of Expenditures</th> 
								<th style="min-width:50px">Annual</th>
								<th style="min-width:50px">Jan</th>
								<th style="min-width:50px">Feb</th>
								<th style="min-width:50px">Mar</th>										
								<th style="min-width:50px">Apr</th>										
								<th style="min-width:50px">May</th>										
								<th style="min-width:50px">Jun</th>										
								<th style="min-width:50px">Jul</th>										
								<th style="min-width:50px">Aug</th>										
								<th style="min-width:50px">Sep</th>										
								<th style="min-width:50px">Oct</th>										
								<th style="min-width:50px">Nov</th>										
								<th style="min-width:50px">Dec</th>	
								@role('Division Budget Controller')
									@if($status_id==16 || $status_id==20)
										<td class="text-center" style="min-width:60px">										
											<button type="button" class="btn-xs btn_add" data-division-id="{{ $division_id }}"
												data-year="{{ $year }}" data-toggle="modal" data-target="#cp_modal" data-toggle="tooltip" 
												data-placement='auto' title='Add New Cash Program Item'><i class="fa-solid fa-plus fa-lg blue"></i>
											</button>&nbsp;																			 
										</td>
									@endif
								@endrole
							</thead>		
							<tbody><?php
								$data = DB::table('view_monthly_cash_programs')->where('year', $year_selected)
									->where(function ($query) use ($division_id){
										$query->where(function ($query) use ($division_id){
												$query->where('division_id', $division_id)
													->whereNull('pooled_at_division_id');
											})
											->orWhere(function ($query) use ($division_id){
												$query->where('pooled_at_division_id',$division_id)
													->where('division_id','!=', $division_id);
											});
									})
									->where('is_active', 1)->where('is_deleted', 0)
									->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
									->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_specific','ASC')->groupBy('id')->get();

								$data1 = DB::table('view_monthly_cash_programs')->where('year', $year_selected)->where('division_id',$division_id)
									->where(function ($query) use ($division_id){
										$query->whereNotNull('pooled_at_division_id')
											->where('pooled_at_division_id','!=',$division_id);
									})
									->where('is_active', 1)->where('is_deleted', 0)
									->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
									->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_specific','ASC')->groupBy('id')->get();

								foreach($data->groupBY('pap_id') as $key=>$row){			
									foreach($row as $item) {} //item?>
									<tr>
										<td class="font-weight-bold gray1-bg" colspan="14">{{ $item->pap }} - {{ $item->pap_code }}</td>										
									</tr><?php
									foreach($data->where('pap_id', $item->pap_id)->groupBY('activity_id') as $key1=>$row1){
										foreach($row1 as $item1) {} //item 1?>
										<tr>
											<td class="activity font-weight-bold" colspan="14">{{ $item1->activity }}</td>													
										</tr><?php 	
										foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
											->groupBY('subactivity_id') as $key2=>$row2){
											foreach($row2 as $item2) {} 
											if(isset($item2->subactivity)){//item 2?>
												<tr>
													<td class="subactivity font-weight-bold" colspan="14">{{ $item2->subactivity }}</td>													
												</tr><?php 
											}												
											foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
												->where('subactivity_id', $item2->subactivity_id)->groupBY('allotment_class_id') as $key3=>$row3){
												foreach($row3 as $item3) {}//item 3?>
												<tr>
													<td class="aclass font-weight-bold" colspan="14">{{ $item3->allotment_class }} ({{ $item3->allotment_class_acronym }})</td>													
												</tr><?php 													
												foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
													->where('subactivity_id', $item2->subactivity_id)
													->where('allotment_class_id', $item3->allotment_class_id)
													->groupBY('expense_account_id') as $key4=>$row4){															
													foreach($row4 as $item4) { }//item 4
														$jan_expense_total=$row4->sum('jan_amount');
														$feb_expense_total=$row4->sum('feb_amount');
														$mar_expense_total=$row4->sum('mar_amount');
														$apr_expense_total=$row4->sum('apr_amount');
														$may_expense_total=$row4->sum('may_amount');
														$jun_expense_total=$row4->sum('jun_amount');
														$jul_expense_total=$row4->sum('jul_amount');
														$aug_expense_total=$row4->sum('aug_amount');
														$sep_expense_total=$row4->sum('sep_amount');
														$oct_expense_total=$row4->sum('oct_amount');
														$nov_expense_total=$row4->sum('nov_amount');
														$dec_expense_total=$row4->sum('dec_amount');										
														$q1_expense_total=$jan_expense_total + $feb_expense_total + $mar_expense_total;										
														$q2_expense_total=$apr_expense_total + $may_expense_total + $jun_expense_total;										
														$q3_expense_total=$jul_expense_total + $aug_expense_total + $sep_expense_total;										
														$q4_expense_total=$oct_expense_total + $nov_expense_total + $dec_expense_total;										
														$annual_expense_total=$q1_expense_total + $q2_expense_total + $q3_expense_total + $q4_expense_total;?>	
													<tr class="text-right font-weight-bold gray-bg">
														<td class="expense">{{ $item4->expense_account }}</td>	
														<td>{{ number_format($annual_expense_total, 2) }}</td>											 
														<td>{{ number_format($jan_expense_total, 2) }}</td>
														<td>{{ number_format($feb_expense_total, 2) }}</td>
														<td>{{ number_format($mar_expense_total, 2) }}</td>														
														<td>{{ number_format($apr_expense_total, 2) }}</td>														
														<td>{{ number_format($may_expense_total, 2) }}</td>														
														<td>{{ number_format($jun_expense_total, 2) }}</td>														
														<td>{{ number_format($jul_expense_total, 2) }}</td>														
														<td>{{ number_format($aug_expense_total, 2) }}</td>														
														<td>{{ number_format($sep_expense_total, 2) }}</td>														
														<td>{{ number_format($oct_expense_total, 2) }}</td>														
														<td>{{ number_format($nov_expense_total, 2) }}</td>															
														<td>{{ number_format($dec_expense_total, 2) }}</td>															
													</tr><?php 		
													if($item4->object_specific_id == NULL || $item4->object_specific_id == 0 || $item4->object_specific_id == ''){
														foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
															->where('subactivity_id', $item2->subactivity_id)
															->where('allotment_class_id', $item3->allotment_class_id)
															->where('expense_account_id', $item4->expense_account_id)
															->groupBY('id') as $key5=>$row5){
																foreach($row5 as $item5) {}
																$jan_amount=$item5->jan_amount;
																$feb_amount=$item5->feb_amount;
																$mar_amount=$item5->mar_amount;
																$apr_amount=$item5->apr_amount;
																$may_amount=$item5->may_amount;
																$jun_amount=$item5->jun_amount;
																$jul_amount=$item5->jul_amount;
																$aug_amount=$item5->aug_amount;
																$sep_amount=$item5->sep_amount;
																$oct_amount=$item5->oct_amount;
																$nov_amount=$item5->nov_amount;
																$dec_amount=$item5->dec_amount;										
																$q1_amount=$jan_amount + $feb_amount + $mar_amount;										
																$q2_amount=$apr_amount + $may_amount + $jun_amount;										
																$q3_amount=$jul_amount + $aug_amount + $sep_amount;										
																$q4_amount=$oct_amount + $nov_amount + $dec_amount;										
																$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
																<tr class="text-right">
																	<td class="objexp">{{ $item5->object_expenditure }}
																		@if($item5->pooled_at_division_id != '') 
																			- Pooled at {{ $item5->pooled_at_division_acronym }} ({{ $item5->division_acronym }})@endif</td>
																	<td>{{ number_format($annual_amount, 2) }}</td>											 
																	<td>{{ number_format($jan_amount, 2) }}</td>
																	<td>{{ number_format($feb_amount, 2) }}</td>
																	<td>{{ number_format($mar_amount, 2) }}</td>														
																	<td>{{ number_format($apr_amount, 2) }}</td>														
																	<td>{{ number_format($may_amount, 2) }}</td>														
																	<td>{{ number_format($jun_amount, 2) }}</td>														
																	<td>{{ number_format($jul_amount, 2) }}</td>														
																	<td>{{ number_format($aug_amount, 2) }}</td>														
																	<td>{{ number_format($sep_amount, 2) }}</td>														
																	<td>{{ number_format($oct_amount, 2) }}</td>														
																	<td>{{ number_format($nov_amount, 2) }}</td>														
																	<td>{{ number_format($dec_amount, 2) }}</td>	
																	@role('Division Budget Controller')
																	@if($status_id==16 || $status_id==19 || $status_id==21 || $status_id==31)
																		<td class="text-center" style="width:140px">
																			<button type="button" data-id="{{ $item5->id }}" data-year="{{ $year }}"
																				data-division-id="{{ $division_id }}" data-active-status-id="{{ $status_id }}"																						
																				data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																				data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
																				title='View Comment'		
																				@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL 
																				&& $item5->comment_is_deleted==NULL)
																				|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																				@else class="btn-xs btn_comment" @endif><i class="fa-solid fa-eye"></i>																				
																			</button>									
																			<button type="button" class="btn-xs btn_edit" data-id="{{ $item5->id }}"
																				data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																				data-placement='auto' title='Edit'>
																				<i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
																			</button>
																			<button type="button" class="btn-xs btn_delete" data-id="{{ $item5->id }}" 
																				data-toggle="tooltip" data-placement='auto'title='Delete'>
																				<i class="fa-solid fa-trash-can fa-lg red"></i>
																			</button>																				 
																		</td>
																		@endif
																	@endrole
																	@role('Division Director|Section Head')																		
																		@if($status_id!=16 || $status_id!=17)
																		<td class="text-center">					
																			<button type="button" data-id="{{ $item5->id }}" data-division-id="{{ $division_id }}" 
																				data-parent-division-id="{{ $parent_division_id }}" data-year="{{ $year }}"
																				data-active-status-id="{{ $status_id }}" data-toggle="modal" 
																				data-target="#comment_modal" data-toggle="tooltip" data-placement='auto' 
																				@if($status_id==3) title='Add/Edit Comment' class="btn-xs btn_comment" 
																				@else title='View Comment'
																				@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL 
																					&& $item5->comment_is_deleted==NULL)
																					|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																				@else class="btn-xs btn_comment"@endif
																				@endif>
																				<i 
																				@if($status_id==3) class="fa-solid fa-pen-to-square fa-lg green"
																				@else class="fa-solid fa-eye"
																				@endif></i>																					
																			</button>																			
																		</td>
																		@endif
																	@endrole
																</tr><?php
														}	
													}
													elseif($item4->object_specific_id != NULL || $item4->object_specific_id != 0 || $item4->object_specific_id != ''){												
														foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
															->where('subactivity_id', $item2->subactivity_id)
															->where('allotment_class_id', $item3->allotment_class_id)
															->where('expense_account_id', $item4->expense_account_id)
															->groupBY('object_expenditure_id') as $key5=>$row5){
															foreach($row5 as $item5) {}//item 5?>
															<tr class="text-right">
																	<td class="objexp" colspan="14">{{ $item5->object_expenditure }}</td>										
															</tr><?php 
															if($item5->object_specific_id != NULL || $item5->object_specific_id != 0 || $item5->object_specific_id != ''){																	
																foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
																	->where('subactivity_id', $item2->subactivity_id)
																	->where('allotment_class_id', $item3->allotment_class_id)
																	->where('expense_account_id', $item4->expense_account_id)
																	->where('object_expenditure_id', $item5->object_expenditure_id)
																	->groupBy('id') as $key6=>$row6){
																	foreach($row6 as $item6) { }//item 6
																	$item6_id = $item6->id;
																	$jan_amount=$item6->jan_amount;
																	$feb_amount=$item6->feb_amount;
																	$mar_amount=$item6->mar_amount;
																	$apr_amount=$item6->apr_amount;
																	$may_amount=$item6->may_amount;
																	$jun_amount=$item6->jun_amount;
																	$jul_amount=$item6->jul_amount;
																	$aug_amount=$item6->aug_amount;
																	$sep_amount=$item6->sep_amount;
																	$oct_amount=$item6->oct_amount;
																	$nov_amount=$item6->nov_amount;
																	$dec_amount=$item6->dec_amount;										
																	$q1_amount=$jan_amount + $feb_amount + $mar_amount;										
																	$q2_amount=$apr_amount + $may_amount + $jun_amount;										
																	$q3_amount=$jul_amount + $aug_amount + $sep_amount;										
																	$q4_amount=$oct_amount + $nov_amount + $dec_amount;										
																	$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
																	<tr class="text-right">
																		<td class="objspe @if($item6->object_specific==NULL)  @else font-italic @endif">
																		@if($item6->object_specific==NULL) {{ $item6->object_expenditure }}
																		@else {{ $item6->object_specific }} 
																		@endif
																		@if($item6->pooled_at_division_id != '') 
																			- Pooled at {{ $item6->pooled_at_division_acronym }} ({{ $item6->division_acronym }})@endif</td>												
																		<td>{{ number_format($annual_amount, 2) }}</td>											 
																		<td>{{ number_format($jan_amount, 2) }}</td>
																		<td>{{ number_format($feb_amount, 2) }}</td>
																		<td>{{ number_format($mar_amount, 2) }}</td>														
																		<td>{{ number_format($apr_amount, 2) }}</td>														
																		<td>{{ number_format($may_amount, 2) }}</td>														
																		<td>{{ number_format($jun_amount, 2) }}</td>														
																		<td>{{ number_format($jul_amount, 2) }}</td>														
																		<td>{{ number_format($aug_amount, 2) }}</td>														
																		<td>{{ number_format($sep_amount, 2) }}</td>														
																		<td>{{ number_format($oct_amount, 2) }}</td>														
																		<td>{{ number_format($nov_amount, 2) }}</td>														
																		<td>{{ number_format($dec_amount, 2) }}</td>
																		@role('Division Budget Controller')
																			@if($status_id==16 || $status_id==19 || $status_id==21 || $status_id==31)
																				<td class="text-center" style="width:140px">
																					<button type="button" data-id="{{ $item6->id }}" data-year="{{ $year }}"
																						data-division-id="{{ $division_id }}" data-active-status-id="{{ $status_id }}"
																						data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal"																						 
																						data-target="#comment_modal" data-toggle="tooltip" 
																						data-placement='auto' title='View Comment'		
																						@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL 
																							&& $item6->comment_is_deleted==NULL)
																							|| ($item6->comment_by<>'' && $item6->comment_is_deleted==1)) class="d-none"
																						@else class="btn-xs btn_comment" @endif><i class="fa-solid fa-eye"></i>																				
																					</button>							
																					<button type="button" class="btn-xs btn_edit" data-id="{{ $item6->id }}" 
																						data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																						data-placement='auto' title='Edit'>
																						<i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
																					</button>																	
																					<button type="button" class="btn-xs btn_delete" data-id="{{ $item6->id }}" 
																						data-toggle="tooltip" data-placement='auto'title='Delete'>
																						<i class="fa-solid fa-trash-can fa-lg red"></i>
																					</button>																				 
																				</td>
																			@endif
																		@endrole
																		@role('Division Director|Section Head')
																			@if($status_id!=16 || $status_id!=17)
																				<td class="text-center">						
																					<button type="button" data-id="{{ $item6->id }}" data-year="{{ $year }}"
																						data-division-id="{{ $division_id }}" data-active-status-id="{{ $status_id }}"
																						data-parent-division-id="{{ $parent_division_id }}" data-placement='auto'
																						data-toggle="modal" data-target="#comment_modal" data-toggle="tooltip" 																						
																						@if($status_id==3) title='Add/Edit Comment' class="btn-xs btn_comment" 
																						@else title='View Comment'
																							@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL 
																								&& $item6->comment_is_deleted==NULL)
																								|| ($item6->comment_by <>'' && $item6->comment_is_deleted==1)) class="d-none"
																							@else class="btn-xs btn_comment"@endif
																						@endif>
																						<i
																						@if($status_id==3) class="fa-solid fa-pen-to-square fa-lg green"
																						@else class="fa-solid fa-eye"
																						@endif></i>																					
																					</button>
																				</td>
																			@endif
																		@endrole
																	</tr><?php 
																}
															}
														}
													}
												}
												if(isset($item2->subactivity)){
													$jan_subactivity_total=$row2->sum('jan_amount');
													$feb_subactivity_total=$row2->sum('feb_amount');
													$mar_subactivity_total=$row2->sum('mar_amount');
													$apr_subactivity_total=$row2->sum('apr_amount');
													$may_subactivity_total=$row2->sum('may_amount');
													$jun_subactivity_total=$row2->sum('jun_amount');
													$jul_subactivity_total=$row2->sum('jul_amount');
													$aug_subactivity_total=$row2->sum('aug_amount');
													$sep_subactivity_total=$row2->sum('sep_amount');
													$oct_subactivity_total=$row2->sum('oct_amount');
													$nov_subactivity_total=$row2->sum('nov_amount');
													$dec_subactivity_total=$row2->sum('dec_amount');										
													$q1_subactivity_total=$jan_subactivity_total + $feb_subactivity_total + $mar_subactivity_total;										
													$q2_subactivity_total=$apr_subactivity_total + $may_subactivity_total + $jun_subactivity_total;										
													$q3_subactivity_total=$jul_subactivity_total + $aug_subactivity_total + $sep_subactivity_total;										
													$q4_subactivity_total=$oct_subactivity_total + $nov_subactivity_total + $dec_subactivity_total;										
													$annual_subactivity_total=$q1_subactivity_total + $q2_subactivity_total + $q3_subactivity_total + $q4_subactivity_total;?>		
													<tr class="text-right font-weight-bold gray-bg">
														<td class="subactivity">Sub-Total Subactivity</td>
														<td>{{ number_format($annual_subactivity_total, 2) }}</td>											 
														<td>{{ number_format($jan_subactivity_total, 2) }}</td>
														<td>{{ number_format($feb_subactivity_total, 2) }}</td>
														<td>{{ number_format($mar_subactivity_total, 2) }}</td>														
														<td>{{ number_format($apr_subactivity_total, 2) }}</td>														
														<td>{{ number_format($may_subactivity_total, 2) }}</td>														
														<td>{{ number_format($jun_subactivity_total, 2) }}</td>														
														<td>{{ number_format($jul_subactivity_total, 2) }}</td>														
														<td>{{ number_format($aug_subactivity_total, 2) }}</td>														
														<td>{{ number_format($sep_subactivity_total, 2) }}</td>														
														<td>{{ number_format($oct_subactivity_total, 2) }}</td>														
														<td>{{ number_format($nov_subactivity_total, 2) }}</td>	
														<td>{{ number_format($dec_subactivity_total, 2) }}</td>	
													</tr><?php
												}
											}
										} 
										if(isset($item1->activity)){
											$jan_activity_total=$row1->sum('jan_amount');
											$feb_activity_total=$row1->sum('feb_amount');
											$mar_activity_total=$row1->sum('mar_amount');
											$apr_activity_total=$row1->sum('apr_amount');
											$may_activity_total=$row1->sum('may_amount');
											$jun_activity_total=$row1->sum('jun_amount');
											$jul_activity_total=$row1->sum('jul_amount');
											$aug_activity_total=$row1->sum('aug_amount');
											$sep_activity_total=$row1->sum('sep_amount');
											$oct_activity_total=$row1->sum('oct_amount');
											$nov_activity_total=$row1->sum('nov_amount');
											$dec_activity_total=$row1->sum('dec_amount');										
											$q1_activity_total=$jan_activity_total + $feb_activity_total + $mar_activity_total;										
											$q2_activity_total=$apr_activity_total + $may_activity_total + $jun_activity_total;										
											$q3_activity_total=$jul_activity_total + $aug_activity_total + $sep_activity_total;										
											$q4_activity_total=$oct_activity_total + $nov_activity_total + $dec_activity_total;										
											$annual_activity_total=$q1_activity_total + $q2_activity_total + $q3_activity_total + $q4_activity_total;?>
											<tr class="text-right font-weight-bold gray-bg">
												<td class="activity">Sub-Total Activity</td>
												<td>{{ number_format($annual_activity_total, 2) }}</td>											 
												<td>{{ number_format($jan_activity_total, 2) }}</td>
												<td>{{ number_format($feb_activity_total, 2) }}</td>
												<td>{{ number_format($mar_activity_total, 2) }}</td>														
												<td>{{ number_format($apr_activity_total, 2) }}</td>														
												<td>{{ number_format($may_activity_total, 2) }}</td>														
												<td>{{ number_format($jun_activity_total, 2) }}</td>														
												<td>{{ number_format($jul_activity_total, 2) }}</td>														
												<td>{{ number_format($aug_activity_total, 2) }}</td>														
												<td>{{ number_format($sep_activity_total, 2) }}</td>														
												<td>{{ number_format($oct_activity_total, 2) }}</td>														
												<td>{{ number_format($nov_activity_total, 2) }}</td>	
												<td>{{ number_format($dec_activity_total, 2) }}</td>	
											</tr><?php
										}
									}		
									if(isset($item->pap)){
										$jan_pap_total=$row->sum('jan_amount');
										$feb_pap_total=$row->sum('feb_amount');
										$mar_pap_total=$row->sum('mar_amount');
										$apr_pap_total=$row->sum('apr_amount');
										$may_pap_total=$row->sum('may_amount');
										$jun_pap_total=$row->sum('jun_amount');
										$jul_pap_total=$row->sum('jul_amount');
										$aug_pap_total=$row->sum('aug_amount');
										$sep_pap_total=$row->sum('sep_amount');
										$oct_pap_total=$row->sum('oct_amount');
										$nov_pap_total=$row->sum('nov_amount');
										$dec_pap_total=$row->sum('dec_amount');										
										$q1_pap_total=$jan_pap_total + $feb_pap_total + $mar_pap_total;										
										$q2_pap_total=$apr_pap_total + $may_pap_total + $jun_pap_total;										
										$q3_pap_total=$jul_pap_total + $aug_pap_total + $sep_pap_total;										
										$q4_pap_total=$oct_pap_total + $nov_pap_total + $dec_pap_total;										
										$annual_pap_total=$q1_pap_total + $q2_pap_total + $q3_pap_total + $q4_pap_total;?>
										<tr class="text-right font-weight-bold gray-bg">
											<td class="text-left">TOTAL PAP</td>
											<td>{{ number_format($annual_pap_total, 2) }}</td>											 
											<td>{{ number_format($jan_pap_total, 2) }}</td>
											<td>{{ number_format($feb_pap_total, 2) }}</td>
											<td>{{ number_format($mar_pap_total, 2) }}</td>														
											<td>{{ number_format($apr_pap_total, 2) }}</td>														
											<td>{{ number_format($may_pap_total, 2) }}</td>														
											<td>{{ number_format($jun_pap_total, 2) }}</td>														
											<td>{{ number_format($jul_pap_total, 2) }}</td>														
											<td>{{ number_format($aug_pap_total, 2) }}</td>														
											<td>{{ number_format($sep_pap_total, 2) }}</td>														
											<td>{{ number_format($oct_pap_total, 2) }}</td>														
											<td>{{ number_format($nov_pap_total, 2) }}</td>
											<td>{{ number_format($dec_pap_total, 2) }}</td>
										</tr><?php 
									}
								}
								foreach($data->groupBy('year') as $keyCPSum=>$rowCPSum){
									foreach($rowCPSum as $itemCPSum){}
										$jan_cp_total=$rowCPSum->sum('jan_amount');
										$feb_cp_total=$rowCPSum->sum('feb_amount');
										$mar_cp_total=$rowCPSum->sum('mar_amount');
										$apr_cp_total=$rowCPSum->sum('apr_amount');
										$may_cp_total=$rowCPSum->sum('may_amount');
										$jun_cp_total=$rowCPSum->sum('jun_amount');
										$jul_cp_total=$rowCPSum->sum('jul_amount');
										$aug_cp_total=$rowCPSum->sum('aug_amount');
										$sep_cp_total=$rowCPSum->sum('sep_amount');
										$oct_cp_total=$rowCPSum->sum('oct_amount');
										$nov_cp_total=$rowCPSum->sum('nov_amount');
										$dec_cp_total=$rowCPSum->sum('dec_amount');										
										$q1_cp_total=$jan_cp_total + $feb_cp_total + $mar_cp_total;										
										$q2_cp_total=$apr_cp_total + $may_cp_total + $jun_cp_total;										
										$q3_cp_total=$jul_cp_total + $aug_cp_total + $sep_cp_total;										
										$q4_cp_total=$oct_cp_total + $nov_cp_total + $dec_cp_total;										
										$annual_cp_total=$q1_cp_total + $q2_cp_total + $q3_cp_total + $q4_cp_total;?>		
									<tr class="text-right font-weight-bold gray-bg">
										<td class="text-left">GRAND TOTAL</td>
										<td>{{ number_format($annual_cp_total, 2) }}</td>											 
										<td>{{ number_format($jan_cp_total, 2) }}</td>
										<td>{{ number_format($feb_cp_total, 2) }}</td>
										<td>{{ number_format($mar_cp_total, 2) }}</td>														
										<td>{{ number_format($apr_cp_total, 2) }}</td>														
										<td>{{ number_format($may_cp_total, 2) }}</td>														
										<td>{{ number_format($jun_cp_total, 2) }}</td>														
										<td>{{ number_format($jul_cp_total, 2) }}</td>														
										<td>{{ number_format($aug_cp_total, 2) }}</td>														
										<td>{{ number_format($sep_cp_total, 2) }}</td>														
										<td>{{ number_format($oct_cp_total, 2) }}</td>														
										<td>{{ number_format($nov_cp_total, 2) }}</td>
										<td>{{ number_format($dec_cp_total, 2) }}</td>
									</tr><?php
								}?>
								<tr>
									<td colspan="14">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="14">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="14"><span class="wpooled">Note: Items with 'Pooled at' are not included 
										in the total computation of the budget proposal of your division.
									</span>
									</td>
								</tr>
								<?php 
								//With Pooled At
								foreach($data1->groupBY('pap_id') as $key=>$row){			
									foreach($row as $item) {} //item?>
									<tr>
										<td class="font-weight-bold gray1-bg" colspan="14">{{ $item->pap }} - {{ $item->pap_code }}</td>										
									</tr><?php
									foreach($data1->where('pap_id', $item->pap_id)->groupBY('activity_id') as $key1=>$row1){
										foreach($row1 as $item1) {} //item 1?>
										<tr>
											<td class="activity font-weight-bold" colspan="14">{{ $item1->activity }}</td>													
										</tr><?php 	
										foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
											->groupBY('subactivity_id') as $key2=>$row2){
											foreach($row2 as $item2) {} 
											if(isset($item2->subactivity)){//item 2?>
												<tr>
													<td class="subactivity font-weight-bold" colspan="14">{{ $item2->subactivity }}</td>													
												</tr><?php 
											}												
											foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
												->where('subactivity_id', $item2->subactivity_id)->groupBY('allotment_class_id') as $key3=>$row3){
												foreach($row3 as $item3) {}//item 3?>
												<tr>
													<td class="aclass font-weight-bold" colspan="14">{{ $item3->allotment_class }} ({{ $item3->allotment_class_acronym }})</td>													
												</tr><?php 													
												foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
													->where('subactivity_id', $item2->subactivity_id)
													->where('allotment_class_id', $item3->allotment_class_id)
													->groupBY('expense_account_id') as $key4=>$row4){															
													foreach($row4 as $item4) { }//item 4
														$jan_expense_total=$row4->sum('jan_amount');
														$feb_expense_total=$row4->sum('feb_amount');
														$mar_expense_total=$row4->sum('mar_amount');
														$apr_expense_total=$row4->sum('apr_amount');
														$may_expense_total=$row4->sum('may_amount');
														$jun_expense_total=$row4->sum('jun_amount');
														$jul_expense_total=$row4->sum('jul_amount');
														$aug_expense_total=$row4->sum('aug_amount');
														$sep_expense_total=$row4->sum('sep_amount');
														$oct_expense_total=$row4->sum('oct_amount');
														$nov_expense_total=$row4->sum('nov_amount');
														$dec_expense_total=$row4->sum('dec_amount');										
														$q1_expense_total=$jan_expense_total + $feb_expense_total + $mar_expense_total;										
														$q2_expense_total=$apr_expense_total + $may_expense_total + $jun_expense_total;										
														$q3_expense_total=$jul_expense_total + $aug_expense_total + $sep_expense_total;										
														$q4_expense_total=$oct_expense_total + $nov_expense_total + $dec_expense_total;										
														$annual_expense_total=$q1_expense_total + $q2_expense_total + $q3_expense_total + $q4_expense_total;?>	
													<tr class="text-right font-weight-bold gray-bg">
														<td class="expense">{{ $item4->expense_account }}</td>	
														<td>{{ number_format($annual_expense_total, 2) }}</td>											 
														<td>{{ number_format($jan_expense_total, 2) }}</td>
														<td>{{ number_format($feb_expense_total, 2) }}</td>
														<td>{{ number_format($mar_expense_total, 2) }}</td>														
														<td>{{ number_format($apr_expense_total, 2) }}</td>														
														<td>{{ number_format($may_expense_total, 2) }}</td>														
														<td>{{ number_format($jun_expense_total, 2) }}</td>														
														<td>{{ number_format($jul_expense_total, 2) }}</td>														
														<td>{{ number_format($aug_expense_total, 2) }}</td>														
														<td>{{ number_format($sep_expense_total, 2) }}</td>														
														<td>{{ number_format($oct_expense_total, 2) }}</td>														
														<td>{{ number_format($nov_expense_total, 2) }}</td>															
														<td>{{ number_format($dec_expense_total, 2) }}</td>															
													</tr><?php 		
													if($item4->object_specific_id == NULL || $item4->object_specific_id == 0 || $item4->object_specific_id == ''){
														foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
															->where('subactivity_id', $item2->subactivity_id)
															->where('allotment_class_id', $item3->allotment_class_id)
															->where('expense_account_id', $item4->expense_account_id)
															->groupBY('id') as $key5=>$row5){
																foreach($row5 as $item5) {}
																$jan_amount=$item5->jan_amount;
																$feb_amount=$item5->feb_amount;
																$mar_amount=$item5->mar_amount;
																$apr_amount=$item5->apr_amount;
																$may_amount=$item5->may_amount;
																$jun_amount=$item5->jun_amount;
																$jul_amount=$item5->jul_amount;
																$aug_amount=$item5->aug_amount;
																$sep_amount=$item5->sep_amount;
																$oct_amount=$item5->oct_amount;
																$nov_amount=$item5->nov_amount;
																$dec_amount=$item5->dec_amount;										
																$q1_amount=$jan_amount + $feb_amount + $mar_amount;										
																$q2_amount=$apr_amount + $may_amount + $jun_amount;										
																$q3_amount=$jul_amount + $aug_amount + $sep_amount;										
																$q4_amount=$oct_amount + $nov_amount + $dec_amount;										
																$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
																<tr class="text-right wpooled">
																	<td class="objexp">{{ $item5->object_expenditure }}
																		@if($item5->pooled_at_division_id != '') 
																			- Pooled at {{ $item5->pooled_at_division_acronym }} ({{ $item5->division_acronym }})@endif</td>
																	<td>{{ number_format($annual_amount, 2) }}</td>											 
																	<td>{{ number_format($jan_amount, 2) }}</td>
																	<td>{{ number_format($feb_amount, 2) }}</td>
																	<td>{{ number_format($mar_amount, 2) }}</td>														
																	<td>{{ number_format($apr_amount, 2) }}</td>														
																	<td>{{ number_format($may_amount, 2) }}</td>														
																	<td>{{ number_format($jun_amount, 2) }}</td>														
																	<td>{{ number_format($jul_amount, 2) }}</td>														
																	<td>{{ number_format($aug_amount, 2) }}</td>														
																	<td>{{ number_format($sep_amount, 2) }}</td>														
																	<td>{{ number_format($oct_amount, 2) }}</td>														
																	<td>{{ number_format($nov_amount, 2) }}</td>														
																	<td>{{ number_format($dec_amount, 2) }}</td>	
																	@role('Division Budget Controller')
																	@if($status_id==16 || $status_id==19 || $status_id==21 || $status_id==31)
																		<td class="text-center" style="width:140px">
																			<button type="button" data-id="{{ $item5->id }}" data-year="{{ $year }}"
																				data-division-id="{{ $division_id }}" data-active-status-id="{{ $status_id }}"																						
																				data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																				data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
																				title='View Comment'		
																				@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL 
																				&& $item5->comment_is_deleted==NULL)
																				|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																				@else class="btn-xs btn_comment" @endif><i class="fa-solid fa-eye"></i>																				
																			</button>									
																			<button type="button" class="btn-xs btn_edit" data-id="{{ $item5->id }}"
																				data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																				data-placement='auto' title='Edit'>
																				<i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
																			</button>
																			<button type="button" class="btn-xs btn_delete" data-id="{{ $item5->id }}" 
																				data-toggle="tooltip" data-placement='auto'title='Delete'>
																				<i class="fa-solid fa-trash-can fa-lg red"></i>
																			</button>																				 
																		</td>
																		@endif
																	@endrole
																	@role('Division Director|Section Head')																		
																		@if($status_id!=16 || $status_id!=17)
																		<td class="text-center">					
																			<button type="button" data-id="{{ $item5->id }}" data-division-id="{{ $division_id }}" 
																				data-parent-division-id="{{ $parent_division_id }}" data-year="{{ $year }}"
																				data-active-status-id="{{ $status_id }}" data-toggle="modal" 
																				data-target="#comment_modal" data-toggle="tooltip" data-placement='auto' 
																				@if($status_id==3) title='Add/Edit Comment' class="btn-xs btn_comment" 
																				@else title='View Comment'
																				@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL 
																					&& $item5->comment_is_deleted==NULL)
																					|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																				@else class="btn-xs btn_comment"@endif
																				@endif>
																				<i 
																				@if($status_id==3) class="fa-solid fa-pen-to-square fa-lg green"
																				@else class="fa-solid fa-eye"
																				@endif></i>																					
																			</button>																			
																		</td>
																		@endif
																	@endrole
																</tr><?php
														}	
													}
													elseif($item4->object_specific_id != NULL || $item4->object_specific_id != 0 || $item4->object_specific_id != ''){												
														foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
															->where('subactivity_id', $item2->subactivity_id)
															->where('allotment_class_id', $item3->allotment_class_id)
															->where('expense_account_id', $item4->expense_account_id)
															->groupBY('object_expenditure_id') as $key5=>$row5){
															foreach($row5 as $item5) {}//item 5?>
															<tr class="text-right">
																	<td class="objexp" colspan="14">{{ $item5->object_expenditure }}</td>										
															</tr><?php 
															if($item5->object_specific_id != NULL || $item5->object_specific_id != 0 || $item5->object_specific_id != ''){																	
																foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
																	->where('subactivity_id', $item2->subactivity_id)
																	->where('allotment_class_id', $item3->allotment_class_id)
																	->where('expense_account_id', $item4->expense_account_id)
																	->where('object_expenditure_id', $item5->object_expenditure_id)
																	->groupBy('id') as $key6=>$row6){
																	foreach($row6 as $item6) { }//item 6
																	$item6_id = $item6->id;
																	$jan_amount=$item6->jan_amount;
																	$feb_amount=$item6->feb_amount;
																	$mar_amount=$item6->mar_amount;
																	$apr_amount=$item6->apr_amount;
																	$may_amount=$item6->may_amount;
																	$jun_amount=$item6->jun_amount;
																	$jul_amount=$item6->jul_amount;
																	$aug_amount=$item6->aug_amount;
																	$sep_amount=$item6->sep_amount;
																	$oct_amount=$item6->oct_amount;
																	$nov_amount=$item6->nov_amount;
																	$dec_amount=$item6->dec_amount;										
																	$q1_amount=$jan_amount + $feb_amount + $mar_amount;										
																	$q2_amount=$apr_amount + $may_amount + $jun_amount;										
																	$q3_amount=$jul_amount + $aug_amount + $sep_amount;										
																	$q4_amount=$oct_amount + $nov_amount + $dec_amount;										
																	$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
																	<tr class="text-right wpooled">
																		<td class="objspe @if($item6->object_specific==NULL)  @else font-italic @endif">
																		@if($item6->object_specific==NULL) {{ $item6->object_expenditure }}
																		@else {{ $item6->object_specific }} 
																		@endif
																		@if($item6->pooled_at_division_id != '') 
																			- Pooled at {{ $item6->pooled_at_division_acronym }} ({{ $item6->division_acronym }})@endif</td>												
																		<td>{{ number_format($annual_amount, 2) }}</td>											 
																		<td>{{ number_format($jan_amount, 2) }}</td>
																		<td>{{ number_format($feb_amount, 2) }}</td>
																		<td>{{ number_format($mar_amount, 2) }}</td>														
																		<td>{{ number_format($apr_amount, 2) }}</td>														
																		<td>{{ number_format($may_amount, 2) }}</td>														
																		<td>{{ number_format($jun_amount, 2) }}</td>														
																		<td>{{ number_format($jul_amount, 2) }}</td>														
																		<td>{{ number_format($aug_amount, 2) }}</td>														
																		<td>{{ number_format($sep_amount, 2) }}</td>														
																		<td>{{ number_format($oct_amount, 2) }}</td>														
																		<td>{{ number_format($nov_amount, 2) }}</td>														
																		<td>{{ number_format($dec_amount, 2) }}</td>
																		@role('Division Budget Controller')
																			@if($status_id==16 || $status_id==19 || $status_id==21 || $status_id==31)
																				<td class="text-center" style="width:140px">
																					<button type="button" data-id="{{ $item6->id }}" data-year="{{ $year }}"
																						data-division-id="{{ $division_id }}" data-active-status-id="{{ $status_id }}"
																						data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal"																						 
																						data-target="#comment_modal" data-toggle="tooltip" 
																						data-placement='auto' title='View Comment'		
																						@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL 
																							&& $item6->comment_is_deleted==NULL)
																							|| ($item6->comment_by<>'' && $item6->comment_is_deleted==1)) class="d-none"
																						@else class="btn-xs btn_comment" @endif><i class="fa-solid fa-eye"></i>																				
																					</button>							
																					<button type="button" class="btn-xs btn_edit" data-id="{{ $item6->id }}" 
																						data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																						data-placement='auto' title='Edit'>
																						<i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
																					</button>																	
																					<button type="button" class="btn-xs btn_delete" data-id="{{ $item6->id }}" 
																						data-toggle="tooltip" data-placement='auto'title='Delete'>
																						<i class="fa-solid fa-trash-can fa-lg red"></i>
																					</button>																				 
																				</td>
																			@endif
																		@endrole
																		@role('Division Director|Section Head')
																			@if($status_id!=16 || $status_id!=17)
																				<td class="text-center">						
																					<button type="button" data-id="{{ $item6->id }}" data-year="{{ $year }}"
																						data-division-id="{{ $division_id }}" data-active-status-id="{{ $status_id }}"
																						data-parent-division-id="{{ $parent_division_id }}" data-placement='auto'
																						data-toggle="modal" data-target="#comment_modal" data-toggle="tooltip" 																						
																						@if($status_id==3) title='Add/Edit Comment' class="btn-xs btn_comment" 
																						@else title='View Comment'
																							@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL 
																								&& $item6->comment_is_deleted==NULL)
																								|| ($item6->comment_by <>'' && $item6->comment_is_deleted==1)) class="d-none"
																							@else class="btn-xs btn_comment"@endif
																						@endif>
																						<i
																						@if($status_id==3) class="fa-solid fa-pen-to-square fa-lg green"
																						@else class="fa-solid fa-eye"
																						@endif></i>																					
																					</button>
																				</td>
																			@endif
																		@endrole
																	</tr><?php 
																}
															}
														}
													}
												}
												if(isset($item2->subactivity)){
													$jan_subactivity_total=$row2->sum('jan_amount');
													$feb_subactivity_total=$row2->sum('feb_amount');
													$mar_subactivity_total=$row2->sum('mar_amount');
													$apr_subactivity_total=$row2->sum('apr_amount');
													$may_subactivity_total=$row2->sum('may_amount');
													$jun_subactivity_total=$row2->sum('jun_amount');
													$jul_subactivity_total=$row2->sum('jul_amount');
													$aug_subactivity_total=$row2->sum('aug_amount');
													$sep_subactivity_total=$row2->sum('sep_amount');
													$oct_subactivity_total=$row2->sum('oct_amount');
													$nov_subactivity_total=$row2->sum('nov_amount');
													$dec_subactivity_total=$row2->sum('dec_amount');										
													$q1_subactivity_total=$jan_subactivity_total + $feb_subactivity_total + $mar_subactivity_total;										
													$q2_subactivity_total=$apr_subactivity_total + $may_subactivity_total + $jun_subactivity_total;										
													$q3_subactivity_total=$jul_subactivity_total + $aug_subactivity_total + $sep_subactivity_total;										
													$q4_subactivity_total=$oct_subactivity_total + $nov_subactivity_total + $dec_subactivity_total;										
													$annual_subactivity_total=$q1_subactivity_total + $q2_subactivity_total + $q3_subactivity_total + $q4_subactivity_total;?>		
													<tr class="text-right font-weight-bold gray-bg">
														<td class="subactivity">Sub-Total Subactivity</td>
														<td>{{ number_format($annual_subactivity_total, 2) }}</td>											 
														<td>{{ number_format($jan_subactivity_total, 2) }}</td>
														<td>{{ number_format($feb_subactivity_total, 2) }}</td>
														<td>{{ number_format($mar_subactivity_total, 2) }}</td>														
														<td>{{ number_format($apr_subactivity_total, 2) }}</td>														
														<td>{{ number_format($may_subactivity_total, 2) }}</td>														
														<td>{{ number_format($jun_subactivity_total, 2) }}</td>														
														<td>{{ number_format($jul_subactivity_total, 2) }}</td>														
														<td>{{ number_format($aug_subactivity_total, 2) }}</td>														
														<td>{{ number_format($sep_subactivity_total, 2) }}</td>														
														<td>{{ number_format($oct_subactivity_total, 2) }}</td>														
														<td>{{ number_format($nov_subactivity_total, 2) }}</td>	
														<td>{{ number_format($dec_subactivity_total, 2) }}</td>	
													</tr><?php
												}
											}
										} 
										if(isset($item1->activity)){
											$jan_activity_total=$row1->sum('jan_amount');
											$feb_activity_total=$row1->sum('feb_amount');
											$mar_activity_total=$row1->sum('mar_amount');
											$apr_activity_total=$row1->sum('apr_amount');
											$may_activity_total=$row1->sum('may_amount');
											$jun_activity_total=$row1->sum('jun_amount');
											$jul_activity_total=$row1->sum('jul_amount');
											$aug_activity_total=$row1->sum('aug_amount');
											$sep_activity_total=$row1->sum('sep_amount');
											$oct_activity_total=$row1->sum('oct_amount');
											$nov_activity_total=$row1->sum('nov_amount');
											$dec_activity_total=$row1->sum('dec_amount');										
											$q1_activity_total=$jan_activity_total + $feb_activity_total + $mar_activity_total;										
											$q2_activity_total=$apr_activity_total + $may_activity_total + $jun_activity_total;										
											$q3_activity_total=$jul_activity_total + $aug_activity_total + $sep_activity_total;										
											$q4_activity_total=$oct_activity_total + $nov_activity_total + $dec_activity_total;										
											$annual_activity_total=$q1_activity_total + $q2_activity_total + $q3_activity_total + $q4_activity_total;?>
											<tr class="text-right font-weight-bold gray-bg">
												<td class="activity">Sub-Total Activity</td>
												<td>{{ number_format($annual_activity_total, 2) }}</td>											 
												<td>{{ number_format($jan_activity_total, 2) }}</td>
												<td>{{ number_format($feb_activity_total, 2) }}</td>
												<td>{{ number_format($mar_activity_total, 2) }}</td>														
												<td>{{ number_format($apr_activity_total, 2) }}</td>														
												<td>{{ number_format($may_activity_total, 2) }}</td>														
												<td>{{ number_format($jun_activity_total, 2) }}</td>														
												<td>{{ number_format($jul_activity_total, 2) }}</td>														
												<td>{{ number_format($aug_activity_total, 2) }}</td>														
												<td>{{ number_format($sep_activity_total, 2) }}</td>														
												<td>{{ number_format($oct_activity_total, 2) }}</td>														
												<td>{{ number_format($nov_activity_total, 2) }}</td>	
												<td>{{ number_format($dec_activity_total, 2) }}</td>	
											</tr><?php
										}
									}		
									if(isset($item->pap)){
										$jan_pap_total=$row->sum('jan_amount');
										$feb_pap_total=$row->sum('feb_amount');
										$mar_pap_total=$row->sum('mar_amount');
										$apr_pap_total=$row->sum('apr_amount');
										$may_pap_total=$row->sum('may_amount');
										$jun_pap_total=$row->sum('jun_amount');
										$jul_pap_total=$row->sum('jul_amount');
										$aug_pap_total=$row->sum('aug_amount');
										$sep_pap_total=$row->sum('sep_amount');
										$oct_pap_total=$row->sum('oct_amount');
										$nov_pap_total=$row->sum('nov_amount');
										$dec_pap_total=$row->sum('dec_amount');										
										$q1_pap_total=$jan_pap_total + $feb_pap_total + $mar_pap_total;										
										$q2_pap_total=$apr_pap_total + $may_pap_total + $jun_pap_total;										
										$q3_pap_total=$jul_pap_total + $aug_pap_total + $sep_pap_total;										
										$q4_pap_total=$oct_pap_total + $nov_pap_total + $dec_pap_total;										
										$annual_pap_total=$q1_pap_total + $q2_pap_total + $q3_pap_total + $q4_pap_total;?>
										<tr class="text-right font-weight-bold gray-bg">
											<td class="text-left">TOTAL PAP</td>
											<td>{{ number_format($annual_pap_total, 2) }}</td>											 
											<td>{{ number_format($jan_pap_total, 2) }}</td>
											<td>{{ number_format($feb_pap_total, 2) }}</td>
											<td>{{ number_format($mar_pap_total, 2) }}</td>														
											<td>{{ number_format($apr_pap_total, 2) }}</td>														
											<td>{{ number_format($may_pap_total, 2) }}</td>														
											<td>{{ number_format($jun_pap_total, 2) }}</td>														
											<td>{{ number_format($jul_pap_total, 2) }}</td>														
											<td>{{ number_format($aug_pap_total, 2) }}</td>														
											<td>{{ number_format($sep_pap_total, 2) }}</td>														
											<td>{{ number_format($oct_pap_total, 2) }}</td>														
											<td>{{ number_format($nov_pap_total, 2) }}</td>
											<td>{{ number_format($dec_pap_total, 2) }}</td>
										</tr><?php 
									}
								}
								foreach($data1->groupBy('year') as $keyCPSum=>$rowCPSum){
									foreach($rowCPSum as $itemCPSum){}
										$jan_cp_total=$rowCPSum->sum('jan_amount');
										$feb_cp_total=$rowCPSum->sum('feb_amount');
										$mar_cp_total=$rowCPSum->sum('mar_amount');
										$apr_cp_total=$rowCPSum->sum('apr_amount');
										$may_cp_total=$rowCPSum->sum('may_amount');
										$jun_cp_total=$rowCPSum->sum('jun_amount');
										$jul_cp_total=$rowCPSum->sum('jul_amount');
										$aug_cp_total=$rowCPSum->sum('aug_amount');
										$sep_cp_total=$rowCPSum->sum('sep_amount');
										$oct_cp_total=$rowCPSum->sum('oct_amount');
										$nov_cp_total=$rowCPSum->sum('nov_amount');
										$dec_cp_total=$rowCPSum->sum('dec_amount');										
										$q1_cp_total=$jan_cp_total + $feb_cp_total + $mar_cp_total;										
										$q2_cp_total=$apr_cp_total + $may_cp_total + $jun_cp_total;										
										$q3_cp_total=$jul_cp_total + $aug_cp_total + $sep_cp_total;										
										$q4_cp_total=$oct_cp_total + $nov_cp_total + $dec_cp_total;										
										$annual_cp_total=$q1_cp_total + $q2_cp_total + $q3_cp_total + $q4_cp_total;?>		
									<tr class="text-right font-weight-bold gray-bg">
										<td class="text-left">GRAND TOTAL</td>
										<td>{{ number_format($annual_cp_total, 2) }}</td>											 
										<td>{{ number_format($jan_cp_total, 2) }}</td>
										<td>{{ number_format($feb_cp_total, 2) }}</td>
										<td>{{ number_format($mar_cp_total, 2) }}</td>														
										<td>{{ number_format($apr_cp_total, 2) }}</td>														
										<td>{{ number_format($may_cp_total, 2) }}</td>														
										<td>{{ number_format($jun_cp_total, 2) }}</td>														
										<td>{{ number_format($jul_cp_total, 2) }}</td>														
										<td>{{ number_format($aug_cp_total, 2) }}</td>														
										<td>{{ number_format($sep_cp_total, 2) }}</td>														
										<td>{{ number_format($oct_cp_total, 2) }}</td>														
										<td>{{ number_format($nov_cp_total, 2) }}</td>
										<td>{{ number_format($dec_cp_total, 2) }}</td>
									</tr><?php
								}?>
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

