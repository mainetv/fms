<?php

use App\Models\PrefixNumberModel;
use App\Models\ViewAllotmentModel;
use App\Models\ViewRSModel;
use Illuminate\Support\Facades\DB;

   function getRSbyDivision($rs_type_id, $division_id, $month_selected, $year_selected){
      $data=DB::table('view_request_status')->select('view_request_status.*', 'view_rs_pap.allotment_division_id','view_rs_pap.allotment_division_acronym')
         ->leftJoin('view_rs_pap','view_request_status.id','=','view_rs_pap.rs_id')
         ->whereMonth('view_request_status.rs_date',$month_selected)->whereYear('view_request_status.rs_date',$year_selected)
         ->where('view_request_status.rs_type_id',$rs_type_id)
         ->where('view_request_status.is_active','=',1)
         ->where('view_request_status.is_deleted','=',0)
         ->where(function ($query) use ($division_id) {
            $query->where('view_request_status.division_id',$division_id)
               ->orWhere('allotment_division_id',$division_id);
         })
         ->groupBy('id')->orderBy('rs_date', 'ASC')->orderBy('payee', 'ASC')->get();      
      // dd($data);
      return $data; 
   }

   function getAllRS($rs_type_id, $month_selected, $year_selected){
      $data=ViewRSModel::whereMonth('rs_date', $month_selected)->whereYear('rs_date', $year_selected)
         ->where('rs_type_id', $rs_type_id)->where('is_active', 1)->where('is_deleted', 0)
         ->orderBy('division_acronym', 'ASC')->orderBy('id', 'ASC')->get();   
      // dd($data);
      return $data; 
   }

   function getRSActivityAllotmentAllDivision($rs_type_id, $year_selected){
      $data= ViewAllotmentModel::where('is_active', 1)->where('is_deleted', 0)
         ->where(function ($query) use ($rs_type_id, $year_selected) {
            $query
            ->where('year', $year_selected)
            ->where('pooled_at_division_id','=','')
            ->where('rs_type_id','=', $rs_type_id);
         })
         ->orWhere(function ($query) use ($rs_type_id, $year_selected){
            $query
            ->where('year', $year_selected)
            ->where('rs_type_id','=', $rs_type_id);
         })
         ->groupBy('id')
         ->orderBy('division_acronym','asc')
         ->orderBy('pap_code','asc')
         ->orderBy('activity','asc')
         ->orderBy('object_code','asc')
         ->get();
      // dd($data);
      return $data; 
   }

   function getRSActivityAllotmentByDivision($rs_type_id, $division_id, $year_selected){
      $data= ViewAllotmentModel::where('is_active', 1)->where('is_deleted', 0)
         ->where(function ($query) use ($rs_type_id, $year_selected, $division_id) {
            $query
               ->where('year', $year_selected)
               ->where('division_id', $division_id)
               ->where('pooled_at_division_id','=','')
               ->where('rs_type_id','=', $rs_type_id);
         })
         ->orWhere(function ($query) use ($rs_type_id, $year_selected, $division_id){
            $query
            ->where('year', $year_selected)
            ->where('division_id', $division_id)
            ->where('rs_type_id','=', $rs_type_id)
            ->whereNull('pooled_at_division_id');
         })
         ->where('is_active', 1)->where('is_deleted', 0)
         ->groupBy('id')
         ->orderBy('pap_code','asc')
         ->orderBy('activity_id','asc')
         ->orderBy('subactivity_id','asc')
         ->orderBy('object_code','asc')
         ->get();
      // dd($data);
      return $data; 
   }

   function getAllotmentforRS($allotment_id){
      // $rs_type_id= ViewAllotmentModel::where('id', $allotment_id)->pluck('rs_type_id')->first();
      $data = DB::table("view_allotment")->select("view_allotment.*",
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
            AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
            AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
         DB::raw("(SELECT SUM(amount) FROM rs_pap
            LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
            WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
            AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
            AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
         DB::raw("(SELECT SUM(amount) FROM rs_pap
            LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
            WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
            AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
            AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
         DB::raw("(SELECT SUM(amount) FROM rs_pap
            LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
            WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
            AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
            AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
         
         )
         ->where('id', $allotment_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      // dd($data);
      return $data;
   }

   function getRSPrefix($rs_type_id){
      $data= PrefixNumberModel::where('request_status_type_id', $rs_type_id)->where('is_active', 1)->where('is_deleted', 0)->get();
      // dd($data);
      return $data;
   }