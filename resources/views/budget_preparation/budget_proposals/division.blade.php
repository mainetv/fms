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
						<li class="breadcrumb-item active">Budget Preparation</li>
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
						<h3 class="card-title">
							<i class="fas fa-edit"></i>
							<label for="year_selected">Year: </label>                        
							@php 
								$year = $data['year_selected'];
								// $years = getYears()
							@endphp
							<select name="year_selected" id="year_selected" onchange="changeYear()">
								@foreach ($years as $row)
									<option value="{{ $row->year }}" @if(isset($row->year) && $year==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
								@endforeach    
							</select>                                              
						</h3>
					</div>  
					<?php 
						$budget_proposal_id = 0;
						$division_acronym = '';
						$status_id = 0;
						$fiscal_year1 = '';
						$fiscal_year2 = '';
						$fiscal_year3 = '';
						$getUserDetails = getUserDetails($user_id);						
						foreach ($getUserDetails as $key => $value) {
							$user_id = $value->id;
							$emp_code = $value->emp_code;
							$parent_division_id = $value->parent_division_id;
							$division_id = $value->division_id;
							$division_acronym = $value->division_acronym;
							$cluster_id = $value->cluster_id;
						}
						if($user_id=='20' || $user_id=='14'){
							$division_id = '9';
							$user_division_acronym = 'FAD-DO';
							$division_acronym = 'FAD-DO';
						}
						// if($user_id=='3'){
						// 	$division_id = '22';
						// 	$user_division_acronym = 'OED';
						// 	$division_acronym = 'OED';
						// }
						if($user_id=='111'){
							$division_id = '3';
							$user_division_acronym = 'COA';
							$division_acronym = 'COA';
						}
						$sqlBP = getBudgetProposal($division_id, $year);			
						$sqlBpCommentsbyDirector = getBpCommentsbyDirector($division_id, $year);
						$dir_comment_count = getBpCommentsbyDirectorCount($division_id, $year) ?? NULL;
						$sqlBpCommentsbyFADBudget = getBpCommentsbyFADBudget($division_id, $year);
						$budget_comment_count = getBpCommentsbyFADBudgetCount($division_id, $year);
						$sqlBpStatus = getBudgetProposalStatus($division_id, $year);
						foreach($sqlBpCommentsbyDirector as $row){
							$director_comments=$row->comment;
							$budget_proposal_id=$row->budget_proposal_id;
						}
						foreach($sqlBpCommentsbyFADBudget as $row){
							$fad_budget_comments=$row->comment;
							$budget_proposal_id=$row->budget_proposal_id;
						}
						foreach($sqlBpStatus as $row){	
							$division_acronym=$row->division_acronym;
							$status=$row->status;
							$status_id=$row->status_id;
							$status_by_user_role_id=$row->status_by_user_role_id;
						}
						foreach($sqlBP as $row){
							$fiscal_year1 = $row->fiscal_year1;
							$fiscal_year2 = $row->fiscal_year2;
							$fiscal_year3 = $row->fiscal_year3;
						}						
					?> 					             
					<div class="col-2">
						<a target="_blank" href="{{ route('division_proposals.generatePDF', ['division_id'=>$division_id, 'year'=>$year]) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
					</div>													    
				</div>
			</div>    

			<div class="card-body py-2">				
				<div class="content">					
					<div class="row">	
						<div class="col-4 float-left">
							<h5>Fiscal Year: 
								@foreach ($fiscal_years_vertical as $row)
									{{ $fiscal_year1 = $row->fiscal_year1; }}-{{ $fiscal_year3 = $row->fiscal_year3; }}
									@php $fiscal_year2 = $row->fiscal_year2; @endphp
								@endforeach    
							</h5>
							<span class='badge badge-success' style='font-size:15px'>{{ $status ?? ""}}</span>
						</div>
						<div class="col-4 text-center">               
							<h2>{{ $user_division_acronym }}</h2>		  
						</div>  
						<div class="col-4 py-2">	
							@role('Division Director|Section Head')											
								<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year }}" 
									data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $status_id }}" data-toggle="modal" 									
									@if($status_id==2) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"								
									@elseif(($status_id==3) && ($dir_comment_count <> 0)) class="btn btn-primary float-right btn_forward_comment" 
										data-target="#forward_comment_modal"
									@elseif(($status_id==3) && ($dir_comment_count == 0)) class="btn btn-primary float-right btn_forward" 
										data-target="#forward_modal"							
									@else class="btn-xs d-none" @endif>
									@if($status_id==2) Receive Budget Proposal
									@elseif(($status_id==3) && ($dir_comment_count <> 0)) Forward Comment/s to Division Budget Controller
									@elseif(($status_id==3) && ($dir_comment_count == 0)) Forward Budget Proposal to FAD-Budget									
									@endif								
								</button>
							@endrole								
							@role('Division Budget Controller')
								<button type="button" data-division-id="{{ $division_id }}" data-year="{{ $year }}" data-parent-division-id="{{ $parent_division_id }}"
									data-division-acronym="{{ $division_acronym }}" data-active-status-id="{{ $status_id }}" data-toggle="modal"
									@if($status_id==1 || $status_id==5 || $status_id==9 || $status_id==13 || $division_id==3) class="btn btn-primary float-right btn_forward" data-target="#forward_modal"	
									@elseif($status_id==4 || $status_id==8 || $status_id==12) class="btn btn-primary float-right btn_receive" data-target="#receive_modal"
									@else class="btn-xs d-none" @endif>
									@if($status_id==1 || $status_id==5 || $status_id==9 || $status_id==13) 		
										@if($parent_division_id==0) Forward Budget Proposal to Division Director	
										@elseif($division_id==3) Forward Budget Proposal to FAD-Budget	
										@else Forward Budget Proposal to Section Head
										@endif			
									@elseif($status_id==4) 
										@if($parent_division_id==0) Receive Comment/s from Division Director
										@else Receive Comment/s from Section Head
										@endif	
									@elseif($status_id==8) Receive Comment/s from FAD-Budget	
									@elseif($status_id==12) Receive Comment/s from BPAC Chair @endif								
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
								@role('Division Budget Controller')
									@if($status_id==1 || $status_id==5 || $status_id==9 || $status_id==13)
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

								$data1 = DB::table('view_budget_proposals')->where('year', $year_selected)->where('division_id',$division_id)
									->where(function ($query) use ($division_id){
										$query->whereNotNull('pooled_at_division_id')
											->where('pooled_at_division_id','!=',$division_id);
									})
									->where('is_active', 1)->where('is_deleted', 0)
									->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
									->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
									->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
									->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
									->groupBy('id')->get();

								foreach($data->groupBY('allotment_class_id') as $key=>$row){			
									foreach($row as $item) {} //item?>
									<tr>
										<td class="font-weight-bold" colspan="4">{{ $item->allotment_class }} ({{ $item->allotment_class_acronym }})</td>													
									</tr><?php
									foreach($data->where('allotment_class_id', $item->allotment_class_id)->groupBY('pap_id') as $key1=>$row1){
										foreach($row1 as $item1) {} //item 1?>
										<tr>
											<td class="pap font-weight-bold gray1-bg" colspan="4">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
										</tr><?php 		
										foreach($data->where('allotment_class_id', $item->allotment_class_id)
											->where('pap_id', $item1->pap_id)
											->groupBY('activity_id') as $key2=>$row2){
											foreach($row2 as $item2) {} //item 2?>
											<tr>
												<td class="activity1 font-weight-bold" colspan="4">{{ $item2->activity }}</td>													
											</tr><?php 										
											foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
												->where('activity_id', $item2->activity_id)
												->groupBY('subactivity_id') as $key3=>$row3){
												foreach($row3 as $item3) {} 
												if(isset($item3->subactivity)){//item 3?>
													<tr>
														<td class="subactivity1 font-weight-bold" colspan="4">{{ $item3->subactivity }}</td>													
													</tr><?php 
												}	
												foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
													->where('activity_id', $item2->activity_id)
													->where('subactivity_id', $item3->subactivity_id)
													->groupBY('expense_account_id') as $key4=>$row4){
													foreach($row4 as $item4) {}//item 4?>
													<tr class="text-right font-weight-bold">
														<td class="expense">{{ $item4->expense_account }}</td>
														<td>{{ number_format($row4->sum('fy1_amount'), 2) }}</td>													
														<td>{{ number_format($row4->sum('fy2_amount'), 2) }}</td>													
														<td>{{ number_format($row4->sum('fy3_amount'), 2) }}</td>												
													</tr><?php
													foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
														->where('activity_id', $item2->activity_id)
														->where('subactivity_id', $item3->subactivity_id)
														->where('expense_account_id', $item4->expense_account_id)
														->whereNull('object_specific_id')
														->groupBY('id') as $key5=>$row5){
														foreach($row5 as $item5) {}//item 4?>
														<tr class="text-right">
															<td class="objexp">{{ $item5->object_expenditure }}
																@if($item5->pooled_at_division_id != '') 
																	- Pooled at {{ $item5->pooled_at_division_acronym }} ({{ $item5->division_acronym }})@endif</td>
															<td>{{ number_format($item5->fy1_amount, 2) }}</td>													
															<td>{{ number_format($item5->fy2_amount, 2) }}</td>													
															<td>{{ number_format($item5->fy3_amount, 2) }}</td>														
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
																@role('Division Budget Controller')																
																@if($active_status_id==1 || $active_status_id==5 || $active_status_id==9 || $active_status_id==13)								
																	<button type="button" class="btn-xs btn_edit btn btn-outline-success" data-id="{{ $item5->id }}"
																		data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																		data-placement='auto' title='Edit'>
																		<i class="fa-solid fa-pen-to-square fa-lg"></i>															
																	</button>
																	<button type="button" class="btn-xs btn_delete btn btn-outline-danger" data-id="{{ $item5->id }}" 
																		data-toggle="tooltip" data-placement='auto'title='Delete'>
																		<i class="fa-solid fa-trash-can fa-lg"></i>
																	</button>	
																@endif		
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
														if($item5->object_specific_id != NULL){?>
															<tr>			
																<td class="objexp" colspan="4">{{ $item5->object_expenditure }}</td>											
															</tr><?php
															foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
																->where('activity_id', $item2->activity_id)
																->where('subactivity_id', $item3->subactivity_id)
																->where('expense_account_id', $item4->expense_account_id)
																->where('object_expenditure_id', $item5->object_expenditure_id)
																->whereNotNull('object_specific_id')
																->groupBY('id') as $key6=>$row6){
																foreach($row6 as $item6) {}//item 4?>
																<tr class="text-right">
																	{{-- <td class="objspe1 font-italic">{{ $item6->object_specific }}</td>		 --}}
																	<td class="objspe1 font-italic">{{ $item6->object_specific }}
																		@if($item6->pooled_at_division_id != '') 
																			- Pooled at {{ $item6->pooled_at_division_acronym }} ({{ $item6->division_acronym }})@endif</td>
																	<td>{{ number_format($item6->fy1_amount, 2) }}</td>													
																	<td>{{ number_format($item6->fy2_amount, 2) }}</td>													
																	<td>{{ number_format($item6->fy3_amount, 2) }}</td>															
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
																		@role('Division Budget Controller')
																		@if($active_status_id==1 || $active_status_id==5 || $active_status_id==9 || $active_status_id==13)							
																			<button type="button" class="btn-xs btn_edit btn btn-outline-success" data-id="{{ $item6->id }}" 
																				data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
																				data-placement='auto' title='Edit'>
																				<i class="fa-solid fa-pen-to-square fa-lg"></i>																					
																			</button>																	
																			<button type="button" class="btn-xs btn_delete btn btn-outline-danger" data-id="{{ $item6->id }}" 
																				data-toggle="tooltip" data-placement='auto'title='Delete'>
																				<i class="fa-solid fa-trash-can fa-lg"></i>
																			</button>	
																		@endif	
																		@endrole																		 
																	</td>		
																</tr><?php
															}
														}
													}
												}	
												if(isset($item3->subactivity)){?>		
													<tr class="text-right font-weight-bold gray-bg">
														<td>Total Subactivity, {{ $item3->subactivity }}</td>	
														<td>&nbsp;&nbsp;{{ number_format($row3->sum('fy1_amount'), 2) }}</td>
														<td>&nbsp;&nbsp;{{ number_format($row3->sum('fy2_amount'), 2) }}</td>
														<td>&nbsp;&nbsp;{{ number_format($row3->sum('fy3_amount'), 2) }}</td>		
													</tr><?php
												}
											}																		
											if(isset($item2->activity)){?>
												<tr class="text-right font-weight-bold gray-bg">
													<td>Total Activity, {{ $item2->activity }}</td>
													<td>&nbsp;&nbsp;{{ number_format($row2->sum('fy1_amount'), 2) }}</td>
													<td>&nbsp;&nbsp;{{ number_format($row2->sum('fy2_amount'), 2) }}</td>
													<td>&nbsp;&nbsp;{{ number_format($row2->sum('fy3_amount'), 2) }}</td>
												</tr><?php
											}
										}									
										if(isset($item1->pap)){?>
											<tr class="text-right font-weight-bold gray-bg">
												<td>Total PAP, {{ $item1->pap }}</td>
												<td>&nbsp;&nbsp;{{ number_format($row1->sum('fy1_amount'), 2) }}</td>
												<td>&nbsp;&nbsp;{{ number_format($row1->sum('fy2_amount'), 2) }}</td>
												<td>&nbsp;&nbsp;{{ number_format($row1->sum('fy3_amount'), 2) }}</td>
											</tr><?php 
										}
									}
								}
								foreach($data->groupBy('year') as $keyGTSum=>$rowGTSum){
									foreach($rowGTSum as $itemGTSum){}?>		
									<tr class="text-right font-weight-bold gray-bg">
										<td>GRAND TOTAL</td>
										<td>&nbsp;&nbsp;{{ number_format($rowGTSum->sum('fy1_amount'), 2) }}</td>
										<td>&nbsp;&nbsp;{{ number_format($rowGTSum->sum('fy2_amount'), 2) }}</td>
										<td>&nbsp;&nbsp;{{ number_format($rowGTSum->sum('fy3_amount'), 2) }}</td>
									</tr><?php
								}?>
								<tr>
									<td colspan="4">&nbsp;</td>
								</tr>
							</tbody>
						</table>	
						<br>
						
					</div>    
				</div>					
			</div>
		</div>            
	</section>
	@include('budget_preparation.budget_proposals.modal')	
@endsection

@section('jscript')
   <script type="text/javascript">     
      $(document).ready(function(){   
         @include('budget_preparation.budget_proposals.script')   
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
			window.location.replace("{{ url('budget_preparation/budget_proposal/division') }}/"+year);
		}	 
   </script>  
@endsection

