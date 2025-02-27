<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>PRINT - LDDAP</title>
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}" media="all">
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-6.1.1-web/css/all.min.css') }}">
    <style type="text/css">
      @media screen{
        .display_screen{
          padding: 0 7cm 0cm 7cm;
        }
        body,td,th {
          font-family: Arial, Helvetica, sans-serif;
          font-size: 14px;
        }
        .title-font{
          font-size: 16px;
        }
        .page-break	{ display: none; }
      }
      @media print{
        body,td,th {
          font-family: Arial, Helvetica, sans-serif;
          font-size: 14px;
        }
        .title-font{
          font-size: 22px;
        }
        .page-break	{ display: block; page-break-before: always; }
      }
    </style>
    <SCRIPT LANGUAGE="JavaScript">
			function printThis()
			{
				window.print();
			}
		</script>
  </head>
  <body>
    <?php
      foreach ($lddap_data as $row){
        $lddap_id = $row->id;	
        $lddap_no = $row->lddap_no;	
        $lddap_date = $row->lddap_date;
        $payment_mode = $row->payment_mode;
        $fund = $row->fund;
        $nca_no = $row->nca_no;
        $bank_account_no = $row->bank_account_no;	
        $check_no = $row->check_no;	
        $acic_no = $row->acic_no;					
        $total_lddap_gross_amount = $row->total_lddap_gross_amount;					
        $total_lddap_net_amount = $row->total_lddap_net_amount;					
        $signatory1 = $row->signatory1;	
        $signatory1_position = $row->signatory1_position;	
        $signatory2 = $row->signatory2;	
        $signatory2_position = $row->signatory2_position;				
        $signatory3 = $row->signatory3;	
        $signatory3_position = $row->signatory3_position;	
        $signatory4 = $row->signatory4;	
        $signatory4_position = $row->signatory4_position;	
        $signatory5 = $row->signatory5;	
        $signatory5_position = $row->signatory5_position;	
        $date_transferred = $row->date_transferred;			
        $ada_no = $row->ada_no;			
      }
      $lddap_month = date('m', strtotime($lddap_date));
      $lddap_year = date('Y', strtotime($lddap_date));

      $lddap_amount = $total_lddap_net_amount;
      $total_lddap_net_amount = number_format($lddap_amount, 2);
      $qr_code=$lddap_year ."D" . sprintf('%08d', $lddap_id);
      $decimal=substr(strrchr($total_lddap_net_amount, "."), 1);
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
      <table width="100%" cellspacing="0" cellpadding="3" class="table-borderless">
        <tr>
          <td height="32" colspan="3" valign="top" class="deffont text-center">
            <strong>LIST OF DUE AND DEMANDABLE ACCOUNTS PAYABLE - ADVICE TO DEBIT ACCOUNTS (LDDAP-ADA)</strong></td>
        </tr>
        <tr>
          <td><span class="midfont font-weight-bold">Department:</span></td>
          <td><span class="midfont">Department of Science and Technology</span></td>
          <td><span class="midfont font-weight-bold">LDDAP-ADA No.</span></td>
          <td><span class="midfont text-underlined">{{ $lddap_no }}</span></td>
        </tr>
        <tr>
          <td><span class="midfont font-weight-bold">Agency:</span></td>
          <td><span class="smallfont font-weight-bold">PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</span></td>
          <td><span class="smallfont font-weight-bold">Date:</span></td>
          <td><span class="smallfont">{{ $lddap_date }}</span></td>
        </tr>        
        <tr> 
          <td><span class="midfont font-weight-bold">NCA No.</span></td>
          <td>{{ $nca_no }}</td>
          <td><span class="midfont font-weight-bold">Fund Code:</span></td>
          <td>{{ $fund }}</td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold" colspan="8">MDS-GSB BRANCH/MDS SUB ACCOUNT NO.: <span class="text-underlined">{{ $bank_account_no }}</span></td>
        </tr>
      </table>
      
      <table width="100%" border="2" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="9" class="text-center font-weight-bold bottom-border-2">
            I. LIST OF DUE AND DEMANDABLE ACCOUNTS PAYABLE (LDDAP)
          </td>
        </tr>
        <tr class="text-center font-weight-bold bottom-border-2">
          <td colspan="3"><span class="midfont">CREDITOR</span></td>
          <td width="15%" rowspan="2" class="left-border-2"><span class="midfont">Obligation<br /> Request and <br /> Status No.</span></td>
          <td width="6%" rowspan="2" class="left-border-2 right-border-2"><span class="midfont">ALLOTMENT<br />CLASS/<br /> per (UACS)</span></td>
          <td colspan="4"><span class="midfont">In PESOS</span></td>
        </tr>
        <tr class="text-center bottom-border-2">
          <td width="3%">&nbsp;</td>
          <td width="23%"><span class="midfont">NAME</span></td>
          <td width="16%"><span class="midfont">PREFERRED SERVICING<br /> BANK/SAVINGS/CURRENT<br />  ACCOUNT NO.</span></td>          
          <td width="9%"><span class="midfont">GROSS AMOUNT</span></td>
          <td width="8%"><p>OTHER<br />DEDUCTION</p></td>
          <td width="8%"><span class="midfont">W/TAX</span></td>
          <td width="10%"><span class="midfont">NET AMOUNT</span></td>
        </tr>
        <?php        
          $count = 1;
          $wtax = 0;
          $total_tax = 0;
          $gtotal_tax = 0;
          $gt_other_deductions = 0;
          $total_lddap_gross_amount = 0;
          $total_lddap_net_amount = 0;
          $other_deductions = 0;
          foreach ($lddap_dv as $row){
            $id = $row->id;	
            $dv_id = $row->dv_id;	
            $total_dv_gross_amount = $row->total_dv_gross_amount;
            $total_dv_net_amount = $row->total_dv_net_amount;
            $payee_parent_id = $row->payee_parent_id;
            $payee = $row->payee;
            $payee_bank_acronym = $row->payee_bank_acronym;
            $payee_bank_short_name = $row->payee_bank_short_name;
            $payee_bank_branch = $row->payee_bank_branch; 
            $payee_bank_account_name = $row->payee_bank_account_name; 
            $payee_bank_account_name1 = $row->payee_bank_account_name1; 
            $payee_bank_account_name2 = $row->payee_bank_account_name2; 
            $payee_bank_account_no = $row->payee_bank_account_no; 
            $total_lddap_gross_amount += $row->total_dv_gross_amount;
            $total_lddap_net_amount += $row->total_dv_net_amount;           
            $dv_rs_net = DB::table('view_dv_rs_net')->where('dv_id', $dv_id)
              ->where('is_active', 1)->where('is_deleted', 0)->get();                         
            foreach($dv_rs_net as $row1){
              $total_tax = $row1->tax_one + $row1->tax_two + $row1->tax_twob + $row1->tax_three + $row1->tax_five + $row1->tax_six + $row1->wtax + $row1->other_tax;
              $gtotal_tax+=$total_tax;
              $other_deductions=$row1->liquidated_damages+$row1->other_deductions;
              $gt_other_deductions+=$other_deductions;
              $allotment_class_acronym = $row1->allotment_class_acronym;
            }?>
            <tr class="text-center">
              <td>{{ $count }}</td>
              <td class="text-left">
                {{ $payee_bank_account_name }}
                @if(isset($payee_bank_account_name1)) <br><br> {{ $payee_bank_account_name1 }} @endif
              </td>
              <td> 
                {{ $payee_bank_short_name }} -
                @if($payee_bank_acronym!='LBP') {{ $payee_bank_branch }} / 
                @elseif(isset($payee_bank_account_name2)) {{ $payee_bank_acronym }} {{ $payee_bank_account_name2 }} /
                @endif 
                {{ $payee_bank_account_no }}
              </td>
              <td class="left-border-2">
                @foreach($dv_rs_net as $row1)
                    {{ $row1->rs_no }}
                @endforeach
              </td>
              <td class="left-border-2">
                {{ $allotment_class_acronym ?? null }}
              </td>
              <td class="text-right left-border-2">{{ number_format($total_dv_gross_amount,2) }}</td>              
              <td class="text-right">@if($other_deductions > 0) {{ number_format($other_deductions,2) }} @endif</td>
              <td class="text-right">@if($total_tax > 0) {{ number_format($total_tax,2) }} @endif</td>
              <td class="text-right">{{ number_format($total_dv_net_amount,2) }}</td>
            </tr>
              <?php
              $count=$count+1;
          }
        ?>
        <tr class="text-right font-weight-bold top-border-2">
          <td colspan="5">TOTAL&nbsp;</td>
          <td>₱ {{ number_format($total_lddap_gross_amount,2) }}</td>          
          <td>@if($gt_other_deductions > 0) ₱ {{ number_format($gt_other_deductions,2) }} @endif</td>
          <td>@if($gtotal_tax > 0) ₱ {{ number_format($gtotal_tax,2) }} @endif</td>
          <td>₱ {{ number_format($total_lddap_net_amount,2) }}</td>
        </tr>
      </table>
      <table width="100%" border="1" cellpadding="4" cellspacing="0">
        <tr>
          <td>
            <table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><span class="midfontb">
                  <p>I hereby warrant that the above List of Due and Demandable A/Ps was prepared in accordance with existing budgeting, accounting and auditing rules and regulations.</p></span></td>
                <td width="3%" valign="top">&nbsp;</td>                
                <td valign="top"><span class="midfontb">
                  <p>I hereby assume full responsibility for the veracity and accuracy of the listed claims, and the authenticity of the supporting documents as submitted by the claimants</p></span></td>
              </tr>
              <tr>
                <td>Certified Correct:</td>
                <td></td>
                <td>Approved:</td>
              </tr>
              <tr class="text-center font-weight-bold">
                <td><span class="underline-above">{{ strtoupper($signatory1) }}</span></td>
                <td></td>
                <td><span class="underline-above">{{ strtoupper($signatory2) }}</span></td>
              </tr>
              <tr class="text-center">
                <td>Head of Accounting Division/Unit</td>
                <td></td>
                <td>Head of Agency/Authorized Official</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table width="100%" border="2" cellpadding="1" cellspacing="0">
        <tr>
          <td class="text-center font-weight-bold">
            II. ADVICE TO DEBIT ACCOUNT (ADA)
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">               
              <tr class="font-weight-bold">
                <td width="20%"><span class="midfontb">To: MDS GSB of the Agency</span></td>
                <td width="80%" colspan="2"><strong class="midfontb">LAND BANK OF THE PHILIPPINES-UPLB BRANCH</strong></td>
              </tr>
              <tr>
                <td><span class="midfontb">Please debit MDS Sub-Account Number:</span></td>
                <td class="midfont" colspan="2">{{ $bank_account_no }}</td>
              </tr>
              <tr>
                <td><span class="midfontb">NCA No.</span></td>
                <td class="midfont" colspan="2">{{ $nca_no }}</td>
              </tr>
              <tr>
                <td colspan="3"><span class="midfontb">Please credit the accounts of the above listed creditors to cover payment of Accounts Payable (A/Ps).</span></td>
              </tr>
              <tr>
                <td><span class="midfontb font-weight-bold">TOTAL AMOUNT:</span></td>
                <td class="midfont"><strong>{{ strtoupper(convert_number_to_words($total_lddap_net_amount)) }}{{ $cents }}</strong></td>
                <td class="midfont text-right"><strong>₱ {{ number_format($total_lddap_net_amount, 2) }}</strong></td>
              </tr>
              <tr class="font-weight-bold text-center">
                <td colspan="3"><br>Agency Authorized Signatories</td>
              </tr>
              <tr>
                <td height="65" colspan="3" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr class="midfont">
                    <td width="49%" align="center"><strong class="midfont">1. {{ strtoupper($signatory3) }}</strong></td>
                    <td width="51%" align="center"><strong class="midfont">2. {{ strtoupper($signatory4) }}</strong></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td colspan="3" class="text-center font-italic"><span class="midfont">(Erasures shall invalidate this document)</span></td>
              </tr> 
            </table>
          </td>
        </tr>           
      </table>

            {{-- <table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" class="text-center" style="border-bottom-style:solid; border-bottom-width:thin"><strong>ADVICE TO DEBIT ACCOUNT (ADA)</strong></td>
              </tr>
              <tr>
                <td width="25%"><span class="midfontb">TO: MDS GSB of the Agency</span></td>
                <td width="75%"><strong class="midfontb">LAND BANK OF THE PHILIPPINES-UPLB BRANCH</strong></td>
              </tr>
              <tr>
                <td><span class="midfontb">Please debit MDS Sub-Account Number:</span></td>
                <td class="midfont">{{ $bank_account_no }}</td>
              </tr>
              <tr>
                <td><span class="midfontb">NCA No.</span></td>
                <td class="midfont">{{ $nca_no }}</td>
              </tr>
              <tr>
                <td colspan="2"><span class="midfontb">Please credit the accounts of the above listed creditors to cover payment of Accounts Payable (A/Ps).</span></td>
              </tr>
              <tr>
                <td><span class="midfontb">TOTAL AMOUNT:</span></td>
              <td class="midfont">&nbsp;<strong>{{ strtoupper(convert_number_to_words($total_lddap_net_amount)) }}{{ $cents }}</strong></td>
              </tr>
              <tr>
                <td height="55" colspan="2" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr class="midfont">
                    <td width="49%" align="center"><strong class="midfont">1. {{ strtoupper($signatory3) }}</strong></td>
                    <td width="51%" align="center"><strong class="midfont">2. {{ strtoupper($signatory4) }}</strong></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td colspan="2" class="text-center"><span class="midfont">(Erasures shall invalidate this document)</span></td>
              </tr>
            </table>
            <table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3" style="border-bottom-style:solid; border-bottom-width:thin; border-top-style:solid; border-top-width:thin;"><span class="midfont">FOR MDS-GSB USE ONLY:</span></td>
              </tr>
              <tr>
                <td width="49%">&nbsp;</td>
                <td width="11%" class="midfontb">ACIC NO.</td>
                <td width="40%" class="midfontb" style="border-bottom:solid; border-bottom-width:thin">{{ $acic_no }}</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="midfontb">Check No.</td>
                <td class="midfontb" style="border-bottom:solid; border-bottom-width:thin"><strong>{{ $check_no }}</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="midfontb">LDDAP-ADA No.</td>
                <td class="midfontb" style="border-bottom:solid; border-bottom-width:thin"><strong>{{ $lddap_no }}</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="midfontb">Date of Issue</td>
                <td class="midfontb"><strong>{{ $lddap_date }}</strong></td>
              </tr>
            </table> --}}
      <table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
				<tr>
					<td class="font-weight-bold">LDDAP ID: {{ $lddap_id }}
					</td>
          <td class="text-right">Date Printed:{{ $now }}</td>
				</tr>
			</table>
      <p>&nbsp;</p>
    </div>
  </body>
</html>