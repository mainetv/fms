<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - RS</title>
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}" media="all">
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-6.1.1-web/css/all.min.css') }}">
		<style>
			@media screen{
				.rs_page2{
					padding: 0 10cm 0cm 10cm;
				}
				.title-font{
					font-size:16px ;
				}
			}
			body,td,th {
				font-family: Verdana, Geneva, sans-serif;
				color: #000000;
				font-size: 12px;
			}
			.smallfont {
				font-size:10px ;
			}
			@media print{
				body,td,th {
					font-family: Verdana, Geneva, sans-serif;
					font-size: 17px;
				}
				.smallfont {
					font-size:16px ;
				}
				.title-font{
					font-size:25px ;
				}
				.pageBreak {
					page-break-after: always;
				}
			}
		</style>
		<SCRIPT LANGUAGE="JavaScript">
			function printThis()
			{
            // var css = '@page { size: portrait; }',
            // head = document.head || document.getElementsByTagName('head')[0],
            // style = document.createElement('style');

            // style.type = 'text/css';
            // style.media = 'print';

            // if (style.styleSheet){
            // 	style.styleSheet.cssText = css;
            // } else {
            // 	style.appendChild(document.createTextNode(css));
            // }

            // head.appendChild(style);

				window.print();
			}
		</script>
	</head>
	<body><?php
		foreach ($rs_data as $row){
			$rs_id = $row->id;	
			$rs_type_id = $row->rs_type_id;	
			$rs_date = $row->rs_date;	
			$rs_year = date('Y', strtotime($rs_date));
			$request_status_type = $row->request_status_type;
			$rs_type = $row->rs_type;
			$fund = $row->fund;
			$payee = $row->payee;	
			$division_acronym = $row->division_acronym;	
			$tin = $row->tin;	
			$rs_no = $row->rs_no;	
			$address = $row->address;	
			$office = $row->office;	
			$bank = $row->bank;	
			$bank_account_number = $row->bank_account_number;	
			$contact_number = $row->contact_number;	
			$particulars = $row->particulars;	
			$total_rs_pap_amount = $row->total_rs_pap_amount;	
			$signatory1b = $row->signatory1b;	
			$signatory1b_position = $row->signatory1b_position;				
		}
		$total_rs_pap_amount = number_format($total_rs_pap_amount, 2);
		$qr_code=$rs_year ."O" . sprintf('%08d', $rs_id);		
		?>
		<button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
		<br class="noprint"><br class="noprint">
		<div class="rs_page2">
			Page 2 of 2<br />
			<table width="100%" class="text-center" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="3">
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
							<tr>
								<td>Republic of the Philippines<br />
									<p class="smallfont">DEPARTMENT OF SCIENCE AND TECHNOLOGY<br />
									<strong>PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</strong><br />
									LOS BANOS, LAGUNA</p></td>
							</tr>
							<tr>
								<td><p class="title-font"><strong>{{ strtoupper($rs_type) }}</strong></p></td>
							</tr>
						</table>
					</td>
					<td>
						{!! QrCode::size(160)->generate('{{ $qr_code }}') !!}<br />
						{{ $qr_code }}
					</td>
				</tr>
				<tr>
					<td width="20%" height="30">Payee</td>
					<td colspan="2" class="text-left">&nbsp;{{ $payee }}</td>
					<td width="22%" rowspan="4" valign="top">
						<table width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td><br><p>Division:<br />{{ $division_acronym }}<br /><br /></p></td>
							</tr>
						</table>      
						<p>Amount:</p><p class="font-weight-bold">Php {{ $total_rs_pap_amount }}</p></td>
				</tr>
				<tr>
					<td height="30">Office</td>
					<td colspan="2" class="text-left">&nbsp;{{ $office }}</td>
				</tr>
				<tr>
					<td height="30">Address</td>
					<td colspan="2" class="text-left">&nbsp;{{ $address }}</td>
				</tr>
				<tr>
					<td colspan="3" class="text-left"><p>&nbsp;&nbsp;Particulars:</p><p>&nbsp;&nbsp;<?php echo nl2br($particulars); ?><br />	<br /></p></td>
				</tr>
			</table>
			<?php
				$is=3;
				$TotalNoOfRecords = $rs_allotment->count();
				if($rs_allotment->count() >= 2) {
					$is=$rs_allotment->count()+2 ;
				}		
				$rowCounter = 0;
			?>
			<table width="100%" class="text-center" cellspacing="0" cellpadding="0">
				<tr class="font-weight-bold">
					<td width="23%">Res. Center / P.A.P.</td>
					<td width="31%">Account Code</td>
					<td width="17%">Amount</td>				
					<td width="29%" rowspan="{{ $is }}" valign="top"  class="font-weight-normal">
						{{ $rs_type }} No:<br>
						<span class="font-weight-bold">{{ $rs_no }}</span><br />
					{{ $rs_date }}<br />				
					Fund Source:&nbsp;<span class="font-weight-bold">{{ $fund }}</span></p></td>
				</tr><?php
				foreach ($rs_allotment as $row) {  ?>							
					<tr class="text-left">
						<td valign="top" >&nbsp;&nbsp;{{ $row->allotment_division_acronym }}: {{ $row->pap_code }}	
							@if($rs_type_id!=1)
								@if($row->activity_code<>NULL) <br>&nbsp; {{ $row->activity_code }}
								@else<br>&nbsp; {{ $row->activity }}  @endif 
							@endif	
						</td>	
						<td valign="top">
							@if($rs_type_id==1)
								@if($row->subactivity<>NULL) &nbsp; {{ $row->subactivity }} <br>@endif 
								&nbsp;&nbsp;{{ $row->object_code }}: {{ $row->object_expenditure }} 
								@if($row->object_specific<>NULL) - {{ $row->object_specific }} <br>@endif 
							@else
								{{-- subactivity --}}
								@if($row->subactivity_code<>NULL) &nbsp; {{ $row->subactivity_code }} <br>
								@else {{ $row->subactivity }} <br>
								@endif 
								{{-- axpense or expenditure --}}
								@if($row->object_expenditure<>NULL) &nbsp; {{ $row->object_code }}: {{ $row->object_expenditure }} 
								@else &nbsp; {{ $row->expense_account_code }}: {{ $row->expense_account }} 
								@endif 
								{{-- specific --}}
								@if($row->object_specific<>NULL) - {{ $row->object_specific }} @endif
							@endif
						</td>
						<td valign="top" class="text-right">{{ number_format($row->rs_amount, 2) }}&nbsp;&nbsp;</td>
					</tr>	
					{{-- @if($rowCounter % 6 == 0 && $rowCounter != $TotalNoOfRecords) <span class="pageBreak"></span> @endif		 --}}
					{{-- @if($rowCounter>=15) <span class="pageBreak"></span> @endif		 --}}
					<?php	
					$rowCounter++;										
				}?>	
				<tr class="font-weight-bold text-right">
					<td colspan="2">Total&nbsp;&nbsp;</td>
					<td>{{ $total_rs_pap_amount }}&nbsp;&nbsp;</td>
				</tr>
			</table>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="3">
							<tr>
								<td colspan="2" valign="top"><strong>B. CERTIFIED</strong><br /><br />
									<table width="80%" cellpadding="0" cellspacing="0">
										<tr>
										<td><span class="smallfont">&nbsp;&nbsp;Allotment available and obligated for the purpose as indicated above</span>
											<p>&nbsp;</p></td>
										</tr>
									</table><br />
								</td>
								<td width="55%" colspan="2" valign="top">
									<table width="100%" cellspacing="0" cellpadding="5">
										<tr>
											<td width="26%" height="26">Signature</td>
											<td width="74%" style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
										<tr>
											<td height="21">Printed Name</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ strtoupper($signatory1b) }}</td>
										</tr>
										<tr>
											<td height="19">Position</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ $signatory1b_position }}</td>
										</tr>
										<tr>
											<td height="19"></td>
											<td>Head, Budget Section/Unit/Authorized Representative</td>
										</tr>
										<tr>
											<td height="21">Date</td>
											<td style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" class="text-center font-weight-bold" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="8">
									<table width="100%"  cellspacing="0" cellpadding="0">
										<tr>
											<td class="text-left">&nbsp;C.
												STATUS OF @if($rs_type_id==1) OBLIGATION @else UTILIZATION @endif</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3">Reference</td>
								<td colspan="5">Amount</td>
							</tr>
							<tr>
								<td width="12%" rowspan="2">Date</td>
								<td width="12%" rowspan="2">@if($rs_type_id==1) ORS No. @else BURS No. @endif</td>
								<td width="11%" rowspan="2">JEV/Check/ADA/<br />TRA No.</td>
								<td width="14%" rowspan="2">@if($rs_type_id==1) Obligation @else Utilization @endif</td>
								<td width="13%" rowspan="2">Payment</td>
								<td width="12%" rowspan="2">Payable</td>
								<td colspan="2">Balance</td>
							</tr>
							<tr>
								<td width="13%">Not Yet Due</td>
								<td width="13%">Due &amp; Demandable</td>
							</tr>
							<tr class="font-weight-normal">
								<td>{{ $rs_date }}</td>
								<td>{{ $rs_no }}</td>
								<td>&nbsp;</td>
								<td class="text-right">{{ $total_rs_pap_amount }}</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html> 