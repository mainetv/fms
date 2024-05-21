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
						<li class="breadcrumb-item active">Funds Utilization</li>
						<li class="breadcrumb-item active">List of Due and Demandable Accounts Payable (LDDAP)</li>
				</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	
	<section class="content">  
		@php
			$fund_selected = $data['fund_selected'];
			$month_selected = $data['month_selected'];
			$year_selected = $data['year_selected'];
			$division_id = $user_division_id;			
		@endphp
		<div class="card refreshDiv">			
			<div class="card-header">
				<div class="row">
					<div class="col float-left">            
						<h3 class="card-title">
							<i class="fas fa-edit"></i>
							<label for="year_selected">Fund: </label>      
							<select name="fund_selected" id="fund_selected" onchange="changeFilter()">               
								@foreach ($getFunds as $row)
									<option value="{{ $row->id }}" @if(isset($row->fund) && $fund_selected==$row->id){{"selected"}} @endif > {{ $row->fund }}</option>
								@endforeach    
							</select> 
							<label for="year_selected">Month: </label> 
							<select name="month_selected" id="month_selected" onchange="changeFilter()">     
								<option value="01" @if($month_selected=='01') selected @endif>January</option>
								<option value="02" @if($month_selected=='02') selected @endif>February</option>
								<option value="03" @if($month_selected=='03') selected @endif>March</option>
								<option value="04" @if($month_selected=='04') selected @endif>April</option>
								<option value="05" @if($month_selected=='05') selected @endif>May</option>
								<option value="06" @if($month_selected=='06') selected @endif>June</option>
								<option value="07" @if($month_selected=='07') selected @endif>July</option>
								<option value="08" @if($month_selected=='08') selected @endif>August</option>
								<option value="09" @if($month_selected=='09') selected @endif>September</option>
								<option value="10" @if($month_selected=='10') selected @endif>October</option>
								<option value="11" @if($month_selected=='11') selected @endif>November</option>
								<option value="12" @if($month_selected=='12') selected @endif>December</option>
							</select>
							<label for="year_selected">Year: </label>      
							<select name="year_selected" id="year_selected" onchange="changeFilter()">               
								@foreach ($years as $row)
									<option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
								@endforeach    
							</select>                                             
						</h3>
					</div>  					             
					<label for="search_all" class="col-form-label"><i class="fas fa-edit"></i>Search (All)</label>		
					<div class="col-sm-2">															
						<input type="text" id="search_all" name="search_all" class="form-control">
						<input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
						<input type="text" id="division_id" name="division_id" value="{{ $division_id }}" hidden>
					</div>											    
				</div>
			</div>    

			<div class="card-body py-2">			
				<div class="row py-2">
					<div class="col table-responsive">
						<table id="lddap_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								<th style="min-width: 6%; max-width: 6%;">LDDAP ID</th>
								<th style="min-width: 6%; max-width: 6%;">LDDAP/Check Date</th>
								<th style="min-width: 16%; max-width: 16%;">LDDAP/Check No.</th>
								<th style="min-width: 3%; max-width: 3%;">Fund</th>
								<th nowrap style="min-width: 12%; max-width: 12%;">Amount</th>
								<th style="min-width: 8%; max-width: 8%;">ADA No.</th>
								<th style="min-width: 6%; max-width: 6%;">ADA Date</th>
								@role('Accounting Officer')
									<th class="text-center" style="min-width: 3%; max-width: 3%;">						
										<a href="{{ url('funds_utilization/lddap/add') }}" data-toggle="tooltip" data-placement='left'
											title='Add LDDAP' data-year="{{ $year_selected }}">								
										<button type="button" class="btn-xs btn btn-outline-primary"><i class="fa-solid fa-plus fa-lg"></i></button></a>														 
									</th>
								@endrole
							</thead>	
							<tbody><?php 
								$annual_total=0;
								$q1=0;
								$q2=0;
								$q3=0;
								$q4=0;
								$jan_total=0;
								$feb_total=0;
								$mar_total=0;
								$apr_total=0;
								$may_total=0;
								$jun_total=0;
								$jul_total=0;
								$aug_total=0;
								$sep_total=0;
								$oct_total=0;
								$nov_total=0;
								$dec_total=0;
								foreach ($getNCA as $row) {
									$jan=$row->jan_nca;
									$feb=$row->feb_nca;
									$mar=$row->mar_nca;
									$apr=$row->apr_nca;
									$may=$row->may_nca;
									$jun=$row->jun_nca;
									$jul=$row->jul_nca;
									$aug=$row->aug_nca;
									$sep=$row->sep_nca;
									$oct=$row->oct_nca;
									$nov=$row->nov_nca;
									$dec=$row->dec_nca;																
									$jan_total+=$row->jan_nca;
									$feb_total+=$row->feb_nca;
									$mar_total+=$row->mar_nca;
									$apr_total+=$row->apr_nca;
									$may_total+=$row->may_nca;
									$jun_total+=$row->jun_nca;
									$jul_total+=$row->jul_nca;
									$aug_total+=$row->aug_nca;
									$sep_total+=$row->sep_nca;
									$oct_total+=$row->oct_nca;
									$nov_total+=$row->nov_nca;
									$dec_total+=$row->dec_nca;
									$q1 = $jan_total+$feb_total+$mar_total;
									$q2 = $apr_total+$may_total+$jun_total;
									$q3 = $jul_total+$aug_total+$sep_total;
									$q4 = $oct_total+$nov_total+$dec_total;
									$annual_total = $q1+$q2+$q3+$q4;		
								} 

								if ($fund_selected=='1'){
									if($month_selected==1 || $month_selected==2 || $month_selected==3) { $qrt = "1"; $quarter = "1st Quarter";  $quarter_annual_beginning_balance=$q1; }
									if($month_selected==4 || $month_selected==5 || $month_selected==6) { $qrt = "2";  $quarter = "2nd Quarter"; $quarter_annual_beginning_balance=$q2; }
									if($month_selected==7 || $month_selected==8 || $month_selected==9) { $qrt = "3";  $quarter = "3rd Quarter"; $quarter_annual_beginning_balance=$q3; }
									if($month_selected==10 || $month_selected==11 || $month_selected==12) { $qrt = "4";  $quarter = "4th Quarter"; $quarter_annual_beginning_balance=$q4; }
									if($month_selected==1) $month_beginning_balance=$q1; 
									if($month_selected==4) $month_beginning_balance=$q2; 
									if($month_selected==7) $month_beginning_balance=$q3;  
									if($month_selected==10) $month_beginning_balance=$q4;   
									$previous_month = $month_selected-1; 
									
									if($month_selected!=1 && $month_selected!=4 && $month_selected!=7 && $month_selected!=10){
										$previous_month_total = DB::table('view_lddap')->select(DB::raw("SUM(total_lddap_net_amount) AS total_lddap_net_amount"))
											->whereMonth('lddap_date', $previous_month)->whereYear('lddap_date', $year_selected)
											->where('fund_id', $fund_selected)->where('is_active', 1)->where('is_deleted', 0)->pluck('total_lddap_net_amount')->first();
										$month_beginning_balance=$quarter_annual_beginning_balance-$previous_month_total; 
										echo $previous_month_total;           
									}

									if($month_selected==3 || $month_selected==6 || $month_selected==9 || $month_selected==12){
										echo  $previous_month2 = $previous_month-1;      
										$previous_months_total = DB::table('view_lddap')->select(DB::raw("SUM(total_lddap_net_amount) AS total_lddap_net_amount"))
											->where(function ($query) use($previous_month, $previous_month2) {
												$query->whereMonth('lddap_date','=',$previous_month)
													->orWhereMonth('lddap_date','=',$previous_month2);
											})
											->whereYear('lddap_date', $year_selected)
											->where('fund_id', $fund_selected)->where('is_active', 1)->where('is_deleted', 0)->pluck('total_lddap_net_amount')->first();
										$month_beginning_balance=$quarter_annual_beginning_balance-$previous_months_total;  
									}
								}								
								elseif ($fund_selected=='2' || $fund_selected=='3'){
									$quarter="Annual"; $quarter_annual_beginning_balance=$annual_total ?? 0; 
									if($month_selected==1) $month_beginning_balance=$jan; 
									if($month_selected==2) $month_beginning_balance=$feb; 
									if($month_selected==3) $month_beginning_balance=$mar; 
									if($month_selected==4) $month_beginning_balance=$apr; 
									if($month_selected==5) $month_beginning_balance=$may; 
									if($month_selected==6) $month_beginning_balance=$jun; 
									if($month_selected==7) $month_beginning_balance=$jul; 
									if($month_selected==8) $month_beginning_balance=$aug; 
									if($month_selected==9) $month_beginning_balance=$sep; 
									if($month_selected==10) $month_beginning_balance=$oct; 
									if($month_selected==11) $month_beginning_balance=$nov; 
									if($month_selected==12) $month_beginning_balance=$dec; 
									$previous_month = $month_selected-1; 
								}
								?>
								<tr class="text-right font-weight-bold">
									<td colspan="4">NCA Beginning Balance ({{ $quarter }})</td>
									<td>{{ number_format($quarter_annual_beginning_balance, 2) }}</td>
									<td colspan="3"></td>
								</tr>
								<tr class="text-right font-weight-bold">
									<td colspan="4">NCA Beginning Balance ({{ numtomonth($month_selected) }})</td>
									<td>{{ number_format($month_beginning_balance, 2) }}</td>
									<td colspan="3"></td>
								</tr>
								<?php
								$month_total_lddap_net_amount=0;			
								$quarter_annual_ending_balance=0;
								$quarter_annual_total=0;
								$year_total_lddap_amount = DB::table('lddap')->select(DB::raw("SUM(total_lddap_net_amount) AS total_lddap_net_amount"))
									->whereYear('lddap_date', $year_selected)
									->where('fund_id', $fund_selected)->where('is_active', 1)->where('is_deleted', 0)->pluck('total_lddap_net_amount')->first();
								$getLDDAPbyFundMonthYear=getLDDAPbyFundMonthYear($fund_selected, $month_selected, $year_selected);
								foreach($getLDDAPbyFundMonthYear as $row){
									$payment_mode_id=$row->payment_mode_id;
									$month_total_lddap_net_amount += $row->total_lddap_net_amount;
									?>
								<tr class="text-center">
									{{-- <td>{{ $row->id }}</td> --}}
									<td>
										<a data-id="{{ $row->id }}"
											@if($payment_mode_id==1) 
												href="{{ url('funds_utilization/lddap/edit/'.$row->id) }}">
											@elseif($payment_mode_id==2) 
												href="{{ url('funds_utilization/checks/view/'.$row->id) }}">
											@endif 
											{{ $row->id }}
										</a>
									</td>
									<td>{{ $row->lddap_date }}</td>
									<td class="text-left"><a data-id="{{ $row->id }}"
										@if($payment_mode_id==1) 
											href="{{ url('funds_utilization/lddap/edit/'.$row->id) }}">
										@elseif($payment_mode_id==2) 
											href="{{ url('funds_utilization/checks/view/'.$row->id) }}"> Check#
										@endif {{ $row->lddap_no }}</a></td>
									<td>{{ $row->fund }}</td>
									<td class="text-right">{{ number_format($row->total_lddap_net_amount,2) }}</td>
									<td>{{ $row->ada_no }}</td>
									<td>{{ $row->ada_date }}</td>
									@role('Accounting Officer')
										<td>
											<button type="button" class="btn-xs @if($row->total_lddap_net_amount!=0) disabled @else btn_delete @endif 
												btn btn-outline-danger" data-id="{{ $row->id }}" data-toggle="tooltip" data-placement='auto'
												@if($row->total_lddap_net_amount==0) title='Delete LDDAP' @endif>
												<i class="fa-solid fa-trash-can fa-lg @if($row->total_lddap_net_amount!=0) gray @endif"></i>
											</button>
										</td>
									@endrole
								</tr>
								<?php
								}
								if ($fund_selected=='1'){
									if($month_selected==1) $quarter_annual_ending_balance=$q1-$month_total_lddap_net_amount; 
									if($month_selected==4) $quarter_annual_ending_balance=$q2-$month_total_lddap_net_amount; 
									if($month_selected==7) $quarter_annual_ending_balance=$q3-$month_total_lddap_net_amount;  
									if($month_selected==10) $quarter_annual_ending_balance=$q4-$month_total_lddap_net_amount;        
							
									if($month_selected!=1 && $month_selected!=4 && $month_selected!=7 && $month_selected!=10){   
										$previous_month = $month_selected-1;       
										$quarter_annual_ending_balance=$month_beginning_balance-$month_total_lddap_net_amount;  
										$quarter_annual_total=$previous_month_total+$month_total_lddap_net_amount;  
									}  
									else{
										$quarter_annual_total=$month_total_lddap_net_amount;     
									} 

									if($month_selected==3 || $month_selected==6 || $month_selected==9 || $month_selected==12){  
										$quarter_annual_ending_balance=$month_beginning_balance-$month_total_lddap_net_amount; 
										$quarter_annual_total=$previous_month_total+$month_total_lddap_net_amount;  
									}   
								}
								elseif ($fund_selected=='2' || $fund_selected=='3'){ 
									// $quarter_annual_ending_balance=$annual_total-$month_total_lddap_net_amount;
									$quarter_annual_ending_balance=$annual_total-$year_total_lddap_amount;
								}
								?>
								<tr class="text-right font-weight-bold">
									<td colspan="4">Total ({{ numtomonth($month_selected) }})</td>
									<td>{{ number_format($month_total_lddap_net_amount, 2) }}</td>
									<td colspan="3"></td>
								</tr>
								<tr class="text-right font-weight-bold">
									<td colspan="4">Total (January to December)</td>
									<td>{{ number_format($year_total_lddap_amount, 2) }}</td>
									<td colspan="3"></td>
								</tr>
								<tr class="text-right font-weight-bold">
									<td colspan="4">Total ({{ $quarter }})</td>
									<td>{{ number_format($quarter_annual_total, 2) }}</td>
									<td colspan="3"></td>
								</tr>
								<tr class="text-right font-weight-bold">
									<td colspan="4">NCA Ending Balance ({{ $quarter }})</td>
									<td>{{ number_format($quarter_annual_ending_balance, 2) }}</td>
									<td colspan="3"></td>
								</tr>
							</tbody>
						</table>	 
					</div>    
				</div>					
			</div>
		</div>            
	</section>
	@include('funds_utilization.lddap.modal')	
@endsection

@section('jscript')
  <script type="text/javascript">   
		$(document).ready(function(){ 
		@include('funds_utilization.lddap.script')   
		@include('scripts.common_script')   
		}) 

    	function changeFilter()
		{         
			fund = $("#fund_selected").val();
			month = $("#month_selected").val();
      	year = $("#year_selected").val();
			window.location.replace("{{ url('funds_utilization/lddap') }}/"+fund+"/"+month+"/"+year);
		}
   </script>  
@endsection

