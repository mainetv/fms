<!-- Modal -->
<div class="modal fade" id="bp_form4_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="bp_form4_modal_header"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <input type="hidden" id="bp_form4_year" name="bp_form4_year" readonly>
				<input type="hidden" id="bp_form4_fiscal_year" name="bp_form4_fiscal_year" readonly>
				<input type="hidden" id="bp_form4_division_id" name="bp_form4_division_id" value="{{ $user_division_id }}" readonly>  
            <div class="form-group">
               <label for="description">Tier</label>
               <select name="tier" id="bp_form4_tier">
                  <option value="1">1</option>
                  <option value="2">2</option>
               </select>
               <span class="text-danger"><small id="bp-form4-tier-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="description">Description</label>
               <textarea type="text" id="bp_form4_description" name="description" class="bp-form4-field form-control bp-forms-field"></textarea>
               <span class="text-danger"><small id="bp-form4-description-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="amount">Amount Needed</label>
               <input type="number" id="bp_form4_amount" name="amount" class="bp-form4-field form-control bp-forms-field">
               <span class="text-danger"><small id="bp-form4-amount-error" class="error"></small></span>
            </div>
            <div class="row"> 
               <div class="form-group col">
                  <label for="num_years_completion">No. of Years of Completion</label>
                  <input type="number" id="bp_form4_num_years_completion" name="num_years_completion" class="bp-form4-field form-control bp-forms-field">
                  <span class="text-danger"><small id="bp-form4-num-years-completion-error" class="error"></small></span>
               </div>
               <div class="form-group col">
                  <label>Date Started</label>
                  <input id="bp_form4_date_started" type="date" class="date bp-form4-field form-control bp-forms-field"/>
                  <span class="text-danger"><small id="bp-form4-date-started-error" class="error"></small></span>
               </div>
            </div>           
            <div class="form-group">
               <label for="total_cost">Total Cost</label>
               <input type="number" id="bp_form4_total_cost" name="total_cost" class="bp-form4-field form-control bp-forms-field">
               <span class="text-danger"><small id="bp-form4-total-cost-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="justification">Justification</label>
               <textarea type="text" id="bp_form4_justification" name="justification" class="bp-form4-field form-control bp-forms-field"></textarea>
               <span class="text-danger"><small id="bp-form4-justification-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="remarks">Remarks</label>
               <textarea type="text" id="bp_form4_remarks" name="remarks" class="bp-form4-field form-control bp-forms-field"></textarea>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary save-buttons d-none add_bp_form4">Save</button>
            <button type="button" class="update btn btn-primary save-buttons d-none edit_bp_form4" value="update">Save changes</button>
         </div>
      </div>
   </div>
</div>