@extends('layouts.app')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">{{ $title }}</h1>
				</div>
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Budget Preparation</li>
						<li class="breadcrumb-item active">{{ $title }}</li>
				</ol>
				</div>
			</div>
		</div>
	</div>
	
	<section class="content">  
		<div class="card refreshDiv">			
			<div class="card-header">
				<div class="row">
					<div class="col-10 float-left">
						{{-- <form method="post" id="send_year" action="{{ route('division_proposals.postAction') }}">     --}}
							@csrf              
							<h3 class="card-title">
								<i class="fas fa-edit"></i>
								<label for="year_selected">Year: </label>                        
								<?php $year_selected = $data['year_selected']; ?> 
								<select name="year_selected" id="year_selected" onchange="changeYear()">               
									@foreach ($years as $row)
										<option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
									@endforeach    
								</select>                                              
							</h3>
						{{-- </form>    --}}
					</div>  
					<?php 
						$division_acronym = '';
						$fiscal_year = '';
						$fiscal_year1 = '';
						$fiscal_year2 = '';
						$fiscal_year3 = '';
						$division_id=$user_division_id;		
						$sqlPT = getPhysicalTargets($division_id, $year_selected);	
						foreach ($sqlPT as $row) {
							$fiscal_year = $row->fiscal_year;
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
					<div class="col-2">
						<a target="_blank" href="{{ route('physical_targets.generatePDF', ['division_id'=>$division_id, 'year'=>$year_selected]) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
					</div>													    
				</div>
			</div>    

			<div class="card-body py-2">				
				<div class="content">					
					<div class="row">	
						<div class="col-4 float-left">
							<h5>FY {{ $fiscal_year }}</h5>
						</div>
						<div class="col-4 text-center">
							<h2>{{ $user_division_acronym }}</h2>
						</div> 
					</div>
				</div>
				<div class="row py-3">
					<div class="col-2"></div>
					<div class="col-8 table-responsive">
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
					</div> 
					<div class="col-2"></div>   
				</div>					
			</div>
		</div>            
	</section>
@endsection

@section('jscript')
   <script type="text/javascript">     
      $(document).ready(function(){    
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
			window.location.replace("{{ url('budget_preparation/physical_targets/division') }}/"+year);
		}		  
   </script>  
@endsection

