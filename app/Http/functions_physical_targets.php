<?php

use App\Models\PAMSPhysicalTargetsModel;
use App\Models\ViewPhysicalTargetsModel;
use Illuminate\Support\Facades\DB;

function getPhysicalTargets($division_id, $year){
   $data=ViewPhysicalTargetsModel::where('division_id',$division_id)->where('year',$year)
      ->where('is_active', 1)->where('is_deleted', 0)->get();     
   // dd($data);
   return $data; 
} 

// function getPhysicalTargetsByDivision($division_id, $year){
//    $data=ViewPhysicalTargetsModel::where('division_id',$division_id)->where('year',$year)
//       ->where('is_active', 1)->where('is_deleted', 0)->get();     
//    // dd($data);
//    return $data; 
// } 