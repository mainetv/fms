     
     
<?php
   $fiscal_year = $value->fiscal_year;
   $year = $value->year;?>
   @unlessrole('Cluster Budget Controller|Division Director|Division Budget Controller')
      @php $sqlBpForm8byFY = getBpForm8byFY($year, $fiscal_year);  @endphp
   @endrole
   @role('Cluster Budget Controller|Division Director')
      @php $sqlBpForm8byFY = getBpForm8byClusterbyFY($user_division_id, $year, $fiscal_year);  @endphp
   @endrole
   @role('Division Budget Controller')
      @php $sqlBpForm8byFY = getBpForm8byDivisionbyFY($user_division_id, $year, $fiscal_year);  @endphp
   @endrole
<h4>TRAVELING EXPENSES: FOREIGN TRAVEL</h4>
<h6>DOST Form No. 8</h6>
<div class="content">
  <div class="row">
    <div class="col-2">
      @role('Division Budget Controller')
         <button data-division-id={{ $user_division_id }} data-year="{{ $year }}" data-fy="{{ $fiscal_year }}"
            type="button" class="btn btn-primary float-left btn_add_bp_form8" data-toggle="modal" data-target="#bp_form8_modal">Add Form 8
         </button>
      @endrole
    </div>
    <div class="col-10">
      <div class="float-right"><?php 
         foreach($fiscal_years as $row => $key){?><br>
            <input type="checkbox" id="chk_fy" value="{{ $key->fiscal_year; }}" 
               @if($key->fiscal_year == $fiscal_year) checked @endif onclick="return false;"> FY {{ $key->fiscal_year; }} <?php
         }?>
      </div>
   </div>
  </div>
</div>
<div class="row py-3">
   <div class="col table-responsive">        
      <table id="bp_form8_table" class="table table-bordered data-table">
         <thead>            
            <tr>
               <th style="min-width:150px;">Name</th>
               <th style="min-width:55px;">Proposed Date</th>
               <th style="min-width:80px;">Destination</th>
               <th style="min-width:80px;">Amount</th>
               <th style="min-width:150px;">Purpose of Travel</th>
               <th style="min-width:110px; max-width:120px;">Action</th> 
            </tr>     
         </thead>  
         <tbody>
            <?php 
               $count = 0;
               foreach($sqlBpForm8byFY as $row){
                  $id = $row->id;
                  $name = $row->name;
                  $proposed_date = $row->proposed_date;
                  $destination = $row->destination;
                  $amount = $row->amount;
                  $purpose_travel = $row->purpose_travel;
                  $remarks = $row->remarks;
                  $is_active = $row->is_active;
                  $count = count($sqlBpForm8byFY);
                  if($count != 0){?>
                     <tr>
                        <td>{{ $name }}</td>
                        <td>{{ $proposed_date }}</td>
                        <td>{{ $destination }}</td>
                        <td>{{ $amount }}</td>
                        <td>{{ $purpose_travel }}</td>
                        @role('Division Budget Controller')
                           <td class="text-center"> 		
                              <button type="button" class="btn-xs btn_view_bp_form8" data-id="{{ $id }}"
                                 data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                                 data-placement='auto' title='View'>
                                 <i class="fa-solid fas fa-eye"></i>																					
                              </button>								
                              <button type="button" class="btn-xs btn_edit_bp_form8" data-id="{{ $id }}"
                                 data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                                 data-placement='auto' title='Edit'>
                                 <i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
                              </button>
                              <button type="button" class="btn-xs btn_delete_bp_form8" data-id="{{ $id }}" 
                                 data-toggle="tooltip" data-placement='auto'title='Delete'>
                                 <i class="fa-solid fa-trash-can fa-lg red"></i>
                              </button>																				 
                           </td>
                        @endrole
                        @unlessrole('Division Budget Controller')
                           <td class="text-center"> 		
                              <button type="button" class="btn-xs btn_view_bp_form8" data-id="{{ $id }}"
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
                     <td class="font-italic" colspan="6">No Results Found</td>
                  </tr>
               <?php
               }
            ?>            
         </tbody>           
      </table>
   </div>         
</div>