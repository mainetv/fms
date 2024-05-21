@unlessrole('Cluster Budget Controller|Division Director|Division Budget Controller')
   @php $sqlBpForm205byFY = getBpForm205byFY($year, $fiscal_year1);  @endphp
@endrole
@role('Cluster Budget Controller|Division Director')
   @php $sqlBpForm205byFY = getBpForm205byClusterbyFY($user_division_id, $year, $fiscal_year1);  @endphp
@endrole
@role('Division Budget Controller')
   @php $sqlBpForm205byFY = getBpForm205byDivisionbyFY($user_division_id, $year, $fiscal_year1);  @endphp
@endrole
<h4>LIST OF RETIREES</h4>
<h6>BP Form 205</h6>
<h6>FY {{ $fiscal_year1 }}</h6>
<div class="content">
  <div class="row">
    <div class="col-2">
      @role('Division Budget Controller')
         <button data-division-id={{ $user_division_id }} data-year="{{ $year }}" data-fy="{{ $fiscal_year1 }}"
            type="button" class="btn btn-primary float-left btn_add_bp_form205" data-toggle="modal" data-target="#bp_form205_modal">Add Form 205
         </button>
      @endrole
    </div>
    <div class="col-10">
   </div>
  </div>
</div>
<div class="row py-3">
   <div class="col table-responsive">        
      <table id="bp_form205_table" class="table-bordered table-hover table" style="width: 100%;">
         <thead>            
            <tr>
               <th rowspan="3" style="min-width:150px;">Name of Retiree</th>
               <th rowspan="3" style="min-width:20px;">Position at Ret. Date</th>
               <th colspan="3" style="min-width:50px;">Date</th>
               <th rowspan="3" style="min-width:50px;">Highest Montly Salary</th>
               <th colspan="3" style="min-width:50px;">Terminal Leave</th>
               <th colspan="3" style="min-width:50px;">Retirement Gratuity</th>
               <th rowspan="3"style="min-width:110px; max-width:120px;">Action</th>
            </tr> 
            <tr>
               <th rowspan="2">Birth </th>
               <th rowspan="2">Orig. Appt.</th>
               <th rowspan="2">Ret.</th> 
               <th colspan="2">No. of Leave Credits Earned</th>  
               <th rowspan="2">Amount</th>              
               <th rowspan="2">Total Creditable Service</th>
               <th rowspan="2">No. of Gratuity Months</th>        
               <th rowspan="2">Amount</th>    
            </tr>
            <tr>    
               <th>VL</th>        
               <th>SL</th>                  
            </tr>     
         </thead>  
         <tbody>
            <?php 
               $count = 0;
               foreach($sqlBpForm205byFY as $row){
                  $id = $row->id;
                  $emp_code = $row->emp_code;
                  $lname = $row->lname;
                  $fname = $row->fname;
                  $mname = $row->mname;
                  $exname = $row->exname;
                  $exname = $row->exname;
                  $position_at_retirement_date = $row->position_at_retirement_date;
                  $retiree_division_acronym = $row->retiree_division_acronym;
                  $birthdate = $row->birthdate;
                  $highest_monthly_salary = $row->highest_monthly_salary;
                  $sl_credits_earned = $row->sl_credits_earned;
                  $vl_credits_earned = $row->vl_credits_earned;
                  $leave_amount = $row->leave_amount;
                  $total_creditable_service = $row->total_creditable_service;
                  $num_gratuity_months = $row->num_gratuity_months;
                  $gratuity_amount = $row->gratuity_amount;
                  $remarks = $row->remarks;
                  $is_active = $row->is_active;
                  $count = count($sqlBpForm205byFY);
                  if($count != 0){?>
                     <tr>
                        <td>{{ $lname }}, {{ $fname }} {{ $mname }} {{ $exname }}</td>
                        <td>{{ $position_at_retirement_date }}</td>
                        <td>{{ $birthdate }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($highest_monthly_salary, 2) }}</td>
                        <td>{{ $vl_credits_earned }}</td>
                        <td>{{ $sl_credits_earned }}</td>
                        <td>{{ number_format($leave_amount, 2) }}</td>
                        <td>{{ $total_creditable_service }}</td>
                        <td>{{ $num_gratuity_months }}</td>
                        <td>{{ number_format($gratuity_amount, 2) }}</td>
                        @role('Division Budget Controller')
                           <td class="text-center"> 		
                              {{-- <button type="button" class="btn-xs btn_view_bp_form205" data-id="{{ $id }}"
                                 data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                                 data-placement='auto' title='View'>
                                 <i class="fa-solid fas fa-eye"></i>																					
                              </button>								 --}}
                              <button type="button" class="btn-xs btn_edit_bp_form205" data-id="{{ $id }}"
                                 data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                                 data-placement='auto' title='Edit'>
                                 <i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
                              </button>
                              <button type="button" class="btn-xs btn_delete_bp_form205" data-id="{{ $id }}" 
                                 data-toggle="tooltip" data-placement='auto'title='Delete'>
                                 <i class="fa-solid fa-trash-can fa-lg red"></i>
                              </button>																				 
                           </td>
                        @endrole
                        @unlessrole('Division Budget Controller')
                           <td class="text-center"> 		
                              <button type="button" class="btn-xs btn_view_bp_form205" data-id="{{ $id }}"
                                 data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                                 data-placement='auto' title='View'>
                                 <i class="fa-solid fas fa-eye"></i>																					
                              </button>
                           </td>
                         @endrole
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






 