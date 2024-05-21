{{-- @role('Administrator') --}}
<h4>Fiscal Years</h4>
<div class="content">
  <div class="row">
    <div class="col">
      <button id="add_new_budget_proposal_fiscal_years" type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#budget_proposal_fiscal_years_modal">
         Add Budget Proposal Fiscal Year 
      </button>
    </div>
  </div>
</div>
<div class="row py-3">
   <div class="col table-responsive">        
      <table id="budget_proposal_fiscal_years_table" class="table table-sm table-bordered data-table table-hover table-responsive-sm">
         <thead>            
            <tr>               
               <th>Year</th>
               <th>Fiscal Year 1</th>
               <th>Fiscal Year 2</th>
               <th>Fiscal Year 3</th>
               <th>Date Open From</th>
               <th>Date Open To</th>        
               <th>File</th>        
               <th>Is Locked</th>        
               <th>Is Active</th>        
               <th width="280px">Action</th>
            </tr>     
         </thead>  
      </table>
   </div>         
</div>
{{-- @endrole --}}