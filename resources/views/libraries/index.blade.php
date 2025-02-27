@extends('layouts.app')

@section('content')
   {{ csrf_field() }}
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Utilities</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
                  <li class="breadcrumb-item active">Utilities</li>
            </ol>
            </div>
         </div>
      </div>
   </div>

   <section class="content">  
      <div class="card text-center">
         <div class="card-header">
           <ul class="nav nav-tabs" id="libraries_nav_tabs" role="tablist"> 
               @unlessrole('Budget Officer')
               <li class="nav-item">
                  <a href="#library_payees" class="nav-link active" id="library_payees_tab" data-toggle="tab" role="tab" aria-controls="library_payees" aria-selected="true">Payees</a>
               </li>   
               @endunlessrole
               @unlessrole('Accounting Officer')
               <li class="nav-item">
                  <a href="#library_pap" class="nav-link" id="library_pap_tab" data-toggle="tab" role="tab" aria-controls="library_pap" aria-selected="true">PAP Codes</a>
               </li>  
               <li class="nav-item">
                  <a href="#library_activity" class="nav-link" id="library_activity_tab" data-toggle="tab" role="tab" aria-controls="library_activity" aria-selected="true">Activities</a>
               </li>       
               <li class="nav-item">
                  <a href="#library_subactivity" class="nav-link" id="library_subactivity_tab" data-toggle="tab" role="tab" aria-controls="library_subactivity" aria-selected="true">Subactivities</a>
               </li>  
               <li class="nav-item">
                  <a href="#library_expense_account" class="nav-link" id="library_expense_account_tab" data-toggle="tab" role="tab" aria-controls="library_expense_account" aria-selected="true">Expense Accounts</a>
               </li> 
               <li class="nav-item">
                  <a href="#library_object_expenditure" class="nav-link" id="library_object_expenditure_tab" data-toggle="tab" role="tab" aria-controls="library_object_expenditure" aria-selected="true">Object Expenditures</a>
               </li>  
               <li class="nav-item">
                  <a href="#library_object_specific" class="nav-link" id="library_object_specific_tab" data-toggle="tab" role="tab" aria-controls="library_object_specific" aria-selected="true">Object Specifics</a>
               </li>
               @endunlessrole
            </ul>
         </div>         
         <div class="card-body">
           <div class="tab-content" id="libraries">  
               <div class="tab-pane fade show active" id="library_payees" role="tabpanel" aria-labelledby="library_payees_tab">
                  @include('libraries.library_payees.index')                    
               </div>             
               <div class="tab-pane fade show" id="library_pap" role="tabpanel" aria-labelledby="library_pap_tab">
                  @include('libraries.library_pap.index')                    
               </div>    
               <div class="tab-pane fade show" id="library_activity" role="tabpanel" aria-labelledby="library_activity_tab">
                  @include('libraries.library_activity.index')   
               </div>  
               <div class="tab-pane fade show" id="library_subactivity" role="tabpanel" aria-labelledby="library_subactivity_tab">
                  @include('libraries.library_subactivity.index')   
               </div> 
               <div class="tab-pane fade show" id="library_expense_account" role="tabpanel" aria-labelledby="library_expense_account_tab">
                  @include('libraries.library_expense_account.index')   
               </div> 
               <div class="tab-pane fade show" id="library_object_expenditure" role="tabpanel" aria-labelledby="library_object_expenditure_tab">
                  @include('libraries.library_object_expenditure.index')   
               </div> 
               <div class="tab-pane fade show" id="library_object_specific" role="tabpanel" aria-labelledby="library_object_specific_tab">
                  @include('libraries.library_object_specific.index')   
               </div> 
           </div>
         </div>
      </div>           
      {{-- <div class="card">
         <div class="card-header">
         </div>        
         <div class="card-body">
            <div class="row">
               <div class="col-5 col-sm-1">
                  <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical"> 
                     <a href="#library_payees" id="library_payees_tab" class="nav-link-sm active" aria-controls="library_payees role=" role="tab"   
                        data-toggle="pill" data-toggle="tab" id="library_payees_tab" aria-selected="true">Payees
                     </a>
                     <a href="#library_pap" id="library_pap_tab" class="nav-link-sm" aria-controls="library_pap" role="tab"     
                        data-toggle="pill" data-toggle="tab" id="library_pap_tab" aria-selected="true">PAP
                     </a> 
                     <a href="#library_activity" id="library_activity_tab" class="nav-link-sm" aria-controls="library_activity" role="tab"     
                        data-toggle="pill" data-toggle="tab" id="library_activity_tab" aria-selected="true">Activity
                     </a>
                     <a href="#library_subactivity" id="library_subactivity_tab" class="nav-link-sm" aria-controls="library_subactivity" role="tab"     
                        data-toggle="pill" data-toggle="tab" id="library_subactivity_tab" aria-selected="true">Subactivity
                     </a>
                     <a href="#library_expense_account" id="library_expense_account_tab" class="nav-link-sm" aria-controls="library_expense_account" role="tab"     
                        data-toggle="pill" data-toggle="tab" id="library_expense_account_tab" aria-selected="true">Expense Account
                     </a>
                     <a href="#library_object_expenditure" id="library_expenditure_tab" class="nav-link-sm" aria-controls="library_object_expenditure" role="tab"     
                        data-toggle="pill" data-toggle="tab" id="library_object_object_expenditure_tab" aria-selected="true">Object Expenditure
                     </a>
                     <a href="#library_object_specific" id="library_object_specific_tab" class="nav-link-sm" aria-controls="library_object_specific" role="tab"     
                        data-toggle="pill" data-toggle="tab" id="library_object_specific_tab" aria-selected="true">Object Specific
                     </a>
                  </div>
               </div>
               <div class="col-7 col-sm-11">
                  <div role="tabpanel" id="library_payees" class="tab-pane text-left fade in active show" 
                        data-toggle="library_payees" aria-labelledby="library_payees_tab">    
                        @include('libraries.library_payees.index') 
                     </div>
                  <div class="tab-content" id="vert-tabs-tabContent">
                     <div role="tabpanel" id="library_pap" class="tab-pane text-left fade in" 
                        data-toggle="library_pap" aria-labelledby="library_pap_tab">    
                        @include('libraries.library_pap.index') 
                     </div>    
                     <div role="tabpanel" id="library_activity" class="tab-pane text-left fade in" 
                        data-toggle="library_activity" aria-labelledby="library_activity_tab">   
                     </div>
                     <div role="tabpanel" id="library_subactivity" class="tab-pane text-left fade in" 
                        data-toggle="library_subactivity" aria-labelledby="library_subactivity_tab">   
                     </div>
                     <div role="tabpanel" id="library_expense_account" class="tab-pane text-left fade in" 
                        data-toggle="library_expense_account" aria-labelledby="library_expense_account_tab">
                     </div>
                     <div role="tabpanel" id="library_object_expenditure" class="tab-pane text-left fade in"
                        data-toggle="library_object_expenditure" aria-labelledby="library_expenditure_tab">   
                     </div>
                     <div role="tabpanel" id="library_object_specific" class="tab-pane text-left fade in"
                        data-toggle="library_object_specific" aria-labelledby="library_object_specific_tab">    
                     </div>
                  </div>
               </div>
            </div>           
         </div>
      </div>  --}}
   </section>

   @include('libraries.library_payees.modal')
   @include('libraries.library_pap.modal')
   @include('libraries.library_activity.modal')
   @include('libraries.library_subactivity.modal')
   @include('libraries.library_expense_account.modal')
   @include('libraries.library_object_expenditure.modal')
   @include('libraries.library_object_specific.modal')

@endsection
 
@section('jscript')
   <script type="text/javascript">
      $(document).ready(function(){  
         @include('libraries.library_payees.script')                     
         @include('libraries.library_pap.script')                     
         @include('libraries.library_activity.script')                     
         @include('libraries.library_subactivity.script')                     
         @include('libraries.library_expense_account.script')                     
         @include('libraries.library_object_expenditure.script')                      
         @include('libraries.library_object_specific.script')                      
         @include('scripts.common_script')          
      })
   </script>  
@endsection
 
