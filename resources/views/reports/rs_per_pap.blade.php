@extends('layouts.app')

@php
	$getAllActiveDivisions=getAllActiveDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
@endphp
@section('content')	
	<section class="content">
		<div class="card text-left">
			<SCRIPT LANGUAGE="JavaScript">
				function printThis()
				{
		
					window.print();
				}
			</script>
			<div class="card-header row">
				<div class="col-11">
					<h5 class="font-weight-bold">
						Summary of ORS per PAP/Account Code
					</h5> 
				</div>
				<div class="col-1">    
					<button class="print btn float-left"  data-toggle="tooltip" data-placement='auto'title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button>
				</div>    
			</div>   
			<div class="card-body">
				<div class="row">		
					<label>Request and Status Type:</label> 
					<div>&nbsp;		  	
						<select name="rstype_id_selected" id="rstype_id_selected" onChange="changeFilter()">               
							@foreach ($getRSTypes as $row)
								<option value="{{ $row->id }}" @if(isset($row->id) && $rstype_id_selected==$row->id){{"selected"}} @endif > {{ $row->request_status_type }}</option>
							@endforeach    
						</select>
					</div>	&emsp;
					<label>Date range:</label>   
					<div>&nbsp;
						<input type="text" name="date_range" id="date_range"/>						
					</div> 
				</div>
				<div class="card-body py-2">			
					<div class="row py-2">
						<div class="col table-responsive">
							<table id="records_table" style="width: 100%;">
								<thead class="text-center">
									<th style="min-width:6%; max-width:6%;">Object Code</th>
									<th style="min-width:28%; max-width:28%;">Activity</th>
									<th style="min-width:12%; max-width:12%;">ORS/BURS No.</th>
									<th style="min-width:6%; max-width:6%;">Date</th>
									<th style="min-width:5%; max-width:5%;">Division</th>
									<th style="min-width:16%; max-width:16%;">Payee</th>
									<th style="min-width:20%; max-width:20%;">Object</th>
									<th style="min-width:7%; max-width:7%;">Amount</th>
								</thead>
								<tbody>
								<?php
								if($rstype_id_selected==1){								
									$data = DB::table('view_rs_summary')->where('rs_type_id', $rstype_id_selected)->where('is_active', 1)->where('is_deleted', 0)
										->where('rs_id','!=',39857)->where('rs_id','!=',39875)->where('rs_id','!=',39876)
										->where('rs_id','!=',40177)->where('rs_id','!=',40178)->where('rs_id','!=',40179)
										->where('rs_id','!=',40376)->where('rs_id','!=',40377)->where('rs_id','!=',40378)
										->where(function ($query) use ($start_date, $end_date) {
											$query->where(function ($query) use ($start_date, $end_date){
													$query->where('rs_no','!=','')
														->where('rs_date','>=',$start_date)
														->where('rs_date','<=',$end_date)
														->whereNull('notice_adjustment_date');
												})
												->orWhere(function ($query)use ($start_date, $end_date) {
													$query->where('notice_adjustment_date','>=',$start_date)
														->where('notice_adjustment_date','<=',$end_date);
												});
										})
										->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id', 'ASC')
										->orderBy('object_code', 'ASC')->orderBy('object_expenditure', 'ASC')
										->orderBy('expense_account_code', 'ASC')->orderBy('expense_account', 'ASC')
										->orderBy('allotment_division_acronym', 'ASC')->orderBy('rs_no', 'ASC')->get();
								}
								else{
									$data = DB::table('view_rs_summary')->where('rs_type_id', $rstype_id_selected)->where('is_active', 1)->where('is_deleted', 0)
										->where('rs_id','!=',39857)->where('rs_id','!=',39875)->where('rs_id','!=',39876)
										->where('rs_id','!=',40177)->where('rs_id','!=',40178)->where('rs_id','!=',40179)
										->where('rs_id','!=',40376)->where('rs_id','!=',40377)->where('rs_id','!=',40378)
										->where(function ($query) use ($start_date, $end_date) {
											$query->where(function ($query) use ($start_date, $end_date){
													$query->where('rs_no','!=','')
														->where('rs_date','>=',$start_date)
														->where('rs_date','<=',$end_date)
														->whereNull('notice_adjustment_date');
												})
												->orWhere(function ($query)use ($start_date, $end_date) {
													$query->where('notice_adjustment_date','>=',$start_date)
														->where('notice_adjustment_date','<=',$end_date);
												});
										})
										->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id', 'ASC')										
										->orderBy('expense_account_code', 'ASC')->orderBy('expense_account', 'ASC')
										->orderBy('object_code', 'ASC')->orderBy('object_expenditure', 'ASC')
										->orderBy('allotment_division_acronym', 'ASC')->orderBy('rs_no', 'ASC')->get();
								}
								foreach($data->groupBY('pap') as $key=>$row){
									foreach($row as $item) {} ?>
									<tr class="text-center">
										<td class="text-left gray2-bg font-weight-bold" colspan="9">{{ $item->pap }}</td>
									</tr><?php 									
									foreach($data->where('pap', $item->pap)->where('is_gia', 0)->groupBy('allotment_class_id') as $key1=>$row1){
										foreach($row1 as $item1) {}
										foreach($data->where('pap', $item->pap)
											->where('allotment_class_id', $item1->allotment_class_id)		
											->where('is_gia', 0)
											->groupBy('id') as $key2=>$row2){
											foreach($row2 as $item2) {}?>
											<tr class="text-center">
												<td class="text-left">
													@if($item2->object_expenditure==NULL) {{ $item2->expense_account_code }} @else{{ $item2->object_code }} @endif
												</td>
												<td class="text-left">
													@if($item2->rs_type_id==1)
														{{ $item2->activity }}
														@if($item2->subactivity!=NULL) - {{ $item2->subactivity }} @endif
													@else
														@if($item2->subactivity==NULL) {{ $item2->activity }} @else {{ $item2->subactivity }} @endif
													@endif													
													@if($item2->object_specific!=NULL) - {{ $item2->object_specific }} @endif
												</td>										
												<td>@if($item2->notice_adjustment_no==NULL ) {{ $item2->rs_no }} @else {{ $item2->notice_adjustment_no }} @endif</td>
												<td>@if($item2->notice_adjustment_no==NULL ) {{ $item2->rs_date }} @else {{ $item2->notice_adjustment_date }} @endif</td>
												<td>{{ $item2->allotment_division_acronym }}</td>
												<td class="text-left">{{ $item2->payee }}</td>
												<td class="text-left">
													@if($item2->object_expenditure==NULL) {{ $item2->expense_account }} @else{{ $item2->object_expenditure }} @endif
												</td>
												<td class="text-right">{{ number_format($item2->amount, 2) }}</td>
											</tr><?php
										}
										if(isset($item1->allotment_class_id)){
											$amount = $row1->sum('amount');?>
											<tr class="text-right font-weight-bold gray-bg">
												<td colspan="7" class="font-weight-bold">Total {{ $item2->allotment_class_acronym }}&nbsp;</td>													
												<td class="font-weight-bold"> {{ number_format($amount, 2) }}</td>													
											</tr>
											<?php
										}
									}
									foreach($data->where('pap', $item->pap)->where('is_gia', 1)->groupBy('allotment_class_id') as $key1=>$row1){
										foreach($row1 as $item1) {}
										foreach($data->where('pap', $item->pap)
											->where('allotment_class_id', $item1->allotment_class_id)		
											->where('is_gia', 1)
											->groupBy('id') as $key2=>$row2){
											foreach($row2 as $item2) {}?>
											<tr class="text-center">
												<td class="text-left">
													@if($item2->object_expenditure==NULL) {{ $item2->expense_account_code }} @else{{ $item2->object_code }} @endif
												</td>
												<td class="text-left">
													@if($item2->rs_type_id==1)
														{{ $item2->activity }}
														@if($item2->subactivity!=NULL) - {{ $item2->subactivity }} @endif
													@else
														@if($item2->subactivity==NULL) {{ $item2->activity }} @else {{ $item2->subactivity }} @endif
													@endif													
													@if($item2->object_specific!=NULL) - {{ $item2->object_specific }} @endif
												</td>										
												<td>@if($item2->notice_adjustment_no==NULL ) {{ $item2->rs_no }} @else {{ $item2->notice_adjustment_no }} @endif</td>
												<td>@if($item2->notice_adjustment_no==NULL ) {{ $item2->rs_date }} @else {{ $item2->notice_adjustment_date }} @endif</td>
												<td>{{ $item2->allotment_division_acronym }}</td>
												<td class="text-left">{{ $item2->payee }}</td>
												<td class="text-left">
													@if($item2->object_expenditure==NULL) {{ $item2->expense_account }} @else{{ $item2->object_expenditure }} @endif
												</td>
												<td class="text-right">{{ number_format($item2->amount, 2) }}</td>
											</tr><?php
										}
										if(isset($item1->allotment_class_id)){
											$amount = $row1->sum('amount');?>
											<tr class="text-right font-weight-bold gray-bg">
												<td colspan="7" class="font-weight-bold">Total {{ $item2->allotment_class_acronym }} - GIA&nbsp;</td>													
												<td class="font-weight-bold"> {{ number_format($amount, 2) }}</td>													
											</tr>
											<?php
										}
									}
									if(isset($item->pap)){
										$amount = $row->sum('amount');?>
										<tr class="text-right font-weight-bold gray-bg">
											<td colspan="7" class="font-weight-bold">Total PAP, {{ $item->pap_code }}&nbsp;</td>													
											<td class="font-weight-bold"> {{ number_format($amount, 2) }}</td>													
										</tr>
										<?php
									}									
								}
								foreach($data->groupBy('rs_type_id') as $keySum=>$rowSum){
									foreach($rowSum as $itemSum){}
									$amount = $rowSum->sum('amount');?>
									<tr class="text-right font-weight-bold gray-bg">
										<td colspan="7" class="font-weight-bold">GRAND TOTAL&nbsp;</td>													
										<td class="font-weight-bold"> {{ number_format($amount, 2) }}</td>													
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

		function getCurrenURL() {
			return window.location.pathname.split('/');
		}
		var current_filter = getCurrenURL();
		//server
		var start_date = `${current_filter[5]}`; 
		var end_date = `${current_filter[6]}`; 
		//local
		// var start_date = `${current_filter[6]}`; 
		// var end_date = `${current_filter[7]}`; 

		$('#date_range').daterangepicker(
			{
				locale: {
					format: 'YYYY-MM-DD',
				},
				showDropdowns: true,
				startDate: start_date,
				endDate: end_date,
			},
			function(start, end) {
				console.log(start.format('YYYY-MM-DD'));	
				console.log(end.format('YYYY-MM-DD'));	
				start_date = start.format('YYYY-MM-DD');
				end_date = end.format('YYYY-MM-DD');
				changeFilter(start_date, end_date);		
			},	
		);

		function changeFilter(){
			rstype_id_selected = $('#rstype_id_selected').val(),
			window.location.replace("{{ url('reports/rs_per_pap') }}/"+rstype_id_selected+"/"+start_date+"/"+end_date);
		}

		$('.print').on('click', function(e){ 
			rstype_id_selected = $('#rstype_id_selected').val();
			window.open("{{ url('/print_rs_per_pap') }}/"+rstype_id_selected+"/"+start_date+"/"+end_date);
		})      
	</script> 
@endsection	