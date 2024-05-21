
@hasanyrole('Super Administrator|Administrator')  
                        <li class="nav-header">ADMINISTRATION</li> 
                        <li class="nav-item">
                           <a href="{{ url('administration')}}" class="nav-link @if ($title == 'Administration') active @endif">
                              <img src="{{ url('images/forms-icon.png') }}" width="24px">
                              <p>Administration</p>
                           </a>
                        </li> 
                        <li class="nav-item">
                           <a href="{{ url('libraries')}}" class="nav-link @if ($title == 'Libraries') active @endif">
                              <img src="{{ url('images/forms-icon.png') }}" width="24px">
                              <p>Libraries</p>
                           </a>
                        </li> 
                     @endhasanyrole 
                     @unlessrole('Accounting Officer|Cash Officer')                  
                        <li class="nav-header">BUDGET PREPARATION</li>  
                        @hasrole('Budget Officer|Super Administrator')  
                           <li class="nav-item">
                              <a href="{{ url('budget/maintenance/')}}" class="nav-link @if ($title == 'Maintenance') active @endif">
                                 <img src="{{ url('images/forms-icon.png') }}" width="24px">
                                 <p>Call for Budget Proposal</p>
                              </a>
                           </li> 
                        @endhasrole 
                        @hasanyrole('Budget Officer|Executive Director|BPAC|BPAC Chair|Cluster Budget Controller|Super Administrator|Administrator')   
                           <li class="nav-item @if ($title == 'PCAARRD Budget Proposal' || $title == 'Agency Budget Proposal by PAP/Expenditure' || $title == 'Agency Budget Proposal by PAP/Activity' || $title == 'Division Budget Proposals' || $title == 'Cluster Budget Proposals' || $title == 'Cluster Budget Proposal') menu-open @endif" >
                              <a href="#" class="nav-link @if ($title == 'PCAARRD Budget Proposal' || $title == 'Agency Budget Proposal by PAP/Expenditure' || $title == 'Agency Budget Proposal by PAP/Activity' || $title == 'Division Budget Proposals' || $title == 'Cluster Budget Proposals' || $title == 'Cluster Budget Proposal') active @endif">
                                 <img src="{{ url('images/nep-icon.png') }}" width="24px">
                                 <p>
                                    3-Year Budget Proposal
                                    <i class="right fas fa-angle-left"></i>
                                 </p>
                              </a>
                              <ul class="nav nav-treeview">
                                 @hasanyrole('Budget Officer|Executive Director|BPAC|BPAC Chair|Super Administrator|Administrator')
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
                                 @endhasanyrole
                                 @hasanyrole('Cluster Budget Controller')
                                    <li class="nav-item">
                                       <a href="{{ url('budget_preparation/budget_proposals/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Budget Proposal') active @endif">
                                          <i class="fa-solid fa-circle fa-2xs"></i>
                                          <p>Cluster</p>
                                       </a>
                                    </li>
                                    <li class="nav-item">
                                       <a href="{{ url('budget_preparation/budget_proposals/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Division Budget Proposals') active @endif">
                                          <i class="fa-solid fa-circle fa-2xs"></i>
                                          <p>Divisions</p>
                                       </a>
                                    </li>
                                 @endhasanyrole                               
                              </ul>
                           </li>   
                        @endhasanyrole                     
                        
                        @hasanyrole('Division Budget Controller|Division Director|Section Head')                        
                           <li class="nav-item">
                              <a href="{{ url('budget_preparation/budget_proposals/division/'.date('Y')) }}" class="nav-link @if ($title == 'Division Budget Proposal') active @endif">
                                 <img src="{{ url('images/proposal-icon.png') }}" width="24px">
                                 <p>3-Year Division Proposal</p>
                              </a>
                           </li>    
                        @endhasanyrole                     

                        <li class="nav-item">
                           <a href="{{ url('budget_preparation/bp_forms/'.date('Y')) }}" class="nav-link @if ($title == 'BP Forms') active @endif">
                              <img src="{{ url('images/forms-icon.png') }}" width="24px">
                              <p>BP Forms</p>
                           </a>
                        </li>   
                        {{-- <li class="nav-item">
                           <a href="#" class="nav-link @if ($title == 'DPPMP') active @endif">
                              <img src="{{ url('images/procurement-icon.png') }}" width="24px">
                              <p>DPPMP</p>
                           </a>
                        </li>   --}}

                        @hasanyrole('Budget Officer|FAD Director|Executive Director|BPAC|BPAC Chair|Cluster Budget Controller|Super Administrator|Administrator')   
                           <li class="nav-item @if ($title == 'PCAARRD Physical Targets' || $title == 'Physical Targets' || $title == 'Cluster Physical Targets') menu-open @endif" >
                              <a href="#" class="nav-link @if ($title == 'PCAARRD Physical Targets' || $title == 'Physical Targets' || $title == 'Cluster Physical Targets') active @endif">
                                 <img src="{{ url('images/targets-icon.png') }}" width="24px">
                                 <p>
                                    Physical Targets
                                    <i class="right fas fa-angle-left"></i>
                                 </p>
                              </a>
                              <ul class="nav nav-treeview">
                                 {{-- @hasanyrole('Budget Officer|FAD Director|Executive Director|BPAC|BPAC Chair')
                                 <li class="nav-item">
                                    <a href="{{ url('budget_preparation/physical_targets/agency/'.date('Y')) }}" class="nav-link @if ($title == 'PCAARRD Physical Targets') active @endif">
                                       <i class="fa-solid fa-circle fa-2xs"></i>
                                       <p>PCAARRD</p>
                                    </a>
                                 </li>   
                                 @endhasanyrole                           
                                 @hasanyrole('Cluster Budget Controller|Budget|FAD Director|Executive Director|BPAC|BPAC Chair')
                                 <li class="nav-item">
                                    <a href="{{ url('budget_preparation/physical_targets/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Physical Targets') active @endif">
                                       <i class="fa-solid fa-circle fa-2xs"></i>
                                       <p>Cluster</p>
                                    </a>
                                 </li>
                                 @endhasanyrole                               --}}
                                 <li class="nav-item">
                                    <a href="{{ url('budget_preparation/physical_targets/division/'.date('Y')) }}" class="nav-link @if ($title == 'Physical Targets') active @endif">
                                       <i class="fa-solid fa-circle fa-2xs"></i>
                                       <p>Divisions</p>
                                    </a>
                                 </li> 
                              </ul>
                           </li>   
                        @endhasanyrole

                        @hasanyrole('Division Budget Controller|Division Director|Section Head')
                           @unlessrole('Budget Officer')
                           <li class="nav-item">
                              <a href="{{ url('budget_preparation/physical_targets/division/'.date('Y')) }}" class="nav-link @if ($title == 'Physical Targets') active @endif">
                                 <img src="{{ url('images/targets-icon.png') }}" width="24px">
                                 <p> Physical Targets</p>
                              </a>
                           </li>  
                           @endunlessrole 
                        @endhasanyrole
                     @endunlessrole                     
                     <li class="nav-header">PROGRAMMING & ALLOCATION</li>  
                     @hasanyrole('Budget Officer|FAD Director|Super Administrator|Administrator|BPAC|BPAC Chair')
                        <li class="nav-item">
                           <a href="{{ url('programming_allocation/approved_budget/divisions/'.date('Y')) }}" class="nav-link @if ($title == 'Approved Budget') active @endif">
                              <img src="{{ url('images/allotment-icon.png') }}" width="24px">
                              <p>Approved Budget</p>
                           </a>
                        </li> 
                     @endhasanyrole
                     @unlessrole('Accounting Officer|Cash Officer')
                        <li class="nav-item menu-close @if ($title == 'Monthly Cash Program' || $title == 'Monthly Cash Programs' || $title == 'Cluster Monthly Cash Program' || $title == 'Agency Monthly Cash Program' || $title == 'Quarterly Obligation Programs' || $title == 'Cluster Quarterly Obligation Program' || $title == 'Agency Quarterly Obligation Program' || $title == 'Quarterly Physical Targets') menu-open @endif" >
                           <a href="#" class="nav-link @if ($title == 'Monthly Cash Program' || $title == 'Monthly Cash Programs' || $title == 'Cluster Monthly Cash Program' || $title == 'Agency Monthly Cash Program' || $title == 'Quarterly Obligation Programs' || $title == 'Cluster Quarterly Obligation Program' || $title == 'Agency Quarterly Obligation Program' || $title == 'Quarterly Physical Targets') active @endif">
                              <img src="{{ url('images/nep-icon.png') }}" width="24px">
                              <p>
                                 NEP
                                 <i class="right fas fa-angle-left"></i>
                              </p>
                           </a>
                           <ul class="nav nav-treeview">  
                              @hasanyrole('Budget Officer|FAD-Director|Executive Director|BPAC|BPAC Chair|Cluster Budget Controller|Super Administrator|Administrator') 
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
                                       @hasanyrole('Budget Officer|FAD-Director|Executive Director|BPAC|BPAC Chair|Super Administrator|Administrator') 
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
                                       @endhasanyrole
                                       @hasanyrole('Cluster Budget Controller')                                   
                                          <li class="nav-item">
                                             <a href="{{ url('programming_allocation/nep/monthly_cash_programs/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Monthly Cash Program') active @endif">
                                                <i class="fa-solid fa-circle fa-2xs"></i>
                                                <p>Cluster</p>
                                             </a>
                                          </li>
                                       @endhasanyrole
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
                                       @hasanyrole('Budget Officer|FAD-Director|Executive Director|BPAC|BPAC Chair|Super Administrator|Administrator') 
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
                                       @endhasanyrole
                                       @hasanyrole('Cluster Budget Controller')                                   
                                          <li class="nav-item">
                                             <a href="{{ url('programming_allocation/nep/quarterly_obligation_programs/cluster'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Quarterly Obligation Program') active @endif">
                                                <i class="fa-solid fa-circle fa-2xs"></i>
                                                <p>Cluster</p>
                                             </a>
                                          </li>
                                       @endhasanyrole
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
                                       @hasanyrole('Budget Officer|FAD-Director|Executive Director|BPAC|BPAC Chair|Super Administrator|Administrator') 
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
                                       @endhasanyrole
                                       @hasanyrole('Cluster Budget Controller')                                   
                                          <li class="nav-item">
                                             {{-- <a href="{{ url('programming_allocation/nep/quarterly_physical_targets/cluster/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Quarterly Physical Targets') active @endif"> --}}
                                             <a href="#" class="nav-link @if ($title == 'Cluster Quarterly Physical Targets') active @endif">
                                                <i class="fa-solid fa-circle fa-2xs"></i>
                                                <p>Cluster</p>
                                             </a>
                                          </li>
                                       @endhasanyrole
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
                              @endhasanyrole

                              @hasanyrole('Division Budget Controller|Division Director|Section Head')
                              @unlessrole('Budget Officer')
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
                              @endunlessrole
                              @endhasanyrole
                           </ul>
                        </li> 
                        @hasanyrole('Budget Officer|FAD Director|Super Administrator|Administrator')
                           <li class="nav-item">
                              <a href="{{ url('programming_allocation/allotment/1/'.date('Y').'/annual') }}" class="nav-link @if ($title == 'Allotment') active @endif">
                                 <img src="{{ url('images/allotment-icon.png') }}" width="24px">
                                 <p>Allotment</p>
                              </a>
                           </li> 
                        @endhasanyrole     
                     @endunlessrole     
                     @hasanyrole('Accounting Officer|Cash Officer')
                        <li class="nav-item">
                           <a href="{{ url('programming_allocation/nca/'.date('Y')) }}" class="nav-link @if ($title == 'NCA') active @endif">
                              <img src="{{ url('images/allotment-icon.png') }}" width="24px">
                              <p>NCA</p>
                           </a>
                        </li> 
                     @endhasanyrole           
                     
                     <li class="nav-header">FUNDS UTILIZATION</li>                       
                     @hasanyrole('Super Administrator|Administrator|Division Director|Section Head|Budget Officer')
                        <li class="nav-item">
                           {{-- <a href="{{ url('funds_utilization/rs/ors/'.date('m').'/'.date('Y')) }}"  --}}
                           <a href="{{ url('funds_utilization/rs/ors') }}" 
                              class="nav-link @if ($title == 'Obligation Request and Status (ORS)' || $title == 'Edit Obligation Request and Status' || $title == 'Add Obligation Request and Status')) active @endif">
                              <img src="{{ url('images/rs-icon.png') }}" width="23px">
                              <p>ORS</p>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ url('funds_utilization/rs/burs') }}" 
                              class="nav-link @if ($title == 'Budget Utilization Request and Status (BURS)' || $title == 'Edit Budget Utilization Request and Status' || $title == 'Add Budget Utilization Request and Status')) active @endif">
                              <img src="{{ url('images/rs-icon.png') }}" width="23px">
                              <p>BURS</p>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ url('funds_utilization/rs/burs_cfitf') }}"
                              class="nav-link @if ($title == 'Budget Utilization Request and Status - Coconut Trust Fund (BURS-CFITF)' || $title == 'Edit Budget Utilization Request and Status - Coconut Trust Fund' || $title == 'Add Budget Utilization Request and Status - Coconut Trust Fund')) active @endif">
                              <img src="{{ url('images/rs-icon.png') }}" width="23px">
                              <p>BURS-CFITF</p>
                           </a>
                        </li>
                     @endhasanyrole
                     @hasanyrole('Super Administrator|Administrator|Division Budget Controller')
                        <li class="nav-item">
                           {{-- <a href="{{ url('funds_utilization/rs/ors/'.date('m').'/'.date('Y')) }}"  --}}
                           <a href="{{ url('funds_utilization/rs/ors') }}" 
                              class="nav-link @if ($title == 'Obligation Request and Status (ORS)' || $title == 'Edit Obligation Request and Status' || $title == 'Add Obligation Request and Status')) active @endif">
                              <img src="{{ url('images/rs-icon.png') }}" width="23px">
                              <p>ORS</p>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ url('funds_utilization/rs/burs') }}" 
                              class="nav-link @if ($title == 'Budget Utilization Request and Status (BURS)' || $title == 'Edit Budget Utilization Request and Status' || $title == 'Add Budget Utilization Request and Status')) active @endif">
                              <img src="{{ url('images/rs-icon.png') }}" width="23px">
                              <p>BURS</p>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ url('funds_utilization/rs/burs_cfitf') }}"
                              class="nav-link @if ($title == 'Budget Utilization Request and Status - Coconut Trust Fund (BURS-CFITF)' || $title == 'Edit Budget Utilization Request and Status - Coconut Trust Fund' || $title == 'Add Budget Utilization Request and Status - Coconut Trust Fund')) active @endif">
                              <img src="{{ url('images/rs-icon.png') }}" width="23px">
                              <p>BURS-CFITF</p>
                           </a>
                        </li>
                     @endhasanyrole
                     @hasanyrole('Super Administrator|Administrator|Division Budget Controller|Division Director|Section Head|Cash Officer')
                        <li class="nav-item">
                           <a href="{{ url('funds_utilization/dv/division') }}" class="nav-link @if ($title == 'Disbursement Voucher (DV)' || $title == 'Edit Disbursement Voucher' || $title == 'Add Disbursement Voucher') active @endif">
                              <img src="{{ url('images/dv-icon.png') }}" width="25px">
                              <p>Disbursement Vouchers</p>
                           </a>
                        </li>
                     @endhasanyrole
                     @hasanyrole('Accounting Officer')
                        <li class="nav-item">
                           <a href="{{ url('funds_utilization/dv/all') }}" class="nav-link @if ($title == 'Disbursement Voucher (DV)' || $title == 'Edit Disbursement Voucher' || $title == 'Add Disbursement Voucher') active @endif">
                              <img src="{{ url('images/dv-icon.png') }}" width="25px">
                              <p>Disbursement Vouchers</p>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ url('funds_utilization/lddap') }}" class="nav-link @if ($title == 'List of Due and Demandable Accounts Payable (LDDAP)' || $title == 'Edit LDDAP') active @endif">
                              <img src="{{ url('images/lddap-icon.png') }}" width="23px">
                              <p>LDDAP</p>
                           </a>
                        </li>
                     @endhasanyrole 
                     @hasanyrole('Cash Officer')
                        <li class="nav-item">
                           <a href="{{ url('funds_utilization/ada/1/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'Advice to Debit Accounts (ADA)' || $title == 'Add ADA' || $title == 'Edit ADA') active @endif">
                              <img src="{{ url('images/ada-icon.png') }}" width="23px">
                              <p>ADA</p>
                           </a>
                        </li>                         
                        <li class="nav-item">
                           <a href="{{ url('funds_utilization/checks/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'Checks' || $title == 'Add Check' || $title == 'Edit Check') active @endif">
                              <img src="{{ url('images/ada-icon.png') }}" width="23px">
                              <p>Checks</p>
                           </a>
                        </li>  
                     @endhasanyrole   
                     @hasanyrole('Budget Officer')
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
                     @endhasanyrole       