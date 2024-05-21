
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - Cluster Budget Proposal</title>
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}" media="all">
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-6.1.1-web/css/all.min.css') }}">
		<style>
			/* td, th {
				font-size: 12px;
			} */			
		</style>
		<SCRIPT LANGUAGE="JavaScript">
			function printThis()
			{
				window.print();
			}
		</script>
	</head>
	<body>
		<div class="wrapper">
			<button class="noprint btn float-right" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
				title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
			<?php
				$user_id = auth()->user()->id; 
				$user_fullname = App\Models\ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();  
				$user_role = App\Models\ViewUsersModel::where('id', $user_id)->pluck('user_role')->first(); 
				$user_division_id = App\Models\ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
				$user_division_acronym = App\Models\ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
				$user_division_director = App\Models\ViewUsersModel::where('division_id', $user_division_id)
					->where('user_role_id', 6)->pluck('fullname_last')->first();
				$sqlBP = getClusterBudgetProposal($user_division_id, $year);	
				foreach($sqlBP as $row){
					$year=$row->year;
					$fiscal_year1=$row->fiscal_year1;
					$fiscal_year2=$row->fiscal_year2;
					$fiscal_year3=$row->fiscal_year3;
				} 
			?>	
			<h4>{{ $user_division_acronym }} CLUSTER BUDGET PROPOSAL</h4>
			FY {{ $fiscal_year1 }}-{{ $fiscal_year3 }} BUDGET PROPOSAL <br>		
			<br>
			<table id="budget_proposal_table" class="table-bordered table-hover" style="width: 100%;">
				<thead class="text-center">
					<th>ACTIVITY / Object of Expenditures</th>
					<th>{{ $fiscal_year1 }}</th>
					<th>{{ $fiscal_year2 }}</th>
					<th>{{ $fiscal_year3 }}</th>
				</thead>		
				<tbody><?php
					$data = DB::table('view_budget_proposals')->where('year', $year)
						->where(function ($query) use ($user_division_id){
							$query->where(function ($query) use ($user_division_id){
									$query->where('cluster_id', $user_division_id)
										->whereNull('cluster_id_pooled_at_division_id');
								})
								->orWhere(function ($query) use ($user_division_id){
									$query->where('cluster_id','!=',$user_division_id)
										->where('cluster_id_pooled_at_division_id', $user_division_id);
								});
						})
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')
						->orderBy('object_specific','ASC')->groupBy('id')->get();

					$data1 = DB::table('view_budget_proposals')->where('cluster_id', $user_division_id)->where('year', $year)
						->where('is_active', 1)->where('is_deleted', 0)
						->where(function ($query) use ($user_division_id){
							$query->whereNotNull('cluster_id_pooled_at_division_id')
								->where('cluster_id_pooled_at_division_id','!=',$user_division_id);
						})
						->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')
						->orderBy('object_specific','ASC')->groupBy('id')->get();
					

					foreach($data->groupBY('pap_id') as $key=>$row){			
						foreach($row as $item) {} //item?>
						<tr>
							<td class="font-weight-bold gray1-bg" colspan="4">{{ $item->pap }}</td>
						</tr><?php
						foreach($data->where('pap_id', $item->pap_id)->groupBY('activity_id') as $key1=>$row1){
							foreach($row1 as $item1) {} //item 1?>
							<tr>
								<td class="activity font-weight-bold" colspan="4">{{ $item1->activity }}</td>													
							</tr><?php 	
							foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
								->groupBY('subactivity_id') as $key2=>$row2){
								foreach($row2 as $item2) {} 
								if(isset($item2->subactivity)){//item 2?>
									<tr>
										<td class="subactivity font-weight-bold" colspan="4">{{ $item2->subactivity }}</td>													
									</tr><?php 
								}												
								foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
									->where('subactivity_id', $item2->subactivity_id)->groupBY('allotment_class_id') as $key3=>$row3){
									foreach($row3 as $item3) {}//item 3?>
									<tr>
										<td class="aclass font-weight-bold" colspan="4">{{ $item3->allotment_class }} ({{ $item3->allotment_class_acronym }})</td>													
									</tr><?php 													
									foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
										->where('subactivity_id', $item2->subactivity_id)
										->where('allotment_class_id', $item3->allotment_class_id)
										->groupBY('expense_account_id') as $key4=>$row4){															
										foreach($row4 as $item4) { }//item 4?>
										<tr class="text-right font-weight-bold gray-bg">
											<td class="expense">{{ $item4->expense_account }}</td>													
											<td>{{ number_format($row4->sum('fy1_amount'), 2) }}</td>													
											<td>{{ number_format($row4->sum('fy2_amount'), 2) }}</td>													
											<td>{{ number_format($row4->sum('fy3_amount'), 2) }}</td>													
										</tr><?php 														
										foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
											->where('subactivity_id', $item2->subactivity_id)
											->where('allotment_class_id', $item3->allotment_class_id)
											->where('expense_account_id', $item4->expense_account_id)
											->groupBY('object_expenditure_id') as $key5=>$row5){
											foreach($row5 as $item5) {}//item 5?>
											<tr class="text-right"><?php
												if($item5->object_specific_id == NULL || $item5->object_specific_id == 0 || $item5->object_specific_id == ''){?>
													<td class="objexp">{{ $item5->object_expenditure }}
														@if($item5->pooled_at_division_id != '') 
															- Pooled at {{ $item5->pooled_at_division_acronym }} ({{ $item5->division_acronym }})@endif</td>
													<td>{{ number_format($item5->fy1_amount, 2) }}</td>													
													<td>{{ number_format($item5->fy2_amount, 2) }}</td>													
													<td>{{ number_format($item5->fy3_amount, 2) }}</td><?<?php 
												}else{?>
													<td class="objexp" colspan="4">{{ $item5->object_expenditure }}</td><?php
												}?>										
											</tr><?php 
											if($item5->object_specific_id != NULL || $item5->object_specific_id != 0 || $item5->object_specific_id != ''){																	
												foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
													->where('subactivity_id', $item2->subactivity_id)
													->where('allotment_class_id', $item3->allotment_class_id)
													->where('expense_account_id', $item4->expense_account_id)
													->where('object_expenditure_id', $item5->object_expenditure_id)
													->groupBy('object_specific') as $key6=>$row6){
													foreach($row6 as $item6) { }//item 6?>
													<tr class="text-right">
														<td class="objspe @if($item6->object_specific==NULL)  @else font-italic @endif">
															@if($item6->object_specific==NULL) {{ $item6->object_expenditure }}
															@else {{ $item6->object_specific }} 
															@endif
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
									if(isset($item2->subactivity)){?>
										<tr class="text-right font-weight-bold gray-bg">
											<td class="subactivity">Sub-Total Subactivity</td>
											<td>{{ number_format($row2->sum('fy1_amount'), 2) }}</td>
											<td>{{ number_format($row2->sum('fy2_amount'), 2) }}</td>
											<td>{{ number_format($row2->sum('fy3_amount'), 2) }}</td>
										</tr><?php
									}
								}
							} 
							if(isset($item1->activity)){?>
								<tr class="text-right font-weight-bold gray-bg">
									<td class="activity">Sub-Total Activity</td>
									<td>{{ number_format($row1->sum('fy1_amount'), 2) }}</td>
									<td>{{ number_format($row1->sum('fy2_amount'), 2) }}</td>
									<td>{{ number_format($row1->sum('fy3_amount'), 2) }}</td>
								</tr><?php
							}
						}		
						if(isset($item->pap)){?>
							<tr class="text-right font-weight-bold gray-bg">
								<td class="text-left">TOTAL PAP</td>
								<td>{{ number_format($row->sum('fy1_amount'), 2) }}</td>
								<td>{{ number_format($row->sum('fy2_amount'), 2) }}</td>
								<td>{{ number_format($row->sum('fy3_amount'), 2) }}</td>
							</tr><?php 
						}
					}
					foreach($data->groupBy('year') as $keyBPSum=>$rowBPSum){
						foreach($rowBPSum as $itemBPSum){}?>
						<tr class="text-right font-weight-bold gray-bg">
							<td class="text-left">GRAND TOTAL</td>
							<td>{{ number_format($rowBPSum->sum('fy1_amount'), 2) }}</td>
							<td>{{ number_format($rowBPSum->sum('fy2_amount'), 2) }}</td>
							<td>{{ number_format($rowBPSum->sum('fy3_amount'), 2) }}</td>
						</tr><?php
					}?>
				</tbody>
			</table>
			<br>
			<table style="width: 100%;">
				<tr>
					<td>Prepared By:</td>
					{{-- <td>Approved By:</td> --}}
				</tr>
				<tr>
					<td></td>
					{{-- <td></td> --}}
				</tr>
				<tr>
					<td></td>
					{{-- <td></td> --}}
				</tr>
				<tr>
					<td></td>
					{{-- <td></td> --}}
				</tr>
				<tr class="text-center">
					<td>______________________________</td>
					{{-- <td>______________________________</td> --}}
				</tr>
				<tr class="text-center">
					<td>{{ strtoupper($user_fullname) }}</td>
					{{-- <td>{{ strtoupper($user_division_director) }}</td> --}}
				</tr>
				<tr class="text-center">
					<td style="font-size:14px;">{{ $user_role }}</td>
					{{-- <td style="font-size:11px;">Division Director</td> --}}
				</tr>	
			</table>
		</div>
	</body>
</html>
					