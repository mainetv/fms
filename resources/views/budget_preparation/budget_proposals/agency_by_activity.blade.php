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
		<div class="card">			
			<div class="card-header noprint">
				<div class="row">
					<div class="col-5">            
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
					</div><?php 
						$fiscal_year1 = '';		
						$fiscal_year2 = '';		
						$fiscal_year3 = '';		
						$sqlBP = getAgencyBudgetProposal($year_selected);	
						foreach($sqlBP as $row){
							$year=$row->year;
							$fiscal_year1=$row->fiscal_year1;
							$fiscal_year2=$row->fiscal_year2;
							$fiscal_year3=$row->fiscal_year3;
						}?> 					             
					<div class="col-5">  
						<h3>Fiscal Year: 
							{{ $fiscal_year1 }} - {{ $fiscal_year3 }}
                  </h3> 
					</div>	
					<div class="col-2">  
						<a target="_blank" href="{{ route('agency_proposal.generatePDF_by_activity', $year_selected) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
						{{-- <button class="noprint btn float-right" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
							title='GENERATE PDF'><i class="fa-2xl fa-solid fa-print"></i></button> --}}
                  {{-- <button id="generatePDF" data-year="{{ $year }}" data-fy1="{{ $fiscal_year1 }}" data-fy3="{{ $fiscal_year3 }}"
							class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button>    --}}
               </div> 												    
				</div>
			</div>    
			<div class="card-body">				
				<div class="content d-none">					
					<div class="row">	
						<div class="col-5">
							<h4>PCAARRD BUDGET PROPOSAL</h4>
							<h5>FY {{ $fiscal_year1 }} - {{ $fiscal_year3 }}</h5>
						</div> 
					</div>
				</div>
				<div class="row py-3">
					<div class="col table-responsive">
						<table id="budget_proposal_table" class="table table-sm table-bordered table-responsive-sm table-hover" style="width: 100%;">
							<thead class="text-center">
								<th>ACTIVITY / Object of Expenditures</th>
								<th>{{ $fiscal_year1 }}</th>
								<th>{{ $fiscal_year2 }}</th>
								<th>{{ $fiscal_year3 }}</th>
							</thead>		
							<tbody id="pcaarrd_budget_proposal" class="table-bordered table-hover" style="width: 100%;"><?php
								$data = DB::table('view_budget_proposals')->where('year', $year_selected)
									->where('is_active', 1)->where('is_deleted', 0)
									->orderBy('allotment_class_id', 'ASC')->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')
									->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')
									->orderBy('object_specific','ASC')->groupBy('id')->get();	

								foreach($data->groupBY('allotment_class_id') as $key=>$row){			
									foreach($row as $item) {} //item?>
									<tr>
										<td class="font-weight-bold" colspan="4">{{ $item->allotment_class }} - {{ $item->allotment_class_acronym }}</td>										
									</tr><?php
									foreach($data->where('allotment_class_id', $item->allotment_class_id)->groupBY('pap_id') as $key1=>$row1){
										foreach($row1 as $item1) {} //item 1?>
										<tr>
											<td class="pap font-weight-bold gray1-bg" colspan="4">{{ $item1->pap }} - {{ $item1->pap_code }}</td>													
										</tr><?php 	
										foreach($data->where('allotment_class_id', $item->allotment_class_id)
											->where('pap_id', $item1->pap_id)
											->groupBY('activity_id') as $key2=>$row2){
											foreach($row2 as $item2) {} //item 2?>
											<tr>
												<td class="activity1 font-weight-bold" colspan="4">{{ $item2->activity }}</td>													
											</tr><?php 
											foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
												->where('activity_id', $item2->activity_id)
												->groupBY('subactivity_id') as $key3=>$row3){
												foreach($row3 as $item3) {} 
												if(isset($item3->subactivity)){//item 3?>
													<tr>
														<td class="subactivity1 font-weight-bold" colspan="4">{{ $item3->subactivity }}</td>													
													</tr><?php 
												}					
												foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
													->where('activity_id', $item2->activity_id)
													->where('subactivity_id', $item3->subactivity_id)
													->groupBY('expense_account_id') as $key4=>$row4){															
													foreach($row4 as $item4) { }//item 4?>
													<tr class="text-right font-weight-bold">
														<td class="expense">{{ $item4->expense_account }}</td>													
														<td>{{ number_format($row4->sum('fy1_amount'), 2) }}</td>													
														<td>{{ number_format($row4->sum('fy2_amount'), 2) }}</td>													
														<td>{{ number_format($row4->sum('fy3_amount'), 2) }}</td>													
													</tr><?php 														
													foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
														->where('activity_id', $item2->activity_id)
														->where('subactivity_id', $item3->subactivity_id)
														->where('expense_account_id', $item4->expense_account_id)
														->groupBY('object_expenditure_id') as $key5=>$row5){
														foreach($row5 as $item5) {}//item 5?>
														<tr class="text-right"><?php
															if($item5->object_specific_id == NULL || $item5->object_specific_id == 0 || $item5->object_specific_id == ''){?>
																<td class="objexp">{{ $item5->object_expenditure }}
																	@if($item5->pooled_at_division_id != '') 
																		- Pooled at {{ $item5->pooled_at_division_acronym }} ({{ $item5->division_acronym }})@endif</td>
																<td>{{ number_format($row5->sum('fy1_amount'), 2) }}</td>													
																<td>{{ number_format($row5->sum('fy2_amount'), 2) }}</td>													
																<td>{{ number_format($row5->sum('fy3_amount'), 2) }}</td><?php 
															}else{?>
																<td class="objexp" colspan="4">{{ $item5->object_expenditure }}</td><?php
															}?>										
														</tr><?php 
														if($item5->object_specific_id != NULL || $item5->object_specific_id != 0 || $item5->object_specific_id != ''){																	
															foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item->pap_id)
																->where('activity_id', $item1->activity_id)
																->where('subactivity_id', $item2->subactivity_id)
																->where('expense_account_id', $item4->expense_account_id)
																->where('object_expenditure_id', $item5->object_expenditure_id)
																->groupBy('object_specific_id') as $key6=>$row6){
																foreach($row6 as $item6) { }//item 6?>
																<tr class="text-right">
																	<td class="objspe @if($item6->object_specific==NULL)  @else font-italic @endif">
																		@if($item6->object_specific==NULL) {{ $item6->object_expenditure }}
																		@else {{ $item6->object_specific }} 
																		@endif
																		@if($item6->pooled_at_division_id != '') 
																			- Pooled at {{ $item6->pooled_at_division_acronym }} ({{ $item6->division_acronym }})@endif</td>													
																	<td>{{ number_format($row6->sum('fy1_amount'), 2) }}</td>													
																	<td>{{ number_format($row6->sum('fy2_amount'), 2) }}</td>													
																	<td>{{ number_format($row6->sum('fy3_amount'), 2) }}</td>	
																</tr><?php 
															}
														}
													}
												}
												if(isset($item3->subactivity)){?>
													<tr class="text-right font-weight-bold gray-bg">
														<td class="subactivity1">Total Subactivity, {{ $item3->subactivity }}</td>
														<td>{{ number_format($row2->sum('fy1_amount'), 2) }}</td>
														<td>{{ number_format($row2->sum('fy2_amount'), 2) }}</td>
														<td>{{ number_format($row2->sum('fy3_amount'), 2) }}</td>
													</tr><?php
												}
											}
											if(isset($item2->activity)){?>
												<tr class="text-right font-weight-bold gray-bg">
													<td class="activity1">Total Activity, {{ $item2->activity }}</td>
													<td>{{ number_format($row1->sum('fy1_amount'), 2) }}</td>
													<td>{{ number_format($row1->sum('fy2_amount'), 2) }}</td>
													<td>{{ number_format($row1->sum('fy3_amount'), 2) }}</td>
												</tr><?php
											}
										}		
										if(isset($item->pap)){?>
											<tr class="text-right font-weight-bold gray-bg">
												<td class="text-left">TOTAL PAP, {{ $item->pap }}</td>
												<td>{{ number_format($row->sum('fy1_amount'), 2) }}</td>
												<td>{{ number_format($row->sum('fy2_amount'), 2) }}</td>
												<td>{{ number_format($row->sum('fy3_amount'), 2) }}</td>
											</tr><?php 
										}
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
			window.location.replace("{{ url('budget_preparation/budget_proposal/agency_by_activity') }}/"+year);
		}	 
   </script>  
@endsection

