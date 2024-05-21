@extends('layouts.app')

@section('content')   
  <section class="content"> 
    @php 
      $user_division_id=getUserDivisionID($user_id);
      foreach($getRsDetails as $row){
        $rs_id=$row->id;
        $fais_id=$row->fais_id;
        $rs_no=$row->rs_no;
        $rs_type_id=$row->rs_type_id;
        $month=$row->month;
        $year=$row->year;
        $rs_date=$row->rs_date;
        $rs_date1=$row->rs_date1;
        $fund_id=$row->fund_id;
        $fund=$row->fund;
        $division_id=$row->division_id;
        $division_acronym=$row->division_acronym;
        $payee=$row->payee;
        $payee_id=$row->payee_id;
        $particulars=$row->particulars;
        $signatory1b=$row->signatory1b;
        $signatory1=$row->signatory1;
        $signatory2=$row->signatory2;
        $signatory3=$row->signatory3;
        $signatory4=$row->signatory4;
        $showall=$row->showall;
        $is_locked=$row->is_locked;
        $locked_at=$row->locked_at;
        $cancel_date=$row->cancel_date;
        $total_rs_pap_amount=$row->total_rs_pap_amount;
        $total_rs_amount=$row->total_rs_activity_amount;
      }
      $attached_allotment_count = $getAttachedAllotmentByRs->count();
      $rs_month = date("m",strtotime($rs_date));
      $rs_month1 = date("m",strtotime($rs_date));
      $getRSType=getRSType($rs_type_id);
      foreach($getRSType as $row){
        $fund_id=$row->fund_id;
        $fund=$row->fund;
        $rs_type=$row->request_status_type;
        $rs_type_url=strtolower($row->request_status_type);
        $rs=$row->rs;
        $notice_adjustment=$row->notice_adjustment;
      }
    @endphp
    <div class="card text-left">
       <div class="card-header">
          <h3 class="card-title">
          Edit {{ $rs_type }}
          </h3>            
       </div>         
       <div class="card-body">
          <div class="row">            
            <form id="rs_form" class="col-md-12"> 
              <input type="text" id="year" name="year" value="{{ $year }}" hidden>
              <input type="text" id="rs_type_id" name="rs_type_id" value="{{ $rs_type_id }}" hidden>
              <input type="text" id="rs_type" name="rs_type" value="{{ $rs_type }}" hidden>
              <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
              <div class="form-group row">
                <label for="rs_id" class="col-sm-1 col-form-label">{{ $rs_type }} ID</label>
                <div class="col-sm-2"> 
                  <input type="text" name="rs_id" id="rs_id" value="{{ $rs_id }}" class="form-control no-border" readonly>
                </div>              
                @if($user_role_id!=3)
                  <div class="col-sm-1"></div>  
                  <label for="rs_no" class="col-form-label">{{ $rs_type }} No. </label>&emsp;&nbsp;&nbsp;&nbsp;
                  <div class="col"> 
                    <input type="text" name="rs_no" id="rs_no" value="{{ $rs_no }}" class="form-control no-border" readonly>
                  </div>                           
                @else      
                  &emsp;&emsp;&emsp;&emsp; 
                  {{-- @if($fais_id<>"")              
                    <label for="rs_id" class="col-form-label">FAIS {{ $rs_type }} ID</label>&emsp;&emsp;        
                    <div class="col-sm-2"> 
                      <input type="text" name="fais_id" id="fais_id" value="{{ $fais_id }}" class="form-control">
                    </div>&emsp;&emsp;&emsp;&emsp;
                  @endif --}}
                  <label for="rs_no" class="col-form-label">{{ $rs_type }} No.                
                    <a href="javascript:void(0)" class="generate_rs_no" data-rs-id="{{ $rs_id }}" 
                      data-rs-month="{{ $rs_month }}" data-year="{{ $year }}" data-rs-type-id="{{ $rs_type_id }}"  data-rs-type="{{ $rs_type }}"
                      data-allotment-count={{ $attached_allotment_count }}  data-toggle="tooltip" 
                      data-placement='left' title='Generate ORS number'> >> </a></label>&emsp;&emsp;
                  <div class="@if($fais_id<>"") col-3 @else col @endif "> 
                    <input type="text" name="rs_no" id="rs_no" value="{{ $rs_no }}" class="form-control">
                    <span class="is-invalid"><small id="allotment-count-error" class="error"></small></span>
                  </div>&emsp;&emsp;
                  <label for="is_locked" class="col-sm-1 col-form-label">                     
                  <div class="col"> 
                    <input type="checkbox" name="is_locked" id="is_locked" class="form-check-input"
                    value="{{ $is_locked == '1' ? '1':'0' }}"  {{ $is_locked == '1' ? 'checked':'' }}>Lock
                  </div>   
                @endif
              </div>  
              <div class="form-group row">
                <label for="activity_id" class="col-sm-1 col-form-label">Date</label>
                <div class="col-sm-2"> 
                    <input type="text" id="rs_date" name="rs_date" value="{{ $rs_date }}" class="form-control dv-field datepicker">
                   <span class="is-invalid"><small id="date-error" class="error"></small></span>
                </div>
                @if($user_role_id!=3) <div class="col-sm-1"></div> @else &emsp;&emsp;&emsp;&emsp; @endif
                <label for="fund_id" class="col-form-label">Fund</label>@if($user_role_id!=3) &emsp;&emsp;&emsp; @else &emsp;&emsp;&emsp;&emsp;&emsp; @endif
                <div class="col-sm-2">     
                  <input type="text" id="fund_id" name="fund_id" class="form-control rs-field" value="{{ $fund }}" readonly>  
                </div>
                @if($user_role_id!=3) <div class="col-sm-1"></div> @else &emsp;&emsp;&emsp;&emsp; @endif
                <label for="division_id" class="col-form-label">Division</label>@if($user_role_id!=3) &emsp;&emsp;&emsp; @else &emsp;&emsp;&emsp; @endif
                <div class="col"> 
                  <input type="text" id="division_id" name="division_id" value="{{ $division_id }}" class="form-control rs-field" hidden>
                  <input type="text" id="division_acronym"  value="{{ $division_acronym }}" class="form-control rs-field" readonly>
                </div> 
              </div>              
              <div class="form-group row">
                <label for="payee_id" class="col-sm-1 col-form-label">Payee</label>
                <div class="col-11">
                  @if($user_role_id!=3)
                    <select id="payee_id" name="payee_id" class="form-control rs-field select2bs4">   
                      <option value="" selected hidden>Select Payee</option>
                      @foreach ($getPayees as $row)
                        <option value="{{ $row->id }}" data-id="{{ $row->id }}" @if($payee_id==$row->id){{ "selected" }} @endif>
                          {{ $row->payee }} [{{ $row->bank_acronym }}: {{ $row->bank_account_name }} | {{ $row->bank_account_no }}]
                        </option>
                      @endforeach                           
                    </select>
                  @else
                    <input type="text" id="payee" value="{{ $payee }}" class="form-control" readonly>
                  @endif
                  <span class="is-invalid"><small id="payee-error" class="error"></small></span>
                </div> 
              </div> 
              <div class="form-group row">
                <label for="particulars" class="col-sm-1 col-form-label">Particulars<br>
                  <sub><a href="#" class="btn_insert_particulars_template" data-toggle="tooltip" data-placement='auto' 
                  title='Insert particulars template' data-rs-type-id="{{ $rs_type_id }}">Template</a></sub></label>
                <div class="col">             
                  <textarea name="particulars" id="particulars" rows="4" class="form-control rs-field">{{ $particulars }}</textarea>
                  <span class="is-invalid"><small id="particulars-error" class="error"></small></span>
                </div>        
              </div> 
              <input type="checkbox" id="showall" name="showall"
              value="{{ $showall == '1' ? '1':'0' }}"  {{ $showall == '1' ? 'checked':'' }}> Show All Divisions' Activity 
              <br>
              Charged to:
              <div class="table-responsive">
                <table id="attached_activity_table" class="table-xs table-bordered text-center" style="width: 100%;">    
                  <thead>
                    <th style="max-width:80%;">Activity</th>
                    <th style="min-width:19%;">Amount</th>
                    @if($is_locked==0)
                    <th style="max-width:10px;">
                      <button type="button" data-toggle="tooltip" data-placement='auto' title='Attach activity'
                        class="btn_attach_activity btn-xs btn btn-outline-primary">
                      <i class="fas fa-plus"></i></button>
                    </th>
                    @endif
                  </thead>    
                  <tbody>
                    <?php        
                      $total_rs_activity_amount = 0;                 
                      foreach ($getAttachedActivityByRs as $row) {  
                        $total_rs_activity_amount += $row->amount; ?>                            
                        <tr>
                          <td class="text-left">@if($is_locked==0)<a href="#" class="btn_edit_attached_activity" data-toggle="tooltip" 
                            data-rs-allotment-id="{{ $row->id }}" data-placement='auto' title='Replace attached activity' class="text-left">
                            @endif
                            {{ $row->allotment_division_acronym }}:
                            @if($rs_type_id==1)
                              {{ $row->activity }}                                 
                            @else
                              @if($row->activity_code<>NULL) {{ $row->activity_code }} @else {{ $row->activity }} @endif 
                            @endif
                            @if($row->subactivity<>NULL) - {{ $row->subactivity }}@endif
                            @if($row->object_specific<>NULL) - {{ $row->object_specific }} @endif</td>
                          <td><input type="text" class="text-right" id="rs_activity_amount" name="rs_activity_amount[]" value="{{ number_format($row->amount, 2) }}">
                            <input type="text" id="rs_activity_id" name="rs_activity_id[]" value="{{ $row->id }}" hidden></td>
                          @if($is_locked==0)  
                          <td>
                            <button type="button" class="btn-xs btn_remove_attached_activity btn btn-outline-danger" data-id="{{ $row->id }}" data-rs-id="{{ $rs_id }}" 
                              data-toggle="tooltip" data-placement='auto' title='Remove attached activity'><i class="fa-solid fa-xmark"></i>
                            </button>
                          </td>
                          @endif
                        </tr>
                        <?php
                      }
                    ?>
                    <tr class="text-right font-weight-bold">
                      <td>Total</td>
                      <td>Php {{ number_format($total_rs_activity_amount, 2) }}</td>
                    </tr>
                  </tbody>          
                </table>
              </div><br>
              <label for="signatory_id" class="col-form-label">A. Certified</label>
              <div class="form-group row">  
                <label for="signatory_id" class="col-1 col-form-label text-right">1.</label>
                <div class="col-5"> 
                  <select id="signatory1" name="signatory1" class="form-control rs-field select2bs4">   
                    <option value="" selected hidden></option>
                    @foreach ($getRsSignatories as $row)
                      <option value="{{ $row->fullname_first }}" 
                        @if(($signatory1==strtoupper($row->fullname_first)) || (strtoupper($signatory1)==strtoupper($row->fullname_first)) || ($signatory1==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div> 
                <label for="signatory_id" class="col-1 col-form-label text-right">&emsp;2.</label> 
                <div class="col-5"> 
                  <select id="signatory2" name="signatory2" class="form-control rs-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getRsSignatories as $row)
                      <option value="{{ $row->fullname_first }}"
                        @if(($signatory2==strtoupper($row->fullname_first)) || (strtoupper($signatory2)==strtoupper($row->fullname_first)) || ($signatory2==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>              
              </div>          
              <div class="form-group row">
                <label for="signatory_id" class="col-1 col-form-label text-right">3.</label>
                <div class="col-5"> 
                  <select id="signatory3" name="signatory3" class="form-control rs-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getRsSignatories as $row)
                      <option value="{{ $row->fullname_first }}"
                        @if(($signatory3==strtoupper($row->fullname_first)) || (strtoupper($signatory3)==strtoupper($row->fullname_first)) || ($signatory3==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>   
                <label for="signatory_id" class="col-1 col-form-label text-right">&emsp;4.</label>
                <div class="col-5"> 
                  <select id="signatory4" name="signatory4" class="form-control rs-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getRsSignatories as $row)
                      <option value="{{ $row->fullname_first }}"
                        @if(($signatory4==strtoupper($row->fullname_first)) || (strtoupper($signatory4)==strtoupper($row->fullname_first)) || ($signatory4==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>              
              </div><br>
              <div class="form-group row">
                <label for="particulars" class="col-sm-1 col-form-label">Transaction Type</label>
                <div class="col">                      
                  <?php 
                    $Array = array();
                    foreach($getSelectedRsTransactionTypes as $row1){
                      $arr = "";
                      $arr = $row1->rs_transaction_type_id;                      
                      $Array[] = $arr;
                    }
                    $arr1 = implode(",", $Array);
                    $arr2 = explode(',', $arr1);
                  ?>         
                  <select name="rs_transaction_type_id[]" id="rs_transaction_type_id" multiple="multiple" 
                    data-placeholder="Select Transaction Type" class="rs-field select2bs4 form-control">
                    @foreach($getRsTransactionTypes->groupBy('allotment_class') as $key=>$row)       
                      <optgroup class="font-weight-bold" label="{{ $key }}">
                        @foreach($row as $item)               
                          <option value="{{ $item->id }}" {{ (in_array($item->id, $arr2)) ? 'selected' : '' }}>
                              {{ $item->transaction_type }} 
                          </option>                        
                        @endforeach
                      </optgroup>
                    @endforeach     
                  </select>
                </div>        
              </div>           
              <div class="row text-left">   
                <div class="col-5">
                  <a style="font-color:white;" href="{{ url('funds_utilization/rs/division/'.$rs_type_url.'/'.$month.'/'.$year) }}">
                    <button type="button" class="btn btn-secondary">   Back
                  </button></a>
                </div> 
                <div class="col">
                  <button type="button" class="btn btn-primary 
                    @if($user_role_id!=3) @if($total_rs_amount!=0) print_p1 @else disabled @endif  @endif">
                    Print</button>
                  <button type="button" class="btn btn-primary save-buttons 
                  @if($user_role_id!=3 && $is_locked==0) edit_rs @elseif($user_role_id!=3 && $is_locked==1) d-none @else update_rs @endif">Save Changes</button>  
                </div>       
              </div>
            </form> 
          </div>           
       </div>
    </div>
  </section>  
  @include('funds_utilization.rs.modal')
@endsection 

@section('jscript')
   <script type="text/javascript" defer>
      $(document).ready(function(){
        @include('funds_utilization.rs.script')   
        @include('scripts.common_script') 
      });

      // var rs_amount = document.getElementById("rs_allotment_amount");
      var input = document.getElementByClass("rs_allotment_amount");
      input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          $.ajax({
            method: "PATCH",   
            dataType: 'json',         
            url: "{{ route('rs.update') }}",
            data:  $('#rs_form').serialize() + "&update_rs=1",
            success:function(data) {
              console.log(data);
            }                             
          });
        }
      });
   </script>
@endsection



