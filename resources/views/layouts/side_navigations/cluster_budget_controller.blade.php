
    <!-- Super Administrator Side Navigation -->
 <ul class="nav nav-compact nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
   <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
   <li class="nav-item">
      <a href="{{ url('') }}" class="nav-link @if ($title == 'Dashboard') active @endif">
         <i class="nav-icon fas fa-tachometer-alt"></i>
         <p>Dashboard</p>
      </a>
   </li>
   
   <li class="nav-header">BUDGET PREPARATION</li>  
   <li class="nav-item @if ($title == 'PCAARRD Budget Proposal' || $title == 'Division Budget Proposals') menu-open @endif" >
      <a href="#" class="nav-link @if ($title == 'PCAARRD Budget Proposal' || $title == 'Division Budget Proposals') active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            3-Year Budget Proposal
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ url('budget_proposal/cluster_proposals/'.date('Y')) }}" class="nav-link @if ($title == 'Cluster Budget Proposal') active @endif">
               <i class="fa-solid fa-circle fa-2xs"></i>
               <p>Cluster Budget Proposal</p>
            </a>
         </li>
         <li class="nav-item">
            <a href="{{ url('budget_proposal/division_proposals/'.date('Y')) }}" class="nav-link @if ($title == 'Division Budget Proposals') active @endif">
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
   <li class="nav-item @if ($title == 'Monthly Cash Program' || $title == 'Quarterly Obligation Program' || $title == 'Physical Targets') menu-open @endif" >
      <a href="#" class="nav-link @if ($title == 'Monthly Cash Program' || $title == 'Quarterly Obligation Program' || $title == 'Physical Targets') active @endif">
         <img src="{{ url('images/nep-icon.png') }}" width="24px">
         <p>
            NEP
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
         <a href="{{ url('nep/monthly_cash_programs/'.date('Y')) }}" class="nav-link @if ($title == 'Monthly Cash Program') active @endif">
            <i class="fa-solid fa-circle fa-2xs"></i>
            <p>Monthly Cash Program</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="{{ url('nep/quarterly_obligation_programs/'.date('Y')) }}" class="nav-link @if ($title == 'Quarterly Obligation Program') active @endif">
            <i class="fa-solid fa-circle fa-2xs"></i>
            <p>Quarterly Obligation Program</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="{{ url('budget_proposal/physical_targets/'.date('Y')) }}" class="nav-link @if ($title == 'Physical Targets') active @endif">
            <i class="fa-solid fa-circle fa-2xs"></i>
            <p> Physical Targets</p>
         </a>
      </li> 
      </ul>
    </li>
   
   {{-- <li class="nav-header">PROGRAMMING & ALLOCATION</li>   
   <li class="nav-item">
      <a href="{{ url('funds_utilization/ors/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'ORS') active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>ORS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="#" class="nav-link @if ($title == 'BURS') active @endif">
      <a href="{{ url('funds_utilization/burs/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'BURS') active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="#" class="nav-link @if ($title == 'BURS-CFITF') active @endif">
      <a href="{{ url('funds_utilization/burs_cfitf/'.date('m').'/'.date('Y')) }}" class="nav-link @if ($title == 'BURS-CFITF') active @endif">
         <img src="{{ url('images/rs-icon.png') }}" width="23px">
         <p>BURS-CFITF</p>
      </a>
   </li>
   <li class="nav-header">FUNDS UTILIZATION</li> --}}
</ul>

   {{-- <li class="nav-item">
      <a href="{{ url('budget_preparation/bp_forms/'.date('Y')) }}" class="nav-link @if ($title == 'BP Forms') active @endif">
         <i class="nav-icon fas fa-building"></i>
         <p>BP Forms</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('budget_proposal/physical_targets/'.date('Y')) }}" class="nav-link @if ($title == 'Physical Targets') active @endif">
         <i class="nav-icon fas fa-building"></i>
         <p> Physical Targets</p>
      </a>
   </li>  
   <li class="nav-header">NATIONAL EXPENDITURE PROGRAM</li>  
   <li class="nav-item">
      <a href="{{ url('nep/monthly_cash_programs/'.date('Y')) }}" class="nav-link @if ($title == 'Monthly Cash Programs') active @endif">
         <i class="nav-icon fas fa-building"></i>
         <p>Monthly Cash Programs</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('nep/quarterly_obligation_programs/'.date('Y')) }}" class="nav-link @if ($title == 'Quarterly Obligation Programs') active @endif">
         <i class="nav-icon fas fa-building"></i>
         <p>Quarterly Obligation Programs</p>
      </a>
   </li>    --}}