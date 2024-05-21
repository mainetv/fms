<!-- Obligations Modal -->
  <div class="modal fade" id="obligation_modal" tabindex="-1" role="dialog" aria-labelledby="pap_label" aria-hidden="true">
    <div class="modal-dialog modal-2xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="obligation_modal_header">View Obligations</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>  
        <div class="modal-body">  
          <div>
            <input id="pap_activity" class="font-weight-bold" style="background-color:white; border:none; width:100%;" readonly><br>
            <input id="expenditure" class="font-weight-bold" style="background-color:white; border:none; width:100%;" readonly>
          </div>   
          <input type="text" id="allotment_id" name="allotment_id" hidden>        
          <div class="table-responsive">
            <table id="obligations_by_allotment_table" class="table table-bordered text-center" style="width: 100%;">              
            </table>
          </div>
          <br>          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>            
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- END Obligations Modal -->
