<?php

use App\Models\ViewAllotmentModel;
use Illuminate\Support\Facades\DB;

function getAllotment($rstype_id_selected, $division_id, $year_selected)
{
    $data = ViewAllotmentModel::where('division_id', $division_id)->where('rs_type_id', $rstype_id_selected)->where('year', $year_selected)
        ->where('is_deleted', 0)->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id')->orderBy('activity', 'ASC')
        ->orderBy('expense_account_code', 'ASC')->orderBy('object_code', 'ASC')->orderBy('object_specific', 'ASC')->get();

    // dd($data);
    return $data;
}

function getAllotmentFAD($rstype_id_selected, $year_selected)
{
    $data = ViewAllotmentModel::where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)->where('division_acronym', 'LIKE', '%FAD%')
        ->where('is_deleted', 0)->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id')->orderBy('activity', 'ASC')
        ->orderBy('expense_account_code', 'ASC')->orderBy('object_code', 'ASC')->orderBy('object_specific', 'ASC')->get();

    return $data;
}

function getAdjustment()
{
    $data = DB::table('view_adjustment')
        ->select(DB::raw('allotment_id, SUM(annual_adjustment) AS annual_adjustment, SUM(annual_total) AS annual_total,
         SUM(q1_allotment) AS q1_allotment, SUM(q2_allotment) AS q2_allotment,
         SUM(q3_allotment) AS q3_allotment, SUM(q4_allotment) AS q4_allotment,
         SUM(q1_adjustment) AS q1_adjustment, SUM(q2_adjustment) AS q2_adjustment,
         SUM(q3_adjustment) AS q3_adjustment, SUM(q4_adjustment) AS q1_adjustment,
         SUM(q1_total) AS q1_total,SUM(q2_total) AS q2_total, SUM(q3_total) AS q3_total, SUM(q4_total) AS q4_total'))
        ->where('is_active', 1)->where('is_deleted', 0)->get();

    // dd($data);
    return $data;
}
