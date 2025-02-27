@extends('layouts.app')

@php
	$getAllotmentByYear=getAllotmentByYear($year);	
@endphp

@section('content') 
	<section class="content">
		<div class="card text-left">
			<div class="card-header row">
				<div class="col-10">
					<h5 class="font-weight-bold">
						Statement of Appropiations, Allotments, Obligations, Disbursements and Balances (FAR 1)
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
								@php
									$data = DB::table("view_allotment")->where('rs_type_id', 1)->where('year', $year)
										->where('is_active', 1)->where('is_deleted', 0)
										->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
										->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
										->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
										->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
										->get();
								@endphp		
								<tbody>
									<tr>
										<td nowrap>I. Agency Specific Budget</td>
										<td></td>		
										<td></td>
										<td></td>
										<td></td>				
									</tr>
									@foreach($getAllotmentByYear->groupBy('year') as $key=>$row)										
										@foreach($row as $item) @endforeach	
										<tr>
											<td>{{ $item->pap }}</td>
										</tr>
											{{-- 1st --}}
												{{-- <tr>
													<td class="pap1" nowrap>General Administration and Support</td>		
													<td>100000000000000</td>	
													<td></td>
													<td></td>
													<td></td>											
													<td>{{ $item->q1_allotment }}</td>											
												</tr>
												<tr>										
													<td class="pap2" nowrap>General Management and Supervision</td>		
													<td>100000100001000</td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="activity1">PS</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="activity1">MOOE</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td class="pap">Administration of Personnel Benefits</td>	
													<td>100000100002000</td>
													<td></td>
													<td></td>
													<td></td>								
												</tr>		
												<tr>										
													<td class="activity1">PS</td>		
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="font-weight-bold">Sub-Total, General Administration and Support</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td class="activity1">PS</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="activity1">MOOE</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="activity1">FinEx (if Applicable)</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="activity1">CO</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td class="pap1">Operations</td>		
													<td>300000000000000</td>	
													<td></td>
													<td></td>
													<td></td>						
												</tr>		
												<tr>
													<td class="pap">OO:  Increased benefits to Filipinos from science-based know-how and tools for agricultural productivity in the agriculture, aquatic and natural resources (AANR) Sectors</td>									
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>		
												<tr>
													<td class="pap">National AANR Sector R&D Program</td>		
													<td></td>	
													<td></td>
													<td></td>
													<td></td>						
												</tr>	
												<tr>
													<td class="pap2">Development, integration and coordination of the National Research System for the AANR Sector</td>	
													<td>310100100001000</td>	
													<td></td>
													<td></td>
													<td></td>							
												</tr>		
												<tr>										
													<td class="activity1">PS</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="activity1">MOOE</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>	
												<tr>										
													<td class="font-weight-bold">Sub-Total, Operations</td>
													<td></td>	
													<td></td>
													<td></td>
													<td></td>
												</tr>		
												<tr>										
													<td class="activity1">PS</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>		
												<tr>										
													<td class="activity1">MOOE</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="activity1">FinEx (if Applicable)</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="activity1">CO</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="font-weight-bold">Sub-Total, I. Agency Specific Budget</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>										
													<td class="activity1">PS</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>	
												<tr>										
													<td class="activity1">MOOE</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>	
												<tr>										
													<td class="activity1">FinEx (if Applicable)</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>	
												<tr>										
													<td class="activity1">CO</td>	
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>	 --}}
										{{-- 1st end --}}
										{{-- @foreach($getAllotmentByYear->where('pap_code', $item->pap_code) as $key1=>$row1)
											@foreach($row1 as $item1) @endforeach --}}
											{{-- {{ $item1 }} --}}
											{{-- <tr>
												<td>{{ $item->pap->parentPap->pap ?? '' }}</td>											
												<td>{{ $item->pap->pap_code ?? '' }}</td>		
											</tr>
											<tr>
												<td>{{ $item1->pap->pap ?? '' }}</td>											
												<td>{{ $item1->pap->pap_code ?? '' }}</td>		
												<td></td>									
												<td></td>									
												<td></td>									
												<td></td>									
											</tr> --}}
											{{-- @foreach($getAllotmentByYear->where('year', $item->year)
												->where('pap_id', $item1->pap_id)->groupBy('objectExpenditure.allotmentClass') as $key2=>$row2)
												@foreach($row2 as $item2) @endforeach
											@endforeach	 --}}
										{{-- @endforeach	 --}}
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
