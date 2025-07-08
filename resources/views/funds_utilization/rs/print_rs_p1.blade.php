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
					font-size:25px ;op
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
			<table width="100%" class="text-center" border="2" cellspacing="0" cellpadding="4">
				<tr>
					<td colspan="3" class="bottom-border-2">
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
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
						<div >
							<span class="label-sn">Serial No.:</span>
							<span class="underline-sn"></span>
						</div>
						<div>
							<span class="label-sn">Date:</span>
							<span class="underline-sn">{{ $rs_date }}</span>
						</div>
						<div>
							<span class="label-sn">Fund Cluster:</span>
							<span class="underline-sn"></span>
						</div>
					</td>

					{{-- <td>
						{!! QrCode::size(160)->generate('{{ $qr_code }}') !!}<br />
						{{ $qr_code }}
					</td> --}}
				</tr>	
				<tr>
					<tr>
						<td width="8%" height="30">Payee</td>
						<td width="90%" colspan="4" class="text-left">{{ $payee }}</td>
					</tr>
					<tr>
						<td height="30">Office</td>
						<td colspan="4" class="text-left">{{ $office }}</td>
					</tr>
					<tr>
						<td height="30">Address</td>
						<td colspan="4" class="text-left">{{ $address }}</td>
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
					<td width="8%" class="text-center">{{ $division_acronym }}</td>
					<td width="35%" height="79">{!! nl2br(e($particulars)) !!}</td>
					<td colspan="3" class="rs">
						<table width="100%" class="full-height-table" cellspacing="0" cellpadding="4">
							@foreach ($rs_activity->filter() as $row)
								<tr>
									<td valign="top" width="42%" class="no-bottom-border no-left-border"><i>{{ $row->allotment_division_acronym }}</i>:													
										@if($rs_type_id==1)
											{{ $row->activity }}
											@if(!empty($row->subactivity)) - {{ $row->subactivity }} <br>@endif
										@else
											@if($row->activity_code<>NULL) {{ $row->activity_code }} <br>
											@else {{ $row->activity }} <br> @endif 
											@if($row->subactivity<>NULL) {{ $row->subactivity }} <br>@endif 														
										@endif
									</td>
									<td valign="top" width="32%" class="no-bottom-border">{{ $row->object_code }}</td>
									<td valign="top" class="text-right no-bottom-border no-right-border" nowrap>₱ {{ number_format($row->amount, 2) }}</td>
								</tr>
							@endforeach
						</table>									
					</td>
				</tr>	
				<tr>
					<td height="96" colspan="5" class="text-left top-border-2" valign="top">
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="4">
							<tr>
								<td height="60" colspan="2" valign="top"><strong>A. Certified: </strong>
									Charges to appropriation/alloment are necessary,
									lawful and under my direct supervision;
									and supporting documents valid, proper and legal <br />									
								</td>
							</tr>
							<tr>
								<td width="50%" height="139" valign="top">
									<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
										<tr>
											<td width="30%" height="26" class="text-left cell-padleft-1">Signature:</td>
											<td class="bottom-border-1"></td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-1">Printed Name:</td>
											<td class="bottom-border-1">{{ strtoupper($signatory1)  }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-1">Position:</td>
											<td class="bottom-border-1">{{ $signatory1_position }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-1"></td>
											<td class="bottom-border-1">Head, Requesting Office/Authorized Representative</td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-1">Date:</td>
											<td class="bottom-border-1"></td>
										</tr>
									</table>
								</td>
								<td width="50%" height="139" valign="top">
									@if($signatory2 <> "")
									<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
										<tr>
											<td width="30%" height="26" class="text-left cell-padleft-2">Signature:</td>
											<td class="bottom-border-1"></td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-2">Printed Name:</td>
											<td class="bottom-border-1">{{ strtoupper($signatory2) }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-2">Position:</td>
											<td class="bottom-border-1">{{ $signatory2_position }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-1"></td>
											<td class="bottom-border-1">Head, Requesting Office/Authorized Representative</td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-2">Date:</td>
											<td class="bottom-border-1"></td>
										</tr>
									</table>
									@endif				
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td width="50%" valign="top">
									@if($signatory3 <> "")
									<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
										<tr>
											<td width="30%" class="text-left cell-padleft-1">Signature:</td>
											<td class="bottom-border-1"></td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-1">Printed Name</td>
											<td class="bottom-border-1">{{ strtoupper($signatory3) }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-1">Position:</td>
											<td class="bottom-border-1">{{ $signatory3_position }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-1"></td>
											<td class="bottom-border-1">Head, Requesting Office/Authorized Representative</td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-1">Date:</td>
											<td class="bottom-border-1"></td>
										</tr>
									</table>
									@endif
								</td>
								<td width="50%" valign="top">
									@if($signatory4 <> "")
									<table width="100%" class="table-borderless" cellspacing="0" cellpadding="5">
										<tr>
											<td width="30%" height="26" class="text-left cell-padleft-2">Signature:</td>
											<td class="bottom-border-1"></td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-2">Printed Name</td>
											<td class="bottom-border-1">{{ strtoupper($signatory4) }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-2">Position:</td>
											<td class="bottom-border-1">{{ $signatory4_position }}</td>
										</tr>
										<tr>
											<td height="19" class="text-left cell-padleft-1"></td>
											<td class="bottom-border-1">Head, Requesting Office/Authorized Representative</td>
										</tr>
										<tr>
											<td height="21" class="text-left cell-padleft-2">Date:</td>
											<td class="bottom-border-1"></td>
										</tr>
									</table>
									@endif
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>			
			<table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						@if ($rs_documents->count() > 0)
							<strong>&nbsp;Supporting Documents:</strong>
						@endif
						<span class="float-right">Date Printed: {{ $now }}</span>
						<br />
						@if ($rs_documents->count() > 0)
							@foreach($rs_documents as $key=>$item)					
								@if ($key % 1 == 0)
								<tr>
								@endif
									<td>&nbsp;&nbsp;- {{ $item->document }}</td>
								@if (($key + 1) % 1 == 0)
								</tr>
								@endif		
							@endforeach
						@endif
					</td>							
				</tr>
			</table>			
		</div>
		<br><br>
	</body>
</html> 