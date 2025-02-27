@extends('layouts.app')

@php
	// $getAllotmentByYear=getAllotmentByYear($year);	
@endphp

@section('content') 
	<section class="content">
		<div class="card text-left">
			<div class="card-header row">
				<div class="col-10">
					<h5 class="font-weight-bold">
						Statement of Appropiations, Allotments, Obligations, Disbursements and Balances (FAR 1A)
					</h5> 
				</div>
				<div class="col float-right">    
					{{-- <div class="col-2">
						<a target="_blank" href="{{ route('division_proposals.generatePDF', ['division_id'=>$division_id, 'year'=>$year_selected],'year'=>$year_selected) }}" >
							<button class="btn float-right" data-toggle="tooltip" data-placement='auto'
							title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button></a>
					</div> --}}
					<button class="print btn"  data-toggle="tooltip" data-placement='auto'title='Generate PDF'><i class="fa-2xl fa-solid fa-print"></i></button>
					{{-- <button class="export_to_excel btn" onclick="exportToExcel(this)" data-toggle="tooltip" data-placement='auto'title='Export to Excel'>
						<img src="{{ asset('/images/export-to-excel.png') }}" width="50px"></img></button> --}}
				</div>    
			</div>   
			<div class="card-body">
				<div class="row">	
					<div class="col"> 		
						<label>Year: </label>
						<?php $year_selected = $data['year_selected']; ?> 
						<select name="year_selected" id="year_selected" onchange="changeFilter()">   
							<option value="" disabled selected>Select Year</option>
							@for ($year = date('Y'); $year >= 2015; $year--)
								<option value="{{ $year }}">{{ $year }}</option>
							@endfor
						</select>
					</div>	
				</div>	

				{{-- <div class="card-body py-2">			 --}}
					<div class="row py-2">
						<div class="col table-responsive">
							<table width="100%" class="table-hover table2excel" id="tbl_far1" style="font-size: 11px;">
								<thead class="text-center">
									<tr>
										<th rowspan="3">Particulars</th>
										<th rowspan="3">UACS Code</th>
										<th colspan="3">Approriations</th>
										<th colspan="5">Allotments</th>
										<th colspan="5">Current Year Obligations</th>
										<th colspan="5">Current Year Disbursements</th>
										<th colspan="4">Balances</th>
									</tr>
									<tr>
										<th rowspan="2">Authorized Approriations</th>
										<th rowspan="2">Adjustments (Transfer)</th>
										<th rowspan="2">Adjusted Approriations</th>
										<th rowspan="2">Allotments Received</th>
										<th rowspan="2">Adjustments(Reductions)</th>
										<th rowspan="2">Transfer To</th>
										<th rowspan="2">Transfer From</th>
										<th rowspan="2">Adjusted Allotments</th>
										<th rowspan="2">1st Quarter Ending March 31</th>
										<th rowspan="2">2nd Quarter Ending June 30</th>
										<th rowspan="2">3rd Quarter Ending September 30</th>
										<th rowspan="2">4th Quarter Ending December 31</th>
										<th rowspan="2">Total</th>
										<th rowspan="2">1st Quarter Ending March 31</th>
										<th rowspan="2">2nd Quarter Ending June 30</th>
										<th rowspan="2">3rd Quarter Ending September 30</th>
										<th rowspan="2">4th Quarter Ending December 31</th>
										<th rowspan="2">Total</th>
										<th rowspan="2">Unreleased Approriations</th>
										<th rowspan="2">Unobligated Allotments</th>
										<th colspan="2">Unpaid Obligations (15-20)=(23+24)</th>										
									</tr>
									<tr>
										<th>Due and Demandable</th>
										<th>Not Yet Due and Demandable</th>
									</tr>
									<tr>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5=(3+4)</th>
										<th>6</th>
										<th>7</th>
										<th>8</th>
										<th>9</th>
										<th>10=[{6+(-)7}-8+9]</th>
										<th>11</th>
										<th>12</th>
										<th>13</th>
										<th>14</th>
										<th>15=(11+12+13+14)</th>
										<th>16</th>
										<th>17</th>
										<th>18</th>
										<th>19</th>
										<th>20=(16+17+18+19)</th>
										<th>21</th>
										<th>22</th>
										<th>23</th>
										<th>24</th>
									</tr>
								</thead>	
								<tbody>
									@php
										$data = DB::table("view_allotment")->select("view_allotment.*",
											DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
											DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
												AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
											DB::raw("(SELECT SUM(amount) FROM rs_pap
												LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
												WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
												AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
												AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
											)
											->where('year', $year_selected)->where('rs_type_id', 1)
											->where('is_active', 1)->where('is_deleted', 0)											
											->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('sub_object_code','ASC')
											// ->orderByRaw('(object_specific_id is not null) ASC')
											->orderBy('pooled_at_division_id','ASC')
											->groupBy('id')->get();
									@endphp	
									<tr>
										<td nowrap>A. Agency Specific Budget</td>
										<td></td>		
										<td></td>
										<td></td>
										<td></td>				
									</tr>
									@foreach($data->groupBy('allotment_class_id') as $key=>$row)										
										@foreach($row as $item) @endforeach	
										{{-- {{ $row }} --}}
										<tr>
											<td class="font-weight-bold pap1">{{ $item->allotment_class }}</td>		
											<td></td>											
										</tr>
										@foreach($data->where('allotment_class_id', $item->allotment_class_id)->groupBy('expense_account_id') as $key1=>$row1)
											@foreach($row1 as $item1) @endforeach
											{{-- {{ $row1 }} --}}
											@php
													$q1_allotment=$row1->sum('q1_allotment'); 
													$q2_allotment=$row1->sum('q2_allotment'); 
													$q3_allotment=$row1->sum('q3_allotment'); 
													$q4_allotment=$row1->sum('q4_allotment'); 
													$q1_adjustment=$row1->sum('q1_adjustment'); 	
													$q2_adjustment=$row1->sum('q2_adjustment'); 	
													$q3_adjustment=$row1->sum('q3_adjustment'); 	
													$q4_adjustment=$row1->sum('q4_adjustment'); 	
													$q1_obligation=$row1->sum('q1_obligation'); 	
													$q2_obligation=$row1->sum('q2_obligation');	
													$q3_obligation=$row1->sum('q3_obligation');	
													$q4_obligation=$row1->sum('q4_obligation');	
													$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
													$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
													$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
													$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
													$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
													$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
													$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
													$total_allotment_adjustment = $total_allotment + $total_adjustment;
													$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;
												@endphp
											<tr>
												<td class="font-weight-bold subactivity">{{ $item1->expense_account }}</td>
												<td class="text-center font-weight-bold" nowrap>{{ $item1->expense_account_code }}</td>	
												<td class="text-right">{{ number_format($total_allotment, 2)}}</td>		
												<td class="text-right">{{ number_format($total_adjustment, 2)}}</td>		
												<td class="text-right">{{ number_format($total_allotment_adjustment, 2)}}</td>		
												<td class="text-right">{{ number_format($total_allotment, 2)}}</td>	
												<td class="text-right">{{ number_format($total_adjustment, 2)}}</td>	
												<td></td>
												<td></td>
												<td class="text-right">{{ number_format($total_allotment_adjustment, 2)}}</td>	
												<td class="text-right">{{ number_format($q1_obligation, 2)}}</td>	
												<td class="text-right">{{ number_format($q2_obligation, 2)}}</td>	
												<td class="text-right">{{ number_format($q3_obligation, 2)}}</td>	
												<td class="text-right">{{ number_format($q4_obligation, 2)}}</td>	
												<td class="text-right">{{ number_format($total_obligation, 2)}}</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td class="text-right">{{ number_format($total_balance, 2)}}</td>	
												<td class="text-right">{{ number_format($total_balance, 2)}}</td>	
												<td></td>
												<td></td>
											</tr>
											@foreach($data->where('allotment_class_id', $item->allotment_class_id)
												->where('expense_account_id', $item1->expense_account_id)
												->groupBy('object_expenditure_id') as $key2=>$row2)
												@foreach($row2 as $item2) @endforeach
												@php
													$q1_allotment=$row2->sum('q1_allotment'); 
													$q2_allotment=$row2->sum('q2_allotment'); 
													$q3_allotment=$row2->sum('q3_allotment'); 
													$q4_allotment=$row2->sum('q4_allotment'); 
													$q1_adjustment=$row2->sum('q1_adjustment'); 	
													$q2_adjustment=$row2->sum('q2_adjustment'); 	
													$q3_adjustment=$row2->sum('q3_adjustment'); 	
													$q4_adjustment=$row2->sum('q4_adjustment'); 	
													$q1_obligation=$row2->sum('q1_obligation'); 	
													$q2_obligation=$row2->sum('q2_obligation');	
													$q3_obligation=$row2->sum('q3_obligation');	
													$q4_obligation=$row2->sum('q4_obligation');	
													$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
													$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
													$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
													$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
													$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
													$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
													$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
													$total_allotment_adjustment = $total_allotment + $total_adjustment;
													$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;
												@endphp
												<tr>
													<td class="font-weight-bold subactivity1">{{ $item2->object_expenditure }}</td>	
													<td class="text-center font-weight-bold">{{ $item2->object_code }}</td>	
													<td class="text-right">{{ number_format($total_allotment, 2)}}</td>	
													<td class="text-right">{{ number_format($total_adjustment, 2)}}</td>	
													<td class="text-right">{{ number_format($total_allotment_adjustment, 2)}}</td>	
													<td class="text-right">{{ number_format($total_allotment, 2)}}</td>	
													<td class="text-right">{{ number_format($total_adjustment, 2)}}</td>	
													<td></td>
													<td></td>
													<td class="text-right">{{ number_format($total_allotment_adjustment, 2)}}</td>	
													<td class="text-right">{{ number_format($q1_obligation, 2)}}</td>	
													<td class="text-right">{{ number_format($q2_obligation, 2)}}</td>	
													<td class="text-right">{{ number_format($q3_obligation, 2)}}</td>	
													<td class="text-right">{{ number_format($q4_obligation, 2)}}</td>	
													<td class="text-right">{{ number_format($total_obligation, 2)}}</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td class="text-right">{{ number_format($total_balance, 2)}}</td>	
													<td class="text-right">{{ number_format($total_balance, 2)}}</td>	
													<td></td>
													<td></td>
												</tr>												
												@foreach($data->where('allotment_class_id', $item->allotment_class_id)
													->where('expense_account_id', $item1->expense_account_id)
													->where('object_expenditure_id', $item2->object_expenditure_id)
													->groupBy('object_specific_id') as $key3=>$row3)
													@foreach($row3 as $item3) @endforeach
													@php
														$q1_allotment=$row3->sum('q1_allotment'); 
														$q2_allotment=$row3->sum('q2_allotment'); 
														$q3_allotment=$row3->sum('q3_allotment'); 
														$q4_allotment=$row3->sum('q4_allotment'); 
														$q1_adjustment=$row3->sum('q1_adjustment'); 	
														$q2_adjustment=$row3->sum('q2_adjustment'); 	
														$q3_adjustment=$row3->sum('q3_adjustment'); 	
														$q4_adjustment=$row3->sum('q4_adjustment'); 	
														$q1_obligation=$row3->sum('q1_obligation'); 	
														$q2_obligation=$row3->sum('q2_obligation');	
														$q3_obligation=$row3->sum('q3_obligation');	
														$q4_obligation=$row3->sum('q4_obligation');	
														$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
														$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
														$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
														$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
														$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
														$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
														$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
														$total_allotment_adjustment = $total_allotment + $total_adjustment;
														$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;
													@endphp
													@if($item3->object_specific_id != NULL)
														<tr>
															<td class="font-weight-bold subactivity1">{{ $item3->object_specific }}</td>	
															<td class="text-center font-weight-bold">{{ $item3->sub_object_code }}</td>	
															<td class="text-right">{{ number_format($total_allotment, 2)}}</td>	
															<td class="text-right">{{ number_format($total_adjustment, 2)}}</td>	
															<td class="text-right">{{ number_format($total_allotment_adjustment, 2)}}</td>
															<td class="text-right">{{ number_format($total_allotment, 2)}}</td>	
															<td class="text-right">{{ number_format($total_adjustment, 2)}}</td>	
															<td></td>
															<td></td>
															<td class="text-right">{{ number_format($total_allotment_adjustment, 2)}}</td>	
															<td class="text-right">{{ number_format($q1_obligation, 2)}}</td>	
															<td class="text-right">{{ number_format($q2_obligation, 2)}}</td>	
															<td class="text-right">{{ number_format($q3_obligation, 2)}}</td>	
															<td class="text-right">{{ number_format($q4_obligation, 2)}}</td>	
															<td class="text-right">{{ number_format($total_obligation, 2)}}</td>	
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td class="text-right">{{ number_format($total_balance, 2)}}</td>	
															<td class="text-right">{{ number_format($total_balance, 2)}}</td>	
															<td></td>
															<td></td>
														</tr>
													@endif
												@endforeach	
											@endforeach	
										@endforeach	
									@endforeach	
								</tbody>
							</table>		
						</div>	
					</div>	
				{{-- </div>	 --}}
			</div>	
		</div>	
	</section> 	
	@include('reports.saob.modal')			
@endsection
	
@section('jscript')
   <script type="text/javascript" defer>
      $(document).ready(function(){
			@include('reports.saob.script')     
			@include('scripts.common_script') 
      });

		function exportToExcel() {
			$("#saob_table").table2excel({
				exclude: ".excludeThisClass",
				// name: $("#saob_table").data("tableName"),
				filename: "saob.xls",
				preserveColors: false
			});
		}

		// function changeFilter()
		// {     
		// 	rstype_id_selected = $("#rstype_id_selected").val();
		// 	division_id = $('#division_id').val(),
		// 	year_selected = $("#year_selected").val();
		// 	view_selected = $("#view_selected").val();
		// 	if(rstype_id_selected==1 && year_selected=='all'){
		// 		const d = new Date();
		// 		year_selected = d.getFullYear();           
		// 	}
		// 	else if(rstype_id_selected!=1 && division_id!='all'){   
		// 		year_selected = 'all';
		// 	}  
		// 	else if(rstype_id_selected!=1 && division_id=='all'){   
		// 		division_id = 2;
		// 		year_selected = 'all';
		// 	}  
		// 	window.location.replace("{{ url('reports/saob') }}/"+rstype_id_selected+"/"+division_id+"/"+year_selected+"/"+view_selected);
		// }	
   </script>
@endsection
