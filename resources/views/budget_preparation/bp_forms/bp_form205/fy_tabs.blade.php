@extends('budget_preparation.bp_forms.index')

@section('fy_tabs')
@csrf
   <ul class="nav nav-tabs" role="tablist"  id="fy_tabs">  
      @foreach($fiscal_years_vertical as $row)  
         @php $fiscal_year1 = $row->fiscal_year1; 
               $year = $row->year; @endphp
      @endforeach 
      <li class="nav-item">
         <a href="#bp_form205_{{ $fiscal_year1 }}" class="nav-link" id="bp_form205_{{ $fiscal_year1 }}_tab" 
            data-toggle="tab" role="tab" aria-controls="bp_form205_{{ $fiscal_year1 }}" aria-selected="true">
            FY {{ $fiscal_year1 }} </a>
      </li>
   </ul>
   <div class="tab-content">
      @foreach($fiscal_years_vertical as $row) 
         @php $fiscal_year1 = $row->fiscal_year1;
               $year = $row->year; @endphp
      @endforeach 
      <div role="tabpanel" class="tab-pane text-center active show" id="bp_form205_{{ $fiscal_year1 }}" 
         data-toggle="bp_form205_{{ $fiscal_year1 }}"aria-labelledby="bp_form205_{{ $fiscal_year1 }}_tab">  
         @include('budget_preparation.bp_forms.bp_form205.index')                       
      </div>   
      
   </div>   
@endsection  