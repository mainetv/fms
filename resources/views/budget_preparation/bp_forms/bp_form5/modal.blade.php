<!-- Modal -->
<div class="modal fade" id="bp_form5_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="bp_form5_modal_header"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <input type="hidden" id="bp_form5_year" name="bp_form5_year" readonly>
				<input type="hidden" id="bp_form5_fiscal_year" name="bp_form5_fiscal_year" readonly>
				<input type="hidden" id="bp_form5_division_id" name="bp_form5_division_id" value="{{ $user_division_id }}" readonly> 
            <div class="form-group">
               <label for="description">Tier</label>
               <select name="tier" id="bp_form5_tier">
                  <option value="1">1</option>
                  <option value="2">2</option>
               </select>
               <span class="text-danger"><small id="bp-form5-tier-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="description">Item Description</label>
               <textarea type="text" id="bp_form5_description" name="description" class="bp-form5-field form-control bp-forms-field"></textarea>
               <span class="text-danger"><small id="bp-form5-description-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="quantity">Quantity</label>
               <input type="number" id="bp_form5_quantity" name="quantity" class="bp-form5-field form-control bp-forms-field">
               <span class="text-danger"><small id="bp-form5-quantity-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="unit_cost">Unit Cost</label>
               <input type="number" id="bp_form5_unit_cost" name="unit_cost" class="bp-form5-field form-control bp-forms-field">
               <span class="text-danger"><small id="bp-form5-unit-cost-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="total_cost">Total Cost</label>
               <input type="number" id="bp_form5_total_cost" name="total_cost" class="bp-form5-field form-control bp-forms-field">
               <span class="text-danger"><small id="bp-form5-total-cost-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="organizational_deployment">Organizational Deployment</label>
               <textarea type="text" id="bp_form5_organizational_deployment" name="organizational_deployment" class="bp-form5-field form-control bp-forms-field"></textarea>
               <span class="text-danger"><small id="bp-form5-organizational-deployment-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="justification">Justification</label>
               <textarea type="text" id="bp_form5_justification" name="justification" class="bp-form5-field form-control bp-forms-field"></textarea>
               <span class="text-danger"><small id="bp-form5-justification-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="remarks">Remarks</label>
               <textarea type="text" id="bp_form5_remarks" name="remarks" class="bp-form5-field form-control bp-forms-field"></textarea>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary save-buttons d-none add_bp_form5">Save</button>
            <button type="button" class="update btn btn-primary save-buttons d-none edit_bp_form5" value="update">Save changes</button>
         </div>
      </div>
   </div>
</div>