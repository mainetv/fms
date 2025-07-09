<div class="content">
  <div class="row">
    <div class="col-lg-8">
      <div class="row">
        <label for="search" class="col-form-label" data-toggle="tooltip" data-placement='bottom'
          title="Search Payee by Name, TIN, Bank Account Number"><i class="fa-solid fa-magnifying-glass"></i> Payee:</label>     
        <div class="col-lg-5 float-right">
          <input type="text" id="search" name="search" class="form-control" placeholder="Search Payee (Press 'Enter' or click the 'Search' button)" autocomplete="off">
        </div>
        <div class="col-lg-5 float-left">         
          <button id="btn_search" class="btn btn-primary" value="search">Search</button>
          &emsp;
          <button id="btn_clear_search" class="btn btn-danger" data-toggle="tooltip" data-placement='auto' title="Clear Search"  value="clear">X</button>
          &emsp;
          <button id="btn_show_all" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement='auto' title="Show all payees" value="all">All</button>
          <button id="btn_show_unveried" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement='auto' title="Show unverified payees" value="unverified">Unverified</button>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <button id="btn_add" class="btn btn-success float-right">Add Payee</button>      
    </div>
  </div>
</div>
<div class="py-3">       
   <table id="tbl_payees" class="table table-sm table-bordered data-table table-hover table-responsive-sm" style="width: 100%;">
      <thead>         
         <th>ID</th>
         <th>Parent ID</th>
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