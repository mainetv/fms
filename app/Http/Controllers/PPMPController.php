<?php

namespace App\Http\Controllers;

use App\Jobs\BudgetProposalStore;
use App\Jobs\BudgetProposalYear;
use App\Models\BudgetProposalActivityModel;
use App\Models\BudgetProposalExpenditureModel;
use App\Models\BudgetProposalSubactivityModel;
use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\LibraryActivityModel;
use App\Models\LibraryObjectExpenditureModel;
use App\Models\LibraryPAPModel;
use App\Models\LibrarySubactivityModel;
use App\Models\ViewBpPAPModel;
use App\Models\ViewBudgetProposalItemsModel;
use App\Models\ViewUsersModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;
use Validator;

class PPMPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_role_id = auth()->user()->user_role_id;
        $username = auth()->user()->username;
        $user_id = auth()->user()->id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
        $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
        $year = Carbon::now()->format('Y');
        $budget_proposal_id = $request->budget_proposal_id;
        $division_id = $request->division_id;
        $data = [
            'year_selected' => $year,
            'division_id' => $division_id,
        ];
        $title = 'PPMP';
        $view_bp_items = ViewBudgetProposalItemsModel::where('is_active', 1)->where('is_deleted', 0)->get();
        $division_ids = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->where('is_section', 0)->orderBy('division_acronym', 'asc')->get();
        $fiscal_years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'ASC')->get();
        $fiscal_year_selected = FiscalYearsModel::where('year', $year)->where('is_active', 1)->where('is_deleted', 0)->get();
        $getLibraryPAP = LibraryPAPModel::where('is_active', 1)->where('is_deleted', 0)
            ->whereNotIn('pap_code', (function ($query) use ($year, $division_id) {
                $query->from('view_bp_pap')
                    ->select('pap_code')
                    ->where('year', $year)
                    ->where('division_id', $division_id);
            }))->get();
        $getLibraryActivities = LibraryActivityModel::where('is_active', 1)->where('is_deleted', 0)->get();
        $getLibrarySubactivities = LibrarySubactivityModel::where('is_active', 1)->where('is_deleted', 0)->get();
        $getLibraryObjectExpenditures = LibraryObjectExpenditureModel::where('is_active', 1)->where('is_deleted', 0)->get();
        if ($user_role_id == '1' || $user_role_id == '4') {
            $view_budget_proposal_items_byyear = ViewBudgetProposalItemsModel::where('year', $year)->where('is_active', 1)->where('is_deleted', 0)->get();
        } elseif ($user_role_id != '1' || $user_role_id != '4') {
            $view_budget_proposal_items_byyear = ViewBudgetProposalItemsModel::where('division_id', $user_division_id)->where('year', $year)->where('is_active', 1)->where('is_deleted', 0)->get();
        }

        // dd($getLibraryPAP);
        return view('budget_preparation.budget_proposals.index')
            ->with(compact('title'), $title)
            ->with(compact('data'), $data)
            ->with(compact('username'), $username)
            ->with(compact('user_role'), $user_role)
            ->with(compact('user_fullname'), $user_fullname)
            ->with(compact('divisions'), $division_ids)
            ->with(compact('getLibraryPAP'), $getLibraryPAP)
            ->with(compact('getLibraryActivities'), $getLibraryActivities)
            ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
            ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
            ->with(compact('year'), $year)
            ->with(compact('fiscal_years'), $fiscal_years)
            ->with(compact('fiscal_year_selected'), $fiscal_year_selected)
            ->with(compact('view_bp_items'), $view_bp_items)
            ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
    }

    public function findAction(Request $request)
    {
        // dd($request->has('year'));
        if ($request->has('store')) {
            return $this->dispatch(new BudgetProposalStore($request));
        } elseif ($request->has('year')) {
            return $this->dispatch(new BudgetProposalYear($request));
        }

        return 'no action found';
    }

    public function postAction(Request $request)
    {
        if ($request->ajax()) {
            if ($request->add_pap != '') { // adding PAP
                $message = [
                    'pap_code.required' => 'Please select PAP.',
                ];
                $validator = Validator::make($request->all(), [
                    'pap_code' => 'required',
                ], $message);

                $input = $request->all();
                if ($validator->passes()) {
                    $data = new ViewBpPAPModel([
                        'budget_proposal_id' => $request->get('budget_proposal_id'),
                        'pap_code' => $request->get('pap_code'),
                    ]);
                    $data->save();

                    return Response::json(['success' => '1']);
                }

                return Response::json(['errors' => $validator->errors()]);
            } elseif ($request->add_activity != '') { // adding activity
                $message = [
                    'activity_id.required' => 'Please select activity.',
                ];
                $validator = Validator::make($request->all(), [
                    'activity_id' => 'required',
                ], $message);

                $input = $request->all();
                if ($validator->passes()) {
                    $data = new BudgetProposalActivityModel([
                        'bp_pap_id' => $request->get('bp_pap_id'),
                        'activity_id' => $request->get('activity_id'),
                    ]);
                    $data->save();

                    return Response::json(['success' => '1']);
                }

                return Response::json(['errors' => $validator->errors()]);
            } elseif ($request->add_subactivity != '') { // adding subactivity
                $message = [
                    'subactivity_id.required' => 'Please select subactivity.',
                ];
                $validator = Validator::make($request->all(), [
                    'subactivity_id' => 'required',
                ], $message);

                $input = $request->all();
                if ($validator->passes()) {
                    $data = new BudgetProposalSubactivityModel([
                        'bp_activity_id' => $request->get('bp_activity_id'),
                        'subactivity_id' => $request->get('subactivity_id'),
                    ]);
                    $data->save();

                    return Response::json(['success' => '1']);
                }

                return Response::json(['errors' => $validator->errors()]);
            } elseif ($request->add_expenditure_activity == 1) { // adding expenditure under activity
                $message = [
                    'expenditure_id.required' => 'Please select expenditure.',
                ];
                $validator = Validator::make($request->all(), [
                    'expenditure_id' => 'required',
                ], $message);

                $input = $request->all();
                if ($validator->passes()) {
                    $data = new BudgetProposalExpenditureModel([
                        'bp_activity_id' => $request->get('bp_activity_id'),
                        'expenditure_id' => $request->get('expenditure_id'),
                        'fy1_amount' => $request->get('fy1_amount'),
                        'fy2_amount' => $request->get('fy2_amount'),
                        'fy3_amount' => $request->get('fy3_amount'),
                    ]);
                    $data->save();

                    return Response::json(['success' => '1']);
                }

                return Response::json(['errors' => $validator->errors()]);
            } elseif ($request->add_expenditure_subactivity == 1) { // adding expenditure under subactivity
                $message = [
                    'expenditure_id.required' => 'Please select expenditure.',
                ];
                $validator = Validator::make($request->all(), [
                    'expenditure_id' => 'required',
                ], $message);

                $input = $request->all();
                if ($validator->passes()) {
                    $data = new BudgetProposalExpenditureModel([
                        'budget_proposal_subactivity_id' => $request->get('budget_proposal_subactivity_id'),
                        'expenditure_id' => $request->get('expenditure_id'),
                        'fy1_amount' => $request->get('fy1_amount'),
                        'fy2_amount' => $request->get('fy2_amount'),
                        'fy3_amount' => $request->get('fy3_amount'),
                    ]);
                    $data->save();

                    return Response::json(['success' => '1']);
                }

                return Response::json(['errors' => $validator->errors()]);
            }
        } elseif ($request->year_selected != '') { // change drop down year
            $user_role_id = auth()->user()->user_role_id;
            $username = auth()->user()->username;
            $user_id = auth()->user()->id;
            $year_selected = $request->year_selected;
            $division_id = $request->division_id;
            $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
            $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
            $budget_proposal_id = $request->budget_proposal_id;
            $data = [
                'division_id' => $division_id,
                'year_selected' => $year_selected,
            ];
            $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
            $title = 'Division Proposals';

            $view_bp_items = ViewBudgetProposalItemsModel::where('is_active', 1)->where('is_deleted', 0)->get();
            $division_ids = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->where('is_section', 0)->orderBy('division_acronym', 'asc')->get();
            $fiscal_years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'ASC')->get();
            $fiscal_year_selected = FiscalYearsModel::where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();
            $getLibraryPAP = LibraryPAPModel::where('is_active', 1)->where('is_deleted', 0)
                ->whereNotIn('pap_code', (function ($query) use ($year_selected) {
                    $query->from('view_bp_pap')
                        ->select('pap_code')
                        ->where('year', $year_selected)
                        ->where('division_id', 'D');
                }))->get();
            $getLibraryActivities = LibraryActivityModel::where('is_active', 1)->where('is_deleted', 0)->get();
            $getLibrarySubactivities = LibrarySubactivityModel::where('is_active', 1)->where('is_deleted', 0)->get();
            $getLibraryObjectExpenditures = LibraryObjectExpenditureModel::where('is_active', 1)->where('is_deleted', 0)->get();
            if ($user_role_id == '0') {
                $view_budget_proposal_items_byyear = ViewBudgetProposalItemsModel::where('division_id', $division_id)->where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();
            } elseif ($user_role_id == '6') {
                $view_budget_proposal_items_byyear = ViewBudgetProposalItemsModel::where('division_id', $division_id)->where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();
            }

            return view('budget_preparation.budget_proposals.index')
                ->with(compact('title'), $title)
                ->with(compact('data'), $data)
                ->with(compact('username'), $username)
                ->with(compact('user_role'), $user_role)
                ->with(compact('user_fullname'), $user_fullname)
                ->with(compact('divisions'), $division_ids)
                ->with(compact('getLibraryPAP'), $getLibraryPAP)
                ->with(compact('getLibraryActivities'), $getLibraryActivities)
                ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
                ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
                ->with(compact('year_selected'), $year_selected)
                ->with(compact('fiscal_years'), $fiscal_years)
                ->with(compact('fiscal_year_selected'), $fiscal_year_selected)
                ->with(compact('view_bp_items'), $view_bp_items)
                ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
        }
    }

    public function select_year(Request $request)
    {
        $user_role_id = auth()->user()->user_role_id;
        $username = auth()->user()->username;
        $user_id = auth()->user()->id;
        $year_selected = $request->year;
        $division_id = $request->division_id;
        $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
        $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
        // $budget_proposal_id = $request->budget_proposal_id;
        $data = [
            'division_id' => $division_id,
            'year_selected' => $year_selected,
        ];
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $title = 'Division Proposals';

        $view_bp_items = ViewBudgetProposalItemsModel::where('is_active', 1)->where('is_deleted', 0)->get();
        $division_ids = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->where('is_section', 0)->orderBy('division_acronym', 'asc')->get();
        $fiscal_years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'ASC')->get();
        $fiscal_year_selected = FiscalYearsModel::where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();
        $getLibraryPAP = LibraryPAPModel::where('is_active', 1)->where('is_deleted', 0)
            ->whereNotIn('pap_code', (function ($query) use ($year_selected, $division_id) {
                $query->from('view_bp_pap')
                    ->select('pap_code')
                    ->where('year', $year_selected)
                    ->where('division_id', $division_id);
            }))->get();
        $getLibraryActivities = LibraryActivityModel::where('is_active', 1)->where('is_deleted', 0)->get();
        $getLibrarySubactivities = LibrarySubactivityModel::where('is_active', 1)->where('is_deleted', 0)->get();
        $getLibraryObjectExpenditures = LibraryObjectExpenditureModel::where('is_active', 1)->where('is_deleted', 0)->get();
        if ($user_role_id == '0') {
            $view_budget_proposal_items_byyear = ViewBudgetProposalItemsModel::where('division_id', $division_id)->where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();
        } elseif ($user_role_id == '6') {
            $view_budget_proposal_items_byyear = ViewBudgetProposalItemsModel::where('division_id', $division_id)->where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();
        }

        return view('budget_preparation.budget_proposals.index')
            ->with(compact('title'), $title)
            ->with(compact('year_selected'), $year_selected)
            ->with(compact('division_id'), $division_id)
            ->with(compact('data'), $data)
            ->with(compact('username'), $username)
            ->with(compact('user_role'), $user_role)
            ->with(compact('user_fullname'), $user_fullname)
            ->with(compact('divisions'), $division_ids)
            ->with(compact('getLibraryPAP'), $getLibraryPAP)
            ->with(compact('getLibraryActivities'), $getLibraryActivities)
            ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
            ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
            ->with(compact('fiscal_years'), $fiscal_years)
            ->with(compact('fiscal_year_selected'), $fiscal_year_selected)
            ->with(compact('view_bp_items'), $view_bp_items)
            ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
    }
}
