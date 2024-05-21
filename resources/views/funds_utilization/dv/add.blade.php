@extends('layouts.app')

@php
  $user_division_id=getUserDivisionID($user_id);
  $getPayees=getPayees();
  $getDvSignatories=getDvSignatories();
  $getAllActiveDivisions=getAllActiveDivisions();
  $getPayTypes=getPayTypes();
  $getTaxTypes=getTaxTypes();
  $getFunds=getFunds();
  $getDvTransactionTypes=getDvTransactionTypes();
  if($user_id=='111'){
    $user_division_id=3;
    $user_division_acronym='COA';
  }
  if($user_id=='20' || $user_id=='14'){
    $user_division_id = '9';
    $user_division_acronym='FAD-DO';
  }
@endphp

@section('content')   
  <section class="content"> 
    <div class="card text-left">
       <div class="card-header">
          <h3 class="card-title">
            Add Disbursement Voucher
          </h3>            
       </div>         
       <div class="card-body">
          <div class="row">            
            <form id="dv_form" class="col-md-12"> 
              <input type="text" id="module_id" name="module_id" value="6" hidden>
              <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
              <div class="form-group row">
                <label for="dv_id" class="col-sm-1 col-form-label">DV ID</label>
                <div class="col-sm-2"> 
                  <input type="text" name="dv_id" id="dv_id"  class="form-control no-border" readonly>
                </div> 
                <div class="col-sm-1"></div>  
                <label for="dv_no" class="col-form-label">DV No.</label>&emsp;&emsp;&nbsp;&nbsp;
                <div class="col"> 
                  <input type="text" name="dv_no" id="dv_no" class="form-control no-border" readonly>
                </div> 
              </div>  
              <div class="form-group row">
                <label for="activity_id" class="col-sm-1 col-form-label">Date</label>
                <div class="col-sm-2"> 
                  <input type="text" id="dv_date" name="dv_date" value="{{ date("Y-m-d") }}" class="form-control dv-field datepicker">
                  <span class="is-invalid"><small id="date-error" class="error"></small></span>
                </div>   
                <div class="col-sm-1"></div> 
                <label for="fund_id" class="col-form-label">Fund</label>&emsp;&emsp;&emsp;
                <div class="col-sm-2"> 
                  <select id="fund_id" name="fund_id" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Fund</option>
                    @foreach ($getFunds as $row)
                      <option value="{{ $row->id }}" data-id="{{ $row->id }}">{{ $row->fund }}</option>
                    @endforeach                           
                  </select>
                  <span class="is-invalid"><small id="fund-error" class="error"></small></span>
                </div>   
                <div class="col-sm-1"></div> 
                <label for="division_id" class="col-form-label">Division</label>&emsp;&emsp;&emsp;
                <div class="col"> 
                  <input type="text" id="division_id" name="division_id" value="{{ $user_division_id }}" class="form-control dv-field" hidden>
                  <input type="text" id="division_acronym" value="{{ $user_division_acronym }}" class="form-control dv-field" readonly>
                </div> 
              </div>              
              <div class="form-group row">
                <label for="payee_id" class="col-sm-1 col-form-label">Payee</label>
                <div class="col-11">
                  <select id="payee_id" name="payee_id" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Payee</option>
                    @foreach ($getPayees as $row)
                      <option value="{{ $row->id }}" data-id="{{ $row->id }}">
                        {{ $row->payee }} [{{ $row->bank_acronym }}: {{ $row->bank_account_name }} | {{ $row->bank_account_no }}]
                      </option>
                    @endforeach                           
                  </select>                    
                  <span class="is-invalid"><small id="payee-error" class="error"></small></span>
                </div> 
              </div> 
              <div class="form-group row">
                <label for="particulars" class="col-sm-1 col-form-label">Particulars</label>
                <div class="col">             
                  <textarea name="particulars" id="particulars" rows="4" class="form-control dv-field"></textarea>
                  <span class="is-invalid"><small id="particulars-error" class="error"></small></span>
                </div>        
              </div>   
              {{-- <div class="table-responsive">
                <table id="attached_rs_table" class="table-xs table-bordered text-center" style="width: 100%;">    
                  <thead>
                    <th style="max-width:80%;">ID</th>
                    <th style="max-width:80%;">Date</th>
                    <th style="min-width:19%;">No.</th>
                    <th style="min-width:19%;">Obligated Amount</th>                        
                    <th style="min-width:19%;">DV Payment</th>
                    <th style="min-width:19%;">Balance</th>                    
                  </thead>    
                  <tbody>
                  </tbody>          
                </table>
              </div><br><br> --}}
              {{-- <div class="form-group row">  
                <label for="signatory_id" class="col-1 col-form-label text-right">A. Certified</label>
                <div class="col-4"> 
                  <select id="signatory1" name="signatory1" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getDvSignatories as $row)
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div> 
                <label for="signatory_id" class="col-2 col-form-label text-right">&emsp;B. Approved for Payment</label> 
                <div class="col-5"> 
                  <select id="signatory2" name="signatory2" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getDvSignatories as $row)
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>              
              </div><br>
              <div class="form-group row">  
                <label for="po_no" class="col-1 col-form-label text-right">PO No.</label>
                <div class="col-2"> 
                  <input type="text" id="po_no" name="po_no" class="form-control dv-field">
                </div> 
                <label for="po_date" class="col-1 col-form-label text-right">PO Date</label> 
                <div class="col-2"> 
                  <input type="text" id="po_date" name="po_date" class="form-control dv-field datepicker">
                </div> 
                <label for="invoice_no" class="col-1 col-form-label text-right">Invoice No.</label>
                <div class="col-2"> 
                  <input type="text" id="invoice_no" name="invoice_no" class="form-control dv-field datepicker">
                </div> 
                <label for="invoice_date" class="col-1 col-form-label text-right">Invoice Date</label> 
                <div class="col-2"> 
                  <input type="text" id="invoice_date" name="invoice_date" class="form-control dv-field datepicker">
                </div>             
              </div>
              <div class="form-group row">  
                <label for="jobcon_no" class="col-1 col-form-label text-right">Job Con No.</label>
                <div class="col-2"> 
                  <input type="text" id="jobcon_no" name="jobcon_no" class="form-control dv-field">
                </div> 
                <label for="jobcon_date" class="col-1 col-form-label text-right">Job Con Date</label> 
                <div class="col-2"> 
                  <input type="text" id="jobcon_date" name="jobcon_date" class="form-control dv-field datepicker">
                </div> 
                <label for="or_no" class="col-1 col-form-label text-right">OR No.</label>
                <div class="col-2"> 
                  <input type="text" id="or_no" name="or_no" class="form-control dv-field">
                </div> 
                <label for="or_date" class="col-1 col-form-label text-right">OR Date</label> 
                <div class="col-2"> 
                  <input type="text" id="or_date" name="or_date" class="form-control dv-field datepicker">
                </div>             
              </div> --}}
              <div class="form-group row">
                <label for="particulars" class="col-sm-1 col-form-label">Transaction Type</label>
                <div class="col-11">    
                  <select name="dv_transaction_type_id[]" id="dv_transaction_type_id" multiple="multiple" 
                    data-placeholder="Select Transaction Type" class="dv-field select2bs4 form-control">
                    @foreach($getDvTransactionTypes->groupBy('allotment_class') as $key=>$row)       
                      <optgroup class="font-weight-bold" label="{{ $key }}">
                        @foreach($row as $item)               
                          <option value="{{ $item->id }}">
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
                  <a style="font-color:white;" href="{{ url('funds_utilization/dv/division/'.date('m').'/'.date('Y')) }}">
                    <button type="button" class="btn btn-secondary"> Back
                  </button></a>
                </div> 
                <div class="col">
                  <button type="button" class="btn btn-primary save-buttons add_dv">Save</button>  
                </div>       
              </div>
            </form> 
          </div>           
       </div>
    </div>
 </section>  
 @include('funds_utilization.dv.modal')
@endsection 

@section('jscript')
   <script type="text/javascript" defer>
      $(document).ready(function(){
        @include('funds_utilization.dv.script')   
        @include('scripts.common_script') 
      });
   </script>
@endsection



