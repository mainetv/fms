@extends('layouts.app')

@php
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
	$user_id=getUserID();
	$user_role_id=getUserRoleID($user_id);
@endphp

@section('content')
	<section class="content">
		<div class="card text-left">
			<div class="card-header">
				<h5 class="font-weight-bold">
					Monthly Withholding Tax By Payee
				</h5>            
			</div>   
			<div class="card-body">
				<div class="row">
					<div>
						<label>Month</label>  			
						<select name="month_selected" id="month_selected" class="select_filter">     
							<option value="01" @if($month_selected=='01') {{ 'selected' }}@endif>January</option>
							<option value="02" @if($month_selected=='02') {{ 'selected' }}@endif>February</option>
							<option value="03" @if($month_selected=='03') {{ 'selected' }}@endif>March</option>
							<option value="04" @if($month_selected=='04') {{ 'selected' }}@endif>April</option>
							<option value="05" @if($month_selected=='05') {{ 'selected' }}@endif>May</option>
							<option value="06" @if($month_selected=='06') {{ 'selected' }}@endif>June</option>
							<option value="07" @if($month_selected=='07') {{ 'selected' }}@endif>July</option>
							<option value="08" @if($month_selected=='08') {{ 'selected' }}@endif>August</option>
							<option value="09" @if($month_selected=='09') {{ 'selected' }}@endif>September</option>
							<option value="10" @if($month_selected=='10') {{ 'selected' }}@endif>October</option>
							<option value="11" @if($month_selected=='11') {{ 'selected' }}@endif>November</option>
							<option value="12" @if($month_selected=='12') {{ 'selected' }}@endif>December</option>
						</select>
					</div>&emsp;
					<div>
						<label>Year</label>  			
						<select name="year_selected" id="year_selected" class="select_filter">               
							@foreach ($getYears as $row)
								<option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
							@endforeach    
						</select>  
					</div>&emsp;
				</div>
				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table id="records_table" style="width: 100%;">
								<thead class="text-center">
									<tr>
										<th rowspan="2">Date</th>
										<th rowspan="2">Payee</th>
										<th rowspan="2">TIN</th>
										<th rowspan="2">DV No.</th>
										<th rowspan="2">Ref No.</th>
										<th colspan="8">TAX</th>
									</tr>
									<tr>
										<th>1%</th>
										<th>2%</th>
										<th>2b</th>
										<th>3%</th>
										<th>5%</th>
										<th>6%</th>
										<th>W-Tax</th>
										<th>Total</th>
									</tr>									
								</thead>
								<tbody><?php 
									$data = DB::table('view_lddap_check_tax')->whereMonth('date', $month_selected)->whereYear('date', $year_selected)
										->where('is_active', 1)->where('is_deleted', 0)->where('total_tax','>',0)
										->orderBy('payee', 'ASC')->get();
										foreach($data->groupBy('payee') as $key=>$row){
											foreach($row as $item) {} 
											$tax_one = $row->sum('tax_one');
											$tax_two = $row->sum('tax_two');
											$tax_twob = $row->sum('tax_twob');
											$tax_three = $row->sum('tax_three');
											$tax_five = $row->sum('tax_five');
											$tax_six = $row->sum('tax_six');
											$wtax = $row->sum('wtax');
											$total_tax = $row->sum('total_tax');
											?>
										<tr class="text-right">
											<td class="text-center">{{ $item->date }}</td>
											<td class="text-left">{{ $item->payee }}</td>
											<td class="text-center">{{ $item->tin }}</td>
											<td class="text-center">{{ $item->dv_no }}</td>
											<td class="text-center">{{ $item->ref_no }}</td>
											<td>{{ number_format($tax_one,2) }}</td>
											<td>{{ number_format($tax_two,2) }}</td>
											<td>{{ number_format($tax_twob,2) }}</td>
											<td>{{ number_format($tax_three,2) }}</td>
											<td>{{ number_format($tax_five,2) }}</td>
											<td>{{ number_format($tax_six,2) }}</td>
											<td>{{ number_format($wtax,2) }}</td>
											<td>{{ number_format($total_tax,2) }}</td>
										</tr>
										<?php 
										}
										?>									
								</tbody>
							</table>	 
						</div>    
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
		
		$('.select_filter').on('change', function(){			
			month_selected = $('#month_selected').val(),
			year_selected = $('#year_selected').val(),
			window.location.replace("{{ url('reports/monthly_wtax_by_payee') }}/"+month_selected+"/"+year_selected);
		})	
	</script> 
@endsection	