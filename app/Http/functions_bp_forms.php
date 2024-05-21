<?php

use App\Models\BpForm205Model;
use App\Models\BpForm3Model;
use App\Models\BpForm4Model;
use App\Models\BpForm5Model;
use App\Models\BpForm6Model;
use App\Models\BpForm7Model;
use App\Models\BpForm8Model;
use App\Models\BpForm9Model;
use App\Models\RetirementLawModel;
use App\Models\ViewUsersRetireeModel;
use Illuminate\Support\Facades\DB;

   function getBpForm3byDivisionbyFYbyTier($division_id, $year_selected, $tier, $fiscal_year){
      $data=BpForm3Model::where('division_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('tier',$tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm4byDivisionbyFYbyTier($division_id, $year_selected, $tier, $fiscal_year){
      $data=BpForm4Model::where('division_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('tier',$tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm5byDivisionbyFYbyTier($division_id, $year_selected, $tier, $fiscal_year){
      $data=BpForm5Model::where('division_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
      ->where('tier',$tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm6byDivisionbyFYbyTier($division_id, $year_selected, $tier, $fiscal_year){
      $data=BpForm6Model::where('division_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('tier',$tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm7byDivisionbyFY($division_id, $year_selected, $fiscal_year){
      $data=DB::table('view_bp_form7')->where('division_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm8byDivisionbyFY($division_id, $year_selected, $fiscal_year){
      $data=BpForm8Model::where('division_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm9byDivisionbyFY($division_id, $year_selected, $fiscal_year){
      $data=BpForm9Model::where('division_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm205byDivisionbyFY($division_id, $year_selected, $fiscal_year){
      $data=DB::table('view_bp_form205')->where('division_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 

   function getBpForm3byClusterbyFYbyTier($division_id, $year_selected, $tier, $fiscal_year){
      $data=DB::table('view_bp_form3')->where('cluster_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('tier',$tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm4byClusterbyFYbyTier($division_id, $year_selected, $tier, $fiscal_year){
      $data=DB::table('view_bp_form4')->where('cluster_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('tier',$tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm5byClusterbyFYbyTier($division_id, $year_selected, $tier, $fiscal_year){
      $data=DB::table('view_bp_form5')->where('cluster_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('tier',$tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm6byClusterbyFYbyTier($division_id, $year_selected, $tier, $fiscal_year){
      $data=DB::table('view_bp_form6')->where('cluster_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('tier',$tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm7byClusterbyFY($division_id, $year_selected, $fiscal_year){
      $data=DB::table('view_bp_form7')->where('cluster_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm8byClusterbyFY($division_id, $year_selected, $fiscal_year){
      $data=DB::table('view_bp_form8')->where('cluster_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm9byClusterbyFY($division_id, $year_selected, $fiscal_year){
      $data=DB::table('view_bp_form9')->where('cluster_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm205byClusterbyFY($division_id, $year_selected, $fiscal_year){
      $data=DB::table('view_bp_form205')->where('cluster_id',$division_id)->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 

   function getBpForm3byFYbyTier($year_selected, $tier, $fiscal_year){
      $data=BpForm3Model::where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('tier', $tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm4byFYbyTier($year_selected, $tier, $fiscal_year){
      $data=BpForm4Model::where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('tier', $tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm5byFYbyTier($year_selected, $tier, $fiscal_year){
      $data=BpForm5Model::where('year',$year_selected)->where('fiscal_year',$fiscal_year)
      ->where('tier', $tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm6byFYbyTier($year_selected, $tier, $fiscal_year){
      $data=BpForm6Model::where('year',$year_selected)->where('fiscal_year',$fiscal_year)
      ->where('tier', $tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm7byFY($year_selected, $fiscal_year){
      $data=DB::table('view_bp_form7')->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm8byFY($year_selected, $fiscal_year){
      $data=BpForm8Model::where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm9byFY($year_selected, $fiscal_year){
      $data=BpForm9Model::where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm205byFY($year_selected, $fiscal_year){
      $data=DB::table('view_bp_form205')->where('year',$year_selected)->where('fiscal_year',$fiscal_year)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   }

   function getBpForm3byDivisionbyYearbyTier($division_id, $tier, $year_selected){
      $data=BpForm3Model::where('division_id',$division_id)->where('year',$year_selected)
         ->where('tier', $tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm4byDivisionbyYearbyTier($division_id,  $tier, $year_selected){
      $data=BpForm4Model::where('division_id',$division_id)->where('year',$year_selected)
         ->where('tier', $tier)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm5byDivisionbyYearbyTier($division_id, $tier, $year_selected){
      $data=BpForm5Model::where('division_id',$division_id)->where('year',$year_selected)
         ->where('tier', $tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm6byDivisionbyYearbyTier($division_id, $tier, $year_selected){
      $data=BpForm6Model::where('division_id',$division_id)->where('year',$year_selected)
         ->where('tier', $tier)->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm7byDivisionbyYear($division_id, $year_selected){
      $data=DB::table('view_bp_form7')->where('division_id',$division_id)->where('year',$year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm8byDivisionbyYear($division_id, $year_selected){
      $data=BpForm8Model::where('division_id',$division_id)->where('year',$year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm9byDivisionbyYear($division_id, $year_selected){
      $data=BpForm9Model::where('division_id',$division_id)->where('year',$year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 
   function getBpForm205byDivisionbyYear($division_id, $year_selected){
      $data=DB::table('view_bp_form205')->where('division_id',$division_id)->where('year',$year_selected)
         ->where('is_active', 1)->where('is_deleted', 0)->get();     
      // dd($data);
      return $data; 
   } 

   function getRetirees(){
      $data=ViewUsersRetireeModel::where('age', '>=', 60)->orderBy('lname', 'ASC')->get();   
      // dd($data);
      return $data; 
   }

   function getRetirementLaw(){
      $data=RetirementLawModel::where('is_active', 1)->where('is_deleted', 0)->get();   
      // dd($data);
      return $data; 
   }
?>