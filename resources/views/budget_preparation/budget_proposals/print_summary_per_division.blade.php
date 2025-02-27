
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - Summary per Division</title>
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
				<h5> FY {{ $fiscal_year1 }} - {{ $fiscal_year3 }}
				<br>Summary of 3-Year Budget Proposal per Division</h5>					
				<br>
				<table id="budget_proposal_table" class="table-sm table-bordered table-responsive-sm table-hover" style="width:100%;">
					<thead class="text-center">
						<tr>
							<th width="12%" rowspan="2">Division</th>
							<th width="88%" colspan="3">Year</th>
						</tr>
						<tr>
							<th>{{ $fiscal_year1 }}</th>
							<th>{{ $fiscal_year2 }}</th>
							<th>{{ $fiscal_year3 }}</th>
						</tr>

					</thead>		
					<tbody id="budget_proposal" class="table-bordered table-hover">								
						<?php
						//MOOE Tier 1
						$data = DB::table('view_budget_proposals')->where('year', $year)
							->where('is_active', 1)->where('is_deleted', 0)
							->orderBy('division_acronym','ASC')->groupBy('id')->get();	
							
						foreach($data->groupBY('division_id') as $key=>$row){			
							foreach($row as $item) {} //item
							$fy1 = $row->sum('fy1_amount');
							$fy2 = $row->sum('fy2_amount');
							$fy3 = $row->sum('fy3_amount');
							?>									
							<tr class="text-right">
								<td class="text-left">{{ $item->division_acronym }}</td>	
								<td>{{ number_format($fy1, 2) }}</td>			
								<td>{{ number_format($fy2, 2) }}</td>			
								<td>{{ number_format($fy3, 2) }}</td>		
							</tr>	
							<?php								
						}?>

						<?php

						//GRAND TOTAL
						$data_total = DB::table('view_budget_proposals')->where('year', $year)
							->where('is_active', 1)->where('is_deleted', 0)->groupBy('id')->get();

						foreach($data_total->groupBy('year') as $keyBPSum=>$rowBPSum){
							$fy1_gt = $rowBPSum->sum('fy1_amount');
							$fy2_gt = $rowBPSum->sum('fy2_amount');
							$fy3_gt = $rowBPSum->sum('fy3_amount'); ?>
							<tr class="text-right font-weight-bold gray-bg">
								<td nowrap>GRAND TOTAL</td>
								<td>{{ number_format($fy1_gt, 2) }}</td>	
								<td>{{ number_format($fy2_gt, 2) }}</td>	
								<td>{{ number_format($fy3_gt, 2) }}</td>	
							</tr><?php
						}?>	
					</tbody>
				</table>	 
			</center>
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
					