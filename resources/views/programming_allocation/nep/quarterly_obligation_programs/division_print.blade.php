
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - Quarterly Obligation Program</title>
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
         .main-header{
            font-size: 22px;
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
            var css = '@page { size: portrait; }',
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
               ->Where('user_role_id','=',6)
               ->where('is_active',1)->where('is_deleted',0)->pluck('fullname_last')->first(); 
            $division = 'Finance & Administrative Division';	 
         }
         else{
            $user_division_director = App\Models\ViewUsersHasRolesModel::where('division_id', $user_division_id)
               ->where('role_id','=',6)
               ->where('is_active',1)->where('is_deleted',0)->pluck('fullname_last')->first(); 
         } 
         $getYearsV = getYearsV($year);	  
         foreach($getYearsV as $row){
            $fiscal_year1 = $row->fiscal_year1;
         }
         $sqlQOP = getQuarterlyObligationProgram($division_id, $year);	
         foreach($sqlQOP as $row){
            $division_acronym = $row->division_acronym;
            $division = $row->division;
         }
      ?>
      <button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
      <table class="table-bordered" style="width: 100%; border:1px;">
         <tr>
            <th rowspan="4" class="text-center"><img src="{{ asset('/images/dost-pcaarrd-logo.png') }}" alt="" width="80px"></th>
            <th class="text-center">PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC, AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</th>
            <th class="text-left right-subheader">DOCUMENT CODE</th>
            <th class="right-subheader text-center">QMSF-FADBD-07-01-02</th>
         </tr>
         <tr class="text-center">  
            <th rowspan="3" class="main-header">ANNUAL FINANCIAL PLAN</th>          
            <th class="text-left right-subheader">REVISION NUMBER</th>
            <th class="right-subheader">0</th>
         </tr>      
         <tr class="right-subheader">
            <th class="text-left">PAGE NUMBER</th>
            <th class="text-center">1 of 1</th>
         </tr>
         <tr class="right-subheader">
            <th class="text-left">EFFECTIVITY DATE</th>
            <th class="text-center">MAY 2, 2018</th>
         </tr> 
      </table>
      <table id="quarterly_obligation_program_table" class="table-bordered table-hover" style="width: 100%; border:1px;">
         <thead class="text-center">
            <tr>
               <th colspan="7">CY {{ $fiscal_year1 }}</th>
            </tr>
            <tr>
               <th colspan="7">{{ $division }}</th>
            </tr> 
            <tr>
               <th colspan="7" class="mheader font-weight-bolder">QUARTERLY OBLIGATION PROGRAM</th>
            </tr>
            <tr class="subheader">
               <th>P/A/P, Division, Item of Expenditures</th>
               <th style="min-width: 80px">ANNUAL <br>PROGRAM</th>
               <th>Q1</th> 
               <th>Q2</th> 
               <th>Q3</th> 
               <th>Q4</th>               
            </tr>
         </thead>
         <tbody> <?php
            if($division_id==5){
               $data = DB::table('view_quarterly_obligation_programs')->where('year', $year)
                  ->where('parent_division_id', $division_id)->where('is_active', 1)->where('is_deleted', 0)
                  ->where('is_active', 1)->where('is_deleted', 0)
                  ->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
                  ->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
                  ->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
                  ->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
                  ->groupBy('id')->get();
            }
            else{
               $data = DB::table('view_quarterly_obligation_programs')->where('year', $year)
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
                  <td class="font-weight-bold" colspan="7">{{ $item->allotment_class }} ({{ $item->allotment_class_acronym }})</td>													
               </tr><?php
               foreach($data->where('allotment_class_id', $item->allotment_class_id)->groupBY('pap_code') as $key1=>$row1){
                  foreach($row1 as $item1) {} //item 1?>
                  <tr>
                     <td class="pap font-weight-bold gray1-bg" colspan="7">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
                  </tr><?php 		
                  foreach($data->where('allotment_class_id', $item->allotment_class_id)
                     ->where('pap_id', $item1->pap_id)
                     ->groupBY('activity_id') as $key2=>$row2){
                     foreach($row2 as $item2) {} //item 2?>
                     <tr>
                        <td class="activity1 font-weight-bold" colspan="7">{{ $item2->activity }}</td>													
                     </tr><?php 										
                     foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
                        ->where('activity_id', $item2->activity_id)
                        ->groupBY('subactivity_id') as $key3=>$row3){
                        foreach($row3 as $item3) {} 
                        if(isset($item3->subactivity)){//item 3?>
                           <tr>
                              <td class="subactivity1 font-weight-bold" colspan="7">{{ $item3->subactivity }}</td>													
                           </tr><?php 
                        }	
                        foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
                           ->where('activity_id', $item2->activity_id)
                           ->where('subactivity_id', $item3->subactivity_id)
                           ->groupBY('expense_account_id') as $key4=>$row4){
                           foreach($row4 as $item4) {}//item 4?>
                           <tr>
                              <td class="expense1 font-weight-bold" colspan="7">{{ $item4->expense_account }}</td>														
                           </tr>
                           <?php
                           foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
                              ->where('activity_id', $item2->activity_id)
                              ->where('subactivity_id', $item3->subactivity_id)
                              ->where('expense_account_id', $item4->expense_account_id)
                              ->whereNull('object_specific_id')
                              ->groupBY('id') as $key5=>$row5){
                              foreach($row5 as $item5) {}//item 4
                              $q1_amount=$item5->q1_amount;
                              $q2_amount=$item5->q2_amount;
                              $q3_amount=$item5->q3_amount;
                              $q4_amount=$item5->q4_amount;																								
                              $annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
                              <tr class="text-right">
                                 <td class="objexp1">{{ $item5->object_expenditure }}</td>
                                 <td>{{ number_format($annual_amount, 2) }}</td>											 
                                 <td>{{ number_format($q1_amount, 2) }}</td>		
                                 <td>{{ number_format($q2_amount, 2) }}</td>		
                                 <td>{{ number_format($q3_amount, 2) }}</td>		
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
                              $q1_amount=$item5->q1_amount;
                              $q2_amount=$item5->q2_amount;
                              $q3_amount=$item5->q3_amount;
                              $q4_amount=$item5->q4_amount;																								
                              $annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;
                              if($item5->object_specific_id != NULL){?>
                                 <tr>
                                    <td class="objexp1" colspan="7">{{ $item5->object_expenditure }}</td>														
                                 </tr><?php
                                 foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
                                    ->where('activity_id', $item2->activity_id)
                                    ->where('subactivity_id', $item3->subactivity_id)
                                    ->where('expense_account_id', $item4->expense_account_id)
                                    ->where('object_expenditure_id', $item5->object_expenditure_id)
                                    ->whereNotNull('object_specific_id')
                                    ->groupBY('id') as $key6=>$row6){
                                    foreach($row6 as $item6) {}//item 4
                                    $q1_amount=$item6->q1_amount;
                                    $q2_amount=$item6->q2_amount;
                                    $q3_amount=$item6->q3_amount;
                                    $q4_amount=$item6->q4_amount;																								
                                    $annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
                                    <tr class="text-right">
                                       <td class="objspe1 font-italic">{{ $item6->object_specific }}</td>		
                                       <td>{{ number_format($annual_amount, 2) }}</td>											 
                                       <td>{{ number_format($q1_amount, 2) }}</td>		
                                       <td>{{ number_format($q2_amount, 2) }}</td>		
                                       <td>{{ number_format($q3_amount, 2) }}</td>		
                                       <td>{{ number_format($q4_amount, 2) }}</td>				
                                    </tr><?php
                                 }
                              }
                           }
                        }	
                        if(isset($item3->subactivity)){
                           $q1_subactivity_total=$row3->sum('q1_amount');									
                           $q2_subactivity_total=$row3->sum('q2_amount');									
                           $q3_subactivity_total=$row3->sum('q3_amount');									
                           $q4_subactivity_total=$row3->sum('q4_amount');									
                           $annual_subactivity_total=$q1_subactivity_total + $q2_subactivity_total + $q3_subactivity_total + $q4_subactivity_total;?>		
                           <tr class="text-right font-weight-bold gray-bg">
                              <td>Total Subactivity, {{ $item3->subactivity }}</td>
                              <td>&nbsp;&nbsp;{{ number_format($annual_subactivity_total, 2) }}</td>											 
                              <td>&nbsp;&nbsp;{{ number_format($q1_subactivity_total, 2) }}</td>
                              <td>&nbsp;&nbsp;{{ number_format($q2_subactivity_total, 2) }}</td>
                              <td>&nbsp;&nbsp;{{ number_format($q3_subactivity_total, 2) }}</td>
                              <td>&nbsp;&nbsp;{{ number_format($q4_subactivity_total, 2) }}</td>
                           </tr><?php
                        }
                     }
                                          
                     if(isset($item2->activity)){
                        $q1_activity_total=$row2->sum('q1_amount');										
                        $q2_activity_total=$row2->sum('q2_amount');										
                        $q3_activity_total=$row2->sum('q3_amount');										
                        $q4_activity_total=$row2->sum('q4_amount');		
                        $annual_activity_total=$q1_activity_total + $q2_activity_total + $q3_activity_total + $q4_activity_total;?>
                        <tr class="text-right font-weight-bold gray-bg">
                           <td>Total Activity, {{ $item2->activity }}</td>
                           <td>&nbsp;&nbsp;{{ number_format($annual_activity_total, 2) }}</td>											 
                           <td>&nbsp;&nbsp;{{ number_format($q1_activity_total, 2) }}</td>
                           <td>&nbsp;&nbsp;{{ number_format($q2_activity_total, 2) }}</td>
                           <td>&nbsp;&nbsp;{{ number_format($q3_activity_total, 2) }}</td>
                           <td>&nbsp;&nbsp;{{ number_format($q4_activity_total, 2) }}</td>
                        </tr><?php
                     }
                  }									
                  if(isset($item1->pap)){
                     $q1_pap_total=$row1->sum('q1_amount');																		
                     $q2_pap_total=$row1->sum('q2_amount');																		
                     $q3_pap_total=$row1->sum('q3_amount');																		
                     $q4_pap_total=$row1->sum('q4_amount');																		
                     $annual_pap_total=$q1_pap_total + $q2_pap_total + $q3_pap_total + $q4_pap_total;?>
                     <tr class="text-right font-weight-bold gray-bg">
                        <td>Total PAP, {{ $item1->pap }}</td>
                        <td>&nbsp;&nbsp;{{ number_format($annual_pap_total, 2) }}</td>											 
                        <td>&nbsp;&nbsp;{{ number_format($q1_pap_total, 2) }}</td>
                        <td>&nbsp;&nbsp;{{ number_format($q2_pap_total, 2) }}</td>
                        <td>&nbsp;&nbsp;{{ number_format($q3_pap_total, 2) }}</td>
                        <td>&nbsp;&nbsp;{{ number_format($q4_pap_total, 2) }}</td>
                     </tr><?php 
                  }
               }
            }
            foreach($data->groupBy('year') as $keyCPSum=>$rowQOPSum){
               foreach($rowQOPSum as $itemQOPSum){}
               $q1_qop_total=$rowQOPSum->sum('q1_amount');															
               $q2_qop_total=$rowQOPSum->sum('q2_amount');															
               $q3_qop_total=$rowQOPSum->sum('q3_amount');															
               $q4_qop_total=$rowQOPSum->sum('q4_amount');															
               $annual_qop_total=$q1_qop_total + $q2_qop_total + $q3_qop_total + $q4_qop_total;?>		
               <tr class="text-right font-weight-bold gray-bg">
                  <td>GRAND TOTAL</td>
                  <td>&nbsp;&nbsp;{{ number_format($annual_qop_total, 2) }}</td>											 
                  <td>&nbsp;&nbsp;{{ number_format($q1_qop_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($q2_qop_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($q3_qop_total, 2) }}</td>
                  <td>&nbsp;&nbsp;{{ number_format($q4_qop_total, 2) }}</td>
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