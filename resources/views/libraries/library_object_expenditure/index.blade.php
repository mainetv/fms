     
<h4>Expenditure</h4>
<div class="content">
  <div class="row">
    <div class="col">
      <button id="add_new_library_expenditure" type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#library_expenditure_modal">
        Add Expenditure
      </button>
    </div>
  </div>
</div>
<div class="row py-3">
   <div class="col table-responsive">        
      <table id="library_expenditure_table" class="table table-bordered data-table">
         <thead>
            <tr>
               <th>Expenditure</th>
               {{-- <th>Account Code</th> --}}
               {{-- <th>Expense</th> --}}
               <th>Continuing</th>  
               <th>Active</th>       
               <th>Action</th>
            </tr>     
         </thead>  
         <tbody></tbody>             
      </table>
   </div>         
</div>