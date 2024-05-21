<h4>{{ $value->division_acronym }}</h4>
@php
	$division_id=$value->id;	
@endphp
<div class="content">
  <div class="row">
    <div class="col">
		<span class='badge badge-success' style='font-size:15px'>{{ $status ?? ""}}</span>
    </div>
	 <div class="col-3">
		
	 </div>
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
			</thead>		
			<tbody><?php
				$data = DB::table('view_quarterly_obligation_programs')->where('cluster_id', $division_id)->where('year', $year_selected)
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
									foreach($row4 as $item4) {}//item 4
									$q1_expense_total=$row4->sum('q1_amount');
									$q2_expense_total=$row4->sum('q2_amount');
									$q3_expense_total=$row4->sum('q3_amount');
									$q4_expense_total=$row4->sum('q4_amount');																
									$annual_expense_total=$q1_expense_total + $q2_expense_total + $q3_expense_total + $q4_expense_total;									
									$annual_expense_total=$q1_expense_total + $q2_expense_total + $q3_expense_total + $q4_expense_total;?>
									<tr>
										<td class="expense1 font-weight-bold" colspan="6">{{ $item4->expense_account }}</td>														
									</tr><?php														
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
								if(isset($item3->subactivity)){
									$q1_subactivity_total=$row3->sum('q1_amount');									
									$q2_subactivity_total=$row3->sum('q3_amount');									
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
									<td>Total Activity, {{ $item2->activity }}</td>
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

