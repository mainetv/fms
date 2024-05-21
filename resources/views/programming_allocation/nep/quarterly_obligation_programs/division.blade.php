@extends('layouts.app')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">Quarterly Obligations Program</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Programming & Allocation</li>
						<li class="breadcrumb-item active">NEP</li>
						<li class="breadcrumb-item active">Quarterly Obligation Program</li>
				</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	@php
		$getUserDetails = getUserDetails($user_id);						
		foreach ($getUserDetails as $key => $value) {
			$user_id = $value->id;
			$emp_code = $value->emp_code;
			$parent_division_id = $value->parent_division_id;
			$division_id = $value->division_id;
			$division_acronym = $value->division_acronym;
			$cluster_id = $value->cluster_id;
			$user_role_id = $value->user_role_id;
		}
		$getYears=getYears();
		$getLibraryPAP=getLibraryPAP();
		$getLibraryActivities=getLibraryActivities($division_id);
		$getLibraryExpenseAccounts=getLibraryExpenseAccounts();
		$getLibraryObjectExpenditures=getLibraryObjectExpenditures();					
		$qop_id = 0;
		$active_status_id = 0;
		$fiscal_year1 = '';
		$fiscal_year2 = '';
		$fiscal_year3 = '';						
		if($user_id=='20' || $user_id=='14'){
			$division_id = '9';
			$division_acronym = 'FAD-DO';
		}
		if($user_id=='3'){
			$division_id = '22';
			$division_acronym = 'OED';
			$parent_division_id = '0';
		}
		if($user_id=='111'){
			$division_id = '3';
			$division_acronym = 'COA';
		}
	@endphp
	<section class="content">  
		<div class="card refreshDiv">			
			<div class="card-header">
				<div class="row">
					<div class="col-10 float-left">
						@csrf              
						<h3 class="card-title">
							<i class="fas fa-edit"></i>
							<label for="year_selected">Year: </label>    
							<select name="year_selected" id="year_selected" onchange="changeYear()">               
								@foreach ($getYears as $row)
									<option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
								@endforeach    
							</select>                                              
						</h3>
					</div>  
					@php
						$sqlQOP = getQuarterlyObligationProgram($division_id, $year_selected);			
						$sqlQopCommentsbyDirector = getQopCommentsbyDirector($division_id, $year_selected);
						$dir_comment_count = getQopCommentsbyDirectorCount($division_id, $year_selected) ?? NULL;
						$sqlQopCommentsbyFADBudget = getBpCommentsbyFADBudget($division_id, $year_selected);
						$budget_comment_count = getQopCommentsbyFADBudgetCount($division_id, $year_selected);
						$sqlQopStatus = getQuarterlyObligationProgramStatus($division_id, $year_selected);
						foreach($sqlQopCommentsbyDirector as $row){
							$director_comments=$row->comment;
							$qop_id=$row->qop_id;
						}
						foreach($sqlQopCommentsbyFADBudget as $row){
							$fad_budget_comments=$row->comment;
							$qop_id=$row->qop_id;
						}
						foreach($sqlQopStatus as $row){	
							$division_acronym=$row->division_acronym;
							$status=$row->status;
							$active_status_id=$row->status_id;
							$status_by_user_role_id=$row->status_by_user_role_id;
						}
						foreach($sqlQOP as $row){
							$fiscal_year1 = $row->fiscal_year1;
							$fiscal_year2 = $row->fiscal_year2;
							$fiscal_year3 = $row->fiscal_year3;
						}							
					@endphp				
					<div class="col-2 float-right"> 
						<a target="_blank" href="{{ route('quarterly_obligation_program.generatePDF', ['division_id'=>$division_id, 'year'=>$year_selected]) }}" >
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
						<h2>{{ $division_acronym }}</h2>
					</div>	
					<div class="col-4 py-2 float-right">						
						@hasanyrole('Division Budget Controller')
							<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year_selected }}" data-parent-division-id="{{ $parent_division_id }}"
								data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $active_status_id }}" data-toggle="modal"
								@if($active_status_id==18 || $active_status_id==5 || $active_status_id==9 || $active_status_id==13) class="btn btn-primary float-right btn_forward" data-target="#forward_modal"	
								@elseif($active_status_id==4 || $active_status_id==8 || $active_status_id==12) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"
								@else class="btn-xs d-none" @endif>
								@if($active_status_id==18 || $active_status_id==5 || $active_status_id==9 || $active_status_id==13) 		
									@if($parent_division_id==0) Forward Quarterly Obligation Program to Division Director	
@elseif($division_id==3) Forward Quarterly Obligation Program to FAD-Budget									@else Forward Quarterly Obligation Program to Section Head
									@endif				
								@elseif($active_status_id==4) 
									@if($parent_division_id==0) Receive Comment/s from Division Director
									@else Receive Comment/s from Section Head
									@endif		
								@elseif($active_status_id==8) Receive Comment/s from FAD-Budget			
								@elseif($active_status_id==12) Receive Comment/s from BPAC Chair @endif								
							</button>
						@endhasanyrole	
						@hasanyrole('Division Director|Section Head')											
							<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year_selected }}" 
								data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $active_status_id }}" data-toggle="modal" 									
								@if($active_status_id==2) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"								
								@elseif(($active_status_id==3) && ($dir_comment_count <> 0)) class="btn btn-primary float-right btn_forward_comment" 
									data-target="#forward_comment_modal"
								@elseif(($active_status_id==3) && ($dir_comment_count == 0)) class="btn btn-primary float-right btn_forward" 
									data-target="#forward_modal"							
								@else class="btn-xs d-none" @endif>
								@if($active_status_id==2) Receive Quarterly Obligation Program	
								@elseif(($active_status_id==3) && ($dir_comment_count <> 0)) Forward Comment/s to Division Budget Controller
								@elseif(($active_status_id==3) && ($dir_comment_count == 0)) Forward Quarterly Obligation Program to FAD-Budget									
								@endif								
							</button>
						@endhasanyrole	
					</div>	  
				</div>
				<div class="row py-3">
					<div class="col table-responsive">						
						<table id="quarterly_obligation_program_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								<th>P/A/P, Division, Item of Expenditures</th> 
								<th style="min-width:50px">Annual Program</th>
								<th style="min-width:50px">Q1</th>
								<th style="min-width:50px">Q2</th>
								<th style="min-width:50px">Q3</th>										
								<th style="min-width:50px">Q4</th>		
								@role('Division Budget Controller')
									@if($active_status_id==18 || $active_status_id==5 || $active_status_id==9 || $active_status_id==13)
										<td class="text-center" style="min-width:70px">										
											<button type="button" class="btn-xs btn_add" data-division-id="{{ $division_id }}"
												data-year="{{ $year_selected }}" data-toggle="modal" data-target="#qop_modal" data-toggle="tooltip" 
												data-placement='auto' title='Add New Quarterly Obligation Program Item'>
												<i class="fa-solid fa-plus fa-lg blue"></i>
											</button>&nbsp;																			 
										</td>
									@endif
								@endrole
							</thead>		
							<tbody><?php
								$data = DB::table('view_quarterly_obligation_programs')->where('year', $year_selected)
									->where('division_id', $division_id)
									->where('is_active', 1)->where('is_deleted', 0)
									->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
									->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
									->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
									->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
									->groupBy('id')->get();

								foreach($data->groupBY('allotment_class_id') as $key=>$row){			
									foreach($row as $item) {} //item?>
									<tr>
										<td class="font-weight-bold" colspan="6">{{ $item->allotment_class }} ({{ $item->allotment_class_acronym }})</td>													
									</tr><?php
									foreach($data->where('allotment_class_id', $item->allotment_class_id)->groupBY('pap_code') as $key1=>$row1){
										foreach($row1 as $item1) {} //item 1?>
										<tr>
											<td class="pap font-weight-bold gray1-bg" colspan="6">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
										</tr><?php 		
										foreach($data->where('allotment_class_id', $item->allotment_class_id)
											->where('pap_id', $item1->pap_id)
											->groupBY('activity_id') as $key2=>$row2){
											foreach($row2 as $item2) {} //item 2?>
											<tr>
												<td class="activity1 font-weight-bold" colspan="6">{{ $item2->activity }}</td>													
											</tr><?php 										
											foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
												->where('activity_id', $item2->activity_id)
												->groupBY('subactivity_id') as $key3=>$row3){
												foreach($row3 as $item3) {} 
												if(isset($item3->subactivity)){//item 3?>
													<tr>
														<td class="subactivity1 font-weight-bold" colspan="6">{{ $item3->subactivity }}</td>													
													</tr><?php 
												}	
												foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
													->where('activity_id', $item2->activity_id)
													->where('subactivity_id', $item3->subactivity_id)
													->groupBY('expense_account_id') as $key4=>$row4){
													foreach($row4 as $item4) {}//item 4?>
													<tr>
														<td class="expense1 font-weight-bold" colspan="6">{{ $item4->expense_account }}</td>														
													</tr>
													<?php
													foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
														->where('activity_id', $item2->activity_id)
														->where('subactivity_id', $item3->subactivity_id)
														->where('expense_account_id', $item4->expense_account_id)
														->whereNull('object_specific_id')
														->groupBY('id') as $key5=>$row5){
														foreach($row5 as $item5) {}//item 4
														$q1_amount=$item5->q1_amount;
														$q2_amount=$item5->q2_amount;
														$q3_amount=$item5->q3_amount;
														$q4_amount=$item5->q4_amount;																								
														$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
														<tr class="text-right">
															<td class="objexp1">{{ $item5->object_expenditure }}</td>
															<td>{{ number_format($annual_amount, 2) }}</td>											 
															<td>{{ number_format($q1_amount, 2) }}</td>		
															<td>{{ number_format($q2_amount, 2) }}</td>		
															<td>{{ number_format($q3_amount, 2) }}</td>		
															<td>{{ number_format($q4_amount, 2) }}</td>
															@role('Division Budget Controller')
																	<td class="text-center">																		
																		<button type="button" data-id="{{ $item5->id }}" data-year="{{ $year_selected }}"
																			data-division-id="{{ $division_id }}" data-active-status-id="{{ $active_status_id }}"																						
																			data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																			data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
																			title='View Comment'		
																			@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL 
																			&& $item5->comment_is_deleted==NULL)
																			|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																			@else class="btn-xs btn_comment" @endif>
																			<i class="fa-solid fa-eye"></i>																				
																		</button>																			
																		@if($active_status_id==18 || $active_status_id==5 || $active_status_id==9 || $active_status_id==13)					
																			<button type="button" class="btn-xs btn_edit" data-id="{{ $item5->id }}"
																				data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																				data-placement='auto' title='Edit'>
																				<i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
																			</button>
																			<button type="button" class="btn-xs btn_delete" data-id="{{ $item5->id }}" 
																				data-toggle="tooltip" data-placement='auto'title='Delete'>
																				<i class="fa-solid fa-trash-can fa-lg red"></i>
																			</button>
																		@endif																					 
																	</td>
															@endrole
															@role('Division Director|Section Head')																		
																@if($active_status_id!=18)
																	<td class="text-center">					
																		<button type="button" data-id="{{ $item5->id }}" data-division-id="{{ $division_id }}" 
																			data-parent-division-id="{{ $parent_division_id }}" data-year="{{ $year_selected }}"
																			data-active-status-id="{{ $active_status_id }}" data-user-role-id={{ $user_role_id }} data-toggle="modal" 
																			data-target="#comment_modal" data-toggle="tooltip" data-placement='auto' 
																			@if($active_status_id==3) title='Add/Edit Comment' class="btn-xs btn_comment" 
																			@else title='View Comment'
																			@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL 
																				&& $item5->comment_is_deleted==NULL)
																				|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																			@else class="btn-xs btn_comment"@endif
																			@endif>
																			<i 
																			@if($active_status_id==3) class="fa-solid fa-comment fa-lg green"
																			@else class="fa-solid fa-comment"
																			@endif></i>																					
																		</button>																			
																	</td>
																@endif
															@endrole												
														</tr><?php
													}
													foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
														->where('activity_id', $item2->activity_id)
														->where('subactivity_id', $item3->subactivity_id)
														->where('expense_account_id', $item4->expense_account_id)
														->whereNotNull('object_specific_id')
														->groupBY('object_expenditure_id') as $key5=>$row5){
														foreach($row5 as $item5) {}//item 4
														$q1_amount=$item5->q1_amount;
														$q2_amount=$item5->q2_amount;
														$q3_amount=$item5->q3_amount;
														$q4_amount=$item5->q4_amount;																								
														$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;
														if($item5->object_specific_id != NULL){?>
															<tr>
																<td class="objexp1" colspan="6">{{ $item5->object_expenditure }}</td>														
															</tr><?php
															foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
																->where('activity_id', $item2->activity_id)
																->where('subactivity_id', $item3->subactivity_id)
																->where('expense_account_id', $item4->expense_account_id)
																->where('object_expenditure_id', $item5->object_expenditure_id)
																->whereNotNull('object_specific_id')
																->groupBY('id') as $key6=>$row6){
																foreach($row6 as $item6) {}//item 4
																$q1_amount=$item6->q1_amount;
																$q2_amount=$item6->q2_amount;
																$q3_amount=$item6->q3_amount;
																$q4_amount=$item6->q4_amount;																								
																$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
																<tr class="text-right">
																	<td class="objspe1 font-italic">{{ $item6->object_specific }}</td>		
																	<td>{{ number_format($annual_amount, 2) }}</td>											 
																	<td>{{ number_format($q1_amount, 2) }}</td>		
																	<td>{{ number_format($q2_amount, 2) }}</td>		
																	<td>{{ number_format($q3_amount, 2) }}</td>		
																	<td>{{ number_format($q4_amount, 2) }}</td>				
																	@role('Division Budget Controller')
																		<td class="text-center">																			
																			<button type="button" data-id="{{ $item6->id }}" data-year="{{ $year_selected }}"
																				data-division-id="{{ $division_id }}" data-active-status-id="{{ $active_status_id }}"
																				data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal"																						 
																				data-target="#comment_modal" data-toggle="tooltip" 
																				data-placement='auto' title='View Comment'		
																				@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL 
																					&& $item6->comment_is_deleted==NULL)
																					|| ($item6->comment_by<>'' && $item6->comment_is_deleted==1)) class="d-none"
																				@else class="btn-xs btn_comment" @endif><i class="fa-solid fa-eye"></i>																				
																			</button>	
																			@if($active_status_id==18 || $active_status_id==5 || $active_status_id==9 || $active_status_id==13)						
																				<button type="button" class="btn-xs btn_edit" data-id="{{ $item6->id }}" 
																					data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																					data-placement='auto' title='Edit'>
																					<i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
																				</button>																	
																				<button type="button" class="btn-xs btn_delete" data-id="{{ $item6->id }}" 
																					data-toggle="tooltip" data-placement='auto'title='Delete'>
																					<i class="fa-solid fa-trash-can fa-lg red"></i>
																				</button>	
																			@endif																			 
																		</td>																		
																	@endrole
																	@role('Division Director|Section Head')
																		@if($active_status_id!=18)
																			<td class="text-center">						
																				<button type="button" data-id="{{ $item6->id }}" data-year="{{ $year_selected }}"
																					data-division-id="{{ $division_id }}" data-user-role-id={{ $user_role_id }}
																					data-active-status-id="{{ $active_status_id }}"
																					data-parent-division-id="{{ $parent_division_id }}" data-placement='auto'
																					data-toggle="modal" data-target="#comment_modal" data-toggle="tooltip" 																						
																					@if($active_status_id==3) title='Add/Edit Comment' class="btn-xs btn_comment" 
																					@else title='View Comment'
																						@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL 
																							&& $item6->comment_is_deleted==NULL)
																							|| ($item6->comment_by <>'' && $item6->comment_is_deleted==1)) class="d-none"
																						@else class="btn-xs btn_comment"@endif
																					@endif>
																					<i
																					@if($active_status_id==3) class="fa-solid fa-comment fa-lg green"
																					@else class="fa-solid fa-comment"
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
												if(isset($item3->subactivity)){
													$q1_subactivity_total=$row3->sum('q1_amount');									
													$q2_subactivity_total=$row3->sum('q2_amount');									
													$q3_subactivity_total=$row3->sum('q3_amount');									
													$q4_subactivity_total=$row3->sum('q4_amount');									
													$annual_subactivity_total=$q1_subactivity_total + $q2_subactivity_total + $q3_subactivity_total + $q4_subactivity_total;?>		
													<tr class="text-right font-weight-bold gray-bg">
														<td>Total Subactivity, {{ $item3->subactivity }}</td>
														<td>&nbsp;&nbsp;{{ number_format($annual_subactivity_total, 2) }}</td>											 
														<td>&nbsp;&nbsp;{{ number_format($q1_subactivity_total, 2) }}</td>
														<td>&nbsp;&nbsp;{{ number_format($q2_subactivity_total, 2) }}</td>
														<td>&nbsp;&nbsp;{{ number_format($q3_subactivity_total, 2) }}</td>
														<td>&nbsp;&nbsp;{{ number_format($q4_subactivity_total, 2) }}</td>
													</tr><?php
												}
											}
																		
											if(isset($item2->activity)){
												$q1_activity_total=$row2->sum('q1_amount');										
												$q2_activity_total=$row2->sum('q2_amount');										
												$q3_activity_total=$row2->sum('q3_amount');										
												$q4_activity_total=$row2->sum('q4_amount');		
												$annual_activity_total=$q1_activity_total + $q2_activity_total + $q3_activity_total + $q4_activity_total;?>
												<tr class="text-right font-weight-bold gray-bg">
													<td>Total Activity, {{ $item2->activity }}</td>
													<td>&nbsp;&nbsp;{{ number_format($annual_activity_total, 2) }}</td>											 
													<td>&nbsp;&nbsp;{{ number_format($q1_activity_total, 2) }}</td>
													<td>&nbsp;&nbsp;{{ number_format($q2_activity_total, 2) }}</td>
													<td>&nbsp;&nbsp;{{ number_format($q3_activity_total, 2) }}</td>
													<td>&nbsp;&nbsp;{{ number_format($q4_activity_total, 2) }}</td>
												</tr><?php
											}
										}									
										if(isset($item1->pap)){
											$q1_pap_total=$row1->sum('q1_amount');																		
											$q2_pap_total=$row1->sum('q2_amount');																		
											$q3_pap_total=$row1->sum('q3_amount');																		
											$q4_pap_total=$row1->sum('q4_amount');																		
											$annual_pap_total=$q1_pap_total + $q2_pap_total + $q3_pap_total + $q4_pap_total;?>
											<tr class="text-right font-weight-bold gray-bg">
												<td>Total PAP, {{ $item1->pap }}</td>
												<td>&nbsp;&nbsp;{{ number_format($annual_pap_total, 2) }}</td>											 
												<td>&nbsp;&nbsp;{{ number_format($q1_pap_total, 2) }}</td>
												<td>&nbsp;&nbsp;{{ number_format($q2_pap_total, 2) }}</td>
												<td>&nbsp;&nbsp;{{ number_format($q3_pap_total, 2) }}</td>
												<td>&nbsp;&nbsp;{{ number_format($q4_pap_total, 2) }}</td>
											</tr><?php 
										}
									}
								}
								foreach($data->groupBy('year') as $keyCPSum=>$rowQOPSum){
									foreach($rowQOPSum as $itemQOPSum){}
									$q1_qop_total=$rowQOPSum->sum('q1_amount');															
									$q2_qop_total=$rowQOPSum->sum('q2_amount');															
									$q3_qop_total=$rowQOPSum->sum('q3_amount');															
									$q4_qop_total=$rowQOPSum->sum('q4_amount');															
									$annual_qop_total=$q1_qop_total + $q2_qop_total + $q3_qop_total + $q4_qop_total;?>		
									<tr class="text-right font-weight-bold gray-bg">
										<td>GRAND TOTAL</td>
										<td>&nbsp;&nbsp;{{ number_format($annual_qop_total, 2) }}</td>											 
										<td>&nbsp;&nbsp;{{ number_format($q1_qop_total, 2) }}</td>
										<td>&nbsp;&nbsp;{{ number_format($q2_qop_total, 2) }}</td>
										<td>&nbsp;&nbsp;{{ number_format($q3_qop_total, 2) }}</td>
										<td>&nbsp;&nbsp;{{ number_format($q4_qop_total, 2) }}</td>
									</tr><?php
								}?>							
							</tbody>
						</table>	 
					</div>    
				</div>					
			</div>
		</div>            
	</section>
	@include('programming_allocation.nep.quarterly_obligation_programs.modal')	
@endsection

@section('jscript')
   <script type="text/javascript">     
      $(document).ready(function(){   
         @include('programming_allocation.nep.quarterly_obligation_programs.script')   
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
			window.location.replace("{{ url('programming_allocation/nep/quarterly_obligation_program/division') }}/"+year);
		}	
   </script>  
@endsection

