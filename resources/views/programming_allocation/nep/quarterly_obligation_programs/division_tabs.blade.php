@extends('layouts.app')

@section('content')
   @csrf
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Quarterly Obligation Program</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
                  <li class="breadcrumb-item active">Programming & Allocation</li>
                  <li class="breadcrumb-item active">NEP</li>
                  <li class="breadcrumb-item active">Quarterly Obligation Program</li>
            </ol>
            </div>
         </div>
      </div>
   </div>
   @php
      $qop_id = 0;
      $active_status_id = 0;
      $fiscal_year1 = '';
      $fiscal_year2 = '';
      $fiscal_year3 = '';	
      $getUserDetails = getUserDetails($user_id);						
      foreach ($getUserDetails as $key => $value) {
         $user_id = $value->id;
         $emp_code = $value->emp_code;
         $user_parent_division_id = $value->parent_division_id;
         $user_division_id = $value->division_id;
         $user_division_acronym = $value->division_acronym;
         $user_cluster_id = $value->cluster_id;
         $user_role_id = $value->user_role_id;
      }
      $getYears=getYears();
      $getYearsV=getYearsV($year_selected);
      $getLibraryPAP=getLibraryPAP();
      $getLibraryActivities=getLibraryActivities($user_division_id);
      $getLibraryExpenseAccounts=getLibraryExpenseAccounts();
      $getLibraryObjectExpenditures=getLibraryObjectExpenditures();	
   @endphp
   <section class="content">  
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-5">                             
                  <h3 class="card-title">
                     <i class="fas fa-edit"></i>
                     <label for="year_selected">Year: </label>           
                     <select name="year_selected" id="year_selected" onchange="changeYear()">               
                        @foreach ($getYears as $row)
                           <option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
                        @endforeach    
                     </select>                                              
                  </h3>
               </div> 
               <div class="col-5">               
                  <h3>FY 
                     @foreach ($getYearsV as $row)
                        {{ $row->fiscal_year1; }}
                     @endforeach    
                  </h3>     
               </div>  
            </div>
         </div>        
         <div class="card-body">
            <div class="row">
               <div class="col-5 col-sm-1">
                  <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  @foreach($divisions as $row => $value)   
                     <a href="#{{ $value->division_code }}" class="nav-link-sm" aria-controls="{{ $value->division_code }}" role="tab"     
                        data-toggle="pill" data-toggle="tab" id="{{ $value->division_code }}_tab" aria-selected="true">{{ $value->division_acronym }} 
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
                        @include('programming_allocation.nep.quarterly_obligation_programs.division_tabs_content') 
                     </div>   
                  @endforeach   
                  </div>
               </div>
            </div>           
         </div>
      </div>            
   </section>
   @include('programming_allocation.nep.quarterly_obligation_programs.modal')
@endsection
 
@section('jscript')
   <script type="text/javascript">     
      $(document).ready(function(){   
         @include('programming_allocation.nep.quarterly_obligation_programs.script')   
         @include('scripts.common_script') 
      })  
      $(document).on('select2:open', () => {
         document.querySelector('.select2-search__field').focus();
      });
      $(function() {
         $('#vert-tabs-tab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
         });

         // store the currently selected tab in the hash value
         $("div.nav-tabs > a").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
         });

         // on load of the page: switch to the currently selected tab
         var hash = window.location.hash;
         $('#vert-tabs-tab a[href="' + hash + '"]').tab('show');
      });
      function changeYear()
		{         
			year = $("#year_selected").val();
			window.location.replace("{{ url('programming_allocation/nep/quarterly_obligation_program/divisions') }}/"+year);
		}
   </script>  
@endsection
 
