<!-- Modal -->

  <div class="modal fade" id="user_modal" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
      <form id="frm_user">
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
                  @foreach ($getAllActiveStaff as $row)
                      <option value="{{ $row->username }}">{{ $row->lname.", ".$row->fname. " ".$row->mname." : ".$row->username }}</option>
                  @endforeach                           
                </select>
                <small class="text-danger" id="users_employee_code-feedback"></small>
            </div>
          <div class="form-group">
              <label for="users_user_role_id">User Role</label>
              <select id="users_user_role_id" name="users_user_role_id[]" class="form-control users-field select2bs4" required multiple >   
                @foreach ($getUserRoles as $row)
                  <option value="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}"> {{ $row->name }}</option>
                @endforeach                           
              </select>
              <small class="text-danger" id="users_user_role_id-feedback"></small>
            </div> 
        </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="add_user btn btn-primary save-buttons d-none">Save</button>
          <button type="button" class="update_user btn btn-primary save-buttons d-none">Save</button>
        </div>
      </form>
     </div>
   </div>
 </div>
