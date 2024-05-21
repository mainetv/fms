<li class="nav-header">BUDGET PREPARATION</li>                                
   <li class="nav-item">
      <a href="{{ url('budget_preparation/budget_proposals/division/'.date('Y')) }}" class="nav-link @if ($title == 'Division Budget Proposal') active @endif">
         <img src="{{ url('images/proposal-icon.png') }}" width="24px">
         <p>3-Year Division Proposal</p>
      </a>
   </li>  
   <li class="nav-item">
      <a href="{{ url('budget_preparation/bp_forms/'.date('Y')) }}" class="nav-link @if ($title == 'BP Forms') active @endif">
         <img src="{{ url('images/forms-icon.png') }}" width="24px">
         <p>BP Forms</p>
      </a>
   </li>   
   <li class="nav-item @if ($title == 'PCAARRD Physical Targets' || $title == 'Physical Targets' || $title == 'Cluster Physical Targets') menu-open @endif" >
      <a href="#" class="nav-link @if ($title == 'PCAARRD Physical Targets' || $title == 'Physical Targets' || $title == 'Cluster Physical Targets') active @endif">
         <img src="{{ url('images/targets-icon.png') }}" width="24px">
         <p>
            Other BP
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ url('budget_preparation/physical_targets/division/'.date('Y')) }}" class="nav-link @if ($title == 'Physical Targets') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Divisions</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="#" class="nav-link @if ($title == 'DPPMP') active @endif">
               <img src="{{ url('images/procurement-icon.png') }}" width="24px">
               <p>DPPMP</p>
            </a>
         </li>  
      </ul>
   </li>                
<li class="nav-header">PROGRAMMING & ALLOCATION</li> 
   <li class="nav-item menu-close @if ($title == 'Monthly Cash Program' || $title == 'Monthly Cash Programs' || $title == 'Cluster Monthly Cash Program' || $title == 'Agency Monthly Cash Program' || $title == 'Quarterly Obligation Programs' || $title == 'Cluster Quarterly Obligation Program' || $title == 'Agency Quarterly Obligation Program' || $title == 'Quarterly Physical Targets') menu-open @endif" >
      <a href="#" class="nav-link @if ($title == 'Monthly Cash Program' || $title == 'Monthly Cash Programs' || $title == 'Cluster Monthly Cash Program' || $title == 'Agency Monthly Cash Program' || $title == 'Quarterly Obligation Programs' || $title == 'Cluster Quarterly Obligation Program' || $title == 'Agency Quarterly Obligation Program' || $title == 'Quarterly Physical Targets') active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            NEP
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">  
         <li class="nav-item">
            <a href="{{ url('programming_allocation/nep/monthly_cash_programs/division/'.date('Y')) }}" class="nav-link @if ($title == 'Monthly Cash Program') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
               <p>Monthly Cash Program</p>
            </a>
         </li>  
         <li class="nav-item">
            <a href="{{ url('programming_allocation/nep/quarterly_obligation_programs/division/'.date('Y')) }}" class="nav-link @if ($title == 'Quarterly Obligation Program') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
               <p>Quarterly Obligation Program</p>
            </a>
         </li>
         <li class="nav-item">
            <a href="{{ url('programming_allocation/quarterly_physical_targets/division/'.date('Y')) }}" class="nav-link @if ($title == 'Quarterly Physical Targets') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
               <p>Quarterly Physical Targets</p>
            </a>
         </li> 
      </ul>
   </li>         
   
<li class="nav-header">FUNDS UTILIZATION</li>                     
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/division/ors/'.date('m').'/'.date('Y')) }}"
         class="nav-link @if ($title == 'Obligation Request and Status (ORS)' || $title == 'Edit Obligation Request and Status' || $title == 'Add Obligation Request and Status')) active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>ORS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/division/burs/'.date('m').'/'.date('Y')) }}" 
         class="nav-link @if ($title == 'Budget Utilization Request and Status (BURS)' || $title == 'Edit Budget Utilization Request and Status' || $title == 'Add Budget Utilization Request and Status')) active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/division/burs_cfitf/'.date('m').'/'.date('Y')) }}"
         class="nav-link @if ($title == 'Budget Utilization Request and Status - Coconut Trust Fund (BURS-CFITF)' || $title == 'Edit Budget Utilization Request and Status - Coconut Trust Fund' || $title == 'Add Budget Utilization Request and Status - Coconut Trust Fund')) active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS-CFITF</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/dv/division') }}" class="nav-link @if ($title == 'Disbursement Voucher (DV)' || $title == 'Edit Disbursement Voucher' || $title == 'Add Disbursement Voucher') active @endif">
         <img src="{{ url('images/dv-icon.png') }}" width="25px">
         <p>Disbursement Vouchers</p>
      </a>
   </li>
   <li class="nav-item @if ($title == 'Statement of Allotment and Obligation (SAOB)' || $title == 'Checks/ADA Payment per PAP/Account Code' || $title=='RS Balance' || $title=='RS per Responsibility Center' ) menu-open @endif">
      <a href="#" class="nav-link @if ($title == 'Statement of Allotment and Obligation (SAOB)' || $title == 'Checks/ADA Payment per PAP/Account Code' || $title=='RS Balance' || $title=='RS per Responsibility Center' ) active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            Reports
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_division') }}" class="nav-link @if($title == 'RS per Responsibility Center') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>RS per Responsibility Center</p>
            </a>
         </li>  
         <li class="nav-item">
            <a href="{{ url('reports/ada_check_per_pap') }}" class="nav-link @if($title == 'Checks/ADA Payment per PAP/Account Code') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Checks/ADA per PAP</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_balance') }}" class="nav-link @if($title == 'RS Balance') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>RS Balance</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/lddap_check_issued') }}" class="nav-link @if($title == 'LDDAP/Check Issued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>LDDAP/Check Issued</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_pap') }}" class="nav-link @if($title == 'RS per PAP') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>RS per PAP</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_activity') }}" class="nav-link @if($title == 'RS per Activity/LIB') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>RS per Activity/LIB</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/saob/1/2/'.date('Y').'/annual') }}" class="nav-link @if ($title == 'Statement of Allotment and Obligation (SAOB)') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>SAOB</p>
            </a>
         </li>  
         <li class="nav-item">
            <a href="{{ url('reports/allotment_summary') }}" class="nav-link @if($title == 'Allotment Summary') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Allotment Summary</p>
            </a>
         </li>                        
      </ul>
   </li>                 
