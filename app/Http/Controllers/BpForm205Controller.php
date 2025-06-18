<?php

namespace App\Http\Controllers;

use App\Models\BpForm205Model;
use App\Models\FiscalYearsModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Validator;

class BpForm205Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year_selected)
    {
        $title = 'BP Forms';
        $subtitle = 'BP Form 205';
        $username = auth()->user()->username;
        $user_id = auth()->user()->id;
        $user_role_id = auth()->user()->user_role_id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
        $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
        $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();
        foreach ($user_roles as $row) {
            $user_roles_data[] = [
                'user_role' => $row->user_role,
                'user_role_id' => $row->role_id,
            ];
        }
        if ($user_id == 149 || $user_id == 117) {
            $user_division_id = 3;
            $division_acronym = 'COA';
        }
        if ($user_id == '20' || $user_id == '14') {
            $user_division_id = '9';
            $division_acronym = 'FAD-DO';
        }
        $years = FiscalYearsModel::orderBy('year', 'ASC')->get();
        $data = [
            'year_selected' => $year_selected,
        ];
        $fy1 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year1 as fiscal_year')
            ->where('year', '=', $year_selected)
            ->where('is_active', '=', 1)
            ->where('is_deleted', '=', 0);
        $fy2 = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year2 as fiscal_year')
            ->where('year', '=', $year_selected)
            ->where('.is_active', '=', 1)
            ->where('is_deleted', '=', 0);
        $fiscal_years = DB::table('fiscal_year')->select('year', 'fiscal_year.fiscal_year3 as fiscal_year')
            ->where('year', '=', $year_selected)->where('.is_active', '=', 1)->where('is_deleted', '=', 0)
            ->union($fy1)->union($fy2)->orderBy('fiscal_year', 'ASC')->get();
        $fiscal_years_vertical = FiscalYearsModel::where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();

        $bp_form205 = BpForm205Model::where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();

        return view('budget_preparation.bp_forms.bp_form205.fy_tabs')
            ->with(compact('title'), $title)
            ->with(compact('subtitle'), $subtitle)
            ->with(compact('data'), $data)
            ->with(compact('username'), $username)
            ->with(compact('user_id'))
            ->with(compact('user_role'), $user_role)
            ->with(compact('user_roles'))
            ->with(compact('user_role_id'), $user_role_id)
            ->with(compact('user_division_id'), $user_division_id)
            ->with(compact('user_fullname'), $user_fullname)
            ->with(compact('fiscal_years'), $fiscal_years)
            ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical)
            ->with(compact('years'), $years)
            ->with(compact('bp_form205'), $bp_form205);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $message = [
                'retirement_law_id.required' => 'Please select retirement law.',
                'emp_code.required' => 'Please select name of retiree.',
                'position_id_at_retirement_date.required' => 'Please select position.',
                'highest_monthly_salary.required' => 'Please input highest monthly salary.',
                'sl_credits_earned.required' => 'Please input number of sick leave earned.',
                'vl_credits_earned.required' => 'Please input number of vacation leave earned.',
                'leave_amount.required' => 'Please input terminal leave amount.',
                // 'total_creditable_service.required' => 'Please input total creditable service.',
                // 'num_gratuity_months.required' => 'Please input number of gratuity months.',
                // 'gratuity_amount.required' => 'Please input retirement gratuity amount.',
            ];
            $validator = Validator::make($request->all(), [
                'retirement_law_id' => 'required',
                'emp_code' => 'required',
                'position_id_at_retirement_date' => 'required',
                'highest_monthly_salary' => 'required',
                'sl_credits_earned' => 'required',
                'vl_credits_earned' => 'required',
                'leave_amount' => 'required',
                // 'total_creditable_service' => 'required',
                // 'num_gratuity_months' => 'required',
                // 'gratuity_amount' => 'required',
            ], $message);

            if ($validator->passes()) {
                $data = new BpForm205Model([
                    'division_id' => $request->division_id,
                    'year' => $request->year,
                    'fiscal_year' => $request->fiscal_year,
                    'retirement_law_id' => $request->retirement_law_id,
                    'emp_code' => $request->emp_code,
                    'position_id_at_retirement_date' => $request->position_id_at_retirement_date,
                    'highest_monthly_salary' => $request->highest_monthly_salary,
                    'sl_credits_earned' => $request->sl_credits_earned,
                    'vl_credits_earned' => $request->vl_credits_earned,
                    'leave_amount' => $request->leave_amount,
                    'total_creditable_service' => $request->total_creditable_service,
                    'num_gratuity_months' => $request->num_gratuity_months,
                    'gratuity_amount' => $request->gratuity_amount,
                ]);
                // dd($data);
                $data->save();

                return Response::json(['success' => '1']);
            }

            return Response::json(['errors' => $validator->errors()]);

        }
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $data = BpForm205Model::find($request->get('id'));
            // dd($data);
            if ($data->count()) {
                return Response::json([
                    'status' => '1',
                    'bp_form205' => $data,
                ]);
            } else {
                return Response::json([
                    'status' => '0',
                ]);
            }
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $message = [
                'retirement_law_id.required' => 'Please select retirement law.',
                'emp_code.required' => 'Please select name of retiree.',
                'position_id_at_retirement_date.required' => 'Please select position.',
                'highest_monthly_salary.required' => 'Please input highest monthly salary.',
                'sl_credits_earned.required' => 'Please input number of sick leave earned.',
                'vl_credits_earned.required' => 'Please input number of vacation leave earned.',
                'leave_amount.required' => 'Please input terminal leave amount.',
                // 'total_creditable_service.required' => 'Please input total creditable service.',
                // 'num_gratuity_months.required' => 'Please input number of gratuity months.',
                // 'gratuity_amount.required' => 'Please input retirement gratuity amount.',
            ];
            $validator = Validator::make($request->all(), [
                'retirement_law_id' => 'required',
                'emp_code' => 'required',
                'position_id_at_retirement_date' => 'required',
                'highest_monthly_salary' => 'required',
                'sl_credits_earned' => 'required',
                'vl_credits_earned' => 'required',
                'leave_amount' => 'required',
                // 'total_creditable_service' => 'required',
                // 'num_gratuity_months' => 'required',
                // 'gratuity_amount' => 'required',
            ], $message);
            if ($validator->passes()) {
                BpForm205Model::find($request->get('id'))
                    ->update([
                        'retirement_law_id' => $request->retirement_law_id,
                        'emp_code' => $request->emp_code,
                        'position_id_at_retirement_date' => $request->position_id_at_retirement_date,
                        'highest_monthly_salary' => $request->highest_monthly_salary,
                        'sl_credits_earned' => $request->sl_credits_earned,
                        'vl_credits_earned' => $request->vl_credits_earned,
                        'leave_amount' => $request->leave_amount,
                        'total_creditable_service' => $request->total_creditable_service,
                        'num_gratuity_months' => $request->num_gratuity_months,
                        'gratuity_amount' => $request->gratuity_amount,
                    ]);

                return Response::json([
                    'success' => '1',
                    'status' => '0',
                ]);
            }

            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            try {
                BpForm205Model::find($request->get('id'))
                    ->update([
                        'is_deleted' => '1',
                    ]);
            } catch (\Exception $e) {
                return Response::json([
                    'status' => '0',
                ]);
            }

            return Response::json([
                'status' => '1',
            ]);
        }
    }
}
