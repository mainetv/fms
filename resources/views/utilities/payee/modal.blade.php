<!-- Modal -->
@php
  $getPayeeTypes = getPayeeTypes();
  $getPayees = getPayees();
  $getBanks = getBanks();
@endphp
<div class="modal fade" id="payee_modal" role="dialog" aria-labelledby="payee_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="frm_payee">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="payee_modal_header"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>        
        <div class="modal-body">
          <input type="text" id="id" name="id" class="payee-field" placeholder="id" hidden>
          <div class="form-group row payee_type">
            <label for="payee_type_id" class="col-sm-2 col-form-label">Payee Type</label>
            <div class="col-4">
              <input type="radio" id="individual" name="payee_type_id" class="payee-field"
                value="1">&nbsp;Individual&emsp;
              <input type="radio" id="organization" name="payee_type_id" class="payee-field"
                value="2">&nbsp;Organization
            </div>
            <div class="col">
              <div id="payee_type_id-feedback" class="invalid-feedback"></div>
            </div>
          </div>
          @role('Administrator')
          <div class="form-group row">
            <label for="particulars" class="col-sm-2 col-form-label">Payee Parent</label>
            <div class="col">
              <input type="text" id="payee_parent_name" name="payee_parent_name" class="form-control payee-field" readonly>
              <input type="text" id="parent_id" name="parent_id" class="form-control payee-field" readonly>
            </div>
          </div>
          @else
            <input type="text" id="parent_id" name="parent_id" class="form-control payee-field" readonly hidden>
          @endrole
          <div class="form-group d-none organization">
            <div class="form-group row">
              <label for="particulars" class="col-sm-2 col-form-label">Organization Name</label>
              <div class="col">
                <input type="text" id="organization_name" name="organization_name"
                  class="organization form-control payee-field">
                <div id="organization_name-feedback" class="invalid-feedback"></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="particulars" class="col-sm-2 col-form-label">Organization Acronym</label>
              <div class="col">
                <input type="text" id="organization_acronym" name="organization_acronym" class="organization form-control payee-field">
              </div>
            </div>
          </div>
          <div class="individual">
            <div class="form-group row">
              <label for="particulars" class="col-sm-2 col-form-label">First Name</label>
              <div class="col">
                <input type="text" id="first_name" name="first_name" class="individual form-control payee-field">
                <div id="first_name-feedback" class="invalid-feedback"></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="library_payees_description" class="col-sm-2 col-form-label">Middle Initial</label>
              <div class="col">
                <input type="text" id="middle_initial" name="middle_initial" class="individual form-control payee-field">
              </div>
            </div>
            <div class="form-group row">
              <label for="library_payees_request_status_type_id" class="col-sm-2 col-form-label">Last Name</label>
              <div class="col">
                <input type="text" id="last_name" name="last_name" class="individual form-control payee-field">
                <div id="last_name-feedback" class="invalid-feedback"></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="library_payees_request_status_type_id" class="col-sm-2 col-form-label">Suffix</label>
              <div class="col">
                <input type="text" id="suffix" name="suffix" class="individual form-control payee-field">
              </div>
            </div>
          </div>
          <div class="all">
            <div class="form-group row">
              <label for="library_payees_request_status_type_id" class="col-sm-2 col-form-label">TIN</label>
              <div class="col">
                <input type="text" id="tin" name="tin" class="form-control payee-field" />
                <div id="tin-feedback" class="invalid-feedback"></div>
              </div>
            </div>
            <fieldset>
              <div class="row form-group">
                <div class="col-6">
                  <label for="bank_id">Bank</label>
                  <select name="bank_id" id="bank_id" class="form-control payee-field select2bs4">
                    <option value="">Select Bank</option>
                    @foreach ($getBanks as $row)
                      <option value="{{ $row->id }}">{{ $row->bank }}</option>
                    @endforeach
                  </select>
                  <div id="bank_id-feedback" class="invalid-feedback"></div>
                </div>
                <div class="col-6">
                  <label for="library_payees_remarks">Bank Branch</label>
                  <input type="text" id="bank_branch" name="bank_branch" class="form-control payee-field" />
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <label for="library_payees_remarks">Bank Account Name</label>
                  <input type="text" id="bank_account_name" name="bank_account_name"
                    class="form-control payee-field" />
                  <div id="bank_account_name-feedback" class="invalid-feedback"></div>
                </div>
                <div class="col-6">
                  <label for="library_payees_remarks">Bank Account No.</label>
                  <input type="text" id="bank_account_no" name="bank_account_no"
                    class="form-control payee-field" />
                  <div id="bank_account_no-feedback" class="invalid-feedback"></div>
                </div>
              </div>
            </fieldset>
            <br>
            <div class="form-group row">
              <label for="library_payees_description" class="col-sm-2 col-form-label">Address</label>
              <div class="col">
                <textarea type="text" id="address" rows="1" name="address" class="form-control payee-field"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="library_payees_description" class="col-sm-2 col-form-label">Office Address</label>
              <div class="col">
                <textarea type="text" id="office_address" rows="1" name="office_address" class="form-control payee-field"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-6">
                <label for="library_payees_remarks">Email Address</label>
                <input type="text" id="email_address" name="email_address" class="form-control payee-field" />
              </div>
              <div class="col-6">
                <label for="library_payees_remarks">Contact No.</label>
                <input type="text" id="contact_no" name="contact_no" class="form-control payee-field" />
              </div>
            </div>
            @role('Administrator')
            <div class="form-group row">
              <div class="col-3">
                <label>Verify</label>
                <input type="checkbox" id="is_verified" name="is_verified" class="bootstrap-switch bootstrap-switch-mini payee-field" 
                  data-on-text="Yes" data-off-text="No"  data-on-color="success" data-off-color="danger" checked>
              </div>
            </div>            
            @endrole
          </div>
        </div>
        <div class="modal-footer">          
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="add btn btn-primary save-buttons d-none">Save</button>
          <button type="button" class="update btn btn-primary save-buttons d-none">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
