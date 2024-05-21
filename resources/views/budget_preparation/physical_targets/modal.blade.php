<!-- Main Modal -->
  <div class="modal fade" id="bp_modal" tabindex="-1" role="dialog" aria-labelledby="pap_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bp_modal_header">Add New Budget Proposal Item</h5>
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
              <select id="pap_id" name="pap_id" class="form-control bp-field select2bs4">   
                <option value="" selected hidden>Select PAP</option>
                          
              </select>
              <span class="is-invalid"><small id="pap-error" class="error"></small></span>
            </div>   
          </div>   
          <div class="form-group row">
            <label for="activity_id" class="col-sm-2 col-form-label">Activity</label>
            <div class="col-sm-10"> 
              <select id="activity_id" name="activity_id" class="form-control bp-field select2bs4">   
                <option value="" selected hidden>Select Activity</option>                        
              </select>
              <span class="is-invalid"><small id="activity-error" class="error"></small></span>
            </div>   
          </div>   
          @if($user_division_id==9 || $user_division_id==10 || $user_division_id==12 || $user_division_id==21 || $user_division_id==16 || $user_division_id==7 || $user_division_id==13)
            <div class="form-group row">
              <label for="subactivity_id" class="col-sm-2 col-form-label">Subactivity</label>
              <div class="col-sm-10">
                <select id="subactivity_id" name="subactivity_id" class="form-control bp-field select2bs4">   
                  <option value="" selected hidden>Select Subactivity</option>
                </select>
              </div> 
            </div> 
          @endif
          <div class="form-group row">
            <label for="expense_account_id" class="col-sm-2 col-form-label">Expense Account</label>
            <div class="col-sm-10">
              <select id="expense_account_id" name="expense_account_id" class="form-control bp-field select2bs4">   
                <option value="" selected hidden>Select Expense Account</option>                        
              </select>
              <span class="is-invalid"><small id="expense-error" class="error"></small></span>
            </div> 
          </div> 
          <div class="form-group row">
            <label for="object_expenditure_id" class="col-sm-2 col-form-label">Object Expenditure</label>
            <div class="col-sm-10">
              <select id="object_expenditure_id" name="object_expenditure_id" class="form-control bp-field select2bs4">   
                <option value="" selected hidden>Select Object Expenditure</option>                        
              </select>
              <span class="is-invalid"><small id="expenditure-error" class="error"></small></span>
            </div>        
          </div>        
          <div class="form-group row">
            <label for="object_specific_id" class="col-sm-2 col-form-label">Object Specific</label>
            <div class="col-sm-10">
              <select id="object_specific_id" name="object_specific_id" class="form-control bp-field select2bs4">   
                <option value="" selected hidden>Select Object Specific</option>                          
              </select>
            </div> 
          </div> 
          <div class="form-group row">
            <label for="pooled_at_division_id" class="col-sm-2 col-form-label">Pooled at</label>
            <div class="col-sm-10">
              <select id="pooled_at_division_id" name="pooled_at_division_id" class="form-control bp-field select2bs4">   
                <option value="" selected hidden>Select Division</option>
                @foreach ($divisions as $row)
                  <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->division_acronym }}</option>
                @endforeach                           
              </select>
            </div> 
          </div> 
          <div class="row">   
            <div class="form-group col">                
              <label for="fy1_amount">Fiscal Year 1 Amount</label>
              <input type="number" id="fy1_amount" class="form-control bp-field">
              <span class="is-invalid"><small id="fy1-error" class="error"></small></span>              
            </div>   
            <div class="form-group col">                
              <label for="fy2_amount">Fiscal Year 2 Amount</label>
              <input type="number" id="fy2_amount" class="form-control bp-field">
              <span class="is-invalid"><small id="fy2-error" class="error"></small></span>              
            </div> 
            <div class="form-group col">                
              <label for="fy3_amount">Fiscal Year 3 Amount</label>
              <input type="number" id="fy3_amount" class="form-control bp-field">
              <span class="is-invalid"><small id="fy3-error" class="error"></small></span>              
            </div>                            
          </div> 
        </div>   
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary save-buttons d-none add_budget_proposal">Save</button>
          <button type="button" class="btn btn-primary save-buttons d-none edit_budget_proposal" value="update">Save changes</button>         
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
        <form id="save_comment_form"> 
          @csrf  
          <div class="modal-body">                              
            <div class="form-group" >               
              <input type="hidden" id="budget_proposal_id" name="budget_proposal_id"> 
              <input type="hidden" id="comment_by_user_role_id"
                @if($user_role_id==6 || $user_role_id==11) value="6" 
                @elseif($user_role_id==3) value="3" @endif>   
              <input type="hidden" id="comment_by" name="comment_by"
                @if($user_role_id==6 || $user_role_id==11) value="Division Director" 
                @elseif($user_role_id==3) value="FAD-Budget" @endif>               
              @if($user_role_id==6) By Division Director   
              @elseif($user_role_id==11) By Section Head
              @endif 
              <button data-toggle="tooltip" data-placement="auto" title="Add Comment"
              @if ($user_role_id==6 || $user_role_id==11) class="add-row-director btn-sm"
              @else class="d-none" @endif><i class="fa-solid fa-plus"></i></button> 
              <table class="director_comments_table text-center" width="100%">
                <thead>
                  <th>Comment</th>
                  <th></th>
                </thead>
                <tbody class="director_comments_tbody">
                  <tr>
                    <td><span class="is-invalid"><small id="comment-director-error" class="error"></small></span></td>
                  </tr>                                    
                </tbody>                               
              </table>  
              <hr>
              By FAD-Budget  <button data-toggle="tooltip" data-placement="auto" title="Add Comment"
              @if ($user_role_id==3) class="add-row-budget btn-sm" 
              @else class="d-none" @endif><i class="fa-solid fa-plus"></i></button>
              <table class="fad_budget_comments_table text-center" width="100%">
                <thead>
                  <th>Comment</th>
                  <th></th>
                </thead>
                <tbody class="fad_budget_comments_tbody">
                  <tr>
                    <td><span class="is-invalid"><small id="comment-budget-error" class="error"></small></span></td>
                  </tr>
                </tbody>
              </table>
            </div>      
          </div>      
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
            <button type="button" value="update"
            @if(($user_role_id==6 || $user_role_id==11) || $user_role_id==3) class="update btn btn-primary save-buttons save_comment"
            @else class="d-none"  @endif>Save</button>
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
          <h5 class="modal-title" id="forward_comment_modal_header">Forward Comments</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">                  
          <div class="form-group">              
            <input type="hidden" id="forward_comment_id" >  
            <input type="hidden" id="forward_comment_division_id">
            <input type="hidden" id="forward_comment_year">    
            <input type="hidden" id="forward_comment_division_id_from" value="{{ $user_division_id }}">                        
            @if($user_role_id==6 || $user_role_id==11) 
              <h4>Are you sure you want to forward the comment/s to your division budget controller?</h4>              
              <input type="hidden" id="forward_comment_status_id" value="4">
              <input type="hidden" id="forward_comment_user_role_id_to" value="7">
              <input type="hidden" id="forward_comment_division_id_to" value="{{ $user_division_id }}">
              <input type="hidden" id="forward_comment_notif_message" value="Division director forwarded comment/s for your revision">             
            @elseif($user_role_id==3) 
              <h4>Are you sure you want to forward the comment/s to <span id="forward_comment_division_acronym"></span>'s budget controller?</h4>              
              <input type="hidden" id="forward_comment_status_id" value="4">
              <input type="hidden" id="forward_comment_user_role_id_to" value="7">
              <input type="hidden" id="forward_comment_division_id_to">
              <input type="hidden" id="forward_comment_notif_message" value="FAD-Budget forwarded comment/s for your revision">             
            @endif
            Note: You cannot add, edit, or delete after this action.
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
