
@extends('layouts.app')

@php
   $status_id = 0;
	$getAllDivisions=getAllDivisions();
	$getYears=getYears();
	$getRSTypes=getRSTypes();
	$getUserDivisionID=getUserDivisionID($user_id);
	$getAllotmentActiveStatus=getAllotmentActiveStatus($year_selected);
	if($user_role_id==7){
		$division_id=$getUserDivisionID;
	}
	$emp_code = DB::table('view_users')->where('id', $user_id)->pluck('emp_code')->first();     
   foreach($getAllotmentActiveStatus as $row){	
      $status=$row->status;
      $status_id=$row->status_id;
   }
@endphp

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
                  <li class="breadcrumb-item active">Programming & Allocation</li>
                  <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            </div>
         </div>
      </div>
   </div>

   <section class="content">  
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-8">                              
                  <h3 class="card-title">
                     <i class="fas fa-edit"></i>                      
                     <?php $rstype_id_selected = $data['rstype_id_selected']; ?> 
                     <select name="rstype_id_selected" id="rstype_id_selected" onchange="changeFilter()">               
                        @foreach ($getRSTypes as $row)
                           <option value="{{ $row->id }}" @if(isset($row->id) && $rstype_id_selected==$row->id){{"selected"}} @endif > {{ $row->request_status_type }}</option>
                        @endforeach    
                     </select>
                     <label for="year_selected">Year: </label>                        
                     <?php $year_selected = $data['year_selected']; ?> 
                     <select name="year_selected" id="year_selected" onchange="changeFilter()">       
                        @if($rstype_id_selected!=1)
                           <option value="all">All</option>
                        @else
                           @foreach ($getYears as $row)
                              <option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
                           @endforeach    
                        @endif     
                     </select>  
                     <?php $view_selected = $data['view_selected']; ?> 
                     <label for="view_selected">View: </label>  
                     <select name="view_selected" id="view_selected" onchange="changeFilter()">      
                        <option value="annual" @if ($view_selected == 'annual') selected="true" @endif>Annual</option>   
                        @if($rstype_id_selected==1)
                           <option value="q1" @if ($view_selected == 'q1') selected="true" @endif>Q1</option>         
                           <option value="q2" @if ($view_selected == 'q2') selected="true" @endif>Q2</option>         
                           <option value="q3" @if ($view_selected == 'q3') selected="true" @endif>Q3</option>         
                           <option value="q4" @if ($view_selected == 'q4') selected="true" @endif>Q4</option>      
                        @endif   
                     </select>                                            
                  </h3>
               </div> 
               <div class="float-right col-4">  
                  @if($status_id==22) 
                     <button type="button" data-year="{{ $year_selected }}"  data-toggle="modal" 									
                        class="btn btn-primary float-right btn_forward" data-target="#forward_modal">
                        Forward {{ $year_selected }} activities/object to NEP Preparation FY {{ $year_selected+1 }}</button>
                  @endif
               </div> 
            </div>
         </div>        
         <div class="card-body">
            <div class="row">
               <div class="col-5 col-sm-1">
                  <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  @foreach($divisions as $row => $value)   
                     <a href="#{{ $value->division_code }}" class="nav-link-sm" aria-controls="{{ $value->division_code }}" role="tab"     
                       data-toggle="pill" data-toggle="tab" id="{{ $value->division_code }}tab" >{{ $value->division_acronym }} 
                     </a>
                  @endforeach  
                  </div>
               </div>
               <div class="col-7 col-sm-11">
                  <div class="tab-content" id="vert-tabs-tabContent">
                  @foreach($divisions as $row => $value) 
                     <div role="tabpanel" @if($row == 0) class="tab-pane text-left fade in active show" 
                        @else class="tab-pane" @endif id="{{ $value->division_code }}" data-toggle="{{ $value->division_code }}"
                           aria-labelledby="{{ $value->division_code }}_tab">    
                        @include('programming_allocation.allotment.division_tabs_content') 
                     </div>   
                  @endforeach   
                  </div>
               </div>
            </div>           
         </div>
      </div>            
   </section>
   
	@include('programming_allocation.allotment.modal')
@endsection
 
@section('jscript')
   <script type="text/javascript">   
      $(document).ready(function(){ 
         @include('programming_allocation.allotment.script')   
         @include('scripts.common_script')   

			// $('.select2bs4').select2({
			// 	theme: 'bootstrap4'
			// })     

			// $(document).on('select2:open', () => {
         // 	document.querySelector('.select2-search__field').focus();
      	// });  
         // $(document).on('select2:open', () => {
         //       alert('test');
         //       document.querySelector(".select2-container--open .select2-search__field").focus()
         //    }); 
      })
      $(function() {   
         // store the currently selected tab in the hash value
         $("div.nav-tabs > a").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;  
         });

         // on load of the page: switch to the currently selected tab
         var hash = window.location.hash;
         $('#vert-tabs-tab a[href="' + hash + '"]').tab('show');
      });

      function changeFilter()
		{         
			rstype_id_selected = $("#rstype_id_selected").val();
         year_selected = $("#year_selected").val();
         view_selected = $("#view_selected").val();
         if(rstype_id_selected==1 && year_selected=='all'){
            const d = new Date();
            year_selected = d.getFullYear();            
         }
         else if(rstype_id_selected!=1){            
            year_selected = 'all';
         }      
         hash = window.location.hash;
			window.location.replace("{{ url('programming_allocation/allotment') }}/"+rstype_id_selected+"/"+year_selected+"/"+view_selected+hash);
		}		
   </script>  
@endsection
 
