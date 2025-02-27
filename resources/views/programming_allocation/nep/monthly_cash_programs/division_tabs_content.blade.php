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
	$sqlCP = getMonthlyCashProgram($division_id, $year_selected);
	$sqlCpCommentsbyDirector = getCpCommentsbyDirector($division_id, $year_selected);
	$sqlCpCommentsbyFADBudget = getCpCommentsbyFADBudget($division_id, $year_selected);
	$sqlCpCommentsbyBPAC = getCpCommentsbyBPAC($division_id, $year_selected);
	$director_comment_count = getCpCommentsbyDirectorCount($division_id, $year_selected);	
	$budget_comment_count = getCpCommentsbyFADBudgetCount($division_id, $year_selected);
	$bpac_comment_count = getCpCommentsbyBPACCount($division_id, $year_selected);
	$sqlCpStatus = getCashProgramStatus($division_id, $year_selected);
	foreach($sqlCpCommentsbyDirector as $row){
		$director_comments=$row->comment;
		$cash_program_id=$row->cash_program_id;
	}
	foreach($sqlCpCommentsbyFADBudget as $row){
		$fad_budget_comments=$row->comment;
		$cash_program_id=$row->cash_program_id;
	}
	foreach($sqlCpCommentsbyBPAC as $row){
		$bpac_comments=$row->comment;
		$cash_program_id=$row->cash_program_id;
	}
	foreach($sqlCpStatus as $row){
		$division_acronym=$row->division_acronym;
		$status=$row->status;
		$active_status_id=$row->status_id;
	}
	foreach($sqlCP as $row){
		$year=$row->year;
		$fiscal_year1 = $row->fiscal_year1;
		$fiscal_year2 = $row->fiscal_year2;
		$fiscal_year3 = $row->fiscal_year3;
	}	
@endphp
<div class="content">
  <div class="row">
	<div class="col-7 float-left">
		@if($division_id!=5)
			<span class='badge badge-success' style='font-size:15px'>				
				{{ $status ?? "" }}							
			</span>
		@endif
	</div>
	<div class="col-5 float-right">
		@if($division_id==5)
			<a target="_blank" href="{{ route('monthly_cash_program.generatePDF', ['division_id'=>$division_id, 'year'=>$year_selected]) }}" >
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
					@if($active_status_id==6 || $active_status_id==14) Receive Monthly Cash Program
					@elseif(($active_status_id==7) && ($budget_comment_count <> 0)) Forward Comment/s to Division Budget Controller
					@elseif(($active_status_id==7) && ($budget_comment_count == 0)) Forward Monthly Cash Program to BPAC
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
					@if($active_status_id==10) Receive Monthly Cash Program
					@elseif(($active_status_id==11) && ($bpac_comment_count <> 0)) Forward Comment/s to Division Budget Controller
					@elseif(($active_status_id==11) && ($bpac_comment_count == 0)) Approve Monthly Cash Program
					@endif								
				</button>
			@endrole
		@endif
	 </div>
  </div>
</div>
<div class="row py-3">
  	<div class="col table-responsive">
		<table id="monthly_cash_program_table" class="table-bordered table-hover" style="width: 100%;">
			<thead class="text-center">
				<th style="min-width:160px; max-width:160px;">P/A/P / Object of Expenditures</th> 
				<th width="60px">Annual</th>
				<th width="50px">Jan</th>
				<th width="50px">Feb</th>
				<th width="50px">Mar</th>										
				<th width="50px">Apr</th>										
				<th width="50px">May</th>										
				<th width="50px">Jun</th>										
				<th width="50px">Jul</th>										
				<th width="50px">Aug</th>										
				<th width="50px">Sep</th>										
				<th width="50px">Oct</th>										
				<th width="50px">Nov</th>										
				<th width="50px">Dec</th>	
			</thead>		
			<tbody><?php
				if($division_id==5){
					$data = DB::table('view_monthly_cash_programs')->where('year', $year_selected)
						->where('parent_division_id', $division_id)->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
						->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
						->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
						->groupBy('id')->get();	
				}
				else{
					$data = DB::table('view_monthly_cash_programs')->where('year', $year_selected)
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
												<td class="objexp1">{{ $item5->object_expenditure }}</td>		
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
											</tr><?php
										}
										foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
											->where('activity_id', $item2->activity_id)
											->where('subactivity_id', $item3->subactivity_id)
											->where('expense_account_id', $item4->expense_account_id)
											->whereNotNull('object_specific_id')
											->groupBY('object_expenditure_id') as $key5=>$row5){
											foreach($row5 as $item5) {}//item 4
											$jan_amount=$row5->sum('jan_amount'); 
											$feb_amount=$row5->sum('feb_amount');
											$mar_amount=$row5->sum('mar_amount');
											$apr_amount=$row5->sum('apr_amount');
											$may_amount=$row5->sum('may_amount');
											$jun_amount=$row5->sum('jun_amount');
											$jul_amount=$row5->sum('jul_amount');
											$aug_amount=$row5->sum('aug_amount');
											$sep_amount=$row5->sum('sep_amount');
											$oct_amount=$row5->sum('oct_amount');
											$nov_amount=$row5->sum('nov_amount');
											$dec_amount=$row5->sum('dec_amount');										
											$q1_amount=$jan_amount + $feb_amount + $mar_amount;										
											$q2_amount=$apr_amount + $may_amount + $jun_amount;										
											$q3_amount=$jul_amount + $aug_amount + $sep_amount;										
											$q4_amount=$oct_amount + $nov_amount + $dec_amount;										
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
													$jan_amount=$row6->sum('jan_amount'); 
													$feb_amount=$row6->sum('feb_amount');
													$mar_amount=$row6->sum('mar_amount');
													$apr_amount=$row6->sum('apr_amount');
													$may_amount=$row6->sum('may_amount');
													$jun_amount=$row6->sum('jun_amount');
													$jul_amount=$row6->sum('jul_amount');
													$aug_amount=$row6->sum('aug_amount');
													$sep_amount=$row6->sum('sep_amount');
													$oct_amount=$row6->sum('oct_amount');
													$nov_amount=$row6->sum('nov_amount');
													$dec_amount=$row6->sum('dec_amount');												
													$q1_amount=$jan_amount + $feb_amount + $mar_amount;										
													$q2_amount=$apr_amount + $may_amount + $jun_amount;										
													$q3_amount=$jul_amount + $aug_amount + $sep_amount;										
													$q4_amount=$oct_amount + $nov_amount + $dec_amount;										
													$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
													<tr class="text-right">
														<td class="objspe1 font-italic">{{ $item6->object_specific }}</td>		
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
												<td class="objexp1">{{ $item5->object_expenditure }}</td>		
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
												<td class="text-center" width="10px">	
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
											$annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;
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
														<td class="objspe1 font-italic">{{ $item6->object_specific }}</td>		
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
														<td class="text-center" width="10px">					
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
									$jan_subactivity_total=$row3->sum('jan_amount');
									$feb_subactivity_total=$row3->sum('feb_amount');
									$mar_subactivity_total=$row3->sum('mar_amount');
									$apr_subactivity_total=$row3->sum('apr_amount');
									$may_subactivity_total=$row3->sum('may_amount');
									$jun_subactivity_total=$row3->sum('jun_amount');
									$jul_subactivity_total=$row3->sum('jul_amount');
									$aug_subactivity_total=$row3->sum('aug_amount');
									$sep_subactivity_total=$row3->sum('sep_amount');
									$oct_subactivity_total=$row3->sum('oct_amount');
									$nov_subactivity_total=$row3->sum('nov_amount');
									$dec_subactivity_total=$row3->sum('dec_amount');										
									$q1_subactivity_total=$jan_subactivity_total + $feb_subactivity_total + $mar_subactivity_total;										
									$q2_subactivity_total=$apr_subactivity_total + $may_subactivity_total + $jun_subactivity_total;										
									$q3_subactivity_total=$jul_subactivity_total + $aug_subactivity_total + $sep_subactivity_total;										
									$q4_subactivity_total=$oct_subactivity_total + $nov_subactivity_total + $dec_subactivity_total;										
									$annual_subactivity_total=$q1_subactivity_total + $q2_subactivity_total + $q3_subactivity_total + $q4_subactivity_total;?>		
									<tr class="text-right font-weight-bold gray-bg">
										<td>Total Subactivity</td>
										<td>&nbsp;&nbsp;{{ number_format($annual_subactivity_total, 2) }}</td>											 
										<td>&nbsp;&nbsp;{{ number_format($jan_subactivity_total, 2) }}</td>
										<td>&nbsp;&nbsp;{{ number_format($feb_subactivity_total, 2) }}</td>
										<td>&nbsp;&nbsp;{{ number_format($mar_subactivity_total, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($apr_subactivity_total, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($may_subactivity_total, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($jun_subactivity_total, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($jul_subactivity_total, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($aug_subactivity_total, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($sep_subactivity_total, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($oct_subactivity_total, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($nov_subactivity_total, 2) }}</td>	
										<td>&nbsp;&nbsp;{{ number_format($dec_subactivity_total, 2) }}</td>	
									</tr><?php
								}
							}														
							if(isset($item2->activity)){
								$jan_activity_total=$row2->sum('jan_amount');
								$feb_activity_total=$row2->sum('feb_amount');
								$mar_activity_total=$row2->sum('mar_amount');
								$apr_activity_total=$row2->sum('apr_amount');
								$may_activity_total=$row2->sum('may_amount');
								$jun_activity_total=$row2->sum('jun_amount');
								$jul_activity_total=$row2->sum('jul_amount');
								$aug_activity_total=$row2->sum('aug_amount');
								$sep_activity_total=$row2->sum('sep_amount');
								$oct_activity_total=$row2->sum('oct_amount');
								$nov_activity_total=$row2->sum('nov_amount');
								$dec_activity_total=$row2->sum('dec_amount');										
								$q1_activity_total=$jan_activity_total + $feb_activity_total + $mar_activity_total;										
								$q2_activity_total=$apr_activity_total + $may_activity_total + $jun_activity_total;										
								$q3_activity_total=$jul_activity_total + $aug_activity_total + $sep_activity_total;										
								$q4_activity_total=$oct_activity_total + $nov_activity_total + $dec_activity_total;										
								$annual_activity_total=$q1_activity_total + $q2_activity_total + $q3_activity_total + $q4_activity_total;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td>Total Activity</td>
									<td>&nbsp;&nbsp;{{ number_format($annual_activity_total, 2) }}</td>											 
									<td>&nbsp;&nbsp;{{ number_format($jan_activity_total, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($feb_activity_total, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($mar_activity_total, 2) }}</td>														
									<td>&nbsp;&nbsp;{{ number_format($apr_activity_total, 2) }}</td>														
									<td>&nbsp;&nbsp;{{ number_format($may_activity_total, 2) }}</td>														
									<td>&nbsp;&nbsp;{{ number_format($jun_activity_total, 2) }}</td>														
									<td>&nbsp;&nbsp;{{ number_format($jul_activity_total, 2) }}</td>														
									<td>&nbsp;&nbsp;{{ number_format($aug_activity_total, 2) }}</td>														
									<td>&nbsp;&nbsp;{{ number_format($sep_activity_total, 2) }}</td>														
									<td>&nbsp;&nbsp;{{ number_format($oct_activity_total, 2) }}</td>														
									<td>&nbsp;&nbsp;{{ number_format($nov_activity_total, 2) }}</td>	
									<td>&nbsp;&nbsp;{{ number_format($dec_activity_total, 2) }}</td>	
								</tr><?php
							}
						}									
						if(isset($item1->pap)){
							$jan_pap_total=$row1->sum('jan_amount');
							$feb_pap_total=$row1->sum('feb_amount');
							$mar_pap_total=$row1->sum('mar_amount');
							$apr_pap_total=$row1->sum('apr_amount');
							$may_pap_total=$row1->sum('may_amount');
							$jun_pap_total=$row1->sum('jun_amount');
							$jul_pap_total=$row1->sum('jul_amount');
							$aug_pap_total=$row1->sum('aug_amount');
							$sep_pap_total=$row1->sum('sep_amount');
							$oct_pap_total=$row1->sum('oct_amount');
							$nov_pap_total=$row1->sum('nov_amount');
							$dec_pap_total=$row1->sum('dec_amount');										
							$q1_pap_total=$jan_pap_total + $feb_pap_total + $mar_pap_total;										
							$q2_pap_total=$apr_pap_total + $may_pap_total + $jun_pap_total;										
							$q3_pap_total=$jul_pap_total + $aug_pap_total + $sep_pap_total;										
							$q4_pap_total=$oct_pap_total + $nov_pap_total + $dec_pap_total;										
							$annual_pap_total=$q1_pap_total + $q2_pap_total + $q3_pap_total + $q4_pap_total;?>
							<tr class="text-right font-weight-bold gray-bg">
								<td>Total PAP</td>
								<td>&nbsp;&nbsp;{{ number_format($annual_pap_total, 2) }}</td>											 
								<td>&nbsp;&nbsp;{{ number_format($jan_pap_total, 2) }}</td>
								<td>&nbsp;&nbsp;{{ number_format($feb_pap_total, 2) }}</td>
								<td>&nbsp;&nbsp;{{ number_format($mar_pap_total, 2) }}</td>														
								<td>&nbsp;&nbsp;{{ number_format($apr_pap_total, 2) }}</td>														
								<td>&nbsp;&nbsp;{{ number_format($may_pap_total, 2) }}</td>														
								<td>&nbsp;&nbsp;{{ number_format($jun_pap_total, 2) }}</td>														
								<td>&nbsp;&nbsp;{{ number_format($jul_pap_total, 2) }}</td>														
								<td>&nbsp;&nbsp;{{ number_format($aug_pap_total, 2) }}</td>														
								<td>&nbsp;&nbsp;{{ number_format($sep_pap_total, 2) }}</td>														
								<td>&nbsp;&nbsp;{{ number_format($oct_pap_total, 2) }}</td>														
								<td>&nbsp;&nbsp;{{ number_format($nov_pap_total, 2) }}</td>
								<td>&nbsp;&nbsp;{{ number_format($dec_pap_total, 2) }}</td>
							</tr><?php 
						}
					}
				}
				foreach($data->groupBy('year') as $keyGTSum=>$rowGTSum){
					foreach($rowGTSum as $itemGTSum){}
						$jan_total=$rowGTSum->sum('jan_amount');
						$feb_total=$rowGTSum->sum('feb_amount');
						$mar_total=$rowGTSum->sum('mar_amount');
						$apr_total=$rowGTSum->sum('apr_amount');
						$may_total=$rowGTSum->sum('may_amount');
						$jun_total=$rowGTSum->sum('jun_amount');
						$jul_total=$rowGTSum->sum('jul_amount');
						$aug_total=$rowGTSum->sum('aug_amount');
						$sep_total=$rowGTSum->sum('sep_amount');
						$oct_total=$rowGTSum->sum('oct_amount');
						$nov_total=$rowGTSum->sum('nov_amount');
						$dec_total=$rowGTSum->sum('dec_amount');										
						$q1_total=$jan_total + $feb_total + $mar_total;										
						$q2_total=$apr_total + $may_total + $jun_total;										
						$q3_total=$jul_total + $aug_total + $sep_total;										
						$q4_total=$oct_total + $nov_total + $dec_total;										
						$annual_total=$q1_total + $q2_total + $q3_total + $q4_total;?>		
					<tr class="text-right font-weight-bold gray-bg">
						<td>GRAND TOTAL</td>
						<td>&nbsp;&nbsp;{{ number_format($annual_total, 2) }}</td>											 
						<td>&nbsp;&nbsp;{{ number_format($jan_total, 2) }}</td>
						<td>&nbsp;&nbsp;{{ number_format($feb_total, 2) }}</td>
						<td>&nbsp;&nbsp;{{ number_format($mar_total, 2) }}</td>														
						<td>&nbsp;&nbsp;{{ number_format($apr_total, 2) }}</td>														
						<td>&nbsp;&nbsp;{{ number_format($may_total, 2) }}</td>														
						<td>&nbsp;&nbsp;{{ number_format($jun_total, 2) }}</td>														
						<td>&nbsp;&nbsp;{{ number_format($jul_total, 2) }}</td>														
						<td>&nbsp;&nbsp;{{ number_format($aug_total, 2) }}</td>														
						<td>&nbsp;&nbsp;{{ number_format($sep_total, 2) }}</td>														
						<td>&nbsp;&nbsp;{{ number_format($oct_total, 2) }}</td>														
						<td>&nbsp;&nbsp;{{ number_format($nov_total, 2) }}</td>
						<td>&nbsp;&nbsp;{{ number_format($dec_total, 2) }}</td>
					</tr><?php
				}?>
			</tbody>
		</table> 
  </div>    
</div>

