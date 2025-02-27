@extends('layouts.app')

@section('content')   
  <section class="content"> 
    <div class="card text-left">
       <div class="card-header">
          <h3 class="card-title">
            {{ $title }}
          </h3>            
       </div>         
       <div class="card-body">
          <div class="row">            
            <form id="lddap_form" class="col-md-12"> 
              <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
              <div class="form-group row">
                <label for="lddap_id" class="col-sm-1 col-form-label"><span class="label"></span> ID</label>
                <div class="col-sm-2"> 
                  <input type="text" name="lddap_id" id="lddap_id" class="form-control no-border" readonly>
                </div>
                &emsp;&emsp;&emsp;&emsp;&emsp;   
                  <label for="lddap_no" class="col-form-label">
                    <select id="payment_mode_id" name="payment_mode_id" class="label">
                      @foreach ($getPaymentModes as $row)
                        <option value="{{ $row->id }}" data-id="{{ $row->id }}">{{ $row->payment_mode }}</option>
                      @endforeach
                    </select>&nbsp;No.  
                    @role('Accounting Officer')                       
                    <a href="javascript:void(0)" class="generate_lddap_no_add" 
                    data-toggle="tooltip" data-placement='auto' title='Generate lddap number'> >> </a>@endrole</label>&nbsp;
                  <div class="col-sm-2"> 
                    <input type="text" name="lddap_no" id="lddap_no" class="form-control red font-weight-bold">
                  </div>
                &emsp;&emsp;&emsp;&emsp;&emsp;
                <label for="fund_id" class="col-form-label">Fund</label>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
                <div class="col-sm-2"> 
                  <select id="fund_id" name="fund_id" class="form-control lddap-field select2bs4">   
                    {{-- <input id="fund_id" name="fund_id" value="{{ $getFund }}" data-id="{{ $fund_id }}" class="form-control lddap-field" readonly> --}}
                    <option value="" selected>Select Fund</option>
                    @foreach ($getFunds as $row)
                      <option value="{{ $row->id }}" data-id="{{ $row->id }}">{{ $row->fund }}</option>
                    @endforeach                                               
                  </select>
                  <span class="is-invalid"><small id="fund-error" class="error"></small></span>
                </div>                    
              </div>  
              <div class="form-group row">
                <label for="activity_id" class="col-sm-1 col-form-label"><span class="label"></span> Date</label>
                <div class="col-sm-2"> 
                  <input type="text" id="lddap_date" name="lddap_date" value="{{ date("Y-m-d") }}" class="form-control lddap-field datepicker">
                  <span class="is-invalid"><small id="date-error" class="error"></small></span>
                </div> 
                &emsp;&emsp;&emsp;&emsp;&emsp;
                <label for="tax_type" class="col-form-label">NCA No.</label>&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
                <div class="col-sm-2"> 
                  <input type="text" id="nca_no" name="nca_no" class="form-control">
                </div>&emsp;&emsp;&emsp;&emsp;&emsp;       
                <label for="tax_type" class="col-form-label">Bank Account No.</label>&emsp;&nbsp;
                <div class="col-sm-2"> 
                  {{-- <input type="text" name="bank_account_id" id="bank_account_id" class="form-control lddap-field" readonly> --}}
                  <select name="bank_account_id" id="bank_account_id" class="form-control lddap-field select2bs4">
                    <option value="">Select Bank Account No.</option>
                  </select>
                </div>  
              </div>     
              <div class="form-group row lddap">
                <label for="activity_id" class="col-sm-1 col-form-label">Check No.</label>
                <div class="col-sm-2"> 
                  <input type="text" id="check_no" name="check_no" class="form-control">
                </div> 
                &emsp;&emsp;&emsp;&emsp;&emsp;
                <label for="tax_type" class="col-form-label">ACIC No.</label>&emsp;&emsp;&emsp;&emsp;&nbsp;
                <div class="col-sm-2"> 
                  <input type="text" id="acic_no" name="acic_no" class="form-control">
                </div>&emsp;&emsp;&emsp;&emsp;&emsp;       
                <label for="tax_type" class="col-form-label">ADA Date</label>&emsp;&emsp;&emsp;&emsp;&emsp;
                <div class="col-sm-2"> 
                  <input type="text" id="ada_date" class="form-control" readonly>
                </div>  
              </div> 
              <div class="form-group row">  
                <label for="signatory_id" class="col-sm-1 col-form-label">Certified Correct</label>
                <div class="col-4"> 
                  <select id="signatory1" name="signatory1" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getLDDAP1Signatories as $row)
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div> 
                <label for="signatory_id" class="col-sm-2 col-form-label text-right">Approved</label> 
                <div class="col-4"> 
                  <select id="signatory2" name="signatory2" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getLDDAPSignatories as $row)
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>              
              </div> 
              <div class="form-group row">  
                <label for="signatory_id" class="col-sm-1 col-form-label text-right">1.</label>
                <div class="col-4"> 
                  <select id="signatory3" name="signatory3" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getLDDAP2Signatories as $row)
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div> 
                <label for="signatory_id" class="col-sm-2 col-form-label text-right">2.</label> 
                <div class="col-4"> 
                  <select id="signatory4" name="signatory4" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getLDDAPSignatories as $row)
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
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
                      <option value="{{ $row->fullname_first }}">{{ strtoupper($row->fullname_first) }}</option>
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
                    {{-- <th style="min-width:2%; max-width:2%;">
                      <button type="button" data-toggle="tooltip" data-placement='auto' title='Attach voucher'
                        class="btn-xs btn_attach_dv dv-field btn btn-outline-primary add-buttons">
                      <i class="nav-icon fas fa-plus"></i></button>
                    </th>          --}}
                  </thead>    
                  <tbody>
                    <?php                    
                    ?>
                  </tbody>          
                </table>
              </div><br>   
              <br>         
              <div class="row text-left">  
                <div class="col-5"> 
                  <a style="font-color:white;" href="{{ url('funds_utilization/lddap/1/'.date('m').'/'.date('Y')) }}">
                    <button type="button" class="btn btn-secondary">   Back
                  </button></a>
                </div> 
                <div class="col">
                  <button type="button" class="btn btn-primary save-buttons add_lddap">Save</button>                                
                </div>    
              </div>
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




