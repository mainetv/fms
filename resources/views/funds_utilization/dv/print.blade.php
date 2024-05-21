<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - DV</title>
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
					font-size: 10px;
				}
				.title-font{
					font-size: 16px;
				}
			}
			@media print{
				body,td,th {
					font-family: Verdana, Geneva, sans-serif;
					font-size: 15px;
				}
				.title-font{
					font-size: 22px;
				}
			}
		</style>
		<SCRIPT LANGUAGE="JavaScript">
			document.addEventListener('contextmenu', function(e) {
				e.preventDefault();
			});
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
		foreach ($dv_data as $row){
			$dv_id = $row->id;	
			$dv_date = $row->dv_date;				
			$payee = $row->payee;	
			$division_acronym = $row->division_acronym;	
			$tin = $row->tin;	
			$dv_no = $row->dv_no;	
			$address = $row->address;	
			$payee_bank = $row->payee_bank;	
			$payee_bank_acronym = $row->payee_bank_acronym;	
			$payee_bank_short_name = $row->payee_bank_short_name;	
			$total_dv_gross_amount = $row->total_dv_gross_amount;	
			$payee_bank_account_no = $row->payee_bank_account_no;	
			$contact_no = $row->contact_no;	
			$particulars = $row->particulars;					
			$signatory1 = $row->signatory1;	
			$signatory1_position = $row->signatory1_position;	
			$signatory2 = $row->signatory2;	
			$signatory2_position = $row->signatory2_position;				
			$check_no = $row->check_no;				
			$or_no = $row->or_no;				
		}
		$dv_amount = $total_dv_gross_amount;
		$dv_month = date('m', strtotime($dv_date));
		$dv_year = date('Y', strtotime($dv_date));
		$total_dv_gross_amount = number_format($dv_amount, 2);
		$qr_code=$dv_year ."D" . sprintf('%08d', $dv_id);
		$decimal=substr(strrchr($total_dv_gross_amount, "."), 1);
		$cents=" PESOS" ;
		if($decimal > 0) {
			$cents=" PESOS AND " . strtoupper(convert_number_to_words($decimal)) . " CENTAVOS";
		}
		elseif($decimal == 01) {
			$cents=" PESOS AND " . strtoupper(convert_number_to_words($decimal)) . " CENTAVOS";
		}	
		?>
		<button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
		<br class="noprint"><br class="noprint">
		<div class="display_screen">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
				<td colspan="3">
						<table width="100%" class="table-borderless text-center" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<p>Republic of the Philippines<br />
									DEPARTMENT OF SCIENCE AND TECHNOLOGY<br />
									<strong>PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</strong><br />
									<span>LOS BANOS, LAGUNA</span></p>
									<p class="title-font"><strong>DISBURSEMENT VOUCHER</strong></p>
								</td>
								<td>
									{!! QrCode::size(95)->generate('{{ $qr_code }}') !!}<br />
									{{ $qr_code }}
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
				<td colspan="3">
						<table width="100%">
							<tr>
								<td valign="top">&nbsp;Mode of Payment</td>
								<td colspan="2" valign="top">&emsp;&emsp;[&emsp;] Check&emsp;&emsp;&emsp;&emsp;[&emsp;] Cash&emsp;&emsp;&emsp;&emsp;[&emsp;] Others</td>
								<td valign="top">&nbsp;DV No.</td>
							</tr>
							<tr>
								<td height="42" valign="top">&nbsp;Payee</td>
								<td width="38%" valign="top">&nbsp;<strong>{{ $payee }}</strong></td>       
								<td width="28%" valign="top">&nbsp;TIN / Employee No.<br /><strong>&nbsp;{{ $tin }}</strong></td>
								<td width="26%" valign="top">&nbsp;ORS/BURS No.<br /><strong>
									@foreach ($dv_rs as $row)
									&nbsp;{{ $row->rs_no }}
										<br>
									@endforeach</strong></td>
							</tr>
							<tr>
								<td rowspan="2" valign="top">&nbsp;Address</td>
								<td rowspan="2" valign="top">&nbsp;<strong>{{ $address }}</strong></td>
								<td colspan="2" class="text-center" valign="top">Responsibility Center</td>
							</tr>
							<tr>
								<td height="42" valign="top">&nbsp;Office/Unit/Project<strong><br />&nbsp;{{ $division_acronym }}</strong></td>
								<td valign="top">&nbsp;Code</td>
							</tr>
							<tr>
								<td height="26" colspan="2" valign="top">&nbsp;Bank : &emsp;{{ $payee_bank_short_name }}&emsp;&emsp;&emsp;&emsp;Bank Acct. No.&emsp;{{ $payee_bank_account_no }}</td>
								<td height="26" colspan="2" valign="top">&nbsp;Contact Number: &emsp;{{ $contact_no }}</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
				<td colspan="3" class="text-center">
						<table width="100%" cellspacing="0" cellpadding="5">
							<tr>
								<td width="74%" height="25"><strong>EXPLANATION</strong></td>
								<td width="26%"><strong>AMOUNT</strong></td>
							</tr>
							<tr>
								<td height="109" valign="top" class="text-left"><strong><?php echo nl2br($particulars); ?></strong></td>
								<td class="text-right" valign="top"><strong>{{ $total_dv_gross_amount }}&emsp;</strong></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
				<td colspan="3">
						<table width="100%" border="1" cellspacing="0" cellpadding="5">
							<tr>
								<td height="54" colspan="3" valign="top"><p><strong>A. CERTIFIED</strong><br />          
								&nbsp;&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;] <span>Cash available</span><br />          
								&nbsp;&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;] <span>Subject to Authority to Debit Account (where applicable)<br />
								&nbsp;&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;] Supporting documents complete        </span></p></td>
								<td colspan="3" valign="top"><p><strong>B. APPROVED FOR PAYMENT</strong><br />          
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
								<p>{{ strtoupper(convert_number_to_words($dv_amount)) }}{{ $cents }}</p></td>
							</tr>
							<tr>
								<td width="14%" height="24" valign="top">Signature</td>
								<td width="25%" valign="top">&nbsp;</td>
								<td width="10%" valign="top">Date</td>
								<td width="14%" height="24" valign="top">Signature</td>
								<td width="25%" valign="top">&nbsp;</td>
								<td width="12%" valign="top">Date</td>
							</tr>
							<tr class="font-weight-bold">
								<td height="26">Printed Name</td>
								<td height="26" colspan="2">{{ $signatory1 }}</td>
								<td height="26">Printed Name</td>
								<td height="26" colspan="2">{{ $signatory2 }}</td>
							</tr>
							<tr class="font-weight-bold">
								<td rowspan="2">Position</td>
								<td height="26" colspan="2">{{ $signatory1_position }}</td>
								<td rowspan="2">Position</td>
								<td height="26" colspan="2">{{ $signatory2_position }}</td>
							</tr>
							<tr>
								<td height="24" colspan="2" class="text-center">Head, Accounting Unit/Authorized Representative</td>
								<td height="24" colspan="2" class="text-center">Treasurer/Authorized Representative</td>
							</tr>
							<tr>
								<td height="26" colspan="6"><strong>C. RECEIVED PAYMENT</strong></td>
							</tr>
							<tr>
								<td width="14%">Check No.</td>
								<td height="24">&nbsp;{{ $check_no }}</td>
								<td height="24" colspan="2">Date</td>
								<td colspan="2" rowspan="3" valign="top">JEV No.</td>
							</tr>
							<tr>
								<td>Signature</td>
								<td height="24">&nbsp;</td>
								<td height="24" colspan="2" valign="top">Date</td>
							</tr>
							<tr>
								<td>Printed Name</td>
								<td height="26" colspan="3"><strong>{{ $payee }}</strong></td>
								</tr>
							<tr>
								<td valign="top">OR/Other Documents</td>
								<td height="40" class="text-center">&nbsp;{{ $or_no }}</td>
								<td height="40" colspan="2" class="text-left" valign="top">Date</td>
								<td height="40" colspan="2" class="text-left" valign="top">Date</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
				<tr>
					{{-- <td class="text-right">Date Printed: <strong>{{ date('l jS \of F Y h:i:s A') }}</strong></td> --}}
					<td class="text-right">Date Printed: <strong>{{ $now }}</strong></td>
				</tr>
				<tr>
					<td><p><strong>Supporting Documents:</strong>
						<table width="98%" class="table-borderless" cellspacing="0" cellpadding="0">						
							@foreach($dv_documents as $key=>$item)					
								@if ($key % 2 == 0)
								<tr>
								@endif
									<td>- {{ $item->document }}</td>
								@if (($key + 1) % 2 == 0)
								</tr>
								@endif		
							@endforeach
						</table>
					</td>
				</tr>
			</table>
		</div>
		<br><br>
	</body>
</html> 