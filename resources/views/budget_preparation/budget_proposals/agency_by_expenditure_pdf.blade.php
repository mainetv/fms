
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - Agency Budget Proposal</title>
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}" media="all">
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-6.1.1-web/css/all.min.css') }}">
		<style>
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
		<div class="wrapper">
			<button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
				title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button><br><?php
			$fiscal_year1 = '';
			$fiscal_year2 = '';
			$fiscal_year3 = '';
			$sqlBP = getAgencyBudgetProposal($year);	
			foreach($sqlBP as $row){
				$fiscal_year1 = $row->fiscal_year1;
				$fiscal_year2 = $row->fiscal_year2;
				$fiscal_year3 = $row->fiscal_year3;
			}			
			$user_id = auth()->user()->id; 
			$user_fullname = App\Models\ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();  
			$user_role = App\Models\ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();  ?>	
			<center><h4>DOST-Philippine Council for Agriculture, Aquatic and Natural Resources Research and Development (DOST-PCAARRD)</h4>
			<h5> FY {{ $fiscal_year1 }} - {{ $fiscal_year3 }} Budget Proposal</h5>
			(In Thousand Pesos)			
			</center><br>		
			<table id="budget_proposal_table" class="table-bordered table-hover" style="width: 100%;">
				<thead class="text-center">
					<th>PAP / Object of Expenditures</th>
					<th>{{ $fiscal_year1 }}</th>
					<th>{{ $fiscal_year2 }}</th>
					<th>{{ $fiscal_year3 }}</th>
				</thead>		
				<tbody id="budget_proposal" class="table-bordered table-hover" style="width: 100%;">
					<tr>
						<td class="font-weight-bold" colspan="4">MAINTENANCE AND OTHER OPERATING EXPENSES (MOOE)</td>
					</tr>
					<tr>
						<td class="font-weight-bold" colspan="4">TIER 1</td>
					</tr><?php
					//MOOE Tier 1
					$data_t1 = DB::table('view_budget_proposals')->where('year', $year)
						->where('is_active', 1)->where('is_deleted', 0)->where('allotment_class_id', 2)
						->where(function ($query) {
							$query->where('tier','=',1)
								->orWhere('tier','=',0)
								->orWhereNull('tier');
						})
						->orderBy('pap_code', 'ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->groupBy('id')->get();	

					foreach($data_t1->groupBY('pap_id') as $key=>$row){			
						foreach($row as $item) {} //item?>									
						<tr>
							<td class="font-weight-bold gray1-bg" colspan="4">{{ $item->pap }} - {{ $item->pap_code }}</td>										
						</tr><?php
						//all except subsidy nga
						foreach($data_t1->where('pap_id', $item->pap_id)->where('expense_account_id', '!=', 4)
							->groupBY('expense_account_id') as $key1=>$row1){
							foreach($row1 as $item1) {} //item 1
								$fy1_expense = $row1->sum('fy1_amount');
								$fy2_expense = $row1->sum('fy2_amount');
								$fy3_expense = $row1->sum('fy3_amount'); ?>
							<tr class="font-weight-bold text-right font-weight-bold gray-bg">
								<td class="subactivity">{{ $item1->expense_account}}</td>
								<td>{{ number_format($fy1_expense, 2) }}</td>													
								<td>{{ number_format($fy2_expense, 2) }}</td>													
								<td>{{ number_format($fy3_expense, 2) }}</td>													
							</tr><?php 	
							foreach($data_t1->where('pap_id', $item->pap_id)
								->where('expense_account_id', $item1->expense_account_id)
								->groupBY('object_expenditure_id') as $key2=>$row2){
								foreach($row2 as $item2) {} //item 2
								$fy1_expenditure = $row2->sum('fy1_amount');
								$fy2_expenditure = $row2->sum('fy2_amount');
								$fy3_expenditure = $row2->sum('fy3_amount'); ?>
								<tr class="text-right">
									<td class="expense">{{ $item2->object_code }}: {{ $item2->object_expenditure }}</td>													
									<td>{{ number_format($fy1_expenditure, 2) }}</td>													
									<td>{{ number_format($fy2_expenditure, 2) }}</td>													
									<td>{{ number_format($fy3_expenditure, 2) }}</td>																
								</tr><?php 
							}	
						}	
						
						//subsidy nga non rd
						foreach($data_t1->where('pap_id', $item->pap_id)->where('division_id', '!=', 20)->where('expense_account_id', 4)
							->groupBY('expense_account_id') as $key1=>$row1){
							foreach($row1 as $item1) {} //item 1
								$fy1_expense = $row1->sum('fy1_amount');
								$fy2_expense = $row1->sum('fy2_amount');
								$fy3_expense = $row1->sum('fy3_amount'); ?>
							<tr class="font-weight-bold text-right font-weight-bold gray-bg">
								<td class="subactivity">Capacity Building - {{ $item1->expense_account}}</td>
								<td>{{ number_format($fy1_expense, 2) }}</td>													
								<td>{{ number_format($fy2_expense, 2) }}</td>													
								<td>{{ number_format($fy3_expense, 2) }}</td>													
							</tr><?php 	
							foreach($data_t1->where('pap_id', $item->pap_id)->where('division_id', '!=', 20)->where('expense_account_id', 4)
								->groupBY('object_expenditure_id') as $key2=>$row2){
								foreach($row2 as $item2) {} //item 2
								$fy1_expenditure = $row2->sum('fy1_amount');
								$fy2_expenditure = $row2->sum('fy2_amount');
								$fy3_expenditure = $row2->sum('fy3_amount'); ?>
								<tr class="text-right">
									<td class="expense">{{ $item2->object_code }}: {{ $item2->object_expenditure }}</td>													
									<td>{{ number_format($fy1_expenditure, 2) }}</td>													
									<td>{{ number_format($fy2_expenditure, 2) }}</td>													
									<td>{{ number_format($fy3_expenditure, 2) }}</td>																
								</tr><?php 
							}	
						}

						//subsidy nga rd
						foreach($data_t1->where('pap_id', $item->pap_id)->where('division_id', 20)->where('expense_account_id', 4)
							->groupBY('expense_account_id') as $key1=>$row1){
							foreach($row1 as $item1) {} //item 1
								$fy1_expense = $row1->sum('fy1_amount');
								$fy2_expense = $row1->sum('fy2_amount');
								$fy3_expense = $row1->sum('fy3_amount'); ?>
							<tr class="font-weight-bold text-right font-weight-bold gray-bg">
								<td class="subactivity">{{ $item1->activity }} - {{ $item1->expense_account}}</td>
								<td>{{ number_format($fy1_expense, 2) }}</td>													
								<td>{{ number_format($fy2_expense, 2) }}</td>													
								<td>{{ number_format($fy3_expense, 2) }}</td>													
							</tr><?php 	
							foreach($data_t1->where('pap_id', $item->pap_id)->where('division_id', 20)->where('expense_account_id', 4)
								->groupBY('object_expenditure_id') as $key2=>$row2){
								foreach($row2 as $item2) {} //item 2
								$fy1_expenditure = $row2->sum('fy1_amount');
								$fy2_expenditure = $row2->sum('fy2_amount');
								$fy3_expenditure = $row2->sum('fy3_amount'); ?>
								<tr class="text-right">
									<td class="expense">{{ $item2->object_code }}: {{ $item2->object_expenditure }}</td>													
									<td>{{ number_format($fy1_expenditure, 2) }}</td>													
									<td>{{ number_format($fy2_expenditure, 2) }}</td>													
									<td>{{ number_format($fy3_expenditure, 2) }}</td>																
								</tr><?php 
							}	
						}
								
						if(isset($item->pap)){
							$fy1_pap = $row->sum('fy1_amount');
							$fy2_pap = $row->sum('fy2_amount');
							$fy3_pap = $row->sum('fy3_amount'); ?>
							<tr class="text-right font-weight-bold gray-bg">
								<td>TOTAL PAP, {{ $item->pap }}</td>
								<td>{{ number_format($fy1_pap, 2) }}</td>			
								<td>{{ number_format($fy2_pap, 2) }}</td>			
								<td>{{ number_format($fy3_pap, 2) }}</td>			
							</tr><?php 
						}									
					}
					
					//MOOE Tier 1 Total								
					foreach($data_t1->groupBy('year') as $key_mooe_t1=>$row_mooe_t1){
						$fy1_mooe_t1 = $row_mooe_t1->sum('fy1_amount');
						$fy2_mooe_t1 = $row_mooe_t1->sum('fy2_amount');
						$fy3_mooe_t1 = $row_mooe_t1->sum('fy3_amount'); ?>
						<tr class="text-right font-weight-bold gray-bg">
							<td>TOTAL TIER 1 MOOE</td>
							<td>{{ number_format($fy1_mooe_t1, 2) }}</td>	
							<td>{{ number_format($fy2_mooe_t1, 2) }}</td>	
							<td>{{ number_format($fy3_mooe_t1, 2) }}</td>	
						</tr><?php
					}?>

					<tr>
						<td class="font-weight-bold" colspan="4">TIER 2</td>
					</tr><?php

					//MOOE Tier 2
					$data_t2 = DB::table('view_budget_proposals')->where('year', $year)
						->where('is_active', 1)->where('is_deleted', 0)->where('allotment_class_id', 2)
						->where('tier', 2)->orderBy('pap_code', 'ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->groupBy('id')->get();	

					foreach($data_t2->groupBY('pap_id') as $key=>$row){			
						foreach($row as $item) {} //item?>									
						<tr>
							<td class="font-weight-bold gray1-bg" colspan="4">{{ $item->pap }} - {{ $item->pap_code }}</td>										
						</tr><?php
						foreach($data_t2->where('pap_id', $item->pap_id)->groupBY('expense_account_id') as $key1=>$row1){
							foreach($row1 as $item1) {} //item 1
								$fy1_expense = $row1->sum('fy1_amount');
								$fy2_expense = $row1->sum('fy2_amount');
								$fy3_expense = $row1->sum('fy3_amount'); ?>
							<tr class="font-weight-bold text-right font-weight-bold gray-bg">
								<td class="subactivity">{{ $item1->expense_account}}</td>
								<td>{{ number_format($fy1_expense, 2) }}</td>													
								<td>{{ number_format($fy2_expense, 2) }}</td>													
								<td>{{ number_format($fy3_expense, 2) }}</td>													
							</tr><?php 	
							foreach($data_t2->where('pap_id', $item->pap_id)->where('expense_account_id', $item1->expense_account_id)
								->groupBY('object_expenditure_id') as $key2=>$row2){
								foreach($row2 as $item2) {} //item 2
								$fy1_expenditure = $row2->sum('fy1_amount');
								$fy2_expenditure = $row2->sum('fy2_amount');
								$fy3_expenditure = $row2->sum('fy3_amount'); ?>
								<tr class="text-right">
									<td class="expense">{{ $item2->object_code }}: {{ $item2->object_expenditure }}</td>													
									<td>{{ number_format($fy1_expenditure, 2) }}</td>													
									<td>{{ number_format($fy2_expenditure, 2) }}</td>													
									<td>{{ number_format($fy3_expenditure, 2) }}</td>																
								</tr><?php 
							}	
						}		
						if(isset($item->pap)){
							$fy1_pap = $row->sum('fy1_amount');
							$fy2_pap = $row->sum('fy2_amount');
							$fy3_pap = $row->sum('fy3_amount'); ?>
							<tr class="text-right font-weight-bold gray-bg">
								<td>TOTAL PAP, {{ $item->pap }}</td>
								<td>{{ number_format($fy1_pap, 2) }}</td>			
								<td>{{ number_format($fy2_pap, 2) }}</td>			
								<td>{{ number_format($fy3_pap, 2) }}</td>			
							</tr><?php 
						}									
					} 

					//MOEE Tier 2 Total
					foreach($data_t2->groupBy('year') as $key_mooe_t2_total=>$row_mooe_t2_total){
						$fy1_mooe_t2 = $row_mooe_t2_total->sum('fy1_amount');
						$fy2_mooe_t2 = $row_mooe_t2_total->sum('fy2_amount');
						$fy3_mooe_t2 = $row_mooe_t2_total->sum('fy3_amount'); ?>
						<tr class="text-right font-weight-bold gray-bg">
							<td>TOTAL TIER 2 MOOE</td>
							<td>{{ number_format($fy1_mooe_t2, 2) }}</td>	
							<td>{{ number_format($fy2_mooe_t2, 2) }}</td>	
							<td>{{ number_format($fy3_mooe_t2, 2) }}</td>	
						</tr><?php
					}

					//MOOE TOTAL
					$data_mooe_total = DB::table('view_budget_proposals')->where('year', $year)->where('allotment_class_id', 2)
						->where('is_active', 1)->where('is_deleted', 0)->groupBy('id')->get();

					foreach($data_mooe_total->groupBy('year') as $key_mooe_total=>$row_mooe_total){
						$fy1_mooe = $row_mooe_total->sum('fy1_amount');
						$fy2_mooe = $row_mooe_total->sum('fy2_amount');
						$fy3_mooe = $row_mooe_total->sum('fy3_amount'); ?>
						<tr class="text-right font-weight-bold gray-bg">
							<td>TOTAL MOOE</td>
							<td>{{ number_format($fy1_mooe, 2) }}</td>	
							<td>{{ number_format($fy2_mooe, 2) }}</td>	
							<td>{{ number_format($fy3_mooe, 2) }}</td>	
						</tr><?php
					}?>

					<tr><td colspan="4">&nbsp;</td></tr>
					<tr>
						<td class="font-weight-bold" colspan="4">CAPITAL OUTLAY (CO)</td>
					</tr><?php

					//CO
					$data_co = DB::table('view_budget_proposals')->where('year', $year)
						->where('is_active', 1)->where('is_deleted', 0)->where('allotment_class_id', 3)
						->orderBy('pap_code', 'ASC')->orderBy('expense_account_code','ASC')
						->orderBy('object_code','ASC')->groupBy('id')->get();
					
					foreach($data_co->groupBY('pap_id') as $key=>$row){			
						foreach($row as $item) {} //item?>
						<tr>
							<td class="font-weight-bold gray1-bg" colspan="4">{{ $item->pap }} - {{ $item->pap_code }}</td>										
						</tr><?php
						foreach($data_co->where('pap_id', $item->pap_id)->groupBY('expense_account_id') as $key1=>$row1){
							foreach($row1 as $item1) {} //item 1
								$fy1_expense = $row1->sum('fy1_amount');
								$fy2_expense = $row1->sum('fy2_amount');
								$fy3_expense = $row1->sum('fy3_amount'); ?>
							<tr class="font-weight-bold text-right font-weight-bold gray-bg">
								<td class="subactivity">{{ $item1->expense_account}}</td>
								<td>{{ number_format($fy1_expense, 2) }}</td>													
								<td>{{ number_format($fy2_expense, 2) }}</td>													
								<td>{{ number_format($fy3_expense, 2) }}</td>													
							</tr><?php 	
							foreach($data_co->where('pap_id', $item->pap_id)->where('expense_account_id', $item1->expense_account_id)
								->groupBY('object_expenditure_id') as $key2=>$row2){
								foreach($row2 as $item2) {} //item 2
								$fy1_expenditure = $row2->sum('fy1_amount');
								$fy2_expenditure = $row2->sum('fy2_amount');
								$fy3_expenditure = $row2->sum('fy3_amount'); ?>
								<tr class="text-right">
									<td class="expense">{{ $item2->object_code }}: {{ $item2->object_expenditure }}</td>													
									<td>{{ number_format($fy1_expenditure, 2) }}</td>													
									<td>{{ number_format($fy2_expenditure, 2) }}</td>													
									<td>{{ number_format($fy3_expenditure, 2) }}</td>																
								</tr><?php 
							}	
						}		
						if(isset($item->pap)){
							$fy1_pap = $row->sum('fy1_amount');
							$fy2_pap = $row->sum('fy2_amount');
							$fy3_pap = $row->sum('fy3_amount'); ?>
							<tr class="text-right font-weight-bold gray-bg">
								<td>TOTAL PAP, {{ $item->pap }}</td>
								<td>{{ number_format($fy1_pap, 2) }}</td>			
								<td>{{ number_format($fy2_pap, 2) }}</td>			
								<td>{{ number_format($fy3_pap, 2) }}</td>			
							</tr><?php 
						}
					}

					//CO TOTAL
					foreach($data_co->groupBy('year') as $key_co=>$row_co){
						$fy1_co = $row_co->sum('fy1_amount');
						$fy2_co = $row_co->sum('fy2_amount');
						$fy3_co = $row_co->sum('fy3_amount'); ?>
						<tr class="text-right font-weight-bold gray-bg">
							<td>TOTAL CO</td>
							<td>{{ number_format($fy1_co, 2) }}</td>	
							<td>{{ number_format($fy2_co, 2) }}</td>	
							<td>{{ number_format($fy3_co, 2) }}</td>	
						</tr><?php
					}

					//GRAND TOTAL
					$data_total = DB::table('view_budget_proposals')->where('year', $year)
						->where('is_active', 1)->where('is_deleted', 0)->groupBy('id')->get();

					foreach($data_total->groupBy('year') as $keyBPSum=>$rowBPSum){
						$fy1_gt = $rowBPSum->sum('fy1_amount');
						$fy2_gt = $rowBPSum->sum('fy2_amount');
						$fy3_gt = $rowBPSum->sum('fy3_amount'); ?>
						<tr class="text-right font-weight-bold gray-bg">
							<td >GRAND TOTAL</td>
							<td>{{ number_format($fy1_gt, 2) }}</td>	
							<td>{{ number_format($fy2_gt, 2) }}</td>	
							<td>{{ number_format($fy3_gt, 2) }}</td>	
						</tr><?php
					}?>	
				</tbody>
			</table>
			<br><br>
			<table class="table-borderless text-left" style="width: 100%;">
				<tr>
					<td>Prepared By:</td>
				</tr>	
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>			
				<tr>
					<td>__________________________________</td>
				</tr>
				<tr>
					<td>{{ strtoupper($user_fullname) }}</td>
				</tr>
				<tr class="text-left">
					<td style="font-size:14px;">{{ $user_role }}</td>
				</tr>	
			</table>
			<br>
		</div>
	</body>
</html>
					