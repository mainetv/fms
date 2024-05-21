<?php

use App\Models\ViewAbStatusModel;
use App\Models\ViewApprovedBudgetModel;
use App\Models\ViewCashProgramsModel;
use App\Models\ViewCpCommentsModel;
use App\Models\ViewCpStatusModel;
use App\Models\ViewObligationProgramsModel;
use App\Models\ViewQopCommentsModel;
use App\Models\ViewQopStatusModel;
use Illuminate\Support\Facades\DB;

   function getApprovedBudget($division_id, $year_selected){
      $data=ViewApprovedBudgetModel::where('division_id',$division_id)->where('year',$year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   }  

   function getApprovedBudgetStatus($division_id, $year_selected){
      $data = ViewAbStatusModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->get();
      // dd($data);
      return $data;
   }   

   function getMonthlyCashProgram($division_id, $year_selected){
      $data=ViewCashProgramsModel::where('division_id',$division_id)->where('year',$year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   }  

   function getCashProgramStatus($division_id, $year_selected){
      $data = ViewCpStatusModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->get();
      // dd($data);
      return $data;
   }   

   function getCpCommentsbyDirector($division_id, $year_selected){
      $data = ViewCpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)
         ->where(function ($query) {
            $query->where('comment_by','=',6)
               ->orWhere('comment_by','=',11);
         })->get();
      // dd($division_id);
      return $data;
   } 

   function getCpCommentsbyDirectorCount($division_id, $year_selected){
      $data = ViewCpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)
         ->where(function ($query) {
            $query->where('comment_by',6)
               ->orWhere('comment_by',11);
         })->count();
      return $data;
   } 
   
   function getCpCommentsbyFADBudget($division_id, $year_selected){
      $data = ViewCpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where('comment_by', 3)->get();
      // dd($data);
      return $data;
   } 

   function getCpCommentsbyFADBudgetCount($division_id, $year_selected){
      $data = ViewCpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where('comment_by', 3)->count();
      // dd($data);
      return $data;
   } 

   function getCpCommentsbyBPAC($division_id, $year_selected){
      $data = ViewCpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('comment_by', 9)->get();
      // dd($data);
      return $data;
   } 
   
   function getCpCommentsbyBPACCount($division_id, $year_selected){
      $data = ViewCpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where('comment_by', 9)->count();
      // dd($data);
      return $data;
   } 

   function getQuarterlyObligationProgram($division_id, $year_selected){
      $data=ViewObligationProgramsModel::where('division_id',$division_id)->where('year',$year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   }  

   function getQuarterlyObligationProgramStatus($division_id, $year_selected){
      $data = ViewQopStatusModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->get();
      // dd($data);
      return $data;
   } 
   
   function getQopCommentsbyDirector($division_id, $year_selected){
      $data = ViewQopCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where(function ($query) {
            $query->where('comment_by',6)
               ->orWhere('comment_by',11);
         })->get();
      // dd($division_id);
      return $data;
   } 
   
   function getQopCommentsbyDirectorCount($division_id, $year_selected){
      $data = ViewQopCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where(function ($query) {
            $query->where('comment_by',6)
               ->orWhere('comment_by',11);
         })->count();
      // dd($data);
      return $data;
   } 
   
   function getQopCommentsbyFADBudget($division_id, $year_selected){
      $data = ViewQopCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where('comment_by', 3)->get();
      // dd($data);
      return $data;
   } 
   
   function getQopCommentsbyFADBudgetCount($division_id, $year_selected){
      $data = ViewQopCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where('comment_by', 3)->count();
      // dd($data);
      return $data;
   } 

   function getQopCommentsbyBPAC($division_id, $year_selected){
      $data = ViewQopCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('comment_by', 9)->get();
      // dd($data);
      return $data;
   } 
   
   function getQopCommentsbyBPACCount($division_id, $year_selected){
      $data = ViewQopCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where('comment_by', 9)->count();
      // dd($data);
      return $data;
   } 
?>