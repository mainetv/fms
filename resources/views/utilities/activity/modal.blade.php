<!-- Modal -->
<div class="modal fade" id="library_activity_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="library_activity_modal_header"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>            
       <div class="modal-body">
          <div class="form-group">
            <label for="library_activity">Activity</label>
            <input type="text" id="library_activity_name" name="library_activity_name" class="form-control library-activity-field"  required>
            <span class="is-invalid"><small id="activity-error" class="error"></small></span>
          </div>
          <div class="form-group">
              <label for="library_activity_code">Activity Code</label>
              <input type="text" id="library_activity_code" name="library_activity_code" class="form-control library-activity-field"  required>
              <span class="is-invalid"><small id="activity-code-error" class="error"></small></span>
          </div>
         <div class="form-group">
            <label for="library_activity_description">Description</label>
            <input type="text" id="library_activity_description" name="library_activity_description" class="form-control library-activity-field" required>   
            <span class="is-invalid"><small id="description-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_activity_request_status_type_id">Obligation Type</label>
            <input type="text" id="library_activity_request_status_type_id" name="library_activity_request_status_type_id"  class="form-control library-activity-field" required>
            <span class="is-invalid"><small id="request_status-type-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_activity_division_id">Division</label>
            <input type="text" id="library_activity_division_id" name="library_activity_division_id"  class="form-control library-activity-field" required>
            <span class="is-invalid"><small id="request_status-type-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="library_activity_remarks">Remarks</label>
            <textarea type="text" id="library_activity_remarks" name="library_activity_remarks" class="form-control library-activity-field"></textarea>
          </div> 
          <div class="form-check form-check-inline">
            <label for="library_activity_is_program">Is Program</label>&nbsp;
            <input type="checkbox" id="library_activity_is_program" name="library_activity_is_program" class="form-check-input library-activity-field" 
            @foreach ($library_activities as $row)
              {{ $row->is_program=="yes"?true:false }}
            @endforeach>
          </div>
          <div class="form-check form-check-inline">
            <label for="library_activity_is_active">Is Active</label>&nbsp;
            <input type="checkbox" id="library_activity_is_active" name="library_activity_is_active" class="form-check-input library-activity-field" 
            @foreach ($library_activities as $row)
              {{ $row->is_active=="yes"?true:false }}
            @endforeach>
          </div>
       </div>      
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button id="add_library_activity" type="button" class="btn btn-primary save-buttons d-none">Save</button>
         <button id="update_library_activity" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
       </div>
     </div>
   </div>
 </div>