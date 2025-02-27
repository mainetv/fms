<!-- Modal -->
<div class="modal fade" id="library_subactivity_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="library_subactivity_modal_header"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>            
       <div class="modal-body">
          <div class="form-group">
              <label for="library_subactivity">Subactivity</label>
              <input type="text" id="library_subactivity" name="library_subactivity" class="form-control library-subactivity-field select2"  required>
              <span class="is-invalid"><small id="subactivity-error" class="error"></small></span>
          </div>
         <div class="form-group">
            <label for="library_subactivity_description">Description</label>
            <input type="text" id="library_subactivity_description" name="library_subactivity_description" class="form-control library-subactivity-field select2" required>   
            <span class="is-invalid"><small id="description-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_subactivity_request_status_type_id">Request and Status Type</label>
            <input type="text" id="library_subactivity_request_status_type_id" name="library_subactivity_request_status_type_id"  class="form-control library-subactivity-field select2" required>
            <span class="is-invalid"><small id="request-status-type-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_subactivity_remarks">Remarks</label>
            <textarea type="text" id="library_subactivity_remarks" name="library_subactivity_remarks" class="form-control library-subactivity-field"></textarea>
          </div> 
          <div class="form-check form-check-inline">
            <label for="library_subactivity_is_continuing">Is Continuing</label>&nbsp;
            <input type="checkbox" id="library_subactivity_is_continuing" name="library_subactivity_is_continuing" class="form-check-input library-subactivity-field select2" 
            @foreach ($library_subactivities as $row)
              {{ $row->is_continuing=="yes"?true:false }}
            @endforeach>
          </div>
          <div class="form-check form-check-inline">
            <label for="library_subactivity_is_active">Is Active</label>&nbsp;
            <input type="checkbox" id="library_subactivity_is_active" name="library_subactivity_is_active" class="form-check-input library-subactivity-field select2" 
            @foreach ($library_subactivities as $row)
              {{ $row->is_active=="yes"?true:false }}
            @endforeach>
          </div>
       </div>      
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button id="add_library_subactivity" type="button" class="btn btn-primary save-buttons d-none">Save</button>
         <button id="update_library_subactivity" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
       </div>
     </div>
   </div>
 </div>