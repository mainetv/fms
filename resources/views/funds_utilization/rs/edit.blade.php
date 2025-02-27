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
                  @if($user_role_id==3)
                    <input type="text" id="rs_date" name="rs_date" value="@if($rs_date1==NULL) {{ date('Y-m-d') }} @else {{ $rs_date }} @endif" class="form-control dv-field datepicker">
                  @else
                    <input type="text" id="rs_date" name="rs_date" value="{{ $rs_date }}" class="form-control dv-field datepicker">
                  @endif


                  <span class="is-invalid"><small id="date-error" class="error"></small></span>
                </div>
                @if($user_role_id!=3) <div class="col-sm-1"></div> @else &emsp;&emsp;&emsp;&emsp; @endif
                <label for="fund_id" class="col-form-label">Fund</label>@if($user_role_id!=3) &emsp;&emsp;&emsp; @else &emsp;&emsp;&emsp;&emsp;&emsp; @endif
                <div class="col-sm-2">     
                  <input type="text" id="fund_id" name="fund_id" class="form-control rs-field" value="{{ $fund }}" readonly>       
                  {{-- <select id="fund_id" name="fund_id" class="form-control rs-field select2bs4">   
                    <option value="" selected hidden>Select Fund</option>
                    @foreach ($getFunds as $row)
                      <option value="{{ $row->id }}" data-id="{{ $row->id }}" @if($fund_id==$row->id){{"selected"}} @endif>{{ $row->fund }}</option>
                    @endforeach                           
                  </select> --}}
                  {{-- <span class="is-invalid"><small id="fund-error" class="error"></small></span> --}}
                </div>
                @if($user_role_id!=3) <div class="col-sm-1"></div> @else &emsp;&emsp;&emsp;&emsp; @endif
                <label for="division_id" class="col-form-label">Division</label>@if($user_role_id!=3) &emsp;&emsp;&emsp; @else &emsp;&emsp;&emsp; @endif
                <div class="col"> 
                  <input type="text" id="division_id" name="division_id" value="{{ $division_id }}" class="form-control rs-field" hidden>
                  <input type="text" id="division_acronym"  value="{{ $division_acronym }}" class="form-control rs-field" readonly>
                </div> 
                {{-- @if($user_role_id==3) <div class="col-sm-2"></div> @endif                 --}}
              </div>              
              <div class="form-group row">
                <label for="payee_id" class="col-sm-1 col-form-label">Payee</label>
                <div class="col-11">
                  @if($user_role_id!=3)
                    <select id="payee_id" name="payee_id" class="form-control rs-field select2bs4">   
                      <option value="" selected hidden>Select Payee</option>
                      @foreach ($getPayees as $row)
                        <option value="{{ $row->id }}" data-id="{{ $row->id }}" @if($payee_id==$row->id){{ "selected" }} @endif>
                          {{ $row->payee }} [{{ $row->bank_acronym }}: {{ $row->bank_account_no }}]
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
              <div class="table-responsive">
                <table id="attached_activity_table" class="table-xs table-bordered text-center" style="width: 100%;">    
                  <thead>
                    <th style="max-width:80%;">Activity</th>
                    <th style="min-width:19%;">Amount</th>
                  </thead>    
                  <tbody>
                    <?php        
                      $total_rs_activity_amount = 0;                 
                      foreach ($getAttachedActivityByRs as $row) {  
                        $total_rs_activity_amount += $row->amount; ?>                            
                        <tr>
                          <td class="text-left">
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
                        </tr>
                        <?php
                      }
                    ?>
                    <tr class="text-right font-weight-bold">
                      <td>Total</td>
                      <td>₱ {{ number_format($total_rs_activity_amount, 2) }}</td>
                    </tr>
                  </tbody>          
                </table>
              </div><br>
              
              <div class="table-responsive">
                <table id="attached_allotment_table" class="table-sm table-bordered text-center">    
                  <thead>
                    <th style="min-width:6%; max-width:6%;">Division</th>
                    <th style="min-width:27%; max-width:27%;">PAP</th>
                    <th style="min-width:22%; max-width:22%;">Activity / Account Code</th>
                    <th style="min-width:11%; max-width:11%;">Amount</th>
                    <th style="min-width:11%; max-width:11%;">Allotment</th>
                    <th style="min-width:11%; max-width:11%;">Total Obligation</th>
                    <th style="min-width:11%; max-width:11%;">Balance</th>
                    <th style="min-width:1%; max-width:1%;">
                      <button type="button" data-toggle="tooltip" data-placement='left' title='Attach allotment activity'
                        class="@hasrole('Budget Officer|Super Administrator|Administrator') btn_attach_allotment_activity @else d-none @endhasrole btn-xs btn btn-outline-primary">
                      <i class="fas fa-plus fa-lg"></i></button>
                    </th>
                  </thead>    
                  <tbody>
                    <?php                         
                      foreach ($getAttachedAllotmentByRs as $row) { 
                        $sqlAllotment = getAllotmentforRS($row->allotment_id); ?>                            
                        <tr>
                          <td>
                            @hasrole('Budget Officer|Super Administrator|Administrator') 
                            <a href="#" class="btn_edit_attached_allotment_activity" data-toggle="tooltip" data-placement='auto' 
                            title='Replace attached allotment' data-rs-allotment-id="{{ $row->id }}">
                            @endhasrole
                            {{ $row->allotment_division_acronym }}</a></td>
                          <td class="text-left">
                            @if($rs_type_id==1)      
                              {{ $row->pap_all }}
                            @else 
                              {{ $row->pap_code }}:                  
                              @if($row->activity_code<>NULL) {{ $row->activity_code }} @else {{ $row->activity }}@endif 
                            @endif
                          </td>
                          <td class="text-left">
                            @if($rs_type_id==1)     
                              {{ $row->activity }}                           
                              @if($row->subactivity<>NULL) - {{ $row->subactivity }}<br>@endif 
                              {{ $row->object_code }}:
                              {{ $row->object_expenditure }}
                              @if($row->object_specific<>NULL) - {{ $row->object_specific }} @endif
                            @else
                              {{-- subactivity --}}
                              @if($row->subactivity_code<>NULL) &nbsp; {{ $row->subactivity_code }} <br>
                              @else {{ $row->subactivity }} <br>
                              @endif 
                              {{-- axpense or expenditure --}}
                              @if($row->object_expenditure<>NULL) &nbsp; {{ $row->object_code }}: {{ $row->object_expenditure }} 
                              @else &nbsp; {{ $row->expense_account_code }}: {{ $row->expense_account }} 
                              @endif 
                              {{-- specific --}}
                              @if($row->object_specific<>NULL) - {{ $row->object_specific }} @endif
                            @endif
                          </td>
                          <td><input type="text" class="text-right" id="rs_allotment_amount" name="rs_allotment_amount[]"
                            value="{{ number_format($row->rs_amount, 2) }}">
                            <input type="text" id="rs_allotment_id" name="rs_allotment_id[]" value="{{ $row->id }}" hidden></td>
                          <td class="text-right"><?php 
                            $allotment=0;
                            $balance=0;
                            foreach($sqlAllotment as $row1){
                              $allotment=($row1->q1_allotment+$row1->q2_allotment+$row1->q3_allotment+$row1->q4_allotment);
                              $total_obligation=($row1->q1_obligation+$row1->q2_obligation+$row1->q3_obligation+$row1->q4_obligation);
                              $adjustment=($row1->q1_adjustment+$row1->q2_adjustment+$row1->q3_adjustment+$row1->q4_adjustment);
                              $total_allotment=$allotment+$adjustment;
                              $balance=$total_allotment - $total_obligation; ?>
                              {{ number_format($total_allotment, 2) }}
                              <?php 
                            } ?>
                          </td>
                          <td class="text-right">{{ number_format($total_obligation, 2)}}</td>
                          <td class="text-right">{{ number_format($balance, 2) }}</td>
                          <td>
                            <button type="button" class="@hasrole('Budget Officer|Super Administrator|Administrator') btn_remove_attached_allotment @else d-none @endhasrole
                              btn-xs btn btn-outline-danger" data-id="{{ $row->id }}" data-toggle="tooltip" data-placement='auto' title='Remove attached allotment'><i class="fa-solid fa-xmark fa-lg"></i>
                            </button>
                          </td>
                        </tr>
                        <?php
                      }
                    ?>
                  </tbody>          
                </table>
                <br>
              </div>                          
              <div class="form-group row">              
                <label for="signatory_id" class="col-sm-1 col-form-label">B. Certified</label>
                <div class="col"> 
                    @foreach ($getRsSignatory1b as $row)
                      <input value="{{ $row->fullname_first }}" id="signatory1b" name="signatory1b" class="form-control" readonly>
                    @endforeach        
                </div>              
              </div> 
              <br>
              <strong>{{ $notice_adjustment }}</strong>
              <br>                
              <div class="table-responsive">
                <table id="attached_allotment_table" class="table-sm table-bordered text-center" style="width: 100%;">    
                  <thead>
                    <th style="min-width:6%; max-width:6%;">Division</th>
                    <th style="min-width:27%; max-width:27%;">PAP</th>
                    <th style="min-width:22%; max-width:22%;">Activity / Account Code</th>                        
                    <th style="min-width:11%; max-width:11%;">Amount</th>
                    <th style="min-width:17%; max-width:17%;">{{ $notice_adjustment }} No.</th>
                    <th style="min-width:15%; max-width:15%;">{{ $notice_adjustment }} Date</th>
                    <th style="min-width:1%; max-width:1%;">
                      <button type="button" data-toggle="tooltip" data-placement='auto' title='Add {{ $notice_adjustment }}'
                        class="@hasrole('Budget Officer|Super Administrator|Administrator') btn_add_notice_adjustment @else d-none @endhasrole btn-xs btn btn-outline-primary">
                      <i class="fas fa-plus fa-lg"></i></button>
                    </th>
                  </thead>    
                  <tbody>
                    <?php                         
                      foreach ($getNoticeAdjustmentbyRS as $row) {  ?>                            
                        <tr>
                          <td>
                            @hasrole('Budget Officer|Super Administrator|Administrator')
                              <a href="#" class="btn_edit_notice_adjustment" data-toggle="tooltip" 
                              data-placement='auto' title='Replace notice adjustment'
                              data-rs-allotment-id="{{ $row->id }}">
                            @endhasrole
                            {{ $row->allotment_division_acronym }}</a></td>
                            <td class="text-left">
                              @if($rs_type_id==1)      
                                {{ $row->pap }}
                              @else 
                                {{ $row->pap_code }}:                  
                                @if($row->activity_code<>NULL) {{ $row->activity_code }} @else {{ $row->activity }}@endif 
                              @endif
                            </td>
                            <td class="text-left">
                              @if($rs_type_id==1)     
                                {{ $row->activity }}                           
                                @if($row->subactivity<>NULL) - {{ $row->subactivity }}<br>@endif 
                                {{ $row->object_code }}:
                                {{ $row->object_expenditure }} - {{ $row->object_specific }}
                              @else
                                @if($row->subactivity<>NULL) - {{ $row->subactivity }}<br>@endif 
                                {{ $row->object_code }}:
                                @if($row->object_expenditure<>NULL) {{ $row->object_expenditure }} @else {{ $row->expense_account }}<br>@endif 
                              @endif
                            </td>
                          <td><input type="text" id="notice_adjustment_amount" class= "text-right" name="notice_adjustment_amount[]"
                            value="{{ number_format($row->rs_amount, 2) }}">
                            <input type="text" id="notice_adjustment_id" name="notice_adjustment_id[]" value="{{ $row->id }}" hidden></td>
                          <td><input type="text" id="notice_adjustment_no" name="notice_adjustment_no[]" value="{{ $row->notice_adjustment_no }}"></td>
                          <td><input type="date" id="notice_adjustment_date" name="notice_adjustment_date[]" 
                            value="{{ $row->notice_adjustment_date }}" class="form-control rs-field">
                          </td>
                          <td>
                            <button type="button" class="@hasrole('Budget Officer|Super Administrator|Administrator') btn_remove_notice_adjustment @else d-none @endhasrole btn-xs btn btn-outline-danger" data-id="{{ $row->id }}" data-toggle="tooltip" 
                              data-placement='auto' title='Remove notice adjustment'><i class="fa-solid fa-xmark"></i>
                            </button>
                          </td>
                        </tr>
                        <?php
                      }
                    ?>
                  </tbody>    
                  <tfoot class="text-right no-border">
                    <th colspan="3">TOTAL</th>
                    <th>{{ number_format($total_rs_pap_amount,2) }}</th>
                  </tfoot>      
                </table>
                <br>
              </div>                         
              <div class="row text-left">   
                <div class="col-5">    
                    <a style="font-color:white;" href="{{ url('funds_utilization/rs/all/'.$rs_type_url.'/'.$month.'/'.$year) }}">
                      <button type="button" class="btn btn-secondary">   Back
                    </button></a>
                </div> 
                <div class="col">
                  @hasrole('Budget Officer|Super Administrator|Administrator')
                    <button type="button" class="btn btn-primary 
                      @if($total_rs_pap_amount==$total_rs_amount) print_p2
                      @elseif($total_rs_pap_amount!=$total_rs_amount) disabled
                      @else disabled @endif">
                      Print</button>
                    <button type="button" class="btn btn-primary save-buttons update_rs">Save Changes</button>
                  @endhasrole
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



