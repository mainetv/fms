<!-- Modal -->
<div class="modal fade" id="bp_form8_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="bp_form8_modal_header"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <input type="hidden" id="bp_form8_year" name="bp_form8_year" readonly>
				<input type="hidden" id="bp_form8_fiscal_year" name="bp_form8_fiscal_year" readonly>
				<input type="hidden" id="bp_form8_division_id" name="bp_form8_division_id" value="{{ $user_division_id }}" readonly> 
            <div class="form-group">
               <label for="name">Name</label>
               <input type="text" id="bp_form8_name" name="name" class="bp-form8-field form-control bp-forms-field">
               <span class="text-danger"><small id="bp-form8-name-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="proposed_date">Proposed Date</label>
               <input type="text" id="bp_form8_proposed_date" name="proposed_date" class="bp-form8-field form-control bp-forms-field">
               <span class="text-danger"><small id="bp-form8-proposed-date-error" class="error"></small></span>
            </div>
            {{-- <div class="form-group">
               <label>Proposed Date</label>
               <input id="bp_form8_proposed_date1" name="proposed_date" type="date" class="date bp-form8-field form-control bp-forms-field"/>
               <span class="text-danger"><small id="bp-form8-propoased-date-error" class="error"></small></span>
            </div> --}}
            <div class="form-group">
               <label for="destination">Destination</label>
               <input type="text" id="bp_form8_destination" name="destination" class="bp-form8-field form-control bp-forms-field">
               <span class="text-danger"><small id="bp-form8-destination-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="amount">Amount</label>
               <input type="number" id="bp_form8_amount" name="amount" class="bp-form8-field form-control bp-forms-field">
               <span class="text-danger"><small id="bp-form8-amount-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="justification">Purpose of Travel</label>
               <textarea type="text" id="bp_form8_purpose_travel" name="purpose_travel" class="bp-form8-field form-control bp-forms-field"></textarea>
               <span class="text-danger"><small id="bp-form8-purpose-travel-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="remarks">Remarks</label>
               <textarea type="text" id="bp_form8_remarks" name="remarks" class="bp-form8-field form-control bp-forms-field"></textarea>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary save-buttons d-none add_bp_form8">Save</button>
            <button type="button" class="update btn btn-primary save-buttons d-none edit_bp_form8" value="update">Save changes</button>
         </div>
      </div>
   </div>
</div>