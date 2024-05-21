@extends('layouts.app')

@section('content')   
  <section class="content"> 
    <?php 
      foreach($getLDDAPDetails as $row){
        $lddap_id=$row->id;
        $lddap_no=$row->lddap_no;
        $lddap_date=$row->lddap_date;
        $payment_mode_id=$row->payment_mode_id;
        $payment_mode=$row->payment_mode;
        $fund_id=$row->fund_id;        
        $bank_account_id=$row->bank_account_id;
        $nca_no=$row->nca_no;
        $acic_no=$row->acic_no;
        $check_no=$row->check_no;
        $ada_date=$row->ada_date;
        $signatory1=$row->signatory1;
        $signatory2=$row->signatory2;
        $signatory3=$row->signatory3;
        $signatory4=$row->signatory4;
        $signatory5=$row->signatory5;
      }      
      $lddap_month = date("m",strtotime($lddap_date));
      $lddap_year = date("Y",strtotime($lddap_date));   
      
      $getLDDAPPrefix = getLDDAPPrefix($fund_id);
      foreach($getLDDAPPrefix as $rowP){
        $prefix_code = $rowP->prefix_code;
      }
      $prefix = $prefix_code.'-'.$lddap_month;
      if($check_no == '' || $check_no == NULL){
        if($fund_id==1){
          $check_no_prefix=993000;
        }
        else if($fund_id==2){
          $check_no_prefix=995000;
        }
        else if($fund_id==3){
          $check_no_prefix=9960000;
        }        
      }
      else{
        $check_no_prefix='';
      }   
    ?>
    <div class="card text-left">
       <div class="card-header">
          <h3 class="card-title">
            {{ $title }}
          </h3>            
       </div>         
       <div class="card-body">
          <div class="row">            
            <form id="lddap_form" class="col-md-12"> 
              <input type="text" id="year" name="year" value="{{ $lddap_year }}" hidden>
              <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
              <div class="form-group row">
                <label for="lddap_id" class="col-sm-1 col-form-label">LDDAP ID</label>
                <div class="col-sm-2"> 
                  <input type="text" name="lddap_id" id="lddap_id" value="{{ $lddap_id }}" class="form-control no-border" readonly>
                </div>
                &emsp;&emsp;&emsp;&emsp;&emsp;   
                <label for="lddap_no" class="col-form-label">{{ $payment_mode }} No.  
                  @role('Accounting Officer')                       
                  <a href="javascript:void(0)" class="generate_lddap_no" data-lddap-id="{{ $lddap_id }}" data-fund-id="{{ $fund_id }}"
                  data-payment-mode-id="{{ $payment_mode_id }}" data-prefix-code="{{ $prefix_code }}" data-year="{{ $lddap_year }}" 
                  data-toggle="tooltip" data-placement='auto' title='Generate lddap number'> >> </a>@endrole</label>&emsp;&emsp;
                <div class="col-sm-2"> 
                  <input type="text" name="lddap_no" id="lddap_no" value="{{ $lddap_no }}" class="form-control red font-weight-bold">
                </div>
                &emsp;&emsp;&emsp;&emsp;&emsp;
                <label for="fund_id" class="col-form-label">Fund</label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
                <div class="col-sm-2"> 
                  <select id="fund_id" name="fund_id" class="form-control lddap-field select2bs4">   
                    <option value="" selected hidden>Select Fund</option>
                    @foreach ($getFunds as $row)
                      <option value="{{ $row->id }}" data-id="{{ $row->id }}" @if($fund_id==$row->id){{"selected"}} @endif>{{ $row->fund }}</option>
                    @endforeach                           
                  </select>
                  <span class="is-invalid"><small id="fund-error" class="error"></small></span>
                </div>    
              </div>  
              <div class="form-group row">
                <label for="activity_id" class="col-sm-1 col-form-label">LDDAP Date</label>
                <div class="col-sm-2"> 
                  <input type="text" id="lddap_date" name="lddap_date" value="{{ $lddap_date }}" class="form-control lddap-field datepicker">
                  <span class="is-invalid"><small id="date-error" class="error"></small></span>
                </div> 
                &emsp;&emsp;&emsp;&emsp;&emsp;
                <label for="tax_type" class="col-form-label">NCA No.</label>&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
                <div class="col-sm-2"> 
                  <input type="text" id="nca_no" name="nca_no" value="{{ $nca_no }}" class="form-control">
                </div>&emsp;&emsp;&emsp;&emsp;&emsp;       
                <label for="tax_type" class="col-form-label">Bank Account No.</label>&emsp;&nbsp;
                <div class="col-sm-2"> 
                  <select name="bank_account_id" id="bank_account_id" class="form-control lddap-field select2bs4">
                    <option value="">Select Bank Account No.</option>
                    @foreach ($getBankAccounts as $row)
                      <option value="{{ $row->id }}" @if($bank_account_id==$row->id){{ "selected" }} @endif>{{ $row->bank_account_no }} </option>
                    @endforeach
                  </select>
                  <span class="is-invalid"><small id="bank-account-id-error" class="error"></small></span>
                </div>  
              </div>     
              <div class="form-group row">
                <label for="activity_id" class="col-sm-1 col-form-label">Check No.</label>
                <div class="col-sm-2"> 
                  <input type="text" id="check_no" name="check_no" value="{{ $check_no_prefix }}{{ $check_no }}" class="form-control">
                </div> 
                &emsp;&emsp;&emsp;&emsp;&emsp;
                <label for="tax_type" class="col-form-label">ACIC No.</label>&emsp;&emsp;&emsp;&emsp;&nbsp;
                <div class="col-sm-2"> 
                  <input type="text" id="acic_no" name="acic_no" value="{{ $acic_no }}" class="form-control">
                </div>&emsp;&emsp;&emsp;&emsp;&emsp;       
                <label for="tax_type" class="col-form-label">ADA Date</label>&emsp;&emsp;&emsp;&emsp;&emsp;
                <div class="col-sm-2"> 
                  <input type="text" id="ada_date" class="form-control" value="{{ $ada_date }}" readonly>
                </div>  
              </div> 
              <div class="form-group row">  
                <label for="signatory_id" class="col-form-label">Certified Correct 1.</label>
                <div class="col-4"> 
                  <select id="signatory1" name="signatory1" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getLDDAP1Signatories as $row)
                      <option value="{{ $row->fullname_first }}"
                        @if(($signatory1==strtoupper($row->fullname_first)) || ($signatory1==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div> 
                <label for="signatory_id" class="col-sm-2 col-form-label text-right">Approved 1.</label> 
                <div class="col-4"> 
                  <select id="signatory2" name="signatory2" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getLDDAPSignatories as $row)
                      <option value="{{ $row->fullname_first }}"
                        @if(($signatory2==strtoupper($row->fullname_first)) || ($signatory2==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>              
              </div> 
              <div class="form-group row">  
                <label for="signatory_id" class="col-form-label">Certified Correct 2.</label>
                <div class="col-4"> 
                  <select id="signatory3" name="signatory3" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getLDDAPSignatories as $row)
                      <option value="{{ $row->fullname_first }}"
                        @if(($signatory3==strtoupper($row->fullname_first)) || ($signatory3==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div> 
                <label for="signatory_id" class="col-sm-2 col-form-label text-right">Approved 2.</label> 
                <div class="col-4"> 
                  <select id="signatory4" name="signatory4" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getLDDAPSignatories as $row)
                      <option value="{{ $row->fullname_first }}"
                        @if(($signatory4==strtoupper($row->fullname_first)) || ($signatory4==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>              
              </div> 
              <div class="form-group row">  
                <label for="signatory_id" class="col-sm-1 col-form-label">Delivered by</label>
                <div class="col-4"> 
                  <select id="signatory5" name="signatory5" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getLDDAPSignatoriesD as $row)
                      <option value="{{ $row->fullname_first }}"
                        @if(($signatory5==strtoupper($row->fullname_first)) || ($signatory5==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>                             
              </div> 
              <div class="table-responsive">
                <table id="attached_dv_table" class="table-xs table-bordered text-center" style="width: 100%;">    
                  <thead>
                    <th></th>
                    <th>DV Date</th>
                    <th>DV ID</th>
                    <th>DV No.</th>                                      
                    <th>Payee</th>           
                    <th>Bank</th>           
                    <th>Bank Account Name</th>           
                    <th>Bank Account No.</th>           
                    <th>Net Amount</th>    
                    @role('Accounting Officer')       
                    <th style="min-width:2%; max-width:2%;">
                      <button type="button" data-lddap-month="{{ $lddap_month }}" data-lddap-year="{{ $lddap_year }}"
                        data-toggle="tooltip" data-placement='auto' title='Attach voucher'
                        class="btn-xs btn_attach_dv dv-field btn btn-outline-primary add-buttons">
                      <i class="nav-icon fas fa-plus"></i></button>
                    </th>  
                    @endrole       
                  </thead>    
                  <tbody>
                    <?php 
                      $count = 1;
                      $total_lddap_amount=0;
                      foreach ($getAttachedDVbyLDDAP as $row) {  
                          $id = $row->id; 
                          $dv_date = $row->dv_date; 
                          $dv_id = $row->dv_id; 
                          $dv_no = $row->dv_no; 
                          $payee = $row->payee; 
                          $payee_parent_id = $row->payee_parent_id; 
                          $payee_id = $row->payee_id; 
                          $payee_bank_acronym = $row->payee_bank_acronym; 
                          $payee_bank_account_name = $row->payee_bank_account_name; 
                          $payee_bank_account_no = $row->payee_bank_account_no; 
                          $total_dv_net_amount = $row->total_dv_net_amount; 
                          $total_lddap_amount += $total_dv_net_amount; 
                          $for_remit = $row->for_remit; 
                          $bg_color = $row->bg_color; 
                          ?>                            
                          <tr class="text-center"  style="background-color: {{ $bg_color }};">
                            <td style="min-width:2%; max-width:2%;">{{ $count }}</td>
                            <td style="min-width:9%; max-width:9%;">{{ $dv_date }}</td>
                            <td style="min-width:7%; max-width:7%;">
                              <a href="{{ url('funds_utilization/dv/accounting/edit/'.$dv_id) }}" target="_blank" 
                              data-toggle="tooltip" data-placement='auto' title='View DV' >{{ $dv_id }}</td>
                            <td style="min-width:7%; max-width:7%;">{{ $dv_no }}</td>
                            <td class="text-left" style="min-width:22%; max-width:22%;">{{ $payee }}</td>
                            <td style="min-width:7%; max-width:7%;">{{ $payee_bank_acronym }}</td>  
                            <td class="text-left" style="min-width:22%; max-width:22%;">{{ $payee_bank_account_name }}</td>  
                            <td nowrap style="min-width:9%; max-width:9%;">                              
                              <a  @role('Accounting Officer')
                                  href="#" class="btn_replace_payee_bank_account_no" 
                                  data-dv-id="{{ $dv_id }}" data-payee-id="{{ $payee_parent_id }}" 
                                  data-toggle="tooltip" data-placement='right' title='Replace payee bank account number' class="text-left"
                                @endrole >
                                {{ $payee_bank_account_no }}</a>
                            </td>
                            <td nowrap class="text-right" style="min-width:8%; max-width:15%;">{{ number_format($total_dv_net_amount,2) }} 
                              <input type="text" id="lddap_dv_id" name="lddap_dv_id[]" value="{{ $id }}" hidden> 
                            </td>
                            @role('Accounting Officer')      
                            <td style="min-width:2%; max-width:2%;">
                              <button type="button" class="btn-xs btn_remove_attached_dv btn btn-outline-danger" data-id="{{ $id }}" 
                                data-dv-id="{{ $dv_id }}" data-lddap-id="{{ $lddap_id }}" data-toggle="tooltip" data-placement='auto' 
                                title='Remove attached voucher'>  <i class="fa-solid fa-xmark"></i>
                              </button>
                            </td>
                            @endrole
                          </tr>
                          <?php
                          $count=$count+1;
                        }                    
                      ?>
                      <tr class="text-right font-weight-bold">
                        <td colspan="8">Total LDDAP Amount&nbsp;</td>
                        <td nowrap>Php {{ number_format($total_lddap_amount, 2) }}
                          <input type="text" name="total_lddap_amount" value="{{ $total_lddap_amount }}" hidden>
                      </tr>
                  </tbody>          
                </table>
              </div><br>   
              <br>       
              @role('Accounting Officer')  
              <div class="row text-left">  
                <div class="col-5"> 
                  <a style="font-color:white;" href="{{ url('funds_utilization/lddap/'.$fund_id.'/'.$lddap_month.'/'.$lddap_year) }}">
                    <button type="button" class="btn btn-secondary">   Back
                  </button></a>
                </div> 
                <div class="col">
                  <button type="button" class="btn btn-primary save-buttons edit_lddap">Save Changes</button>                                
                </div>     
                <div class="col">  
                  <button type="button" class="btn btn-primary print_lddap">Print LDDAP</button>
                  <button type="button" class="btn btn-primary print_lddap_ada_summary">Print LDDAP-ADA Summary</button>    
                </div>
              </div>
              @endrole
            </form> 
          </div>           
       </div>
    </div>
 </section>  
 @include('funds_utilization.lddap.modal')
@endsection 

@section('jscript')
   <script type="text/javascript" defer>
      $(document).ready(function(){
        @include('funds_utilization.lddap.script')   
        @include('scripts.common_script') 
      });
   </script>
@endsection



