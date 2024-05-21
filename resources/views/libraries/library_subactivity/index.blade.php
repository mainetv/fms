     
<h4>Subactivity</h4>
<div class="content">
  <div class="row">
    <div class="col">
      <button id="add_new_library_subactivity" type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#library_subactivity_modal">
        Add Subactivity
      </button>
    </div>
  </div>
</div>
<div class="row py-3">
   <div class="col table-responsive">        
      <table id="library_subactivity_table" class="table table-bordered data-table">
         <thead>
            <tr>
               <th>Subactivity</th>
               <th>Description</th>                
               {{-- <th>Request and Status Type</th>   --}}
               {{-- <th>Continuing</th>      --}}
               <th>Active</th>       
               <th>Action</th>
            </tr>     
         </thead>  
         <tbody></tbody>             
      </table>
   </div>         
</div>