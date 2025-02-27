@extends('layouts.app')

@section('content')
   {{ csrf_field() }}
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
                  <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            </div>
         </div>
      </div>
   </div>

   <section class="content">  
      <div class="card text-center">
         <div class="card-header">
           <ul class="nav nav-tabs" id="administration_nav_tabs" role="tablist">   
               <li class="nav-item">
                  <a href="#users" class="nav-link active" id="users_tab" data-toggle="tab" role="tab" aria-controls="users" aria-selected="true">User Accounts</a>
               </li>  
               <li class="nav-item">
                  <a href="#user_roles" class="nav-link" id="user_roles_tab" data-toggle="tab" role="tab" aria-controls="user_roles" aria-selected="true">User Roles</a>
               </li>         
            </ul>
         </div>
         <div class="card-body">
           <div class="tab-content" id="administration">               
               <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users_tab">
                  @include('administration.users.index')                    
               </div>    
               <div class="tab-pane fade show" id="user_roles" role="tabpanel" aria-labelledby="user_roles_tab">
                  @include('administration.user_roles.index')                    
               </div>  
           </div>
         </div>
       </div>           
   </section>

   @include('administration.users.modal')
   @include('administration.user_roles.modal')

@endsection
 
@section('jscript')
   <script type="text/javascript">
      $(document).ready(function(){  
         @include('administration.users.script')          
         @include('administration.user_roles.script')          
         @include('scripts.common_script')  
      })
   </script>  
@endsection
 
