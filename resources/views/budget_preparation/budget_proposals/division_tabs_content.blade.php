<h4>{{ $value->division_acronym }}</h4>
<?php
	$division_id=$value->id;	
	$division_acronym=$value->division_acronym;	
	$parent_division_id=$value->parent_id;	
	$budget_proposal_id = 0;
	$status_id = 0;
	$sqlBP = getBudgetProposal($division_id, $year_selected);	
	$sqlBpCommentsbyDirector = getBpCommentsbyDirector($division_id, $year_selected);
	$sqlBpCommentsbyFADBudget = getBpCommentsbyFADBudget($division_id, $year_selected);
	$sqlBpCommentsbyBPAC = getBpCommentsbyBPAC($division_id, $year_selected);
	$director_comment_count = getBpCommentsbyDirectorCount($division_id, $year_selected);	
	$budget_comment_count = getBpCommentsbyFADBudgetCount($division_id, $year_selected);
	$bpac_comment_count = getBpCommentsbyBPACCount($division_id, $year_selected);
	$sqlBpStatus = getBudgetProposalStatus($division_id, $year_selected);
	foreach($sqlBpCommentsbyDirector as $row){
		$director_comments=$row->comment;
		$budget_proposal_id=$row->budget_proposal_id;
	}
	foreach($sqlBpCommentsbyFADBudget as $row){
		$fad_budget_comments=$row->comment;
		$budget_proposal_id=$row->budget_proposal_id;
	}
	foreach($sqlBpCommentsbyBPAC as $row){
		$bpac_comments=$row->comment;
		$budget_proposal_id=$row->budget_proposal_id;
	}
	foreach($sqlBpStatus as $row){	
		$division_acronym=$row->division_acronym;
		$status=$row->status;
		$status_id=$row->status_id;
	}
	foreach($sqlBP as $row){
		$year=$row->year;
		$fiscal_year1 = $row->fiscal_year1;
		$fiscal_year2 = $row->fiscal_year2;
		$fiscal_year3 = $row->fiscal_year3;
	}
?>
<div class="content">
  <div class="row">
    <div class="col-7">
		<span class='badge badge-success' style='font-size:15px'>
			@if($division_id!=5)
				{{ $status ?? ""}}
			@endif			
		</span>
    </div>
	 <div class="col-5">
		@role('BPAC Chair')
			<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year_selected }}" 
				data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $status_id }}" data-toggle="modal" 								
				@if($status_id==10) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"			
				@elseif($status_id==11 && $bpac_comment_count <> 0) class="btn btn-primary float-right btn_forward_comment" 
					data-target="#forward_comment_modal"
				@elseif(($status_id==11 && $bpac_comment_count == 0) || $status_id==11) 
					class="btn btn-primary float-right btn_forward" data-target="#forward_modal"						
				@else class="btn-xs d-none" @endif>
				@if($status_id==10) Receive Budget Proposal
				@elseif($status_id==11 && $bpac_comment_count <> 0) Forward Comment/s to Division Budget Controller									
				@elseif($status_id==11 && $bpac_comment_count == 0) Approve Budget Proposal									
				@endif								
			</button>
		@endrole
		@role('Budget Officer')
			<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year_selected }}"
				data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $status_id }}" data-toggle="modal" 								
				@if($status_id==6 || $status_id==14) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"					
				@elseif($status_id==7 && $budget_comment_count <> 0) class="btn btn-primary float-right btn_forward_comment" 
					data-target="#forward_comment_modal"
				@elseif(($status_id==7 && $budget_comment_count == 0) || ($division_id==3 && $status_id==1) || $status_id==15) 
					class="btn btn-primary float-right btn_forward" data-target="#forward_modal"	
				@elseif($status_id==10) class="btn btn-primary float-right btn_reverse" data-target="#reverse_modal"	
				@else class="btn-xs d-none" @endif>
				@if($status_id==6 || $status_id==14) Receive Budget Proposal
				@elseif(($status_id==7) && ($budget_comment_count <> 0)) Forward Comment/s to Division Budget Controller
				@elseif(($status_id==7) && ($budget_comment_count == 0) || ($division_id==3 && $status_id==1)) Forward Budget Proposal to BPAC
				{{-- @elseif($status_id==14) Forward to 'Set Approve Budget' --}}
				@elseif($status_id==15) Set Allotment Status
				@elseif($status_id==10) Reverse Forwading to BPAC
				@endif								
			</button>
		@endrole	
	 </div>
  </div>
</div>
<div class="row py-3">
  	<div class="col table-responsive">
		<table id="budget_proposal_table" class="table-bordered table-hover" style="width: 100%;">
			<thead class="text-center">
				<th>ACTIVITY / Object of Expenditures</th>
				<th>{{ $fiscal_year1 }}</th>
				<th>{{ $fiscal_year2 }}</th>
				<th>{{ $fiscal_year3 }}</th>
				@role('Budget Officer')
					@if(($division_id==3 && ($status_id==1 || $status_id==29)) || ($division_id==22 && $status_id==9))
						<td class="text-center" style="width:140px">					
							<button type="button" class="btn_add btn-xs btn btn-outline-primary" data-division-id="{{ $division_id }}"
								data-year="{{ $year }}" data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
								data-placement='auto' title='Add'><i class="fa-solid fa-plus fa-lg"></i>
							</button>&nbsp;																			 
						</td>
					@endif
				@endrole
			</thead>			
			<tbody><?php					
				if($division_id==5){
					$data = DB::table('view_budget_proposals')->where('year', $year_selected)
						->where(function ($query) use ($division_id){
							$query->where(function ($query) use ($division_id){
									$query->where('parent_division_id', $division_id)
										->whereNull('parent_pooled_at_division_id');
								})
								->orWhere(function ($query) use ($division_id){
									$query->where('parent_division_id','!=', $division_id)
										->where('parent_pooled_at_division_id',$division_id);		
								});
						})
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
						->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
						->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
						->groupBy('id')->get();
					// $data = DB::table('view_budget_proposals')->where('year', $year_selected)
					// 	->where('is_active', 1)->where('is_deleted', 0)
					// 	->where(function ($query) use ($division_id){
					// 		$query->where(function ($query) use ($division_id){
					// 				$query->where('parent_division_id', $division_id)
					// 					->whereNull('parent_pooled_at_division_id');
					// 			})
					// 			->orWhere(function ($query) use ($division_id){
					// 				$query->where('parent_division_id','!=', $division_id)
					// 					->where('parent_pooled_at_division_id',$division_id);									
					// 			});
					// 	})
					// 	->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
					// 	->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_specific','ASC')->groupBy('id')->get();	
						
					$data1 = DB::table('view_budget_proposals')->where('year', $year_selected)->where('parent_division_id', $division_id)
						->where(function ($query) use ($division_id){
							$query->whereNotNull('parent_division_id')
								->where('parent_pooled_at_division_id','!=',$division_id);
						})
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id')->orderBy('activity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_specific','ASC')->groupBy('id')->get();
				}
				else{
					$data = DB::table('view_budget_proposals')->where('year', $year_selected)
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
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
						->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
						->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
						->groupBy('id')->get();
					// $data = DB::table('view_budget_proposals')->where('year', $year_selected)
					// 	->where(function ($query) use ($division_id){
					// 		$query->where(function ($query) use ($division_id){
					// 				$query->where('division_id', $division_id)
					// 					->whereNull('pooled_at_division_id');
					// 			})
					// 			->orWhere(function ($query) use ($division_id){
					// 				$query->where('pooled_at_division_id',$division_id)
					// 					->where('division_id','!=', $division_id);
					// 			});
					// 	})
					// 	->where('is_active', 1)->where('is_deleted', 0)
					// 	->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
					// 	->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_specific','ASC')->groupBy('id')->get();
						
					$data1 = DB::table('view_budget_proposals')->where('year', $year_selected)->where('division_id',$division_id)
						->where(function ($query) use ($division_id){
							$query->whereNotNull('pooled_at_division_id')
								->where('pooled_at_division_id','!=',$division_id);
						})
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_specific','ASC')->groupBy('id')->get();	
				}					
				foreach($data->groupBY('allotment_class_id') as $key=>$row){			
					foreach($row as $item) {} //item?>
					<tr>
						<td class="font-weight-bold" colspan="14">{{ $item->allotment_class }} ({{ $item->allotment_class_acronym }})</td>													
					</tr><?php
					foreach($data->where('allotment_class_id', $item->allotment_class_id)->groupBY('pap_code') as $key1=>$row1){
						foreach($row1 as $item1) {} //item 1?>
						<tr>
							<td class="pap font-weight-bold gray1-bg" colspan="14">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
						</tr><?php 		
						foreach($data->where('allotment_class_id', $item->allotment_class_id)
							->where('pap_id', $item1->pap_id)
							->groupBY('activity_id') as $key2=>$row2){
							foreach($row2 as $item2) {} //item 2?>
							<tr>
								<td class="activity1 font-weight-bold" colspan="14">{{ $item2->activity }}</td>													
							</tr><?php 										
							foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
								->where('activity_id', $item2->activity_id)
								->groupBY('subactivity_id') as $key3=>$row3){
								foreach($row3 as $item3) {} 
								if(isset($item3->subactivity)){//item 3?>
									<tr>
										<td class="subactivity1 font-weight-bold" colspan="14">{{ $item3->subactivity }}</td>													
									</tr><?php 
								}	
								foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
									->where('activity_id', $item2->activity_id)
									->where('subactivity_id', $item3->subactivity_id)
									->groupBY('expense_account_id') as $key4=>$row4){
									foreach($row4 as $item4) {}//item 4
									$fy1_expense_total=$row4->sum('fy1_amount');
									$fy2_expense_total=$row4->sum('fy2_amount');
									$fy3_expense_total=$row4->sum('fy3_amount');								?>
									<tr>
										<td class="expense1 font-weight-bold" colspan="14">{{ $item4->expense_account }}</td>														
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
											$fy1_amount=$item5->fy1_amount;
											$fy2_amount=$item5->fy2_amount;
											$fy3_amount=$item5->fy3_amount;								?>
											<tr class="text-right">
												<td class="objexp1">{{ $item5->object_expenditure }}</td>											 
												<td>{{ number_format($fy1_amount, 2) }}</td>
												<td>{{ number_format($fy2_amount, 2) }}</td>
												<td>{{ number_format($fy3_amount, 2) }}</td>												
											</tr><?php
										}
										foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
											->where('activity_id', $item2->activity_id)
											->where('subactivity_id', $item3->subactivity_id)
											->where('expense_account_id', $item4->expense_account_id)
											->whereNotNull('object_specific_id')
											->groupBY('object_expenditure_id') as $key5=>$row5){
											foreach($row5 as $item5) {}//item 4
											$fy1_amount=$row5->sum('fy1_amount'); 
											$fy2_amount=$row5->sum('fy2_amount');
											$fy3_amount=$row5->sum('fy3_amount');								
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
													$fy1_amount=$row6->sum('fy1_amount'); 
													$fy2_amount=$row6->sum('fy2_amount');
													$fy3_amount=$row6->sum('fy3_amount');						?>
													<tr class="text-right">
														<td class="objspe1 font-italic">{{ $item6->object_specific }}</td>											 
														<td>{{ number_format($fy1_amount, 2) }}</td>
														<td>{{ number_format($fy2_amount, 2) }}</td>
														<td>{{ number_format($fy3_amount, 2) }}</td>			
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
											$fy1_amount=$item5->fy1_amount;
											$fy2_amount=$item5->fy2_amount;
											$fy3_amount=$item5->fy3_amount;								?>
											<tr class="text-right">
												<td class="objexp1">{{ $item5->object_expenditure }}</td>											 
												<td>{{ number_format($fy1_amount, 2) }}</td>
												<td>{{ number_format($fy2_amount, 2) }}</td>
												<td>{{ number_format($fy3_amount, 2) }}</td>			
												<td class="text-center" width="10px">	
												@role('BPAC|Executive Director|Administrator|Super Administrator')		
													<td class="text-center">								
														<button type="button" data-id="{{ $item5->id }}" data-division-id="{{ $division_id }}" 
															data-year="{{ $year_selected }}" data-active-status-id="{{ $status_id }}"
															data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
															data-target="#comment_modal" data-toggle="tooltip" data-placement='auto' title='View Comment'
																@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL && $item5->comment_is_deleted==NULL)
																	|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																@else class="btn-xs btn_comment"@endif>
															<i class="fa-solid fa-comment"></i>																					
														</button>																																							 
													</td>
												@endrole
												@role('Budget Officer')		
													<td class="text-center">
														<button type="button" data-id="{{ $item5->id }}" data-division-id="{{ $division_id }}" 
															data-year="{{ $year_selected }}" data-active-status-id="{{ $status_id }}"
															data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
															data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
															@if($status_id==7) title='Add/Edit Comment' class="btn-xs btn_comment" 
															@else title='View Comment'
																@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL && $item5->comment_is_deleted==NULL)
																	|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																@else class="btn-xs btn_comment"@endif
															@endif>
															<i 
															@if($status_id==7) class="fa-solid fa-comment blue fa-lg"
															@else class="fa-solid fa-comment fa-lg"
															@endif></i>																		
														</button>
														@if(($division_id==3 && ($status_id==1 || $status_id==5)) || ($division_id==22 && $status_id==9))
															<button type="button" class="btn-xs btn_edit" data-id="{{ $item5->id }}" 
																data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																data-placement='auto' title='Edit'>
																<i class="fa-solid fa-edit green fa-lg"></i>																				
															</button>																	
															<button type="button" class="btn-xs btn_delete" data-id="{{ $item5->id }}" 
																data-toggle="tooltip" data-placement='auto'title='Delete'>
																<i class="fa-solid fa-trash-can fa-lg red"></i>
															</button>
														@endif																																					 
													</td>
												@endrole
												@role('BPAC Chair')		
													<td class="text-center">								
														<button type="button" data-id="{{ $item5->id }}" data-division-id="{{ $division_id }}" 
															data-year="{{ $year_selected }}" data-active-status-id="{{ $status_id }}"
															data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
															data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
															@if($status_id==11) title='Add/Edit Comment' class="btn-xs btn_comment" 
															@else title='View Comment'
																@if(($item5->comment_by==NULL && $item5->comment_is_deleted==NULL && $item5->comment_is_deleted==NULL)
																	|| ($item5->comment_by<>'' && $item5->comment_is_deleted==1)) class="d-none"
																@else class="btn-xs btn_comment"@endif
															@endif>
															<i 
															@if($status_id==11) class="fa-solid fa-comment blue fa-lg"
															@else class="fa-solid fa-comment fa-lg"
															@endif></i>																		
														</button>																																							 
													</td>
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
											$fy1_amount=$item5->fy1_amount;
											$fy2_amount=$item5->fy2_amount;
											$fy3_amount=$item5->fy3_amount;								
											if($item5->object_specific_id != NULL){?>
												<tr>
													<td class="objexp1" colspan="14">{{ $item5->object_expenditure }}</td>														
												</tr><?php
												foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
													->where('activity_id', $item2->activity_id)
													->where('subactivity_id', $item3->subactivity_id)
													->where('expense_account_id', $item4->expense_account_id)
													->where('object_expenditure_id', $item5->object_expenditure_id)
													->whereNotNull('object_specific_id')
													->groupBY('id') as $key6=>$row6){
													foreach($row6 as $item6) {}//item 4
													$fy1_amount=$item6->fy1_amount;
													$fy2_amount=$item6->fy2_amount;
													$fy3_amount=$item6->fy3_amount;					?>
													<tr class="text-right">
														<td class="objspe1 font-italic">{{ $item6->object_specific }}</td>									 
														<td>{{ number_format($fy1_amount, 2) }}</td>
														<td>{{ number_format($fy2_amount, 2) }}</td>
														<td>{{ number_format($fy3_amount, 2) }}</td>		
														<td class="text-center" width="10px">					
														@role('BPAC|Executive Director|Administrator|Super Administrator')		
															<td class="text-center">								
																<button type="button" data-id="{{ $item6->id }}" data-division-id="{{ $division_id }}" 
																	data-year="{{ $year_selected }}" data-active-status-id="{{ $status_id }}"
																	data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																	data-target="#comment_modal" data-toggle="tooltip" data-placement='auto' title='View Comment'
																		@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL && $item6->comment_is_deleted==NULL)
																			|| ($item6->comment_by<>'' && $item6->comment_is_deleted==1)) class="d-none"
																		@else class="btn-xs btn_comment"@endif>
																	<i class="fa-solid fa-comment"></i>																					
																</button>																																							 
															</td>
														@endrole
														@role('Budget Officer')		
															<td class="text-center">
																<button type="button" data-id="{{ $item6->id }}" data-division-id="{{ $division_id }}" 
																	data-year="{{ $year_selected }}" data-active-status-id="{{ $status_id }}"
																	data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																	data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
																	@if($status_id==7) title='Add/Edit Comment' class="btn-xs btn_comment" 
																	@else title='View Comment'
																		@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL && $item6->comment_is_deleted==NULL)
																			|| ($item6->comment_by<>'' && $item6->comment_is_deleted==1)) class="d-none"
																		@else class="btn-xs btn_comment"@endif
																	@endif>
																	<i 
																	@if($status_id==7) class="fa-solid fa-comment blue fa-lg"
																	@else class="fa-solid fa-comment fa-lg"
																	@endif></i>																		
																</button>
																@if(($division_id==3 && ($status_id==1 || $status_id==29)) || ($division_id==22 && $status_id==9))
																	<button type="button" class="btn-xs btn_edit" data-id="{{ $item6->id }}" 
																		data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																		data-placement='auto' title='Edit'>
																		<i class="fa-solid fa-edit green fa-lg"></i>																				
																	</button>																	
																	<button type="button" class="btn-xs btn_delete" data-id="{{ $item6->id }}" 
																		data-toggle="tooltip" data-placement='auto'title='Delete'>
																		<i class="fa-solid fa-trash-can fa-lg red"></i>
																	</button>
																@endif																																					 
															</td>
														@endrole
														@role('BPAC Chair')		
															<td class="text-center">								
																<button type="button" data-id="{{ $item6->id }}" data-division-id="{{ $division_id }}" 
																	data-year="{{ $year_selected }}" data-active-status-id="{{ $status_id }}"
																	data-parent-division-id="{{ $parent_division_id }}" data-toggle="modal" 
																	data-target="#comment_modal" data-toggle="tooltip" data-placement='auto'
																	@if($status_id==11) title='Add/Edit Comment' class="btn-xs btn_comment" 
																	@else title='View Comment'
																		@if(($item6->comment_by==NULL && $item6->comment_is_deleted==NULL && $item6->comment_is_deleted==NULL)
																			|| ($item6->comment_by<>'' && $item6->comment_is_deleted==1)) class="d-none"
																		@else class="btn-xs btn_comment"@endif
																	@endif>
																	<i 
																	@if($status_id==11) class="fa-solid fa-comment blue fa-lg"
																	@else class="fa-solid fa-comment fa-lg"
																	@endif></i>																		
																</button>																																							 
															</td>
														@endrole	
														</td>
													</tr><?php
												}
											}
										}
									}
								}	
								if(isset($item3->subactivity)){
									$fy1_subactivity_total=$row3->sum('fy1_amount');
									$fy2_subactivity_total=$row3->sum('fy2_amount');
									$fy3_subactivity_total=$row3->sum('fy3_amount');?>		
									<tr class="text-right font-weight-bold gray-bg">
										<td>Total Subactivity</td>										 
										<td>&nbsp;&nbsp;{{ number_format($fy1_subactivity_total, 2) }}</td>
										<td>&nbsp;&nbsp;{{ number_format($fy2_subactivity_total, 2) }}</td>
										<td>&nbsp;&nbsp;{{ number_format($fy3_subactivity_total, 2) }}</td>		
									</tr><?php
								}
							}														
							if(isset($item2->activity)){
								$fy1_activity_total=$row2->sum('fy1_amount');
								$fy2_activity_total=$row2->sum('fy2_amount');
								$fy3_activity_total=$row2->sum('fy3_amount');									?>
								<tr class="text-right font-weight-bold gray-bg">
									<td>Total Activity</td>										 
									<td>&nbsp;&nbsp;{{ number_format($fy1_activity_total, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($fy2_activity_total, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($fy3_activity_total, 2) }}</td>
								</tr><?php
							}
						}									
						if(isset($item1->pap)){
							$fy1_pap_total=$row1->sum('fy1_amount');
							$fy2_pap_total=$row1->sum('fy2_amount');
							$fy3_pap_total=$row1->sum('fy3_amount');							?>
							<tr class="text-right font-weight-bold gray-bg">
								<td>Total PAP</td>										 
								<td>&nbsp;&nbsp;{{ number_format($fy1_pap_total, 2) }}</td>
								<td>&nbsp;&nbsp;{{ number_format($fy2_pap_total, 2) }}</td>
								<td>&nbsp;&nbsp;{{ number_format($fy3_pap_total, 2) }}</td>
							</tr><?php 
						}
					}
				}
				foreach($data->groupBy('year') as $keyGTSum=>$rowGTSum){
					foreach($rowGTSum as $itemGTSum){}
						$fy1_total=$rowGTSum->sum('fy1_amount');
						$fy2_total=$rowGTSum->sum('fy2_amount');
						$fy3_total=$rowGTSum->sum('fy3_amount');						?>		
					<tr class="text-right font-weight-bold gray-bg">
						<td>GRAND TOTAL</td>										 
						<td>&nbsp;&nbsp;{{ number_format($fy1_total, 2) }}</td>
						<td>&nbsp;&nbsp;{{ number_format($fy2_total, 2) }}</td>
						<td>&nbsp;&nbsp;{{ number_format($fy3_total, 2) }}</td>	
					</tr><?php
				}?>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
			</tbody>
		</table>	 	 
  </div>    
</div>

