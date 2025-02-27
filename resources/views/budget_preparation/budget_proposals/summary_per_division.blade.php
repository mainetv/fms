@extends('layouts.app')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">Summary of 3-Year Budget Proposal per Division</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Budget Preparation</li>
						<li class="breadcrumb-item active">Summary of 3-Year Budget Proposal per Division</li>
				</ol>
				</div><!-- /.col -->
			</div>
		</div>
	</div>

	<section class="content">  
		<div class="card">			
			<div class="card-header noprint">
				<div class="row">
					<div class="col-3">            
						<h3 class="card-title">
							<i class="fas fa-edit"></i>
							<label for="year_selected">Year: </label>                        
							<?php $year_selected = $data['year_selected']; ?> 
							<select name="year_selected" id="year_selected" onchange="changeYear()">               
								@foreach ($years as $row)
									<option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
								@endforeach    
							</select>  							                                   
						</h3><br><br>
						<?php 
						$fiscal_year1 = '';		
						$fiscal_year2 = '';		
						$fiscal_year3 = '';		
						$sqlBP = getAgencyBudgetProposal($year_selected);	
						foreach($sqlBP as $row){
							$year=$row->year;
							$fiscal_year1=$row->fiscal_year1;
							$fiscal_year2=$row->fiscal_year2;
							$fiscal_year3=$row->fiscal_year3;
						}
						$sqlDivisions = getAllActiveDivisions();
						$divisions_count = $sqlDivisions->count();
						$sqlBPStatus = getBPStatusbyYear($year_selected);
						$sqlBPStatus10Count = $sqlBPStatus->where('status_id', 10)->count();
						$sqlBPStatus12Count = $sqlBPStatus->where('status_id', 12)->count();
						if(($sqlBPStatus10Count == $divisions_count) || ($sqlBPStatus12Count == $divisions_count)){
							foreach ($sqlBPStatus as $row) {
								$status = $row->status;
							}?>
								<span class='badge' style='font-size:15px'>STATUS OF ALL DIVISIONS' BUDGET PROPOSAL</span><br>
								<span class='badge badge-success' style='font-size:15px'>{{ $status ?? ""}}</span> 
							<?php
						}?>      						
					</div>       
					<div class="col-6 text-center">  
						<h3>Fiscal Year: 
							{{ $fiscal_year1 }} - {{ $fiscal_year3 }}
                  </h3> 
					</div>	
					<div class="col-3">  
						<a target="_blank" href="{{ route('agency_proposal.print_summary_per_division', $year_selected) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
               </div> 												    
				</div>
			</div>    
			<div class="card-body">				
				<div class="content d-none">					
					<div class="row">	
						<div class="col-5">
							<h4>Summary of 3-Year Budget Proposal per Division</h4>
							<h5>FY {{ $fiscal_year1 }} - {{ $fiscal_year3 }}</h5>
						</div> 
					</div>
				</div>
				<div class="row py-3  text-center">
					<div class="col table-responsive">
						<center>
							<table id="budget_proposal_table" class="table-sm table-bordered table-responsive-sm table-hover" style="width:70%;">
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
									$data = DB::table('view_budget_proposals')->where('year', $year_selected)
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
									$data_total = DB::table('view_budget_proposals')->where('year', $year_selected)
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
						</center>
					</div>    
				</div>					
			</div>
		</div>            
	</section>
@endsection

@section('jscript')
   <script type="text/javascript">     
      $(document).ready(function(){   
         @include('scripts.common_script')       
      })     
		function changeYear()
		{
			year = $("#year_selected").val();
			window.location.replace("{{ url('budget_preparation/budget_proposal/summary_per_division') }}/"+year);
		}	 
   </script>  
@endsection

