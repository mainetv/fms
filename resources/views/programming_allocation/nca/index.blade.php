@extends('layouts.app')

@section('content')
	@php
		$user_division_id=getUserDivisionID($user_id);
		$user_role_id=getUserRoleID($user_id);
		$getFunds=getFunds();
		$getYears=getYears();
	@endphp
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">{{ $title }}</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
						<li class="breadcrumb-item active">Programming & Allocation</li>
						<li class="breadcrumb-item active">{{ $title }}</li>
				</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	
	<section class="content">  
		<div class="card refreshDiv">			
			<div class="card-header">
				<div class="row">
					<div class="col-10 float-left">  
							@csrf              
							<h3 class="card-title float-left">
								<i class="fas fa-edit"></i>
								<label for="fund_selected">Fund: </label>                
								<select name="fund_selected" id="fund_selected" onchange="changeFilter()">               
									@foreach ($getFunds as $row)
										<option value="{{ $row->id }}" @if(isset($row->fund) && $fund_selected==$row->id){{"selected"}} @endif > {{ $row->fund }}</option>
									@endforeach    
								</select> 
								<label for="year_selected">Year: </label>   
								<select name="year_selected" id="year_selected" onchange="changeFilter()">               
									@foreach ($getYears as $row)
										<option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
									@endforeach    
								</select>                                              
							</h3>				
					</div>  												    
				</div>
			</div>    

			<div class="card-body py-2">		
				<div class="row">
					<div class="col-4 float-left">
					</div>
					<div class="col-4 text-center">
					</div>	
					<div class="col-4 py-2 float-right">
					</div>	  
				</div>			
				<div class="row py-3">
					<div class="col table-responsive">						
						<table id="nca_table" class="table-bordered table-hover" style="width: 100%;">
							<thead class="text-center">
								<th>YEAR</th> 
								{{-- <th>Annual</th> --}}
								<th>Jan</th>
								<th>Feb</th>
								<th>Mar</th>										
								<th>Apr</th>										
								<th>May</th>										
								<th>Jun</th>										
								<th>Jul</th>										
								<th>Aug</th>										
								<th>Sep</th>										
								<th>Oct</th>										
								<th>Nov</th>										
								<th>Dec</th>	
								@role('Accounting Officer')
									<td class="text-center" style="min-width:60px">										
										<button type="button" class="btn-xs btn_add" data-year="{{ $year_selected }}" 
											data-fund-id="{{ $fund_selected }}"
											data-toggle="modal" data-target="#nca_modal" data-toggle="tooltip" 
											data-placement='auto' title='Add NCA'><i class="fa-solid fa-plus fa-lg blue"></i>
										</button>&nbsp;																			 
									</td>
								@endrole
							</thead>		
							<tbody><?php
								$annual_total=0;
								$q1=0;
								$q2=0;
								$q3=0;
								$q4=0;
								foreach($nca as $row){
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
									$annual_total = $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec;
									$q1 = $jan+$feb+$mar;
									$q2 = $apr+$may+$jun;
									$q3 = $jul+$aug+$sep;
									$q4 = $oct+$nov+$dec;
									?>
									<tr class="text-right">
										<td class="text-center">{{ $row->year }}</td>
										{{-- <td>{{ $annual_total }}</td> --}}
										<td>{{ number_format($jan,2) }}</td>
										<td>{{ number_format($feb,2) }}</td>
										<td>{{ number_format($mar,2) }}</td>
										<td>{{ number_format($apr,2) }}</td>
										<td>{{ number_format($may,2) }}</td>
										<td>{{ number_format($jun,2) }}</td>
										<td>{{ number_format($jul,2) }}</td>
										<td>{{ number_format($aug,2) }}</td>
										<td>{{ number_format($sep,2) }}</td>
										<td>{{ number_format($oct,2) }}</td>
										<td>{{ number_format($nov,2) }}</td>
										<td>{{ number_format($dec,2) }}</td>
									</tr><?php
								}?>
								<tr class="text-center font-weight-bold">
									<td></td>
									<td colspan="3">Q1: {{ number_format($q1,2) }}</td>
									<td colspan="3">Q2: {{ number_format($q2,2) }}</td>
									<td colspan="3">Q3: {{ number_format($q3,2) }}</td>
									<td colspan="3">Q4: {{ number_format($q4,2) }}</td>
								</tr>
								<tr class="text-center font-weight-bold">
									<td></td>
									<td colspan="12">TOTAL: {{ number_format($annual_total,2) }}</td>
								</tr>
							</tbody>
						</table>	 
					</div>    
				</div>					
			</div>
		</div>            
	</section>
	@include('programming_allocation.nca.modal')	
@endsection

@section('jscript')
   <script type="text/javascript">     
      $(document).ready(function(){   
         @include('programming_allocation.nca.script')   
         @include('scripts.common_script')   

			$('.select2bs4').select2({
				theme: 'bootstrap4'
			})     

			$(document).on('select2:open', () => {
				document.querySelector('.select2-search__field').focus();
			});   
      })  
		function changeFilter()
		{
			fund_selected = $("#fund_selected").val();
			year_selected = $("#year_selected").val();
			window.location.replace("{{ url('programming_allocation/nca') }}/"+fund_selected+"/"+year_selected);
		}	
   </script>  
@endsection

