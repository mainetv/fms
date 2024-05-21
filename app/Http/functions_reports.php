<?php

use App\Models\ViewRSSummaryModel;
use Illuminate\Support\Facades\DB;

   function getRSbyRSTypeDateRange($rs_type_id, $start_date, $end_date){
      $data = ViewRSSummaryModel::where('rs_type_id', $rs_type_id)->where('rs_date','>=',$start_date)->where('rs_date','<=', $end_date)
			->where('is_active', 1)->where('is_deleted', 0)
			->orderBy('pap', 'ASC')->orderBy('allotment_class_id', 'ASC')->orderBy('object_code', 'ASC')->orderBy('division_acronym', 'ASC')->get();	     
      // dd($data);
      return $data; 
   }