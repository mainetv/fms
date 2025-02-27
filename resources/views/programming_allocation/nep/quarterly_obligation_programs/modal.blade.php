<!-- Main Modal -->
  <div class="modal fade" id="qop_modal" role="dialog" aria-labelledby="pap_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="qop_modal_header">Add New Quarterly Obligation Program Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">     
          <div class="form-group row">
            <input type="hidden" id="division_id" name="division_id">
            <input type="hidden" id="year" name="year">
            <input type="hidden" id="id" name="id">
            <label for="pap_id" class="col-sm-2 col-form-label">PAP</label>
            <div class="col-sm-10">
              <select id="pap_id" name="pap_id" class="form-control qop-field select2bs4">   
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
              <select id="activity_id" name="activity_id" class="form-control qop-field select2bs4">   
                <option value="" selected hidden>Select Activity</option>
                @foreach ($getLibraryActivities as $row)
                  <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->activity }}</option>
                @endforeach                           
              </select>
              <span class="is-invalid"><small id="activity-error" class="error"></small></span>
            </div>   
          </div>   
          {{-- @if($user_division_id==9 || $user_division_id==10 || $user_division_id==12 || $user_division_id==21 || $user_division_id==16 || $user_division_id==7 || $user_division_id==13) --}}
          <div class="form-group row">
            <label for="subactivity_id" class="col-sm-2 col-form-label">Subactivity</label>
            <div class="col-sm-10">
              <select id="subactivity_id" name="subactivity_id" class="form-control qop-field select2bs4">   
                <option value="" selected hidden>Select Subactivity</option>
              </select>
            </div> 
          </div> 
          {{-- @endif --}}
          <div class="form-group row">
            <label for="expense_account_id" class="col-sm-2 col-form-label">Expense Account</label>
            <div class="col-sm-10">
              <select id="expense_account_id" name="expense_account_id" class="form-control qop-field select2bs4">   
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
              <select id="object_expenditure_id" name="object_expenditure_id" class="form-control qop-field select2bs4">   
                <option value="" selected hidden>Select Object Expenditure</option>
                @foreach ($getLibraryObjectExpenditures as $row)
                  <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->object_expenditure }}</option>
                @endforeach                           
              </select>
              <span class="is-invalid"><small id="expenditure-error" class="error"></small></span>
            </div>        
          </div>        
          <div class="form-group row">
            <label for="object_specific_id" class="col-sm-2 col-form-label">Object Specific</label>
            <div class="col-sm-10">
              <select id="object_specific_id" name="object_specific_id" class="form-control qop-field select2bs4">   
                <option value="" selected hidden>Select Object Specific</option>                          
              </select>
            </div> 
          </div> 


          <div class="row">   
            <div class="form-group col">                
              <label for="q1_amount">Q1</label>
              <input type="text" id="q1_amount" class="amount form-control qop-field">
              <span class="is-invalid"><small id="q1-error" class="error"></small></span>              
            </div>   
            <div class="form-group col">                
              <label for="q2_amount">Q2</label>
              <input type="text" id="q2_amount" class="amount form-control qop-field">
              <span class="is-invalid"><small id="q2-error" class="error"></small></span>              
            </div>                                       
          </div>  
          <div class="row">   
            <div class="form-group col">                
              <label for="q3_amount">Q3</label>
              <input type="text" id="q3_amount" class="amount form-control qop-field">
              <span class="is-invalid"><small id="q3-error" class="error"></small></span>              
            </div>   
            <div class="form-group col">                
              <label for="q4_amount">Q4</label>
              <input type="text" id="q4_amount" class="amount form-control qop-field">
              <span class="is-invalid"><small id="q4-error" class="error"></small></span>              
            </div>                                       
          </div>
          
          
        </div>   
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary save-buttons d-none save_qop">Save</button>
          <button type="button" class="btn btn-primary save-buttons d-none update_qop" value="update">Save changes</button>         
        </div>
      </div>
    </div>
  </div>
<!-- END Main Modal -->

{{-- Comments --}}
  <div class="modal fade" id="comment_modal" tabindex="-1" role="dialog" aria-labelledby="comment_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="comment_modal_header">Comment/s</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form-group">
          Legend: 
          <input type="text" size="2" class="btn-xs" style="background:#85cd85" disabled> = Resolved
          <input type="text" size="2" class="btn-xs" style="background:#e49c9c" disabled> = To Resolve
        </div>
        <form id="comment_form"> 
          @csrf  
          <div class="modal-body">                              
            <div class="form-group" > 
              <input type="hidden" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}">              
              <input type="hidden" id="comment_division_id" name="comment_division_id"> 
              <input type="hidden" id="comment_year" name="comment_year"> 
              <input type="hidden" id="qop_id" name="qop_id"> 
              <input type="hidden" id="comment_active_status_id" name="comment_active_status_id"> 
                By Division Director/Section Head 
              <table class="director_comments_table text-center table-borderless" width="100%">
                <thead>
                  <th>Comment</th>
                  <th></th>
                </thead>
                <tbody class="director_comments_tbody">
                  <tr>
                    <td><span class="is-invalid"><small id="director-comment-error" class="error"></small></span></td>
                  </tr>                                    
                </tbody>                                                
              </table>  
              <button data-toggle="tooltip" data-placement="auto" title="Add Comment"
                  @if ($user_role_id==6 || $user_role_id==11) class="add-row-director"
                  @else class="d-none" 
                  @endif><i class="fa-solid fa-plus"></i></button>              
              <hr>
              By Budget Officer
              <table class="budget_officer_comments_table text-center table-borderless" width="100%">
                <thead>
                  <th>Comment</th>
                  <th></th>
                </thead>
                <tbody class="budget_officer_comments_tbody">
                  <tr>
                    <td><span class="is-invalid"><small id="budget-comment-error" class="error"></small></span></td>
                  </tr>
                </tbody>
              </table>
              <button data-toggle="tooltip" data-placement="auto" title="Add Comment"
                  @if ($user_role_id==3) class="add-row-budget"
                  @else class="d-none" 
                  @endif><i class="fa-solid fa-plus"></i></button>              
              <hr>
              By BPAC               
              <table class="bpac_comments_table text-center table-borderless" width="100%">
                <thead>
                  <th>Comment</th>
                  <th></th>
                </thead>
                <tbody class="bpac_comments_tbody">
                  <tr>
                    <td><span class="is-invalid"><small id="bpac-comment-error" class="error"></small></span></td>
                  </tr>
                </tbody>
              </table>
              <button data-toggle="tooltip" data-placement="auto" title="Add Comment"
                  @if ($user_role_id==9) class="add-row-bpac"
                  @else class="d-none" 
                  @endif><i class="fa-solid fa-plus"></i></button>  
            </div>      
          </div>      
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
            <button type="button" value="update" class="update btn btn-primary save-buttons save_comment d-none">Save</button>
          </div>
        <form>         
      </div>
    </div>
  </div>
{{-- END Comments--}}

{{-- Forward Comment--}}
  <div class="modal fade" id="forward_comment_modal" tabindex="-1" role="dialog" aria-labelledby="forward_comment_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="forward_comment_modal_header">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">                  
          <div class="form-group">     
            <input type="hidden" id="forward_comment_user_role_id_from" value="{{ $user_role_id }}">         
            <input type="hidden" id="forward_comment_division_id">
            <input type="hidden" id="forward_comment_year">      
            <input type="hidden" id="forward_comment_status_id">
            <input type="hidden" id="forward_comment_notif_msg">   
            <h4><span id="forward_comment_alert_msg"></span></h4>
            Note: You cannot reverse this action.
          </div>                   
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary forward_comment">Forward</button>          
        </div>
      </div>
    </div>
  </div>
{{-- END Forward Comment--}}

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
            <input type="hidden" id="forward_year">  
            <input type="hidden" id="forward_division_id">          
            <input type="hidden" id="forward_status_id">
            <input type="hidden" id="forward_notif_msg">             
            <h4><span id="forward_alert_msg"></span></h4>    
            Note: You cannot reverse this action.
          </div>                   
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary forward_qop">Forward</button>          
        </div>
      </div>
    </div>
  </div>
{{-- END Forward--}}

{{-- Receive--}}
  <div class="modal fade" id="receive_modal" tabindex="-1" role="dialog" aria-labelledby="receive_label" aria-hidden="true">  
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="receive_modal_header">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">                  
          <div class="form-group">   
            <input type="hidden" id="receive_user_role_id_from" value="{{ $user_role_id }}">
            <input type="hidden" id="receive_division_id">     
            <input type="hidden" id="receive_year">     
            <input type="hidden" id="receive_status_id">
            <input type="hidden" id="receive_notif_msg">
            <h4><span id="receive_alert_msg"></span></h4> 
          </div>                   
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary receive_qop">Receive</button>          
        </div>
      </div>
    </div>
  </div>
{{-- END Receive--}}

{{-- Reverse--}}
  <div class="modal fade" id="reverse_modal" tabindex="-1" role="dialog" aria-labelledby="reverse_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reverse_modal_header">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">                  
          <div class="form-group">   
            <input type="hidden" id="reverse_user_role_id_from" value="{{ $user_role_id }}">
            <input type="hidden" id="reverse_division_id">             
            <input type="hidden" id="reverse_year">       
            <input type="hidden" id="reverse_status_id">
            <input type="hidden" id="reverse_notif_msg">             
            <h4><span id="reverse_alert_msg"></span></h4>    
            Note: You cannot reverse this action.
          </div>                   
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary reverse_qop">Reverse</button>          
        </div>
      </div>
    </div>
  </div>
{{-- END Reverse--}}

