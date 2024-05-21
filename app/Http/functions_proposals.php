<?php

use App\Models\BpForm3Model;
use App\Models\BudgetProposalsModel;
use App\Models\ViewBpCommentsModel;
use App\Models\ViewBpStatusModel;
use App\Models\ViewBudgetProposalsModel;

   function getBudgetProposal($division_id, $year_selected){
      $data=ViewBudgetProposalsModel::where('division_id',$division_id)->where('year',$year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->groupBY('year')->get(); 
      // dd($data);    
      return $data; 
   } 

   function getAgencyBudgetProposal($year_selected){
      $data=ViewBudgetProposalsModel::where('year',$year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->groupBY('year')->get();;     
      // dd($data);
      return $data; 
   }

   function getClusterBudgetProposal($cluster_id, $year_selected){
      $data=ViewBudgetProposalsModel::where('year',$year_selected)->where('cluster_id', $cluster_id)
         ->where('is_active', 1)->where('is_deleted', 0)->groupBY('year')->get();;     
      // dd($data);
      return $data; 
   }

   function getBudgetProposalStatus($division_id, $year_selected){
      $data = ViewBpStatusModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->get();
      // dd($data);
      return $data;
   } 
   
   function getBpCommentsbyDirector($division_id, $year_selected){
      $data = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)         
         ->where(function ($query) {
            $query->where('comment_by', 'Division Director')
               ->orWhere('comment_by', 'Section Head');
         })
         ->where('is_active',1)->where('is_deleted',0)->get();
      // dd($data);
      return $data;
   } 

   function getBpCommentsbyDirectorCount($division_id, $year_selected){
      $data = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where(function ($query) {
            $query->where('comment_by', 'Division Director')
               ->orWhere('comment_by', 'Section Head');
         })
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->count();
      // dd($data);
      return $data;
   } 
   
   function getBpCommentsbyFADBudget($division_id, $year_selected){
      $data = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('comment_by', 'FAD-Budget')->get();
      // dd($data);
      return $data;
   }  

   function getBpCommentsbyFADBudgetCount($division_id, $year_selected){
      $data = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where('comment_by', 'FAD-Budget')->count();
      // dd($data);
      return $data;
   } 

   function getBpCommentsbyBPAC($division_id, $year_selected){
      $data = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('comment_by', 'BPAC')->get();
      // dd($data);
      return $data;
   }  

   function getBpCommentsbyBPACCount($division_id, $year_selected){
      $data = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year_selected)
         ->where('is_active',1)->where('is_deleted',0)->where('is_resolved', 0)->where('comment_by', 'BPAC')->count();
      // dd($data);
      return $data;
   } 

   function getBpCompleteCount($year_selected){
      $data = ViewBpStatusModel::where('year', $year_selected)->where('status_id', 10)->where('is_active', 1)->where('is_deleted', 0)->get();
      // dd($data);
      return $data;
   } 
?>