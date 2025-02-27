<section class="content">  
   <div class="card text-center">
      <div class="card-header">
         <div class="row">
            {{-- <label for="acct" class="col-lg-3 col-form-label">Bank Account Number:</label>
            <div class="col-lg-4">
               <input type="text" id="search" name="search" class="form-control" placeholder="Bank Account Number">
            </div>     
            <div class="col-lg-3">
               <button class="btn btn-primary">Search</button>
            </div>   --}}
            
            <label for="search" class="col-form-label" data-toggle="tooltip" data-placement='auto' title="Search Payee by Bank Account Numnber"><i class="fa-solid fa-magnifying-glass"></i> Bank Account Number:</label>		
            <div class="col-sm-3 float-right">															
               <input type="text" id="search" name="search" class="form-control" placeholder="Bank Account Number">
            </div>	
            <div class="col-sm-1 float-left">	
               <button id="btn_search" class="btn btn-primary">Search</button>		
            </div>
            <label id="no_records_message" class="text-danger d-none col-form-label">No records found.</label>&emsp;
            <button id="btn_add" class="btn btn-success d-none">Add Payee</button>
         </div>         
      </div>         
      <div class="card-body">
         <div class="row py-2">
            <div class="col table-responsive">
               <table id="tbl_payees" class="table table-sm table-bordered data-table table-hover table-responsive-sm d-none" style="width: 100%;">
                  <thead>
                     <th width="40%">Payee Name</th>
                     <th>Bank Name</th>
                     <th>Bank Account Name</th>
                     <th>Bank Account Number</th>
                     <th>Verified</th>
                     <th>Active</th>
                     <th></th>
                  </thead>
               </table>	 
            </div>    
         </div>	
      </div>
   </div>        
</section>


