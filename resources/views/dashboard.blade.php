@extends('layouts.app')

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  @php
    $previous_year=$current_year-1;
    $getUserDivisionID=getUserDivisionID($user_id);
    $getUserDetails=getUserDetails($user_id);
    foreach($getUserDetails as $row){
      $user_role_id = $row->user_role_id;
      $division_id = $row->division_id;
    }
  @endphp
  <section class="content">
    <div class="container-fluid">     
      <!-- Small boxes (Stat box) -->
      {{$user_role_id}}
      @if($user_role_id==3)
      @php
        $getGTORS = DB::table("view_allotment")->select("view_allotment.*",
              DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
              )
              ->where('year', $current_year)->where('rs_type_id', 1)
              ->where('is_active', 1)->where('is_deleted', 0)
              ->get();
        $getGTORSprev = DB::table("view_allotment")->select("view_allotment.*",
              DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
              )
              ->where('year', $previous_year)->where('rs_type_id', 1)
              ->where('is_active', 1)->where('is_deleted', 0)
              ->get();
          $getGTBURS = DB::table("view_allotment")->select("view_allotment.*",
              DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
                  AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
                  AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
                  AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
                  AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
              )
              ->where('rs_type_id', 2)->where('is_active', 1)->where('is_deleted', 0)
              ->get();
        foreach($getGTORS->groupBY('year') as $key=>$row){
          $q1_allotment = $row->sum('q1_allotment');
          $q2_allotment = $row->sum('q2_allotment');
          $q3_allotment = $row->sum('q3_allotment');
          $q4_allotment = $row->sum('q4_allotment');
          $q1_adjustment = $row->sum('q1_adjustment');
          $q2_adjustment = $row->sum('q2_adjustment');
          $q3_adjustment = $row->sum('q3_adjustment');
          $q4_adjustment = $row->sum('q4_adjustment');
          $q1_obligation = $row->sum('q1_obligation');
          $q2_obligation = $row->sum('q2_obligation');
          $q3_obligation = $row->sum('q3_obligation');
          $q4_obligation = $row->sum('q4_obligation');
          $allotment = $q1_allotment+$q2_allotment+$q3_allotment+$q4_allotment;
          $adjustment = $q1_adjustment+$q2_adjustment+$q3_adjustment+$q4_adjustment;
          $total_allotment = $allotment+$adjustment;
          $total_obligation = $q1_obligation+$q2_obligation+$q3_obligation+$q4_obligation;
          $utilized_budget = ($total_obligation/$total_allotment)*100;
          $total_balance = $total_allotment-$total_obligation;
        } 
        foreach($getGTORSprev->groupBY('year') as $key=>$row){
          $q1_allotment_prev = $row->sum('q1_allotment');
          $q2_allotment_prev = $row->sum('q2_allotment');
          $q3_allotment_prev = $row->sum('q3_allotment');
          $q4_allotment_prev = $row->sum('q4_allotment');
          $q1_adjustment_prev = $row->sum('q1_adjustment');
          $q2_adjustment_prev = $row->sum('q2_adjustment');
          $q3_adjustment_prev = $row->sum('q3_adjustment');
          $q4_adjustment_prev = $row->sum('q4_adjustment');
          $q1_obligation_prev = $row->sum('q1_obligation');
          $q2_obligation_prev = $row->sum('q2_obligation');
          $q3_obligation_prev = $row->sum('q3_obligation');
          $q4_obligation_prev = $row->sum('q4_obligation');
          $allotment_prev = $q1_allotment_prev+$q2_allotment_prev+$q3_allotment_prev+$q4_allotment_prev;
          $adjustment_prev = $q1_adjustment_prev+$q2_adjustment_prev+$q3_adjustment_prev+$q4_adjustment_prev;
          $total_allotment_prev = $allotment_prev+$adjustment_prev;
          $total_obligation_prev = $q1_obligation_prev+$q2_obligation_prev+$q3_obligation_prev+$q4_obligation_prev;
          $utilized_budget_prev = ($total_obligation_prev/$total_allotment_prev)*100;
          $total_balance_prev = $total_allotment_prev-$total_obligation_prev;
        }  
      @endphp
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ number_format($total_allotment ?? 0,2) }}</h3>
                <p>Fund 101 Allotment for year {{ $current_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ number_format($total_obligation ?? 0,2) }}</h3>
                <p>Fund 101 Total Obligated for year {{ $current_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ number_format($utilized_budget ?? 0,2) }}%</h3>
                <p>Fund 101 Utilized Budget for year {{ $current_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ number_format($total_balance ?? 0,2) }}</h3>
                <p>Fund 101 Allotment Balance for year {{ $current_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
        </div>
        {{-- Previious Year --}}
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ number_format($total_allotment_prev ?? 0,2) }}</h3>
                <p>Fund 101 Allotment for year {{ $previous_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ number_format($total_obligation_prev ?? 0,2) }}</h3>
                <p>Fund 101 Total Obligated for year {{ $previous_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ number_format($utilized_budget_prev ?? 0,2) }}%</h3>
                <p>Fund 101 Utilized Budget for year {{ $previous_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ number_format($total_balance_prev ?? 0,2) }}</h3>
                <p>Fund 101 Allotment Balance for year {{ $previous_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
        </div>
      @else
      @php
        $getGTORS = DB::table("view_allotment")->select("view_allotment.*",
              DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
              )
              ->where('year', $current_year)->where('rs_type_id', 1)->where('division_id', $division_id)
              ->where('is_active', 1)->where('is_deleted', 0)
              ->get();
        $getGTORSprev = DB::table("view_allotment")->select("view_allotment.*",
              DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE (rs_no<>'' and (MONTH(rs_date1) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
                  AND YEAR(rs_date1) = view_allotment.YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
              )
              ->where('year', $previous_year)->where('rs_type_id', 1)
              ->where('is_active', 1)->where('is_deleted', 0)
              ->get();
          $getGTBURS = DB::table("view_allotment")->select("view_allotment.*",
              DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
              DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
                  AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
                  AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
                  AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
                  AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
              DB::raw("(SELECT SUM(amount) FROM rs_pap
                  LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
                  WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
                  AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
                  AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
              )
              ->where('rs_type_id', 2)->where('is_active', 1)->where('is_deleted', 0)->where('division_id', $division_id)
              ->get();
        foreach($getGTORS->groupBY('year') as $key=>$row){
          $q1_allotment = $row->sum('q1_allotment');
          $q2_allotment = $row->sum('q2_allotment');
          $q3_allotment = $row->sum('q3_allotment');
          $q4_allotment = $row->sum('q4_allotment');
          $q1_adjustment = $row->sum('q1_adjustment');
          $q2_adjustment = $row->sum('q2_adjustment');
          $q3_adjustment = $row->sum('q3_adjustment');
          $q4_adjustment = $row->sum('q4_adjustment');
          $q1_obligation = $row->sum('q1_obligation');
          $q2_obligation = $row->sum('q2_obligation');
          $q3_obligation = $row->sum('q3_obligation');
          $q4_obligation = $row->sum('q4_obligation');
          $allotment = $q1_allotment+$q2_allotment+$q3_allotment+$q4_allotment;
          $adjustment = $q1_adjustment+$q2_adjustment+$q3_adjustment+$q4_adjustment;
          $total_allotment = $allotment+$adjustment;
          $total_obligation = $q1_obligation+$q2_obligation+$q3_obligation+$q4_obligation;
          $utilized_budget = ($total_obligation/$total_allotment)*100;
          $total_balance = $total_allotment-$total_obligation;
        } 
        foreach($getGTORSprev->groupBY('year') as $key=>$row){
          $q1_allotment_prev = $row->sum('q1_allotment');
          $q2_allotment_prev = $row->sum('q2_allotment');
          $q3_allotment_prev = $row->sum('q3_allotment');
          $q4_allotment_prev = $row->sum('q4_allotment');
          $q1_adjustment_prev = $row->sum('q1_adjustment');
          $q2_adjustment_prev = $row->sum('q2_adjustment');
          $q3_adjustment_prev = $row->sum('q3_adjustment');
          $q4_adjustment_prev = $row->sum('q4_adjustment');
          $q1_obligation_prev = $row->sum('q1_obligation');
          $q2_obligation_prev = $row->sum('q2_obligation');
          $q3_obligation_prev = $row->sum('q3_obligation');
          $q4_obligation_prev = $row->sum('q4_obligation');
          $allotment_prev = $q1_allotment_prev+$q2_allotment_prev+$q3_allotment_prev+$q4_allotment_prev;
          $adjustment_prev = $q1_adjustment_prev+$q2_adjustment_prev+$q3_adjustment_prev+$q4_adjustment_prev;
          $total_allotment_prev = $allotment_prev+$adjustment_prev;
          $total_obligation_prev = $q1_obligation_prev+$q2_obligation_prev+$q3_obligation_prev+$q4_obligation_prev;
          $utilized_budget_prev = ($total_obligation_prev/$total_allotment_prev)*100;
          $total_balance_prev = $total_allotment_prev-$total_obligation_prev;
        }  
      @endphp
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ number_format($total_allotment ?? 0,2) }}</h3>
                <p>Fund 101 Allotment for year {{ $current_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ number_format($total_obligation ?? 0,2) }}</h3>
                <p>Fund 101 Total Obligated for year {{ $current_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ number_format($utilized_budget ?? 0,2) }}%</h3>
                <p>Fund 101 Utilized Budget for year {{ $current_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ number_format($total_balance ?? 0,2) }}</h3>
                <p>Fund 101 Allotment Balance for year {{ $current_year }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
          </div>
          <!-- ./col -->
        </div>
      @endif
      @php
        foreach($getGTBURS->groupBY('year') as $key=>$row){
          $q1_allotment = $row->sum('q1_allotment');
          $q2_allotment = $row->sum('q2_allotment');
          $q3_allotment = $row->sum('q3_allotment');
          $q4_allotment = $row->sum('q4_allotment');
          $q1_adjustment = $row->sum('q1_adjustment');
          $q2_adjustment = $row->sum('q2_adjustment');
          $q3_adjustment = $row->sum('q3_adjustment');
          $q4_adjustment = $row->sum('q4_adjustment');
          $q1_obligation = $row->sum('q1_obligation');
          $q2_obligation = $row->sum('q2_obligation');
          $q3_obligation = $row->sum('q3_obligation');
          $q4_obligation = $row->sum('q4_obligation');
          $allotment = $q1_allotment+$q2_allotment+$q3_allotment+$q4_allotment;
          $adjustment = $q1_adjustment+$q2_adjustment+$q3_adjustment+$q4_adjustment;
          $total_allotment = $allotment+$adjustment;
          $total_obligation = $q1_obligation+$q2_obligation+$q3_obligation+$q4_obligation;
          $utilized_budget = ($total_obligation/$total_allotment)*100;
          $total_balance = $total_allotment-$total_obligation;
        }
      @endphp
      
      <!-- /.row -->
      <!-- Main row -->      
      <div class="row">
        <!-- Left col -->
        {{-- BUDGET PROPOSAL --}}
        <section class="col-md-12">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
            <div class="card-header">
              <h2 class="card-title font-weight-bold">                
                {{-- STATUS OF MONTHLY CASH PROGRAM SUBMISSION FY {{ $current_year+1 }} --}}
                STATUS OF 3-YR BUDGET PROPOSAL SUBMISSION for the Fiscal Year {{ $current_year+1 }}-{{ $current_year+3 }}
              </h2>
            </div><!-- /.card-header -->
            <div class="card-body" style="font-size:13px;">  
              <div>
                <input type="text" size="2" class="btn-xs current" disabled> = Current Status&ensp;&ensp;
                <input type="text" size="2" class="btn-xs completed" disabled> = Completed&ensp;&ensp;
              </div>        
              <div class="col table-responsive table-striped">   
                <table id="bp_status_table" class="all-bordered table-hover table-scroll" style="width: 100%;">
                  <thead class="text-center">
                    <tr>
                      <th rowspan="3" style="min-width:50px; max-width:50px;">Division</th>
                      <th colspan="4" class="color1">Budget Controller</th>   
                      <th colspan="3" class="color2">Division Director / Section Head</th>
                      <th colspan="4" class="color3">FAD-Budget</th>
                      <th colspan="3" class="color4">BPAC</th>
                    </tr>
                    <tr>
                      {{-- <th rowspan="2" class="color1" style="min-width:10px; max-width:10px;"></th> --}}
                      <th rowspan="2" class="color1" style="min-width:50px; max-width:50px;">Forwarded <br>to DD/SH</th>
                      <th colspan="3" class="color1" style="min-width:160px; max-width:160px;">Received comments from <br><sub>If with comments</sub></th>
                      <th rowspan="2" class="color2" style="min-width:50px; max-width:50px;">Received budget proposal</th>
                      <th rowspan="2" class="color2" style="min-width:50px; max-width:50px;">Returned to division<br><sub> If with comments</sub></th>
                      <th rowspan="2" class="color2" style="min-width:50px; max-width:50px;">Forwarded to FAD-Budget</th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Received signed copy of budget proposal</th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Returned to division<br><sub> If with comments</sub></th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Forwarded to BPAC</th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Approved<br><sub>Received by FAD-Budget</sub></th>
                      <th rowspan="2" class="color4" style="min-width:50px; max-width:50px;">Received budget proposal</th>
                      <th rowspan="2" class="color4" style="min-width:50px; max-width:50px;">Returned to division<br><sub> If with comments</sub></th>
                      <th rowspan="2" class="color4" style="min-width:50px; max-width:50px;">Approved<br><sub>Forwarded to FAD-Budget</sub></th>
                    </tr>
                    <tr>
                      <th class="color1" style="min-width:30px; max-width:30px;">DD/SH</th>
                      <th class="color1" style="min-width:30px; max-width:30px;">Budget</th>
                      <th class="color1" style="min-width:30px; max-width:30px;">BPAC</th>
                    </tr>
                  </thead>
                  <tbody><?php
                    $year = date("Y");
                    $sqlDivisions = getAllActiveDivisions();   
                    foreach ($sqlDivisions->where('id','!=',5)->where('id','!=',3) as $row1){
                      $division_id = $row1->id;
                      $division_acronym = $row1->division_acronym;            
                      $getBPStatus = getBPStatus($division_id, $year); 
                      $getBPStatusbyDate = getBPStatusbyDate($division_id, $year); 
                      $sqlForm3_count = getForm3Count($division_id, $year); 
                      $sqlForm4_count = getForm4Count($division_id, $year); 
                      $sqlForm5_count = getForm5Count($division_id, $year); 
                      $sqlForm6_count = getForm6Count($division_id, $year); 
                      $sqlForm7_count = getForm7Count($division_id, $year); 
                      $sqlForm8_count = getForm8Count($division_id, $year); 
                      $sqlForm9_count = getForm9Count($division_id, $year); 
                      ?>
                      <tr class="text-center">
                        <td class="text-left">{{ $division_acronym }}</td>
                        <td
                          @foreach($getBPStatus->where('status_id', 2) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current" 
                            @endif
                          @endforeach >
                          @foreach($getBPStatusbyDate->where('status_id', 2) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 2))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>                          
                        <td 
                          @foreach($getBPStatus->where('status_id', 5) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 5) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 5))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getBPStatus->where('status_id', 9) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 9) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 9))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getBPStatus->where('status_id', 13) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 13) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 13))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getBPStatus->where('status_id', 3) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 3) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 3))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getBPStatus->where('status_id', 4) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 4) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 4))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td 
                          @foreach($getBPStatus->where('status_id', 6) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 6) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 6))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getBPStatus->where('status_id', 7) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 7) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 7))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach    
                        </td>
                        <td
                          @foreach($getBPStatus->where('status_id', 8) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 8) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 8))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach   
                        </td>    
                        <td
                          @foreach($getBPStatus->where('status_id', 10) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 10) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 10))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach    
                        </td> 
                        <td
                          @foreach($getBPStatus->where('status_id', 11) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 11) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 11))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td> 
                        <td
                          @foreach($getBPStatus->where('status_id', 15) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 15) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 15))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>         
                        <td
                          @foreach($getBPStatus->where('status_id', 12) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 12) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 12))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach 
                        </td>
                        <td
                          @foreach($getBPStatus->where('status_id', 14) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getBPStatusbyDate->where('status_id', 14) as $row)
                            @if(count($getBPStatusbyDate->where('status_id', 14))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>          
                      </tr>
                      @if($division_id==7)
                        <tr class="text-center">
                          <td class="activity">-BP300</td>   
                          <td></td>    
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>        
                        </tr> 
                      @endif
                      @if($division_id==12)
                        <tr class="text-center">
                          <td class="activity">-BP205</td>  
                          <td></td>    
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>        
                        </tr> 
                      @endif
                      @if($division_id==13)
                        <tr class="text-center">
                          <td class="activity">-DPPMP</td>          
                          <td></td>          
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>        
                        </tr> 
                      @endif
                      @if($division_id==16)
                        <tr class="text-center">
                          <td class="activity">-DOST Form 3</td>   
                          <td
                            @if($sqlForm3_count<>0) class="completed"
                            @endif></td>   
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>         
                        </tr>
                        <tr class="text-center">
                          <td class="activity">-DOST Form 4</td>  
                          <td
                            @if($sqlForm4_count<>0) class="completed"
                            @endif></td>   
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>         
                        </tr>
                        <tr class="text-center">
                          <td class="activity">-DOST Form 5</td>   
                          <td
                            @if($sqlForm5_count<>0) class="completed"
                            @endif></td>  
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>         
                        </tr>
                        <tr class="text-center">
                          <td class="activity">-DOST Form 6</td> 
                          <td
                            @if($sqlForm6_count<>0) class="completed"
                            @endif></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>          
                        </tr>
                        <tr class="text-center">
                          <td class="activity">-DOST Form 9</td>  
                          <td
                            @if($sqlForm9_count<>0) class="completed"
                            @endif></td>     
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td> 
                        </tr>
                        <tr class="text-center">
                          <td class="activity">-BP202</td>      
                          <td></td>    
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td> 
                        </tr>
                      @endif
                      @if($division_id==19)
                        <tr class="text-center">
                          <td class="activity">-DOST Form 5</td> 
                          <td
                            @if($sqlForm5_count<>0) class="completed"
                            @endif></td>    
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>       
                        </tr>  
                        <tr class="text-center">
                          <td class="activity">-BP202</td>   
                          <td></td>    
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>  
                        </tr>
                      @endif
                      @if($division_id==21)
                        <tr class="text-center">
                          <td class="activity">-DOST Form 7</td>  
                          <td
                            @if($sqlForm7_count<>0) class="completed"
                            @endif></td>  
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>    
                        </tr>  
                      @endif
                      @if($division_id==20)
                        <tr class="text-center">
                          <td class="activity">-DOST Form 7</td>  
                          <td
                            @if($sqlForm7_count<>0) class="completed"
                            @endif></td>   
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>       
                        </tr>  
                        <tr class="text-center">
                          <td class="activity">-BP202A</td>     
                          <td></td>
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                        </tr>  
                      @endif
                      @if($division_id==23)
                        <tr class="text-center">
                          <td class="activity">-Physical Targets</td>  
                          <td></td>    
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>        
                        </tr>  
                        <tr class="text-center">
                          <td class="activity">-DOST Form 8</td>  
                          <td
                            @if($sqlForm8_count<>0) class="completed"
                            @endif></td> 
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                        </tr>  
                        <tr class="text-center">
                          <td class="activity">-BP201F</td>  
                          <td></td>    
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                        </tr> 
                        <tr class="text-center">
                          <td class="activity">-BP202A</td>  
                          <td></td>    
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td>      
                          <td class="gray3-bg"></td> 
                        </tr> 
                      @endif
                      <?php
                    }?>
                  </tbody>
                </table>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </section> 

        {{-- CASH PROGRAM --}}
        <section class="col-md-12">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
            <div class="card-header">
              <h2 class="card-title font-weight-bold">                
                {{-- STATUS OF MONTHLY CASH PROGRAM SUBMISSION FY {{ $current_year+1 }} --}}
                STATUS OF BPAC APPROVED MONTHLY CASH PROGRAM FY {{ $current_year+1 }}
              </h2>
            </div><!-- /.card-header -->
            <div class="card-body" style="font-size:13px;">  
              <div>
                <input type="text" size="2" class="btn-xs current" disabled> = Current Status&ensp;&ensp;
                <input type="text" size="2" class="btn-xs completed" disabled> = Completed&ensp;&ensp;
              </div>        
              <div class="col table-responsive table-striped">   
                <table id="bp_status_table" class="all-bordered table-hover table-scroll" style="width: 100%;">
                  <thead class="text-center">
                    <tr>
                      <th rowspan="3" style="min-width:50px; max-width:50px;">Division</th>
                      <th colspan="4" class="color1">Budget Controller</th>   
                      <th colspan="3" class="color2">Division Director / Section Head</th>
                      <th colspan="4" class="color3">FAD-Budget</th>
                      <th colspan="3" class="color4">BPAC</th>
                    </tr>
                    <tr>
                      {{-- <th rowspan="2" class="color1" style="min-width:80px; max-width:80px;">With input</th> --}}
                      <th rowspan="2" class="color1" style="min-width:50px; max-width:50px;">Forwarded <br>to DD/SH</th>
                      <th colspan="3" class="color1" style="min-width:160px; max-width:160px;">Received comments from <br><sub>If with comments</sub></th>
                      <th rowspan="2" class="color2" style="min-width:50px; max-width:50px;">Received cash program</th>
                      <th rowspan="2" class="color2" style="min-width:50px; max-width:50px;">Returned to division<br><sub> If with comments</sub></th>
                      <th rowspan="2" class="color2" style="min-width:50px; max-width:50px;">Forwarded to FAD-Budget</th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Received signed copy of cash program</th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Returned to division<br><sub> If with comments</sub></th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Forwarded to BPAC</th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Approved<br><sub>Received by FAD-Budget</sub></th>
                      <th rowspan="2" class="color4" style="min-width:50px; max-width:50px;">Received cash program</th>
                      <th rowspan="2" class="color4" style="min-width:50px; max-width:50px;">Returned to division<br><sub> If with comments</sub></th>
                      <th rowspan="2" class="color4" style="min-width:50px; max-width:50px;">Approved<br><sub>Forwarded to FAD-Budget</sub></th>
                    </tr>
                    <tr>
                      <th class="color1" style="min-width:30px; max-width:30px;">DD/SH</th>
                      <th class="color1" style="min-width:30px; max-width:30px;">Budget</th>
                      <th class="color1" style="min-width:30px; max-width:30px;">BPAC</th>
                    </tr>
                  </thead>
                  <tbody><?php
                    $count=0;
                    $year = date("Y");
                    $getAllActiveDivisions = getAllActiveDivisions();   
                    foreach ($getAllActiveDivisions->where('id','!=',5) as $row1){
                      $division_id = $row1->id;
                      $division_acronym = $row1->division_acronym;            
                      $getMCPStatus = getMCPStatus($division_id, $year); 
                      $getMCPStatusbyDate = getMCPStatusbyDate($division_id, $year); 
                      // dd($getMCPStatus);
                      ?>
                      <tr class="text-center">
                        <td class="text-left">{{ $division_acronym }}</td>
                        <td
                          @foreach($getMCPStatus->where('status_id', 2) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current" 
                            @endif
                          @endforeach >
                          @foreach($getMCPStatusbyDate->where('status_id', 2) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 2))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>                          
                        <td 
                          @foreach($getMCPStatus->where('status_id', 5) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 5) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 5))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getMCPStatus->where('status_id', 9) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 9) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 9))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getMCPStatus->where('status_id', 13) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 13) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 13))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getMCPStatus->where('status_id', 3) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 3) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 3))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getMCPStatus->where('status_id', 4) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 4) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 4))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td 
                          @foreach($getMCPStatus->where('status_id', 6) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 6) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 6))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getMCPStatus->where('status_id', 7) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 7) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 7))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach    
                        </td>
                        <td
                          @foreach($getMCPStatus->where('status_id', 8) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 8) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 8))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach   
                        </td>    
                        <td
                          @foreach($getMCPStatus->where('status_id', 10) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 10) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 10))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach    
                        </td> 
                        <td
                          @foreach($getMCPStatus->where('status_id', 11) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 11) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 11))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td> 
                        <td
                          @foreach($getMCPStatus->where('status_id', 15) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 15) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 15))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>         
                        <td
                          @foreach($getMCPStatus->where('status_id', 12) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 12) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 12))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach 
                        </td>
                        <td
                          @foreach($getMCPStatus->where('status_id', 14) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getMCPStatusbyDate->where('status_id', 14) as $row)
                            @if(count($getMCPStatusbyDate->where('status_id', 14))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>          
                      </tr>
                      <?php
                    }?>
                  </tbody>
                </table>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </section> 
        
        {{-- QUARTERLY PROGRAM--}}
        <section class="col-md-12">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
            <div class="card-header">
              <h2 class="card-title font-weight-bold">           
                STATUS OF BPAC APPROVED QUARTERLY OBLIGATION PROGRAM FY {{ $current_year+1 }}     
                {{-- STATUS OF QUARTERLY OBLIGATION PROGRAM SUBMISSION FY {{ $current_year+1 }} --}}
              </h2>
            </div><!-- /.card-header -->
            <div class="card-body" style="font-size:13px;">  
              <div>
                <input type="text" size="2" class="btn-xs current" disabled> = Current Status&ensp;&ensp;
                <input type="text" size="2" class="btn-xs completed" disabled> = Completed&ensp;&ensp;
              </div>        
              <div class="col table-responsive table-striped">   
                <table id="bp_status_table" class="all-bordered table-hover table-scroll" style="width: 100%;">
                  <thead class="text-center">
                    <tr>
                      <th rowspan="3" style="min-width:50px; max-width:50px;">Division</th>
                      <th colspan="4" class="color1">Budget Controller</th>   
                      <th colspan="3" class="color2">Division Director / Section Head</th>
                      <th colspan="4" class="color3">FAD-Budget</th>
                      <th colspan="3" class="color4">BPAC</th>
                    </tr>
                    <tr>
                      {{-- <th rowspan="2" class="color1" style="min-width:80px; max-width:80px;">With input</th> --}}
                      <th rowspan="2" class="color1" style="min-width:50px; max-width:50px;">Forwarded <br>to DD/SH</th>
                      <th colspan="3" class="color1" style="min-width:160px; max-width:160px;">Received comments from <br><sub>If with comments</sub></th>
                      <th rowspan="2" class="color2" style="min-width:50px; max-width:50px;">Received quarterly program</th>
                      <th rowspan="2" class="color2" style="min-width:50px; max-width:50px;">Returned to division<br><sub> If with comments</sub></th>
                      <th rowspan="2" class="color2" style="min-width:50px; max-width:50px;">Forwarded to FAD-Budget</th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Received signed copy of quarterly program</th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Returned to division<br><sub> If with comments</sub></th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Forwarded to BPAC</th>
                      <th rowspan="2" class="color3" style="min-width:50px; max-width:50px;">Approved<br><sub>Received by FAD-Budget</sub></th>
                      <th rowspan="2" class="color4" style="min-width:50px; max-width:50px;">Received quarterly program</th>
                      <th rowspan="2" class="color4" style="min-width:50px; max-width:50px;">Returned to division<br><sub> If with comments</sub></th>
                      <th rowspan="2" class="color4" style="min-width:50px; max-width:50px;">Approved<br><sub>Forwarded to FAD-Budget</sub></th>
                    </tr>
                    <tr>
                      <th class="color1" style="min-width:30px; max-width:30px;">DD/SH</th>
                      <th class="color1" style="min-width:30px; max-width:30px;">Budget</th>
                      <th class="color1" style="min-width:30px; max-width:30px;">BPAC</th>
                    </tr>
                  </thead>
                  <tbody><?php
                    $year = date("Y");
                    $getAllActiveDivisions = getAllActiveDivisions();   
                    foreach ($getAllActiveDivisions->where('id','!=',5) as $row1){
                      $division_id = $row1->id;
                      $division_acronym = $row1->division_acronym;            
                      $getQOPStatus = getQOPStatus($division_id, $year); 
                      $getQOPStatusbyDate = getQOPStatusbyDate($division_id, $year); 
                      // dd($getQOPStatus);
                      ?>
                      <tr class="text-center">
                        <td class="text-left">{{ $division_acronym }}</td>
                        <td
                          @foreach($getQOPStatus->where('status_id', 2) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current" 
                            @endif
                          @endforeach >
                          @foreach($getQOPStatusbyDate->where('status_id', 2) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 2))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>                          
                        <td 
                          @foreach($getQOPStatus->where('status_id', 5) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 5) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 5))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getQOPStatus->where('status_id', 9) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 9) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 9))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getQOPStatus->where('status_id', 13) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 13) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 13))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getQOPStatus->where('status_id', 3) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 3) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 3))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getQOPStatus->where('status_id', 4) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 4) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 4))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td 
                          @foreach($getQOPStatus->where('status_id', 6) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 6) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 6))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>
                        <td
                          @foreach($getQOPStatus->where('status_id', 7) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 7) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 7))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach    
                        </td>
                        <td
                          @foreach($getQOPStatus->where('status_id', 8) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 8) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 8))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach   
                        </td>    
                        <td
                          @foreach($getQOPStatus->where('status_id', 10) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 10) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 10))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach  
                        </td> 
                        <td
                          @foreach($getQOPStatus->where('status_id', 15) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 15) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 15))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach  
                        </td> 
                        <td
                          @foreach($getQOPStatus->where('status_id', 11) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 11) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 11))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>         
                        <td
                          @foreach($getQOPStatus->where('status_id', 12) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 12) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 12))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach 
                        </td>
                        <td
                          @foreach($getQOPStatus->where('status_id', 14) as $row)
                            @if($row->is_active==0) class="completed"
                            @elseif($row->is_active==1) class="current"
                            @endif
                          @endforeach>
                          @foreach($getQOPStatusbyDate->where('status_id', 14) as $row)
                            @if(count($getQOPStatusbyDate->where('status_id', 14))>=1)
                              {{ date_format($row->created_at,'Y-m-d') }}<br/>
                            @endif                          
                          @endforeach
                        </td>          
                      </tr>
                      <?php
                    }?>
                  </tbody>
                </table>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </section> 
      </div>
      
     
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection