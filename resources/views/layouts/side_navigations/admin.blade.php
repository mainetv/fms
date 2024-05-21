
<li class="nav-header">ADMINISTRATION</li> 
   <li class="nav-item">
      <a href="{{ url('administration')}}" class="nav-link @if ($title == 'Administration') active @endif">
         <img src="{{ url('images/forms-icon.png') }}" width="24px">
         <p>Administration</p>
      </a>
   </li> 
              
<li class="nav-header">BUDGET PREPARATION</li>        
   <li class="nav-item">
      <a href="{{ url('budget/maintenance/')}}" class="nav-link @if ($title == 'Maintenance') active @endif">
         <img src="{{ url('images/forms-icon.png') }}" width="24px">
         <p>Call for Budget Proposal</p>
      </a>
   </li>       
   <li class="nav-item @if ($title == 'PCAARRD Budget Proposal' || $title == 'Agency Budget Proposal by PAP/Expenditure' || $title == 'Agency Budget Proposal by PAP/Activity' || $title == 'Division Budget Proposals' || $title == 'Cluster Budget Proposals' || $title == 'Cluster Budget Proposal') menu-open @endif" >
      <a href="#" class="nav-link @if ($title == 'PCAARRD Budget Proposal' || $title == 'Agency Budget Proposal by PAP/Expenditure' || $title == 'Agency Budget Proposal by PAP/Activity' || $title == 'Division Budget Proposals' || $title == 'Cluster Budget Proposals' || $title == 'Cluster Budget Proposal') active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            3-Year Budget Proposal
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item @if ($title == 'Agency Budget Proposal by PAP/Expenditure' || $title == 'Agency Budget Proposal by PAP/Activity') menu-open @endif" >
            <a href="#" class="nav-link @if ($title == 'Agency Budget Proposal by PAP/Expenditure' || $title == 'Agency Budget Proposal by PAP/Activity') active @endif">                                   
               <p>
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  Agency                                       
               </p>
               <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview"> 
               <li class="nav-item">
                  <a href="{{ url('budget_preparation/budget_proposals/agency_by_expenditure/'.date('Y')) }}" class="nav-link @if ($title == 'Agency Budget Proposal by PAP/Expenditure') active @endif">
                     <i class="fa-solid fa-circle fa-2xs"></i>
                     <p>By PAP/Expenditure</p>
                  </a>
               </li> 
               <li class="nav-item">
                  <a href="{{ url('budget_preparation/budget_proposals/agency_by_activity/'.date('Y')) }}" class="nav-link @if ($title == 'Agency Budget Proposal by PAP/Activity') active @endif">
                     <i class="fa-solid fa-circle fa-2xs"></i>
                     <p>By PAP/Activity</p>
                  </a>
               </li>                                    
            </ul>
         </li>
         <li class="nav-item">
            <a href="{{ url('budget_preparation/budget_proposals/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Budget Proposal') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Clusters</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('budget_preparation/budget_proposals/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Division Budget Proposals') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Divisions</p>
            </a>
         </li>                              
      </ul>
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
            Other BP Submissions
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ url('budget_preparation/physical_targets/division/'.date('Y')) }}" class="nav-link @if ($title == 'Physical Targets') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Physical Targets</p>
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
   <li class="nav-item">
      <a href="{{ url('programming_allocation/approved_budget/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Approved Budget') active @endif">
         <img src="{{ url('images/allotment-icon.png') }}" width="24px">
         <p>Approved Budget</p>
      </a>
   </li>       
   <li class="nav-item menu-close @if ($title == 'Monthly Cash Program' || $title == 'Monthly Cash Programs' || $title == 'Cluster Monthly Cash Program' || $title == 'Agency Monthly Cash Program' || $title == 'Quarterly Obligation Programs' || $title == 'Cluster Quarterly Obligation Program' || $title == 'Agency Quarterly Obligation Program' || $title == 'Quarterly Physical Targets') menu-open @endif" >
      <a href="#" class="nav-link @if ($title == 'Monthly Cash Program' || $title == 'Monthly Cash Programs' || $title == 'Cluster Monthly Cash Program' || $title == 'Agency Monthly Cash Program' || $title == 'Quarterly Obligation Programs' || $title == 'Cluster Quarterly Obligation Program' || $title == 'Agency Quarterly Obligation Program' || $title == 'Quarterly Physical Targets') active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            NEP
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">  
         {{-- monthly cash program --}}
            <li class="nav-item @if ($title == 'Agency Monthly Cash Program' || $title == 'Cluster Monthly Cash Program' || $title == 'Monthly Cash Programs') menu-open @endif" >
               <a href="#" class="nav-link @if ($title == 'Agency Monthly Cash Program' || $title == 'Cluster Monthly Cash Program' || $title == 'Monthly Cash Programs') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>
                     Monthly Cash Program
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/monthly_cash_programs/agency/'.date('Y')) }}" class="nav-link @if ($title == 'Agency Monthly Cash Program') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
                        <p>Agency</p>
                     </a>
                  </li>                                    
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/monthly_cash_programs/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Monthly Cash Program') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
                        <p>Clusters</p>
                     </a>
                  </li>  
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/monthly_cash_programs/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Monthly Cash Programs') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
                        <p>Divisions</p>
                     </a>
                  </li>                                 
               </ul>
            </li> 
            
            <li class="nav-item @if ($title == 'Agency Quarterly Obligation Program' || $title == 'Cluster Quarterly Obligation Program' || $title == 'Quarterly Obligation Programs') menu-open @endif" >
               <a href="#" class="nav-link @if ($title == 'Agency Quarterly Obligation Program' || $title == 'Cluster Quarterly Obligation Program' || $title == 'Quarterly Obligation Programs') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>
                     Quarterly Obligation Program
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/quarterly_obligation_programs/agency/'.date('Y')) }}" class="nav-link @if ($title == 'Agency Quarterly Obligation Program') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
                        <p>Agency</p>
                     </a>
                  </li>                                    
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/quarterly_obligation_programs/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Quarterly Obligation Program') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
                        <p>Clusters</p>
                     </a>
                  </li>  
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/quarterly_obligation_programs/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Quarterly Obligation Programs') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
                        <p>Divisions</p>
                     </a>
                  </li>                                 
               </ul>
            </li> 
            {{-- quarterly physical targets --}}
            <li class="nav-item @if ($title == 'PCAARRD Quarterly Physical Targets' || $title == 'Cluster Quarterly Physical Targets' || $title == 'Division Quarterly Physical Targets') menu-open @endif" >
               <a href="#" class="nav-link @if ($title == 'PCAARRD Quarterly Physical Targets' || $title == 'Cluster Quarterly Physical Targets' || $title == 'Division Quarterly Physical Targets') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>
                     Quarterly Physical Targets
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                     <li class="nav-item">
                        {{-- <a href="{{ url('programming_allocation/nep/quarterly_physical_targets/agency/'.date('Y')) }}" class="nav-link @if ($title == 'PCAARRD Quarterly Physical Targets') active @endif"> --}}
                        <a href="#" class="nav-link @if ($title == 'PCAARRD Quarterly Physical Targets') active @endif">
                           <i class="fa-solid fa-circle fa-2xs"></i>
                           {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
                           <p>Agency</p>
                        </a>
                     </li>                                    
                     <li class="nav-item">
                        {{-- <a href="{{ url('programming_allocation/nep/quarterly_physical_targets/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Quarterly Physical Targets') active @endif"> --}}
                        <a href="#" class="nav-link @if ($title == 'Cluster Quarterly Physical Targets') active @endif">
                           <i class="fa-solid fa-circle fa-2xs"></i>
                           {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
                           <p>Clusters</p>
                        </a>
                     </li> 
                  <li class="nav-item">
                     {{-- <a href="{{ url('programming_allocation/nep/quarterly_physical_targets/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Division Quarterly Physical Targets') active @endif"> --}}
                     <a href="#" class="nav-link @if ($title == 'Division Quarterly Physical Targets') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        {{-- <img src="{{ url('images/nep-icon.png') }}" width="24px"> --}}
                        <p>Divisions</p>
                     </a>
                  </li>                                 
               </ul>
            </li>
      </ul>
   </li> 
   <li class="nav-item">
      <a href="{{ url('programming_allocation/allotment/1/'.date('Y').'/annual') }}" class="nav-link @if ($title == 'Allotment') active @endif">
         <img src="{{ url('images/allotment-icon.png') }}" width="24px">
         <p>Allotment</p>
      </a>
   </li> 
   <li class="nav-item">
      <a href="{{ url('programming_allocation/nca/'.date('Y')) }}" class="nav-link @if ($title == 'NCA') active @endif">
         <img src="{{ url('images/allotment-icon.png') }}" width="24px">
         <p>NCA</p>
      </a>
   </li>           
   
<li class="nav-header">FUNDS UTILIZATION</li> 
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/all/ors/'.date('m').'/'.date('Y')) }}"
         class="nav-link @if ($title == 'Obligation Request and Status (ORS)' || $title == 'Edit Obligation Request and Status' || $title == 'Add Obligation Request and Status')) active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>ORS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/all/burs/'.date('m').'/'.date('Y')) }}"
         class="nav-link @if ($title == 'Budget Utilization Request and Status (BURS)' || $title == 'Edit Budget Utilization Request and Status' || $title == 'Add Budget Utilization Request and Status')) active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/all/burs-cfitf/'.date('m').'/'.date('Y')) }}"
         class="nav-link @if ($title == 'Budget Utilization Request and Status - Coconut Trust Fund (BURS-CFITF)' || $title == 'Edit Budget Utilization Request and Status - Coconut Trust Fund' || $title == 'Add Budget Utilization Request and Status - Coconut Trust Fund')) active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS-CFITF</p>
      </a>
   </li>  
   <li class="nav-item">
      <a href="{{ url('funds_utilization/dv/all/'.date('Y-m-d')) }}" class="nav-link @if ($title == 'Disbursement Voucher (DV)' || $title == 'Edit Disbursement Voucher' || $title == 'Add Disbursement Voucher') active @endif">
         <img src="{{ url('images/dv-icon.png') }}" width="25px">
         <p>Disbursement Vouchers</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/lddap/1/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'List of Due and Demandable Accounts Payable (LDDAP)' || $title == 'Edit LDDAP') active @endif">
         <img src="{{ url('images/lddap-icon.png') }}" width="23px">
         <p>LDDAP</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/ada/1/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'Advice to Debit Accounts (ADA)' || $title == 'Add ADA' || $title == 'Edit ADA') active @endif">
         <img src="{{ url('images/ada-icon.png') }}" width="23px">
         <p>ADA</p>
      </a>
   </li>                         
   <li class="nav-item">
      <a href="{{ url('funds_utilization/checks/all/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'Checks' || $title == 'Add Check' || $title == 'Edit Check') active @endif">
         <img src="{{ url('images/ada-icon.png') }}" width="23px">
         <p>Checks</p>
      </a>
   </li>  
   <li class="nav-item @if ($title == 'rsperdivision' || $title == 'adaperpap' || $title == 'rsbalance' || $title=='lddapissued' || $title=='rsperpap' || $title=='rsperactivity' || $title=='saob' || $title=='allotmentsummary') menu-open @endif">
      <a href="#" class="nav-link @if ($title == 'rsperdivision' || $title == 'adaperpap' || $title == 'rsbalance' || $title=='lddapissued' || $title=='rsperpap' || $title=='rsperactivity' || $title=='saob' || $title=='allotmentsummary') active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            Reports
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_division') }}" class="nav-link @if($title == 'rsperdivision') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>1. ORS/BURS per Responsibility Center</p>
            </a>
         </li>  
         <li class="nav-item">
            <a href="{{ url('reports/ada_check_per_pap') }}" class="nav-link @if($title == 'adaperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>2. Checks/ADA per PAP</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_balance') }}" class="nav-link @if($title == 'rsbalance') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>3. ORS/BURS Balance</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/ada_check_issued') }}" class="nav-link @if($title == 'lddapissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>4. LDDAP/Checks Issued</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_pap/1/'.date('Y-m-d').'/'.date('Y-m-d')) }}" class="nav-link @if($title == 'rsperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>5. ORS per PAP</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_activity/1/'.date('Y').'/annual') }}" class="nav-link @if($title == 'rsperactivity') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>6. ORS per Activity/LIB</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/saob/1/2/'.date('Y').'/annual') }}" class="nav-link @if ($title == 'saob') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>7. SAOB</p>
            </a>
         </li>  
         <li class="nav-item">
            <a href="{{ url('reports/allotment_summary/1/'.date('Y')) }}" class="nav-link @if($title == 'allotmentsummary') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>8. Allotment Summary</p>
            </a>
         </li>                        
      </ul>
   </li>          
