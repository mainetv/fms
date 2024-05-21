@extends('layouts.app')

@section('content')   
  <section class="content"> 
    @php
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
            Add {{ $rs }} Request and Status
          </h3>            
       </div>         
       <div class="card-body">
          <div class="row">            
            <form id="rs_form" class="col-md-12"> 
              <input type="text" id="module_id" name="module_id" value="5" hidden>
              <input type="text" id="rs_type_id" name="rs_type_id" value="{{ $rs_type_id }}" hidden>
              <div class="form-group row">
                <label for="rs_id" class="col-sm-1 col-form-label">{{ $rs_type }} ID</label>
                <div class="col-sm-2"> 
                  <input type="text" name="rs_id" id="rs_id"  class="form-control no-border" readonly>
                </div>
                <div class="col-sm-1"></div>
                <label for="rs_no" class="col-form-label">{{ $rs_type }} No. </label>&emsp;&nbsp;&nbsp;&nbsp;
                <div class="col"> 
                  <input type="text" name="rs_no" id="rs_no" class="form-control no-border" readonly>
                </div> 
              </div>  
              <div class="form-group row">
                <label for="activity_id" class="col-sm-1 col-form-label">Date</label>
                <div class="col-sm-2"> 
                  <input type="text" id="rs_date" name="rs_date"  value="{{ date("Y-m-d") }}" class="form-control rs-field datepicker">
                  <span class="is-invalid"><small id="date-error" class="error"></small></span>
                </div>
                <div class="col-sm-1"></div>
                <label for="fund_id" class="col-form-label">Fund</label>&emsp;&emsp;&emsp;  
                <div class="col-sm-2"> 
                  <input type="text" id="fund_id" name="fund_id" class="form-control rs-field" value="{{ $fund_id }}" hidden>
                  <input type="text" value="{{ $fund }}" class="form-control rs-field" readonly>
                  {{-- <select id="fund_id" name="fund_id" class="form-control rs-field select2bs4">   
                    <option value="" selected hidden>Select Fund</option>
                    @foreach ($getFunds as $row)
                      <option value="{{ $row->id }}" data-id="{{ $row->id }}">{{ $row->fund }}</option>
                    @endforeach                           
                  </select> --}}
                  <span class="is-invalid"><small id="fund-error" class="error"></small></span>
                </div>
                <div class="col-sm-1"></div>   
                <label for="division_id" class="col-form-label">Division</label>&emsp;&emsp;&emsp;
                <div class="col"> 
                  <input type="text" id="division_id" name="division_id" value="{{ $user_division_id }}" class="form-control rs-field" hidden>
                  <input type="text" id="division_acronym" value="{{ $user_division_acronym }}" class="form-control rs-field" readonly>
                </div> 
              </div>              
              <div class="form-group row">
                <label for="payee_id" class="col-sm-1 col-form-label">Payee</label>
                <div class="col-11">
                  <select id="payee_id" name="payee_id" class="form-control rs-field select2bs4">   
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
                <label for="particulars" class="col-sm-1 col-form-label">Particulars<br>
                  <sub><a href="#" class="btn_insert_particulars_template" data-toggle="tooltip" data-placement='auto' 
                  title='Insert particulars template' data-rs-type-id="{{ $rs_type_id }}">Template</a></sub></label>
                <div class="col">             
                  <textarea name="particulars" id="particulars" rows="4" class="form-control rs-field"></textarea>
                  <span class="is-invalid"><small id="particulars-error" class="error"></small></span>
                </div>        
              </div>      
              
              <input type="checkbox" id="showall" name="showall" class="rs-field">Show All Divisions' Activity 
              <br>  
              Charged to:
              <div class="table-responsive">
                <table id="attached_activity_table" class="table-xs table-bordered text-center" style="width: 100%;">    
                  <thead>
                    <th style="max-width:80%;">Activity</th>
                    <th style="min-width:19%;">Amount</th>
                  </thead>    
                  <tbody>
                    
                  </tbody>          
                </table>
              </div><br>
              <label for="signatory_id" class="col-form-label">A. Certified</label>
              <div class="form-group row">  
                <label for="signatory_id" class="col-1 col-form-label text-right">1.</label>
                <div class="col-5"> 
                  <select id="signatory1" name="signatory1" class="form-control rs-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getRsSignatories as $row)
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div> 
                <label for="signatory_id" class="col-1 col-form-label text-right">&emsp;2.</label> 
                <div class="col-5"> 
                  <select id="signatory2" name="signatory2" class="form-control rs-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getRsSignatories as $row)
                      <option value="{{ $row->fullname_first }}" >{{ strtoupper($row->fullname_first) }}</option>
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
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>   
                <label for="signatory_id" class="col-1 col-form-label text-right">&emsp;4.</label>
                <div class="col-5"> 
                  <select id="signatory4" name="signatory4" class="form-control rs-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getRsSignatories as $row)
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>              
              </div><br>
              <div class="form-group row">
                <label for="particulars" class="col-sm-1 col-form-label">Transaction Type</label>
                <div class="col">    
                  <select name="rs_transaction_type_id[]" id="rs_transaction_type_id" multiple="multiple" 
                    data-placeholder="Select Transaction Type" class="rs-field select2bs4 form-control">
                    @foreach($getRsTransactionTypes->groupBy('allotment_class') as $key=>$row)       
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
                  <a style="font-color:white;" href="{{ url('funds_utilization/rs/division/'.$rs_type_url.'/'.date('m').'/'.date('Y')) }}">
                    <button type="button" class="btn btn-secondary"> Back
                  </button></a>
                </div> 
                <div class="col">
                  <button type="button" class="btn btn-primary save-buttons add_rs">Save</button>  
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
   </script>
@endsection



