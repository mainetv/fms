@extends('layouts.app')

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Notifications</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">     
      @php $notifications = getAllNotifications($user_id);   @endphp
      <div class="row">
        @foreach($notifications as $row)   
          <?php 
            $record_id = $row->record_id;                           
            $module_id = $row->module_id;                           
            $link = $row->link;                           
            $division_code = $row->division_code;                           
            $year = $row->year;                           
            if($module_id==1 || $module_id==2 || $module_id==3 || $module_id==4){
              if($user_role_id_to == 3 || $user_role_id_to == 8 || $user_role_id_to == 9 || $user_role_id_to == 10){ 
                  $link = $link.$year."#".$division_code;                              
              }
              else{
                  $link = $link.$year;   
              }
            }
            else{
              $link = $link."edit/".$record_id;    
            }
          ?>
          @php $user_role_id_to = $row->user_role_id_to; @endphp
          <div class="col-md-12">            
            <a href="" data-id="{{ $row->id }}" class="notification_has_read" data-link="{{ $link }}" >
              <div class="info-box bg-info">                
                <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                  @if ($row->is_read == 0)
                    <span class="badge badge-danger badge-primary notif_unread"> </span>
                  @elseif ($row->is_read == 1)
                  @endif
                </span>           
                <div class="info-box-content">
                  <span class="info-box-number">{{$row->user_from}} - {{ $row->division_from }} </span>
                  <span class="info-box-text">{{ $row->message }}</span>
                  <span class="progress-description">
                    {{ $row->created_at }}
                  </span>
                </div>           
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
        @endforeach
        
      </div>
            
      
    </div>
  </section>
  <!-- /.content -->
@endsection