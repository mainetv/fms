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
                  <li class="breadcrumb-item active">PCAARRD Budget Proposal</li>
                  <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            </div>
         </div>
      </div>
   </div>

   <section class="content">  
         <div class="card">
            <div class="card-header row">
               <div class="form-group col">
                  {{-- <form method="post" id="send_year" action="{{ route('divisions.select_year', ['year'=>$data['year_selected'], 'division'=>'D']) }}">     --}}
                  <form method="post" id="send_year" action="{{ route('divisions.postAction') }}">    
                     @csrf              
                     <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        <label for="year_selected">Year: </label>                        
                        <?php echo $year_selected = $data['year_selected']; ?> 
                        <select name="year_selected" id="year_selected" onchange="this.form.submit()">               
                           @foreach ($fiscal_years as $row)
                              <option value="{{ $row->year }}" @if(isset($row->year) && $year_selected==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
                           @endforeach    
                        </select>                                              
                     </h3>
                  </form>                   
                  <h3>Fiscal Year: 
                     @foreach ($fiscal_year_selected as $row)
                        {{ $fiscal_year1 = $row->fiscal_year1; }}-{{ $fiscal_year3 = $row->fiscal_year3; }}
                     @endforeach    
                  </h3>       
               </div>
            </div>            
            <div class="card-body">
               <div class="row">
                  <div class="col-3 col-sm-1">
                     <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                     @foreach($divisions as $row => $value)   
                        <a href="#{{ $value->division_id }}" class="nav-link" aria-controls="{{ $value->division_id }}" role="tab"     
                           data-toggle="pill" data-toggle="tab" id="{{ $value->division_id }}_tab" aria-selected="true">{{ $value->division_acronym }} 
                        </a>
                     @endforeach                     
                        {{-- <a href="#D" class="nav-link" aria-controls="D" role="tab"     
                           data-toggle="pill" id="D_tab" aria-selected="true">ACD 
                        </a>
                        <a href="#I" class="nav-link" aria-controls="I" role="tab"     
                           data-toggle="pill" id="I_tab" aria-selected="true">ARMRD 
                        </a> --}}
                     </div>
                  </div>
                  <div class="col-7 col-sm-9">
                     <div class="tab-content" id="vert-tabs-tabContent">
                     @foreach($divisions as $row => $value) 
                        <div role="tabpanel" @if($row == 0) class="tab-pane text-left fade in active show" 
                           @else class="tab-pane" @endif id="{{ $value->division_id }}" data-toggle="{{ $value->division_id }}"
                           aria-labelledby="{{ $value->division_id }}_tab">    
                           @include('budget_preparation.budget_proposals.division_tabs.index')     
                        </div>    
                     @endforeach   
                     </div>
                  </div>
               </div>           
            </div>
         </div>            
   </section>
   
		@include('budget_preparation.budget_proposals.division_tabs.modal')
@endsection
 
@section('jscript')
   <script type="text/javascript">     
      $(document).ready(function(){   
         @include('budget_preparation.budget_proposals.division_tabs.script')   
         @include('scripts.common_script')       
      })  
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
   </script>  
@endsection
 
