@extends('layouts.app')

@section('content')   
  <section class="content"> 
    @php

      $getAdaSignatories = getAdaSignatories();
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
                <input type="text" id="report_id" name="report_id" value="3" hidden>
                <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
                <div class="form-group row">
                  <label for="ada_id" class="col-sm-3 col-form-label">ADA ID</label>
                  <div class="col"> 
                    <input type="text" name="ada_id" id="ada_id" class="form-control no-border" readonly>
                  </div>
                </div>                
                <div class="form-group row">
                  <label for="fund_id" class="col-sm-3 col-form-label">Fund</label>
                  <div class="col"> 
                    <select id="fund_id" name="fund_id" class="form-control ada-field select2bs4">   
                      <option value="" selected hidden>Select Fund</option>
                      @foreach ($getFunds as $row)
                        <option value="{{ $row->id }}" data-id="{{ $row->id }}">{{ $row->fund }}</option>
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
                        <option value="{{ $row->id }}">{{ $row->bank_account_no }} </option>
                      @endforeach
                    </select>
                    <span class="is-invalid"><small id="bank-account-id-error" class="error"></small></span>
                  </div>  
                </div>
                <div class="form-group row">
                  <label for="ada_no" class="col-sm-3 col-form-label">SLIIAE No.
                    <a href="javascript:void(0)" class="generate_ada_no_add" 
                    data-toggle="tooltip" data-placement='right' title='Generate sliiae number'> >> </a></label>&nbsp;
                  </label>
                  <div class="col"> 
                    <input type="text" id="ada_no" name="ada_no" class="red font-weight-bold form-control ada-field">
                    <span class="is-invalid"><small id="ada-no-error" class="error"></small></span>
                  </div>                  
                </div> 
                <div class="form-group row">
                  <label for="activity_id" class="col-sm-3 col-form-label">ADA Date</label>
                  <div class="col"> 
                    <input type="text" id="ada_date" name="ada_date" value="{{ date('Y-m-d') }}" class="date form-control ada-field datepicker">
                    <span class="is-invalid"><small id="date-error" class="error"></small></span>
                  </div> 
                </div>                                       
                <div class="form-group row">
                  <label for="activity_id" class="col-sm-3 col-form-label">Check No.</label>
                  <div class="col"> 
                    <input type="text" id="check_no" name="check_no" class="form-control">
                  </div>  
                </div> 
                <div class="form-group row">
                  <label for="activity_id" class="col-sm-3 col-form-label">Amount</label>
                  <div class="col"> 
                    <input type="text" class="bigger-font font-weight-bolder form-control text-right" readonly>
                  </div>  
                </div>
                <div class="form-group row">
                  <label for="date_transferred" class="col-sm-3 col-form-label">Date Transferred</label>
                  <div class="col"> 
                    <input type="text" id="date_transferred" name="date_transferred" class="date form-control ada-field datepicker">
                  </div> 
                </div> 
                <div class="form-group row">
                  <label for="signatory_id" class="col-sm-3 col-form-label">Approved</label>
                  <div class="col"> 
                    <select id="signatory2" name="signatory2" class="form-control dv-field select2bs4">   
                      <option value="" selected hidden>Select Signatory</option>
                      @foreach ($getAdaSignatories as $row)
                        <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
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
                    </thead>    
                            
                  </table>
                </div>  
              </div>
            </div>
            <div class="form-group row">  
              <div class="col-sm-4"> 
                <div class="row">
                  <div class="col-10">
                    <a style="font-color:white;" href="{{ url('funds_utilization/ada/1/'.date('m').'/'.date('Y')) }}">
                      <button type="button" class="btn btn-secondary">Back</button></a>
                  </div>
                  <div class="col">
                    <button type="button" class="btn btn-primary save-buttons add_ada">Save</button>
                  </div>
                </div>
              </div>
            </div>
          </form> 
        </div>           
      </div>
    </div>
  </section>    

@endsection 

@section('jscript')
  <script type="text/javascript" defer>
    $(document).ready(function(){  
      @include('funds_utilization.ada.script')  
      @include('scripts.common_script') 
    });
  </script>
@endsection




