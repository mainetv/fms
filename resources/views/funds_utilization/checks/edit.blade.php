@extends('layouts.app')

@section('content')   
  <section class="content"> 
    <?php   
      $check_month = date("m",strtotime($check_date));
      $check_year = date("Y",strtotime($check_date)); 
    ?>
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
                <div class="col-sm-2">
                  <input type="text" id="year" name="year" value="{{ $check_year }}" hidden>
                  <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>
                  <div class="form-group row">
                    <label for="activity_id" class="col-sm-3 col-form-label">Check Date</label>
                    <div class="col"> 
                      <input type="text" id="check_date" name="check_date" value="{{ $check_date }}" class="datepicker form-control check-field">
                    </div> 
                  </div> 
                </div>
                <div class="col-sm-9">
                  <div class="table-responsive">
                    <table id="attached_dv_table" class="table-xs table-bordered text-center table-hover" style="width: 100%;">    
                      <thead>
                        <th></th>
                        <th>DV ID</th>
                        <th>DV No.</th>
                        <th>Check No.</th>           
                        <th>Payee</th>              
                        <th>Amount</th>           
                        <th>Date Released</th>           
                        <th style="min-width:3%; max-width:3%;">
                          <button type="button"  data-toggle="tooltip" data-placement='auto' title='Add DV'
                            class="btn-xs btn_attach_dv btn btn-outline-primary add-buttons">
                          <i class="nav-icon fas fa-plus"></i></button>
                        </th>         
                      </thead>    
                      <tbody>
                        <?php 
                          $total_check_amount=0;
                          foreach ($getAttachedDVbyCheckDatebyBankAccount as $row) {   ?>
                          <tr class="text-left gray-bg">
                            <td colspan="4">Bank Account No.: <strong>{{ $row->bank_account_no }}</strong></td>
                            <td>Fund: <strong>{{ $row->fund }}</strong></td>
                            <td colspan="3"></td>
                            {{-- <td colspan="3">Balance: <strong></strong></td> --}}
                          </tr>
                          <?php
                            $getCheckDVByAccountbyDate=getCheckDVByAccountbyDate($row->bank_account_id, $row->check_date);
                            foreach ($getCheckDVByAccountbyDate as $row1) {   
                                ?>                            
                                <tr class="text-center">
                                  <td style="min-width:2%; max-width:2%;">
                                    <button type="button" class="btn-xs btn_edit" data-dv-check-id="{{ $row->id }}"
                                      data-toggle="modal" data-target="#check_bank_modal" data-toggle="tooltip" 
                                      data-placement='auto' title='Edit Bank Account No.'>
                                      <i class="fa-solid fa-pen-to-square fa-lg green"></i>																					
                                    </button>
                                  </td>
                                  <td style="min-width:6%; max-width:6%;">
                                    <a href="{{ url('funds_utilization/dv/edit/'.$row1->dv_id) }}" target="_blank" 
                                    data-toggle="tooltip" data-placement='auto' title='View DV'>{{ $row1->dv_id }}</td>
                                  <td style="min-width:6%; max-width:6%;">{{ $row1->dv_no }}</td>
                                  <td style="min-width:9%; max-width:9%;">
                                    <input type="text" size="12" id="check_no" name="check_no[]" value="{{ $row1->check_no }}">
                                  </td>
                                  <td  class="text-left" style="min-width:54%; max-width:54%;">{{ $row1->payee }}</td>  
                                  <td nowrap class="text-right" style="min-width:12%; max-width:12%;">{{ number_format($row1->total_dv_net_amount,2) }}</td>  
                                  <td nowrap style="min-width:8%; max-width:8%;">
                                    <input type="date" id="date_released" name="date_released[]" value="{{ $row1->date_released }}">
                                    <input type="text" id="dv_check_id" name="dv_check_id[]" value="{{ $row1->id }}" hidden>
                                  </td>  
                                  <td style="min-width:3%; max-width:3%;">
                                    <button type="button" class="btn-xs btn_remove_attached_dv btn btn-outline-danger" data-id="{{ $row1->id }}" 
                                      data-dv-id="{{ $row1->dv_id }}"  data-toggle="tooltip" data-placement='auto' title='Remove DV'>
                                      <i class="fa-solid fa-xmark"></i>
                                    </button>
                                  </td>
                                </tr>
                                <?php
                              }  
                          } ?>
                      </tbody>  
                    </table>
                  </div>  
                </div>
              </div>
              <div class="form-group row">  
                <div class="col-sm-2"> 
                    <a style="font-color:white;" href="{{ url('funds_utilization/checks/all/'.$check_month.'/'.$check_year) }}">
                      <button type="button" class="btn btn-secondary">Back
                    </button></a>                    
                </div>
                <div class="col-sm-2"> 
                  <button type="button" class="btn btn-primary save-buttons edit_check_dv">Save Changes</button>&emsp;&emsp;&emsp;&emsp; 
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



