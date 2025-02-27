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
                  <li class="breadcrumb-item active">Budget Preparation</li>
                  <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            </div>
         </div>
      </div>
   </div>

   <section class="content">
      <div class="card text-left">
         <div class="card-header">
            <h3 class="card-title">
               <i class="fas fa-edit"></i>
               <label for="year_selected">Year: </label>
               <?php $year = $data['year_selected']; ?> 
               <select name="year_selected" id="year_selected" onchange="changeYear()">               
                  @foreach ($years as $row)
                     <option value="{{ $row->year }}" @if(isset($row->year) && $year==$row->year){{"selected"}} @endif > {{ $row->year }}</option>
                  @endforeach    
               </select> 
            </h3>            
         </div>         
         <div class="card-body">
            <div class="row">
               <div class="col-1">
                  @php $subtitle == ''; @endphp
                  {{-- <ul class="nav nav-compact nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> --}}
                  <div class="nav flex-column nav-tabs h-100 flex-column" id="vert-tabs-tab" role="tablist" role="menu" aria-orientation="vertical">
                     @if($user_division_id==16 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form3') }}" 
                              @if ($subtitle == 'BP Form 3') class="nav-link active" @else class="nav-link" @endif>Form 3
                           </a>
                        </li>
                     @endif
                     @if($user_division_id==16 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form4') }}" 
                              @if ($subtitle == 'BP Form 4') class="nav-link active" @else class="nav-link" @endif>Form 4
                           </a> 
                        </li> 
                     @endif
                     @if($user_division_id==16 || $user_division_id==19 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form5') }}" 
                              @if ($subtitle == 'BP Form 5') class="nav-link active" @else class="nav-link" @endif>Form 5
                           </a> 
                        </li> 
                     @endif
                     @if($user_division_id==16 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form6') }}" 
                              @if ($subtitle == 'BP Form 6') class="nav-link active" @else class="nav-link" @endif>Form 6
                           </a> 
                        </li> 
                     @endif
                     @if($user_division_id==20 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form7') }}" 
                              @if ($subtitle == 'BP Form 7') class="nav-link active" @else class="nav-link" @endif>Form 7
                           </a> 
                        </li> 
                     @endif
                     @if($user_division_id==23 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form8') }}" 
                              @if ($subtitle == 'BP Form 8') class="nav-link active" @else class="nav-link" @endif>Form 8
                           </a> 
                        </li> 
                     @endif
                     @if($user_division_id==16 || $user_division_id==2 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form9') }}" 
                              @if ($subtitle == 'BP Form 9') class="nav-link active" @else class="nav-link" @endif>Form 9
                           </a> 
                        </li> 
                     @endif
                     @if($user_division_id==12 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form205') }}" 
                              @if ($subtitle == 'BP Form 205') class="nav-link active" @else class="nav-link" @endif>Form 205
                           </a> 
                        </li> 
                     @endif
                     {{-- @if($user_division_id==16 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form4B_tier1') }}" 
                              @if ($subtitle == 'BP Form 4B Tier 1') class="nav-link active" @else class="nav-link" @endif>Form 4B <br>Tier 1
                           </a> 
                        </li> 
                     @endif
                     @if($user_division_id==16 || $user_role_id==3 || $user_division_id==21 || $user_role_id==8 || $user_role_id==9 || $user_role_id==10 || $user_role_id==0 || $user_role_id==1)
                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.$year.'/bp_form4B_tier2') }}" 
                              @if ($subtitle == 'BP Form 4B Tier 2') class="nav-link active" @else class="nav-link" @endif>Form 4B <br>Tier 2
                           </a> 
                        </li> 
                     @endif --}}
                  </div>
               </div>
               <div class="col-11">
                  <div class="tab-content" id="vert-tabs-tabContent">
                     <div role="tabpanel" class="tab-pane text-left fade in active show">    
                        @yield('fy_tabs')                         
                     </div>    
                  </div>
               </div>
               @include('budget_preparation.bp_forms.bp_form3.modal') 
               @include('budget_preparation.bp_forms.bp_form4.modal') 
               @include('budget_preparation.bp_forms.bp_form5.modal') 
               @include('budget_preparation.bp_forms.bp_form6.modal') 
               @include('budget_preparation.bp_forms.bp_form7.modal') 
               @include('budget_preparation.bp_forms.bp_form8.modal') 
               @include('budget_preparation.bp_forms.bp_form9.modal') 
               @include('budget_preparation.bp_forms.bp_form205.modal') 
            </div>           
         </div>
      </div>
   </section>            
@endsection

@section('jscript')
   <script type="text/javascript" defer>
      $(document).ready(function(){
         @include('budget_preparation.bp_forms.bp_form3.script');       
         @include('budget_preparation.bp_forms.bp_form4.script');       
         @include('budget_preparation.bp_forms.bp_form5.script');       
         @include('budget_preparation.bp_forms.bp_form6.script');       
         @include('budget_preparation.bp_forms.bp_form7.script');       
         @include('budget_preparation.bp_forms.bp_form8.script');       
         @include('budget_preparation.bp_forms.bp_form9.script');       
         @include('budget_preparation.bp_forms.bp_form205.script');       
         @include('scripts.common_script');   
         
         $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
         });
         var hash = window.location.hash;
         $('#fy_tabs a[href="' + hash + '"]').tab('show');
      });
      function changeYear()
		{
			year = $("#year_selected").val();
			window.location.replace("{{ url('budget_preparation/bp_forms') }}/"+year);
		}
   </script>
@endsection

