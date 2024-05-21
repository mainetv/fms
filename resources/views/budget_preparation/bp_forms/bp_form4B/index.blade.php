<?php
   $fiscal_year = $value->fiscal_year;
   $year = $value->year;?>
   @unlessrole('Cluster Budget Controller|Division Director|Division Budget Controller')
      @php $sqlBpForm4byFY = getBpForm4byFY($year, $fiscal_year);  @endphp
   @endrole
   @role('Cluster Budget Controller|Division Director')
      @php $sqlBpForm4byFY = getBpForm4byClusterbyFY($user_division_id, $year, $fiscal_year);  @endphp
   @endrole
   @role('Division Budget Controller')
      @php $sqlBpForm4byFY = getBpForm4byDivisionbyFY($user_division_id, $year, $fiscal_year);  @endphp
   @endrole
<h4>BUILDINGS AND STRUCTURES</h4>
<h6>DOST Form No. 4</h6>
<div class="content">
  <div class="row">
    <div class="col-2">
      @role('Division Budget Controller')
         <button data-division-id={{ $user_division_id }} data-year="{{ $year }}" data-fy="{{ $fiscal_year }}"
            type="button" class="btn btn-primary float-left btn_add_bp_form4" data-toggle="modal" data-target="#bp_form4_modal">Add Form 4
         </button>
      @endrole
    </div>
    <div class="col-10">
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
      <table id="bp_form4_table" class="table-bordered table-hover table" style="width: 100%;">
         <thead>            
            <tr>
               <th style="min-width:150px;">Description</th>
               <th style="min-width:120px;">Amound Needed</th>
               <th style="min-width:60px">No. of Years of Completion</th>
               <th style="min-width:80px;">Date Started</th>
               <th style="min-width:120px;">Total Cost</th>        
               <th style="min-width:150px;">Justification</th>        
               <th style="min-width:110px; max-width:120px;">Action</th>
            </tr>     
         </thead>  
         <tbody>
            <?php 
               $count = 0;
               foreach($sqlBpForm4byFY as $row){
                  $id = $row->id;
                  $description = $row->description;
                  $amount = $row->amount;
                  $num_years_completion = $row->num_years_completion;
                  $date_started = $row->date_started;
                  $total_cost = $row->total_cost;
                  $justification = $row->justification;
                  $remarks = $row->remarks;
                  $is_active = $row->is_active;
                  $count = count($sqlBpForm4byFY);
                  if($count != 0){?>
                     <tr>
                        <td>{{ $description }}</td>
                        <td>{{ $amount }}</td>
                        <td>{{ $num_years_completion }}</td>
                        <td>{{ $date_started }}</td>
                        <td>{{ $total_cost }}</td>
                        <td>{{ $justification }}</td>
                        @role('Division Budget Controller')
                           <td class="text-center"> 		
                              <button type="button" class="btn-xs btn_view_bp_form4" data-id="{{ $id }}"
                                 data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                                 data-placement='auto' title='View'>
                                 <i class="fa-solid fas fa-eye"></i>																					
                              </button>								
                              <button type="button" class="btn-xs btn_edit_bp_form4" data-id="{{ $id }}"
                                 data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                                 data-placement='auto' title='Edit'>
                                 <i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
                              </button>
                              <button type="button" class="btn-xs btn_delete_bp_form4" data-id="{{ $id }}" 
                                 data-toggle="tooltip" data-placement='auto'title='Delete'>
                                 <i class="fa-solid fa-trash-can fa-lg red"></i>
                              </button>																				 
                           </td>
                        @endrole
                        @unlessrole('Division Budget Controller')
                           <td class="text-center"> 		
                              <button type="button" class="btn-xs btn_view_bp_form4" data-id="{{ $id }}"
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
                     <td class="font-italic" colspan="7">No Results Found</td>
                  </tr>
               <?php
               }
            ?>
            
         </tbody>             
      </table>
   </div>         
</div>
