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

         </div>         
         <div class="card-body">
           
         </div>
      </div>        
   </section>

@endsection
 
@section('jscript')
   <script type="text/javascript">
      $(document).ready(function(){  
                           
         @include('scripts.common_script')          
      })
   </script>  
@endsection
 
