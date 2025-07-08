<!-- RS Modal -->
<div class="modal fade" id="attach_rs_modal" role="dialog" aria-labelledby="attach_rs_label" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="rs_form">    
        <div class="modal-header">
          <h5 class="modal-title" id="attach_rs_modal_header">Select request and status to attach</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>         
        <div class="modal-body">
          <input type="text" id="dv_rs_id_edit" name="dv_rs_id_edit" hidden>
          <div class="form-group row">
            <div class="table-responsive">
              <table id="rs_by_payee_table" style="width: 100%;">
                <tbody>
                </tbody>
              </table>
            </div>               
          </div>
        </div>    
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="chart_account_modal" role="dialog" aria-labelledby="chart_account_label" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="rs_form">    
        <div class="modal-header">
          <h5 class="modal-title" id="chart_account_modal_header">Select chart of account to add</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>         
        <div class="modal-body">             
          <div class="form-group row">    
            <div class="row mb-3">
              <div class="col-md-3">
                <label for="filter_level_min">Level From</label>
                <select id="filter_level_min" class="form-control">
                  <option value="">Any</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>

              <div class="col-md-3">
                <label for="filter_level_max">Level To</label>
                <select id="filter_level_max" class="form-control">
                  <option value="">Any</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>

              <div class="col-md-3">
                <label for="filter_uacs">UACS Search</label>
                <input type="text" id="filter_uacs" class="form-control" placeholder="e.g., 10102010">
              </div>

              <div class="col-md-3 d-flex align-items-end">
                <button type="button" id="reset_filters" class="btn btn-secondary w-100">Reset Filters</button>
              </div>
            </div>        
            <div class="table-responsive">
              <div id="sticky-preview" class="sticky-top bg-white border-bottom p-2" style="display: none; z-index: 2;"></div>
              <table id="tbl_chart_accounts" style="width: 100%;">
                <tbody>
                </tbody>
              </table>              
            </div>               
          </div>
          <button id="btn-back-to-top" class="btn btn-secondary" style="display:none; position: absolute; bottom: 10px; right: 20px; z-index: 1050;">
            ↑ Back to Top
          </button>
        </div>    
      </form>
    </div>
  </div>
</div>
<!-- END RS Modal -->


