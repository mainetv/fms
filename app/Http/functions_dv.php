<?php

use App\Models\ViewDVModel;
use App\Models\ViewRSModel;
use Illuminate\Support\Facades\DB;

   function getDVbyDivision($division_id, $month_selected, $year_selected){
      $data=ViewDVModel::where('division_id', $division_id)->whereMonth('dv_date', $month_selected)->whereYear('dv_date', $year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_date', 'ASC')->orderBy('payee', 'ASC')->get();   
      // dd($data);
      return $data; 
   }

   function getDVbyMonthYear($month_selected, $year_selected){
      $data=ViewDVModel::whereMonth('dv_date', $month_selected)->whereYear('dv_date', $year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->orderBy('dv_date', 'ASC')->orderBy('payee', 'ASC')->get();   
      // dd($data);
      return $data; 
   }

   function getDVbyDate($date_selected){
      $data=ViewDVModel::where('dv_date', $date_selected)->where('is_active', 1)->where('is_deleted', 0)
         ->orderByRaw('CAST(dv_no AS UNSIGNED) asc, dv_no asc')->get();   
      // dd($data);
      return $data; 
   }

   function getTotalDvAmountbyDV($dv_id){
      $data = DB::table('view_dv_rs')->select(DB::raw("SUM(dv_amount) as 'total_dv_amount' "))
         ->where('dv_id', $dv_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('total_dv_amount')->first();
      return $data; 
   }

   function getORSbyDivisionbyPayee($division_id, $payee_id){
      $data=ViewRSModel::where('division_id', $division_id)->where('payee_id', $payee_id)
         ->where('is_active', 1)->where('is_deleted', 0)->orderBy('rs_date', 'ASC')->get();   
      // dd($data);
      return $data; 
   }