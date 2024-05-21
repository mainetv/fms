<!-- Modal -->
<div class="modal fade" id="bp_form7_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="bp_form7_modal_header"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>            
       <div class="modal-body">
          <input type="hidden" id="bp_form7_year" name="bp_form7_year" readonly>
          <input type="hidden" id="bp_form7_fiscal_year" name="bp_form7_fiscal_year" readonly>
          <input type="hidden" id="bp_form7_division_id" name="bp_form7_division_id" value="{{ $user_division_id }}" readonly> 
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" id="description" name="description" class="bp-form7-field form-control bp-forms-field">
            <span class="is-invalid"><small id="description-error" class="error"></small></span>
          </div>            
          <div class="form-group">
            <label for="area_sqm">Area / Sqm</label>
            <input type="text" id="area_sqm" name="area_sqm" class="bp-form7-field form-control bp-forms-field">
          </div> 
          <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" class="bp-form7-field form-control bp-forms-field">
          </div>    
          <div class="form-group">
            <label for="aramounta_sqm">Amount</label>
            <input type="text" id="amount" name="amount" class="bp-form7-field form-control bp-forms-field">
          </div>
          <div class="form-group">
            <label for="justification">Justification</label>
            <input type="text" id="justification" name="justification" class="bp-form7-field form-control bp-forms-field">
          </div>
          <div class="form-group">
            <label for="remarks">Remarks</label>
            <input type="text" id="remarks" name="remarks" class="bp-form7-field form-control bp-forms-field">
          </div>         
       </div>      
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button type="button" class="btn btn-primary save-buttons d-none add_bp_form7">Save</button>
         <button type="button" class="update btn btn-primary save-buttons d-none edit_bp_form7" value="update">Save changes</button>
       </div>
     </div>
   </div>
 </div>