@extends('layouts.app')

@section('content')
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">{{ $title }}</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Budget Preparation</li>
						<li class="breadcrumb-item active">{{ $title }}</li>
				</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
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
						<h5>(In Thousand Pesos)</h5>
					</div>	
					<div class="col-3">  
						<a target="_blank" href="{{ route('agency_proposal.generatePDF_by_expenditure', $year_selected) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
               </div> 												    
				</div>
			</div>    
			<div class="card-body">				
				<div class="content d-none">					
					<div class="row">	
						<div class="col-5">
							<h4>AGENCY BUDGET PROPOSAL</h4>
							<h5>FY {{ $fiscal_year1 }} - {{ $fiscal_year3 }}</h5>
						</div> 
					</div>
				</div>
				<div class="row py-3">
					<div class="col table-responsive">
						<table id="budget_proposal_table" class="table table-sm table-bordered table-responsive-sm table-hover" style="width: 100%;">
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
								$data_t1 = DB::table('view_budget_proposals')->where('year', $year_selected)
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
									foreach($data_t1->where('pap_id', $item->pap_id)->groupBY('expense_account_id') as $key1=>$row1){
										foreach($row1 as $item1) {} //item 1
											$fy1_expense = round($row1->sum('fy1_amount'), -3)/1000;
											$fy2_expense = round($row1->sum('fy2_amount'), -3)/1000;
											$fy3_expense = round($row1->sum('fy3_amount'), -3)/1000; ?>
										<tr class="font-weight-bold text-right font-weight-bold gray-bg">
											<td class="subactivity">{{ $item1->expense_account}}</td>
											<td>{{ number_format($fy1_expense) }}</td>													
											<td>{{ number_format($fy2_expense) }}</td>													
											<td>{{ number_format($fy3_expense) }}</td>													
										</tr><?php 	
										foreach($data_t1->where('pap_id', $item->pap_id)->where('expense_account_id', $item1->expense_account_id)
											->groupBY('object_expenditure_id') as $key2=>$row2){
											foreach($row2 as $item2) {} //item 2
											$fy1_expenditure = round($row2->sum('fy1_amount'), -3)/1000;
											$fy2_expenditure = round($row2->sum('fy2_amount'), -3)/1000;
											$fy3_expenditure = round($row2->sum('fy3_amount'), -3)/1000; ?>
											<tr class="text-right">
												<td class="expense">{{ $item2->object_expenditure }}</td>													
												<td>{{ number_format($fy1_expenditure) }}</td>													
												<td>{{ number_format($fy2_expenditure) }}</td>													
												<td>{{ number_format($fy3_expenditure) }}</td>																
											</tr><?php 
										}	
									}		
									if(isset($item->pap)){
										$fy1_pap = round($row->sum('fy1_amount'), -3)/1000;
										$fy2_pap = round($row->sum('fy2_amount'), -3)/1000;
										$fy3_pap = round($row->sum('fy3_amount'), -3)/1000; ?>
										<tr class="text-right font-weight-bold gray-bg">
											<td>TOTAL PAP, {{ $item->pap }}</td>
											<td>{{ number_format($fy1_pap) }}</td>			
											<td>{{ number_format($fy2_pap) }}</td>			
											<td>{{ number_format($fy3_pap) }}</td>			
										</tr><?php 
									}									
								}
								
								//MOOE Tier 1 Total								
								foreach($data_t1->groupBy('year') as $key_mooe_t1=>$row_mooe_t1){
									$fy1_mooe_t1 = round($row_mooe_t1->sum('fy1_amount'), -3)/1000;
									$fy2_mooe_t1 = round($row_mooe_t1->sum('fy2_amount'), -3)/1000;
									$fy3_mooe_t1 = round($row_mooe_t1->sum('fy3_amount'), -3)/1000; ?>
									<tr class="text-right font-weight-bold gray-bg">
										<td>TOTAL TIER 1 MOOE</td>
										<td>{{ number_format($fy1_mooe_t1) }}</td>	
										<td>{{ number_format($fy2_mooe_t1) }}</td>	
										<td>{{ number_format($fy3_mooe_t1) }}</td>	
									</tr><?php
								}?>

								<tr>
									<td class="font-weight-bold" colspan="4">TIER 2</td>
								</tr><?php

								//MOOE Tier 2
								$data_t2 = DB::table('view_budget_proposals')->where('year', $year_selected)
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
											$fy1_expense = round($row1->sum('fy1_amount'), -3)/1000;
											$fy2_expense = round($row1->sum('fy2_amount'), -3)/1000;
											$fy3_expense = round($row1->sum('fy3_amount'), -3)/1000; ?>
										<tr class="font-weight-bold text-right font-weight-bold gray-bg">
											<td class="subactivity">{{ $item1->expense_account}}</td>
											<td>{{ number_format($fy1_expense) }}</td>													
											<td>{{ number_format($fy2_expense) }}</td>													
											<td>{{ number_format($fy3_expense) }}</td>													
										</tr><?php 	
										foreach($data_t2->where('pap_id', $item->pap_id)->where('expense_account_id', $item1->expense_account_id)
											->groupBY('object_expenditure_id') as $key2=>$row2){
											foreach($row2 as $item2) {} //item 2
											$fy1_expenditure = round($row2->sum('fy1_amount'), -3)/1000;
											$fy2_expenditure = round($row2->sum('fy2_amount'), -3)/1000;
											$fy3_expenditure = round($row2->sum('fy3_amount'), -3)/1000; ?>
											<tr class="text-right">
												<td class="expense">{{ $item2->object_expenditure }}</td>													
												<td>{{ number_format($fy1_expenditure) }}</td>													
												<td>{{ number_format($fy2_expenditure) }}</td>													
												<td>{{ number_format($fy3_expenditure) }}</td>																
											</tr><?php 
										}	
									}		
									if(isset($item->pap)){
										$fy1_pap = round($row->sum('fy1_amount'), -3)/1000;
										$fy2_pap = round($row->sum('fy2_amount'), -3)/1000;
										$fy3_pap = round($row->sum('fy3_amount'), -3)/1000; ?>
										<tr class="text-right font-weight-bold gray-bg">
											<td>TOTAL PAP, {{ $item->pap }}</td>
											<td>{{ number_format($fy1_pap) }}</td>			
											<td>{{ number_format($fy2_pap) }}</td>			
											<td>{{ number_format($fy3_pap) }}</td>			
										</tr><?php 
									}									
								} 

								//MOEE Tier 2 Total
								foreach($data_t2->groupBy('year') as $key_mooe_t2_total=>$row_mooe_t2_total){
									$fy1_mooe_t2 = round($row_mooe_t2_total->sum('fy1_amount'), -3)/1000;
									$fy2_mooe_t2 = round($row_mooe_t2_total->sum('fy2_amount'), -3)/1000;
									$fy3_mooe_t2 = round($row_mooe_t2_total->sum('fy3_amount'), -3)/1000; ?>
									<tr class="text-right font-weight-bold gray-bg">
										<td>TOTAL TIER 2 MOOE</td>
										<td>{{ number_format($fy1_mooe_t2) }}</td>	
										<td>{{ number_format($fy2_mooe_t2) }}</td>	
										<td>{{ number_format($fy3_mooe_t2) }}</td>	
									</tr><?php
								}

								//MOOE TOTAL
								$data_mooe_total = DB::table('view_budget_proposals')->where('year', $year_selected)->where('allotment_class_id', 2)
									->where('is_active', 1)->where('is_deleted', 0)->groupBy('id')->get();

								foreach($data_mooe_total->groupBy('year') as $key_mooe_total=>$row_mooe_total){
									$fy1_mooe = round($row_mooe_total->sum('fy1_amount'), -3)/1000;
									$fy2_mooe = round($row_mooe_total->sum('fy2_amount'), -3)/1000;
									$fy3_mooe = round($row_mooe_total->sum('fy3_amount'), -3)/1000; ?>
									<tr class="text-right font-weight-bold gray-bg">
										<td>TOTAL MOOE</td>
										<td>{{ number_format($fy1_mooe) }}</td>	
										<td>{{ number_format($fy2_mooe) }}</td>	
										<td>{{ number_format($fy3_mooe) }}</td>	
									</tr><?php
								}?>

								<tr><td colspan="4">&nbsp;</td></tr>
								<tr>
									<td class="font-weight-bold" colspan="4">CAPITAL OUTLAY (CO)</td>
								</tr><?php

								//CO
								$data_co = DB::table('view_budget_proposals')->where('year', $year_selected)
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
											$fy1_expense = round($row1->sum('fy1_amount'), -3)/1000;
											$fy2_expense = round($row1->sum('fy2_amount'), -3)/1000;
											$fy3_expense = round($row1->sum('fy3_amount'), -3)/1000; ?>
										<tr class="font-weight-bold text-right font-weight-bold gray-bg">
											<td class="subactivity">{{ $item1->expense_account}}</td>
											<td>{{ number_format($fy1_expense) }}</td>													
											<td>{{ number_format($fy2_expense) }}</td>													
											<td>{{ number_format($fy3_expense) }}</td>													
										</tr><?php 	
										foreach($data_co->where('pap_id', $item->pap_id)->where('expense_account_id', $item1->expense_account_id)
											->groupBY('object_expenditure_id') as $key2=>$row2){
											foreach($row2 as $item2) {} //item 2
											$fy1_expenditure = round($row2->sum('fy1_amount'), -3)/1000;
											$fy2_expenditure = round($row2->sum('fy2_amount'), -3)/1000;
											$fy3_expenditure = round($row2->sum('fy3_amount'), -3)/1000; ?>
											<tr class="text-right">
												<td class="expense">{{ $item2->object_expenditure }}</td>													
												<td>{{ number_format($fy1_expenditure) }}</td>													
												<td>{{ number_format($fy2_expenditure) }}</td>													
												<td>{{ number_format($fy3_expenditure) }}</td>																
											</tr><?php 
										}	
									}		
									if(isset($item->pap)){
										$fy1_pap = round($row->sum('fy1_amount'), -3)/1000;
										$fy2_pap = round($row->sum('fy2_amount'), -3)/1000;
										$fy3_pap = round($row->sum('fy3_amount'), -3)/1000; ?>
										<tr class="text-right font-weight-bold gray-bg">
											<td>TOTAL PAP, {{ $item->pap }}</td>
											<td>{{ number_format($fy1_pap) }}</td>			
											<td>{{ number_format($fy2_pap) }}</td>			
											<td>{{ number_format($fy3_pap) }}</td>			
										</tr><?php 
									}
								}

								//CO TOTAL
								foreach($data_co->groupBy('year') as $key_co=>$row_co){
									$fy1_co = round($row_co->sum('fy1_amount'), -3)/1000;
									$fy2_co = round($row_co->sum('fy2_amount'), -3)/1000;
									$fy3_co = round($row_co->sum('fy3_amount'), -3)/1000; ?>
									<tr class="text-right font-weight-bold gray-bg">
										<td>TOTAL CO</td>
										<td>{{ number_format($fy1_co) }}</td>	
										<td>{{ number_format($fy2_co) }}</td>	
										<td>{{ number_format($fy3_co) }}</td>	
									</tr><?php
								}

								//GRAND TOTAL
								$data_total = DB::table('view_budget_proposals')->where('year', $year_selected)
									->where('is_active', 1)->where('is_deleted', 0)->groupBy('id')->get();

								foreach($data_total->groupBy('year') as $keyBPSum=>$rowBPSum){
									$fy1_gt = round($rowBPSum->sum('fy1_amount'), -3)/1000;
									$fy2_gt = round($rowBPSum->sum('fy2_amount'), -3)/1000;
									$fy3_gt = round($rowBPSum->sum('fy3_amount'), -3)/1000; ?>
									<tr class="text-right font-weight-bold gray-bg">
										<td >GRAND TOTAL</td>
										<td>{{ number_format($fy1_gt) }}</td>	
										<td>{{ number_format($fy2_gt) }}</td>	
										<td>{{ number_format($fy3_gt) }}</td>	
									</tr><?php
								}?>	
							</tbody>
						</table>	 
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
			window.location.replace("{{ url('budget_preparation/budget_proposal/agency_by_expenditure') }}/"+year);
		}	 
   </script>  
@endsection

