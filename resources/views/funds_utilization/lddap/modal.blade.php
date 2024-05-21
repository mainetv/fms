<!-- RS Modal -->
<div class="modal fade" id="attach_dv_modal" role="dialog" aria-labelledby="attach_dv_label" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="dv_form">    
        <div class="modal-header">
          <h5 class="modal-title" id="attach_dv_modal_header">Select voucher</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>         
        <div class="modal-body">
          <input type="text" id="lddap_dv_id_edit" name="lddap_dv_id_edit" hidden>
          <div class="form-group row">
            <div class="table-responsive">
              <table id="dv_table" style="width: 100%;">
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
<!-- END RS Modal -->

<!-- Payee Modal -->
<div class="modal fade" id="payee_modal" role="dialog" aria-labelledby="payee_label" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="dv_form">    
        <div class="modal-header">
          <h5 class="modal-title" id="payee_modal_header">Select payee bank account number</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>         
        <div class="modal-body">
          <input type="text" id="dv_id" name="dv_id" hidden>
          <div class="form-group row">
            <div class="table-responsive">
              <table id="payee_table" style="width: 100%;">
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
<!-- END Payee Modal -->


