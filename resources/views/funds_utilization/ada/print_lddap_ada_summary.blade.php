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
        foreach ($ada_data as $row){
          $ada_id = $row->id;	
          $ada_no = $row->ada_no;	
          $ada_date = $row->ada_date;
          $fund = $row->fund;
          $fund_cluster = $row->fund_cluster;
          $nca_no = $row->nca_no;
          $bank_account_no = $row->bank_account_no;	
          $check_no = $row->check_no;	
          $total_ps_amount = $row->total_ps_amount;		   
          $total_mooe_amount = $row->total_mooe_amount;		   
          $total_co_amount = $row->total_co_amount;		   
          $total_ada_amount = $row->total_ada_amount;		   
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
        }
        $ada_month = date('m', strtotime($ada_date));
        $ada_year = date('Y', strtotime($ada_date));
        $ada_dateb = date('j-M-y', strtotime($ada_date));

        $ada_amount = $total_ada_amount;
        $total_ada_amount = number_format($ada_amount, 2);
        $decimal=substr(strrchr($total_ada_amount, "."), 1);
        $cents=" Pesos" ;
        if($decimal > 0) {
          $cents=" Pesos and " . convert_number_to_words($decimal) . " Centavos";
        }
        elseif($decimal == 01) {
          $cents=" Pesos and " . convert_number_to_words($decimal) . " Centavos";
        }	
      ?>
    <div class="display_screen">
      <table width="100%" class="table-borderless" cellspacing="0" cellpadding="1">
        <tr>
          <td height="33" colspan="4" class="text-center title-font font-weight-bold">SUMMARY OF LDDAP-ADAs Issued and Invalidated ADA Entries (SLIIAE)</td>
        </tr>
        <tr>
          <td colspan="2">Department: <strong>Department of Science and Technology</strong></span></td>
          <td width="9%">Fund Cluster:</td>
          <td width="13%">{{ $fund_cluster }}</span></td>
        </tr>
        <tr>
          <td colspan="2">Entity Name: </span><strong>PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</strong></span></td>
          <td>SLIIAE No.:</td>
          <td>{{ $ada_year }}-{{ $ada_month }}-{{ $ada_no }}</span></td>
        </tr>
        <tr>
          <td width="2%">&nbsp;</td>
          <td width="76%">&nbsp;</td>
          <td>Date:</td>
          <td>{{ $ada_dateb }}</span></td>
        </tr>
        <tr>
          <td>To:</td>
          <td><strong>The Bank Manager</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><strong>Land Bank of the Philippines</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><strong>UPLB Branch, Los Banos, Laguna</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="1" cellspacing="0" cellpadding="2">
        <tr>
          <td width="17%" rowspan="3" class="text-center">LDDAP-ADA No.</span></td>
          <td width="12%" rowspan="3" class="text-center">Date of Issue</span></td>
          <td colspan="5" class="text-center">In PESOS</span></td>
          <td class="text-center">For GSB Use Only</span></td>
        </tr>
        <tr>
          <td colspan="5" class="text-center">Allotment/Object Class</span></td>
          <td width="19%" rowspan="2" class="text-center">REMARKS</span></td>
        </tr>
        <tr>
          <td width="11%" class="text-center">Total</span></td>
          <td width="11%" class="text-center">PS</span></td>
          <td width="12%" class="text-center">MOOE</span></td>
          <td width="10%" class="text-center">CO</span></td>
          <td width="8%" class="text-center">RNEX</span></td>
        </tr><?php        
        $count_lddap_by_ada=count($ada_lddap_data);
        foreach($ada_lddap_data as $row){
          $total_lddap_net_amount=$row->total_lddap_net_amount;
          $ps_amount=$row->ps_amount;
          $mooe_amount=$row->mooe_amount;
          $co_amount=$row->co_amount;
          ?>	
          <tr class="text-right">
            <td class="text-center">{{ $row->lddap_no }}</td>
            <td class="text-center">{{ $row->lddap_date }}</td>
            <td>@if($total_lddap_net_amount>0) {{ number_format($total_lddap_net_amount, 2) }} @endif</td>
            <td>@if($ps_amount>0) {{ number_format($ps_amount, 2) }} @endif</td>
            <td>@if($mooe_amount>0) {{ number_format($mooe_amount, 2) }} @endif</td>
            <td>@if($co_amount>0) {{ number_format($co_amount, 2) }} @endif</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr><?php
        } ?>
        <tr class="text-right">
          <td colspan="2" class="text-center"><strong>TOTAL</strong></td>
          <td><strong>{{ $total_ada_amount }}</strong></td>
          <td><strong>@if($total_ps_amount>0) {{ number_format($total_ps_amount, 2)  }} @endif</strong></td>
          <td><strong>@if($total_mooe_amount>0) {{ number_format($total_mooe_amount, 2)  }} @endif</strong></td>
          <td><strong>@if($total_co_amount>0) {{ number_format($total_co_amount, 2)  }} @endif</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="39" colspan="4" valign="top"><p>No. of pcs. Of LDDAP-ADA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>{{ $count_lddap_by_ada }}</strong></span></p></td>
          <td colspan="4" valign="top">Total Amount in Words:<br />
            <strong>{{ convert_number_to_words($ada_amount) }}{{ $cents }}</strong></span></td>
        </tr>
        <tr>
          <td colspan="8">
            <table width="100%" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td width="11%" rowspan="3" class="text-center">LDDAP-ADA No.</span></td>
                <td width="8%" rowspan="3" class="text-center">Amount</span></td>
                <td width="9%" rowspan="3" class="text-center">Date Issued</span></td>
                <td colspan="5" class="text-center">OF WHICH INVALIDATED ENTRIES OF PREVIOUSLY ISSUED LDDAP-ADAs</span></td>
                <td width="14%" rowspan="3" class="text-center">REMARKS</span></td>
              </tr>
              <tr>
                <td colspan="5" class="text-center">Allotment / Object Class</span></td>
                </tr>
              <tr>
                <td width="10%" class="text-center">PS</span></td>
                <td width="11%" class="text-center">MOOE</span></td>
                <td width="12%" class="text-center">CO</span></td>
                <td width="12%" class="text-center">FINEX</span></td>
                <td width="13%" class="text-center">TOTAL</span></td>
                </tr>
              <tr>
                <td colspan="9">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="8">
            <table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
              <tr>
                <td width="49%" height="85" valign="top"><p>Certified Correct:<br />
                  </span> <br />
                </p>
                  <p><strong>{{ Str::upper($signatory1) }}<br />
                   {{ $signatory1_position }}</strong></p></td>
                <td width="3%" valign="top">&nbsp;</td>
                <td width="48%" valign="top"><p>Approved:<br />
                  <br />
                </span></p>
                  <p><strong>{{ Str::upper($signatory2) }}<br />
                    {{ $signatory2_position }}</strong></p></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="8">
            <table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"> TRANSMITTAL INFORMATION: (Signature over printed name. Kindly indicate the designation)</span></td>
                </tr>
              <tr>
                <td height="25" valign="bottom">Delivered by:</span></td>
                <td valign="bottom">Received by:</span></td>
              </tr>
              <tr>
                <td width="50%" height="52" valign="bottom">{{ Str::upper($signatory5) }}</strong></td>
                <td width="50%" valign="bottom">_________________________________</span></td>
              </tr>
              <tr>
                <td><strong>{{ $signatory5_position }}</strong></td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
  </body>
</html>