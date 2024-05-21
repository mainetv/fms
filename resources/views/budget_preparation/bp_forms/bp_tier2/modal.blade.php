<!-- Modal -->
<div class="modal fade" id="bp_form9_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="bp_form9_modal_header"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <input type="text" id="bp_form9_year" name="year" value="{{ date('Y') }}">
				<input type="text" id="bp_form9_division_id" name="division_id" value="{{ $user_division_id }}"> 
            <div class="form-group">
               <label for="description">Item Description</label>
               <input type="text" id="bp_form9_description" name="description" class="dost-form9-field form-control dost-forms-field">
               <span class="text-danger"><small id="dost-form9-description-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="quantity">Quantity</label>
               <input type="number" id="bp_form9_quantity" name="quantity" class="dost-form9-field form-control dost-forms-field">
               <span class="text-danger"><small id="dost-form9-quantity-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="unit_cost">Unit Cost</label>
               <input type="number" id="bp_form9_unit_cost" name="unit_cost" class="dost-form9-field form-control dost-forms-field">
               <span class="text-danger"><small id="dost-form9-unit-cost-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="total_cost">Total Cost</label>
               <input type="number" id="bp_form9_total_cost" name="total_cost" class="dost-form9-field form-control dost-forms-field">
               <span class="text-danger"><small id="dost-form9-total-cost-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="organizational_deployment">Organizational Deployment</label>
               <input type="text" id="bp_form9_organizational_deployment" name="organizational_deployment" class="dost-form9-field form-control dost-forms-field">
               <span class="text-danger"><small id="dost-form9-organizational-deployment-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="justification">Justification</label>
               <input type="text" id="bp_form9_justification" name="justification" class="dost-form9-field form-control dost-forms-field">
               <span class="text-danger"><small id="dost-form9-justification-error" class="error"></small></span>
            </div>
            <div class="form-group">
               <label for="remarks">Remarks</label>
               <input type="text" id="bp_form9_remarks" name="remarks" class="dost-form9-field form-control dost-forms-field">
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="add_bp_form9" type="button" class="btn btn-primary save-buttons d-none">Save</button>
            <button id="update_bp_form9" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
         </div>
      </div>
   </div>
</div>