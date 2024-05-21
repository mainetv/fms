

{{-- @hasanyrole('Super Administrator|Administrator|')  
   <li class="nav-item">
      <a href="{{ url('') }}" class="nav-link @if ($title == 'Dashboard') active @endif">
         <i class="nav-icon fas fa-tachometer-alt"></i>
         <p>Dashboard</p>
      </a>
   </li>  
@else
   <li class="nav-item">
      <a href="{{ url('') }}" class="nav-link @if ($title == 'divisiondashboard') active @endif">
         <i class="nav-icon fas fa-tachometer-alt"></i>
         <p>Dashboard</p>
      </a>
   </li>  
@endhasanyrole        --}}

@hasanyrole('Super Administrator|Administrator|Budget Officer|Accounting Officer')  
   <li class="nav-header">ADMINISTRATION</li> 
   @unlessrole('Budget Officer|Accounting Officer')
      <li class="nav-item">
         <a href="{{ url('administration')}}" class="nav-link @if ($title == 'Administration') active @endif">
            <img src="{{ url('images/forms-icon.png') }}" width="24px">
            <p>Administration</p>
         </a>
      </li> 
   @endunlessrole      
   <li class="nav-item">
      <a href="{{ url('libraries')}}" class="nav-link @if ($title == 'Libraries') active @endif">
         <img src="{{ url('images/forms-icon.png') }}" width="24px">
         <p>Libraries</p>
      </a>
   </li> 
@endhasanyrole       

@unlessrole('Accounting Officer|Cash Officer') 
<li class="nav-header">BUDGET PREPARATION</li>    
@endunlessrole 
   @hasanyrole('Super Administrator|Administrator|Budget Officer')     
      {{-- <li class="nav-item">
         <a href="{{ url('budget/maintenance/')}}" class="nav-link @if ($title == 'Maintenance') active @endif">
            <img src="{{ url('images/forms-icon.png') }}" width="24px">
            <p>Call for Budget Proposal</p>
         </a>
      </li>     --}}
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
                     <a href="{{ url('budget_preparation/budget_proposal/agency_by_expenditure/'.date('Y')) }}" class="nav-link @if ($title == 'Agency Budget Proposal by PAP/Expenditure') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        <p>By PAP/Expenditure</p>
                     </a>
                  </li> 
                  <li class="nav-item">
                     <a href="{{ url('budget_preparation/budget_proposal/agency_by_activity/'.date('Y')) }}" class="nav-link @if ($title == 'Agency Budget Proposal by PAP/Activity') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        <p>By PAP/Activity</p>
                     </a>
                  </li>                                    
               </ul>
            </li>
            <li class="nav-item">
               <a href="{{ url('budget_preparation/budget_proposal/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Budget Proposal') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>Clusters</p>
               </a>
            </li> 
            <li class="nav-item">
               <a href="{{ url('budget_preparation/budget_proposal/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Division Budget Proposals') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>Divisions</p>
               </a>
            </li>                              
         </ul>
      </li>   
   @endhasanyrole    
   @hasanyrole('Executive Director|BPAC Chair|BPAC')    
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
                     <a href="{{ url('budget_preparation/budget_proposal/agency_by_expenditure/'.date('Y')) }}" class="nav-link @if ($title == 'Agency Budget Proposal by PAP/Expenditure') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        <p>By PAP/Expenditure</p>
                     </a>
                  </li> 
                  <li class="nav-item">
                     <a href="{{ url('budget_preparation/budget_proposal/agency_by_activity/'.date('Y')) }}" class="nav-link @if ($title == 'Agency Budget Proposal by PAP/Activity') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        <p>By PAP/Activity</p>
                     </a>
                  </li>                                    
               </ul>
            </li>
            <li class="nav-item">
               <a href="{{ url('budget_preparation/budget_proposal/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Budget Proposal') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>Clusters</p>
               </a>
            </li> 
            <li class="nav-item">
               <a href="{{ url('budget_preparation/budget_proposal/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Division Budget Proposals') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>Divisions</p>
               </a>
            </li>                              
         </ul>
      </li>   
   @endhasanyrole 
   @hasanyrole('Division Budget Controller|Division Director|Section Head')                        
      <li class="nav-item">
         <a href="{{ url('budget_preparation/budget_proposal/division/'.date('Y')) }}" class="nav-link @if ($title == 'Division Budget Proposal') active @endif">
            <img src="{{ url('images/proposal-icon.png') }}" width="24px">
            <p>3-Year Division Proposal</p>
         </a>
      </li>    
   @endhasanyrole 
   @unlessrole('Accounting Officer|Cash Officer') 
   <li class="nav-item">
      <a href="{{ url('budget_preparation/bp_forms/'.date('Y')) }}" class="nav-link @if ($title == 'BP Forms') active @endif">
         <img src="{{ url('images/forms-icon.png') }}" width="24px">         
         <p>BP Forms</p>
         {{-- <img src="{{ url('images/web-maintenance.jpg') }}" width="60"> --}}
      </a>
   </li> 
   @endunlessrole
   {{-- <li class="nav-item @if ($title == 'PCAARRD Physical Targets' || $title == 'Physical Targets' || $title == 'Cluster Physical Targets') menu-open @endif" >
      <a href="#" class="nav-link @if ($title == 'PCAARRD Physical Targets' || $title == 'Physical Targets' || $title == 'Cluster Physical Targets') active @endif">
         <img src="{{ url('images/targets-icon.png') }}" width="24px">
         <p>
            Other
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
   </li> --}}

  
<li class="nav-header">PROGRAMMING & ALLOCATION</li>  
   @hasanyrole('Super Administrator|Administrator|Budget Officer') 
      {{-- <li class="nav-item">
         <a href="{{ url('programming_allocation/approved_budget/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Approved Budget') active @endif">
            <img src="{{ url('images/allotment-icon.png') }}" width="24px">
            <p>Approved Budget</p>
         </a>
      </li>   --}}
   @endhasanyrole   
   @hasanyrole('Super Administrator|Administrator|Budget Officer|Executive Director|BPAC Chair|BPAC')       
      <li class="nav-item menu-close @if ($title == 'mcp' || $title == 'qop' || $title == 'clustermcp' || $title == 'agencymcp' || $title == 'clusterqop' || $title == 'agencyqop') menu-open @endif" >
         <a href="#" class="nav-link @if ($title == 'mcp' || $title == 'qop' || $title == 'clustermcp' || $title == 'agencymcp' || $title == 'clusterqop' || $title == 'agencyqop') active @endif">
            <img src="{{ url('images/nep-icon.png') }}" width="24px">
            NEP<i class="right fas fa-angle-left"></i>
            {{-- <sub>@unlessrole('Super Administrator|Administrator') as @endunlessrole {{ $getUserRoleNotDivision }}</sub> --}}
         </a>
         <ul class="nav nav-treeview">  
            <li class="nav-item @if ($title == 'mcp' || $title == 'clustermcp' || $title == 'agencymcp') menu-open @endif" >
               <a href="#" class="nav-link @if ($title == 'mcp' || $title == 'clustermcp' || $title == 'agencymcp') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>
                     Monthly Cash Program
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="{{ url('programming_allocation/nep/monthly_cash_program/agency/'.date('Y')) }}" class="nav-link @if ($title == 'agencymcp') active @endif">
                           <i class="fa-solid fa-circle fa-2xs"></i>
                           <p>Agency</p>
                        </a>
                     </li>                                    
                     <li class="nav-item">
                        <a href="{{ url('programming_allocation/nep/monthly_cash_program/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'clustermcp') active @endif">
                           <i class="fa-solid fa-circle fa-2xs"></i>
                           <p>Cluster</p>
                        </a>
                     </li>  
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/monthly_cash_program/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'mcp') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        <p>Divisions</p>
                     </a>
                  </li>                                 
               </ul>
            </li>             
            <li class="nav-item @if ($title == 'qop' || $title == 'clusterqop' || $title == 'agencyqop') menu-open @endif" >
               <a href="#" class="nav-link @if ($title == 'qop' || $title == 'clusterqop' || $title == 'agencyqop') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>
                     Quarterly Obligation Program
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/quarterly_obligation_program/agency/'.date('Y')) }}" class="nav-link @if ($title == 'agencyqop') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        <p>Agency</p>
                     </a>
                  </li>                                    
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/quarterly_obligation_program/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'clusterqop') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        <p>Cluster</p>
                     </a>
                  </li>  
                  <li class="nav-item">
                     <a href="{{ url('programming_allocation/nep/quarterly_obligation_program/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'qop') active @endif">
                        <i class="fa-solid fa-circle fa-2xs"></i>
                        <p>Divisions</p>
                     </a>
                  </li>                                 
               </ul>
            </li> 
         </ul>
      </li>  
   @endhasanyrole 
   @hasanyrole('Division Budget Controller|Division Director|Section Head')  
      <li class="nav-item menu-close @if ($title == 'mcpdivision' || $title == 'qopdivision') menu-open @endif" >
         <a href="#" class="nav-link @if ($title == 'mcpdivision' || $title == 'qopdivision') active @endif">
            <img src="{{ url('images/nep-icon.png') }}" width="24px">
            <p>
               NEP<sub>@hasrole('Budget Officer') as DBC @endhasrole</sub>
               <i class="right fas fa-angle-left"></i>
            </p>
         </a>
         <ul class="nav nav-treeview">  
            <li class="nav-item">
               <a href="{{ url('programming_allocation/nep/monthly_cash_program/division/'.date('Y')) }}" class="nav-link @if ($title == 'mcpdivision') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>Monthly Cash Program</p>
               </a>
            </li>  
            <li class="nav-item">
               <a href="{{ url('programming_allocation/nep/quarterly_obligation_program/division/'.date('Y')) }}" class="nav-link @if ($title == 'qopdivision') active @endif">
                  <i class="fa-solid fa-circle fa-2xs"></i>
                  <p>Quarterly Obligation Program</p>
               </a>
            </li>
         </ul>
      </li> 
   @endhasanyrole 
   @hasanyrole('Super Administrator|Administrator|Budget Officer') 
      <li class="nav-item">
         <a href="{{ url('programming_allocation/allotment/1/'.date('Y').'/annual') }}" class="nav-link @if ($title == 'Allotment') active @endif">
            <img src="{{ url('images/allotment-icon.png') }}" width="24px">
            <p>Allotment</p>
         </a>
      </li> 
   @endhasanyrole
   @hasanyrole('Super Administrator|Administrator|Accounting Officer') 
      <li class="nav-item">
         <a href="{{ url('programming_allocation/nca/1/'.date('Y')) }}" class="nav-link @if ($title == 'NCA') active @endif">
            <img src="{{ url('images/allotment-icon.png') }}" width="24px">
            <p>NCA</p>
         </a>
      </li>   
   @endhasanyrole

@hasanyrole('Super Administrator|Administrator|Budget Officer|Accounting Officer|Cash Officer')
<li class="nav-header">FUNDS UTILIZATION</li>    
@endhasanyrole 
@hasanyrole('Super Administrator|Administrator|Budget Officer|Accounting Officer')
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/all/ors/'.date('m').'/'.date('Y')) }}" 
         class="nav-link @if ($title == 'ors') active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>ORS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/all/burs/'.date('m').'/'.date('Y')) }}" 
         class="nav-link @if ($title == 'burs') active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/all/burs-cfitf/'.date('m').'/'.date('Y')) }}"
         class="nav-link @if ($title == 'bursc') active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS-CFITF</p>
      </a>
   </li>
@endhasanyrole
@hasanyrole('Super Administrator|Administrator|Accounting Officer') 
   <li class="nav-item">
      <a href="{{ url('funds_utilization/dv/all/'.date('Y-m-d')) }}" class="nav-link @if ($title == 'alldv') active @endif">
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
@endhasanyrole
@hasanyrole('Super Administrator|Administrator|Cash Officer')
   @hasanyrole('Cash Officer')  
      <li class="nav-item">
         <a href="{{ url('funds_utilization/dv/all_division/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'alldivisiondv') active @endif">
            <img src="{{ url('images/dv-icon.png') }}" width="25px">
            <p>Disbursement Vouchers</p>
         </a>
      </li>
   @endhasanyrole
   @hasanyrole('Super Administrator|Administrator|Cash Officer')  
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
   @endhasrole
@endhasanyrole  
@hasanyrole('Super Administrator|Administrator')
   <li class="nav-item @if ($title == 'saob' || $title == 'rsperdivision' || $title == 'adacheckissued'|| $title == 'adacheckperpap' || $title == 'rsbalance' || $title=='lddapcheckissued' || $title=='rsperpap' || $title=='rsperactivity' || $title=='allotmentsummary'|| $title == 'receiveddvs' || $title == 'dvperdivision' || $title == 'dvsummary' || $title=='adacheckissuedperpayee' || $title=='dvrsperpap' || $title=='monthlywtax' || $title=='monthlywtaxbypayee' || $title=='lddapsummary' || $title=='ncabalanceperaclass' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='disbursementperrci' || $title=='indexpayment' || $title == 'checksissued' || $title == 'lddapissued' || $title == 'lddapcheckissued' || $title == 'lddapsummary' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='lddapcheckissuedperpayee' || $title=='dvrsperpap' || $title=='rsperpap' || $title=='rsbalance' || $title=='lddapcheckperpap' || $title=='monthlywtax' || $title=='monthlywtaxbypayee' || $title=='lddapsummary' || $title=='saob' || $title=='ncabalanceperdivision' || $title=='ncabalanceperaclass' || $title=='cashdisbursement') menu-open @endif">
      <a href="#" class="nav-link @if ($title == 'saob' || $title == 'rsperdivision' || $title == 'adacheckissued'|| $title == 'adacheckperpap' || $title == 'rsbalance' || $title=='lddapcheckissued' || $title=='rsperpap' || $title=='rsperactivity' || $title=='allotmentsummary'|| $title == 'receiveddvs' || $title == 'dvperdivision' || $title == 'dvsummary' || $title=='adacheckissuedperpayee' || $title=='dvrsperpap' || $title=='monthlywtax' || $title=='monthlywtaxbypayee' || $title=='lddapsummary' || $title=='ncabalanceperaclass' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='disbursementperrci' || $title=='indexpayment' || $title == 'checksissued' || $title == 'lddapissued' || $title == 'lddapcheckissued' || $title == 'lddapsummary' || $title=='cashdisbursement' || $title=='ncadisbursement' || $title=='lddapcheckissuedperpayee' || $title=='dvrsperpap' || $title=='rsperpap' || $title=='rsbalance' || $title=='lddapcheckperpap' || $title=='monthlywtax' || $title=='monthlywtaxbypayee' || $title=='lddapsummary' || $title=='saob' || $title=='ncabalanceperdivision' || $title=='ncabalanceperaclass' || $title=='cashdisbursement') active @endif">
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
            <a href="{{ url('reports/ada_check_per_pap') }}" class="nav-link @if($title == 'adacheckperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>2. ADA/Check per PAP</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_balance') }}" class="nav-link @if($title == 'rsbalance') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>3. ORS/BURS Balance</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/ada_check_issued') }}" class="nav-link @if($title == 'adacheckissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>4. ADA/Checks Issued</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_pap/1/'.date('Y-m-d').'/'.date('Y-m-d')) }}" class="nav-link @if($title == 'rsperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>5. ORS/BURS per PAP</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_activity/1/'.date('Y').'/annual') }}" class="nav-link @if($title == 'rsperactivity') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>6. ORS/BURS per Activity/LIB</p>
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
         <li class="nav-item">
            <a href="{{ url('reports/received_dvs/') }}" class="nav-link @if($title == 'receiveddvs') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>9. Received DVs</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/dv_per_division') }}" class="nav-link @if($title == 'dvperdivision') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>10. Disbursement per Division</p>
            </a>
         </li> 
         {{-- <li class="nav-item">
            <a href="{{ url('reports/dv_summary/1/'.date('Y')) }}" class="nav-link @if($title == 'dvsummary') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>3. Disbursement Summary</p>
            </a>
         </li>         --}}
         <li class="nav-item">
            <a href="{{ url('reports/ada_check_issued_per_payee') }}" class="nav-link @if($title == 'adacheckissuedperpayee') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>11. ADA/Checks Issued per Payee</p>
            </a>
         </li>           
         <li class="nav-item">
            <a href="{{ url('reports/dvrs_per_pap/') }}" class="nav-link @if ($title == 'dvrsperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>12. DV ORS/BURS per PAP</p>
            </a>
         </li>          
         <li class="nav-item">
            <a href="{{ url('reports/monthly_wtax/'.date('m').'/'.date('Y')) }}" class="nav-link @if($title == 'monthlywtax') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>13. Monthly WTax</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/monthly_wtax_by_payee/'.date('m').'/'.date('Y')) }}" class="nav-link @if($title == 'monthlywtaxbypayee') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>14. Monthly WTax by Payee</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/lddap_summary/1/'.date('Y-m-d').'/'.date('Y-m-d')) }}" class="nav-link @if($title == 'lddapsummary') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>15. LDDAP Summary</p>
            </a>
         </li> 
         {{-- <li class="nav-item">
            <a href="{{ url('reports/nca_balance_per_aclass') }}" class="nav-link @if($title == 'ncabalanceperaclass') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>16. NCA Balance per Allotment Class</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/cash_disbursement') }}" class="nav-link @if($title == 'cashdisbursement') active @endif">
            <a href="#" class="nav-link @if($title == 'cashdisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>15. Cash Disbursement</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/nca_disbursement') }}" class="nav-link @if($title == 'ncadisbursement') active @endif">
            <a href="#" class="nav-link @if($title == 'ncadisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>16. Disbursement for NCA</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/disbursement_per_rci') }}" class="nav-link @if($title == 'disbursementperrci') active @endif">
            <a href="#" class="nav-link @if($title == 'disbursementperrci') active @endif">
            <i class="fa-solid fa-circle fa-2xs"></i>
               <p>17. Disbursement per RCI</p>
            </a>
         </li>  --}}
         <li class="nav-item">
            <a href="{{ url('reports/index_payment/0/'.date('Y')) }}" class="nav-link @if($title == 'indexpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>16. Index of Payment</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/checks_issued') }}" class="nav-link @if($title == 'checksissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>17. Checks Issued <sub>by period<sub></p>
            </a>
         </li>  
         {{-- <li class="nav-item">
            <a href="{{ url('reports/lddap_issued') }}" class="nav-link @if($title == 'lddapissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>18. LDDAP-ADA Issued</p>
            </a>
         </li>    --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/lddap_check_issued') }}" class="nav-link @if($title == 'lddapcheckissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>19. LDDAP/Checks Issued</p>
            </a>
         </li>         --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/cash_disbursement') }}" class="nav-link @if($title == 'cashdisbursement') active @endif">
            <a href="#" class="nav-link @if($title == 'cashdisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Cash Disbursement(to follow)</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/nca_disbursement') }}" class="nav-link @if($title == 'ncadisbursement') active @endif">
            <a href="#" class="nav-link @if($title == 'ncadisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Cash Receipt(to follow)</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/disbursement_per_rci') }}" class="nav-link @if($title == 'disbursementperrci') active @endif">
            <a href="#" class="nav-link @if($title == 'disbursementperrci') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Collections and Deposits(to follow)</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/index_payment') }}" class="nav-link @if($title == 'indexofpayment') active @endif">
            <a href="#" class="nav-link @if($title == 'indexofpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Disbursement(to follow)</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/index_payment') }}" class="nav-link @if($title == 'indexofpayment') active @endif">
            <a href="#" class="nav-link @if($title == 'indexofpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Unreleased Checks(to follow)</p>
            </a>
         </li>  --}} 
      </ul>   
@endhasanyrole 
@hasanyrole('Budget Officer')
   <li class="nav-item @if ($title == 'saob' || $title == 'rsperdivision' || $title == 'adacheckissued'|| $title == 'adacheckperpap' || $title == 'rsbalance' || $title=='lddapcheckissued' || $title=='rsperpap' || $title=='rsperactivity' || $title=='allotmentsummary') menu-open @endif">
      <a href="#" class="nav-link @if ($title == 'saob' || $title == 'rsperdivision' || $title == 'adacheckissued'|| $title == 'adacheckperpap' || $title == 'rsbalance' || $title=='lddapcheckissued' || $title=='rsperpap' || $title=='rsperactivity' || $title=='allotmentsummary') active @endif">
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
            <a href="{{ url('reports/ada_check_per_pap') }}" class="nav-link @if($title == 'adacheckperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>2. ADA/Check per PAP</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_balance') }}" class="nav-link @if($title == 'rsbalance') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>3. ORS/BURS Balance</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/ada_check_issued') }}" class="nav-link @if($title == 'adacheckissued') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>4. ADA/Check Issued</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_pap/1/'.date('Y-m-d').'/'.date('Y-m-d')) }}" class="nav-link @if($title == 'rsperpap') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>5. ORS/BURS per PAP</p>
            </a>
         </li> 
         <li class="nav-item">
            <a href="{{ url('reports/rs_per_activity/1/'.date('Y').'/annual') }}" class="nav-link @if($title == 'rsperactivity') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>6. ORS/BURS per Activity/LIB</p>
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
@endhasanyrole
@hasanyrole('Accounting Officer')
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
            <a href="{{ url('reports/received_dvs/') }}" class="nav-link @if($title == 'receiveddvs') active @endif">
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
         {{-- <li class="nav-item">
            <a href="{{ url('reports/dv_summary/1/'.date('Y')) }}" class="nav-link @if($title == 'dvsummary') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>3. Disbursement Summary</p>
            </a>
         </li>         --}}
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
         {{-- <li class="nav-item">
            <a href="{{ url('reports/nca_balance_per_aclass') }}" class="nav-link @if($title == 'ncabalanceperaclass') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>14. NCA Balance per Allotment Class</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/cash_disbursement') }}" class="nav-link @if($title == 'cashdisbursement') active @endif">
            <a href="#" class="nav-link @if($title == 'cashdisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>15. Cash Disbursement</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/nca_disbursement') }}" class="nav-link @if($title == 'ncadisbursement') active @endif">
            <a href="#" class="nav-link @if($title == 'ncadisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>16. Disbursement for NCA</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/disbursement_per_rci') }}" class="nav-link @if($title == 'disbursementperrci') active @endif">
            <a href="#" class="nav-link @if($title == 'disbursementperrci') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>17. Disbursement per RCI</p>
            </a>
         </li>  --}}
         <li class="nav-item">
            <a href="{{ url('reports/index_payment/0/'.date('Y')) }}" class="nav-link @if($title == 'indexpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>18. Index of Payment</p>
            </a>
         </li> 
      </ul>
   </li>  
@endhasanyrole
@hasanyrole('Cash Officer')
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
         {{-- <li class="nav-item">
            <a href="{{ url('reports/cash_disbursement') }}" class="nav-link @if($title == 'cashdisbursement') active @endif">
            <a href="#" class="nav-link @if($title == 'cashdisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Cash Disbursement(to follow)</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/nca_disbursement') }}" class="nav-link @if($title == 'ncadisbursement') active @endif">
            <a href="#" class="nav-link @if($title == 'ncadisbursement') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Cash Receipt(to follow)</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/disbursement_per_rci') }}" class="nav-link @if($title == 'disbursementperrci') active @endif">
            <a href="#" class="nav-link @if($title == 'disbursementperrci') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Collections and Deposits(to follow)</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/index_payment') }}" class="nav-link @if($title == 'indexofpayment') active @endif">
            <a href="#" class="nav-link @if($title == 'indexofpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Disbursement(to follow)</p>
            </a>
         </li>  --}}
         {{-- <li class="nav-item">
            <a href="{{ url('reports/index_payment') }}" class="nav-link @if($title == 'indexofpayment') active @endif">
            <a href="#" class="nav-link @if($title == 'indexofpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Unreleased Checks(to follow)</p>
            </a>
         </li>  --}}
         <li class="nav-item">
            <a href="{{ url('reports/index_payment/0/'.date('Y')) }}" class="nav-link @if($title == 'indexpayment') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Index of Payments</p>
            </a>
         </li> 
      </ul>
   </li>  
@endhasanyrole

@hasanyrole('Division Budget Controller|Division Director|Section Head')
{{-- <li class="nav-header">FUNDS UTILIZATION @hasanyrole('Budget Officer|Cash Officer|Accounting Officer') <br>as {{ $getUserRoleIsDivision }} @endhasanyrole</li>    --}}
<li class="nav-header">FUNDS UTILIZATION @hasanyrole('Budget Officer|Cash Officer|Accounting Officer') as DBC @endhasanyrole</li>   
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/division/ors/'.date('m').'/'.date('Y')) }}" 
         class="nav-link @if ($title == 'orsdivision') active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>ORS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/division/burs/'.date('m').'/'.date('Y')) }}" 
         class="nav-link @if ($title == 'bursdivision') active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/rs/division/burs-cfitf/'.date('m').'/'.date('Y')) }}"
         class="nav-link @if ($title == 'burscdivision') active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS-CFITF</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('funds_utilization/dv/division/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'dv') active @endif">
         <img src="{{ url('images/dv-icon.png') }}" width="25px">
         <p>Disbursement Vouchers</p>
      </a>
   </li>  
   <li class="nav-item @if ($title == 'saobdivision' || $title == 'rsbalancedivision' || $title == 'dvbydivision') menu-open @endif">
      <a href="#" class="nav-link @if ($title == 'saobdivision' || $title == 'rsbalancedivision' || $title == 'dvbydivision') active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            Reports
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         {{-- @unlessrole('Budget Officer|Accounting Officer|Cash Officer') --}}
         <li class=" nav-item">
            <a href="{{ url('reports/saob/1/'.$user_division_id.'/'.date('Y').'/annual') }}" class="nav-link @if ($title == 'saobdivision') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>1. SAOB</p>
            </a>
         </li>  
         <li class="nav-item">
            <a href="{{ url('reports/rs_balance_by_division') }}" class="nav-link @if($title == 'rsbalancedivision') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>2. ORS/BURS Balance</p>
            </a>
         </li>  
         {{-- @endunlessrole --}}
         <li class="nav-item">
            <a href="{{ url('reports/dv_by_division') }}" class="nav-link @if($title == 'dvbydivision') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>3. Disbursement Vouchers</p>
            </a>
         </li>                      
      </ul> 
   </li>
@endhasanyrole

          
