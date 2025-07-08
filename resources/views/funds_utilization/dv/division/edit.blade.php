@extends('layouts.app')

@section('content')   
  <section class="content"> 
    @php
      $user_division_id=getUserDivisionID($user_id);
      $getPayees=getPayees();
      $getDvSignatories=getDvSignatories();
      $getAllActiveDivisions=getAllActiveDivisions();     
      $getFunds=getFunds();
      $getDvTransactionTypes=getDvTransactionTypes();
      foreach($getDvDetails as $row){
        $dv_id=$row->id;
        $lddap_id=$row->lddap_id;
        $dv_no=$row->dv_no;
        $dv_date=$row->dv_date;
        $dv_date1=$row->dv_date1;
        $fund=$row->fund;
        $fund_id=$row->fund_id;
        $division_id=$row->division_id;
        $division_acronym=$row->division_acronym;
        $payee=$row->payee;
        $payee_id=$row->payee_id;
        $payee_parent_id=$row->payee_parent_id;
        $particulars=$row->particulars;
        $signatory1b=$row->signatory1b;
        $signatory1=$row->signatory1;
        $signatory2=$row->signatory2;
        $signatory3=$row->signatory3;
        $signatory4=$row->signatory4;
        $tax_type_id=$row->tax_type_id;
        $pay_type_id=$row->pay_type_id;
        $is_locked=$row->is_locked;
        $locked_at=$row->locked_at;
        $cancelled_at=$row->cancelled_at;
        $po_no=$row->po_no;
        $po_date=$row->po_date;
        $jobcon_no=$row->jobcon_no;
        $jobcon_date=$row->jobcon_date;
        $invoice_no=$row->invoice_no;
        $invoice_date=$row->invoice_date;
        $or_no=$row->or_no;
        $or_date=$row->or_date;
      }     
      
      $dv_month = date("m",strtotime($dv_date));
      $dv_year = date("Y",strtotime($dv_date));      
    @endphp
    <div class="card text-left">
       <div class="card-header">
          <h3 class="card-title">
            Edit DV 
          </h3>            
       </div>         
       <div class="card-body">
          <div class="row">            
            <form id="dv_form" class="col-md-12"> 
              <input type="text" id="parent_id" name="parent_id" value="{{ $payee_parent_id }}" hidden>
              <input type="text" id="lddap_id" name="lddap_id" value="{{ $lddap_id }}" hidden>
              <input type="text" id="year" name="year" value="{{ $dv_year }}" hidden>
              <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
              <div class="form-group row">
                <label for="dv_id" class="col-sm-1 col-form-label">DV ID</label>
                <div class="col-sm-2"> 
                  <input type="text" name="dv_id" id="dv_id" value="{{ $dv_id }}" class="form-control no-border" readonly>
                </div>
                <div class="col-sm-1"></div>  
                <label for="dv_no" class="col-form-label">DV No.</label>&emsp;&emsp;&nbsp;&nbsp;
                <div class="col"> 
                  <input type="text" name="dv_no" id="dv_no" value="{{ $dv_no }}" class="form-control no-border" readonly>
                </div> 
              </div>  
              <div class="form-group row">
                <label for="activity_id" class="col-sm-1 col-form-label">Date</label>
                <div class="col-sm-2"> 
                  <input type="text" id="dv_date" name="dv_date" value="@if($dv_date1==NULL) {{ $dv_date }} @else {{ $dv_date1 }}@endif" class="form-control dv-field datepicker">
                  <span class="is-invalid"><small id="date-error" class="error"></small></span>
                </div> 
                <div class="col-sm-1"></div> 
                <label for="fund_id" class="col-form-label">Fund</label>&emsp;&emsp;&emsp;
                <div class="col-sm-2"> 
                  <select id="fund_id" name="fund_id" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Fund</option>
                    @foreach ($getFunds as $row)
                      <option value="{{ $row->id }}" data-id="{{ $row->id }}" @if($fund_id==$row->id){{"selected"}} @endif>{{ $row->fund }}</option>
                    @endforeach                           
                  </select>
                  <span class="is-invalid"><small id="fund-error" class="error"></small></span>
                </div> 
                <div class="col-sm-1"></div> 
                <label for="division_id" class="col-form-label">Division</label>&emsp;&emsp;&emsp;
                <div class="col"> 
                  <input type="text" id="division_id" name="division_id" value="{{ $division_id }}" class="form-control dv-field" hidden>
                  <input type="text" id="division_acronym"  value="{{ $division_acronym }}" class="form-control dv-field" readonly>
                </div>     
                </div>                         
              </div>              
              <div class="form-group row">
                <label for="payee_id" class="col-sm-1 col-form-label">Payee</label>
                <div class="col-11">
                  <select id="payee_id" name="payee_id" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Payee</option>
                    @foreach ($getPayees as $row)
                      <option value="{{ $row->id }}" data-id="{{ $row->id }}" @if($payee_id==$row->id){{ "selected" }} @endif>
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
                  <textarea name="particulars" id="particulars" rows="4" class="form-control dv-field">{{ $particulars }}
                  </textarea>                  
                  <span class="is-invalid"><small id="particulars-error" class="error"></small></span>
                </div>        
              </div>  
              <div class="table-responsive">
                <table id="attached_rs_table" class="table-xs table-bordered text-center" style="width: 100%;">    
                  <thead>
                    <th style="max-width:80%;">ID</th>
                    <th style="max-width:80%;">Date</th>
                    <th style="min-width:19%;">No.</th>                      
                    <th style="min-width:19%;">Obligated Amount</th>                        
                    <th style="min-width:19%;">Gross DV Payment</th>
                    <th style="min-width:19%;">Balance</th>
                    @if($is_locked==0)
                    @role('Division Budget Controller')  
                    <th>
                      <button type="button" data-toggle="tooltip" data-placement='left' title='Attach request and status'
                        class="btn-xs btn_attach_rs dv-field btn btn-outline-primary add-buttons">
                      <i class="nav-icon fas fa-plus"></i></button>
                    </th>
                    @endrole
                    @endif
                  </thead>    
                  <tbody>
                    <?php        
                      $total_dv_gross_amount = 0;               
                      $all_dv_gross_amount_on_rs = 0;               
                      foreach ($getAttachedRSbyDV as $row) {    
                        $rs_id=$row->rs_id;
                        $all_dv_gross_amount_on_rs = DB::table('view_rs_total_dv')->where('id',$rs_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('total_dv_gross_amount')->first();
                        $total_rs_activity_amount = $row->total_rs_activity_amount;                            
                        $dv_amount = $row->dv_amount; 
                        $balance = $total_rs_activity_amount - $all_dv_gross_amount_on_rs; 
                        $total_dv_gross_amount += $dv_amount; ?>                            
                        <tr class="text-center">
                          <td>@if($is_locked==0)@role('Accounting Officer|Division Budget Controller')<a href="#" class="btn_edit_attached_rs" data-dv-rs-id="{{ $row->id }}" 
                            data-toggle="tooltip" data-placement='right' title='Replace attached request and status' class="text-left">
                            @endrole @endif
                            {{ $row->rs_id }}</td>
                          <td>{{ $row->rs_date }}</td>
                          <td>{{ $row->rs_no }}</td>
                          <td class="text-right">{{ number_format($total_rs_activity_amount, 2) }}</td>                          
                          <td><input type="text" class="text-right amount" id="dv_rs_amount" name="dv_rs_amount[]" value="{{ number_format($dv_amount, 2) }}">
                            <input type="text" id="dv_rs_id" name="dv_rs_id[]" value="{{ $row->id }}" hidden></td>
                            <input type="text" id="rs_id" name="rs_id[]" value="{{ $row->rs_id }}" hidden>
                          <td class="text-right">{{ number_format($balance, 2) }}</td>
                          @if($is_locked==0)  
                          @role('Accounting Officer|Division Budget Controller')  
                          <td>
                            <button type="button" class="btn-xs btn_remove_attached_rs btn btn-outline-danger" data-id="{{ $row->id }}" 
                              data-dv-id="{{ $dv_id }}" data-rs-id="{{ $row->rs_id }}" 
                              data-toggle="tooltip" data-placement='auto' title='Remove attached request and status'><i class="fa-solid fa-xmark"></i>
                            </button>
                          </td>
                          @endrole
                          @endif
                        </tr>
                        <?php
                      }
                    ?>
                    <tr class="text-right font-weight-bold">
                      <td colspan="4">Total DV Amount</td>
                      <td>₱ {{ number_format($total_dv_gross_amount, 2) }}
                    </tr>
                  </tbody>          
                </table>
              </div><br>
              <div class="form-group row">  
                <label for="signatory_id" class="col-1 col-form-label text-right">A. Certified</label>
                <div class="col-2"> 
                  <input value="{{ $signatory1 ?? '' }}" id="signatory1" name="signatory1" class="form-control" readonly>    
                </div> 
                <label for="signatory_id" class="col-1 col-form-label text-right">&emsp;B. Certified</label> 
                <div class="col-2"> 
                  <input value="{{ $getDvSignatory2->fullname_first }}" id="signatory2" name="signatory2" class="form-control" readonly>    
                </div>   
                <label for="signatory_id" class="col-2 col-form-label text-right">&emsp;D. Approved for Payment</label> 
                <div class="col-4"> 
                  <select id="signatory3" name="signatory3" class="form-control dv-field select2bs4">   
                    <option value="" selected hidden>Select Signatory</option>
                    @foreach ($getDvSignatories as $row)
                      <option value="{{ $row->fullname_first }}"
                        @if(($signatory2==strtoupper($row->fullname_first)) || ($signatory2==$row->fullname_first) ){{ "selected" }} @endif>
                        {{ strtoupper($row->fullname_first) }}</option>
                    @endforeach                           
                  </select>
                </div>            
              </div> 
              <div class="form-group row">  
                <label for="po_no" class="col-1 col-form-label text-right">PO No.</label>
                <div class="col-2"> 
                  <input type="text" id="po_no" name="po_no" value="{{ $po_no }}" class="form-control dv-field">
                </div> 
                <label for="po_date" class="col-1 col-form-label text-right">PO Date</label> 
                <div class="col-2"> 
                  <input type="text" id="po_date" name="po_date" value="{{ $po_date }}" class="form-control dv-field datepicker">
                </div> 
                <label for="invoice_no" class="col-1 col-form-label text-right">Invoice No.</label>
                <div class="col-2"> 
                  <input type="text" id="invoice_no" name="invoice_no" value="{{ $invoice_no }}" class="form-control dv-field">
                </div> 
                <label for="invoice_date" class="col-1 col-form-label text-right">Invoice Date</label> 
                <div class="col-2"> 
                  <input type="text" id="invoice_date" name="invoice_date" value="{{ $invoice_date }}" class="form-control dv-field datepicker">
                </div>             
              </div>
              <div class="form-group row">  
                <label for="jobcon_no" class="col-1 col-form-label text-right">Job Con No.</label>
                <div class="col-2"> 
                  <input type="text" id="jobcon_no" name="jobcon_no" value="{{ $jobcon_no }}" class="form-control dv-field">
                </div> 
                <label for="jobcon_date" class="col-1 col-form-label text-right">Job Con Date</label> 
                <div class="col-2"> 
                  <input type="text" id="jobcon_date" name="jobcon_date" value="{{ $jobcon_date }}" class="form-control dv-field datepicker">
                </div> 
                <label for="or_no" class="col-1 col-form-label text-right">OR No.</label>
                <div class="col-2"> 
                  <input type="text" id="or_no" name="or_no"  value="{{ $or_no }}"class="form-control dv-field">
                </div> 
                <label for="or_date" class="col-1 col-form-label text-right">OR Date</label> 
                <div class="col-2"> 
                  <input type="text" id="or_date" name="or_date" value="{{ $or_date }}" class="form-control dv-field datepicker">
                </div>             
              </div> 
              <div class="form-group row">
                <label for="particulars" class="col-sm-1 col-form-label">Transaction Type</label>
                <div class="col">                      
                  <?php 
                    $Array = array();
                    foreach($getSelectedDvTransactionTypes as $row1){
                      $arr = "";
                      $arr = $row1->dv_transaction_type_id;                      
                      $Array[] = $arr;
                    }
                    $arr1 = implode(",", $Array);
                    $arr2 = explode(',', $arr1);
                  ?>         
                  <select name="dv_transaction_type_id[]" id="dv_transaction_type_id" multiple="multiple" 
                    data-placeholder="Select Transaction Type" class="dv-field select2bs4 form-control">
                    @foreach($getDvTransactionTypes->groupBy('allotment_class') as $key=>$row)       
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
              <br>    
              @role('Accounting Officer|Division Budget Controller|Division Director')     
              <div class="row text-left">  
                <div class="col-5"> 
                  <a style="font-color:white;" href="{{ url('funds_utilization/dv/division/'.$dv_month.'/'.$dv_year) }}">
                    <button type="button" class="btn btn-secondary">   Back
                  </button></a>
                </div> 
                <div class="col">
                  @role('Division Budget Controller')
                    <button type="button" class="btn btn-primary @if($total_dv_gross_amount!=0) print_dv @else disabled @endif">
                      <i class="fa-lg fa-solid fa-print"></i> Print</button>                  
                    <button type="button" class="btn btn-primary save-buttons @if($is_locked==0) edit_dv @elseif($is_locked==1) d-none @endif">Save Changes</button>  
                  @endrole
                </div>       
              </div>
              @endrole
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



