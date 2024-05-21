<li class="nav-header">FUNDS UTILIZATION</li>  
   <li class="nav-item">
      <a href="{{ url('funds_utilization/dv/division/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'Disbursement Voucher (DV)' || $title == 'Edit Disbursement Voucher' || $title == 'Add Disbursement Voucher') active @endif">
         <img src="{{ url('images/dv-icon.png') }}" width="25px">
         <p>Disbursement Vouchers</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/ada/1/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'Advice to Debit Accounts (ADA)' || $title == 'Add ADA' || $title == 'Edit ADA') active @endif">
         <img src="{{ url('images/ada-icon.png') }}" width="23px">
         <p>ADA</p>
      </a>
   </li>  
   <li class="nav-item">
      <a href="{{ url('funds_utilization/radai/all/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'RADAI' || $title == 'Add RADAI' || $title == 'Edit RADAI') active @endif">
         <img src="{{ url('images/radai-icon.png') }}" width="25px">
         <p>Report of ADA Issued</p>
      </a>
   </li>                       
   <li class="nav-item">
      <a href="{{ url('funds_utilization/checks/all/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'Checks' || $title == 'Add Check' || $title == 'Edit Check') active @endif">
         <img src="{{ url('images/check-icon.png') }}" width="25px">
         <p>Checks</p>
      </a>
   </li>  
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rci/all/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'RCI' || $title == 'Add RCI' || $title == 'Edit RCI') active @endif">
         <img src="{{ url('images/rci-icon.png') }}" width="25px">
         <p>Report of Checks Issued</p>
      </a>
   </li>  
   <li class="nav-item @if ($title == 'checksissued' || $title == 'lddapissued' || $title == 'lddapcheckissued' || $title == 'lddapsummary' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='lddapcheckissuedperpayee' || $title=='dvrsperpap' || $title=='rsperpap' || $title=='rsbalance' || $title=='lddapcheckperpap' || $title=='monthlywtax' || $title=='monthlywtaxbypayee' || $title=='lddapsummary' || $title=='saob' || $title=='ncabalanceperdivision' || $title=='ncabalanceperaclass' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='disbursementperrci' || $title=='indexpayment') menu-open @endif">
      <a href="#" class="nav-link @if ($title == 'checksissued' || $title == 'lddapissued' || $title == 'lddapcheckissued' || $title == 'lddapsummary' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='lddapcheckissuedperpayee' || $title=='dvrsperpap' || $title=='rsperpap' || $title=='rsbalance' || $title=='lddapcheckperpap' || $title=='monthlywtax' || $title=='monthlywtaxbypayee' || $title=='lddapsummary' || $title=='saob' || $title=='ncabalanceperdivision' || $title=='ncabalanceperaclass' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='disbursementperrci' || $title=='indexpayment') active @endif">
         <img src="{{ url('images/report-icon.png') }}" width="23px">
         <p>
            Reports
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview"> 
         <li class="nav-item">
            <a href="{{ url('reports/checks_issued') }}" class="nav-link @if($title == 'checksissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Checks Issued <sub>by period<sub></p>
            </a>
         </li>  
         <li class="nav-item">
            <a href="{{ url('reports/lddap_issued') }}" class="nav-link @if($title == 'lddapissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>LDDAP-ADA Issued</p>
            </a>
         </li>   
         <li class="nav-item">
            <a href="{{ url('reports/lddap_check_issued') }}" class="nav-link @if($title == 'lddapcheckissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>LDDAP/Checks Issued</p>
            </a>
         </li>         
         <li class="nav-item">
            <a href="{{ url('reports/lddap_summary/1/'.date('Y-m-d').'/'.date('Y-m-d')) }}" class="nav-link @if($title == 'lddapsummary') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>LDDAP-ADA Summary</p>
            </a>
         </li>         
         <li class="nav-item">
            {{-- <a href="{{ url('reports/cash_disbursement') }}" class="nav-link @if($title == 'cashdisbursement') active @endif"> --}}
            <a href="#" class="nav-link @if($title == 'cashdisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Cash Disbursement(to follow)</p>
            </a>
         </li> 
         <li class="nav-item">
            {{-- <a href="{{ url('reports/nca_disbursement') }}" class="nav-link @if($title == 'ncadisbursement') active @endif"> --}}
            <a href="#" class="nav-link @if($title == 'ncadisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Cash Receipt(to follow)</p>
            </a>
         </li> 
         <li class="nav-item">
            {{-- <a href="{{ url('reports/disbursement_per_rci') }}" class="nav-link @if($title == 'disbursementperrci') active @endif"> --}}
            <a href="#" class="nav-link @if($title == 'disbursementperrci') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Collections and Deposits(to follow)</p>
            </a>
         </li> 
         <li class="nav-item">
            {{-- <a href="{{ url('reports/index_payment') }}" class="nav-link @if($title == 'indexofpayment') active @endif"> --}}
            <a href="#" class="nav-link @if($title == 'indexofpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Disbursement(to follow)</p>
            </a>
         </li> 
         <li class="nav-item">
            {{-- <a href="{{ url('reports/index_payment') }}" class="nav-link @if($title == 'indexofpayment') active @endif"> --}}
            <a href="#" class="nav-link @if($title == 'indexofpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Unreleased Checks(to follow)</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/index_payment/0/'.date('Y')) }}" class="nav-link @if($title == 'indexpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Index of Payments</p>
            </a>
         </li> 
      </ul>
   </li>  
