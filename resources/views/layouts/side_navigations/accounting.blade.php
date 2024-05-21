<li class="nav-header">PROGRAMMING & ALLOCATION</li>  
   <li class="nav-item">
      <a href="{{ url('programming_allocation/nca/1/'.date('Y')) }}" class="nav-link @if ($title == 'NCA') active @endif">
         <img src="{{ url('images/allotment-icon.png') }}" width="24px">
         <p>NCA</p>
      </a>
   </li>           
   
<li class="nav-header">FUNDS UTILIZATION</li>                       
   <li class="nav-item">
      <a href="{{ url('funds_utilization/dv/all/'.date('Y-m-d')) }}" class="nav-link @if ($title == 'Disbursement Voucher (DV)' || $title == 'Edit Disbursement Voucher' || $title == 'Add Disbursement Voucher') active @endif">
         <img src="{{ url('images/dv-icon.png') }}" width="25px">
         <p>Disbursement Vouchers</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/lddap/1/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'List of Due and Demandable Accounts Payable (LDDAP)' || $title == 'Edit LDDAP' || $title == 'View Check') active @endif">
         <img src="{{ url('images/lddap-icon.png') }}" width="23px">
         <p>LDDAP</p>
      </a>
   </li>  
   <li class="nav-item @if ($title == 'receiveddvs' || $title == 'dvperdivision' || $title == 'dvsummary' || $title=='adacheckissued' || $title=='adacheckperpap' || $title=='adacheckissuedperpayee' || $title=='dvrsperpap' || $title=='rsperpap' || $title=='rsbalance'|| $title=='monthlywtax' || $title=='monthlywtaxbypayee' || $title=='lddapsummary' || $title=='saob' || $title=='ncabalanceperaclass' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='disbursementperrci' || $title=='indexpayment') menu-open @endif">
      <a href="#" class="nav-link @if ($title == 'receiveddvs' || $title == 'dvperdivision' || $title == 'dvsummary' || $title=='adacheckissued' || $title=='adacheckperpap' || $title=='adacheckissuedperpayee' || $title=='dvrsperpap' || $title=='rsperpap' || $title=='rsbalance' || $title=='monthlywtax' || $title=='monthlywtaxbypayee' || $title=='lddapsummary' || $title=='saob' || $title=='ncabalanceperaclass' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='disbursementperrci' || $title=='indexpayment') active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            Reports
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ url('reports/received_dvs') }}" class="nav-link @if($title == 'receiveddvs') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>1. Received DVs</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/dv_per_division') }}" class="nav-link @if($title == 'dvperdivision') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>2. Disbursement per Division</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/dv_summary/1/'.date('Y')) }}" class="nav-link @if($title == 'dvsummary') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>3. Disbursement Summary</p>
            </a>
         </li>        
         <li class="nav-item">
            <a href="{{ url('reports/ada_check_per_pap') }}" class="nav-link @if($title == 'adacheckperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>4. ADA/Checks per PAP</p>
            </a>
         </li>
         <li class="nav-item">
            <a href="{{ url('reports/ada_check_issued') }}" class="nav-link @if($title == 'adacheckissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>5. ADA/Checks Issued</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/ada_check_issued_per_payee') }}" class="nav-link @if($title == 'adacheckissuedperpayee') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>6. ADA/Checks Issued per Payee</p>
            </a>
         </li>           
         <li class="nav-item">
            <a href="{{ url('reports/dvrs_per_pap/') }}" class="nav-link @if ($title == 'dvrsperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>7. DV ORS/BURS per PAP</p>
            </a>
         </li>  
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_pap/1/'.date('Y-m-d').'/'.date('Y-m-d')) }}" class="nav-link @if($title == 'rsperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>8. ORS/BURS per PAP</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_balance') }}" class="nav-link @if($title == 'rsbalance') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>9. ORS/BURS Balance</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/monthly_wtax/'.date('m').'/'.date('Y')) }}" class="nav-link @if($title == 'monthlywtax') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>10. Monthly WTax</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/monthly_wtax_by_payee/'.date('m').'/'.date('Y')) }}" class="nav-link @if($title == 'monthlywtaxbypayee') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>11. Monthly WTax by Payee</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/lddap_summary/1/'.date('Y-m-d').'/'.date('Y-m-d')) }}" class="nav-link @if($title == 'lddapsummary') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>12. LDDAP Summary</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/saob/1/2/'.date('Y').'/annual') }}" class="nav-link @if($title == 'saob') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>13. SAOB</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/nca_balance_per_aclass') }}" class="nav-link @if($title == 'ncabalanceperaclass') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>14. NCA Balance per Allotment Class</p>
            </a>
         </li> 
         <li class="nav-item">
            {{-- <a href="{{ url('reports/cash_disbursement') }}" class="nav-link @if($title == 'cashdisbursement') active @endif"> --}}
            <a href="#" class="nav-link @if($title == 'cashdisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>15. Cash Disbursement</p>
            </a>
         </li> 
         <li class="nav-item">
            {{-- <a href="{{ url('reports/nca_disbursement') }}" class="nav-link @if($title == 'ncadisbursement') active @endif"> --}}
            <a href="#" class="nav-link @if($title == 'ncadisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>16. Disbursement for NCA</p>
            </a>
         </li> 
         <li class="nav-item">
            {{-- <a href="{{ url('reports/disbursement_per_rci') }}" class="nav-link @if($title == 'disbursementperrci') active @endif"> --}}
            <a href="#" class="nav-link @if($title == 'disbursementperrci') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>17. Disbursement per RCI</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/index_payment/0/'.date('Y')) }}" class="nav-link @if($title == 'indexpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>18. Index of Payment</p>
            </a>
         </li> 
      </ul>
   </li>  
