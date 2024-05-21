<!-- Modal -->
{{-- PAP --}}
  <div class="modal fade" id="pap_modal" tabindex="-1" role="dialog" aria-labelledby="pap_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pap_modal_header">Add PAP</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">
          <div class="row">         
            <div class="form-group col">
              {{-- <input type="text" id="budget_proposal_id" name="budget_proposal_id"> --}}
              {{-- <input type="text" id="division_id" name="division_id" value="{{ $value->division_acronym }}"> --}}
              <label for="bp_pap_id">PAP</label>
              <select id="bp_pap_id" name="bp_pap_id" class="pap-field form-control budget-proposal-field select2">   
                <option value="" selected hidden>Select PAP</option>
                @foreach ($getLibraryPAP as $row)
                  <option value="{{ $row->pap_code }}" data-id="{{ $row->pap_code }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->pap_code }} - {{ $row->description }}</option>
                @endforeach                           
              </select>
              <span class="is-invalid"><small id="pap-code-error" class="error"></small></span>
            </div>                              
          </div>   
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="add_pap" type="button" class="btn btn-primary save-buttons d-none">Save</button>
          <button id="update_pap" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
        </div>
      </div>
    </div>
  </div>
{{-- END PAP --}}

{{-- Activity --}}
  <div class="modal fade" id="activity_modal" tabindex="-1" role="dialog" aria-labelledby="activity_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="activity_modal_header">Add Activity</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">        
          <div class="form-group">   
            <input type="text" id="bp_pap_id" name="bp_pap_id">       
            <label for="bp_activity_id">Activity</label>
            <select id="bp_activity_id" name="activity_id" class="activity-field form-control budget-proposal-field select2">   
              <option value="" selected hidden>Select Activity</option>
              @foreach ($getLibraryActivities as $row)
                <option value="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->activity }}</option>
              @endforeach                           
            </select>
            <span class="is-invalid"><small id="activity-id-error" class="error"></small></span>
          </div>         
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="add_activity" type="button" class="btn btn-primary save-buttons d-none">Save</button>
          <button id="update_activity" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
        </div>
      </div>
    </div>
  </div>
{{-- END Activity --}}

{{-- Subactivity --}}
  <div class="modal fade" id="subactivity_modal" tabindex="-1" role="dialog" aria-labelledby="subactivity_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="subactivity_modal_header">Add Subactivity</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">
          <div class="row">         
            <div class="form-group">   
              <input type="text" id="budget_proposal_activity_id_forsubact" name="budget_proposal_activity_id_forsubact">       
              <label for="budget_proposal_subactivity_id">Subactivity</label>
              <select id="budget_proposal_subactivity_id" name="subactivity_id" class="subactivity-field form-control budget-proposal-field select2">   
                <option value="" selected hidden>Select Subactivity</option>
                @foreach ($getLibrarySubactivities as $row)
                  <option value="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->subactivity }}</option>
                @endforeach                           
              </select>
              <span class="is-invalid"><small id="subactivity-id-error" class="error"></small></span>
            </div>                            
          </div>          
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="add_subactivity" type="button" class="btn btn-primary save-buttons d-none">Save</button>
          <button id="update_subactivity" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
        </div>
      </div>
    </div>
  </div>
{{-- END Subactivity --}}

{{-- Expenditure Activity--}}
  <div class="modal fade" id="expenditure_modal_activity" tabindex="-1" role="dialog" aria-labelledby="expenditure_label_activity" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="expenditure_modal_header_activity">Add Expenditure</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">               
          <div class="form-group">   
            <input type="text" id="budget_proposal_activity_id_activity" name="budget_proposal_activity_id_activity">     
            <label for="budget_proposal_object_expenditure_id_activity">Expenditure</label>
            <select id="budget_proposal_object_expenditure_id_activity" name="expenditure_id" class="expenditure_activity form-control budget-proposal-field select2">   
              <option value="" selected hidden>Select Expenditure</option>
              @foreach ($getLibraryObjectExpenditures as $row)
                <option value="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->expenditure }}</option>
              @endforeach                           
            </select>
            <span class="is-invalid"><small id="expenditure-id-error-activity" class="error"></small></span>              
          </div>   
          <div class="row">   
            <div class="form-group col">                
              <label for="fy1_amount_activity">Fiscal Year 1 Amount</label>
              <input type="number" id="fy1_amount_activity" class="form-control budget-proposal-field">
              <span class="is-invalid"><small id="fiscal-year1-amount-error-activity" class="error"></small></span>              
            </div>   
            <div class="form-group col">                
              <label for="fy2_amount_activity">Fiscal Year 2 Amount</label>
              <input type="number" id="fy2_amount_activity" class="form-control budget-proposal-field">
              <span class="is-invalid"><small id="fiscal-year2-amount-error-activity" class="error"></small></span>              
            </div> 
            <div class="form-group col">                
              <label for="fy3_amount_activity">Fiscal Year 3 Amount</label>
              <input type="number" id="fy3_amount_activity" class="form-control budget-proposal-field">
              <span class="is-invalid"><small id="fiscal-year3-amount-error-activity" class="error"></small></span>              
            </div>                            
          </div>          
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="add_expenditure_activity" type="button" class="btn btn-primary save-buttons d-none">Save</button>
          <button id="update_expenditure_activity" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
        </div>
      </div>
    </div>
  </div>
{{-- END Expenditure Activity--}}

{{-- Expenditure Subactivity--}}
  <div class="modal fade" id="expenditure_modal_subactivity" tabindex="-1" role="dialog" aria-labelledby="expenditure_label_subactivity" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="expenditure_modal_header_subactivity">Add Expenditure</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">                  
          <div class="form-group">   
            <input type="text" id="budget_proposal_subactivity_id_subactivity" name="budget_proposal_subactivity_id_subactivity">     
            <label for="budget_proposal_object_expenditure_id_subactivity">Expenditure</label>
            <select id="budget_proposal_object_expenditure_id_subactivity" name="expenditure_id" class="expenditure_subactivity form-control budget-proposal-field select2">   
              <option value="" selected hidden>Select Expenditure</option>
              @foreach ($getLibraryObjectExpenditures as $row)
                <option value="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->expenditure }}</option>
              @endforeach                           
            </select>
            <span class="is-invalid"><small id="expenditure-id-error-subactivity" class="error"></small></span>
          </div>   
          <div class="row">   
            <div class="form-group col">                
              <label for="fy1_amount_subactivity">Fiscal Year 1 Amount</label>
              <input type="number" id="fy1_amount_subactivity" class="form-control budget-proposal-field">
              <span class="is-invalid"><small id="fiscal-year1-amount-error-subactivity" class="error"></small></span>              
            </div>   
            <div class="form-group col">                
              <label for="fy2_amount_subactivity">Fiscal Year 2 Amount</label>
              <input type="number" id="fy2_amount_subactivity" class="form-control budget-proposal-field">
              <span class="is-invalid"><small id="fiscal-year2-amount-error-subactivity" class="error"></small></span>              
            </div> 
            <div class="form-group col">                
              <label for="fy3_amount_subactivity">Fiscal Year 3 Amount</label>
              <input type="number" id="fy3_amount_subactivity" class="form-control budget-proposal-field">
              <span class="is-invalid"><small id="fiscal-year3-amount-error-subactivity" class="error"></small></span>              
            </div>                            
          </div>              
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="add_expenditure_subactivity" type="button" class="btn btn-primary save-buttons d-none">Save</button>
          <button id="update_expenditure_subactivity" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
        </div>
      </div>
    </div>
  </div>
{{-- END Expenditure Subactivity--}}