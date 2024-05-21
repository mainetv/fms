 <!-- Super Administrator Side Navigation -->
<ul class="nav nav-compact nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
   <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
   <li class="nav-item">
      <a href="{{ url('') }}" class="nav-link @if ($title == 'Dashboard') active @endif">
         <i class="nav-icon fas fa-tachometer-alt"></i>
         <p>Dashboard</p>
      </a>
   </li>   
   <li class="nav-header">PCAARRD BUDGET PROPOSAL</li>
   <li class="nav-item">
      <a href="{{ url('budget_proposal/agency_proposal/'.date('Y')) }}" class="nav-link @if ($title == 'PCAARRD Budget Proposal') active @endif">
         <i class="nav-icon fas fa-building"></i>
         <p>PCAARRD Budget Proposal</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="{{ url('budget_proposal/division_proposals/'.date('Y')) }}" class="nav-link @if ($title == 'Division Budget Proposals') active @endif">
         <i class="nav-icon fas fa-building"></i>
         <p>Division Proposals</p>
      </a>
   </li>
   <li class="nav-item">
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
      <a href="{{ url('programmin_allocation/nep/quarterly_obligation_programs/'.date('Y')) }}" class="nav-link @if ($title == 'Quarterly Obligation Programs') active @endif">
         <i class="nav-icon fas fa-building"></i>
         <p>Quarterly Obligation Programs</p>
      </a>
   </li>
</ul>