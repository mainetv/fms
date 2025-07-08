<?php use App\Models\DvRsAccount; ?>
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
			$payee_bank_account_name = $row->payee_bank_account_name;	
			$payee_bank_account_no = $row->payee_bank_account_no;	
			$contact_no = $row->contact_no;	
			$particulars = $row->particulars;					
			$signatory1 = $row->signatory1;	
			$signatory1_position = $row->signatory1_position;	
			$signatory2 = $row->signatory2;	
			$signatory2_position = $row->signatory2_position;		
			$signatory3 = $row->signatory3;	
			$signatory3_position = $row->signatory3_position;					
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
						<table width="100%" class="text-center"  cellspacing="0" cellpadding="4">
							<tr>
								<td rowspan="2">
									<p>Republic of the Philippines<br />
									DEPARTMENT OF SCIENCE AND TECHNOLOGY<br />
									<strong>PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</strong><br />
									<span>LOS BANOS, LAGUNA</span></p>
									<p class="title-font"><strong>DISBURSEMENT VOUCHER</strong></p>
								</td>
								
								<td class="text-left">
									Fund Cluster:
								</td>
								{{-- <td>
									{!! QrCode::size(95)->generate('{{ $qr_code }}') !!}<br />
									{{ $qr_code }}
								</td> --}}
							</tr>
							<tr>
								<td class="text-left">
									Date: {{ $dv_date }}<br>
									DV No: {{ $dv_no }}
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<table width="100%">
							<tr>
								<td valign="top">&nbsp;Mode of <br>&nbsp;Payment</td>
								<td colspan="3">&emsp;
									<input type="checkbox"> MDS Check&emsp;
									<input type="checkbox"> Commercial Check&emsp;
									<input type="checkbox"> ADA&emsp;
									<input type="checkbox"> Others (Please specify)&emsp;
								</td>
								{{-- <td colspan="2" valign="top">&emsp;&emsp;[&emsp;] Check&emsp;&emsp;&emsp;&emsp;[&emsp;] Cash&emsp;&emsp;&emsp;&emsp;[&emsp;] Others</td> --}}
								{{-- <td valign="top">&nbsp;DV No.</td> --}}
							</tr>
							<tr>
								<td height="42" valign="top">&nbsp;Payee</td>
								<td width="38%" valign="top">&nbsp;<strong>{{ $payee }}</strong></td>       
								<td width="28%" valign="top">&nbsp;TIN / Employee No.<br /><strong>&nbsp;{{ $tin }}</strong></td>
								<td width="26%" valign="top">&nbsp;ORS/BURS No.<br /><strong>
									@foreach ($dvRsNet as $row)
									&nbsp;{{ $row->rs_no }}
										<br>
									@endforeach</strong></td>
							</tr>
							<tr>
								<td valign="top">&nbsp;Address</td>
								<td colspan="3" valign="top">&nbsp;<strong>{{ $address }}</strong></td>
								{{-- <td colspan="2" class="text-center" valign="top">Responsibility Center</td> --}}
							</tr>
							{{-- <tr>
								<td height="42" valign="top">&nbsp;Office/Unit/Project<strong><br />&nbsp;{{ $division_acronym }}</strong></td>
								<td valign="top">&nbsp;Code</td>
							</tr>
							<tr>
								<td height="26" colspan="2" valign="top">&nbsp;Bank : &emsp;{{ $payee_bank_short_name }}&emsp;&emsp;&emsp;&emsp;Bank Acct. No.&emsp;{{ $payee_bank_account_no }}</td>
								<td height="26" colspan="2" valign="top">&nbsp;Contact Number: &emsp;{{ $contact_no }}</td>
							</tr> --}}
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="text-center">
						<table width="100%" cellspacing="0" cellpadding="5">
							<tr>
								<td width="62%" height="25"><strong>Particulars</strong></td>
								<td width="10%">Responsibility Center</td>
								<td width="6%" nowrap>MFO/PAP</td>
								<td width="22%" nowrap><strong>AMOUNT</strong></td>
							</tr>
							<tr>
								<td height="109" valign="top" class="text-left"><strong><?php echo nl2br($particulars); ?></strong>
								</td>								
								<td rowspan="2" valign="top"><strong>{{ $division_acronym }}</strong></td>
								<td rowspan="2"></td>
								<td class="text-right" valign="top" nowrap></td>
							</tr>
							<tr class="left-border-2">
								<td class="no-border"  style="border:0; border-spacing: 0;">										
									<strong>Amount Due</strong>
								</td>
								<td class="text-right" nowrap><strong>{{ $total_dv_gross_amount }}&emsp;</strong></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<table width="100%" cellspacing="0" cellpadding="1">
							<tr>
								<td width="1%" class="font-weight-bold">A.</td>
								<td valign="top">Certified: Expenses/Cash Advance necessary,  lawful and  incurred under my direct supervision.						        
									{{-- &nbsp;&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;] <span>Cash available</span><br />          
									&nbsp;&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;] <span>Subject to Authority to Debit Account (where applicable)<br />
									&nbsp;&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;] Supporting documents complete        </span></p></td> --}}
									{{-- <td colspan="3" valign="top"><p><strong>B. APPROVED FOR PAYMENT</strong><br />          
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
									<p>{{ strtoupper(convert_number_to_words($dv_amount)) }}{{ $cents }}</p></td> --}}
								</td>							
							</tr>
							<tr>
								<td class="text-center font-weight-bold" colspan="2" height="80" valign="bottom" style="border-bottom: none">
									<div style="border-bottom: 1px solid #000; width: 400px; margin: 0 auto;">
										{{ $signatory1 }} - {{ $signatory1_position }}
									</div>
								</td>
							</tr>
							<tr>
								<td class="text-center"  colspan="2" valign="bottom" style="border-top: none">
								Printed Name, Designation and Signature of Supervisor</td>
							</tr>
						</table>
						<table width="100%" class="table-borderless" cellspacing="0" cellpadding="1">
							<tr>
								<td width="1%" class="font-weight-bold with-border" >B.</td>
								<td colspan="5" valign="top" class="with-border">Accounting Entry:</td>
							</tr>
							<tr class="text-center">
								<td colspan="2" class="with-border">Account Title</td>
								<td class="with-border">UACS Code</td>
								<td class="with-border">Debit</td>
								<td class="with-border">Credit</td>
							</tr>	
							@foreach($dvRsNet as $row)
								@php
									$rs_id = $row->rs_id;
									$dv_rs_net_id = $row->id;

									// Get ONLY ONE row for this rs_id to describe the DvRsNet row
									$rsRow = DB::table('view_rs_pap')->where('rs_id', $rs_id)->first();

									$dvAccounts = \App\Models\DvRsAccount::with('chartAccount')
										->whereNULL('deleted_at')
										->where('dv_rs_net_id', $dv_rs_net_id)
										->get();
								@endphp

								{{-- Main DvRsNet row --}}
								<tr>
										<td colspan="2" class="with-left-border">
												@if($rsRow->rs_type_id == 1)
														{{ $rsRow->object_expenditure }}
												@else
														@if($rsRow->object_expenditure != null)
																{{ $rsRow->object_expenditure }}
														@else
																{{ $rsRow->expense_account }}
														@endif

														@if($rsRow->object_specific != null)
																- {{ $rsRow->object_specific }}
														@endif
												@endif
										</td>
										<td height="25" class="text-center with-left-border">{{ $rsRow->object_code }}</td>
										<td height="25" class="text-right with-left-border">{{ number_format($row->gross_amount, 2) }}</td>
										<td height="25" class="text-right with-left-border with-right-border">-</td>
								</tr>

								{{-- Child DvAccount rows --}}
								@foreach ($dvAccounts as $dvAccount)
										<tr class="text-right">
												<td class="with-left-border"></td>
												<td class="text-left">{{ $dvAccount->chartAccount->name }}</td>
												<td class="text-center with-left-border">{{ $dvAccount->chartAccount->uacs }}</td>
												<td class="with-left-border">-</td>
												<td class="with-left-border with-right-border">{{ number_format($dvAccount->amount, 2) }}</td>
										</tr>
								@endforeach
							@endforeach
							<tr height="50">
								<td class="with-left-border"></td>
								<td class="text-left"></td>
								<td class="text-center with-left-border"></td>					
								<td class="with-left-border"></td>	
								<td class="with-left-border with-right-border"></td>
							</tr>
						</table>
						<div class="table-container">
							<table class="half-table" cellspacing="0" cellpadding="1">
								<tr>
								<td width="1px" class="font-weight-bold">C.</td>
								<td colspan="3" valign="top">Certified:</td>
								</tr>
								<tr>
								<td colspan="4">
									&emsp;<input type="checkbox">Cash available <br>
									&emsp;<input type="checkbox">Subject to Authority to Debit Account (when applicable)<br>
									&emsp;<input type="checkbox">Supporting documents complete and amount claimed
								</td>
								</tr>
								<tr>
								<td colspan="2" height="40">Signature</td>
								<td colspan="2" width="85%"></td>
								</tr>
								<tr>
									<td colspan="2">Printed Name</td>
									<td colspan="2" width="85%" class="text-center font-weight-bold">{{ $signatory2 }}</td>
								</tr>
								<tr>
									<td colspan="2" rowspan="2">Position</td>
									<td colspan="2" width="85%" class="text-center font-weight-bold">{{ $signatory2_position }}</td>
								</tr>
								<tr>
									<td colspan="2" width="85%" class="text-center">
											Head, Accounting Unit/Authorized Representative
									</td>
								</tr>
								<tr>
									<td colspan="2">Date</td>
									<td colspan="2" width="85%"></td>
								</tr>
							</table>					  
							<table class="half-table" cellspacing="0" cellpadding="1">
								<tr>
								<td width="1px" class="font-weight-bold">D.</td>
								<td colspan="3" valign="top">Approved for Payment:</td>
								</tr>
								<tr>
								<td colspan="4" height="52"></td>
								</tr>
								<tr>
								<td colspan="2">Signature</td>
								<td colspan="2" width="85%" height="40"></td>
								</tr>
								<tr>
								<td colspan="2">Printed Name</td>
								<td colspan="2" width="85%" class="text-center font-weight-bold">{{ $signatory3 }}</td>
								</tr>
								<tr>
									<td colspan="2" rowspan="2">Position</td>
									<td colspan="2" width="85%" class="text-center font-weight-bold">{{ $signatory3_position }}</td>
								</tr>
								<tr>
									<td colspan="2" width="85%" class="text-center">
											Agency Head/Authorized Representative
									</td>
								</tr>
								<tr>
									<td colspan="2">Date</td>
									<td colspan="2" width="85%"></td>
								</tr>
							</table>
						</div>
						<table width="100%" cellspacing="0" cellpadding="1">
							<tr>
								<td width="1px" class="font-weight-bold">E.</td>
								<td colspan="4" valign="top">Receipt of Payment </td>
								<td rowspan="2" valign="top" width="10%">JEV  No.</td>
							</tr>
							<tr>
								<td colspan="2">Check/ADA No.:</td>
								<td width="30%"></td>
								<td width="20%">Date:</td>
								<td width="30%">Bank Name & Account Number:
									<br> {{ $payee_bank }} {{ $payee_bank_account_no }}</td>							
							</tr>
							<tr>
								<td colspan="2">Signature:</td>
								<td width="30%"></td>
								<td width="20%">Date:</td>
								<td width="30%">Printed Name:</td>
								<td rowspan="2" valign="top">Date</td>
							</tr>
							<tr>
								<td colspan="5">Official Receipt No. & Date/Other Documents</td>
							</tr>
						</table>					
						{{-- <table>
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
						</table> --}}
					</td>
				</tr>
			</table>
			<table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						@if ($dv_documents->count() > 0)
							<strong>&nbsp;Supporting Documents:</strong>
						@endif
						<span class="float-right">Date Printed: {{ $now }}</span>
						<br />
						@if ($dv_documents->count() > 0)
							@foreach($dv_documents as $key=>$item)					
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
			{{-- <table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">				
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
				<tr>
					<td class="text-right">Date Printed: {{ $now }}</td>
				</tr>
			</table> --}}
		</div>
		<br><br>
	</body>
</html> 