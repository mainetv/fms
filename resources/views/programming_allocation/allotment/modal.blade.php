<!-- Main Modal -->
  <div class="modal fade" id="allotment_modal" role="dialog" aria-labelledby="allotment_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="allotment_modal_header">Add Allotment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>      
        <div class="modal-body">  
          <input type="hidden" id="division_id" name="division_id">
          <input type="hidden" id="year" name="year">
          <input type="hidden" id="rs_type_id" name="rs_type_id">
          <input type="hidden" id="id" name="id">   
          <div class="form-group row">            
            <label for="allotment_fund_id" class="col-sm-2 col-form-label">Fund</label>
            <div class="col-sm-10">
              <select id="allotment_fund_id" name="allotment_fund_id" class="form-control allotment-field select2bs4">   
                <option value="" selected hidden>Select Allotment Fund</option>
                @foreach ($getAllotmentFund as $row)
                  <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->fund_code }}: {{ $row->description }}</option>
                @endforeach                           
              </select>
              <span class="is-invalid"><small id="fund-error" class="error"></small></span>
            </div>   
          </div>            
          <div class="form-group row">            
            <label for="pap_id" class="col-sm-2 col-form-label">PAP</label>
            <div class="col-sm-10">
              <select id="pap_id" name="pap_id" class="form-control allotment-field select2bs4">   
                <option value="" selected hidden>Select PAP</option>
                @foreach ($getLibraryPAP as $row)
                  <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->pap_code }} - {{ $row->pap }}</option>
                @endforeach                           
              </select>
              <span class="is-invalid"><small id="pap-error" class="error"></small></span>
            </div>   
          </div>   
          <div class="form-group row">
            <label for="activity_id" class="col-sm-2 col-form-label">Activity</label>
            <div class="col-sm-10"> 
              <select id="activity_id" name="activity_id" class="form-control allotment-field select2bs4">   
                <option value="" selected hidden>Select Activity</option>
                @foreach ($getLibraryActivities as $row)
                  <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->activity }}</option>
                @endforeach                           
              </select>
              <span class="is-invalid"><small id="activity-error" class="error"></small></span>
            </div>   
          </div>   
          @if($user_division_id==9 || $user_division_id==10 || $user_division_id==12 || $user_division_id==21 || $user_division_id==16 || $user_division_id==7 || $user_division_id==13 || $user_division_id==20)
            <div class="form-group row">
              <label for="subactivity_id" class="col-sm-2 col-form-label">Subactivity</label>
              <div class="col-sm-10">
                <select id="subactivity_id" name="subactivity_id" class="form-control allotment-field select2bs4">   
                  <option value="" selected hidden>Select Subactivity</option>
                </select>
              </div> 
            </div> 
          @endif
          <div class="form-group row">
            <label for="expense_account_id" class="col-sm-2 col-form-label">Expense Account</label>
            <div class="col-sm-10">
              <select id="expense_account_id" name="expense_account_id" class="form-control allotment-field select2bs4">   
                <option value="" selected hidden>Select Expense Account</option>
                @foreach ($getLibraryExpenseAccounts as $row)
                  <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->expense_account }}</option>
                @endforeach                           
              </select>
              <span class="is-invalid"><small id="expense-error" class="error"></small></span>
            </div> 
          </div> 
          <div class="form-group row">
            <label for="object_expenditure_id" class="col-sm-2 col-form-label">Object Expenditure</label>
            <div class="col-sm-10">
              <select id="object_expenditure_id" name="object_expenditure_id" class="form-control allotment-field select2bs4">   
                <option value="" selected hidden>Select Object Expenditure</option>                          
              </select>
              <span class="is-invalid"><small id="expenditure-error" class="error"></small></span>
            </div>        
          </div>        
          <div class="form-group row">
            <label for="object_specific_id" class="col-sm-2 col-form-label">Object Specific</label>
            <div class="col-sm-10">
              <select id="object_specific_id" name="object_specific_id" class="form-control allotment-field select2bs4">   
                <option value="" selected hidden>Select Object Specific</option>                          
              </select>
            </div> 
          </div> 
          <div class="form-group row">
            <label for="pooled_at_division_id" class="col-sm-2 col-form-label">Pooled at</label>
            <div class="col-sm-10">
              <select id="pooled_at_division_id" name="pooled_at_division_id" class="form-control allotment-field select2bs4">   
                <option value="" selected hidden>Select Division</option>
                @foreach ($divisions as $row)
                  <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->division_acronym }}</option>
                @endforeach                           
              </select>
            </div> 
          </div> 
          <div class="row text-center">
            <div class="form-group col">                
              <label for="allotment" >ALLOTMENT</label>           
            </div> 
            <div class="form-group col">                
              <label for="obligation">OBLIGATION</label>           
            </div>
          </div>
          <div class="row"> 
            <div><label for="q1">Q1</label> </div>
            <div class="form-group col">                
              <input type="number" id="q1_allotment" class="form-control allotment-field">
              <span class="is-invalid"><small id="q1-allot-error" class="error"></small></span>              
            </div>   
            <div class="form-group col">                
              <input type="number" id="q1_obligation" class="form-control allotment-field" readonly>
              <span class="is-invalid"><small id="q1-adj-error" class="error"></small></span>              
            </div>                                       
          </div> 
          <div class="row"> 
            <div><label for="q2">Q2</label> </div>
            <div class="form-group col">                
              <input type="number" id="q2_allotment" class="form-control allotment-field">
              <span class="is-invalid"><small id="q2-allot-error" class="error"></small></span>              
            </div>   
            <div class="form-group col">                
              <input type="number" id="q2_obligation" class="form-control allotment-field" readonly>
              <span class="is-invalid"><small id="q2-adj-error" class="error"></small></span>              
            </div>                                       
          </div>
          <div class="row"> 
            <div><label for="q3">Q3</label> </div>
            <div class="form-group col">                
              <input type="number" id="q3_allotment" class="form-control allotment-field">
              <span class="is-invalid"><small id="q3-allot-error" class="error"></small></span>              
            </div>   
            <div class="form-group col">                
              <input type="number" id="q3_obligation" class="form-control allotment-field" readonly>
              <span class="is-invalid"><small id="q3-adj-error" class="error"></small></span>              
            </div>                                       
          </div>
          <div class="row"> 
            <div><label for="q4">Q4</label> </div>
            <div class="form-group col">                
              <input type="number" id="q4_allotment" class="form-control allotment-field">
              <span class="is-invalid"><small id="q4-allot-error" class="error"></small></span>              
            </div>   
            <div class="form-group col">                
              <input type="number" id="q4_obligation" class="form-control allotment-field" readonly>
              <span class="is-invalid"><small id="q4-adj-error" class="error"></small></span>              
            </div>                                       
          </div>
          {{-- <div class="row"> 
            <div><label for="q4">TOTAL</label> </div>
            <div class="form-group col">                
              <input type="number" id="total_allotment" class="form-control allotment-field" readonly>     
            </div>   
            <div class="form-group col">                
              <input type="number" id="total_obligation" class="form-control allotment-field" readonly>          
            </div>                                       
          </div> --}}
        </div> 
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary save-buttons d-none add_allotment">Save</button>
          <button type="button" class="btn btn-primary save-buttons d-none edit_allotment" value="update">Save changes</button>         
        </div>
      </div>
    </div>
  </div>
<!-- END Main Modal -->

<!-- Adjustment Modal -->
  <div class="modal fade" id="adjustment_modal" tabindex="-1" role="dialog" aria-labelledby="pap_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="adjustment_modal_header">Allotment Adjustment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>  
        <div class="modal-body">  
          <div>
            <input id="pap_to_adjust" size="100%" style="background-color:white; border:none;" readonly><br>
            <input id="exp_to_adjust" size="100%" style="background-color:white; border:none;" readonly>
          </div>   
          <input type="text" id="allotment_id" name="allotment_id" hidden>        
          <div class="table-responsive">
            <table id="allotment_adjustment_table" class="table table-bordered text-center" style="width: 100%;">
              <thead>
                <tr>
                  <th rowspan="2">Annual Allotment</th>
                  <th rowspan="2">Annual Adjustment</th>
                  <th rowspan="2">Annual Total</th>
                  <th colspan="3">Q1</th>
                  <th colspan="3">Q2</th>
                  <th colspan="3">Q3</th>
                  <th colspan="3">Q4</th>
                </tr>
                <tr>
                  <th>Allt</th>
                  <th>Adj</th>
                  <th>Total</th>
                  <th>Allt</th>
                  <th>Adj</th>
                  <th>Total</th>
                  <th>Allt</th>
                  <th>Adj</th>
                  <th>Total</th>
                  <th>Allt</th>
                  <th>Adj</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <br>
          <button type="button" class="btn_add_adjustment btn btn-outline-primary add-buttons">
            <span class="btn-label"> <i class="nav-icon fas fa-plus"></i></span>Add Adjustment
          </button>
          <div class="table-responsive">
            <table id="adjustment_table" class="table table-bordered text-center" style="width: 100%;">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Adjustment Type</th>
                  <th>Ref No.</th>
                  <th>Q1</th>
                  <th>Q2</th>
                  <th>Q3</th>
                  <th>Q4</th>
                  <th>Action</th>
                </tr>                    
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>       
          <br>
          <button type="button" class="hide_adjustment_container close d-none" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="collapse" id="adjustment_container">   
            <input type="text" id="adjustment_id" name="adjustment_id" hidden>      
            <div class="form-group row">    
              <label class="col-sm-1 col-form-label">Date</label>
              <div>   
                <input id="adjustment_date" type="date" id="adjustment_date" class="date adjustment-field form-control bp-forms-field"/>
                <span class="text-danger"><small id="date-error" class="error"></small></span>
              </div>        
              <div class="col-1"></div>
              <label class="col-form-label">Fund</label>   
              <div class="col-sm-3">          
                <select id="adjustment_type_id" name="adjustment_type_id" class="form-control adjustment-field">   
                  <option value="" selected hidden>Select Adjustment Type</option>
                  @foreach ($getAdjustmentTypes as $row)
                    <option value="{{ $row->id }}" data-id="{{ $row->id }}">{{ $row->adjustment_type }}</option>
                  @endforeach                           
                </select>
                <span class="text-danger"><small id="adjustment-type-error" class="error"></small></span>
              </div>  
              <div class="col-1"></div>
              <label for="allotment_fund_id" class="col-form-label">Ref No.</label>
              <div class="col-sm-3">    
                <input type="text" id="reference_no"  class="form-control adjustment-field">        
                <span class="is-invalid"><small id="fund-error" class="error"></small></span>
              </div> 
            </div>           
            <div class="form-group row">            
              <label for="allotment_fund_id" class="col-sm-2 col-form-label">1st Quarter</label>
              <div class="col-sm-3">    
                <input type="text" id="q1_adjustment"  class="form-control adjustment-field">        
                <span class="is-invalid"><small id="fund-error" class="error"></small></span>
              </div>  
              <div class="col-2"></div>            
              <label for="allotment_fund_id" class="col-form-label">2nd Quarter</label>
              <div class="col-sm-3">    
                <input type="text" id="q2_adjustment"  class="form-control adjustment-field">        
                <span class="is-invalid"><small id="fund-error" class="error"></small></span>
              </div>   
            </div>           
            <div class="form-group row">            
              <label for="allotment_fund_id" class="col-sm-2 col-form-label">3rd Quarter</label>
              <div class="col-sm-3">    
                <input type="text" id="q3_adjustment"  class="form-control adjustment-field">        
                <span class="is-invalid"><small id="fund-error" class="error"></small></span>
              </div>           
              <div class="col-2"></div>        
              <label for="allotment_fund_id" class="col-form-label">4th Quarter</label>
              <div class="col-sm-3">    
                <input type="text" id="q4_adjustment"  class="form-control adjustment-field">        
                <span class="is-invalid"><small id="fund-error" class="error"></small></span>
              </div>   
            </div> 
            <div class="form-group row">            
              <label for="allotment_fund_id" class="col-sm-2 col-form-label">Remarks</label>
              <div class="col-sm-10">    
                <textarea id="remarks" class="form-control adjustment-field"></textarea>    
                <span class="is-invalid"><small id="fund-error" class="error"></small></span>
              </div>   
            </div> 
          </div> 
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary save-buttons d-none add_adjustment">Save</button>
            <button type="button" class="btn btn-primary save-buttons d-none edit_adjustment" value="update">Save changes</button>      
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- END Adjustment Modal -->

{{-- Forward--}}
  <div class="modal fade" id="forward_modal" tabindex="-1" role="dialog" aria-labelledby="forward_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="forward_modal_header">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">                  
          <div class="form-group">   
            <input type="hidden" id="forward_user_role_id_from" value="{{ $user_role_id }}">            
            <input type="hidden" id="forward_year" value="{{ $year_selected }}">       
            <input type="hidden" id="forward_status_id" value="56">
            <input type="hidden" id="forward_notif_msg" value="Call for preparation of monthly cash program for the fiscal year @if($year_selected!='all'){{ $year_selected+1 }}@endif.">             
            <h4><span id="forward_alert_msg">Are you sure you want to forward {{ $year_selected }} activities/object to monthly cash program (NEP) FY @if($year_selected!='all'){{ $year_selected+1 }}@endif?</span></h4>   
            Note: You cannot reverse this action.
          </div>                   
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary forward">Forward</button>          
        </div>
      </div>
    </div>
  </div>
{{-- END Forward--}}
