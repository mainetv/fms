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
						MONTHLY REPORT OF DISBURSEMENTS (FAR 4)
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
										<th colspan="5">Current Year Budget</th>
										<th colspan="12">Prior Year's Budget</th>
										
										<th colspan="4">Trust Liabilities</th>																				
										<th colspan="5">Grand Total</th>
										<th rowspan="3">Remarks</th>
									</tr>
									<tr>										
										<th rowspan="2">PS</th>
										<th rowspan="2">MOOE</th>
										<th rowspan="2">FinEx</th>
										<th rowspan="2">CO</th>
										<th rowspan="2">Total</th>

										<th colspan="5">Prior Year's Accounts Payable</th>
										<th colspan="5">Curent Year's Accounts Payable</th>										
										<th rowspan="2">Total</th>
										<th rowspan="2">Sub-Total</th>

										<th rowspan="2">PS</th>
										<th rowspan="2">MOOE</th>
										<th rowspan="2">CO</th>
										<th rowspan="2">Total</th>
										
										<th rowspan="2">PS</th>
										<th rowspan="2">MOOE</th>
										<th rowspan="2">FinEx</th>
										<th rowspan="2">CO</th>
										<th rowspan="2">Total</th>
									</tr>
									<tr>											
										<th>PS</th>
										<th>MOOE</th>
										<th>FinEx</th>
										<th>CO</th>
										<th>Sub-Total</th>
										<th>PS</th>
										<th>MOOE</th>
										<th>FinEx</th>
										<th>CO</th>
										<th>Sub-Total</th>
									</tr>
									<tr>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
										<th>5</th>
										<th>6=(2+3+4+5)</th>
										<th>7</th>
										<th>8</th>
										<th>9</th>
										<th>10</th>
										<th>11=(7+8+9+10)</th>
										<th>12</th>
										<th>13</th>
										<th>14</th>
										<th>15</th>
										<th>16=</th>
										<th>17=(11+16)</th>
										<th>18=(6+17)</th>
										<th>19</th>
										<th>20</th>
										<th>21</th>
										<th>22</th>
										<th>23=(19+20+21)</th>
										<th>24</th>
										<th>25</th>
										<th>26</th>
										<th>27=(23+24+25+26)</th>
										<th>28</th>
									</tr>
								</thead>	
								<tbody>
									@php
										$data = DB::table("view_financial_summary")
											->whereYear('rs_date', $year_selected)->where('rs_type_id', 1)->whereNull('dv_no')
											->orderBy('allotment_class_id', 'ASC')->orderBy('payee', 'ASC')
											->groupBy('rs_id')->get();	
									@endphp	
									@php $rowNumber = 1; @endphp
									@foreach($data->groupBy('rs_type_id') as $key=>$row)										
										@foreach($row as $item) @endforeach	
										<tr class="font-weight-bold">
											<td>CASH DISBURSEMENTS</td>
											<td></td>
											<td></td>
											<td class="text-center" nowrap>{{ number_format($item->total_rs_pap_amount, 2) }}</td>		
											<td class="text-center" nowrap>{{ number_format($item->total_rs_pap_amount, 2) }}</td>		
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>		
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>				
											<td></td>		
											<td></td>		
											<td></td>		
										</tr>										
										@foreach($data->groupBy('allotment_class_id') as $key1=>$row1)										
											@foreach($row1 as $item1) @endforeach									
											<tr class="font-weight-bold">
												<td class="activity1">{{ $item1->allotment_class }}</td>
												<td></td>
												<td></td>
												<td class="text-center" nowrap>{{ number_format($item1->total_rs_pap_amount, 2) }}</td>
												<td class="text-center" nowrap>{{ number_format($item1->total_rs_pap_amount, 2) }}</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>																		
										@endforeach	
											
										@foreach($data->where('allotment_class_id', $item1->allotment_class_id)->groupBy('rs_id') as $key2=>$row2)										
											@foreach($row2 as $item2) @endforeach						
											<tr>
												<td class="subactivity1">{{ $item2->payee }}</td>
												<td class="text-center" nowrap>{{ $item2->rs_no }}</td>
												<td class="text-center" nowrap>{{ $item2->rs_date }}</td>
												<td class="text-center" nowrap>{{ number_format($item2->total_rs_pap_amount, 2) }}</td>
												<td class="text-center" nowrap>{{ number_format($item2->total_rs_pap_amount, 2) }}</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>																	
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
