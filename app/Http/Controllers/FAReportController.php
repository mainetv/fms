<?php

namespace App\Http\Controllers;

use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FAReportController extends Controller
{
    public function far1($year)
    {
        $user_id = auth()->user()->id;
        // $far_num = $request->num;
        // $month = $request->month;
        // $year = $request->year;
        $title = 'far1';

        return view('reports.far.far1')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('year', $year);
    }

    public function far1a($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'far1a';

        return view('reports.far.far1a')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function far1b($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'far1b';

        return view('reports.far.far1b')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function far1c($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'far1c';

        return view('reports.far.far1c')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function far3($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'far3';

        return view('reports.far.far3')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function far4($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'far4';

        return view('reports.far.far4')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function cfar4($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'cfar4';

        return view('reports.far.cfar4')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function far5($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'far5';

        return view('reports.far.far5')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function far6($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'far6';

        return view('reports.far.far6')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function cfar6($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'cfar6';

        return view('reports.far.cfar6')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function bed3($year)
    {
        $user_id = auth()->user()->id;
        $data = [
            'year_selected' => $year,
        ];
        $title = 'bed3';

        return view('reports.far.bed3')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('data', $data);
    }

    public function faer(Request $request)
    {
        $user_id = auth()->user()->id;
        $far_num = $request->num;
        $month = $request->month;
        $year = $request->year;
        $title = 'far1';

        // dd($request->all());
        // $user_role_id = auth()->user()->user_role_id;
        // $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        // if($user_role_id==3){
        // 	$title = 'saob';
        // }
        // else{
        // 	$title = 'saobdivision';
        // }
        // if($user_id==149 || $user_id==117){
        //    $user_division_id=3;
        //    $user_division_acronym='COA';
        // }
        // if($user_id=='20' || $user_id=='14'){
        // 	$user_division_id = '9';
        // 	$user_division_acronym='FAD-DO';
        // }
        return view('reports.far.far1')
            ->with('title', $title)
            ->with('user_id', $user_id)
            ->with('far_num', $far_num)
            ->with('month', $month)
            ->with('year', $year);
        // 	->with('year_selected', $year_selected)
        // 	->with('view_selected', $view_selected)
        // 	->with(compact('user_role_id'))
        // 	->with(compact('user_division_id'))
        // 	->with(compact('user_id'))
        // 	->with(compact('title'));
    }

    public function print_saob(Request $request, $rstype_id_selected, $division_id, $year_selected, $view_selected)
    {
        return \View::make('reports.saob.print_saob')
            ->with('rstype_id_selected', $rstype_id_selected)
            ->with('division_id', $division_id)
            ->with('year_selected', $year_selected)
            ->with('view_selected', $view_selected);
    }
}
