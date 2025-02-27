<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - Division Budget Proposal</title>
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}" media="all">
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-6.1.1-web/css/all.min.css') }}">
		<style>
         td{
            font-size: 13px;
         }
         .mheader{
            font-size: 20px;
         }
			.subheader {
				font-size: 14px;
			} 
         .right-subheader {
				font-size: 11px;
			} 
		</style>
		<SCRIPT LANGUAGE="JavaScript">
			function printThis()
			{
            var css = '@page { size: portrait; }',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet){
            style.styleSheet.cssText = css;
            } else {
            style.appendChild(document.createTextNode(css));
            }

            head.appendChild(style);

				window.print();
			}
		</script>
	</head>
	<body>
		<?php
			$division_acronym = '';
         $fiscal_year1 = '';
         $fiscal_year2 = '';
         $fiscal_year3 = '';
			$user_id = auth()->user()->id; 
			$user_fullname = App\Models\ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();  
			$user_role = App\Models\ViewUsersModel::where('id', $user_id)->pluck('user_role')->first(); 
			$user_division_id = App\Models\ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
			$user_parent_division_id = App\Models\ViewUsersModel::where('id', $user_id)->pluck('parent_division_id')->first();
			if($user_parent_division_id == 5){
				$user_division_director = App\Models\ViewUsersHasRolesModel::where('parent_division_id', $user_parent_division_id)
					->where('role_id', 6)->where('is_active', 1)->where('is_deleted', 0)->pluck('fullname_last')->first(); 
				$user_division_director_position = "Division Director";
				$isOIC = App\Models\ViewUsersHasRolesModel::where('parent_division_id', $user_parent_division_id)
				->where('role_id', 6)->where('is_active', 1)->where('is_deleted', 0)->pluck('oic')->first();
			}
			else{
				$user_division_director = App\Models\ViewUsersHasRolesModel::where('division_id', $user_division_id)
					->where('role_id', 6)->where('is_active', 1)->where('is_deleted', 0)->pluck('fullname_last')->first(); 
				$user_division_director_position = "Division Director";
				$isOIC = App\Models\ViewUsersHasRolesModel::where('division_id', $user_division_id)
					->where('role_id', 6)->where('is_active', 1)->where('is_deleted', 0)->pluck('oic')->first(); 
			}
			if($isOIC==1){
				$user_division_director_position = "Division Director/OIC";
			}
			$sqlBP = getBudgetProposal($division_id, $year);	
			foreach($sqlBP as $row){
				$division_acronym = $row->division_acronym;
				$fiscal_year1 = $row->fiscal_year1;
				$fiscal_year2 = $row->fiscal_year2;
				$fiscal_year3 = $row->fiscal_year3;
			}
			
		?>	
		<button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
		<br><br>
		<h5>FY {{ $fiscal_year1}}-{{ $fiscal_year3 }} BUDGET PROPOSAL <br>
		{{ $division_acronym }}</h5>
		<table id="budget_proposal_table" class="table-bordered table-hover" style="width: 100%;">
			<thead class="text-center">
				<th>ACTIVITY / Object of Expenditures</th>
				<th>{{ $fiscal_year1 }}</th>
				<th>{{ $fiscal_year2 }}</th>
				<th>{{ $fiscal_year3 }}</th>
			</thead>		
			<tbody><?php
				$data = DB::table('view_budget_proposals')->where('year', $year)
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

				$data1 = DB::table('view_budget_proposals')->where('year', $year)->where('division_id',$division_id)
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
					foreach($data->where('allotment_class_id', $item->allotment_class_id)->groupBY('pap_code') as $key1=>$row1){
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
									</tr>
									<?php
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
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				{{-- <tr>
					<td colspan="4"><span class="wpooled">Note: Items with 'Pooled at' are not included 
						in the total computation of the budget proposal of your division.
					</span>
					</td>
				</tr> --}}
				<?php 
				//With Pooled At
				foreach($data1->groupBY('pap_id') as $key=>$row){			
					foreach($row as $item) {} //item?>
					<tr>
						<td class="font-weight-bold gray1-bg" colspan="4">{{ $item->pap }} - {{ $item->pap_code }}</td>										
					</tr><?php
					foreach($data1->where('pap_id', $item->pap_id)->groupBY('activity_id') as $key1=>$row1){
						foreach($row1 as $item1) {} //item 1?>
						<tr>
							<td class="activity font-weight-bold" colspan="4">{{ $item1->activity }}</td>													
						</tr><?php 	
						foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
							->groupBY('subactivity_id') as $key2=>$row2){
							foreach($row2 as $item2) {} 
							if(isset($item2->subactivity)){//item 2?>
								<tr>
									<td class="subactivity font-weight-bold" colspan="4">{{ $item2->subactivity }}</td>													
								</tr><?php 
							}												
							foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
								->where('subactivity_id', $item2->subactivity_id)
								->groupBY('allotment_class_id') as $key3=>$row3){
								foreach($row3 as $item3) {}//item 3?>
								<tr>
									<td class="aclass font-weight-bold" colspan="4">{{ $item3->allotment_class }} ({{ $item3->allotment_class_acronym }})</td>													
								</tr><?php 																									
								foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
									->where('subactivity_id', $item2->subactivity_id)
									->where('allotment_class_id', $item3->allotment_class_id)
									->groupBY('expense_account_id') as $key4=>$row4){																		
									foreach($row4 as $item4) { }//item 4	?>
									<tr class="text-right font-weight-bold gray-bg">
										<td class="expense">{{ $item4->expense_account }}</td>
										<td>{{ number_format($row4->sum('fy1_amount'), 2) }}</td>													
										<td>{{ number_format($row4->sum('fy2_amount'), 2) }}</td>													
										<td>{{ number_format($row4->sum('fy3_amount'), 2) }}</td>	
									</tr><?php 	
									foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
										->where('subactivity_id', $item2->subactivity_id)
										->where('allotment_class_id', $item3->allotment_class_id)
										->where('expense_account_id', $item4->expense_account_id)												
										->groupBY('object_expenditure_id') as $key5=>$row5){
										foreach($row5 as $item5) {}//item 5?>
										<tr class="text-right"><?php
											if($item5->object_specific_id == NULL || $item5->object_specific_id == 0 || $item5->object_specific_id == ''){?>
												<td class="objexp wpooled">{{ $item5->object_expenditure }}
													@if($item5->pooled_at_division_id != '') - Pooled at {{ $item5->pooled_at_division_acronym }} @endif</td>
												<td class="wpooled">{{ number_format($item5->fy1_amount, 2) }}</td>													
												<td class="wpooled">{{ number_format($item5->fy2_amount, 2) }}</td>													
												<td class="wpooled">{{ number_format($item5->fy3_amount, 2) }}</td>
												@if($active_status_id==1 || $active_status_id==5 || $active_status_id==7 || $active_status_id==29)
													
												@endif<?php 
											}else{?>
												<td class="objexp" colspan="4">{{ $item5->object_expenditure }}</td><?php
											}?>										
										</tr><?php 
											if($item5->object_specific_id != NULL || $item5->object_specific_id != 0 || $item5->object_specific_id != ''){																	
												foreach($data1->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
													->where('subactivity_id', $item2->subactivity_id)
													->where('allotment_class_id', $item3->allotment_class_id)
													->where('expense_account_id', $item4->expense_account_id)
													->where('object_expenditure_id', $item5->object_expenditure_id)
													->groupBy('object_specific') as $key6=>$row6){
													foreach($row6 as $item6) { } //item 6 ?>
													<tr class="text-right">
														<td class="objspe wpooled @if($item6->object_specific==NULL)  @else font-italic @endif">
															@if($item6->object_specific==NULL) {{ $item6->object_expenditure }}
															@else {{ $item6->object_specific }} 
															@endif
															@if($item6->pooled_at_division_id != '') 
																- Pooled at {{ $item6->pooled_at_division_acronym }} @endif</td>													
														<td class="wpooled">{{ number_format($item6->fy1_amount, 2) }}</td>													
														<td class="wpooled">{{ number_format($item6->fy2_amount, 2) }}</td>													
														<td class="wpooled">{{ number_format($item6->fy3_amount, 2) }}</td>															
													</tr><?php 
												}
											}
									}
								}
							}
						} 										
					}					
				}?>
			</tbody>
		</table>
		<br>
		<table class="table-borderless" style="width: 100%;">
			<tr>
				<td>Prepared By:</td>
				<td>Approved By:</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr class="text-center">
				<td>__________________________________</td>
				<td>__________________________________</td>
			</tr>
			<tr class="text-center">
				@if($division_id==3)
				   <td>{{ strtoupper($user_fullname) }}</td>
				   <td>ROSETE, EDLYNE A.</td>
            @else
               <td>{{ strtoupper($user_fullname) }}</td>
               <td>{{ strtoupper($user_division_director) }}</td>
            @endif
			</tr>
			<tr class="text-center">
				@if($division_id==3)
					<td style="font-size:11px;">{{ $user_role }}</td>
					<td style="font-size:11px;">Audit Team Leader</td>
				@else
					<td style="font-size:11px;">{{ $user_role }}</td>
					<td style="font-size:11px;">{{ $user_division_director_position }}</td>
				@endif
			</tr>	
		</table>
		<br> 
	</body>
</html> 