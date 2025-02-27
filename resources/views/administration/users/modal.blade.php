<!-- Modal -->
<div class="modal fade" id="user_modal" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="user_modal_header"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>            
       <div class="modal-body">
          <div class="form-group">
              <label for="users_employee_code">Employee</label>
              <select id="users_employee_code" name="users_employee_code" class="form-control users-field select2bs4" required autofocus>   
                <option value="" selected hidden>Select Employee</option>
                @foreach ($employees as $row)
                    <option value="{{ $row->username }}">{{ $row->lname.", ".$row->fname. " ".$row->mname." : ".$row->username }}</option>
                @endforeach                           
              </select>
              <span class="is-invalid"><small id="employee-code-error" class="error"></small></span>
          </div>
         <div class="form-group">
            <label for="users_user_role_id">User Role</label>
            <select id="users_user_role_id" name="users_user_role_id" class="form-control users-field select2bs4" required>   
              <option value="" selected hidden>Select User Role</option>
              @foreach ($user_roles as $row)
                <option value="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}"> {{ $row->name }}</option>
              @endforeach                           
            </select>
            <span class="is-invalid"><small id="user-role-error" class="error"></small></span>
          </div> 
          {{-- <div class="form-group">
            <label for="users_user_role_id">Username</label>
            <input type="text" id="users_username" name="users_username" :value="old('username')" class="form-control users-field" required>
            <span class="is-invalid"><small id="username-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="users_user_role_id">Password</label>
            <input type="password" id="users_password" name="users_password" class="form-control users-field" required>
            <span class="is-invalid"><small id="password-error" class="error"></small></span>
          </div>  --}}
          <div class="form-check form-check-inline">
            <label for="users_is_active">Is Active</label>&nbsp;
            <input type="checkbox" id="users_is_active" name="users_is_active" class="form-check-input users-field" 
            @foreach ($view_users as $row)
              {{ $row->is_active=="yes" ? 'checked' : '' }}
            @endforeach>
          </div>
       </div>      
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button id="add_user" type="button" class="btn btn-primary save-buttons d-none">Save</button>
         <button id="update_user" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
       </div>
     </div>
   </div>
 </div>