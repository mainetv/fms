<!-- Modal -->
<div class="modal fade" id="library_specific_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="library_specific_modal_header"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>            
       <div class="modal-body">
          <div class="form-group">
              <label for="library_object_specific">Expenditure</label>
              <input type="text" id="library_object_specific" name="library_object_specific" class="form-control library-specific-field"  required>
              <span class="is-invalid"><small id="specific-error" class="error"></small></span>
          </div>
         <div class="form-group">
            <label for="library_specific_description">Description</label>
            <input type="text" id="library_specific_description" name="library_specific_description" class="form-control library-specific-field" required>   
            <span class="is-invalid"><small id="description-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_specific_obligation_type">Obligation Type</label>
            <input type="text" id="library_specific_obligation_type" name="library_specific_obligation_type" class="form-control library-specific-field" required>
            <span class="is-invalid"><small id="obligation-type-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_specific_expense">Expense</label>
            <input type="text" id="library_specific_expense" name="library_specific_expense" class="form-control library-specific-field" required>
            <span class="is-invalid"><small id="expense-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_specific_remarks">Remarks</label>
            <textarea type="text" id="library_specific_remarks" name="library_specific_remarks" class="form-control library-specific-field"></textarea>
          </div> 
          <div class="form-check form-check-inline">
            <label for="library_specific_is_active">Is Active</label>&nbsp;
            <input type="checkbox" id="library_specific_is_active" name="library_specific_is_active" class="form-check-input library-specific-field" 
            @foreach ($library_specifics as $row)
              {{ $row->is_active=="yes"?true:false }}
            @endforeach>
          </div>
       </div>      
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button id="add_library_specific" type="button" class="btn btn-primary save-buttons d-none">Save</button>
         <button id="update_library_specific" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
       </div>
     </div>
   </div>
 </div>