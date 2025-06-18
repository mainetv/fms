<?php

namespace App\Http\Controllers;

use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\PhysicalTargetsModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PhysicalTargetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year_selected)
    {
        $title = 'Physical Targets';
        $user_role_id = auth()->user()->user_role_id;
        $username = auth()->user()->username;
        $user_id = auth()->user()->id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
        $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
        $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
        $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();
        foreach ($user_roles as $row) {
            $user_roles_data[] = [
                'user_role' => $row->user_role,
                'user_role_id' => $row->role_id,
            ];
        }
        $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();
        $data = [
            'year_selected' => $year_selected,
        ];
        if ($emp_code == '0121-A2021' || $emp_code == 'MOL001') {
            $user_division_id = '9';
            $user_division_acronym = 'FAD-DO';
            $division_acronym = 'FAD-DO';
        }
        $years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'ASC')->get();
        $fiscal_years_vertical = FiscalYearsModel::where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();
        $fy1 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year1 as fiscal_year')
            ->where('year', '=', $year_selected)
            ->where('is_active', '=', 1)
            ->where('is_deleted', '=', 0);
        $fy2 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year2 as fiscal_year')
            ->where('year', '=', $year_selected)
            ->where('.is_active', '=', 1)
            ->where('is_deleted', '=', 0);
        $fiscal_years_horizontal = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year3 as fiscal_year')
            ->where('year', '=', $year_selected)->where('.is_active', '=', 1)->where('is_deleted', '=', 0)
            ->union($fy1)->union($fy2)->orderBy('fiscal_year', 'ASC')->get();

        if (isset(request()->url)) {
            return redirect(request()->url);
        } else {
            if ($user_role_id == '0' || $user_role_id == '1' || $user_role_id == '3' || $user_role_id == '8' || $user_role_id == '9' || $user_role_id == '10') {
                $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();

                return view('budget_preparation.physical_targets.division_tabs')
                    ->with(compact('title'))
                    ->with(compact('data'))
                    ->with(compact('username'))
                    ->with(compact('user_id'))
                    ->with(compact('user_role'))
                    ->with(compact('user_roles'))
                    ->with(compact('user_role_id'))
                    ->with(compact('user_division_id'))
                    ->with(compact('user_fullname'))
                    ->with(compact('divisions'))
                    ->with(compact('years'))
                    ->with(compact('fiscal_years_horizontal'))
                    ->with(compact('fiscal_years_vertical'));
            } elseif ($user_role_id == '5') { // Specific divisions under their cluster only
                $divisions = DivisionsModel::where('cluster_id', $user_division_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();

                return view('budget_preparation.physical_targets.division_tabs')
                    ->with(compact('title'))
                    ->with(compact('data'))
                    ->with(compact('username'))
                    ->with(compact('user_id'))
                    ->with(compact('user_role'))
                    ->with(compact('user_roles'))
                    ->with(compact('user_role_id'))
                    ->with(compact('user_division_id'))
                    ->with(compact('user_fullname'))
                    ->with(compact('user_division_acronym'))
                    ->with(compact('divisions'))
                    ->with(compact('years'))
                    ->with(compact('fiscal_years_horizontal'))
                    ->with(compact('fiscal_years_vertical'));
            } elseif ($user_role_id == '6' || $user_role_id == '7') { // User specific division only
                $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();

                return view('budget_preparation.physical_targets.division')
                    ->with(compact('title'))
                    ->with(compact('data'))
                    ->with(compact('username'))
                    ->with(compact('user_id'))
                    ->with(compact('user_role'))
                    ->with(compact('user_roles'))
                    ->with(compact('user_role_id'))
                    ->with(compact('user_division_id'))
                    ->with(compact('user_fullname'))
                    ->with(compact('user_division_acronym'))
                    ->with(compact('divisions'))
                    ->with(compact('years'))
                    ->with(compact('fiscal_years_horizontal'))
                    ->with(compact('fiscal_years_vertical'));
            }
        }
    }

    public function generatePDF(Request $request, $division_id, $year)
    {
        if ($request->ajax()) {
            $year = $request->year;
            view()->share('year', $year);
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('division_proposals.physical_targets.division_pdf')
                ->set_paper('letter', 'portait');

            return $pdf->stream();
        } else {
            return view('budget_preparation.physical_targets.division_pdf')
                ->with('division_id', $division_id)
                ->with('year', $year);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PhysicalTargetsModel $physicalTargetsModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PhysicalTargetsModel $physicalTargetsModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhysicalTargetsModel $physicalTargetsModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhysicalTargetsModel $physicalTargetsModel)
    {
        //
    }
}
