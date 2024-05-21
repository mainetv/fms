<!-- Modal -->
<div class="modal fade" id="bp_form3_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="bp_form3_modal_header"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>            
			<div class="modal-body">
				<input type="hidden" id="bp_form3_year" name="bp_form3_year" readonly>
				<input type="hidden" id="bp_form3_fiscal_year" name="bp_form3_fiscal_year" readonly>
				<input type="hidden" id="bp_form3_division_id" name="bp_form3_division_id" value="{{ $user_division_id }}" readonly> 
				<div class="form-group">
               <label for="description">Tier</label>
               <select name="tier" id="bp_form3_tier">
                  <option value="1">1</option>
                  <option value="2">2</option>
               </select>
               <span class="text-danger"><small id="bp-form3-tier-error" class="error"></small></span>
            </div>
				<div class="form-group">
					<label for="description">Description</label>
					<textarea type="text" id="bp_form3_description" name="description" class="bp-form3-field form-control bp-forms-field"></textarea>
					<span class="text-danger"><small id="bp-form3-description-error" class="error"></small></span>
				</div>            
				<div class="form-group">
					<label for="area_sqm">Area / Sqm</label>
					<input type="number" id="bp_form3_area_sqm" name="area_sqm" class="bp-form3-field form-control bp-forms-field">
					<span class="text-danger"><small id="bp-form3-area-sqm-error" class="error"></small></span>
				</div> 
				<div class="form-group">
					<label for="location">Location</label>
					<input type="text" id="bp_form3_location" name="location" class="bp-form3-field form-control bp-forms-field">
					<span class="text-danger"><small id="bp-form3-location-error" class="error"></small></span>
				</div>    
				<div class="form-group">
					<label for="amount">Amount</label>
					<input type="number" id="bp_form3_amount" name="amount" class="bp-form3-field form-control bp-forms-field">
					<span class="text-danger"><small id="bp-form3-amount-error" class="error"></small></span>
				</div>
				<div class="form-group">
					<label for="justification">Justification</label>
					<textarea id="bp_form3_justification" name="justification" class="bp-form3-field form-control bp-forms-field"></textarea>
					<span class="text-danger"><small id="bp-form3-justification-error" class="error"></small></span>
				</div>
				<div class="form-group">
					<label for="remarks">Remarks</label>
					<textarea type="text" id="bp_form3_remarks" name="remarks" class="bp-form3-field form-control bp-forms-field"></textarea>
				</div>         
			</div>      
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary save-buttons d-none add_bp_form3">Save</button>
				<button type="button" class="update btn btn-primary save-buttons d-none edit_bp_form3">Save changes</button>
			</div>
		</div>
	</div>
</div>