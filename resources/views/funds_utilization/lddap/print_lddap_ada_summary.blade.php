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
          font-size: 12px;
        }
        .title-font{
          font-size: 16px;
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
      $cents=" Pesos" ;
      if($decimal > 0) {
        $cents=" Pesos and " . convert_number_to_words($decimal) . " Centavos";
      }
      elseif($decimal == 01) {
        $cents=" Pesos and " . convert_number_to_words($decimal) . " Centavos";
      }	
    ?>
    <button class="noprint btn float-left" onClick="printThis()" data-toggle="tooltip" data-placement='auto'
      title='PRINT'><i class="fa-2xl fa-solid fa-print"></i></button>
    <br class="noprint"><br class="noprint">
    <div class="display_screen">
      <table width="100%" class="table-borderless" cellspacing="0" cellpadding="3">
        <tr>
          <td width="15%"><span class="midfont">DEPARTMENT</span></td>
          <td width="85%"><span class="midfont">Department of Science and Technology</span></td>
        </tr>
        <tr>
          <td><span class="midfont">AGENCY</span></td>
          <td><span class="midfont"><strong>PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC AND NATURAL RESOURCES RESEARCH AND DEVELOPMENT</strong></span></td>
        </tr>
        <tr>
          <td><span class="midfont">OPERATING UNIT</span></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><span class="midfont">FUND CODE</span></td>
          <td><span class="midfont">{{ $fund }}</span></td>
        </tr>
        <tr>
          <td colspan="2" class="text-center"><span class="deffont"><strong>SUMMARY OF LDDAP-ADAs Issued and Invalidated ADA Entries (SUEE)</strong></span></td>
        </tr>
      </table>
      <table width="100%" border="1" class="text-center" cellspacing="0" cellpadding="0">
        <tr>
          <td width="17%" rowspan="3"><span class="midfont">LDDAP-ADA No.</span></td>
          <td width="12%" rowspan="3"><span class="midfont">Date of Issue</span></td>
          <td colspan="5"><span class="midfont">In PESOS</span></td>
          <td><span class="midfont">For GSB Use Only</span></td>
        </tr>
        <tr>
          <td colspan="5"><span class="midfont">Allotment/Object Class</span></td>
          <td width="19%" rowspan="2"><span class="midfont">REMARKS</span></td>
        </tr>
        <tr>
          <td width="11%"><span class="midfont">Total</span></td>
          <td width="11%"><span class="midfont">PS</span></td>
          <td width="12%"><span class="midfont">MOOE</span></td>
          <td width="10%"><span class="midfont">CO</span></td>
          <td width="8%"><span class="midfont">RNEX</span></td>
        </tr>
        <?php          
          $view_lddap = DB::table('view_lddap')
            ->select(DB::raw("lddap_no, lddap_date, fund, 
              (SELECT SUM(total_dv_net_amount) FROM dv_rs_net LEFT JOIN disbursement_vouchers ON dv_rs_net .dv_id=disbursement_vouchers.id             
              WHERE disbursement_vouchers.lddap_id=$lddap_id and dv_rs_net.is_active=1 and dv_rs_net.is_deleted=0) as total,
              (SELECT SUM(total_dv_net_amount) FROM dv_rs_net LEFT JOIN disbursement_vouchers ON dv_rs_net .dv_id=disbursement_vouchers.id
              LEFT JOIN view_rs_pap_total ON dv_rs_net .rs_id=view_rs_pap_total.rs_id 
              WHERE disbursement_vouchers.lddap_id=$lddap_id and dv_rs_net.is_active=1 and dv_rs_net.is_deleted=0
               and view_rs_pap_total.allotment_class_acronym='PS') as total_ps,
              (SELECT SUM(total_dv_net_amount) FROM dv_rs_net LEFT JOIN disbursement_vouchers ON dv_rs_net .dv_id=disbursement_vouchers.id
              LEFT JOIN view_rs_pap_total ON dv_rs_net .rs_id=view_rs_pap_total.rs_id 
              WHERE disbursement_vouchers.lddap_id=$lddap_id and dv_rs_net.is_active=1 and dv_rs_net.is_deleted=0
               and view_rs_pap_total.allotment_class_acronym='MOOE') as total_mooe, 
              (SELECT SUM(total_dv_net_amount) FROM dv_rs_net LEFT JOIN disbursement_vouchers ON dv_rs_net .dv_id=disbursement_vouchers.id
              LEFT JOIN view_rs_pap_total ON dv_rs_net .rs_id=view_rs_pap_total.rs_id 
              WHERE disbursement_vouchers.lddap_id=$lddap_id and dv_rs_net.is_active=1 and dv_rs_net.is_deleted=0
               and view_rs_pap_total.allotment_class_acronym='CO') as total_co"))
            ->where('view_lddap.id', $lddap_id)->groupBy('lddap_no')->get();
        foreach($view_lddap as $row){
          $total = $row->total;
          $total_ps = $row->total_ps;
          $total_mooe = $row->total_mooe;
          $total_co = $row->total_co;
        }
        ?>	
        <tr class="text-right">
          <td class="text-center"><span class="midfont">{{ $lddap_no }}</span></td>
          <td class="text-center"><span class="midfont">{{ $lddap_date }}</span></td>
          <td><span class="midfont">{{ number_format($total, 2) }}</span></td>
          <td><span class="midfont">{{ number_format($total_ps, 2) }}</span></td>
          <td><span class="midfont">{{ number_format($total_mooe, 2) }}</span></td>
          <td><span class="midfont">{{ number_format($total_co, 2) }}</span></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="text-left">
          <td height="49" colspan="4" valign="top"><p><span class="midfont">No. of pcs. Of LDDAP-ADA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>1</strong></span></p></td>
          <td colspan="4" valign="top"><span class="midfont">Total Amount in Words:<br />
            <strong>{{ convert_number_to_words($lddap_amount) }}{{ $cents }}</strong></span></td>
        </tr>
        <tr class="text-center">
          <td colspan="8"><table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="11%" rowspan="3"><span class="midfont">LDDAP-ADA No.</span></td>
              <td width="8%" rowspan="3"><span class="midfont">Amount</span></td>
              <td width="9%" rowspan="3"><span class="midfont">Date Issued</span></td>
              <td colspan="5"><span class="midfont">OF WHICH INVALIDATED ENTRIES OF PREVIOUSLY ISSUED LDDAP-ADAs</span></td>
              <td width="14%" rowspan="3"><span class="midfont">REMARKS</span></td>
            </tr>
            <tr>
              <td colspan="5"><span class="midfont">Allotment / Object Class</span></td>
              </tr>
            <tr>
              <td width="10%"><span class="midfont">PS</span></td>
              <td width="11%"><span class="midfont">MOOE</span></td>
              <td width="12%"><span class="midfont">CO</span></td>
              <td width="12%"><span class="midfont">FINEX</span></td>
              <td width="13%"><span class="midfont">TOTAL</span></td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr class="text-left">
          <td colspan="8"><table width="100%" class="table-borderless" cellspacing="0" cellpadding="10">
            <tr>
              <td width="49%" height="103" valign="top"><p><span class="midfont">Certified Correct:<br />
                </span> <br />
              </p>
                <p><strong>{{ strtoupper($signatory1) }}<br />
                  {{ $signatory1_position }}</strong></p></td>
              <td width="3%" valign="top">&nbsp;</td>
              <td width="48%" valign="top"><p><span class="midfont">Approved:<br />
                <br />
              </span></p>
                <p><strong>{{ strtoupper($signatory2) }}<br />
                  {{ $signatory2_position }}</strong></p></td>
            </tr>
          </table></td>
        </tr>
        <tr class="text-left">
          <td colspan="8"><table width="100%" class="table-borderless" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2"><span class="midfont"> TRANSMITTAL INFORMATION: (Signature over printed name. Kindly indicate the designation)</span></td>
              </tr>
            <tr>
              <td height="43" valign="bottom"><span class="midfont">Delivered by:</span></td>
              <td valign="bottom"><span class="midfont">Received by:</span></td>
            </tr>
            <tr>
              <td width="50%" height="52" valign="bottom">&nbsp;<strong>{{ strtoupper($signatory5) }}</strong></td>
              <td width="50%" valign="bottom"><span class="midfont">_________________________________</span></td>
            </tr>
            <tr>
              <td><strong>&nbsp;{{ $signatory5_position }}</strong></td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div>
  </body>
</html>