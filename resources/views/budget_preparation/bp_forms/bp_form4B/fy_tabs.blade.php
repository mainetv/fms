@extends('budget_preparation.bp_forms.index')

@section('fy_tabs')
@csrf
   <ul class="nav nav-tabs" role="tablist"  id="fy_tabs">  
      @foreach($fiscal_years as $row => $value)  
         <li class="nav-item">
            <a href="#bp_form4_{{ $value->fiscal_year }}" class="nav-link" id="bp_form4_{{ $value->fiscal_year }}_tab" 
               data-toggle="tab" role="tab" aria-controls="bp_form4_{{ $value->fiscal_year }}" aria-selected="true">
               FY {{ $value->fiscal_year }} </a>
         </li>
      @endforeach
   </ul>
   <div class="tab-content">
      @foreach($fiscal_years as $row => $value) 
         <div role="tabpanel" @if($row == 0) class="tab-pane text-center fade in active show" 
            @else class="tab-pane text-center" @endif id="bp_form4_{{ $value->fiscal_year }}" data-toggle="bp_form4_{{ $value->fiscal_year }}"
               aria-labelledby="bp_form4_{{ $value->fiscal_year }}_tab">  
               @include('budget_preparation.bp_forms.bp_form4.index')                       
         </div>   
      @endforeach 
   </div>   
@endsection  