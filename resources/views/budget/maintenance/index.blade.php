@extends('layouts.app')

@section('content')
   @csrf   
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
                  <li class="breadcrumb-item active">Budget Section</li>
                  <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            </div>
         </div>
      </div>
   </div>

   <section class="content">
      <div class="card text-center">    
         <div class="card-header">
           <ul class="nav nav-tabs" id="maintenance_nav_tabs" role="tablist">
               <li class="nav-item">
                  <a href="#fiscal_years" class="nav-link active" id="fiscal_years_tab" data-toggle="tab" role="tab" aria-controls="fiscal_years" aria-selected="true">Fiscal Years</a>
               </li>
            </ul>
         </div>
         <div class="card-body">
           <div class="tab-content" id="maintenance">
               <div class="tab-pane fade show active" id="fiscal_years" role="tabpanel" aria-labelledby="fiscal_years_tab">
                  @include('budget.maintenance.fiscal_year.index')
               </div>
           </div>
         </div>
      </div>
   </section>

   @include('budget.maintenance.fiscal_year.modal') 

@endsection
 
@section('jscript')
   <script type="text/javascript"> 
      $(document).ready(function(){           
         @include('budget.maintenance.fiscal_year.script')       
         @include('scripts.common_script')       
      })  
   </script>  
@endsection
 
