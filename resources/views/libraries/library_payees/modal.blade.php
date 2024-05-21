<!-- Modal -->
@php
	$getPayeeTypes = getPayeeTypes();
	$getPayees = getPayees();
	$getBanks = getBanks();
@endphp
<div class="modal fade" id="library_payees_modal" role="dialog" aria-labelledby="library_payees_label" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="library_payees_modal_header"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>          
		 <input type="text" id="payee_id" hidden>  
       <div class="modal-body">
			<div class="form-group row d-none parent_id">
				<label for="parent_id" class="col-sm-2 col-form-label">Existing Payee?</label>
				<div class="col">
					<select name="parent_id" id="parent_id" class="form-control library-payee-field select2bs4 ">
						<option value="">Select Payee</option>
						<option value="0">Payee does not exist in database</option>
						@foreach ($getPayees as $row)
							<option value="{{ $row->id }}" data-payeetypeid="{{ $row->payee_type_id }}" data-first="{{ $row->first_name }}" 
								data-mi="{{ $row->middle_initial }}" data-last="{{ $row->last_name }}" data-suffix="{{ $row->suffix }}"
								data-org="{{ $row->organization_name }}" data-orgacr="{{ $row->organization_acronym }}" data-tin="{{ $row->tin }}"
								data-address="{{ $row->address }}" data-office="{{ $row->office_address }}" data-email="{{ $row->email_address }}"
								data-contact="{{ $row->contact_no }}" data-bankid="{{ $row->bank_id }}" data-bankbranch="{{ $row->bank_branch }}"
								data-bankaccntname="{{ $row->bank_account_name }}" data-bankaccntno="{{ $row->bank_account_no}}"
								data-active="{{ $row->is_active }}">{{ $row->payee }}</option>
						@endforeach
					</select> 						
				</div>  
			</div> 
			<input type="text" id="payee_type_id" hidden>
			<div class="form-group row d-none payee_type">
				<label for="payee_type_id" class="col-sm-2 col-form-label">Payee Type</label>
				<div class="col">  
					<input type="radio" id="individual" name="payee_type" value="1">&nbsp;Individual&emsp;
					<input type="radio" id="organization" name="payee_type" value="2">&nbsp;Organization
					<span class="is-invalid"><small id="payee-type-error" class="error"></small></span>
				</div>   
			</div>
			<div class="form-group d-none organization">
				<div class="form-group row">
					<label for="particulars" class="col-sm-2 col-form-label">Organization Name</label>
					<div class="col">         
						<input type="text" id="organization_name" name="organization_name" class="organization form-control library-payee-field">
						<span class="is-invalid"><small id="organization-error" class="error"></small></span>
					</div>        
				</div>
				<div class="form-group row">
					<label for="particulars" class="col-sm-2 col-form-label">Organization Acronym</label>
					<div class="col">         
						<input type="text" id="organization_acronym" name="" class="organization form-control library-payee-field">
						<span class="is-invalid"><small id="organization-error" class="error"></small></span>
					</div>        
				</div>
			</div>
			<div class="d-none individual">				
				<div class="form-group row">
					<label for="particulars" class="col-sm-2 col-form-label">First Name</label>
					<div class="col">         
						<input type="text" id="first_name" name="first_name" class="individual form-control library-payee-field">
						<span class="is-invalid"><small id="first-error" class="error"></small></span>
					</div>        
				</div>  
				<div class="form-group row">
					<label for="library_payees_description" class="col-sm-2 col-form-label">Middle Initial</label>
					<div class="col"> 
						<input type="text" id="middle_initial" name="middle_initial" class="individual form-control library-payee-field">  
					</div>  
				</div> 
				<div class="form-group row">
					<label for="library_payees_request_status_type_id" class="col-sm-2 col-form-label">Last Name</label>
					<div class="col"> 
						<input type="text" id="last_name" name="last_name"  class="individual form-control library-payee-field">
						<span class="is-invalid"><small id="last-error" class="error"></small></span>
					</div>
				</div> 
				<div class="form-group row">
					<label for="library_payees_request_status_type_id" class="col-sm-2 col-form-label">Suffix</label>
					<div class="col"> 
						<input type="text" id="suffix" name="suffix"  class="individual form-control library-payee-field">
						<span class="is-invalid"><small id="last-error" class="error"></small></span>
					</div>
				</div>
			</div>
			<div class="d-none all">
				<div class="form-group row">
					<label for="library_payees_request_status_type_id" class="col-sm-2 col-form-label">TIN</label>
					<div class="col"> 
						<input type="text" id="tin" name="tin" class="form-control library-payee-field"/>
					</div>
				</div>
				<fieldset>		
					<div class="row form-group">		
						<div class="col-6">
							<label for="bank_id">Bank</label>
							<select name="bank_id" id="bank_id" class="form-control library-payee-field select2bs4">
								<option value="">Select Bank</option>
								@foreach ($getBanks as $row)
									<option value="{{ $row->id }}">{{ $row->bank }}</option>						
								@endforeach
							</select>
							<span class="is-invalid"><small id="bank-error" class="error"></small></span>
						</div> 
						<div class="col-6">
							<label for="library_payees_remarks">Bank Branch</label>
							<input type="text" id="bank_branch" name="bank_branch" class="form-control library-payee-field"/>
						</div> 
					</div>	
					<div class="row">
						<div class="col-6">
							<label for="library_payees_remarks">Bank Account Name</label>
							<input type="text" id="bank_account_name" name="bank_account_name" class="form-control library-payee-field"/>
						</div> 
						<div class="col-6">
							<label for="library_payees_remarks">Bank Account No.</label>
							<input type="text" id="bank_account_no" name="bank_account_no" class="form-control library-payee-field"/>

						</div> 
					</div>
				</fieldset>	
				<br>
				<div class="form-group row">
					<label for="library_payees_description" class="col-sm-2 col-form-label">Address</label>
					<div class="col"> 
						<textarea type="text" id="address" rows="1" name="address" class="form-control library-payee-field"></textarea>
					</div>  
				</div> 
				<div class="form-group row">
					<label for="library_payees_description" class="col-sm-2 col-form-label">Office Address</label>
					<div class="col"> 
						<textarea type="text" id="office_address" rows="1" name="office_address" class="form-control library-payee-field"></textarea>
					</div>  
				</div> 
				<div class="form-group row">
					<div class="col-6">
						<label for="library_payees_remarks">Email Address</label>
						<input type="text" id="email_address" name="email_address" class="form-control library-payee-field"/>
					</div>
					<div class="col-6">
						<label for="library_payees_remarks">Contact No.</label>
						<input type="text" id="contact_no" name="contact_no" class="form-control library-payee-field"/>
					</div>
				</div>
				<div class="form-check form-check-inline">
					<label for="is_active">Is Active</label>&nbsp;
					<input type="checkbox" id="payee_is_active" name="payee_is_active" class="form-check-input library-payee-field" >
				</div>
			</div>			
			{{-- <div class="form-check form-check-inline">
            <label for="users_is_active">Is Active</label>&nbsp;
            <input type="checkbox" id="users_is_active" name="users_is_active" class="form-check-input users-field">
         </div> --}}
       </div>      
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button type="button" class="add_payee btn btn-primary save-buttons d-none">Save</button>
         <button type="button" class="edit_payee btn btn-primary save-buttons d-none" value="update">Save changes</button>
       </div>
     </div>
   </div>
</div>