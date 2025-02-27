<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RADAI</title>
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}" media="all">
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-6.1.1-web/css/all.min.css') }}">
    <style type="text/css">
      @media screen{
        .display_screen{
          padding: .2cm 5cm 0cm 5cm;
        }
        body,td,th {
          font-family: Arial, Helvetica, sans-serif;
          font-size: 12px;
        }
        .title-font{
          font-size: 22px;
        }
        .page-break	{ display: none; }
      }
      @media print{
        body,td,th {
          font-family: Arial, Helvetica, sans-serif;
          font-size: 14px;
        }
        .title-font{
          font-size: 25px;
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
      foreach ($radai_data as $row){        
        $ada_date = $row->ada_date;	
        $lddap_date = $row->lddap_date;	
        $lddap_no = $row->lddap_no;
        $rs_no = $row->rs_no;
        $rs_no = $row->rs_no;
        $dv_id = $row->dv_id;
        $dv_no = $row->dv_no;
        $payee = $row->payee;
        $total_dv_net_amount = $row->total_dv_net_amount;
        $fund_id = $row->fund_id;				
        $fund = $row->fund;				
        $bank_account_id = $row->bank_account_id;				
        $bank_account_no = $row->bank_account_no;				
        $bank_acronym = $row->bank_acronym;				
      }
      $ada_date1 = date("F j, Y", strtotime($ada_date));
    ?>
    <table width="100%" class="graytable3 table-borderless" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="9" class="title-font text-center">REPORT OF ADVICE TO DEBIT ACCOUNT ISSUED</td>
      </tr>
      <tr>
        <td colspan="9" class="fontsml text-center">Period Covered: <strong>{{ $ada_date1 }}</strong></td>
      </tr>
      <tr><td colspan="9">&nbsp;</td></tr>
      <tr>
        <td colspan="2">Entity Name:</td>
        <td colspan="2"style="border-bottom: thin solid;"><strong>DOST-PCAARRD</strong></td>
      </tr>
      <tr>
        <td colspan="2">Fund Cluster:</td>
        <td colspan="2" style="border-bottom: thin solid;"><strong>{{ $fund }}</strong></td>
        <td colspan="4" class="text-right">Report No.:</td>
        <td style="border-bottom: thin solid;"><strong>{{ $radai_no }}</strong></td>
      </tr>
      <tr>
        <td colspan="2">Bank Name/Account No.</td>
        <td colspan="2" class="fontsml text-left" style="border-bottom: thin solid;"><strong>{{ $bank_acronym }} - {{ $bank_account_no }}</strong></td>
        <td colspan="4" class="text-right">Sheet No.:</td>
        <td style="border-bottom: thin solid;">&nbsp;</td>
      </tr>
      <tr><td>&nbsp;</td></tr> 
      <tr class="text-center">
        <td colspan="2"><strong>ADA</strong></td>
        <td width="5%" rowspan="2"><strong>DV No.</strong></td>
        <td width="6%" rowspan="2"><strong>ORS/BURS No.</strong></td>
        <td width="5%" rowspan="2"><strong>Responsibility<br />Center Code</strong></td>
        <td width="20%" rowspan="2"><strong>Payee</strong></td>
        <td width="5%" rowspan="2"><strong>UACS Object<br />Code</strong></td>
        <td width="30%" rowspan="2"><strong>Nature of Payment</strong></td>
        <td width="9%" rowspan="2"><strong>Amount</strong></td>
      </tr>
      <tr class="text-center" style="border-bottom: thin solid;">
        <td width="6%" ><strong>Date</strong></td>
        <td width="6%" ><strong>No.</strong></td>
      </tr>  <?php
        $total_net_amount = 0;
        $ada_dvs_data = DB::table('view_ada_dvs')->where('ada_date', $ada_date)->where('fund_id', $fund_id)
          ->where('bank_account_id', $bank_account_id)->where('is_active',1)->where('is_deleted',0)->orderBy('lddap_no')->get();
        $first_lddap_no = DB::table('view_ada_dvs')->where('ada_date', $ada_date)->where('fund_id', $fund_id)
          ->where('bank_account_id', $bank_account_id)->where('is_active',1)->where('is_deleted',0)->orderBy('lddap_no', 'ASC')->pluck('lddap_no')->first();
        $last_lddap_no = DB::table('view_ada_dvs')->where('ada_date', $ada_date)->where('fund_id', $fund_id)
          ->where('bank_account_id', $bank_account_id)->where('is_active',1)->where('is_deleted',0)->orderBy('lddap_no', 'ASC')->pluck('lddap_no')->last();
        // echo "ada date: $ada_date, fund id: $fund_id, bank account id: $bank_account_id ";
        // echo "$first_lddap_no - $last_lddap_no";
        foreach($ada_dvs_data as $row){
          $total_net_amount += $row->total_dv_net_amount;  ?>
          <tr class="text-center" valign="top">
            <td>{{ $row->lddap_date }}</td>
            <td>&nbsp;&nbsp;{{ $row->lddap_no }}</td>
            <td>&nbsp;&nbsp;{{ $row->dv_no }}</td>
            <td>&nbsp;&nbsp;{{ $row->rs_no }}</td>
            <td>&nbsp;&nbsp;{{ $row->dv_division_acronym }}</td>
            <td class="text-left">&nbsp;&nbsp;{{ $row->payee }}</td>
            <td>&nbsp;</td>
            <td class="text-left">&nbsp;&nbsp;{{ $row->particulars }}</td>
            <td class="text-right">&nbsp;&nbsp;{{ number_format($row->total_dv_net_amount,2) }}</td>
          </tr><?php
        } ?>    
      <tr style="border-top: thin solid; border-bottom: thin solid;" class="font-weight-bold" valign="top">
        <td colspan="8" class="text-center">TOTAL</td>
        <td class="text-right">{{ number_format($total_net_amount,2) }}</td>
      </tr>    
    </table>
    <table class="table-borderless text-center" width="100%">      
      <tr><td>&nbsp;</td></tr>
      <tr>     
        <td colspan="8" class="font-weight-bold">CERTIFICATION</td>        
      </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>  
        <td colspan="3">&nbsp;</td>   
        <td>
            <p> I hereby certify on my official oath that the above is a true statement of all ADAs issued by me during          
          the period stated above for which ADA Nos.. <strong>{{ $first_lddap_no }}</strong> to <strong>{{ $last_lddap_no }}</strong> 
          inclusive, were actually issued by me in the amounts shown therein.</p>
        {{-- </span>        <br /> <br /> --}}
        </td>  
      </tr> 
      <tr><td>&nbsp;</td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td class="font-weight-bold">&emsp;&emsp;&emsp;&emsp;&emsp;HEIDELITA A. RAMOS 
          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; _________________</td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td>Administrative Officer V 
          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;Date</td>
      </tr>
    </table>
    <br>
  </body>
</html>