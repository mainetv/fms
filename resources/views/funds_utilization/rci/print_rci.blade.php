<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RCI</title>
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
          font-size: 17px;
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
      foreach ($rci_data as $row){        
        $check_date = $row->check_date;	
        $check_no = $row->check_no;
        $rs_no = $row->rs_no;
        $dv_id = $row->dv_id;
        $dv_no = $row->dv_no;
        $dv_division_acronym = $row->dv_division_acronym;
        $payee = $row->payee;
        $total_dv_net_amount = $row->total_dv_net_amount;
        $fund_id = $row->fund_id;				
        $fund = $row->fund;				
        $bank_account_id = $row->bank_account_id;				
        $bank_account_no = $row->bank_account_no;				
        $bank_acronym = $row->bank_acronym;				
      }
      $check_date1 = date("F j, Y", strtotime($check_date));	
    ?>
    {{-- <input type="submit" name="excel" id="excel" class="noprint" value="Export To Excel" onclick="export_to_excel('table1')"  /> --}}
    <table id="table1"  width="100%" class="graytable3 table-borderless" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="9" class="title-font text-center">REPORT OF CHECKS ISSUED</td>
      </tr>
      <tr>
        <td colspan="9" class="fontsml text-center">Period Covered: <strong>{{ $check_date1 }}</strong></td>
      </tr>
      <tr><td colspan="9">&nbsp;</td></tr>
      <tr>
        <td colspan="2">Entity Name:</td>
        <td colspan="2"style="border-bottom: thin solid;"><strong>DOST-PCAARRD</strong></td>
      </tr>
      <tr>
        <td colspan="2">Fund Cluster:</td>
        <td colspan="2" style="border-bottom: thin solid;"><strong>{{ $fund }}</strong></td>
        <td colspan="4" class="text-right">Report No.:</td>rc
        <td style="border-bottom: thin solid;"><strong>{{ $rci_no }}</strong></td>
      </tr>
      <tr>
        <td colspan="2">Bank Name/Account No.</td>
        <td colspan="2" class="fontsml text-left" style="border-bottom: thin solid;"><strong>{{ $bank_acronym }} - {{ $bank_account_no }}</strong></td>
        <td colspan="4" class="text-right">Sheet No.:</td>
        <td style="border-bottom: thin solid;">&nbsp;</td>
      </tr>
      <tr><td>&nbsp;</td></tr> 
      <tr class="text-center">
        <td colspan="2"><strong>Check</strong></td>
        <td width="10%" rowspan="2"><strong>DV No.</strong></td>
        <td width="10%" rowspan="2"><strong>ORS/BURS No.</strong></td>
        <td width="7%" rowspan="2"><strong>Responsibility<br />Center Code</strong></td>
        <td width="27%" rowspan="2"><strong>Payee</strong></td>
        <td width="5%" rowspan="2"><strong>UACS Object<br />Code</strong></td>
        <td width="23%" rowspan="2"><strong>Nature of Payment</strong></td>
        <td width="9%" rowspan="2"><strong>Amount</strong></td>
      </tr>
      <tr class="text-center" style="border-bottom: thin solid;">
        <td><strong>Date</strong></td>
        <td><strong>No.</strong></td>
      </tr>      
      <?php
        $total_net_amount = 0;
        $check_dvs_data = DB::table('view_check_dv')->where('check_date', $check_date)->where('fund_id', $fund_id)
          ->where('bank_account_id', $bank_account_id)->where('is_active',1)->where('is_deleted',0)->get();
        $first_check_no = DB::table('view_check_dv')->where('check_date', $check_date)->where('fund_id', $fund_id)
          ->where('bank_account_id', $bank_account_id)->where('is_active',1)->where('is_deleted',0)->pluck('check_no')->first();
        $last_check_no = DB::table('view_check_dv')->where('check_date', $check_date)->where('fund_id', $fund_id)
          ->where('bank_account_id', $bank_account_id)->where('is_active',1)->where('is_deleted',0)->pluck('check_no')->last();
        foreach($check_dvs_data as $row){
          $total_net_amount += $row->total_dv_net_amount;
      ?>
      <tr class="text-center">
        <td valign="top">{{ $row->check_date }}</td>
        <td valign="top">{{ $row->check_no }}</td>
        <td valign="top">{{ $row->dv_no }}</td>
        <td valign="top">{{ $row->rs_no }}</td>
        <td valign="top">{{ $row->dv_division_acronym }}</td>
        <td valign="top" class="text-left">{{ $row->payee }}</td>
        <td valign="top">&nbsp;</td>
        <td valign="top" class="text-left">{{ $row->particulars }}</td>
        <td class="text-right" valign="top">{{ number_format($row->total_dv_net_amount,2) }}</td>
      </tr>
      <?php
        }
      ?>
      <tr style="border-top: thin solid; border-bottom: thin solid;" class="fontsml">
        <td colspan="8" class="text-center" valign="top"><strong>TOTAL</strong></td>
        <td class="text-right" valign="top"><strong>{{ number_format($total_net_amount,2) }}</strong></td>
      </tr>  
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td colspan="9" class="text-center" class="fontsml"><span class="fontreg"><strong>CERTIFICATION</strong><br /><br />
          I hereby certify on my official oath that this Report of Checks Issued in ____ sheet(s) is a full, true and correct<br />
          statement of all checks issued by me during the period stated above for which Check Nos. <strong>{{ $first_check_no }} to {{ $last_check_no }}</strong> to <strong><?php //echo $tcheckno ?></strong> inclusive, <br />
          where actually issued by me in payment for obligations shown in the attached disbursement vouchers/payroll.
          <p class="fontsml">&nbsp;</p> 
      <tr>        
      <tr>
        <td colspan="5">&nbsp;</td>
        <td width="373" class="text-center" class="fontsml"><strong>HEIDELITA A. RAMOS<br /></strong>Administrative Officer V<br /></td>
        <td width="110" class="text-center" class="fontsml">_________________<br /> Date</td>
        <td colspan="2">&nbsp;</td>  
      </tr>
    </table>
  </body>
</html>