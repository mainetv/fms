<h4>{{ $value->division_acronym }}</h4>
@php
	$division_id=$value->id;
	$division_acronym=$value->division_acronym;	
	$parent_division_id=$value->parent_id;	
	$cash_program_id = 0;
	$active_status_id = 0;
	$fiscal_year1 = '';
	$fiscal_year2 = '';
	$fiscal_year3 = '';	
	$getUserDetails = getUserDetails($user_id);						
	foreach ($getUserDetails as $key => $value) {
		$emp_code = $value->emp_code;
		$user_parent_division_id = $value->parent_division_id;
		$user_division_id = $value->division_id;
		$user_division_acronym = $value->division_acronym;
		$user_cluster_id = $value->cluster_id;
		$user_role_id = $value->user_role_id;
	}
	$getYears=getYears();
	$getYearsV=getYearsV($year_selected);
	$getLibraryPAP=getLibraryPAP();
	$getLibraryActivities=getLibraryActivities($division_id);
	$getLibraryExpenseAccounts=getLibraryExpenseAccounts();
	$getLibraryObjectExpenditures=getLibraryObjectExpenditures();		
	$sqlQOP = getQuarterlyObligationProgram($division_id, $year_selected);
	$sqlQopCommentsbyDirector = getQopCommentsbyDirector($division_id, $year_selected);
	$sqlQopCommentsbyFADBudget = getQopCommentsbyFADBudget($division_id, $year_selected);
	$sqlQopCommentsbyBPAC = getQopCommentsbyBPAC($division_id, $year_selected);
	$director_comment_count = getQopCommentsbyDirectorCount($division_id, $year_selected);	
	$budget_comment_count = getQopCommentsbyFADBudgetCount($division_id, $year_selected);
	$bpac_comment_count = getQopCommentsbyBPACCount($division_id, $year_selected);
	$sqlQopStatus = getQuarterlyObligationProgramStatus($division_id, $year_selected);
	foreach($sqlQopCommentsbyDirector as $row){
		$director_comments=$row->comment;
		$qop_id=$row->qop_id;
	}
	foreach($sqlQopCommentsbyFADBudget as $row){
		$fad_budget_comments=$row->comment;
		$qop_id=$row->qop_id;
	}
	foreach($sqlQopCommentsbyBPAC as $row){
		$bpac_comments=$row->comment;
		$qop_id=$row->qop_id;
	}
	foreach($sqlQopStatus as $row){
		$division_acronym=$row->division_acronym;
		$status=$row->status;
		$active_status_id=$row->status_id;
	}
	foreach($sqlQOP as $row){
		$year=$row->year;
		$fiscal_year1 = $row->fiscal_year1;
		$fiscal_year2 = $row->fiscal_year2;
		$fiscal_year3 = $row->fiscal_year3;
	}	
@endphp
<div class="content">
  <div class="row">
		<div class="col-7">
			@if($division_id!=5)
			<span class='badge badge-success' style='font-size:15px'>				
					{{ $status ?? ""}}							
			</span>
			@endif
		</div>
		<div class="col-5">
			@if($division_id==5)
				<a target="_blank" href="{{ route('quarterly_obligation_program.generatePDF', ['division_id'=>$division_id, 'year'=>$year_selected]) }}" >
					<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
					title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
			@else
				@role('Budget Officer')
					<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year_selected }}"
						data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $active_status_id }}" data-toggle="modal" 								
						@if($active_status_id==6 || $active_status_id==14) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"					
						@elseif($active_status_id==7 && $budget_comment_count <> 0) class="btn btn-primary float-right btn_forward_comment" 
							data-target="#forward_comment_modal"
						@elseif($active_status_id==7 && $budget_comment_count == 0) 
							class="btn btn-primary float-right btn_forward" data-target="#forward_modal"	
						@elseif($active_status_id==10) class="btn btn-primary float-right btn_reverse" data-target="#reverse_modal"	
						@else class="btn-xs d-none" @endif>
						@if($active_status_id==6 || $active_status_id==14) Receive Quarterly Obligation Program
						@elseif(($active_status_id==7) && ($budget_comment_count <> 0)) Forward Comment/s to Division Budget Controller
						@elseif(($active_status_id==7) && ($budget_comment_count == 0)) Forward Quarterly Obligation Program to BPAC
						@elseif($active_status_id==10) Reverse Forwading to BPAC
						@endif								
					</button>
				@endrole
				@role('BPAC Chair')
					<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year_selected }}"
						data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $active_status_id }}" data-toggle="modal" 								
						@if($active_status_id==10) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"					
						@elseif($active_status_id==11 && $bpac_comment_count <> 0) class="btn btn-primary float-right btn_forward_comment" 
							data-target="#forward_comment_modal"
						@elseif($active_status_id==11 && $bpac_comment_count == 0) 
							class="btn btn-primary float-right btn_forward" data-target="#forward_modal"	
						@else class="btn-xs d-none" @endif>
						@if($active_status_id==10) Receive Quarterly Obligation Program
						@elseif(($active_status_id==11) && ($bpac_comment_count <> 0)) Forward Comment/s to Division Budget Controller
						@elseif(($active_status_id==11) && ($bpac_comment_count == 0)) Approve Quarterly Obligation Program
						@endif								
					</button>
				@endrole
			@endif
		</div>
	</div>
</div>
<div class="row py-3">
  	<div class="col table-responsive">
		<table id="quarterly_obligation_program_table" class="table-bordered table-hover" style="width: 100%;">
			<thead class="text-center">
				<th width="76%">P/A/P, Division, Item of Expenditures</th> 
				<th width="6%">Annual Program</th>
				<th width="4%">Q1</th>
				<th width="4%">Q2</th>
				<th width="4%">Q3</th>										
				<th width="4%">Q4</th>	
			</thead>		
			<tbody><?php
				if($division_id==5){
					$data = DB::table('view_quarterly_obligation_programs')->where('year', $year_selected)
						->where('parent_division_id', $division_id)->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
						->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
						->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
						->groupBy('id')->get();	
				}
				else{
					$data = DB::table('view_quarterly_obligation_programs')->where('year', $year_selected)
						->where('division_id', $division_id)
						->where(function ($query) {
							$query->whereNull('comment_is_deleted')
								->orWhere('comment_is_deleted',0);
						})
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
						->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
						->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
						->groupBy('id')->get();
				}	
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
									foreach($row4 as $item4) {}//item 4
									$q1_expense_total=$row4->sum('q1_amount');
									$q2_expense_total=$row4->sum('q2_amount');
									$q3_expense_total=$row4->sum('q3_amount');
									$q4_expense_total=$row4->sum('q4_amount');																
									$annual_expense_total=$q1_expense_total + $q2_expense_total + $q3_expense_total + $q4_expense_total;									
									$annual_expense_total=$q1_expense_total + $q2_expense_total + $q3_expense_total + $q4_expense_total;?>
									<tr>
										<td class="expense1 font-weight-bold" colspan="6">{{ $item4->expense_account }}</td>														
									</tr>
									<?php
									if($division_id==5 || $division_id=='All'){ 																
										foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
											->where('activity_id', $item2->activity_id)
											->where('subactivity_id', $item3->subactivity_id)
											->where('expense_account_id', $item4->expense_account_id)
											->whereNull('object_specific_id')
											->groupBY('object_expenditure_id') as $key5=>$row5){
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
											</tr><?php
										}
										foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
											->where('activity_id', $item2->activity_id)
											->where('subactivity_id', $item3->subactivity_id)
											->where('expense_account_id', $item4->expense_account_id)
											->whereNotNull('object_specific_id')
											->groupBY('object_expenditure_id') as $key5=>$row5){
											foreach($row5 as $item5) {}//item 4
											$q1_amount=$row5->sum('q1_amount'); 
											$q2_amount=$row5->sum('q2_amount'); 
											$q3_amount=$row5->sum('q3_amount'); 
											$q4_amount=$row5->sum('q4_amount');									
											$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;
											if($item5->object_specific_id != NULL){?>
												<tr>
													<td class="objexp1" colspan="5">{{ $item5->object_expenditure }}</td>														
												</tr><?php
												foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
													->where('activity_id', $item2->activity_id)
													->where('subactivity_id', $item3->subactivity_id)
													->where('expense_account_id', $item4->expense_account_id)
													->where('object_expenditure_id', $item5->object_expenditure_id)
													->whereNotNull('object_specific_id')
													->groupBY('object_specific_id') as $key6=>$row6){
													foreach($row6 as $item6) {}//item 4
													$q1_amount=$row6->sum('q1_amount'); 
													$q2_amount=$row6->sum('q2_amount'); 
													$q3_amount=$row6->sum('q3_amount'); 
													$q4_amount=$row6->sum('q4_amount');
													$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
													<tr class="text-right">
														<td class="objspe1 font-italic">{{ $item6->object_specific }}</td>		
														<td>{{ number_format($annual_amount, 2) }}</td>											 
														<td>{{ number_format($q1_amount, 2) }}</td>		
														<td>{{ number_format($q2_amount, 2) }}</td>		
														<td>{{ number_format($q3_amount, 2) }}</td>		
														<td>{{ number_format($q4_amount, 2) }}</td>			
													</tr><?php
												}
											}
										}
									}
									else{
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
												<td class="text-center" width="2%">			
													@role('BPAC|Executive Director|Administrator|Super Administrator')
														<button type="button" data-id="{{ $item5->id }}" data-division-id="{{ $division_id }}" 
															data-year="{{ $year_selected }}" data-user-role-id="{{ $user_role_id }}" data-active-status-id="{{ $active_status_id }}"
															data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
															data-target="#comment_modal" data-toggle="tooltip" data-placement='auto' title='View Comment'
																@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL && $item5->comment_is_deleted==NULL)
																	|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																@else class="btn-xs btn_comment"@endif>
															<i class="fa-solid fa-comment"></i>																					
														</button>
													@endrole
													@role('Budget Officer')		
														<button type="button" data-id="{{ $item5->id }}" data-division-id="{{ $division_id }}" 
															data-year="{{ $year_selected }}" data-user-role-id="{{ $user_role_id }}" data-active-status-id="{{ $active_status_id }}"
															data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
															data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
															@if($active_status_id==7) title='Add/Edit Comment' class="btn-xs btn_comment" 
															@else title='View Comment'
																@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL && $item5->comment_is_deleted==NULL)
																	|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																@else class="btn-xs btn_comment"@endif
															@endif>
															<i 
															@if($active_status_id==7) class="fa-solid fa-comment blue fa-lg"
															@else class="fa-solid fa-comment fa-lg"
															@endif></i>																		
														</button>	
													@endrole
													@role('BPAC Chair')							
															<button type="button" data-id="{{ $item5->id }}" data-division-id="{{ $division_id }}" 
																data-year="{{ $year_selected }}" data-user-role-id="{{ $user_role_id }}" data-active-status-id="{{ $active_status_id }}"
																data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
																@if($active_status_id==11) title='Add/Edit Comment' class="btn-xs btn_comment" 
																@else title='View Comment'
																	@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL && $item5->comment_is_deleted==NULL)
																		|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																	@else class="btn-xs btn_comment"@endif
																@endif>
																<i 
																@if($active_status_id==11) class="fa-solid fa-comment blue fa-lg"
																@else class="fa-solid fa-comment fa-lg"
																@endif></i>																		
															</button>
													@endrole		
												</td>									
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
														<td class="text-center" width="2%">			
															@role('BPAC|Executive Director|Administrator|Super Administrator')				
																<button type="button" data-id="{{ $item6->id }}" data-division-id="{{ $division_id }}" 
																	data-year="{{ $year_selected }}" data-user-role-id="{{ $user_role_id }}" data-active-status-id="{{ $active_status_id }}"
																	data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																	data-target="#comment_modal" data-toggle="tooltip" data-placement='auto' title='View Comment'
																		@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL && $item6->comment_is_deleted==NULL)
																			|| ($item6->comment_by<>'' && $item6->comment_is_deleted==1)) class="d-none"
																		@else class="btn-xs btn_comment"@endif>
																	<i class="fa-solid fa-comment"></i>																					
																</button>
															@endrole
															@role('Budget Officer')		
																<button type="button" data-id="{{ $item6->id }}" data-division-id="{{ $division_id }}" 
																	data-year="{{ $year_selected }}" data-user-role-id="{{ $user_role_id }}" data-active-status-id="{{ $active_status_id }}"
																	data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																	data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
																	@if($active_status_id==7) title='Add/Edit Comment' class="btn-xs btn_comment" 
																	@else title='View Comment'
																		@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL) 
																			|| ($item6->comment_by<>'' && $item6->comment_is_deleted==1)) class="d-none"
																		@else class="btn-xs btn_comment"@endif
																	@endif>
																	<i 
																	@if($active_status_id==7) class="fa-solid fa-comment blue fa-lg"
																	@else class="fa-solid fa-comment fa-lg"
																	@endif></i>																		
																</button>
															@endrole
															@role('BPAC Chair')									
																<button type="button" data-id="{{ $item6->id }}" data-division-id="{{ $division_id }}" 
																	data-year="{{ $year_selected }}" data-user-role-id="{{ $user_role_id }}" data-active-status-id="{{ $active_status_id }}"
																	data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																	data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
																	@if($active_status_id==11) title='Add/Edit Comment' class="btn-xs btn_comment" 
																	@else title='View Comment'
																		@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL && $item6->comment_is_deleted==NULL)
																			|| ($item6->comment_by<>'' && $item6->comment_is_deleted==1)) class="d-none"
																		@else class="btn-xs btn_comment"@endif
																	@endif>
																	<i 
																	@if($active_status_id==11) class="fa-solid fa-comment blue fa-lg"
																	@else class="fa-solid fa-comment fa-lg"
																	@endif></i>																		
																</button>		
															@endrole	
														</td>
													</tr><?php
												}
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
										<td>Total Subactivity</td>
										<td>{{ number_format($annual_subactivity_total, 2) }}</td>											 
										<td>{{ number_format($q1_subactivity_total, 2) }}</td>
										<td>{{ number_format($q2_subactivity_total, 2) }}</td>
										<td>{{ number_format($q3_subactivity_total, 2) }}</td>
										<td>{{ number_format($q4_subactivity_total, 2) }}</td>	
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
									<td>Total Activity</td>
									<td>{{ number_format($annual_activity_total, 2) }}</td>											 
									<td>{{ number_format($q1_activity_total, 2) }}</td>
									<td>{{ number_format($q2_activity_total, 2) }}</td>
									<td>{{ number_format($q3_activity_total, 2) }}</td>
									<td>{{ number_format($q4_activity_total, 2) }}</td>	
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
								<td>Total PAP</td>
								<td>{{ number_format($annual_pap_total, 2) }}</td>											 
								<td>{{ number_format($q1_pap_total, 2) }}</td>
								<td>{{ number_format($q2_pap_total, 2) }}</td>
								<td>{{ number_format($q3_pap_total, 2) }}</td>
								<td>{{ number_format($q4_pap_total, 2) }}</td>
							</tr><?php 
						}
					}
				}
				foreach($data->groupBy('year') as $keyGTSum=>$rowGTSum){
					foreach($rowGTSum as $itemGTSum){}
						$q1_total=$rowGTSum->sum('q1_amount');															
						$q2_total=$rowGTSum->sum('q2_amount');															
						$q3_total=$rowGTSum->sum('q3_amount');															
						$q4_total=$rowGTSum->sum('q4_amount');												
						$annual_total=$q1_total + $q2_total + $q3_total + $q4_total;?>		
					<tr class="text-right font-weight-bold gray-bg">
						<td>GRAND TOTAL</td>
						<td>{{ number_format($annual_total, 2) }}</td>											 
						<td>{{ number_format($q1_total, 2) }}</td>
						<td>{{ number_format($q2_total, 2) }}</td>
						<td>{{ number_format($q3_total, 2) }}</td>
						<td>{{ number_format($q4_total, 2) }}</td>
					</tr><?php
				}?>
			</tbody>
		</table> 
  </div>    
</div>

