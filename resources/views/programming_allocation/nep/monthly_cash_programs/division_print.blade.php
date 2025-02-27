
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - Monthly Cash Program</title>
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}" media="all">
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-6.1.1-web/css/all.min.css') }}">
		<style>
         td{
            font-size: 13px;
         }
         .mheader{
            font-size: 20px;
         }
			.subheader {
				font-size: 14px;
			} 
         .right-subheader {
				font-size: 11px;
			} 
		</style>
		<SCRIPT LANGUAGE="JavaScript">
			function printThis()
			{
            var css = '@page { size: landscape; }',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet){
            style.styleSheet.cssText = css;
            } else {
            style.appendChild(document.createTextNode(css));
            }

            head.appendChild(style);

				window.print();
			}
		</script>
	</head>
	<body>
      <?php
         $division = '';
         $fiscal_year1 = '';
         $user_id = auth()->user()->id; 
         $getUserDetails = getUserDetails($user_id);						
         foreach ($getUserDetails as $key => $value) {
            $emp_code = $value->emp_code;
            $parent_division_id = $value->parent_division_id;
            $user_division_id = $value->division_id;
            $division_acronym = $value->division_acronym;
            $cluster_id = $value->cluster_id;
            $user_role = $value->user_role;
            $user_fullname = $value->fullname_last;
         }			
         if($parent_division_id==5){
            $user_division_director = App\Models\ViewUsersHasRolesModel::where('parent_division_id', $parent_division_id)
               ->Where('user_role_id',6)
               ->where('is_active',1)->where('is_deleted',0)->pluck('fullname_last')->first(); 
            $division = 'Finance & Administrative Division';	    
         }
         else{
            $user_division_director = App\Models\ViewUsersHasRolesModel::where('division_id', $user_division_id)
               ->where('role_id',6)
               ->where('is_active',1)->where('is_deleted',0)->pluck('fullname_last')->first(); 
              
         } 
         $getYearsV = getYearsV($year);	  
         foreach($getYearsV as $row){
            $fiscal_year1 = $row->fiscal_year1;
         }
         $sqlCP = getMonthlyCashProgram($division_id, $year);	  
         foreach($sqlCP as $row){
            $division_acronym = $row->division_acronym;
            $division = $row->division;
         }
      ?>
      <button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
      <table class="table-bordered" style="width: 100%; border:1px;">
         <tr>
            <th rowspan="4" class="text-center"><img src="{{ asset('/images/dost-pcaarrd-logo.png') }}" alt="" width="80px"></th>
            <th colspan="12" class="text-center">PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC, AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</th>
            <th class="text-left right-subheader" colspan="3">DOCUMENT CODE</th>
            <th class="right-subheader text-center" colspan="3">QMSF-FADBD-07-01-03</th>
         </tr>
         <tr class="text-center">
            <th colspan="12" rowspan="3" >MONTHLY CASH PROGRAM<br>For the Calendar Year {{ $fiscal_year1 }}</th>
            <th class="text-left right-subheader" colspan="3">REVISION NUMBER</th>
            <th class="right-subheader" colspan="3">0</th>
         </tr>      
         <tr class="right-subheader">
            <th class="text-left" colspan="3">PAGE NUMBER</th>
            <th class="text-center" colspan="3">1 of 1</th>
         </tr>
         <tr class="right-subheader">
            <th class="text-left" colspan="3">EFFECTIVITY DATE</th>
            <th class="text-center" colspan="3">MAY 2, 2018</th>
         </tr> 
      </table>
      <table id="monthly_cash_program_table" class="table-bordered table-hover" style="width: 100%; border:1px;">
         <thead>
            <tr class="mheader font-weight-bolder text-center">
               <th colspan="19">{{ $division }}</th>
            </tr> 
            <tr class="text-center subheader">
               <th rowspan="4" colspan="2">P/A/P / OBJECT OF EXPENDITURES</th>
               <th rowspan="4" style="min-width: 80px">ANNUAL <br>CASH PROGRAM</th>
               <tr class="text-center subheader">
                  <th colspan="16">BREAKDOWN OF ANNUAL PROGRAM</th>
               </tr>
               <tr class="text-center subheader">
                  <th colspan="4">FIRST QUARTER</th> 
                  <th colspan="4">SECOND QUARTER</th> 
                  <th colspan="4">THIRD QUARTER</th> 
                  <th colspan="4">FOURTH QUARTER</th> 
               </tr>
               <tr class="subheader text-center">             
                  <th style="min-width:50px">JAN</th>
                  <th style="min-width:50px">FEB</th>
                  <th style="min-width:50px">MAR</th>										
                  <th style="min-width:50px">Q1</th>	
                  <th style="min-width:50px">APR</th>										
                  <th style="min-width:50px">MAY</th>										
                  <th style="min-width:50px">JUN</th>										
                  <th style="min-width:50px">Q2</th>	
                  <th style="min-width:50px">JUL</th>										
                  <th style="min-width:50px">AUG</th>										
                  <th style="min-width:50px">SEP</th>										
                  <th style="min-width:50px">Q3</th>	
                  <th style="min-width:50px">OCT</th>										
                  <th style="min-width:50px">NOV</th>										
                  <th style="min-width:50px">DEC</th>		
                  <th style="min-width:50px">Q4</th>	
               </tr>  	
            </tr>
         </thead>
         <tbody> <?php
            if($division_id==5){
               $data = DB::table('view_monthly_cash_programs')->where('year', $year)
                  ->where('parent_division_id', $division_id)->where('is_active', 1)->where('is_deleted', 0)
                  ->where('is_active', 1)->where('is_deleted', 0)
                  ->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
                  ->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
                  ->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
                  ->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
                  ->groupBy('id')->get();
            }
            else{
               $data = DB::table('view_monthly_cash_programs')->where('year', $year)
                  ->where('division_id', $division_id)
                  ->where('is_active', 1)->where('is_deleted', 0)
                  ->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
                  ->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
                  ->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
                  ->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
                  ->groupBy('id')->get();
            }
            foreach($data->groupBY('allotment_class_id') as $key=>$row){			
               foreach($row as $item) {} //item?>
               <tr>
                  <td class="font-weight-bold" colspan="19">{{ $item->allotment_class }} ({{ $item->allotment_class_acronym }})</td>													
               </tr><?php
               foreach($data->where('allotment_class_id', $item->allotment_class_id)->groupBY('pap_code') as $key1=>$row1){
                  foreach($row1 as $item1) {} //item 1?>
                  <tr>
                     <td class="pap font-weight-bold gray1-bg" colspan="19">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
                  </tr><?php 		
                  foreach($data->where('allotment_class_id', $item->allotment_class_id)
                     ->where('pap_id', $item1->pap_id)
                     ->groupBY('activity_id') as $key2=>$row2){
                     foreach($row2 as $item2) {} //item 2?>
                     <tr>
                        <td class="activity1 font-weight-bold" colspan="19">{{ $item2->activity }}</td>													
                     </tr><?php 										
                     foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
                        ->where('activity_id', $item2->activity_id)
                        ->groupBY('subactivity_id') as $key3=>$row3){
                        foreach($row3 as $item3) {} 
                        if(isset($item3->subactivity)){//item 3?>
                           <tr>
                              <td class="subactivity1 font-weight-bold" colspan="19">{{ $item3->subactivity }}</td>													
                           </tr><?php 
                        }	
                        foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
                           ->where('activity_id', $item2->activity_id)
                           ->where('subactivity_id', $item3->subactivity_id)
                           ->groupBY('expense_account_id') as $key4=>$row4){
                           foreach($row4 as $item4) {}//item 4
                           $jan_expense_total=$row4->sum('jan_amount');
                           $feb_expense_total=$row4->sum('feb_amount');
                           $mar_expense_total=$row4->sum('mar_amount');
                           $apr_expense_total=$row4->sum('apr_amount');
                           $may_expense_total=$row4->sum('may_amount');
                           $jun_expense_total=$row4->sum('jun_amount');
                           $jul_expense_total=$row4->sum('jul_amount');
                           $aug_expense_total=$row4->sum('aug_amount');
                           $sep_expense_total=$row4->sum('sep_amount');
                           $oct_expense_total=$row4->sum('oct_amount');
                           $nov_expense_total=$row4->sum('nov_amount');
                           $dec_expense_total=$row4->sum('dec_amount');										
                           $q1_expense_total=$jan_expense_total + $feb_expense_total + $mar_expense_total;										
                           $q2_expense_total=$apr_expense_total + $may_expense_total + $jun_expense_total;										
                           $q3_expense_total=$jul_expense_total + $aug_expense_total + $sep_expense_total;										
                           $q4_expense_total=$oct_expense_total + $nov_expense_total + $dec_expense_total;										
                           $annual_expense_total=$q1_expense_total + $q2_expense_total + $q3_expense_total + $q4_expense_total;?>
                           <tr>
                              <td class="expense1 font-weight-bold" colspan="19">{{ $item4->expense_account }}</td>														
                           </tr>
                           <?php
                           foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
                              ->where('activity_id', $item2->activity_id)
                              ->where('subactivity_id', $item3->subactivity_id)
                              ->where('expense_account_id', $item4->expense_account_id)
                              ->whereNull('object_specific_id')
                              ->groupBY('id') as $key5=>$row5){
                              foreach($row5 as $item5) {}//item 4
                              $jan_amount=$item5->jan_amount;
                              $feb_amount=$item5->feb_amount;
                              $mar_amount=$item5->mar_amount;
                              $apr_amount=$item5->apr_amount;
                              $may_amount=$item5->may_amount;
                              $jun_amount=$item5->jun_amount;
                              $jul_amount=$item5->jul_amount;
                              $aug_amount=$item5->aug_amount;
                              $sep_amount=$item5->sep_amount;
                              $oct_amount=$item5->oct_amount;
                              $nov_amount=$item5->nov_amount;
                              $dec_amount=$item5->dec_amount;										
                              $q1_amount=$jan_amount + $feb_amount + $mar_amount;										
                              $q2_amount=$apr_amount + $may_amount + $jun_amount;										
                              $q3_amount=$jul_amount + $aug_amount + $sep_amount;										
                              $q4_amount=$oct_amount + $nov_amount + $dec_amount;										
                              $annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
                              <tr class="text-right">
                                 <td class="objexp1" colspan="2">{{ $item5->object_expenditure }}</td>		
                                 <td>{{ number_format($annual_amount, 2) }}</td>											 
                                 <td>{{ number_format($jan_amount, 2) }}</td>
                                 <td>{{ number_format($feb_amount, 2) }}</td>
                                 <td>{{ number_format($mar_amount, 2) }}</td>														
                                 <td>{{ number_format($q1_amount, 2) }}</td>														
                                 <td>{{ number_format($apr_amount, 2) }}</td>														
                                 <td>{{ number_format($may_amount, 2) }}</td>														
                                 <td>{{ number_format($jun_amount, 2) }}</td>														
                                 <td>{{ number_format($q2_amount, 2) }}</td>														
                                 <td>{{ number_format($jul_amount, 2) }}</td>														
                                 <td>{{ number_format($aug_amount, 2) }}</td>														
                                 <td>{{ number_format($sep_amount, 2) }}</td>														
                                 <td>{{ number_format($q3_amount, 2) }}</td>														
                                 <td>{{ number_format($oct_amount, 2) }}</td>														
                                 <td>{{ number_format($nov_amount, 2) }}</td>														
                                 <td>{{ number_format($dec_amount, 2) }}</td>		
                                 <td>{{ number_format($q4_amount, 2) }}</td>											
                              </tr><?php
                           }
                           foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
                              ->where('activity_id', $item2->activity_id)
                              ->where('subactivity_id', $item3->subactivity_id)
                              ->where('expense_account_id', $item4->expense_account_id)
                              ->whereNotNull('object_specific_id')
                              ->groupBY('object_expenditure_id') as $key5=>$row5){
                              foreach($row5 as $item5) {}//item 4
                              $jan_amount=$item5->jan_amount;
                              $feb_amount=$item5->feb_amount;
                              $mar_amount=$item5->mar_amount;
                              $apr_amount=$item5->apr_amount;
                              $may_amount=$item5->may_amount;
                              $jun_amount=$item5->jun_amount;
                              $jul_amount=$item5->jul_amount;
                              $aug_amount=$item5->aug_amount;
                              $sep_amount=$item5->sep_amount;
                              $oct_amount=$item5->oct_amount;
                              $nov_amount=$item5->nov_amount;
                              $dec_amount=$item5->dec_amount;										
                              $q1_amount=$jan_amount + $feb_amount + $mar_amount;										
                              $q2_amount=$apr_amount + $may_amount + $jun_amount;										
                              $q3_amount=$jul_amount + $aug_amount + $sep_amount;										
                              $q4_amount=$oct_amount + $nov_amount + $dec_amount;										
                              $annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;
                              if($item5->object_specific_id != NULL){?>
                                 <tr>
                                    <td class="objexp1" colspan="19">{{ $item5->object_expenditure }}</td>														
                                 </tr><?php
                                 foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
                                    ->where('activity_id', $item2->activity_id)
                                    ->where('subactivity_id', $item3->subactivity_id)
                                    ->where('expense_account_id', $item4->expense_account_id)
                                    ->where('object_expenditure_id', $item5->object_expenditure_id)
                                    ->whereNotNull('object_specific_id')
                                    ->groupBY('id') as $key6=>$row6){
                                    foreach($row6 as $item6) {}//item 4
                                    $item6_id = $item6->id;
                                    $jan_amount=$item6->jan_amount;
                                    $feb_amount=$item6->feb_amount;
                                    $mar_amount=$item6->mar_amount;
                                    $apr_amount=$item6->apr_amount;
                                    $may_amount=$item6->may_amount;
                                    $jun_amount=$item6->jun_amount;
                                    $jul_amount=$item6->jul_amount;
                                    $aug_amount=$item6->aug_amount;
                                    $sep_amount=$item6->sep_amount;
                                    $oct_amount=$item6->oct_amount;
                                    $nov_amount=$item6->nov_amount;
                                    $dec_amount=$item6->dec_amount;										
                                    $q1_amount=$jan_amount + $feb_amount + $mar_amount;										
                                    $q2_amount=$apr_amount + $may_amount + $jun_amount;										
                                    $q3_amount=$jul_amount + $aug_amount + $sep_amount;										
                                    $q4_amount=$oct_amount + $nov_amount + $dec_amount;										
                                    $annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
                                    <tr class="text-right">
                                       <td class="objspe1 font-italic" colspan="2">{{ $item6->object_specific }}</td>		
                                       <td>{{ number_format($annual_amount, 2) }}</td>											 
                                       <td>{{ number_format($jan_amount, 2) }}</td>
                                       <td>{{ number_format($feb_amount, 2) }}</td>
                                       <td>{{ number_format($mar_amount, 2) }}</td>														
                                       <td>{{ number_format($q1_amount, 2) }}</td>														
                                       <td>{{ number_format($apr_amount, 2) }}</td>														
                                       <td>{{ number_format($may_amount, 2) }}</td>														
                                       <td>{{ number_format($jun_amount, 2) }}</td>														
                                       <td>{{ number_format($q2_amount, 2) }}</td>														
                                       <td>{{ number_format($jul_amount, 2) }}</td>														
                                       <td>{{ number_format($aug_amount, 2) }}</td>														
                                       <td>{{ number_format($sep_amount, 2) }}</td>														
                                       <td>{{ number_format($q3_amount, 2) }}</td>														
                                       <td>{{ number_format($oct_amount, 2) }}</td>														
                                       <td>{{ number_format($nov_amount, 2) }}</td>														
                                       <td>{{ number_format($dec_amount, 2) }}</td>		
                                       <td>{{ number_format($q4_amount, 2) }}</td>	
                                    </tr><?php
                                 }
                              }
                           }
                           
                        }	
                        if(isset($item3->subactivity)){
                           $jan_subactivity_total=$row3->sum('jan_amount');
                           $feb_subactivity_total=$row3->sum('feb_amount');
                           $mar_subactivity_total=$row3->sum('mar_amount');
                           $apr_subactivity_total=$row3->sum('apr_amount');
                           $may_subactivity_total=$row3->sum('may_amount');
                           $jun_subactivity_total=$row3->sum('jun_amount');
                           $jul_subactivity_total=$row3->sum('jul_amount');
                           $aug_subactivity_total=$row3->sum('aug_amount');
                           $sep_subactivity_total=$row3->sum('sep_amount');
                           $oct_subactivity_total=$row3->sum('oct_amount');
                           $nov_subactivity_total=$row3->sum('nov_amount');
                           $dec_subactivity_total=$row3->sum('dec_amount');										
                           $q1_subactivity_total=$jan_subactivity_total + $feb_subactivity_total + $mar_subactivity_total;										
                           $q2_subactivity_total=$apr_subactivity_total + $may_subactivity_total + $jun_subactivity_total;										
                           $q3_subactivity_total=$jul_subactivity_total + $aug_subactivity_total + $sep_subactivity_total;										
                           $q4_subactivity_total=$oct_subactivity_total + $nov_subactivity_total + $dec_subactivity_total;										
                           $annual_subactivity_total=$q1_subactivity_total + $q2_subactivity_total + $q3_subactivity_total + $q4_subactivity_total;?>		
                           <tr class="text-right font-weight-bold gray-bg">
                              <td colspan="2">Total Subactivity, {{ $item3->subactivity }}</td>
                              <td>&nbsp;&nbsp;{{ number_format($annual_subactivity_total, 2) }}</td>											 
                              <td>&nbsp;&nbsp;{{ number_format($jan_subactivity_total, 2) }}</td>
                              <td>&nbsp;&nbsp;{{ number_format($feb_subactivity_total, 2) }}</td>
                              <td>&nbsp;&nbsp;{{ number_format($mar_subactivity_total, 2) }}</td>
                              <td>&nbsp;&nbsp;{{ number_format($q1_subactivity_total, 2) }}</td>														
                              <td>&nbsp;&nbsp;{{ number_format($apr_subactivity_total, 2) }}</td>														
                              <td>&nbsp;&nbsp;{{ number_format($may_subactivity_total, 2) }}</td>														
                              <td>&nbsp;&nbsp;{{ number_format($jun_subactivity_total, 2) }}</td>	
                              <td>&nbsp;&nbsp;{{ number_format($q2_subactivity_total, 2) }}</td>															
                              <td>&nbsp;&nbsp;{{ number_format($jul_subactivity_total, 2) }}</td>														
                              <td>&nbsp;&nbsp;{{ number_format($aug_subactivity_total, 2) }}</td>														
                              <td>&nbsp;&nbsp;{{ number_format($sep_subactivity_total, 2) }}</td>		
                              <td>&nbsp;&nbsp;{{ number_format($q3_subactivity_total, 2) }}</td>														
                              <td>&nbsp;&nbsp;{{ number_format($oct_subactivity_total, 2) }}</td>														
                              <td>&nbsp;&nbsp;{{ number_format($nov_subactivity_total, 2) }}</td>	
                              <td>&nbsp;&nbsp;{{ number_format($dec_subactivity_total, 2) }}</td>	
                              <td>&nbsp;&nbsp;{{ number_format($q4_subactivity_total, 2) }}</td>		
                           </tr><?php
                        }
                     }                                          
                     if(isset($item2->activity)){
                        $jan_activity_total=$row2->sum('jan_amount');
                        $feb_activity_total=$row2->sum('feb_amount');
                        $mar_activity_total=$row2->sum('mar_amount');
                        $apr_activity_total=$row2->sum('apr_amount');
                        $may_activity_total=$row2->sum('may_amount');
                        $jun_activity_total=$row2->sum('jun_amount');
                        $jul_activity_total=$row2->sum('jul_amount');
                        $aug_activity_total=$row2->sum('aug_amount');
                        $sep_activity_total=$row2->sum('sep_amount');
                        $oct_activity_total=$row2->sum('oct_amount');
                        $nov_activity_total=$row2->sum('nov_amount');
                        $dec_activity_total=$row2->sum('dec_amount');										
                        $q1_activity_total=$jan_activity_total + $feb_activity_total + $mar_activity_total;										
                        $q2_activity_total=$apr_activity_total + $may_activity_total + $jun_activity_total;										
                        $q3_activity_total=$jul_activity_total + $aug_activity_total + $sep_activity_total;										
                        $q4_activity_total=$oct_activity_total + $nov_activity_total + $dec_activity_total;										
                        $annual_activity_total=$q1_activity_total + $q2_activity_total + $q3_activity_total + $q4_activity_total;?>
                        <tr class="text-right font-weight-bold gray-bg">
                           <td colspan="2">Total Activity, {{ $item2->activity }}</td>
                           <td>&nbsp;&nbsp;{{ number_format($annual_activity_total, 2) }}</td>											 
                           <td>&nbsp;&nbsp;{{ number_format($jan_activity_total, 2) }}</td>
                           <td>&nbsp;&nbsp;{{ number_format($feb_activity_total, 2) }}</td>
                           <td>&nbsp;&nbsp;{{ number_format($mar_activity_total, 2) }}</td>
                           <td>&nbsp;&nbsp;{{ number_format($q1_activity_total, 2) }}</td>														
                           <td>&nbsp;&nbsp;{{ number_format($apr_activity_total, 2) }}</td>														
                           <td>&nbsp;&nbsp;{{ number_format($may_activity_total, 2) }}</td>														
                           <td>&nbsp;&nbsp;{{ number_format($jun_activity_total, 2) }}</td>
                           <td>&nbsp;&nbsp;{{ number_format($q2_activity_total, 2) }}</td>														
                           <td>&nbsp;&nbsp;{{ number_format($jul_activity_total, 2) }}</td>														
                           <td>&nbsp;&nbsp;{{ number_format($aug_activity_total, 2) }}</td>														
                           <td>&nbsp;&nbsp;{{ number_format($sep_activity_total, 2) }}</td>	
                           <td>&nbsp;&nbsp;{{ number_format($q3_activity_total, 2) }}</td>													
                           <td>&nbsp;&nbsp;{{ number_format($oct_activity_total, 2) }}</td>														
                           <td>&nbsp;&nbsp;{{ number_format($nov_activity_total, 2) }}</td>	
                           <td>&nbsp;&nbsp;{{ number_format($dec_activity_total, 2) }}</td>	
                           <td>&nbsp;&nbsp;{{ number_format($q4_activity_total, 2) }}</td>
                        </tr><?php
                     }
                  }									
                  if(isset($item1->pap)){
                     $jan_pap_total=$row1->sum('jan_amount');
                     $feb_pap_total=$row1->sum('feb_amount');
                     $mar_pap_total=$row1->sum('mar_amount');
                     $apr_pap_total=$row1->sum('apr_amount');
                     $may_pap_total=$row1->sum('may_amount');
                     $jun_pap_total=$row1->sum('jun_amount');
                     $jul_pap_total=$row1->sum('jul_amount');
                     $aug_pap_total=$row1->sum('aug_amount');
                     $sep_pap_total=$row1->sum('sep_amount');
                     $oct_pap_total=$row1->sum('oct_amount');
                     $nov_pap_total=$row1->sum('nov_amount');
                     $dec_pap_total=$row1->sum('dec_amount');										
                     $q1_pap_total=$jan_pap_total + $feb_pap_total + $mar_pap_total;										
                     $q2_pap_total=$apr_pap_total + $may_pap_total + $jun_pap_total;										
                     $q3_pap_total=$jul_pap_total + $aug_pap_total + $sep_pap_total;										
                     $q4_pap_total=$oct_pap_total + $nov_pap_total + $dec_pap_total;										
                     $annual_pap_total=$q1_pap_total + $q2_pap_total + $q3_pap_total + $q4_pap_total;?>
                     <tr class="text-right font-weight-bold gray-bg">
                        <td colspan="2">Total PAP, {{ $item1->pap }}</td>
                        <td>&nbsp;&nbsp;{{ number_format($annual_pap_total, 2) }}</td>											 
                        <td>&nbsp;&nbsp;{{ number_format($jan_pap_total, 2) }}</td>
                        <td>&nbsp;&nbsp;{{ number_format($feb_pap_total, 2) }}</td>
                        <td>&nbsp;&nbsp;{{ number_format($mar_pap_total, 2) }}</td>		
                        <td>&nbsp;&nbsp;{{ number_format($q1_pap_total, 2) }}</td>												
                        <td>&nbsp;&nbsp;{{ number_format($apr_pap_total, 2) }}</td>														
                        <td>&nbsp;&nbsp;{{ number_format($may_pap_total, 2) }}</td>														
                        <td>&nbsp;&nbsp;{{ number_format($jun_pap_total, 2) }}</td>	
                        <td>{{ number_format($q2_pap_total, 2) }}</td>													
                        <td>&nbsp;&nbsp;{{ number_format($jul_pap_total, 2) }}</td>														
                        <td>&nbsp;&nbsp;{{ number_format($aug_pap_total, 2) }}</td>														
                        <td>&nbsp;&nbsp;{{ number_format($sep_pap_total, 2) }}</td>	
                        <td>{{ number_format($q3_pap_total, 2) }}</td>													
                        <td>&nbsp;&nbsp;{{ number_format($oct_pap_total, 2) }}</td>														
                        <td>&nbsp;&nbsp;{{ number_format($nov_pap_total, 2) }}</td>
                        <td>&nbsp;&nbsp;{{ number_format($dec_pap_total, 2) }}</td>
                        <td>&nbsp;&nbsp;{{ number_format($q4_pap_total, 2) }}</td>
                     </tr><?php 
                  }
               }
            }
            foreach($data->groupBy('year') as $keyCPSum=>$rowCPSum){
               foreach($rowCPSum as $itemCPSum){}
                  $jan_cp_total=$rowCPSum->sum('jan_amount');
                  $feb_cp_total=$rowCPSum->sum('feb_amount');
                  $mar_cp_total=$rowCPSum->sum('mar_amount');
                  $apr_cp_total=$rowCPSum->sum('apr_amount');
                  $may_cp_total=$rowCPSum->sum('may_amount');
                  $jun_cp_total=$rowCPSum->sum('jun_amount');
                  $jul_cp_total=$rowCPSum->sum('jul_amount');
                  $aug_cp_total=$rowCPSum->sum('aug_amount');
                  $sep_cp_total=$rowCPSum->sum('sep_amount');
                  $oct_cp_total=$rowCPSum->sum('oct_amount');
                  $nov_cp_total=$rowCPSum->sum('nov_amount');
                  $dec_cp_total=$rowCPSum->sum('dec_amount');										
                  $q1_cp_total=$jan_cp_total + $feb_cp_total + $mar_cp_total;										
                  $q2_cp_total=$apr_cp_total + $may_cp_total + $jun_cp_total;										
                  $q3_cp_total=$jul_cp_total + $aug_cp_total + $sep_cp_total;										
                  $q4_cp_total=$oct_cp_total + $nov_cp_total + $dec_cp_total;										
                  $annual_cp_total=$q1_cp_total + $q2_cp_total + $q3_cp_total + $q4_cp_total;?>		
               <tr class="text-right font-weight-bold gray-bg">
                  <td colspan="2">GRAND TOTAL</td>
                  <td>&nbsp;&nbsp;{{ number_format($annual_cp_total, 2) }}</td>											 
                  <td>&nbsp;&nbsp;{{ number_format($jan_cp_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($feb_cp_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($mar_cp_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($q1_cp_total, 2) }}</td>														
                  <td>&nbsp;&nbsp;{{ number_format($apr_cp_total, 2) }}</td>														
                  <td>&nbsp;&nbsp;{{ number_format($may_cp_total, 2) }}</td>														
                  <td>&nbsp;&nbsp;{{ number_format($jun_cp_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($q2_cp_total, 2) }}</td>														
                  <td>&nbsp;&nbsp;{{ number_format($jul_cp_total, 2) }}</td>														
                  <td>&nbsp;&nbsp;{{ number_format($aug_cp_total, 2) }}</td>														
                  <td>&nbsp;&nbsp;{{ number_format($sep_cp_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($q3_cp_total, 2) }}</td>														
                  <td>&nbsp;&nbsp;{{ number_format($oct_cp_total, 2) }}</td>														
                  <td>&nbsp;&nbsp;{{ number_format($nov_cp_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($dec_cp_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($q4_cp_total, 2) }}</td>
               </tr><?php
            }?>
         </tbody>
      </table>
      <br>
		<table style="width: 100%;" class="table-borderless">
			<tr>
				<td>Prepared By:</td>
				<td>Approved By:</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr class="text-center">
				<td>___________________________</td>
				<td>___________________________</td>
			</tr>
			<tr class="text-center">
            @if($division_id==3)
				   <td>{{ strtoupper($user_fullname) }}</td>
				   <td>ROSETE, EDLYNE A.</td>
            @else
               <td>{{ strtoupper($user_fullname) }}</td>
               <td>{{ strtoupper($user_division_director) }}</td>
            @endif
			</tr>
			<tr class="text-center">
            @if($division_id==3)
               <td style="font-size:11px;">{{ $user_role }}</td>
               <td style="font-size:11px;">Audit Team Leader</td>
            @else
               <td style="font-size:11px;">{{ $user_role }}</td>
               <td style="font-size:11px;">
                  Division Director
               </td>
            @endif
			</tr>	
		</table> 
      <br>
   </body>
</html> 