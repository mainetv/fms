<!-- Main Modal -->
  <div class="modal fade" id="nca_modal" tabindex="-1" role="dialog" aria-labelledby="pap_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="nca_modal_header">Add New NCA</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>            
        <div class="modal-body">     
          <div class="form-group row">
            <label for="pap_id" class="col-1 col-form-label">Year</label>&emsp;
            <div class="col">
              <input type="text" id="year" name="year" class="form-control nca-field" readonly>
            </div>  
            <div class="col-1"></div>
            <label for="pap_id" class="col-1 col-form-label">Fund</label>&emsp;&emsp;
            <div class="col">
              <select name="fund_id" id="fund_id" class="form-control nca-field">               
                @foreach ($getFunds as $row)
                  <option value="{{ $row->id }}" @if(isset($row->fund) && $fund_selected==$row->id){{"selected"}} @endif > {{ $row->fund }}</option>
                @endforeach    
              </select> 
              {{-- <input type="text" id="fund" name="fund" class="form-control nca-field" readonly> --}}
            </div>  
          </div>  
          <div class="form-group row">
            <label for="pap_id" class="col-1 col-form-label">January</label>&emsp;
            <div class="col">
              <input type="text" id="jan_nca" name="jan_nca" class="form-control nca-field">
            </div> 
            <div class="col-1"></div>
            <label for="pap_id" class="col-1 col-form-label">July</label>&emsp;&emsp;
            <div class="col">
              <input type="text" id="jul_nca" name="jul_nca" class="form-control nca-field">
            </div>  
          </div>  
          <div class="form-group row">
            <label for="pap_id" class="col-1 col-form-label">February</label>&emsp;
            <div class="col">
              <input type="text" id="feb_nca" name="feb_nca" class="form-control nca-field">
            </div> 
            <div class="col-1"></div>
            <label for="pap_id" class="col-1 col-form-label">August</label>&emsp;&emsp;
            <div class="col">
              <input type="text" id="aug_nca" name="aug_nca" class="form-control nca-field">
            </div>  
          </div> 
          <div class="form-group row">
            <label for="pap_id" class="col-1 col-form-label">March</label>&emsp;
            <div class="col">
              <input type="text" id="mar_nca" name="mar_nca" class="form-control nca-field">
            </div> 
            <div class="col-1"></div>
            <label for="pap_id" class="col-1 col-form-label">September</label>&emsp;&emsp;
            <div class="col">
              <input type="text" id="sep_nca" name="sep_nca" class="form-control nca-field">
            </div>  
          </div> 
          <div class="form-group row">
            <label for="pap_id" class="col-1 col-form-label">April</label>&emsp;
            <div class="col">
              <input type="text" id="apr_nca" name="apr_nca" class="form-control nca-field">
            </div> 
            <div class="col-1"></div>
            <label for="pap_id" class="col-1 col-form-label">October</label>&emsp;&emsp;
            <div class="col">
              <input type="text" id="oct_nca" name="oct_nca" class="form-control nca-field">
            </div>  
          </div> 
          <div class="form-group row">
            <label for="pap_id" class="col-1 col-form-label">May</label>&emsp;
            <div class="col">
              <input type="text" id="may_nca" name="may_nca" class="form-control nca-field">
            </div> 
            <div class="col-1"></div>
            <label for="pap_id" class="col-1 col-form-label">November</label>&emsp;&emsp;
            <div class="col">
              <input type="text" id="nov_nca" name="nov_nca" class="form-control nca-field">
            </div>  
          </div>
          <div class="form-group row">
            <label for="pap_id" class="col-1 col-form-label">June</label>&emsp;
            <div class="col">
              <input type="text" id="jun_nca" name="jun_nca" class="form-control nca-field">
            </div> 
            <div class="col-1"></div>
            <label for="pap_id" class="col-1 col-form-label">December</label>&emsp;&emsp;
            <div class="col">
              <input type="text" id="dec_nca" name="dec_nca" class="form-control nca-field">
            </div>  
          </div>
        </div>   
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary save-buttons d-none add_nca">Save</button>
          <button type="button" class="btn btn-primary save-buttons d-none edit_nca" value="update">Save changes</button>         
        </div>
      </div>
    </div>
  </div>
<!-- END Main Modal -->