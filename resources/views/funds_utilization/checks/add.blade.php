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
              <div class="col-sm-2">
                <input type="text" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}" hidden>               
                <div class="form-group row">
                  <label for="activity_id" class="col-sm-3 col-form-label">Check Date</label>
                  <div class="col"> 
                    <input type="text" id="check_date" name="check_date" value="{{ date('Y-m-d') }}" class="date form-control ada-field">
                    <span class="is-invalid"><small id="date-error" class="error"></small></span>
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
                        <button type="button"
                          data-toggle="tooltip" data-placement='auto' title='Add DV' class="btn-xs btn_add_check_attach_dv btn btn-outline-primary add-buttons">
                        <i class="nav-icon fas fa-plus"></i></button>
                      </th>         
                    </thead>   
                  </table>
                </div>  
              </div>
            </div>
            <div class="form-group row">  
              <div class="col-sm-4"> 
                <div class="row">
                  <div class="col-10">
                    <a style="font-color:white;" href="{{ url('funds_utilization/checks/all/'.date('m').'/'.date('Y')) }}">
                      <button type="button" class="btn btn-secondary">Back</button></a>
                  </div>
                </div>
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
    
    $('#check_date').datepicker({
      todayHighlight: true,
      changeMonth: true,
      changeYear: true,
			dateFormat: 'yy-mm-dd',
      inline: true,
      onSelect: function(date_selected) {
				console.log("Selected date: " + date_selected + "; input's current value: " + this.value);	
				window.history.pushState('', '',date_selected);
        var date = $(this).datepicker('getDate'),
        day  = date.getDate(),  
        month = date.getMonth() + 1,              
        year =  date.getFullYear();        
			}	
    });
  </script>
@endsection




