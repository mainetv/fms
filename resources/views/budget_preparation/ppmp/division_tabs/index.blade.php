<h4>{{ $value->division_acronym }}</h4>
<div class="content">
  <div class="row">
    <div class="col">
    </div>
  </div>
</div>
<div class="row py-3">
  <div class="col table-responsive">
    <table id="budget_proposal_table" class="table table-sm table-bordered table-responsive-sm table-hover" style="width: 100%;">
      <thead class="text-center">
			<th>ACTIVITY / Object of Expenditures</th> 
			<?php 
				$division=$value->division_id;	
				// echo $year_selected; 
            // echo $division; 
				$sql = getBudgetProposal($division, $year_selected);
				foreach($sql as $row){						
					$budget_proposal_id=$row->id;
					$fiscal_year1=$row->fiscal_year1;
					$fiscal_year2=$row->fiscal_year2;
					$fiscal_year3=$row->fiscal_year3;
					$sql1 = "";		?>
					<th>{{ $fiscal_year1 }}</th>
					<th>{{ $fiscal_year2 }}</th>
					<th>{{ $fiscal_year3 }}</th>				
					<th>
						<button id="add_new_pap" type="button" class="btn-xs btn-light" 
						data-id="{{ $budget_proposal_id }}" data-toggle="modal" data-target="#pap_modal" >
						Add PAP</button>
					</th>
					<?php 
				} 
			?>
		</thead>		
      <tbody class="table-borderless"> 			
			<?php		
				$sql1 = getPAP($division, $year_selected);	
				foreach($sql1 as $row1)
				{
					$bp_pap_id=$row1->bp_pap_id;
					$pap_code=$row1->pap_code;
					$pap=$row1->pap;?>
					<tr>
						<td class="font-weight-bold" colspan="4">{{ $pap_code }} - {{ $pap }}			
							<button id="add_new_activity" type="button" class="btn-xs btn-light" 
							data-id="{{ $bp_pap_id }}" data-toggle="modal" data-target="#activity_modal">
							Add Activity</button>
						</td>
						<td></td>
					</tr>
					<?php
					$sql2 = getActivityByPAP($bp_pap_id);	
					foreach($sql2 as $row2){
						$id=$row2->id;
						$activity=$row2->activity;
						$bp_activity_id=$row2->id;?>
						<tr>	
							<td class="second" colspan="4">{{ $activity }}
								<button id="add_new_subactivity" type="button" class="btn-xs btn-light" 
								data-id="{{ $bp_activity_id }}" data-toggle="modal" data-target="#subactivity_modal">
								Add Subactivity{{ $bp_activity_id }}</button>
								<button id="add_new_expenditure_activity" type="button" class="btn-xs btn-light" 
									data-id="{{ $bp_activity_id }}" data-toggle="modal" data-target="#expenditure_modal_activity">
									Add Expenditure{{ $bp_activity_id }}</button>
							</td>	
							<td></td>
						</tr>
						<?php
						$sql3 = getSubactivityByActivity($bp_activity_id);						
						$sql6 = getExpenditureByActivity($bp_activity_id);
						foreach($sql6 as $row6){
							$expenditure=$row6->expenditure;
							$fy1_amount=$row6->fy1_amount;
							$fy2_amount=$row6->fy2_amount;
							$fy3_amount=$row6->fy3_amount;		?>
							<tr>
								<td class="fourth">{{ $expenditure }}</td>
								<td class="fourth font-weight-bold">{{ number_format($fy1_amount, 2) }}</td>					
								<td class="fourth font-weight-bold">{{ number_format($fy2_amount, 2) }}</td>					
								<td class="fourth font-weight-bold">{{ number_format($fy3_amount, 2) }}</td>					
							</tr>
							<?php
						}					
						foreach($sql3 as $row3){
							$subactivity=$row3->subactivity;
							$budget_proposal_subactivity_id=$row3->id;?>
							<tr>
								<td class="third" colspan="4">{{ $subactivity }} 
									<button id="add_new_expenditure_subactivity" type="button" class="btn-xs btn-light" 
									data-id="{{ $budget_proposal_subactivity_id }}" data-toggle="modal" data-target="#expenditure_modal_subactivity">
									Add Expenditure</button>
								</td>	
								<td></td>						
							</tr>
							<?php
							$sql4 = getExpenditureBySubactivity($budget_proposal_subactivity_id);						
							foreach($sql4 as $row4){
								$expenditure=$row4->expenditure;
								$fy1_amount=$row4->fy1_amount;
								$fy2_amount=$row4->fy2_amount;
								$fy3_amount=$row4->fy3_amount;										
								?>
								<tr>
									<td class="fourth">{{ $expenditure }}</td>
									<td class="fourth font-weight-bold">{{ number_format($fy1_amount, 2) }}</td>
									<td class="fourth font-weight-bold">{{ number_format($fy2_amount, 2) }}</td>
									<td class="fourth font-weight-bold">{{ number_format($fy3_amount, 2) }}</td>							
								</tr>
								<?php
							}	
						}	
						$sql5 = getExpenditureActivitySum($bp_activity_id);					
						foreach($sql5 as $row5 => $key5){
							$fy1_activity_total=$key5->fy1_amount;
							$fy2_activity_total=$key5->fy2_amount;
							$fy3_activity_total=$key5->fy3_amount;
						}
						?>
						<tr class="text-right">
							<td class="font-weight-bold">Total Activity</td>
							<td class="font-weight-bold">{{ number_format($fy1_activity_total, 2) }}</td>
							<td class="font-weight-bold">{{ number_format($fy2_activity_total, 2) }}</td>
							<td class="font-weight-bold">{{ number_format($fy3_activity_total, 2) }}</td>
						</tr>
						<?php	
					}
					$sql6 = getExpenditurePAPSum($bp_pap_id);					
					foreach($sql6 as $row6 => $key6){
						$fy1_pap_total=$key6->fy1_amount;
						$fy2_pap_total=$key6->fy2_amount;
						$fy3_pap_total=$key6->fy3_amount;
					}?>
					<tr class="text-right">
						<td class="font-weight-bold">Total PAP</td>
						<td class="font-weight-bold">{{ number_format($fy1_pap_total, 2) }}</td>
						<td class="font-weight-bold">{{ number_format($fy2_pap_total, 2) }}</td>
						<td class="font-weight-bold">{{ number_format($fy3_pap_total, 2) }}</td>
					</tr>
					<tr>
						<td colspan=4><hr></td>
					</tr>
					<?php
				}							
			?>		
      </tbody>
	</table>	 
  </div>    
</div>

