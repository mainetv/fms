<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - BP Form 3</title>
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
			@media print {
				.pagebreak { page-break-before: always; } /* page-break-after works, as well */
			}
		</style>
		<SCRIPT LANGUAGE="JavaScript">
			function printThis()
			{
            var css = '@page { size: landscape; }',
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
		<?php
			$division_acronym = '';
         $fiscal_year1 = '';
         $fiscal_year2 = '';
         $fiscal_year3 = '';
			$user_id = auth()->user()->id; 						
			$user_fullname = getUserFullname($user_id);
			$executive_director_fullname = getExecutiveDirector($user_id);
			$user_role = getUserRole($user_id);
			$user_division_id = getUserDivisionID($user_id);
			$user_parent_division_id = getUserParentDivisionID($user_id);
			$sqlBP = getBudgetProposal($division_id, $year);	
		?>	
		<button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
		<br><br>
		<?php
			$department_header = getDepartmentHeader();
			$agency_header = getAgencyHeader();

		?>
	{{-- tier 1 fy1--}}
		<h5 class="text-center">{{ $department_header }}</h5>
		<h5 class="text-center">{{ $agency_header }}</h5>
		<h5 class="text-center">LAND AND LAND IMPROVEMENTS - Tier 1</h5>
		<h6 class="text-center">(In Thousand Pesos)</h6>		
			<div class="row">
			<div class="col-10">
				<div class="float-right"><?php 
					$sqlFiscalYears = getFiscalYears($year);
					foreach($sqlFiscalYears->where('year', $year) as $row => $key){
						$fiscal_year1 = $key->fiscal_year1;
						$fiscal_year2 = $key->fiscal_year2;
						$fiscal_year3 = $key->fiscal_year3;?><br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year1; }}" 
							@if($fiscal_year1) checked @endif onclick="return false;"> FY {{ $fiscal_year1; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year2; }}" 
							onclick="return false;"> FY {{ $fiscal_year2; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year3; }}" 
							onclick="return false;"> FY {{ $fiscal_year3; }}<?php
					}?>
				</div>
			</div>			
		</div>	
		<div class="col text-right">
			DOST Form No. 3
		</div>		
		<div class="row py-3">			
			<div class="col table-responsive">  
				<table id="bp_form3_table_fy1" class="table-bordered table-hover table" style="width: 100%;">
					<thead>
						<tr class="text-center">
							<th style="min-width:18%;">Description</th>
							<th style="min-width:8%;">Area / SQM</th>
							<th style="min-width:10%;">Location</th>
							<th style="min-width:12%;">Amount</th>
							<th style="min-width:52%;">Justification</th>        
						</tr>     
					</thead>  
					<tbody>
						<?php 
							$count_fy1 = 0;			
							$sqlBpForm3byFY_fy1 = getBpForm3byDivisionbyYearbyTier($user_division_id, '1', $year);
							foreach($sqlBpForm3byFY_fy1 as $row){
								$id = $row->id;
								$description = $row->description;
								$area_sqm = $row->area_sqm;
								$location = $row->location;
								$amount = round($row->amount, -3)/1000;
								$organizational_deployment = $row->organizational_deployment;
								$justification = $row->justification;
								$remarks = $row->remarks;
								$is_active = $row->is_active;								
								$count_fy1 = count($sqlBpForm3byFY_fy1);
								$fiscal_year = $row->fiscal_year;
								if($count_fy1 != 0 && $fiscal_year1==$fiscal_year){?>
									<tr class="text-center">
										<td class="text-left">{{ $description }}</td>
										<td>{{ $area_sqm }}</td>
										<td>{{ $location }}</td>
										<td>{{ number_format($amount) }}</td>
										<td class="text-left" style="max-width:300px">{{ $justification }}</td>
									</tr> <?php
								}
								$count_fy1 = $count_fy1 + 1;
							}
							// $area_sqm=0;
							// $location=0;
							// $amount=0;

							$data_fy1=DB::table('bp_form3')->where('division_id',$user_division_id)->where('year',$year)							
								->where('fiscal_year', $fiscal_year1)->where('tier', 1)->where('is_active', 1)->where('is_deleted', 0)->get();  
							if($count_fy1 != 0){
								foreach($data_fy1->groupBy('year') as $key=>$row){
									$amount_gt = round($row->sum('amount'), -3)/1000; ?>
									<tr class="text-center font-weight-bold">
										<td colspan="3" class="text-right">TOTAL</td>
										<td>{{ $amount_gt }}</td>	
										<td></td>
									</tr><?php
								}
							}
							else{?>
								<tr class="text-center font-italic">
									<td colspan="7">No Results Found</td>
								</tr><?php
							}
						?>            
					</tbody>              
				</table>
				<br><br>
				<table class="table-borderless" style="width: 100%;">
					<tr>
						<td>Prepared By:</td>
						<td>Approved By:</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr class="text-center">
						<td>______________________________</td>
						<td>______________________________</td>
					</tr>
					<tr class="text-center">
						<td>{{ strtoupper($user_fullname) }}</td>
						<td>{{ strtoupper($executive_director_fullname) }}</td>
					</tr>
					<tr class="text-center">
						<td style="font-size:13px;">{{ $user_role }}</td>
						<td style="font-size:13px;">Executive Director</td>
					</tr>	
				</table>
			</div>         
		</div>
	{{-- tier 1 fy1--}}	
		<div class="pagebreak"> </div>
	{{-- tier 1 fy2--}}
		<h5 class="text-center">{{ $department_header }}</h5>
		<h5 class="text-center">{{ $agency_header }}</h5>
		<h5 class="text-center">LAND AND LAND IMPROVEMENTS - Tier 1</h5>
		<h6 class="text-center">(In Thousand Pesos)</h6>
		<div class="row">
			<div class="col-10">
				<div class="float-right"><?php 
					$sqlFiscalYears = getFiscalYears($year);
					foreach($sqlFiscalYears->where('year', $year) as $row => $key){
						$fiscal_year1 = $key->fiscal_year1;
						$fiscal_year2 = $key->fiscal_year2;
						$fiscal_year3 = $key->fiscal_year3;?><br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year1; }}" 
						onclick="return false;"> FY {{ $fiscal_year1; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year2; }}" 
							@if($fiscal_year1) checked @endif onclick="return false;"> FY {{ $fiscal_year2; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year3; }}" 
							onclick="return false;"> FY {{ $fiscal_year3; }}<?php
					}?>
				</div>
			</div>			
		</div>	
		<div class="col text-right">
			DOST Form No. 3
		</div>		
		<div class="row py-3">			
			<div class="col table-responsive">  
				<table id="bp_form3_table_fy2" class="table-bordered table-hover table" style="width: 100%;">
					<thead>
						<tr class="text-center">
							<th style="min-width:18%;">Description</th>
							<th style="min-width:8%;">Area / SQM</th>
							<th style="min-width:10%;">Location</th>
							<th style="min-width:12%;">Amount</th>
							<th style="min-width:52%;">Justification</th>        
						</tr>     
					</thead>  
					<tbody>
						<?php 
							$count_fy2 = 0;			
							$sqlBpForm3byFY_fy2 = getBpForm3byDivisionbyYearbyTier($user_division_id, '1', $year);
							foreach($sqlBpForm3byFY_fy2 as $row){
								$id = $row->id;
								$description = $row->description;
								$area_sqm = $row->area_sqm;
								$location = $row->location;
								$amount = round($row->amount, -3)/1000;
								$organizational_deployment = $row->organizational_deployment;
								$justification = $row->justification;
								$remarks = $row->remarks;
								$is_active = $row->is_active;
								$count_fy2 = count($sqlBpForm3byFY_fy2);
								$fiscal_year = $row->fiscal_year;
								if($count_fy2 != 0 && $fiscal_year2==$fiscal_year){?>
									<tr class="text-center">
										<td class="text-left">{{ $description }}</td>
										<td>{{ $area_sqm }}</td>
										<td>{{ $location }}</td>
										<td>{{ number_format($amount) }}</td>
										<td class="text-left" style="max-width:300px">{{ $justification }}</td>
									</tr> <?php
								}
								$count_fy2 = $count_fy2 + 1;
							}

							$data_fy2=DB::table('bp_form3')->where('division_id',$user_division_id)->where('year',$year)
								->where('fiscal_year', $fiscal_year2)->where('tier', 1)->where('is_active', 1)->where('is_deleted', 0)->get();  
							if($count_fy2 != 0){
								foreach($data_fy2->groupBy('year') as $key=>$row){
									$amount_gt = round($row->sum('amount'), -3)/1000; ?>
									<tr class="text-center font-weight-bold">
										<td colspan="3" class="text-right">TOTAL</td>
										<td>{{ $amount_gt }}</td>	
										<td></td>
									</tr><?php
								}
							}
							else{?>
								<tr class="text-center font-italic">
									<td colspan="7">No Results Found</td>
								</tr><?php
							}
						?>            
					</tbody>              
				</table>
				<br><br>
				<table class="table-borderless" style="width: 100%;">
					<tr>
						<td>Prepared By:</td>
						<td>Approved By:</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr class="text-center">
						<td>______________________________</td>
						<td>______________________________</td>
					</tr>
					<tr class="text-center">
						<td>{{ strtoupper($user_fullname) }}</td>
						<td>{{ strtoupper($executive_director_fullname) }}</td>
					</tr>
					<tr class="text-center">
						<td style="font-size:13px;">{{ $user_role }}</td>
						<td style="font-size:13px;">Executive Director</td>
					</tr>	
				</table>
			</div>         
		</div>
	{{-- tier 1 fy2--}}
		<div class="pagebreak"> </div>
	{{-- tier 1 fy3--}}
		<h5 class="text-center">{{ $department_header }}</h5>
		<h5 class="text-center">{{ $agency_header }}</h5>
		<h5 class="text-center">LAND AND LAND IMPROVEMENTS - Tier 1</h5>
		<h6 class="text-center">(In Thousand Pesos)</h6>
		<div class="row">
			<div class="col-10">
				<div class="float-right"><?php 
					$sqlFiscalYears = getFiscalYears($year);
					foreach($sqlFiscalYears->where('year', $year) as $row => $key){
						$fiscal_year1 = $key->fiscal_year1;
						$fiscal_year2 = $key->fiscal_year2;
						$fiscal_year3 = $key->fiscal_year3;?><br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year1; }}" 
							onclick="return false;"> FY {{ $fiscal_year1; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year2; }}" 
							onclick="return false;"> FY {{ $fiscal_year2; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year3; }}" 
							@if($fiscal_year1) checked @endif onclick="return false;"> FY {{ $fiscal_year3; }}<?php
					}?>
				</div>
			</div>			
		</div>	
		<div class="col text-right">
			DOST Form No. 3
		</div>		
		<div class="row py-3">			
			<div class="col table-responsive">  
				<table id="bp_form3_table_fy3" class="table-bordered table-hover table" style="width: 100%;">
					<thead>
						<tr class="text-center">
							<th style="min-width:18%;">Description</th>
							<th style="min-width:8%;">Area / SQM</th>
							<th style="min-width:10%;">Location</th>
							<th style="min-width:12%;">Amount</th>
							<th style="min-width:52%;">Justification</th>          
						</tr>     
					</thead>  
					<tbody>
						<?php 
							$count_fy3 = 0;			
							$sqlBpForm3byFY_fy3 = getBpForm3byDivisionbyYearbyTier($user_division_id, '1', $year);
							foreach($sqlBpForm3byFY_fy3 as $row){
								$id = $row->id;
								$description = $row->description;
								$area_sqm = $row->area_sqm;
								$location = $row->location;
								$amount = round($row->amount, -3)/1000;
								$organizational_deployment = $row->organizational_deployment;
								$justification = $row->justification;
								$remarks = $row->remarks;
								$is_active = $row->is_active;
								$count_fy3 = count($sqlBpForm3byFY_fy3);
								$fiscal_year = $row->fiscal_year;
								if($count_fy3 != 0 && $fiscal_year3==$fiscal_year){?>
									<tr class="text-center">
										<td class="text-left">{{ $description }}</td>
										<td>{{ $area_sqm }}</td>
										<td>{{ $location }}</td>
										<td>{{ number_format($amount) }}</td>
										<td class="text-left" style="max-width:300px">{{ $justification }}</td>
									</tr> <?php
								}
								$count_fy3 = $count_fy3 + 1;
							}

							$data_fy3=DB::table('bp_form3')->where('division_id',$user_division_id)->where('year',$year)
								->where('fiscal_year', $fiscal_year3)->where('tier', 1)->where('is_active', 1)->where('is_deleted', 0)->get();  
							if($count_fy3 != 0){
								foreach($data_fy3->groupBy('year') as $key=>$row){
									$amount_gt = round($row->sum('amount'), -3)/1000; ?>
									<tr class="text-center font-weight-bold">
										<td colspan="3" class="text-right">TOTAL</td>
										<td>{{ $amount_gt }}</td>	
										<td></td>
									</tr><?php
								}
							}
							else{ ?>
								<tr class="text-center font-italic">
									<td colspan="7">No Results Found</td>
								</tr><?php
							}
						?>            
					</tbody>              
				</table>
				<br><br>
				<table class="table-borderless" style="width: 100%;">
					<tr>
						<td>Prepared By:</td>
						<td>Approved By:</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr class="text-center">
						<td>______________________________</td>
						<td>______________________________</td>
					</tr>
					<tr class="text-center">
						<td>{{ strtoupper($user_fullname) }}</td>
						<td>{{ strtoupper($executive_director_fullname) }}</td>
					</tr>
					<tr class="text-center">
						<td style="font-size:13px;">{{ $user_role }}</td>
						<td style="font-size:13px;">Executive Director</td>
					</tr>	
				</table>
			</div>         
		</div>
	{{-- tier 1 fy3--}}
		<div class="pagebreak"> </div>
	{{-- tier 2 fy1--}}
		<h5 class="text-center">{{ $department_header }}</h5>
		<h5 class="text-center">{{ $agency_header }}</h5>
		<h5 class="text-center">LAND AND LAND IMPROVEMENTS - Tier 2</h5>
		<h6 class="text-center">(In Thousand Pesos)</h6>		
			<div class="row">
			<div class="col-10">
				<div class="float-right"><?php 
					$sqlFiscalYears = getFiscalYears($year);
					foreach($sqlFiscalYears->where('year', $year) as $row => $key){
						$fiscal_year1 = $key->fiscal_year1;
						$fiscal_year2 = $key->fiscal_year2;
						$fiscal_year3 = $key->fiscal_year3;?><br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year1; }}" 
							@if($fiscal_year1) checked @endif onclick="return false;"> FY {{ $fiscal_year1; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year2; }}" 
							onclick="return false;"> FY {{ $fiscal_year2; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year3; }}" 
							onclick="return false;"> FY {{ $fiscal_year3; }}<?php
					}?>
				</div>
			</div>			
		</div>	
		<div class="col text-right">
			DOST Form No. 3
		</div>		
		<div class="row py-3">			
			<div class="col table-responsive">  
				<table id="bp_form3_table_fy1" class="table-bordered table-hover table" style="width: 100%;">
					<thead>
						<tr class="text-center">
							<th style="min-width:18%;">Description</th>
							<th style="min-width:8%;">Area / SQM</th>
							<th style="min-width:10%;">Location</th>
							<th style="min-width:12%;">Amount</th>
							<th style="min-width:52%;">Justification</th>        
						</tr>     
					</thead>  
					<tbody>
						<?php 
							$count_fy1 = 0;			
							$sqlBpForm3byFY_fy1 = getBpForm3byDivisionbyYearbyTier($user_division_id, '2', $year);
							foreach($sqlBpForm3byFY_fy1 as $row){
								$id = $row->id;
								$description = $row->description;
								$area_sqm = $row->area_sqm;
								$location = $row->location;
								$amount = round($row->amount, -3)/1000;
								$organizational_deployment = $row->organizational_deployment;
								$justification = $row->justification;
								$remarks = $row->remarks;
								$is_active = $row->is_active;
								$count_fy1 = count($sqlBpForm3byFY_fy1);
								$fiscal_year = $row->fiscal_year;
								if($count_fy1 != 0 && $fiscal_year1==$fiscal_year){?>
									<tr class="text-center">
										<td class="text-left">{{ $description }}</td>
										<td>{{ $area_sqm }}</td>
										<td>{{ $location }}</td>
										<td>{{ number_format($amount) }}</td>
										<td class="text-left" style="max-width:300px">{{ $justification }}</td>
									</tr> <?php
								}
								$count_fy1 = $count_fy1 + 1;
							}
							// $area_sqm=0;
							// $location=0;
							// $amount=0;

							$data_fy1=DB::table('bp_form3')->where('division_id',$user_division_id)->where('year',$year)							
								->where('fiscal_year', $fiscal_year1)->where('tier', 2)->where('is_active', 1)->where('is_deleted', 0)->get();  
							if($count_fy1 != 0){
								foreach($data_fy1->groupBy('year') as $key=>$row){
									$amount_gt = round($row->sum('amount'), -3)/1000; ?>
									<tr class="text-center font-weight-bold">
										<td colspan="3" class="text-right">TOTAL</td>
										<td>{{ $amount_gt }}</td>	
										<td></td>
									</tr><?php
								}
							}
							else{?>
								<tr class="text-center font-italic">
									<td colspan="7">No Results Found</td>
								</tr><?php
							}
						?>            
					</tbody>              
				</table>
				<br><br>
				<table class="table-borderless" style="width: 100%;">
					<tr>
						<td>Prepared By:</td>
						<td>Approved By:</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr class="text-center">
						<td>______________________________</td>
						<td>______________________________</td>
					</tr>
					<tr class="text-center">
						<td>{{ strtoupper($user_fullname) }}</td>
						<td>{{ strtoupper($executive_director_fullname) }}</td>
					</tr>
					<tr class="text-center">
						<td style="font-size:13px;">{{ $user_role }}</td>
						<td style="font-size:13px;">Executive Director</td>
					</tr>	
				</table>
			</div>         
		</div>
	{{-- tier 2 fy1--}}	
		<div class="pagebreak"> </div>
	{{-- tier 2 fy2--}}
		<h5 class="text-center">{{ $department_header }}</h5>
		<h5 class="text-center">{{ $agency_header }}</h5>
		<h5 class="text-center">LAND AND LAND IMPROVEMENTS - Tier 2</h5>
		<h6 class="text-center">(In Thousand Pesos)</h6>
		<div class="row">
			<div class="col-10">
				<div class="float-right"><?php 
					$sqlFiscalYears = getFiscalYears($year);
					foreach($sqlFiscalYears->where('year', $year) as $row => $key){
						$fiscal_year1 = $key->fiscal_year1;
						$fiscal_year2 = $key->fiscal_year2;
						$fiscal_year3 = $key->fiscal_year3;?><br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year1; }}" 
						onclick="return false;"> FY {{ $fiscal_year1; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year2; }}" 
							@if($fiscal_year1) checked @endif onclick="return false;"> FY {{ $fiscal_year2; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year3; }}" 
							onclick="return false;"> FY {{ $fiscal_year3; }}<?php
					}?>
				</div>
			</div>			
		</div>	
		<div class="col text-right">
			DOST Form No. 3
		</div>		
		<div class="row py-3">			
			<div class="col table-responsive">  
				<table id="bp_form3_table_fy2" class="table-bordered table-hover table" style="width: 100%;">
					<thead>
						<tr class="text-center">
							<th style="min-width:18%;">Description</th>
							<th style="min-width:8%;">Area / SQM</th>
							<th style="min-width:10%;">Location</th>
							<th style="min-width:12%;">Amount</th>
							<th style="min-width:52%;">Justification</th>        
						</tr>     
					</thead>  
					<tbody>
						<?php 
							$count_fy2 = 0;			
							$sqlBpForm3byFY_fy2 = getBpForm3byDivisionbyYearbyTier($user_division_id, '2', $year);
							foreach($sqlBpForm3byFY_fy2 as $row){
								$id = $row->id;
								$description = $row->description;
								$area_sqm = $row->area_sqm;
								$location = $row->location;
								$amount = round($row->amount, -3)/1000;
								$organizational_deployment = $row->organizational_deployment;
								$justification = $row->justification;
								$remarks = $row->remarks;
								$is_active = $row->is_active;
								$count_fy2 = count($sqlBpForm3byFY_fy2);
								$fiscal_year = $row->fiscal_year;
								if($count_fy2 != 0 && $fiscal_year2==$fiscal_year){?>
									<tr class="text-center">
										<td class="text-left">{{ $description }}</td>
										<td>{{ $area_sqm }}</td>
										<td>{{ $location }}</td>
										<td>{{ number_format($amount) }}</td>
										<td class="text-left" style="max-width:300px">{{ $justification }}</td>
									</tr> <?php
								}
								$count_fy2 = $count_fy2 + 1;
							}

							$data_fy2=DB::table('bp_form3')->where('division_id',$user_division_id)->where('year',$year)
								->where('fiscal_year', $fiscal_year2)->where('tier', 2)->where('is_active', 1)->where('is_deleted', 0)->get();  
							if($count_fy2 != 0){
								foreach($data_fy2->groupBy('year') as $key=>$row){
									$amount_gt = round($row->sum('amount'), -3)/1000; ?>
									<tr class="text-center font-weight-bold">
										<td colspan="3" class="text-right">TOTAL</td>
										<td>{{ $amount_gt }}</td>	
										<td></td>
									</tr><?php
								}
							}
							else{?>
								<tr class="text-center font-italic">
									<td colspan="7">No Results Found</td>
								</tr><?php
							}
						?>            
					</tbody>              
				</table>
				<br><br>
				<table class="table-borderless" style="width: 100%;">
					<tr>
						<td>Prepared By:</td>
						<td>Approved By:</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr class="text-center">
						<td>______________________________</td>
						<td>______________________________</td>
					</tr>
					<tr class="text-center">
						<td>{{ strtoupper($user_fullname) }}</td>
						<td>{{ strtoupper($executive_director_fullname) }}</td>
					</tr>
					<tr class="text-center">
						<td style="font-size:13px;">{{ $user_role }}</td>
						<td style="font-size:13px;">Executive Director</td>
					</tr>	
				</table>
			</div>         
		</div>
	{{-- tier 2 fy2--}}
		<div class="pagebreak"> </div>
	{{-- tier 2 fy3--}}
		<h5 class="text-center">{{ $department_header }}</h5>
		<h5 class="text-center">{{ $agency_header }}</h5>
		<h5 class="text-center">LAND AND LAND IMPROVEMENTS - Tier 2</h5>
		<h6 class="text-center">(In Thousand Pesos)</h6>
		<div class="row">
			<div class="col-10">
				<div class="float-right"><?php 
					$sqlFiscalYears = getFiscalYears($year);
					foreach($sqlFiscalYears->where('year', $year) as $row => $key){
						$fiscal_year1 = $key->fiscal_year1;
						$fiscal_year2 = $key->fiscal_year2;
						$fiscal_year3 = $key->fiscal_year3;?><br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year1; }}" 
							onclick="return false;"> FY {{ $fiscal_year1; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year2; }}" 
							onclick="return false;"> FY {{ $fiscal_year2; }}<br>
						<input type="checkbox" id="chk_fy" value="{{ $fiscal_year3; }}" 
							@if($fiscal_year1) checked @endif onclick="return false;"> FY {{ $fiscal_year3; }}<?php
					}?>
				</div>
			</div>			
		</div>	
		<div class="col text-right">
			DOST Form No. 3
		</div>		
		<div class="row py-3">			
			<div class="col table-responsive">  
				<table id="bp_form3_table_fy3" class="table-bordered table-hover table" style="width: 100%;">
					<thead>
						<tr class="text-center">
							<th style="min-width:18%;">Description</th>
							<th style="min-width:8%;">Area / SQM</th>
							<th style="min-width:10%;">Location</th>
							<th style="min-width:12%;">Amount</th>
							<th style="min-width:52%;">Justification</th>          
						</tr>     
					</thead>  
					<tbody>
						<?php 
							$count_fy3 = 0;			
							$sqlBpForm3byFY_fy3 = getBpForm3byDivisionbyYearbyTier($user_division_id, '2', $year);
							foreach($sqlBpForm3byFY_fy3 as $row){
								$id = $row->id;
								$description = $row->description;
								$area_sqm = $row->area_sqm;
								$location = $row->location;
								$amount = round($row->amount, -3)/1000;
								$organizational_deployment = $row->organizational_deployment;
								$justification = $row->justification;
								$remarks = $row->remarks;
								$is_active = $row->is_active;
								$count_fy3 = count($sqlBpForm3byFY_fy3);
								$fiscal_year = $row->fiscal_year;
								if($count_fy3 != 0 && $fiscal_year3==$fiscal_year){?>
									<tr class="text-center">
										<td class="text-left">{{ $description }}</td>
										<td>{{ $area_sqm }}</td>
										<td>{{ $location }}</td>
										<td>{{ number_format($amount) }}</td>
										<td class="text-left" style="max-width:300px">{{ $justification }}</td>
									</tr> <?php
								}
								$count_fy3 = $count_fy3 + 1;
							}

							$data_fy3=DB::table('bp_form3')->where('division_id',$user_division_id)->where('year',$year)
								->where('fiscal_year', $fiscal_year3)->where('tier', 2)->where('is_active', 1)->where('is_deleted', 0)->get();  
							if($count_fy3 != 0){
								foreach($data_fy3->groupBy('year') as $key=>$row){
									$amount_gt = round($row->sum('amount'), -3)/1000; ?>
									<tr class="text-center font-weight-bold">
										<td colspan="3" class="text-right">TOTAL</td>
										<td>{{ $amount_gt }}</td>	
										<td></td>
									</tr><?php
								}
							}
							else{?>
								<tr class="text-center font-italic">
									<td colspan="7">No Results Found</td>
								</tr><?php
							}
						?>            
					</tbody>              
				</table>
				<br><br>
				<table class="table-borderless" style="width: 100%;">
					<tr>
						<td>Prepared By:</td>
						<td>Approved By:</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr class="text-center">
						<td>______________________________</td>
						<td>______________________________</td>
					</tr>
					<tr class="text-center">
						<td>{{ strtoupper($user_fullname) }}</td>
						<td>{{ strtoupper($executive_director_fullname) }}</td>
					</tr>
					<tr class="text-center">
						<td style="font-size:13px;">{{ $user_role }}</td>
						<td style="font-size:13px;">Executive Director</td>
					</tr>	
				</table>
			</div>         
		</div>
	{{-- tier 2 fy3--}}
	</body>
</html> 