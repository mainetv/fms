<h4>{{ $value->division_acronym }}</h4>
<div class="content">
  <div class="row">
    <div class="col-7">
		<span class='badge badge-success' style='font-size:15px'>{{ $status ?? ""}}</span>
    </div>
	 <div class="col-5">
		
	 </div>
  </div>
</div>
<div class="row py-3">
  	<div class="col table-responsive">
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
				</tr><?php 
				$division_acronym = '';
				$fiscal_year1 = '';
				$fiscal_year2 = '';
				$fiscal_year3 = '';
				$division_id=$value->id;		
				$sqlPT = getPhysicalTargets($division_id, $year_selected);			
				if($division_id==5){
					$data = DB::table('view_physical_targets')->where('year', $year_selected)->where('division_acronym', 'LIKE', '%FAD%')
						->where('is_deleted', 0)->get();
				}
				else{
					$data = DB::table('view_physical_targets')->where('division_id', $division_id)->where('year', $year_selected)
						->where('is_deleted', 0)->get();	
				}			
				foreach($data->groupBY('division_id') as $key=>$row){	
					foreach($row as $item) {}?> 				
				<tr>
					<td>1.  Percentage of priorities in the Harmonized R&D agenda addressed</td>
					<td>{{ $item->percentage_priorities_tier1 }}%</td>
					<td>{{ $item->percentage_priorities_tier2 }}%</td>
				</tr>
				<tr>
					<td>2.  Number of partnerships with public and private stakeholders and international organizations</td>
					<td>{{ $item->number_partnerships_tier1 }}</td>
					<td>{{ $item->number_partnerships_tier2 }}</td>
				</tr>
				<tr class="font-weight-bold">
					<td colspan="3">Output Indicators</td>
				</tr>
				<tr>
					<td>1.  Number of projects funded</td>
					<td>{{ $item->number_projects_funded_tier1 }}</td>
					<td>{{ $item->number_projects_funded_tier2 }}</td>
				</tr>
				<tr>
					<td>2.  Number of projects monitored</td>
					<td>{{ $item->number_projects_monitored_tier1 }}</td>
					<td>{{ $item->number_projects_monitored_tier2 }}</td>
				</tr>
				<tr>
					<td>3.  Percentage of projects completed which are published in peer-reviewed journals, presented in national and /or international conferences or with IP filed or approved</td>
					<td>{{ $item->percentage_projects_completed_tier1 }}%</td>
					<td>{{ $item->percentage_projects_completed_tier2 }}%</td>
				</tr><?php } ?>
			</tbody>             
		</table> 				 
  </div>    
</div>

