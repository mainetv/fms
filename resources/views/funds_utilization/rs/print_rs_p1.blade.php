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
				.display_screen{
					padding: 0 10cm 0cm 10cm;
				}
				body,td,th {
					font-family: Verdana, Geneva, sans-serif;
					font-size: 12px;
				}
				.smallfont {
					font-size:10px ;
				}
				.title-font{
					font-size:16px ;
				}
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
			$request_status_type = $row->request_status_type;	
			$rs_type = $row->rs_type;	
			$rs_date = $row->rs_date;	
			$rs_year = date('Y', strtotime($rs_date));
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
			$total_rs_activity_amount = $row->total_rs_activity_amount;	
			$signatory1 = $row->signatory1;	
			$signatory1_position = $row->signatory1_position;	
			$signatory2 = $row->signatory2;	
			$signatory2_position = $row->signatory2_position;	
			$signatory3 = $row->signatory3;	
			$signatory3_position = $row->signatory3_position;
			$signatory4 = $row->signatory4;	
			$signatory4_position = $row->signatory4_position;			
		}
		$total_rs_activity_amount = number_format($total_rs_activity_amount, 2);
		$qr_code=$rs_year ."O" . sprintf('%08d', $rs_id);
		$decimal=substr(strrchr($total_rs_activity_amount, "."), 1);
		$cents=" PESOS" ;
		if($decimal > 0) {
			$cents=" PESOS AND " . strtoupper(convert_number_to_words($decimal)) . " CENTAVOS";
		}
		elseif($decimal == 01) {
			$cents=" PESOS AND " . strtoupper(convert_number_to_words($decimal)) . " CENTAVOS";
		}	
		?>
		<button class="btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
		<br><br>
		<div class="display_screen">
			Page 1 of 2<br />
			<table width="100%" class="text-center" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="3">
						<table width="98%" class="table-borderless" cellspacing="0" cellpadding="0">
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
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
							<tr>
								<td><br/><p>Division:<br />{{ $division_acronym }}<br /><br /></p></td>
							</tr>
						</table>      
						<p>Amount:<br/><strong>Php {{ $total_rs_activity_amount }}</strong></p>
					</td>
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
					<td height="138" colspan="3" class="text-left" valign="top">
						<table width="97%" class="table-borderless" cellpadding="0" cellspacing="0">
							<tr>
								<td>&nbsp;&nbsp;Particulars:<br/><br>&nbsp;&nbsp;<?php echo nl2br($particulars); ?></td>
							</tr>
							<tr>
								<td>
									<table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
										<tr>
											<td height="23" colspan="4">&nbsp;</td>
										</tr>
										<tr>
											<td height="23" colspan="4">&nbsp;&nbsp;Charged to:</td>
										</tr>
										@foreach ($rs_activity as $row)
											<tr>
												<td width="7%">&nbsp;</td>
												<td width="63%"><i>{{ $row->allotment_division_acronym }}</i>:													
													@if($rs_type_id==1)
														{{ $row->activity }}
														@if($row->subactivity<>NULL) - {{ $row->subactivity }} <br>@endif 
													@else
														@if($row->activity_code<>NULL) {{ $row->activity_code }} <br>
														@else {{ $row->activity }} <br> @endif 
														@if($row->subactivity<>NULL) {{ $row->subactivity }} <br>@endif 														
													@endif
												<td width="25%" class="text-right">Php{{ number_format($row->amount, 2) }}</td>
												<td width="5%" class="text-right">&nbsp;</td>
											</tr>
										@endforeach
										<tr>
											<td>&nbsp;</td>
											<td class="text-right"><strong>TOTAL</strong></td>
											<td class="text-right" style="border-top:thin; border-top-style:solid"><strong>Php{{ $total_rs_activity_amount }}</strong></td>
											<td class="text-right">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
						</table><p><br /> </p>
					</td>
				</tr>
				<tr>
					<td height="96" colspan="4" class="text-left" valign="top">
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
							<tr>
								<td height="79" colspan="2" valign="top"><strong>A. CERTIFIED</strong><br />
									<table width="98%" class="table-borderless" cellpadding="0" cellspacing="0">
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>&emsp;[&nbsp;&nbsp;&nbsp;]&nbsp;&nbsp;Charges to appropriation/allotment necessary, lawful and under my direct supervision
												<span class="smallfont"><br /></span>&emsp;[&nbsp;&nbsp;&nbsp;]&nbsp;&nbsp;Supporting documents valid, proper and legal             
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="139" valign="top">
								<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
									<tr>
										<td width="26%" height="26" class="text-right">Signature:</td>
										<td width="74%" style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
									</tr>
									<tr>
										<td height="21" class="text-right">Printed Name:</td>
										<td style="border-bottom:thin; border-bottom-style:solid">{{ strtoupper($signatory1) }}</td>
									</tr>
									<tr>
										<td height="19" class="text-right">Position:</td>
										<td style="border-bottom:thin; border-bottom-style:solid">{{ $signatory1_position }}</td>
									</tr>
									<tr>
										<td height="19" class="text-right"></td>
										<td>Head Requesting Office/ Authorized Representative</td>
									</tr>
									<tr>
										<td height="21" class="text-right">Date:</td>
										<td style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
									</tr>
								</table>
								</td>
								<td valign="top">
									@if($signatory2 <> "")
									<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
										<tr>
											<td width="26%" height="26" class="text-right">Signature:</td>
											<td width="74%" style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
										<tr>
											<td height="21" class="text-right">Printed Name</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ strtoupper($signatory2) }}</td>
										</tr>
										<tr>
											<td height="19" class="text-right">Position:</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ $signatory2_position }}</td>
										</tr>
										<tr>
											<td height="21" class="text-right">Date:</td>
											<td style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
									</table>
									@endif				
								</td>
							</tr>
							<tr>
								<td width="45%" valign="top">
									@if($signatory3 <> "")
									<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
										<tr>
											<td width="26%" height="26" class="text-right">Signature:</td>
											<td width="74%" style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
										<tr>
											<td height="21" class="text-right">Printed Name</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ strtoupper($signatory3) }}</td>
										</tr>
										<tr>
											<td height="19" class="text-right">Position:</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ $signatory3_position }}</td>
										</tr>
										<tr>
											<td height="21" class="text-right">Date:</td>
											<td style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
									</table>
									@endif
								</td>
								<td width="55%" valign="top">
									@if($signatory4 <> "")
									<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
										<tr>
											<td width="26%" height="26" class="text-right">Signature:</td>
											<td width="74%" style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
										<tr>
											<td height="21" class="text-right">Printed Name</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ strtoupper($signatory4) }}</td>
										</tr>
										<tr>
											<td height="19" class="text-right">Position:</td>
											<td style="border-bottom:thin; border-bottom-style:solid">{{ $signatory4_position }}</td>
										</tr>
										<tr>
											<td height="21" class="text-right">Date:</td>
											<td style="border-bottom:thin; border-bottom-style:solid">&nbsp;</td>
										</tr>
									</table>
									@endif
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
				<td height="68" colspan="4" class="text-left" valign="top">
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
							<tr>
								<td><strong>&nbsp;&nbsp;Supporting Documents:</strong><br /><br />
									@foreach($rs_documents as $key=>$item)					
										@if ($key % 1 == 0)
										<tr>
										@endif
											<td>&nbsp;&nbsp;- {{ $item->document }}</td>
										@if (($key + 1) % 1 == 0)
										</tr>
										@endif		
									@endforeach
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<br><br>
	</body>
</html> 