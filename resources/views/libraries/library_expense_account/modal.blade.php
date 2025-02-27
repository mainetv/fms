<!-- Modal -->
<div class="modal fade" id="library_expense_account_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="library_expense_account_modal_header"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>            
       <div class="modal-body">
          <div class="form-group">
              <label for="">Expense Account</label>
              <input type="text" id="library_expense_account" name="library_expense_account" class="form-control library-expense-field"  required>
              <span class="is-invalid"><small id="expense-error" class="error"></small></span>
          </div>
         <div class="form-group">
            <label for="">Account Code</label>
            <input type="text" id="library_account_code" name="library_account_code" class="form-control library-expense-field" required>   
            <span class="is-invalid"><small id="code-error" class="error"></small></span>
          </div> 
          <div class="form-group">
            <label for="">Activity </label>
            <input type="text" id="library_expense_account_activity_id" name="library_expense_account_activity_id" class="form-control library-expense-field" required>
            {{-- <span class="is-invalid"><small id="acitit-type-error" class="error"></small></span> --}}
          </div> 
          <div class="form-group">
            <label for="">Subactivity</label>
            <input type="text" id="library_expense_account_subactivity_id" name="library_expense_account_subactivity_id" class="form-control library-expense-field" required>
            {{-- <span class="is-invalid"><small id="expense-error" class="error"></small></span> --}}
          </div> 
          <div class="form-group">
            <label for="">Request and Status Type</label>
            <input type="text" id="library_expense_account_request_status_type_id" name="library_expense_account_request_status_type_id" class="form-control library-expense-field" required>
            {{-- <span class="is-invalid"><small id="expense-error" class="error"></small></span> --}}
          </div> 
          <div class="form-group">
            <label for="">Remarks</label>
            <textarea type="text" id="library_expense_account_remarks" name="library_expense_account_remarks" class="form-control library-expense-field"></textarea>
          </div> 
          <div class="form-check form-check-inline">
            <label for="">Is Active</label>&nbsp;
            <input type="checkbox" id="library_expense_account_is_active" name="library_expense_account_is_active" class="form-check-input library-expense-field" 
            @foreach ($library_expense_accounts as $row)
              {{ $row->is_active=="yes"?true:false }}
            @endforeach>
          </div>
       </div>      
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button id="add_library_expense_account" type="button" class="btn btn-primary save-buttons d-none">Save</button>
         <button id="update_library_expense_account" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
       </div>
     </div>
   </div>
 </div>