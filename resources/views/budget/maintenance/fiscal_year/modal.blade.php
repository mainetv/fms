<!-- Modal -->
<div class="modal fade" id="budget_proposal_fiscal_years_modal" tabindex="-1" role="dialog" aria-labelledby="pap_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="budget_proposal_fiscal_years_modal_header"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>        
        @csrf  
        <div class="modal-body">           
          <div class="form-group">
            <label>Budget Proposal Year</label>
            <select id="budget_proposal_year" name="budget_proposal_year" class="form-control budget-proposal-fiscal-years-field select2bs4">   
              <option value="" selected hidden>Select Budget Proposal Year</option>
              <?php $year = date('Y'); ?>
              @for($i=$year;$i<=$year+5;$i++)
                <option value="{{ $i; }}">{{ $i; }}</option>
              @endfor              
            </select>
            <span class="is-invalid"><small id="budget-proposal-fiscal-years-error" class="error"></small></span>
          </div> 
          <div class="row"> 
            <div class="form-group col">
              <label>Fiscal Year 1</label>
              <select id="budget_proposal_fiscal_year1" name="fiscal_year1" class="form-control budget-proposal-fiscal-years-field select2bs4">   
                <option value="" selected hidden>Select Fiscal Year 1</option>
                <?php $year = date('Y'); ?>
                @for($i=$year;$i<=$year+5;$i++)
                  <option value="{{ $i; }}">{{ $i; }}</option>
                @endfor              
              </select>
              <span class="is-invalid"><small id="fiscal-year1-error" class="error"></small></span> 
            </div>  
            <div class="form-group col">
              <label>Fiscal Year 2</label>
              <select id="budget_proposal_fiscal_year2" name="fiscal_year2" class="form-control budget-proposal-fiscal-years-field select2bs4">   
                <option value="" selected hidden>Select Fiscal Year 2</option>
                <?php $year = date('Y'); ?>
                @for($i=$year;$i<=$year+5;$i++)
                  <option value="{{ $i; }}">{{ $i; }}</option>
                @endfor              
              </select>
              <span class="is-invalid"><small id="fiscal-year2-error" class="error"></small></span> 
            </div>   
            <div class="form-group col">
              <label>Fiscal Year 3</label>
              <select id="budget_proposal_fiscal_year3" name="fiscal_year3" class="form-control budget-proposal-fiscal-years-field select2bs4">   
                <option value="" selected hidden>Select Fiscal Year 3</option>
                <?php $year = date('Y'); ?>
                @for($i=$year;$i<=$year+5;$i++)
                  <option value="{{ $i; }}">{{ $i; }}</option>
                @endfor              
              </select>
              <span class="is-invalid"><small id="fiscal-year3-error" class="error"></small></span> 
            </div>      
          </div> 
          <div class="row">
            <div class="form-group col">
              <label>Open Date From</label>
              <input id="open_date_from" name="open_date_from" type="date" class="date form-control budget-proposal-fiscal-years-field"/>
              <span class="is-invalid"><small id="open-date-from-error" class="error"></small></span>
            </div>     
            <div class="form-group col">
              <label>Open Date To</label>
              <input id="open_date_to" name="open_date_to" type="date" class="date form-control budget-proposal-fiscal-years-field"/>
              <span class="is-invalid"><small id="open-date-to-error" class="error"></small></span>
            </div>   
          </div>
          <div class="form-group existing_file">          
            <label>File</label>
            <div class="custom-file">
              <input type="text" id="existing_file" name="existing_file" class="date form-control budget-proposal-fiscal-years-field" readonly>
            </div>
          </div>
          <div class="form-group upload_file">          
            <label>Attach File</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input form-control" id="upload_file" name="upload_file" encype="multipart/form-data" accept='image/*,application/pdf'>
              <label class="custom-file-label choose_file_label" for="customFile"></label>
            </div>
          </div>          
          <div class="row">
            <div class="form-group form-check col">           
              <input type="checkbox" id="year_is_active" name="year_is_active" class="form-check-input budget-proposal-fiscal-years-field" 
              @foreach ($fiscal_years as $row)
                {{ $row->is_active=="yes"?true:false }}
              @endforeach>
              <label for="year_is_active" class="form-check-label">Is Active</label>
            </div>      
          </div>      
        </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>       
        <button id="add_budget_proposal_fiscal_years" type="button" class="btn btn-primary save-buttons d-none">Save</button>
        <button id="edit_budget_proposal_fiscal_years" type="button" class="update btn btn-primary save-buttons d-none" value="update">Save changes</button>
      </div>
    </div>
  </div>
</div>