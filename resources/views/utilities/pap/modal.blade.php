<!-- Modal -->
<div class="modal fade" id="library_pap_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="library_pap_modal_header"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>            
       <div class="modal-body">
          <div class="form-group">
              <label for="library_pap_code">PAP Code</label>
              <input type="text" id="library_pap_code" name="library_pap_code" class="form-control library-pap-field"  required>
              <span class="is-invalid"><small id="pap-code-error" class="error"></small></span>
          </div>
          <div class="form-group">
            <label for="library_pap_pap">PAP</label>
            <input type="text" id="library_pap_pap" name="library_pap_pap" class="form-control library-pap-field" required>   
            <span class="is-invalid"><small id="pap-error" class="error"></small></span>
          </div> 
         <div class="form-group">
            <label for="library_pap_description">Description</label>
            <input type="text" id="library_pap_description" name="library_pap_description" class="form-control library-pap-field" required>   
            <span class="is-invalid"><small id="description-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_pap_request_status_type_id">Request and Status Type</label>
            <input type="text" id="library_pap_request_status_type_id" name="library_pap_request_status_type_id"  class="form-control library-pap-field" required>
            <span class="is-invalid"><small id="rs-type-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_pap_remarks">Remarks</label>
            <textarea type="text" id="library_pap_remarks" name="library_pap_remarks" class="form-control library-pap-field"></textarea>
          </div> 
          <div class="form-check form-check-inline">
            <label for="library_pap_is_active">Is Active</label>&nbsp;
            <input type="checkbox" id="library_pap_is_active" name="library_pap_is_active" class="form-check-input library-pap-field" 
            @foreach ($library_paps as $row)
              {{ $row->is_active=="yes"?true:false }}
            @endforeach>
          </div>
       </div>      
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button id="add_library_pap" type="button" class="btn btn-primary save-buttons d-none">Save</button>
         <button id="update_library_pap" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
       </div>
     </div>
   </div>
 </div>