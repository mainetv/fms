<?php

namespace App\Http\Controllers;

use App\Models\BpForm8Model;
use App\Models\FiscalYearsModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;

class BpForm8Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year_selected)
    {
        $title = 'BP Forms';
        $subtitle = 'BP Form 8';
        $username = auth()->user()->username;
        $user_id = auth()->user()->id;
        $user_role_id = auth()->user()->user_role_id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
        $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
        $years = FiscalYearsModel::orderBy('year', 'ASC')->get();
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
        $bp_form8 = BpForm8Model::where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();

        return view('budget_preparation.bp_forms.bp_form8.fy_tabs')
            ->with(compact('title'), $title)
            ->with(compact('subtitle'), $subtitle)
            ->with(compact('data'), $data)
            ->with(compact('username'), $username)
            ->with(compact('user_id'))
            ->with(compact('user_roles'))
            ->with(compact('user_role'), $user_role)
            ->with(compact('user_role_id'), $user_role_id)
            ->with(compact('user_division_id'), $user_division_id)
            ->with(compact('user_fullname'), $user_fullname)
            ->with(compact('fiscal_years'), $fiscal_years)
            ->with(compact('years'), $years)
            ->with(compact('bp_form8'), $bp_form8);
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
        if ($request->ajax()) {
            // dd($request);
            $message = [
                'name.required' => 'Name field is required.',
                'proposed_date.required' => 'Proposed date field is required',
                'destination.required' => 'Destination field is required',
                'amount.required' => 'Amount field is required and should be a number.',
                'purpose_travel.required' => 'Purpose travel field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'proposed_date' => 'required',
                'destination' => 'required',
                'amount' => 'required', 'integer',
                'purpose_travel' => 'required',
            ], $message);

            $input = $request->all();
            if ($validator->passes()) {
                $data = new BpForm8Model([
                    'division_id' => $request->get('division_id'),
                    'year' => $request->get('year'),
                    'fiscal_year' => $request->get('fiscal_year'),
                    'name' => $request->get('name'),
                    'destination' => $request->get('destination'),
                    'proposed_date' => $request->get('proposed_date'),
                    'amount' => $request->get('amount'),
                    'purpose_travel' => $request->get('purpose_travel'),
                ]);
                $data->save();

                return Response::json(['success' => '1']);
            }

            return Response::json(['errors' => $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BpForm8Model  $BpForm8Model
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = BpForm8Model::find($request->get('id'));
            if ($data->count()) {
                return Response::json([
                    'status' => '1',
                    'bp_form8' => $data,
                ]);
            } else {
                return Response::json([
                    'status' => '0',
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\BpForm8Model  $BpForm8Model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all()); exit();
            $message = [
                'name.required' => 'Name field is required.',
                'proposed_date.required' => 'Proposed date field is required',
                'destination.required' => 'Destination field is required',
                'amount.required' => 'Amount field is required and should be a number.',
                'purpose_travel.required' => 'Purpose travel field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'proposed_date' => 'required',
                'destination' => 'required',
                'amount' => 'required', 'integer',
                'purpose_travel' => 'required',
            ], $message);

            $input = $request->all();

            if ($validator->passes()) {
                BpForm8Model::find($request->get('id'))
                    ->update([
                        'name' => $request->get('name'),
                        'destination' => $request->get('destination'),
                        'proposed_date' => $request->get('proposed_date'),
                        'amount' => $request->get('amount'),
                        'purpose_travel' => $request->get('purpose_travel'),
                    ]);

                return Response::json([
                    'success' => '1',
                    'status' => '0',
                ]);
            }

            return Response::json(['errors' => $validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, BpForm8Model $BpForm8Model)
    {
        if ($request->ajax()) {
            try {
                BpForm8Model::find($request->get('id'))
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
