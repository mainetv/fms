@extends('layouts.app')

@section('content')   
  <section class="content"> 
    @php

      $getAdaSignatories = getAdaSignatories();
      foreach($getADADetails as $row){
        $ada_id=$row->id;
        $ada_no=$row->ada_no;
        $ada_date=$row->ada_date;      
        $fund_id=$row->fund_id;        
        $bank_account_id=$row->bank_account_id;
        $check_no=$row->check_no;
        $total_ps_amount=$row->ptotal_s_amount;
        $total_mooe_amount=$row->total_mooe_amount;
        $total_co_amount=$row->total_co_amount;
        $total_ada_amount=$row->total_ada_amount;
        $date_transferred=$row->date_transferred;
        $signatory2=$row->signatory2;
      }      
      $ada_month = date("m",strtotime($ada_date));
      $ada_year = date("Y",strtotime($ada_date)); 
    @endphp
    <div class="card text-left">
       <div class="card-header">
          <h3 class="card-title">
            {{ $title }}
          </h3>            
       </div>         
       <div class="card-body">
          <div class="row">            
            <form id="ada_form" class="col-md-12"> 
              <div class="form-group row">
                <div class="col-sm-4">
                  <input type="text" id="year" name="year" value="{{ $ada_year }}" hidden>
                  <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
                  <div class="form-group row">
                    <label for="ada_id" class="col-sm-3 col-form-label">ADA ID</label>
                    <div class="col"> 
                      <input type="text" name="ada_id" id="ada_id" value="{{ $ada_id }}" class="form-control no-border" readonly>
                    </div>
                  </div>                 
                  <div class="form-group row">
                    <label for="fund_id" class="col-sm-3 col-form-label">Fund</label>
                    <div class="col"> 
                      <select id="fund_id" name="fund_id" class="form-control ada-field select2bs4">   
                        <option value="" selected hidden>Select Fund</option>
                        @foreach ($getFunds as $row)
                          <option value="{{ $row->id }}" data-id="{{ $row->id }}" @if($fund_id==$row->id){{"selected"}} @endif>{{ $row->fund }}</option>
                        @endforeach                           
                      </select>
                      <span class="is-invalid"><small id="fund-error" class="error"></small></span>
                    </div>  
                  </div>
                  <div class="form-group row">  
                    <label for="tax_type" class="col-sm-3 col-form-label">Bank Account No.</label>
                    <div class="col"> 
                      <select name="bank_account_id" id="bank_account_id" class="form-control ada-field select2bs4">
                        <option value="">Select Bank Account No.</option>
                        @foreach ($getBankAccounts as $row)
                          <option value="{{ $row->id }}" @if($bank_account_id==$row->id){{ "selected" }} @endif>{{ $row->bank_account_no }} </option>
                        @endforeach
                      </select>
                      <span class="is-invalid"><small id="bank-account-id-error" class="error"></small></span>
                    </div>  
                  </div> 
                  <div class="form-group row">
                    <label for="ada_no" class="col-sm-3 col-form-label">SLIIAE No.</label>
                    <div class="col"> 
                      <input type="text" id="ada_no" name="ada_no" value="{{ $ada_no }}" class="red font-weight-bold form-control ada-field">
                    </div> 
                  </div> 
                  <div class="form-group row">
                    <label for="activity_id" class="col-sm-3 col-form-label">ADA Date</label>
                    <div class="col"> 
                      <input type="text" id="ada_date" name="ada_date" value="{{ $ada_date }}" class="date form-control ada-field datepicker">
                      <span class="is-invalid"><small id="date-error" class="error"></small></span>
                    </div> 
                  </div>                                        
                  <div class="form-group row">
                    <label for="activity_id" class="col-sm-3 col-form-label">Check No.</label>
                    <div class="col"> 
                      <input type="text" id="check_no" name="check_no" value="{{ $check_no }}" class="form-control">
                    </div>  
                  </div> 
                  <div class="form-group row">
                    <label for="activity_id" class="col-sm-3 col-form-label">Amount</label>
                    <div class="col"> 
                      <input type="text" value="{{ number_format($total_ada_amount, 2) }}" class="bigger-font font-weight-bolder form-control text-right" readonly>
                    </div>  
                  </div>
                  <div class="form-group row">
                    <label for="date_transferred" class="col-sm-3 col-form-label">Date Transferred</label>
                    <div class="col"> 
                      <input type="text" id="date_transferred" name="date_transferred" value="{{ $date_transferred }}" class="date form-control ada-field datepicker">
                    </div> 
                  </div> 
                  <div class="form-group row">
                    <label for="signatory_id" class="col-sm-3 col-form-label">Approved</label>
                    <div class="col"> 
                      <select id="signatory2" name="signatory2" class="form-control dv-field select2bs4">   
                        <option value="" selected hidden>Select Signatory</option>
                        @foreach ($getAdaSignatories as $row)
                          <option value="{{ $row->fullname_first }}" 
                            @if(($signatory2==strtoupper($row->fullname_first)) || ($signatory2==$row->fullname_first) ){{ "selected" }} @endif>
                            {{ strtoupper($row->fullname_first) }}</option>
                        @endforeach                           
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-7">
                  <div class="table-responsive">
                    <table id="attached_lddap_table" class="table-xs table-bordered text-center" style="width: 100%;">    
                      <thead>
                        <th>LDDAP ID</th>
                        <th>LDDAP No.</th>
                        <th>LDDAP Date</th>           
                        <th>Fund</th>           
                        <th>NCA No.</th>           
                        <th>ACIC No.</th>           
                        <th>Bank Account No.</th>           
                        <th>Amount</th>           
                        <th style="min-width:3%; max-width:3%;">
                          <button type="button" data-ada-month="{{ $ada_month }}" data-ada-year="{{ $ada_year }}"
                            data-toggle="tooltip" data-placement='left' title='Attach LDDAP'
                            class="btn-xs btn_attach_lddap btn btn-outline-primary add-buttons">
                          <i class="nav-icon fas fa-plus"></i></button>
                        </th>         
                      </thead>    
                      <tbody>
                        <?php 
                          $total_ada_amount=0;
                          foreach ($getAttachedLDDAPbyADA as $row) {   
                              $total_ada_amount += $row->total_lddap_net_amount; 
                              ?>                            
                              <tr class="text-center">
                                <td style="min-width:8%; max-width:8%;">
                                  <a href="{{ url('funds_utilization/lddap/edit/'.$row->lddap_id) }}" target="_blank" 
                                  data-toggle="tooltip" data-placement='right' title='View LDDAP'>{{ $row->lddap_id }}</td>
                                <td style="min-width:18%; max-width:18%;">{{ $row->lddap_no }}</td>
                                <td style="min-width:11%; max-width:11%;">{{ $row->lddap_date }}</td>
                                <td style="min-width:6%; max-width:6%;">{{ $row->fund }}</td>  
                                <td nowrap style="min-width:12%; max-width:12%;">{{ $row->nca_no }}</td>  
                                <td nowrap style="min-width:8%; max-width:8%;">{{ $row->acic_no }}</td>  
                                <td nowrap style="min-width:15%; max-width:15%;">{{ $row->bank_account_no }}</td>  
                                <td nowrap class="text-right" style="min-width:18%; max-width:18%;">{{ number_format($row->total_lddap_net_amount,2) }} 
                                  <input type="text" id="ada_lddap_id" name="ada_lddap_id[]" value="{{ $row->lddap_id }}" hidden> 
                                </td> 
                                <td style="min-width:4%; max-width:4%;">
                                  <button type="button" class="btn-xs btn_remove_attached_lddap btn btn-outline-danger" data-id="{{ $row->id }}" 
                                    data-ada-id="{{ $ada_id }}" data-lddap-id="{{ $row->lddap_id }}"  data-toggle="tooltip" data-placement='auto' title='Remove attached LDDAP'>
                                    <i class="fa-solid fa-xmark"></i>
                                  </button>
                                </td>
                              </tr>
                              <?php
                            }                    
                          ?>
                          <tr class="text-right font-weight-bold">
                            <td colspan="7">Total ADA Amount&nbsp;</td>
                            <td nowrap>Php {{ number_format($total_ada_amount, 2) }}
                              <input type="text" name="total_ada_amount" value="{{ $total_ada_amount }}" hidden>
                          </tr>
                      </tbody>          
                    </table>
                  </div>  
                </div>
              </div>
              <div class="form-group row">  
                <div class="col-sm-4"> 
                  {{-- <div class="form-group row"> --}}
                    {{-- <div class="col-sm-1"> --}}
                      <a style="font-color:white;" href="{{ url('funds_utilization/ada/'.$fund_id.'/'.$ada_month.'/'.$ada_year) }}">
                        <button type="button" class="btn btn-secondary">Back
                      </button></a>&emsp;&emsp;&emsp;&emsp;
                    {{-- </div>
                    <div class="col-sm-1"> --}}
                      <button type="button" class="btn btn-primary save-buttons edit_ada">Save Changes</button>&emsp;&emsp;&emsp;&emsp; 
                    {{-- </div>  
                    <div class="col-sm-2"> --}}
                      <button type="button" class="btn btn-primary print_lddap_ada_summary">Print LDDAP-ADA Summary</button>    
                    {{-- </div> --}}
                  {{-- </div> --}}
                </div>
              </div>
            </form> 
          </div>           
       </div>
    </div>
 </section>  
 @include('funds_utilization.ada.modal')
@endsection 

@section('jscript')
   <script type="text/javascript" defer>
      $(document).ready(function(){
        @include('funds_utilization.ada.script')   
        @include('scripts.common_script') 
      });
   </script>
@endsection



