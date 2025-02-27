<?php

use App\Models\AllotmentModel;
use App\Models\LibraryPAPModel;
use App\Models\ViewAllotmentModel;

// function getAllotmentByYear($year) {
//    $data = AllotmentModel::with([
//       'pap',
//       'pap.parentPap',
//       'objectExpenditure',
//       'objectExpenditure.allotmentClass',
//   ])
//   ->where('rs_type_id', 1)
//   ->where('year', $year)
//   ->join('library_pap', 'allotment.pap_id', '=', 'library_pap.id')
//   ->orderBy('library_pap.pap_code') // Sorting in the query
//   ->select('allotment.*') 
//   ->get();
//    return $data;
// }

function getAllotmentByYear($year) {
   $data = ViewAllotmentModel::where('rs_type_id', 1)->where('year', $year)
   ->where('is_active', 1)->where('is_deleted', 0)
   ->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
   ->orderBy('expense_account_code','ASC')->orderBy('expense_account','ASC')
   ->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
   ->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
    ->get();
   //  dd($data);
   return $data;
}

function getParentPap($pap_id) {
   $data = LibraryPAPModel::
   with([
            'parentPap',
        ])
   ->where('id', $pap_id)  
    ->get();
   //  dd($data);
   return $data;
}