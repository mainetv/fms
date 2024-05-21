
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
			$user_fullname = App\Models\ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();  
			$user_role = App\Models\ViewUsersModel::where('id', $user_id)->pluck('user_role')->first(); 
			$user_division_id = App\Models\ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
			$user_division_director = App\Models\ViewUsersModel::where('division_id', $user_division_id)
				->where('user_role_id', 6)->pluck('fullname_last')->first();  
         $sqlQOP = getQuarterlyObligationProgram($division_id, $year);	
         foreach($sqlQOP as $row){
            $division_acronym = $row->division_acronym;
            $division = $row->division;
            $fiscal_year1 = $row->fiscal_year1;
         }
      ?>
      <button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
      <table class="table-bordered" style="width: 100%; border:1px;">
         <tr>
            <th rowspan="4" class="text-center"><img src="{{ asset('/images/dost-pcaarrd-logo.png') }}" alt="" width="80px"></th>
            <th colspan="5" class="text-center">PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC, AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</th>
            <th class="text-left right-subheader">DOCUMENT CODE</th>
            <th class="right-subheader text-center">QMSF-FADBD-07-01-02</th>
         </tr>
         <tr class="text-center">  
            <th rowspan="3" colspan="5" class="main-header">ANNUAL FINANCIAL PLAN</th>          
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
               <th colspan="2">>P/A/P, Division, Item of Expenditures</th>
               <th style="min-width: 80px">ANNUAL <br>PROGRAM</th>
               <th>Q1</th> 
               <th>Q2</th> 
               <th>Q3</th> 
               <th>Q4</th>               
            </tr>
         </thead>
         <tbody> <?php
            $data = DB::table('view_quarterly_obligation_programs')->where('division_id', $division_id)->where('year', $year)
               ->where('is_deleted', 0)->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
               ->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_specific','ASC')->get();
            foreach($data->groupBY('pap_id') as $key=>$row){			
               foreach($row as $item) {} //item?>
               <tr>
                  <td class="font-weight-bold gray1-bg" colspan="19">{{ $item->pap }} - {{ $item->pap_code }}</td>										
               </tr><?php
               foreach($data->where('pap_id', $item->pap_id)->groupBY('activity_id') as $key1=>$row1){
                  foreach($row1 as $item1) {} //item 1?>
                  <tr>
                     <td class="activity font-weight-bold" colspan="19">{{ $item1->activity }}</td>													
                  </tr><?php 	
                  foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
                     ->groupBY('subactivity_id') as $key2=>$row2){
                     foreach($row2 as $item2) {} 
                     if(isset($item2->subactivity)){//item 2?>
                        <tr>
                           <td class="subactivity font-weight-bold" colspan="19">{{ $item2->subactivity }}</td>													
                        </tr><?php 
                     }												
                     foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
                        ->where('subactivity_id', $item2->subactivity_id)->groupBY('allotment_class_id') as $key3=>$row3){
                        foreach($row3 as $item3) {}//item 3?>
                        <tr>
                           <td class="aclass font-weight-bold" colspan="19">{{ $item3->allotment_class }} ({{ $item3->allotment_class_acronym }})</td>													
                        </tr><?php 													
                        foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
                           ->where('subactivity_id', $item2->subactivity_id)
                           ->where('allotment_class_id', $item3->allotment_class_id)
                           ->groupBY('expense_account_id') as $key4=>$row4){															
                           foreach($row4 as $item4) { }//item 4
                              $q1_expense_total=$row4->sum('q1_amount');									
                              $q2_expense_total=$row4->sum('q2_amount');									
                              $q3_expense_total=$row4->sum('q3_amount');									
                              $q4_expense_total=$row4->sum('q4_amount');																		
                              $annual_expense_total=$q1_expense_total + $q2_expense_total + $q3_expense_total + $q4_expense_total;?>	
                           <tr class="text-right font-weight-bold gray-bg">
                              <td class="expense" colspan="2">{{ $item4->expense_account }}</td>	
                              <td>{{ number_format($annual_expense_total, 2) }}</td>											 
                              <td>{{ number_format($q1_expense_total, 2) }}</td>													
                              <td>{{ number_format($q2_expense_total, 2) }}</td>													
                              <td>{{ number_format($q3_expense_total, 2) }}</td>													
                              <td>{{ number_format($q4_expense_total, 2) }}</td>													
                           </tr><?php 														
                           foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
                              ->where('subactivity_id', $item2->subactivity_id)
                              ->where('allotment_class_id', $item3->allotment_class_id)
                              ->where('expense_account_id', $item4->expense_account_id)
                              ->groupBY('object_expenditure_id') as $key5=>$row5){
                              foreach($row5 as $item5) {}//item 5
                                 $q1_amount=$item5->q1_amount;								
                                 $q2_amount=$item5->q2_amount;								
                                 $q3_amount=$item5->q3_amount;								
                                 $q4_amount=$item5->q4_amount;																	
                                 $annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
                              <tr class="text-right"><?php
                                 if($item5->object_specific_id == NULL || $item5->object_specific_id == 0 || $item5->object_specific_id == ''){?>
                                    <td class="objexp" colspan="2">{{ $item5->object_expenditure }}</td>
                                    <td>{{ number_format($annual_amount, 2) }}</td>														
                                    <td>{{ number_format($q1_amount, 2) }}</td>														
                                    <td>{{ number_format($q2_amount, 2) }}</td>															
                                    <td>{{ number_format($q3_amount, 2) }}</td>		
                                    <td>{{ number_format($q4_amount, 2) }}</td>	<?php 
                                 }else{?>
                                    <td class="objexp" colspan="19">{{ $item5->object_expenditure }}</td><?php
                                 }?>										
                              </tr><?php 
                              if($item5->object_specific_id != NULL || $item5->object_specific_id != 0 || $item5->object_specific_id != ''){																	
                                 foreach($data->where('pap_id', $item->pap_id)->where('activity_id', $item1->activity_id)
                                    ->where('subactivity_id', $item2->subactivity_id)
                                    ->where('allotment_class_id', $item3->allotment_class_id)
                                    ->where('expense_account_id', $item4->expense_account_id)
                                    ->where('object_expenditure_id', $item5->object_expenditure_id)
                                    ->groupBy('object_specific') as $key6=>$row6){
                                    foreach($row6 as $item6) { }//item 6
                                       $q1_amount=$item6->q1_amount;																
                                       $q2_amount=$item6->q2_amount;																
                                       $q3_amount=$item6->q3_amount;																
                                       $q4_amount=$item6->q4_amount;																
                                       $annual_amount=$q1_amount + $q2_amount + $q3_amount + $q4_amount;?>
                                    <tr class="text-right">
                                       <td class="objspe font-italic" colspan="2">{{ $item6->object_specific }}</td>													
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
                        if(isset($item2->subactivity)){
                           $q1_subactivity_total=$row2->sum('q1_amount');																	
                           $q2_subactivity_total=$row2->sum('q2_amount');																	
                           $q3_subactivity_total=$row2->sum('q3_amount');																	
                           $q4_subactivity_total=$row2->sum('q4_amount');																	
                           $annual_subactivity_total=$q1_subactivity_total + $q2_subactivity_total + $q3_subactivity_total + $q4_subactivity_total;?>		
                           <tr class="text-right font-weight-bold gray-bg">
                              <td class="subactivity">Sub-Total Subactivity</td>
                              <td>{{ number_format($annual_subactivity_total, 2) }}</td>														
                              <td>{{ number_format($q1_subactivity_total, 2) }}</td>															
                              <td>{{ number_format($q2_subactivity_total, 2) }}</td>														
                              <td>{{ number_format($q3_subactivity_total, 2) }}</td>	
                              <td>{{ number_format($q4_subactivity_total, 2) }}</td>	
                           </tr><?php
                        }
                     }
                  } 
                  if(isset($item1->activity)){
                     $q1_activity_total=$row1->sum('q1_amount');																		
                     $q2_activity_total=$row1->sum('q2_amount');																		
                     $q3_activity_total=$row1->sum('q3_amount');																		
                     $q4_activity_total=$row1->sum('q4_amount');																		
                     $annual_activity_total=$q1_activity_total + $q2_activity_total + $q3_activity_total + $q4_activity_total;?>
                     <tr class="text-right font-weight-bold gray-bg">
                        <td class="activity" colspan="2">Sub-Total Activity</td>
                        <td>{{ number_format($annual_activity_total, 2) }}</td>															
                        <td>{{ number_format($q1_activity_total, 2) }}</td>														
                        <td>{{ number_format($q2_activity_total, 2) }}</td>														
                        <td>{{ number_format($q3_activity_total, 2) }}</td>		
                        <td>{{ number_format($q4_activity_total, 2) }}</td>	
                     </tr><?php
                  }
               }		
               if(isset($item->pap)){
                  $q1_pap_total=$row->sum('q1_amount');									
                  $q2_pap_total=$row->sum('q2_amount');									
                  $q3_pap_total=$row->sum('q3_amount');									
                  $q4_pap_total=$row->sum('q4_amount');									
                  $annual_pap_total=$q1_pap_total + $q2_pap_total + $q3_pap_total + $q4_pap_total;?>
                  <tr class="text-right font-weight-bold gray-bg">
                     <td class="text-left" colspan="2">Total PAP</td>
                     <td>{{ number_format($annual_pap_total, 2) }}</td>													
                     <td>{{ number_format($q1_pap_total, 2) }}</td>														
                     <td>{{ number_format($q2_pap_total, 2) }}</td>													
                     <td>{{ number_format($q3_pap_total, 2) }}</td>		
                     <td>{{ number_format($q4_pap_total, 2) }}</td>
                  </tr><?php 
               }
            }
            foreach($data->groupBy('division_id') as $keyQOPSum=>$rowQOPSum){
               foreach($rowQOPSum as $itemQOPSum){}
                  $q1_qop_total=$rowQOPSum->sum('q1_amount');																
                  $q2_qop_total=$rowQOPSum->sum('q2_amount');																
                  $q3_qop_total=$rowQOPSum->sum('q3_amount');																
                  $q4_qop_total=$rowQOPSum->sum('q4_amount');																
                  $annual_qop_total=$q1_qop_total + $q2_qop_total + $q3_qop_total + $q4_qop_total;?>		
               <tr class="text-right font-weight-bold gray-bg">
                  <td class="text-left" colspan="2">GRAND TOTAL</td>
                  <td>{{ number_format($annual_qop_total, 2) }}</td>														
                  <td>{{ number_format($q1_qop_total, 2) }}</td>														
                  <td>{{ number_format($q2_qop_total, 2) }}</td>														
                  <td>{{ number_format($q3_qop_total, 2) }}</td>		
                  <td>{{ number_format($q4_qop_total, 2) }}</td>
               </tr><?php
            }?>
         </tbody>
      </table>
      <br>
		<table style="width: 100%;">
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
				<td>{{ strtoupper($user_fullname) }}</td>
				<td>{{ strtoupper($user_division_director) }}</td>
			</tr>
			<tr class="text-center">
				<td style="font-size:11px;">{{ $user_role }}</td>
				<td style="font-size:11px;">Division Director</td>
			</tr>	
		</table> 
      <br>
   </body>
</html> 