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
            <form id="check_form" class="col-md-12"> 
              <div class="form-group row">
                {{-- <div class="col-sm-2">
                  <input type="text" id="year" name="year" value="{{ $check_year }}" hidden>
                  <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
                </div> --}}
                <div class="col-sm-12">
                  <div class="table-responsive">
                    <table id="attached_dv_table" class="table-xs table-bordered text-center table-hover" style="width: 100%;">    
                      <thead>
                        <th width="6%">DV ID</th>
                        <th width="6%">DV No.</th>
                        <th width="8%">Check Date</th>           
                        <th width="10%">Check No.</th>           
                        <th width="51%">Payee</th>              
                        <th width="10%">Amount</th>           
                        <th width="9%">Date Released</th>      
                      </thead>    
                      <tbody>
                        <?php 
                          $total_check_amount=0;
                          foreach ($getCheckDV as $row) {   ?>
                          <tr class="text-left gray-bg">
                            <td colspan="4">Bank Account No.: <strong>{{ $row->bank_account_no }}</strong></td>
                            <td>Fund: <strong>{{ $row->fund }}</strong></td>
                            <td colspan="3"></td>
                            {{-- <td colspan="3">Balance: <strong></strong></td> --}}
                          </tr>
                          <?php
                            $getCheckDVByAccountbyDate=getCheckDVByAccountbyDate($row->bank_account_id, $row->check_date);
                            foreach ($getCheckDVByAccountbyDate as $row1) {   
                              $check_date=$row1->check_date;
                              $fund_id=$row1->fund_id;
                                ?>                            
                                <tr class="text-center">
                                  <td>
                                    <a href="{{ url('funds_utilization/dv/accounting/edit/'.$row1->dv_id) }}" target="_blank" 
                                    data-toggle="tooltip" data-placement='auto' title='View DV'>{{ $row1->dv_id }}</td>
                                  <td>{{ $row1->dv_no }}</td>
                                  <td>{{ $row1->check_date }}</td>
                                  <td>{{ $row1->check_no }}</td>
                                  <td class="text-left">{{ $row1->payee }}</td>  
                                  <td nowrap class="text-right">{{ number_format($row1->total_dv_net_amount,2) }}</td>  
                                  <td nowrap>{{ $row1->date_released }}</td>  
                                </tr>
                                <?php
                              }  
                          } 
                          $check_month = date("m",strtotime($check_date));
                          $check_year = date("Y",strtotime($check_date)); 
                          ?>
                      </tbody>  
                    </table>
                  </div>  
                </div>
              </div>
              <div class="form-group row">  
                <div class="col-sm-2"> 
                    <a style="font-color:white;" href="{{ url('funds_utilization/lddap/'.$fund_id.'/'.$check_month.'/'.$check_year) }}">
                      <button type="button" class="btn btn-secondary">Back
                    </button></a>                    
                </div>
              </div>
            </form> 
          </div>           
       </div>
    </div>
 </section>  
 @include('funds_utilization.checks.modal')
@endsection 

@section('jscript')
   <script type="text/javascript" defer>
      $(document).ready(function(){        
        @include('funds_utilization.checks.script')   
        @include('scripts.common_script')         
      });

      $( ".datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
   </script>
@endsection



