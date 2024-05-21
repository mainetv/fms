<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
      <title>FMS</title>
      <!-- Fonts -->
      {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet"> --}}
      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Ionicons -->
      {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
      <!-- Font Awesome 6 Icons --> 
      <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-6.1.1-web/css/all.min.css') }}">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
      <link rel="stylesheet" href="{{ asset('css/custom.css') }}" media="all">
      <!-- SweetAlert2 -->
      <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
      <!-- Select2 -->
      <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">              
      <!-- iCheck -->
      <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
      <!-- bs-custom-file-input -->
      <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
      <!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

      <!-- DataTables -->
      @include('scripts.datatables_css')

      <SCRIPT LANGUAGE="JavaScript">
			function printThis()
			{
				window.print();
			}
		</script>
   </head>
   <body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer">
      <div class="wrapper">    
         <!-- Navbar -->
         <nav class="main-header navbar navbar-expand navbar-cyan navbar-light">
            <!-- Left navbar links -->
            @php $getUserDetailsHasRoles = getUserDetailsHasRoles($user_id);  @endphp
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
               </li>
               @foreach ($getUserDetailsHasRoles as $row)            
               <li class="nav-item">
                  {{-- <button onclick="load_side_menu_content(this.value)" type="button" value="{{ $row->role_id }}">As {{ $row->user_role; }}</button>                      --}}
                  {{-- <button type="button" role="button" data-user-role-id="{{ $row->role_id }}" value="{{ $row->role_id }}">As {{ $row->user_role; }}</button> --}}
                  <a href="#" class="btn_view_as nav-link" role="button" data-user-role-id="{{ $row->role_id }}">As {{ $row->user_role; }}</a>                  
                  {{-- <a class="nav-link" href="#" role="button"></a> --}}
               </li>
               @endforeach   
            </ul>
      
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
               <li class="nav-item dropdown">
                  <?php                      
                     $notifications = getNotifications($user_id);
                     foreach($notifications as $row){                                             
                        $notification_count = $notifications->count();                       
                     }                   
                  ?>
                  <a class="nav-link" data-toggle="dropdown" href="#">    
                     <i class="far fa-bell fa-lg"></i>
                     <span class="badge badge-danger navbar-badge" id='total_notification'>{{ $notification_count ?? ''; }}</span>
                  </a>         
                  <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                     <span class="dropdown-item dropdown-header">
                     {{ $notification_count ?? ''; }} Notifications </span>
                     <div id="notification_body">                       
                        @foreach($notifications->take(6) as $row) 
                           <?php 
                              $user_role_id_to = $row->user_role_id_to;
                              $record_id = $row->record_id;                        
                              $module_id = $row->module_id;                           
                              $link = $row->link;                           
                              $division_code = $row->division_code;                           
                              $year = $row->year;       
                           ?>                           
                           <a href="" data-id="{{ $row->id }}" class="dropdown-item notification_has_read" data-link="{{ $link }}">
                              <h3 class="dropdown-item-title">
                                 {{ $row->user_from }} - {{ $row->division_from }}                                                          
                              </h3>                              
                              <p class="text-sm">
                                 {{ $row->module }}<br/>
                                 <i class="fas fa-envelope mr-2"></i>{{ $row->message }}
                              </p>
                              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $row->created_at }}</p>
                           </a> 
                        @endforeach                           
                     </div>        
                     <div class="dropdown-divider"></div>      
                     <a href="#" class="dropdown-item dropdown-footer all-notifications">See All Notifications</a>
                  </div>
               </li>


               {{-- Fullscreen --}}
               <li class="nav-item">
                  <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
                  </a>
               </li>
               <!-- Navbar Logout -->
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>{{ __('Logout') }}
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                     </form>
                  </li>
               </ul>               
            </ul>
         </nav>
         <!-- /.navbar -->
      
         <!-- Main Sidebar Container -->
         <aside class="main-sidebar sidebar-dark-cyan elevation-4 nav-child-indent">
            <!-- Brand Logo -->
            <a href="/fms/public" class="brand-link">
               <img src="{{ asset('/images/pcarrd-logo-sm.png') }}" alt="FMS" class="brand-image img-circle elevation-3" style="opacity: .8">
               <span class="brand-text font-weight-light-bold">FMS</span>
            </a>
      
            <!-- Sidebar -->
            <div class="sidebar">
               <!-- Sidebar user panel (optional) -->
               <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                  <div class="image">
                  <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                  </div>
                  <div class="info">
                     @php
                        $user_details = getUserDetails($user_id);                     
                        $getUserRoleNotDivision = getUserRoleNotDivision($user_id);                    
                        foreach ($user_details as $row){ 
                           $user_fullname = $row->fullname_first;
                        }
                     @endphp
                     <a class="d-block font-weight-bold">{{ $user_fullname }}</a>   
                     {{-- @foreach ($user_details as $row)                        
                        <i><a href="#" class="btn_view_as" data-user-role-id="{{ $row->role_id }}">as {{ $row->user_role; }}</a></i><br>
                     @endforeach           --}}
                  </div>
               </div>
               <!-- Sidebar Menu --> 
               <nav class="mt-2">
                  <ul id="side_menu_content_nav" class="nav nav-compact nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">                     
                     <li class="nav-item">
                        <a href="{{ url('') }}" class="nav-link @if ($title == 'Dashboard') active @endif">
                           <i class="nav-icon fas fa-tachometer-alt"></i>
                           <p>Dashboard</p>
                        </a>
                     </li>   
                     
                     {{-- @yield('side_menu_content')  --}}
                     @include('layouts.side_navigations.side_menu_content')
                     {{-- @show                       --}}
                        {{-- @if($user_role_id==0)                     
                           @include('layouts.side_navigations.super_admin')    
                        @elseif($user_role_id==1) 
                           @include('layouts.side_navigations.admin')    
                        @elseif($user_role_id==3)
                           @include('layouts.side_navigations.budget')  
                           @elseif($user_role_id==2)
                           @include('layouts.side_navigations.accounting')    
                        @elseif($user_role_id==4)
                           @include('layouts.side_navigations.cash')    
                        @elseif($user_role_id==10)
                           @include('layouts.side_navigations.executive_director')    
                        @elseif($user_role_id==9)
                           @include('layouts.side_navigations.bpac')    
                        @elseif($user_role_id==5)
                           @include('layouts.side_navigations.cluster_budget_controller')    
                        @elseif($user_role_id==6)
                           @include('layouts.side_navigations.division_director')    
                        @elseif($user_role_id==11)
                           @include('layouts.side_navigations.section_head')    
                        @elseif($user_role_id==7)
                           @include('layouts.side_navigations.division_budget_controller')  
                        @endif     --}}
                        {{-- @yield('side_menu_content', View::make('layouts.side_navigations.division_budget_controller', ['title' => $title,'user_id'=>$user_id, 'user_role_id'=>7])) --}}
                                                   
                     {{-- @show                  --}}
                     {{-- @role('Budget Officer')
                        @include('layouts.side_navigations.budget')
                     @endrole
                     @role('Accounting Officer')
                        @include('layouts.side_navigations.accounting')
                     @endrole
                     @role('Cash Officer')
                        @include('layouts.side_navigations.cash')
                     @endrole
                     @role('Division Budget Controller')
                        @include('layouts.side_navigations.division_budget_controller')
                     @endrole --}}
                  </ul>
                  <br>
               </nav>
               <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
         </aside>
      
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->         
            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
      
         <!-- Control Sidebar -->
         <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
         </aside>
         <!-- /.control-sidebar -->
      
         <!-- Main Footer -->
         <footer class="main-footer text-sm noprint">
            <strong>Copyright &copy; 2022 <a href="/fms/public">FMS</a>.</strong>All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
               <b>Version</b> 1.0
            </div>
         </footer>
      </div>
      <!-- ./wrapper --> 
      
      <!-- REQUIRED SCRIPTS -->      
      <!-- jQuery -->
      <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>      
      <!-- jQuery UI 1.11.4 -->
      <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
         $.widget.bridge('uibutton', $.ui.button)
      </script>
      <!-- Bootstrap 4 -->
      <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <!-- ChartJS -->
      <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
      <!-- Sparkline -->
      <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
      <!-- JQVMap -->
      <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
      <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
      <!-- jQuery Knob Chart -->
      <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
      <!-- daterangepicker -->
      <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
      <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
      <!-- Tempusdominus Bootstrap 4 -->
      <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
      <!-- Summernote -->
      <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
      <!-- overlayScrollbars -->
      <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
      <!-- AdminLTE App -->
      <script src="{{ asset('dist/js/adminlte.js') }}"></script>
      <!-- SweetAlert2 -->
      <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
      <!-- Select2 -->
      <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
      <!-- iCheck -->
      <script src="{{ asset('plugins/icheck-bootstrap/icheck.js') }}" ></script>   
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js" ></script> 
      <!-- DataTables  & Plugins -->      
      @include('scripts.datatables_js')      

      <script type="text/javascript">   
         $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')               
            }
         });     

         $(".datepicker").datepicker({
            todayHighlight: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',	
         });
         
         $('[data-toggle="tooltip"]').tooltip()
         
         $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
               theme: 'bootstrap4'
            })
     

            $(document).on('select2:open', () => {
               document.querySelector(".select2-container--open .select2-search__field").focus()
            });
            
         });  

         function RemoveRougeChar(convertString){            
            if(convertString.substring(0,1) == ","){               
               return convertString.substring(1, convertString.length)  
            }
            return convertString;            
         } 

         function commaSeparateNumber(val){
            val = val.toString().replace(/,/g, ''); //remove existing commas first
            var valRZ = val.replace(/^0+/, ''); //remove leading zeros, optional
            var valSplit = valRZ.split('.'); //then separate decimals
               
            while (/(\d+)(\d{3})/.test(valSplit[0].toString())){
               valSplit[0] = valSplit[0].toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            
            if(valSplit.length == 2){ //if there were decimals
               val = valSplit[0] + "." + valSplit[1]; //add decimals back
            }else{
               val = valSplit[0]; }
            
            return val;
         }

         $(document).ready(function() {   
            @include('scripts.common_script')
         
            $('input.amount').keyup(function(event) {

               // skip for arrow keys
               if(event.which >= 37 && event.which <= 40){
               event.preventDefault();
               }

               $(this).val(function(index, value) {
               return value
                  .replace(/\D/g, "")
                  .replace(/([0-9])([0-9]{2})$/, '$1.$2')  
                  .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",")
               ;
               });
            });
         }); 
      </script>
      @yield('jscript')      
   </body>
</html>
