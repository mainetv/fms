<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - Physical Targets</title>
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
            // var css = '@page { size: portrait; }',
            // head = document.head || document.getElementsByTagName('head')[0],
            // style = document.createElement('style');

            // style.type = 'text/css';
            // style.media = 'print';

            // if (style.styleSheet){
            // style.styleSheet.cssText = css;
            // } else {
            // style.appendChild(document.createTextNode(css));
            // }

            // head.appendChild(style);

				window.print();
			}
		</script>
	</head>
	<body>
		<?php
			$division_acronym = '';
			$fiscal_year = '';
			$user_id = auth()->user()->id; 
			$user_fullname = App\Models\ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();  
			$user_role = App\Models\ViewUsersModel::where('id', $user_id)->pluck('user_role')->first(); 
			$user_division_id = App\Models\ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
			$user_division_director = App\Models\ViewUsersModel::where('division_id', $user_division_id)
				->where('user_role_id', 6)->pluck('fullname_last')->first();  
			$sqlPT = getPhysicalTargets($division_id, $year);	
			foreach ($sqlPT as $row) {
				$fiscal_year = $row->fiscal_year;
				$division_acronym = $row->division_acronym;
				$percentage_priorities_tier1 = $row->percentage_priorities_tier1;
				$percentage_priorities_tier2 = $row->percentage_priorities_tier2;
				$number_partnerships_tier1 = $row->number_partnerships_tier1;
				$number_partnerships_tier2 = $row->number_partnerships_tier2;
				$number_projects_funded_tier1 = $row->number_projects_funded_tier1;
				$number_projects_funded_tier2 = $row->number_projects_funded_tier2;
				$number_projects_monitored_tier1 = $row->number_projects_monitored_tier1;
				$number_projects_monitored_tier2 = $row->number_projects_monitored_tier2;
				$percentage_projects_completed_tier1 = $row->percentage_projects_completed_tier1;
				$percentage_projects_completed_tier2 = $row->percentage_projects_completed_tier2;
			}	
		?>	
		<button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
		<br><br>
		<h5 class="text-center font-weight-bold">FY {{ $fiscal_year}} PHYSICAL TARGETS <br>		
		{{ $division_acronym }}</h5>
		<table id="physical_targets_table" class="table table-bordered">
			<thead class="text-center">            
				<tr>
					<th rowspan="2">Program/ Sub-Program/Performance Indicator Description</th>     
					<th colspan="2">Targets</th>     
				</tr>  
				<tr>
					<th>Tier 1</th>
					<th>Tier 2</th>
				</tr>   
			</thead>  
			<tbody>
				<tr class="font-weight-bold">
					<td colspan="3">NATIONAL AANR SECTOR R&D PROGRAM</td>
				</tr>
				<tr class="font-weight-bold">
					<td colspan="3">Outcome Indicators</td>
				</tr>
				<tr>
					<td>1.  Percentage of priorities in the Harmonized R&D agenda addressed</td>
					<td>{{ $percentage_priorities_tier1 ?? '' }}%</td>
					<td>{{ $percentage_priorities_tier2 ?? '' }}%</td>
				</tr>
				<tr>
					<td>2.  Number of partnerships with public and private stakeholders and international organizations</td>
					<td>{{ $number_partnerships_tier1 ?? '' }}</td>
					<td>{{ $number_partnerships_tier2 ?? '' }}</td>
				</tr>
				<tr class="font-weight-bold">
					<td colspan="3">Output Indicators</td>
				</tr>
				<tr>
					<td>1.  Number of projects funded</td>
					<td>{{ $number_projects_funded_tier1 ?? '' }}</td>
					<td>{{ $number_projects_funded_tier2 ?? '' }}</td>
				</tr>
				<tr>
					<td>2.  Number of projects monitored</td>
					<td>{{ $number_projects_monitored_tier1 ?? '' }}</td>
					<td>{{ $number_projects_monitored_tier2 ?? '' }}</td>
				</tr>
				<tr>
					<td>3.  Percentage of projects completed which are published in peer-reviewed journals, presented in national and /or international conferences or with IP filed or approved</td>
					<td>{{ $percentage_projects_completed_tier1 ?? '' }}%</td>
					<td>{{ $percentage_projects_completed_tier2 ?? '' }}%</td>
				</tr>
			</tbody>             
		</table>
		<br>
		<table style="width: 100%;">
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
				<td>___________________________</td>
				<td>___________________________</td>
			</tr>
			<tr class="text-center">
				<td>{{ strtoupper($user_fullname) }}</td>
				<td>{{ strtoupper($user_division_director) }}</td>
			</tr>
			<tr class="text-center">
				<td style="font-size:11px;">{{ $user_role }}</td>
				<td style="font-size:11px;">Division Director</td>
			</tr>	
		</table> 
	</body>
</html> 