@php
   $fiscal_year = $value->fiscal_year;
   $year = $value->year;
@endphp   
<h4>CAPITAL OUTLAY - MACHINERIES AND EQUIPMENT- Tier 1</h4>
<h6>DOST Form No. 5</h6>
<div class="content">
  <div class="row">
    <div class="col-2">
      @role('Division Budget Controller')
         <button data-division-id={{ $user_division_id }} data-year="{{ $year }}" data-fy="{{ $fiscal_year }}"
            type="button" class="btn btn-primary float-left btn_add_bp_form5" data-toggle="modal" data-target="#bp_form5_modal">Add Form 5
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
   @unlessrole('Cluster Budget Controller|Division Director|Division Budget Controller')
      @php $sqlBpForm5byFYbyTier = getBpForm5byFYbyTier($year, '1', $fiscal_year);  @endphp
   @endunlessrole
   @role('Cluster Budget Controller')
      @php $sqlBpForm5byFYbyTier = getBpForm5byClusterbyFYbyTier($user_division_id, $year, '1', $fiscal_year);  @endphp
   @endrole
   @role('Division Budget Controller|Division Director')
      @php $sqlBpForm5byFYbyTier = getBpForm5byDivisionbyFYbyTier($user_division_id, $year, '1', $fiscal_year);  @endphp
   @endrole
   <div class="col table-responsive">        
      <table id="bp_form5_table" class="table-bordered table-hover table" style="width: 100%;">
         <thead>            
            <tr>
               <th>Item Description</th>
               <th>Quantity</th>
               <th>Unit Cost</th>
               <th>Total Cost</th>
               <th>Organizational Deployment</th>
               <th>Justification</th>
               <th></th>
            </tr>     
         </thead>  
         <tbody> <?php 
            $count = 0;
            foreach($sqlBpForm5byFYbyTier as $row){
               $id = $row->id;
               $description = $row->description;
               $quantity = $row->quantity;
               $unit_cost = $row->unit_cost;
               $total_cost = $row->total_cost;
               $organizational_deployment = $row->organizational_deployment;
               $justification = $row->justification;
               $remarks = $row->remarks;
               $is_active = $row->is_active;
               $count = count($sqlBpForm5byFYbyTier); 
               if($count != 0){?>
                  <tr>
                     <td style="width:18%;">{{ $description }}</td>
                     <td style="width:4%;">{{ $quantity }}</td>
                     <td style="width:8%;">{{ number_format($unit_cost, 2) }}</td>
                     <td style="width:8%;">{{ number_format($total_cost, 2) }}</td>
                     <td style="width:16%;">{{ $organizational_deployment }}</td>
                     <td style="width:40%;">{{ $justification }}</td>
                     @role('Division Budget Controller')
                        <td class="text-center" style="width:6%;"> 		
                           <button type="button" class="btn-xs btn_edit_bp_form5" data-id="{{ $id }}"
                              data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                              data-placement='auto' title='Edit'>
                              <i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
                           </button>
                           <button type="button" class="btn-xs btn_delete_bp_form5" data-id="{{ $id }}" 
                              data-toggle="tooltip" data-placement='auto'title='Delete'>
                              <i class="fa-solid fa-trash-can fa-lg red"></i>
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
               </tr> <?php
            }?>            
         </tbody>             
      </table>
   </div>         
</div>

<h4>CAPITAL OUTLAY - MACHINERIES AND EQUIPMENT- Tier 2</h4>
<h6>DOST Form No. 5</h6>
<div class="content">
  <div class="row">
    <div class="col-2">
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
   @unlessrole('Cluster Budget Controller|Division Director|Division Budget Controller')
      @php $sqlBpForm5byFYbyTier = getBpForm5byFYbyTier($year, '2', $fiscal_year);  @endphp
   @endunlessrole
   @role('Cluster Budget Controller')
      @php $sqlBpForm5byFYbyTier = getBpForm5byClusterbyFYbyTier($user_division_id, $year, '2', $fiscal_year);  @endphp
   @endrole
   @role('Division Budget Controller|Division Director')
      @php $sqlBpForm5byFYbyTier = getBpForm5byDivisionbyFYbyTier($user_division_id, $year, '2', $fiscal_year);  @endphp
   @endrole
   <div class="col table-responsive">        
      <table id="bp_form5_table" class="table-bordered table-hover table" style="width: 100%;">
         <thead>            
            <tr>
               <th style="min-width:150px;">Item Description</th>
               <th style="min-width:55px;">Quantity</th>
               <th style="min-width:80px;">Unit Cost</th>
               <th style="min-width:80px;">Total Cost</th>
               <th style="min-width:150px;">Organizational Deployment</th>
               <th style="min-width:150px;">Justification</th>  
               <th style="min-width:10px; max-width:20px;"></th>   
            </tr>     
         </thead>  
         <tbody><?php 
            $count = 0;
            foreach($sqlBpForm5byFYbyTier as $row){
               $id = $row->id;
               $description = $row->description;
               $quantity = $row->quantity;
               $unit_cost = $row->unit_cost;
               $total_cost = $row->total_cost;
               $organizational_deployment = $row->organizational_deployment;
               $justification = $row->justification;
               $remarks = $row->remarks;
               $is_active = $row->is_active;
               $count = count($sqlBpForm5byFYbyTier);                  
               if($count != 0){?>
                  <tr>
                     <td style="width:18%;">{{ $description }}</td>
                     <td style="width:4%;">{{ $quantity }}</td>
                     <td style="width:8%;">{{ number_format($unit_cost, 2) }}</td>
                     <td style="width:8%;">{{ number_format($total_cost, 2) }}</td>
                     <td style="width:16%;">{{ $organizational_deployment }}</td>
                     <td style="width:40%;">{{ $justification }}</td>
                     @role('Division Budget Controller')
                        <td class="text-center" style="width:6%;"> 		
                           <button type="button" class="btn-xs btn_edit_bp_form5" data-id="{{ $id }}"
                              data-toggle="modal" data-target="#bp_modal" data-toggle="tooltip" 
                              data-placement='auto' title='Edit'>
                              <i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
                           </button>
                           <button type="button" class="btn-xs btn_delete_bp_form5" data-id="{{ $id }}" 
                              data-toggle="tooltip" data-placement='auto'title='Delete'>
                              <i class="fa-solid fa-trash-can fa-lg red"></i>
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
               </tr> <?php
            }?>            
         </tbody>             
      </table>
   </div>         
</div>
