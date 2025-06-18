<?php

namespace App\Http\Controllers;

use App;
use App\Models\DivisionsModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class AgencyCashProgramsController extends Controller
{
    use HasRoles;

    public function index($year_selected)
    {
        $user_id = auth()->user()->id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        if (isset(request()->url)) {
            return redirect(request()->url);
        } else {
            if (auth()->user()->hasAnyRole('Super Administrator|Administrator|Budget Officer|BPAC|BPAC Chair|Executive Director')) {
                $title = 'agencymcp';
                $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->where('is_section', 0)->orderBy('division_acronym', 'asc')->get();

                return view('programming_allocation.nep.monthly_cash_programs.agency')
                    ->with(compact('title'))
                    ->with(compact('user_id'))
                    ->with(compact('user_division_id'))
                    ->with(compact('year_selected'));
            }
        }
    }

    public function generatePDF(Request $request, $year)
    {
        if ($request->ajax()) {
            $year = $request->year;
            view()->share('year', $year);
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('cash_programs.division_pdf')
                ->set_paper('letter', 'landscape');

            return $pdf->stream();
        } else {
            return view('programming_allocation.nep.monthly_cash_programs.agency_print')
                ->with('year', $year);
        }
    }
}
