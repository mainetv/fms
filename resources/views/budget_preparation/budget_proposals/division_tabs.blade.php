@extends('layouts.app')

@section('content')
   @csrf
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
                  <li class="breadcrumb-item active">Budget Preparation</li>
                  <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            </div><!-- /.col -->
         </div>
      </div>
   </div>

   <section class="content">  
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-5">
                     @csrf              
                     <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        <label for="year_selected">Year: </label>                        
                        @php 
                           $year = $data['year_selected'];
                        @endphp 
                        <select name="year_selected" id="year_selected" onchange="changeYear()">               
                           @foreach ($years as $row)
                              <option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
                           @endforeach    
                        </select>                                              
                     </h3>
                  {{-- </form>   --}}
               </div> 
               <div class="col-4">               
                  <h3>Fiscal Year: 
                     @foreach ($fiscal_years_vertical as $row)
                        {{ $fiscal_year1 = $row->fiscal_year1; }} - {{ $fiscal_year3 = $row->fiscal_year3; }}
                        @php $fiscal_year2 = $row->fiscal_year2; @endphp
                     @endforeach    
                  </h3>     
               </div> 
               <div class="col-3"> 
                  <?php $sqlBpCount = getBpCompleteCount($year_selected); 
                     $bp_count = $sqlBpCount->count();
                     $divisions_count = $divisions->count();
                     if($bp_count==$divisions_count){?>
                        @role('Budget Officer')
                           <button type="button" data-year="{{ $year_selected }}" data-toggle="modal" 	
                              class="btn btn-primary float-right btn_send_email" data-target="#send_email_modal">Send Email to BPAC								
                           </button>
                        @endrole	 <?php
                     }
                  ?>
                  
               </div> 
            </div>
         </div>        
         <div class="card-body">
            <div class="row" id="tabs1" >
               <div class="col-5 col-sm-1">
                  <div class="nav flex-column nav-tabs h-100 navbar-fixed" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
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
                        @include('budget_preparation.budget_proposals.division_tabs_content') 
                     </div>   
                  @endforeach   
                  </div>
               </div>  
            </div>           
         </div>
      </div>            
   </section> 
   <?php $sqlParentDivision = getUserParentDivisionID($value->id); 
      // foreach ($sqlParentDivision as $key => $row) {
      //    echo $row->id;
      // }
      // $value->division_code;
   ?>
	@include('budget_preparation.budget_proposals.modal')
@endsection
 
@section('jscript')
   <script type="text/javascript">     
      $(document).ready(function(){   
         @include('budget_preparation.budget_proposals.script')   
         @include('scripts.common_script') 
      })  
      $(document).on('select2:open', () => {
         document.querySelector('.select2-search__field').focus();
      });
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
      function changeYear()
		{         
			year = $("#year_selected").val();
			window.location.replace("{{ url('budget_preparation/budget_proposal/divisions') }}/"+year);
		}		
   </script>  
@endsection
 
