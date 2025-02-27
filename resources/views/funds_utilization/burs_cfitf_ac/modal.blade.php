<!-- Main Modal -->
  <div class="modal fade" id="ors_modal" role="dialog" style="overflow:hidden; overflow-y:scroll;" aria-labelledby="ors_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ors_modal_header">Add BURS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>    
        <form id="ors_form">     
          <div class="modal-body">   
            <input type="hidden" id="year" name="year">
            <input type="hidden" id="rs_type_id" name="rs_type_id" value="1">
            <input type="hidden" id="user_role_id" name="user_role_id" value="{{ $user_role_id }}">
            <div class="form-group row">
              <label for="rs_id" class="col-sm-1 col-form-label">BURS ID</label>
              <div class="col-sm-4"> 
                <input type="text" name="rs_id" id="rs_id" class="form-control no-border" readonly>
              </div>  
              <label for="rs_no" class="col-sm-1 col-form-label">BURS No. <span id="generate_rs_no" class="d-none"><a href="#"> >> </a></span></label>
              <div class="col"> 
                <input type="text" name="rs_no" id="rs_no" class="form-control" readonly>
              </div>  
            </div>  
            <div class="form-group row">
              <label for="activity_id" class="col-sm-1 col-form-label">Date</label>
              <div class="col-sm-4"> 
                <input type="date" id="rs_date" name="rs_date" class="form-control ors-field">
                <span class="is-invalid"><small id="date-error" class="error"></small></span>
              </div>   
              <label for="fund_id" class="col-sm-1 col-form-label">Fund</label>
              <div class="col"> 
                <select id="fund_id" name="fund_id" class="form-control ors-field select2bs4">   
                  <option value="" selected hidden>Select Fund</option>
                  @foreach ($getFunds as $row)
                    <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->fund }}</option>
                  @endforeach                           
                </select>
                <span class="is-invalid"><small id="fund-error" class="error"></small></span>
              </div>   
              <label for="division_id" class="col-sm-1 col-form-label">Division</label>
              <div class="col"> 
                <input type="text" id="division_id" name="division_id" class="form-control ors-field" hidden>
                <input type="text" id="division_acronym" class="form-control ors-field" readonly>
              </div> 
            </div>              
            <div class="form-group row">
              <label for="payee_id" class="col-sm-1 col-form-label">Payee</label>
              <div class="col">
                <select id="payee_id" name="payee_id" class="form-control ors-field select2bs4">   
                  <option value="" selected hidden>Select Payee</option>
                  @foreach ($getPayees as $row)
                    <option value="{{ $row->id }}" data-id="{{ $row->id }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">
                      @if($row->payee_type_id==1){{ $row->first_name }} {{ $row->middle_initial }} {{ $row->last_name }} [{{ $row->bank_name }}: {{ $row->bank_account_number }}]
                      @elseif($row->payee_type_id==2){{ $row->organization_name }} [{{ $row->bank_name }}: {{ $row->bank_account_number }}]@endif
                    </option>
                  @endforeach                           
                </select>
                <span class="is-invalid"><small id="payee-error" class="error"></small></span>
              </div> 
            </div> 
            <div class="form-group row">
              <label for="particulars" class="col-sm-1 col-form-label">Particulars</label>
              <div class="col">             
                <textarea name="particulars" id="particulars" rows="4" class="form-control ors-field"></textarea>
                <span class="is-invalid"><small id="particulars-error" class="error"></small></span>
              </div>        
            </div>              
            <button data-toggle="tooltip" data-placement="auto" title="Add Activity" class="add-row-allotment-activity btn-sm d-none ors-field">
              <i class="fa-solid fa-plus blue"></i> Add Allotment Activity</button>           
              {{-- <input type="text" id="ors_activity_num_rows" name="ors_activity_num_rows" value="" hidden> --}}
            <input type="checkbox" id="showall" name="showall" class="ors-field">Show All Divisions' Activity 
            <br>  
            Charged to:
            <table id="allotment_activity_table" class="table-borderless">     
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>                 
            </table> 
            <table class="total_amount_table table-borderless" width="100%">   
              <tr>
                <td class="col-sm-9 text-right">Total</td>
                <td class="col-sm-3"><input type="text" id="total_amount" name="total_amount" class="form-control" readonly></td>
                <td class="col-sm-1">&emsp;&emsp;&nbsp;</td>
              </tr>                   
            </table>  
            <br>             
            <div class="form-group row">              
              <label for="signatory_id" class="col-form-label">Signatory 1.</label>
              <div class="col"> 
                <select id="signatory1" name="signatory1" class="form-control ors-field select2bs4">   
                  <option value="" selected hidden>Select Signatory</option>
                  @foreach ($getRsSignatories as $row)
                    <option value="{{ $row->fullname_first }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->fullname_first }}</option>
                  @endforeach                           
                </select>
              </div> 
              <label for="signatory_id" class="col-form-label">2.</label> 
              <div class="col"> 
                <select id="signatory2" name="signatory2" class="form-control ors-field select2bs4">   
                  <option value="" selected hidden>Select Signatory</option>
                  @foreach ($getRsSignatories as $row)
                    <option value="{{ $row->fullname_first }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->fullname_first }}</option>
                  @endforeach                           
                </select>
              </div>              
            </div>          
            <div class="form-group row">
              <label for="signatory_id" class="col-form-label">&emsp;&emsp;&emsp;&emsp;&nbsp; 3.</label>
              <div class="col"> 
                <select id="signatory3" name="signatory3" class="form-control ors-field select2bs4">   
                  <option value="" selected hidden>Select Signatory</option>
                  @foreach ($getRsSignatories as $row)
                    <option value="{{ $row->fullname_first }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->fullname_first }}</option>
                  @endforeach                           
                </select>
              </div>   
              <label for="signatory_id" class="col-form-label">4.</label>
              <div class="col"> 
                <select id="signatory4" name="signatory4" class="form-control ors-field select2bs4">   
                  <option value="" selected hidden>Select Signatory</option>
                  @foreach ($getRsSignatories as $row)
                    <option value="{{ $row->fullname_first }}" data-tags="{{ strtoupper($row->tags) ?? '' }}">{{ $row->fullname_first }}</option>
                  @endforeach                           
                </select>
              </div>              
            </div> 
            <br>
            <div class="form-group row">
              <label for="particulars" class="col-sm-1 col-form-label">Transaction Type</label>
              <div class="col">             
                <select name="rs_transaction_type_id[]" id="rs_transaction_type_id" multiple="multiple" 
                  data-placeholder="Select Transaction Type" class="ors-field select2bs4 form-control">
                  @foreach($getRsTransactionTypes->groupBy('allotment_class') as $key=>$row)       
                    <optgroup class="font-weight-bold" label="{{ $key }}">
                      @foreach($row as $item)               
                        <option value="{{ $item->id }}">
                            {{ $item->transaction_type }} 
                        </option>                        
                      @endforeach
                    </optgroup>
                  @endforeach     
                </select>
              </div>        
            </div>  
          </div>        
          <div class="modal-footer">
            <button type="button" class="btn btn-primary print">Print</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary save-buttons d-none add_ors">Save</button>
            <button type="button" class="btn btn-primary save-buttons d-none edit_ors" value="update">Update</button>         
          </div>
        </form>         
        <div class="form-control">
          Budget Office Remarks:
          <table id="fad_budget_remarks_table">
          </table>
        </div>
      </div>
    </div>    
  </div>
<!-- END Main Modal -->

