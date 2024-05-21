<li class="nav-header">BUDGET PREPARATION</li>              
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
            Other
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
                        <a href="{{ url('programming_allocation/nep/monthly_cash_programs/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Monthly Cash Program') active @endif">
                           <i class="fa-solid fa-circle fa-2xs"></i>
                           <p>Cluster</p>
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
                        <a href="{{ url('programming_allocation/nep/quarterly_obligation_programs/cluster'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Quarterly Obligation Program') active @endif">
                           <i class="fa-solid fa-circle fa-2xs"></i>
                           <p>Cluster</p>
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
                        {{-- <a href="{{ url('programming_allocation/nep/quarterly_physical_targets/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Quarterly Physical Targets') active @endif"> --}}
                        <a href="#" class="nav-link @if ($title == 'Cluster Quarterly Physical Targets') active @endif">
                           <i class="fa-solid fa-circle fa-2xs"></i>
                           <p>Cluster</p>
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
   
<li class="nav-header">FUNDS UTILIZATION</li>   
   <li class="nav-item @if ($title == 'Statement of Allotment and Obligation (SAOB)' || $title == 'Checks/ADA Payment per PAP/Account Code' || $title=='RS Balance' || $title=='ORS per Responsibility Center' ) menu-open @endif">
      <a href="#" class="nav-link @if ($title == 'Statement of Allotment and Obligation (SAOB)' || $title == 'Checks/ADA Payment per PAP/Account Code' || $title=='RS Balance' || $title=='ORS per Responsibility Center' ) active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            Reports
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ url('reports/ors_per_division') }}" class="nav-link @if($title == 'ORS per Responsibility Center') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>ORS per Responsibility Center</p>
            </a>
         </li>  
         <li class="nav-item">
            <a href="{{ url('reports/check_ada_per_pap') }}" class="nav-link @if($title == 'Checks/ADA Payment per PAP/Account Code') active @endif">
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
