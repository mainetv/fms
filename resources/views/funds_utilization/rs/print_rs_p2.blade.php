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
			<table width="100%" class="text-center" border="2" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="3" class="bottom-border-2">
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="3">
							<tr>
								<td><br><p class="title-font"><strong>{{ strtoupper($rs_type) }}</strong></p></td>
							</tr>
							<tr>
								<td>Republic of the Philippines<br />
									<p class="smallfont">DEPARTMENT OF SCIENCE AND TECHNOLOGY<br />
									<strong>PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</strong><br />
									LOS BANOS, LAGUNA</p></td>
							</tr>
						</table>
					</td>
					<td colspan="2" class="text-left bottom-border-2 left-border-2">
						&nbsp;Serial No.: _______________<br>
						&nbsp;Date: _______________<br>
						&nbsp;Fund Cluster:_______________
					</td>
					{{-- <td>
						{!! QrCode::size(160)->generate('{{ $qr_code }}') !!}<br />
						{{ $qr_code }}
					</td> --}}
				</tr>
				<tr>
					<tr>
						<td width="8%" height="30">Payee</td>
						<td width="90%" colspan="4" class="text-left">&nbsp;{{ $payee }}</td>
					</tr>
					<tr>
						<td height="30">Office</td>
						<td colspan="4" class="text-left">&nbsp;{{ $office }}</td>
					</tr>
					<tr>
						<td height="30">Address</td>
						<td colspan="4" class="text-left">&nbsp;{{ $address }}</td>
					</tr>
				</tr>
				<tr class="top-border-2 bottom-border-2">					
					<td width="8%">Responsibility Center</td>
					<td width="32%">Particulars</td>
					<td width="24%">MFO/PAP</td>
					<td width="18%">UACS Object Code</td>
					<td width="18%">Amount</td>
				</tr>
				<tr class="text-left">
					<td width="8%" class="text-center" height="79">{{ $division_acronym }}</td>
					<td width="35%" height="79">{{ nl2br($particulars) }}</td>
					<td height="79" colspan="3">
						<table width="100%"><?php
							$is=3;
							$TotalNoOfRecords = $rs_allotment->count();
							if($rs_allotment->count() >= 2) {
								$is=$rs_allotment->count()+2 ;
							}		
							$rowCounter = 0;							
							foreach ($rs_allotment as $row){ ?>			
								<tr class="text-left">
									<td valign="top" width="42%" class="no-bottom-border no-left-border">{{ $row->allotment_division_acronym }}: {{ $row->pap_code }}<br>	<br>
										@if($rs_type_id!=1)
											@if($row->activity_code<>NULL) <br> {{ $row->activity_code }}
											@else<br> {{ $row->activity }}  @endif
											<br>	
											{{-- subactivity --}}
											@if($row->subactivity_code<>NULL) {{ $row->subactivity_code }} <br>
											@else {{ $row->subactivity }} 
											@endif	
										@else
											@if($row->subactivity<>NULL)  {{ $row->subactivity }} <br>@endif 								
										@endif
										
									</td>	
									<td valign="top" width="32%" class="no-bottom-border">
										@if($rs_type_id==1)											
											{{ $row->object_code }}: {{ $row->object_expenditure }} 
											@if($row->object_specific<>NULL) - {{ $row->object_specific }} <br>@endif 
										@else											 
											{{-- axpense or expenditure --}}
											@if($row->object_expenditure<>NULL) {{ $row->object_code }}: {{ $row->object_expenditure }} 
											@else {{ $row->expense_account_code }}: {{ $row->expense_account }} 
											@endif 
											{{-- specific --}}
											@if($row->object_specific<>NULL) - {{ $row->object_specific }} @endif
										@endif
									</td>
									<td valign="top" class="text-right no-bottom-border no-right-border">₱ {{ number_format($row->rs_amount, 2) }}&nbsp;</td>
								</tr>	<?php	
								$rowCounter++;	
							}?>
							{{-- @foreach ($rs_activity as $row)
							<tr>
								<td width="56%" class="no-bottom-border no-left-border"><i>{{ $row->allotment_division_acronym }}</i>:													
									@if($rs_type_id==1)
										{{ $row->activity }}
										@if($row->subactivity<>NULL) - {{ $row->subactivity }} <br>@endif 
									@else
										@if($row->activity_code<>NULL) {{ $row->activity_code }} <br>
										@else {{ $row->activity }} <br> @endif 
										@if($row->subactivity<>NULL) {{ $row->subactivity }} <br>@endif 														
									@endif
								</td>
								<td width="21%" class="text-center no-bottom-border"></td>
								<td class="text-right no-bottom-border no-right-border">Php{{ number_format($row->amount, 2) }}&nbsp;</td>
							</tr>
						@endforeach --}}
						</table>									
					</td>					
				</tr>	
				<tr>
					<td height="96" colspan="5" class="text-left top-border-2" valign="top">
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
							<tr>
								<td height="60" colspan="2" valign="top"><strong>B. Certified: </strong>
									Allotment available and obligated for the purpose/adjustment necessary as indicated above<br />									
								</td>
							</tr>
							<tr>
								<td height="139" valign="top">
									<table width="50%" class="table-borderless" cellspacing="0" cellpadding="5">
										<tr>
											<td width="30%" height="26" class="text-left cell-padleft-1">Signature:</td>
											<td width="70%" style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-1">Printed Name:</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ strtoupper($signatory1b) }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-1">Position:</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ $signatory1b_position }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-1"></td>
											<td class="text-center">Head, Budget Division/Unit/Authorized Representative</td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-1">Date:</td>
											<td style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
									</table><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<table width="100%" class="text-center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="8">
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td class="font-weight-bold text-left no-right-border">&nbsp;C.</td>
											<td class="font-weight-bold no-left-border">STATUS OF @if($rs_type_id==1) OBLIGATION @else UTILIZATION @endif</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3" class="font-weight-bold bottom-border-2 right-border-2">Reference</td>
								<td colspan="5" class="font-weight-bold bottom-border-2">Amount</td>
							</tr>
							<tr>
								<td width="9%" rowspan="3" class="right-border-2 bottom-border-2">Date</td>
								{{-- <td width="12%" rowspan="3">@if($rs_type_id==1) ORS No. @else BURS No. @endif</td> --}}
								<td width="13%" rowspan="3" class="right-border-2 bottom-border-2">Particulars</td>
								<td width="13%" rowspan="3" class="right-border-2 bottom-border-2">@if($rs_type_id==1) ORS @else BURS @endif/JEV/Check/ADA/<br />TRA No.</td>
								<td width="13%" rowspan="2" class="right-border-2 bottom-border-2">@if($rs_type_id==1) Obligation @else Utilization @endif</td>
								<td width="13%" rowspan="2" class="right-border-2 bottom-border-2">Payment</td>
								<td width="13%" rowspan="2" class="right-border-2 bottom-border-2">Payable</td>
								<td colspan="2" class="bottom-border-2">Balance</td>
							</tr>
							<tr>
								<td width="13%" class="right-border-2 bottom-border-2">Not Yet Due</td>
								<td width="13%" class="bottom-border-2">Due and Demandable</td>
							</tr>
							<tr class="bottom-border-2">
								<td class="right-border-2">(a)</td>
								<td class="right-border-2">(b)</td>
								<td class="right-border-2">(c)</td>
								<td class="right-border-2">(a-b)</td>
								<td>(b-c)</td>
							</tr>
							<tr class="font-weight-normal">
								<td>{{ $rs_date }}</td>
								<td>{{ $rs_no }}</td>
								<td class="right-border-2">&nbsp;</td>
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