<!-- RS Modal -->
<div class="modal fade" id="rci_modal" role="dialog" aria-labelledby="rci_label" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form id="rci_form">    
        <div class="modal-header">
          <h5 class="modal-title" id="rci_modal_header"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>         
        <div class="modal-body">    
          @php
            $rci_no=$year_selected."-".$month_selected."-";
            $rci_no_prefix=$year_selected."-".$month_selected."-";
            $bank_account_id='';
          @endphp      
          <div class="form-group">              
            <label for="library_pap_code">Bank Account No.</label>
            <select name="bank_account_id" id="bank_account_id">
              <option value="" selected>Select Bank Account No.</option>
              @foreach ($getAllBankAccounts->where('is_disbursement', 1) as $row)
                <option value="{{ $row->id }}"
                  @if($bank_account_id==$row->id) selected @endif>
                  {{ $row->fund }}: {{ $row->bank_account_no }}</option>                  
              @endforeach
            </select><br>
            <span class="is-invalid"><small id="bank-error" class="error"></small></span>
          </div>
          <label for="">Date</label>
          <div class="form-group">              
            <input type="text" id="rci_date" name="rci_date" class="datepicker" value="{{ date('Y-m-d') }}"><br>
            <span class="is-invalid"><small id="date-error" class="error"></small></span>
          </div>
          {{-- <label for="">RCI No. 
            <a href="javascript:void(0)" class="generate_rci_no" data-rci-prefix="{{ $rci_no_prefix }}"
            data-toggle="tooltip" data-placement='right' title='Generate RCI number'> >> </a>
          </label>
          <div class="form-group">              
            <input type="text" id="rci_no" name="rci_no" value="{{ $rci_no}}" readonly>
          </div>            --}}
        </div>
        <div class="modal-footer">
          <button id="add" type="button" class="btn add btn-primary save-buttons d-none">Save</button>
          <button id="edit" type="button" class="btn edit btn-primary save-buttons d-none" value="update">Save changes</button>
        </div>   
      </form>
    </div>
  </div>
</div>
<!-- END RS Modal -->


