<!-- Modal -->
<div class="modal fade" id="user_role_modal" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="user_role_modal_header"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>            
       <div class="modal-body">
          <div class="form-group">
              <label for="user_role">User Role</label>
              <input id="user_role" name="user_role" class="form-control user-roles-field"  required autofocus>                  
              <span class="is-invalid"><small id="user-role-error" class="error"></small></span>
          </div>
          {{-- <div class="form-check form-check-inline">
            <label for="users_is_active">Is Active</label>&nbsp;
            <input type="checkbox" id="users_is_active" name="users_is_active" class="form-check-input users-field" 
            @foreach ($view_users as $row)
              {{ $row->is_active=="yes"?true:false }}
            @endforeach>
          </div> --}}
       </div>      
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button id="add_user_role" type="button" class="btn btn-primary save-buttons d-none">Save</button>
         <button id="update_user_role" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
       </div>
     </div>
   </div>
 </div>