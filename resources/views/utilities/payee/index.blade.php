     
{{-- <h4 class="text-center">Payees</h4> --}}
<div class="content">
  <div class="row">
    <div class="col">
      <button type="button" id="btn_add" class="btn_add btn btn-outline-primary float-left" data-toggle="modal" data-target="#library_payees_modal">
        Add Payee
      </button>
    </div>
  </div>
</div>
<div class="py-3">       
   <table id="tbl_payees" class="table table-sm table-bordered data-table table-hover table-responsive-sm" style="width: 100%;">
      <thead>
         <th>Payee</th>
         <th>TIN</th>
         <th>Bank</th>      
         <th>Bank Account Name</th>    
         <th nowrap>Bank Account No.</th>    
         <th>Verified</th>
         <th>Active</th>
         <th></th>    
      </thead>  
      <tbody></tbody>             
   </table> 
</div>