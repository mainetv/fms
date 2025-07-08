@extends('layouts.app')

@section('content')   
  <?php use App\Models\DvRsAccount; ?>
  <section class="content"> 
    @php      
      $getPayTypes=getPayTypes();
      $getTaxTypes=getTaxTypes();
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
        $tax_type_id=$row->tax_type_id;
        $pay_type_id=$row->pay_type_id;
        $is_locked=$row->is_locked;
        $locked_at=$row->locked_at;        
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
                &emsp;&emsp;&emsp;   
                <label for="dv_no" class="col-form-label">DV No.                         
                  <a href="javascript:void(0)" class="generate_dv_no" data-dv-id="{{ $dv_id }}" data-year="{{ $dv_year }}"                    
                    data-toggle="tooltip" data-placement='left' title='Generate DV number'> >> </a></label>&emsp;&emsp;&nbsp;
                <div class="col-sm-2"> 
                  <input type="text" name="dv_no" id="dv_no" value="{{ $dv_no }}" class="form-control red font-weight-bold">
                </div>
                &emsp;&emsp;&emsp;
                <label for="division_id" class="col-form-label">Division</label>&emsp;&emsp;&emsp;&nbsp;&nbsp;
                <div class="col-sm-2"> 
                  <input type="text" id="division_id" name="division_id" value="{{ $division_id }}" class="form-control dv-field" hidden>
                  <input type="text" id="division_acronym"  value="{{ $division_acronym }}" class="form-control dv-field" readonly>
                </div>   
                &emsp;&emsp;&emsp;&emsp;                  
                <div class="col-sm-2"> 
                  <input type="checkbox" name="is_locked" id="is_locked" class="form-check-input"
                  value="{{ $is_locked == '1' ? '1':'0' }}"  {{ $is_locked == '1' ? 'checked':'' }}>Lock                  
                </div>  
              </div>  
              <div class="form-group row">
                <label for="activity_id" class="col-sm-1 col-form-label">Date</label>
                <div class="col-sm-2"> 
                  <input type="text" id="dv_date1" name="dv_date1" value="@if($dv_date1==NULL) {{ date('Y-m-d') }} @else {{ $dv_date1 }}@endif" class="form-control dv-field datepicker">
                  <span class="is-invalid"><small id="date-error" class="error"></small></span>
                </div>                 
                &emsp;&emsp;&emsp;
                <input type="text" id="fund_id" name="fund_id" value="{{ $fund_id }}" hidden>
                <label for="tax_type" class="col-form-label">Tax Type</label>&emsp;&emsp;&nbsp;&nbsp;
                <div class="col-sm-2"> 
                  <select name="tax_type_id" id="tax_type_id" class="form-control dv-field">
                    <option value="">Select Tax Type</option>
                    @foreach ($getTaxTypes as $row)
                      <option value="{{ $row->id }}" @if($tax_type_id==$row->id){{ "selected" }} @endif>{{ $row->tax_type }} </option>
                    @endforeach
                  </select>
                </div>&emsp;&emsp;&emsp;       
                <label for="tax_type" class="col-form-label">Pay Type</label>&emsp;&emsp;&emsp;
                <div class="col-sm-2"> 
                  <select name="pay_type_id" id="tax_type_id" class="form-control dv-field">
                    <option value="">Select Pay Type</option>
                    @foreach ($getPayTypes as $row)
                      <option value="{{ $row->id }}" @if($pay_type_id==$row->id){{ "selected" }} @endif>{{ $row->pay_type }} </option>
                    @endforeach
                  </select>
                </div>&emsp;&emsp;&emsp;
                <label for="tax_type" class="col-form-label">Fund</label>&emsp;&emsp;&nbsp;&nbsp;
                <div class="col-sm-1"> 
                  <input type="text" id="fund" value="{{ $fund }}" class="form-control dv-field" readonly>
                </div>  
                </div>                         
              </div>              
              <div class="form-group row">
                <label for="payee_id" class="col-sm-1 col-form-label">Payee</label>
                <div class="col-11">                  
                  <input type="text" id="payee_id" name="payee_id" value="{{ $payee_id }}" class="form-control" hidden>
                  <input type="text" id="payee" name="payee" value="{{ $payee }}" class="form-control" readonly>
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
              {{-- dv gross by division --}}
              <div class="table-responsive">
                <table id="attached_rs_table" class="table-xs table-bordered text-center" style="width: 100%;">    
                  <thead>
                    <th>RS ID</th>
                    <th>RS Date</th>
                    <th>RS No.</th>                                      
                    <th>Object Code</th>                                      
                    <th>Gross Amount</th>           
                  </thead>    
                  <tbody>
                    <?php 
                      $total_dv_gross_amount = 0;                   
                      foreach ($getAttachedRSbyDV as $row) {
                        $total_dv_gross_amount+=$row->dv_amount; ?>   
                        <tr>
                          <td style="min-width:20px; max-width:20px;">{{ $row->rs_id }}</td>
                          <td style="min-width:20px; max-width:20px;">{{ $row->rs_date }}</td>
                          <td style="min-width:50px; max-width:50px;">{{ $row->rs_no }}</td>
                          <td style="min-width:50px; max-width:50px;">{{ $row->object_code }}</td>
                          <td class="text-right">{{ number_format($row->dv_amount,2) }}</td>
                        </tr>          
                        <?php
                      }
                    ?>
                      <tr class="text-right font-weight-bold">
                        <td colspan="3">Total DV Amount</td>
                        <td>
                          <input type="text" id="total_dv_gross_amount" name="total_dv_gross_amount" value="{{ $total_dv_gross_amount }}" hidden>
                          ₱ {{ number_format($total_dv_gross_amount, 2) }}
                      </tr>
                  </tbody>          
                </table>
              </div><br>
                {{-- dv net by accounting --}}
              <div class="table-responsive">
                <table id="attached_rs_net_table" class="table-xs table-bordered text-center" width="100%">    
                  <thead>
                    <th>RS ID</th>
                    <th>RS No.</th>    
                    <th>Division</th>                                        
                    <th>DV Amount</th> 
                    <th>Total Deductions</th> 
                    <th>Net Amount</th>
                    @role('Accounting Officer')  
                    <th>
                      <button type="button" data-toggle="tooltip" data-placement='top' title='Attach request and status'
                        class="btn-xs btn_attach_rs_net dv-field btn btn-outline-primary add-buttons">
                      <i class="nav-icon fas fa-plus"></i></button>
                    </th>
                    @endrole
                  </thead>     
                  <tbody>
                    <?php        
                      $total_dv_gross_amount = 0;                 
                      $total_dv_net_amount = 0;                 
                      $all_tax = 0;                 
                      $all_deductions = 0;                 
                      $net_amount = 0;                 
                      foreach ($getAttachedRsNetbyDV as $row) {  
                        $rs_id = $row->id;
                        $dv_rs_net_id = $row->id;		
                        $gross_amount = $row->gross_amount; 
                        $tax_one = $row->tax_one; 
                        $tax_two = $row->tax_two; 
                        $tax_twob = $row->tax_twob; 
                        $tax_three = $row->tax_three; 
                        $tax_five = $row->tax_five; 
                        $tax_six = $row->tax_six; 
                        $wtax = $row->wtax; 
                        $other_tax = $row->other_tax; 
                        $liquidated_damages = $row->liquidated_damages; 
                        $other_deductions = $row->other_deductions; 
                        $all_tax = $tax_one + $tax_two + $tax_twob + $tax_three + $tax_five + $tax_six + $wtax + $other_tax;
                        $all_deductions = $all_tax + $liquidated_damages + $other_deductions;
                        $net_amount = $gross_amount - $all_deductions;                        
                        $total_dv_net_amount += $net_amount;
                        $dvAccounts = \App\Models\DvRsAccount::with(['dvRsNet', 'chartAccount'])
                          ->whereNULL('deleted_at')
                          ->where('dv_rs_net_id', $dv_rs_net_id)
                          ->get();
                        ?>  
                        <tr class="text-right summary-row" data-dv-rs-id="{{ $row->id }}">
                          <td class="text-center">
                            <a href="#" class="btn_edit_attached_rs_net" data-dv-rs-id="{{ $row->id }}" 
                            data-toggle="tooltip" data-placement='right' title='Replace attached request and status' class="text-left">
                            {{ $row->rs_id }}</a>&emsp;
                          <button type="button" data-dv-rs-id="{{ $row->id }}" data-toggle="tooltip" data-placement='top' title='Add DV chart of account'
                            class="btn-xs btn_add_dv_chart_account dv-field btn btn-outline-primary add-buttons">
                          <i class="nav-icon fas fa-plus"></i></button>
                          </td>
                          <td nowrap class="text-center">{{ $row->rs_no }}</td>
                          <td class="text-center">{{ $row->division_acronym }}</td>
                          <td>
                            <input type="text" size="20" class="text-right amount" id="gross_amount_{{ $row->id }}" name="gross_amount[{{ $row->id }}]"
                             value="{{ number_format($gross_amount, 2) }}">
                          </td>  
                          <td>
                            <span class="all_deductions_display">{{ number_format($all_deductions, 2) }}</span>
                            <input type="hidden" class="all_deductions_input" value="{{ $all_deductions }}">
                          </td>
                          <td>
                            <span class="net_amount_display">{{ number_format($net_amount, 2) }}</span>
                            <input type="hidden" class="net_amount_input" name="net_amount[{{ $row->id }}]" value="{{ $net_amount }}">
                            <input type="hidden" id="dv_rs_id" name="dv_rs_id[]" value="{{ $row->id }}">
                          </td>

                          @role('Accounting Officer')  
                          <td class="text-center">
                            <button type="button" class="btn-xs btn_remove_attached_rs_net btn btn-outline-danger" data-id="{{ $row->id }}" 
                              data-dv-id="{{ $row->dv_id }}" data-lddap-id="{{ $lddap_id }}" 
                              data-toggle="tooltip" data-placement='auto' title='Remove attached request and status'><i class="fa-solid fa-xmark"></i>
                            </button>
                          </td>
                          @endrole
                        </tr>                                              
                        <tr class="chart-accounts-row" data-dv-rs-id="{{ $row->id }}">
                          <td></td>
                          <td colspan="6"> 
                            <table width="100%" id="tbl_dv_chart_accounts">  
                              <thead>
                                <th>Account Title</th>
                                <th>1%</th>
                                <th>2%</th>
                                <th>2%<br>(Franchise)</th>
                                <th>3%</th>
                                <th>5%</th>
                                <th>6%</th>
                                <th>WTax (0.08)</th>
                                <th>Other Tax</th>
                                <th>Total Amount</th>
                              </thead>
                              <tbody class="chart-body-{{ $row->id }}">                            
                                @include('funds_utilization.dv.partials.chart_accounts_table', [
                                  'dvAccounts' => $dvAccounts,
                                  'rsRow' => $row
                                ])
                               </tbody>
                            </table>
                          </td>                          
                        </tr>                        
                        <?php
                      }
                    ?>
                    <tr class="text-right font-weight-bold">
                      <td colspan="5">Total DV Net Amount</td>
                      <td>
                        ₱ <span id="total_dv_net_amount">{{ number_format($total_dv_net_amount, 2) }}</span>
                      </td>
                    </tr>

                    <tr></tr>
                  </tbody>          
                </table>
              </div>
              <br>             

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
              <br>    
              @role('Accounting Officer|Division Budget Controller')     
              <div class="row text-left">  
                <div class="col-5"> 
                  @if($dv_date1!=NULL)
                    <a style="font-color:white;" href="{{ url('funds_utilization/dv/all/'.$dv_date1) }}">
                      <button type="button" class="btn btn-secondary">   Back
                    </button></a>
                  @else
                    <a style="font-color:white;" href="{{ url('funds_utilization/dv/all/'.date('Y-m-d')) }}">
                      <button type="button" class="btn btn-secondary">   Back
                    </button></a>
                  @endif
                </div> 
                <div class="col">
                  <button type="button" class="btn btn-primary print_dv"> <i class="fa-lg fa-solid fa-print"></i> Print</button>                  
                  <button type="button" class="btn btn-primary save-buttons update_dv">Save Changes</button>   
                </div> 
                {{-- <div class="col">
                  <button type="button" class="btn btn-primary save-buttons update_dv">Save Changes</button>  
                </div>        --}}
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



