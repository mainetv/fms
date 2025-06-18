<?php

use App\Models\BpForm3Model;
use App\Models\BpForm4Model;
use App\Models\BpForm5Model;
use App\Models\BpForm6Model;
use App\Models\BpForm7Model;
use App\Models\BpForm8Model;
use App\Models\BpForm9Model;
use App\Models\ViewBpStatusModel;
use App\Models\ViewCpStatusModel;
use App\Models\ViewQopStatusModel;

function getBPStatus($division_id, $year)
{
    $data = ViewBpStatusModel::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->orderBY('id', 'DESC')->get();

    // dd($data);
    return $data;
}

function getBPStatusbyYear($year)
{
    $data = ViewBpStatusModel::where('year', $year)->where('is_active', 1)->where('is_deleted', 0)->get();

    // dd($data);
    return $data;
}

function getBPStatusbyDate($division_id, $year)
{
    $data = ViewBpStatusModel::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->orderBY('id', 'DESC')->get();

    // dd($data);
    return $data;
}

function getForm3Count($division_id, $year)
{
    $data = BpForm3Model::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->count();

    // dd($data);
    return $data;
}

function getForm4Count($division_id, $year)
{
    $data = BpForm4Model::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->count();

    // dd($data);
    return $data;
}

function getForm5Count($division_id, $year)
{
    $data = BpForm5Model::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->count();

    // dd($data);
    return $data;
}

function getForm6Count($division_id, $year)
{
    $data = BpForm6Model::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->count();

    // dd($data);
    return $data;
}

function getForm7Count($division_id, $year)
{
    $data = BpForm7Model::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->count();

    // dd($data);
    return $data;
}

function getForm8Count($division_id, $year)
{
    $data = BpForm8Model::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->count();

    // dd($data);
    return $data;
}

function getForm9Count($division_id, $year)
{
    $data = BpForm9Model::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->count();

    // dd($data);
    return $data;
}

function getMCPStatus($division_id, $year)
{
    $data = ViewCpStatusModel::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->orderBY('id', 'DESC')->get();

    // dd($data);
    return $data;
}

function getMCPStatusbyDate($division_id, $year)
{
    $data = ViewCpStatusModel::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->orderBY('id', 'ASC')->get();

    // dd($data);
    return $data;
}

function getQOPStatus($division_id, $year)
{
    $data = ViewQopStatusModel::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->orderBY('id', 'DESC')->get();

    // dd($data);
    return $data;
}

function getQOPStatusbyDate($division_id, $year)
{
    $data = ViewQopStatusModel::where('division_id', $division_id)->where('year', $year)
        ->where('is_deleted', 0)->orderBY('id', 'ASC')->get();

    // dd($data);
    return $data;
}
