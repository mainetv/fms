<?php

namespace App\Http\Controllers;

use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\PCAARRDBudgetProposalModel;
use App\Models\ViewBudgetProposalsModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AgencyBudgetProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agency_by_expenditure($year_selected)
    {
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
        $data = [
            'year_selected' => $year_selected,
        ];
        $years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'DESC')->get();
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
            if (auth()->user()->hasAnyRole('Super Administrator|Administrator|BPAC|BPAC Chair|Budget Officer|Executive Director')) {
                $title = 'Agency Budget Proposal by PAP/Expenditure';
                $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->where('is_section', 0)->orderBy('division_acronym', 'asc')->get();

                return view('budget_preparation.budget_proposals.agency_by_expenditure')
                    ->with(compact('title'), $title)
                    ->with(compact('data'), $data)
                    ->with(compact('username'), $username)
                    ->with(compact('user_id'))
                    ->with(compact('user_role'), $user_role)
                    ->with(compact('user_roles'))
                    ->with(compact('user_role_id'), $user_role_id)
                    ->with(compact('user_division_id'), $user_division_id)
                    ->with(compact('user_fullname'), $user_fullname)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('divisions'), $divisions)
                    ->with(compact('years'), $years)
                    ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical);
            }
        }
    }

    public function agency_by_expenditure_tier1_fy1($year_selected)
    {
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
        $data = [
            'year_selected' => $year_selected,
        ];
        $years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'DESC')->get();
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
            if (auth()->user()->hasAnyRole('Super Administrator|Administrator|BPAC|BPAC Chair|Budget Officer|Executive Director')) {
                $title = 'bpfy1';
                $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->where('is_section', 0)->orderBy('division_acronym', 'asc')->get();

                return view('budget_preparation.budget_proposals.agency_by_expenditure_tier1_fy1')
                    ->with(compact('title'), $title)
                    ->with(compact('data'), $data)
                    ->with(compact('username'), $username)
                    ->with(compact('user_id'))
                    ->with(compact('user_role'), $user_role)
                    ->with(compact('user_roles'))
                    ->with(compact('user_role_id'), $user_role_id)
                    ->with(compact('user_division_id'), $user_division_id)
                    ->with(compact('user_fullname'), $user_fullname)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('divisions'), $divisions)
                    ->with(compact('years'), $years)
                    ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical);
            }
        }
    }

    public function getBudgetProposals(Request $request)
    {
        if ($request->ajax()) {
            $data = ViewBudgetProposalsModel::select(
                [
                    'id',
                    'pap',
                    'expense_account',
                    'object_expenditure',
                    'fy1_amount',
                    'fy2_amount',
                    'fy3_amount',
                ]); // Adjust columns as needed

            return DataTables::of($data)->make(true);
        }

        return response()->json(['error' => 'Not an AJAX request'], 400);
    }

    public function summary_per_division($year_selected)
    {
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
        $data = [
            'year_selected' => $year_selected,
        ];
        $years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'DESC')->get();
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
            if (auth()->user()->hasAnyRole('Super Administrator|Administrator|BPAC|BPAC Chair|Budget Officer|Executive Director')) {
                $title = 'summaryperdiv';
                $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->where('is_section', 0)->orderBy('division_acronym', 'asc')->get();

                return view('budget_preparation.budget_proposals.summary_per_division')
                    ->with(compact('title'), $title)
                    ->with(compact('data'), $data)
                    ->with(compact('username'), $username)
                    ->with(compact('user_id'))
                    ->with(compact('user_role'), $user_role)
                    ->with(compact('user_roles'))
                    ->with(compact('user_role_id'), $user_role_id)
                    ->with(compact('user_division_id'), $user_division_id)
                    ->with(compact('user_fullname'), $user_fullname)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('divisions'), $divisions)
                    ->with(compact('years'), $years)
                    ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical);
            }
        }
    }

    public function print_summary_per_division(Request $request, $year)
    {
        if ($request->ajax()) {
            $year = $request->year;
            view()->share('year', $year);
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('budget_preparation.budget_proposals.print_summary_per_division')
                ->set_paper('letter', 'portait');

            return $pdf->stream();
        } else {
            return view('budget_preparation.budget_proposals.print_summary_per_division')
                ->with('year', $year);
        }
    }

    public function print_agency_by_expenditure_tier1_fy1(Request $request, $year)
    {
        if ($request->ajax()) {
            $year = $request->year;
            view()->share('year', $year);
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('budget_preparation.budget_proposals.print_agency_by_expenditure_tier1_fy1')
                ->set_paper('letter', 'portait');

            return $pdf->stream();
        } else {
            return view('budget_preparation.budget_proposals.print_agency_by_expenditure_tier1_fy1')
                ->with('year', $year);
        }
    }

    public function agency_by_activity($year_selected)
    {
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
        $data = [
            'year_selected' => $year_selected,
        ];
        $years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'DESC')->get();
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
            if (auth()->user()->hasAnyRole('Super Administrator|Administrator|BPAC|BPAC Chair|Budget Officer|Executive Director')) {
                $title = 'Agency Budget Proposal by PAP/Activity';
                $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->where('is_section', 0)->orderBy('division_acronym', 'asc')->get();

                return view('budget_preparation.budget_proposals.agency_by_activity')
                    ->with(compact('title'), $title)
                    ->with(compact('data'), $data)
                    ->with(compact('username'), $username)
                    ->with(compact('user_id'))
                    ->with(compact('user_role'), $user_role)
                    ->with(compact('user_roles'))
                    ->with(compact('user_role_id'), $user_role_id)
                    ->with(compact('user_division_id'), $user_division_id)
                    ->with(compact('user_fullname'), $user_fullname)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('divisions'), $divisions)
                    ->with(compact('years'), $years)
                    ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical);
            }
        }
    }

    public function generatePDF_by_expenditure(Request $request, $year)
    {
        if ($request->ajax()) {
            $year = $request->year;
            view()->share('year', $year);
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('budget_preparation.budget_proposals.agency_by_expenditure_pdf')
                ->set_paper('letter', 'portait');

            return $pdf->stream();
        } else {
            return view('budget_preparation.budget_proposals.agency_by_expenditure_pdf')
                ->with('year', $year);
        }
    }

    public function generatePDF_by_activity(Request $request, $year)
    {
        if ($request->ajax()) {
            $year = $request->year;
            view()->share('year', $year);
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('budget_preparation.budget_proposals.agency_by_activity_pdf')
                ->set_paper('letter', 'portait');

            return $pdf->stream();
        } else {
            return view('budget_preparation.budget_proposals.agency_by_activity_pdf')
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
    public function show(PCAARRDBudgetProposalModel $pCAARRDBudgetProposalModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PCAARRDBudgetProposalModel $pCAARRDBudgetProposalModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PCAARRDBudgetProposalModel $pCAARRDBudgetProposalModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PCAARRDBudgetProposalModel $pCAARRDBudgetProposalModel)
    {
        //
    }
}
