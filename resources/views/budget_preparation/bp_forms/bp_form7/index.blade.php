     
<?php
   $fiscal_year = $value->fiscal_year;
   $year = $value->year;?>
   @unlessrole('Cluster Budget Controller|Division Director|Division Budget Controller')
      @php $sqlBpForm7byFY = getBpForm7byFY($year, $fiscal_year);  @endphp
   @endrole
   @role('Division Budget Controller|Cluster Budget Controller|Division Director')
      @php $sqlBpForm7byFY = getBpForm7byDivisionbyFY($user_division_id, $year, $fiscal_year);  @endphp
   @endrole
<h4>LIST OF GRANT-IN-AID PROJECTS</h4>
<h6>DOST Form No. 7</h6>
<div class="content">
  <div class="row">
   <div class="col-12">
      <div class="float-right"><?php          
         foreach($fiscal_years as $row => $key){?><br>
            <input type="checkbox" id="chk_fy" value="{{ $key->fiscal_year; }}" onclick="return false;"
               @if($key->fiscal_year == $fiscal_year) checked @endif> FY {{ $key->fiscal_year; }} <?php
         }?>
      </div>
   </div>
  </div>
</div>
<div class="row py-3">
   <div class="col table-responsive">      
      <table id="bp_form7_table" class="table table-bordered data-table">
         <thead>            
            <tr>
               <th rowspan=2>Program Title</th>
               <th rowspan=2>Project Title</th>
               <th rowspan=2>Location</th>
               <th rowspan=2>Benefeciaries</th>
               <th colspan=2>Project Duration</th>
               <th rowspan=2>Total Project Cost</th>  
               <th rowspan=2>Implementing Agency</th>      
               <th rowspan=2>Monitoring Agency</th>
               <th colspan=3>Fund Allocation by Year</th>
               <th rowspan=2 style="min-width:40px; max-width:50px;"></th>
            </tr>     
            <tr id="second_row_header">
               <th>Start Date</th>
               <th>End Date</th><?php  
               // $sql = fiscal_years($year);
               foreach($fiscal_years as $row => $value){ ?>
                  <th>{{ $value->fiscal_year }}</th><?php 
               } ?>
            </tr>
         </thead>  
         <tbody>
            <?php 
               $count = 0;
               foreach($sqlBpForm7byFY as $row){
                  $id = $row->id;
                  $program = $row->program;
                  $project = $row->project;
                  $location_id = $row->location_id;
                  $beneficiaries = $row->beneficiaries;
                  $start_date = $row->start_date;
                  $end_date = $row->end_date;
                  $total_project_cost = $row->total_project_cost;
                  $implementing_agency = $row->implementing_agency;
                  $monitoring_agency = $row->monitoring_agency;
                  $fund_allocation_fiscal_year1 = $row->fund_allocation_fiscal_year1;
                  $fund_allocation_fiscal_year2 = $row->fund_allocation_fiscal_year2;
                  $fund_allocation_fiscal_year3 = $row->fund_allocation_fiscal_year3;
                  $remarks = $row->remarks;
                  $is_active = $row->is_active;
                  $count = count($sqlBpForm7byFY);
                  if($count != 0){?>
                     <tr>
                        <td>{{ $program }}</td>
                        <td>{{ $project }}</td>
                        <td>{{ $location_id }}</td>
                        <td>{{ $beneficiaries }}</td>
                        <td>{{ $start_date }}</td>
                        <td>{{ $end_date }}</td>
                        <td>{{ $total_project_cost }}</td>
                        <td>{{ $implementing_agency }}</td>
                        <td>{{ $monitoring_agency }}</td>
                        <td>{{ $fund_allocation_fiscal_year1 }}</td>
                        <td>{{ $fund_allocation_fiscal_year2 }}</td>
                        <td>{{ $fund_allocation_fiscal_year3 }}</td>
                        <td class="text-center"> 		
                           <button type="button" class="btn-xs btn_view_bp_form7" data-id="{{ $id }}"
                              data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                              data-placement='auto' title='View'>
                              <i class="fa-solid fas fa-eye"></i>																					
                           </button>																						 
                        </td>
                     </tr> <?php
                  }
                  $count = $count + 1;
               }
               if($count == 0){?>
                  <tr>
                     <td class="font-italic" colspan="13">No Results Found</td>
                  </tr>
               <?php
               }
            ?>            
         </tbody>           
      </table>
   </div>         
</div>
{{-- <script type="text/javascript">
   
</script>   --}}