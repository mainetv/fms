<?php

namespace App\Http\Controllers;

use App;
use App\Mail\NotificationMail;
use App\Models\AllotmentStatusModel;
use App\Models\BpCommentsModel;
use App\Models\BpStatusModel;
use App\Models\BudgetProposalsModel;
use App\Models\DivisionsModel;
use App\Models\FiscalYearsModel;
use App\Models\LibraryActivityModel;
use App\Models\LibraryExpenseAccountModel;
use App\Models\LibraryObjectExpenditureModel;
use App\Models\LibraryPAPModel;
use App\Models\LibrarySubactivityModel;
use App\Models\NotificationsModel;
use App\Models\User;
use App\Models\ViewBpCommentsModel;
use App\Models\ViewBudgetProposalsModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Mail;
use Response;
use Spatie\Permission\Traits\HasRoles;
use Validator;

class BudgetProposalsController extends Controller
{
    use HasRoles;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year_selected)
    {
        $username = auth()->user()->username;
        $user_id = auth()->user()->id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
        $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
        $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();
        $data = [
            'year_selected' => $year_selected,
            'division_id' => $user_division_id,
        ];
        if ($user_id == 149 || $user_id == 117) {
            $user_division_id = 3;
            $user_division_acronym = 'COA';
        }
        $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();
        foreach ($user_roles as $row) {
            $user_roles_data[] = [
                'user_role' => $row->user_role,
                'user_role_id' => $row->role_id,
            ];
        }
        if ($emp_code == 'PS1286' || $emp_code == 'MOL001') {
            $user_division_id = '9';
            $user_division_acronym = 'FAD-DO';
            $division_acronym = 'FAD-DO';
        }
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
        $getLibraryPAP = LibraryPAPModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('pap_code')->get();
        $getLibraryActivities = LibraryActivityModel::where('division_id', $user_division_id)->orWhereNull('division_id')->where('is_active', 1)->where('is_deleted', 0)->orderBy('activity')->get();
        $getLibrarySubactivities = LibrarySubactivityModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('subactivity')->get();
        $getLibraryExpenseAccounts = LibraryExpenseAccountModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('expense_account')->get();
        $getLibraryObjectExpenditures = LibraryObjectExpenditureModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('object_expenditure')->get();
        $active_status_id = BpStatusModel::where('division_id', $user_division_id)->where('year', $year_selected)
            ->where('is_active', 1)->where('is_deleted', 0)->pluck('status_id')->first();
        if (isset(request()->url)) {
            return redirect(request()->url);
        } else {

            // User specific division only
            if (auth()->user()->hasAnyRole('Division Budget Controller|Division Director|Section Head')) {
                // dd('Division Budget Proposal');
                $title = 'Division Budget Proposal';
                $user_role = ViewUsersHasRolesModel::where('id', $user_id)
                    ->where(function ($query) {
                        $query->where('role_id', '=', 11)
                            ->orWhere('role_id', '=', 6)
                            ->orWhere('role_id', '=', 7);
                    })
                    ->pluck('user_role')->first();
                $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
                    ->where(function ($query) {
                        $query->where('role_id', '=', 11)
                            ->orWhere('role_id', '=', 6)
                            ->orWhere('role_id', '=', 7);
                    })
                    ->pluck('role_id')->first();
                // dd($user_role_id);
                $divisions = DivisionsModel::where('is_active', 1)->where('id', '!=', $user_division_id)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();
                $divisions_wofad = DivisionsModel::where('is_active', 1)->where('id', '!=', $user_division_id)->where('division_id', '!=', 5)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();
                $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('division_id', $user_division_id)->where('year', $year_selected)->get();

                return view('budget_preparation.budget_proposals.division')
                    ->with(compact('title'), $title)
                    ->with(compact('data'), $data)
                    ->with(compact('username'), $username)
                    ->with(compact('user_id'), $user_id)
                    ->with(compact('user_role'), $user_role)
                    ->with(compact('user_role_id'))
                    ->with(compact('user_roles'))
                    ->with(compact('user_division_id'), $user_division_id)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('user_fullname'), $user_fullname)
                    ->with(compact('divisions'), $divisions)
                    ->with(compact('divisions_wofad'))
                    ->with(compact('getLibraryPAP'), $getLibraryPAP)
                    ->with(compact('getLibraryActivities'), $getLibraryActivities)
                    ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
                    ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
                    ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
                    ->with(compact('year_selected'), $year_selected)
                    ->with(compact('years'), $years)
                    ->with(compact('active_status_id'))
                    ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
                    ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical)
                    ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
            }
        }
    }

    public function index_divisions($year_selected)
    {
        $username = auth()->user()->username;
        $user_id = auth()->user()->id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
        $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
        $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();
        $data = [
            'year_selected' => $year_selected,
            'division_id' => $user_division_id,
        ];
        $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();
        foreach ($user_roles as $row) {
            $user_roles_data[] = [
                'user_role' => $row->user_role,
                'user_role_id' => $row->role_id,
            ];
        }
        if ($emp_code == 'PS1286' || $emp_code == 'MOL001') {
            $user_division_id = '9';
            $user_division_acronym = 'FAD-DO';
            $division_acronym = 'FAD-DO';
        }
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
        $getLibraryPAP = LibraryPAPModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('pap_code')->get();
        $getLibraryActivities = LibraryActivityModel::where('division_id', $user_division_id)->orWhereNull('division_id')->where('is_active', 1)->where('is_deleted', 0)->orderBy('activity')->get();
        $getLibrarySubactivities = LibrarySubactivityModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('subactivity')->get();
        $getLibraryExpenseAccounts = LibraryExpenseAccountModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('expense_account')->get();
        $getLibraryObjectExpenditures = LibraryObjectExpenditureModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('object_expenditure')->get();
        $divisions_wofad = DivisionsModel::where('is_active', 1)->where('id', '!=', $user_division_id)->where('division_id', '!=', 5)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();
        $active_status_id = BpStatusModel::where('division_id', $user_division_id)->where('year', $year_selected)
            ->where('is_active', 1)->where('is_deleted', 0)->pluck('status_id')->first();
        if (isset(request()->url)) {
            return redirect(request()->url);
        } else {
            if (auth()->user()->hasAnyRole('Super Administrator|Administrator|Budget Officer')) {
                $title = 'Division Budget Proposals';
                $user_role = ViewUsersHasRolesModel::where('id', $user_id)
                    ->where(function ($query) {
                        $query->where('role_id', '!=', 5)
                            ->orWhere('role_id', '!=', 6)
                            ->orWhere('role_id', '!=', 8)
                            ->orWhere('role_id', '!=', 9)
                            ->orWhere('role_id', '!=', 7)
                            ->orWhere('role_id', '!=', 11);
                    })
                    ->pluck('user_role')->first();
                $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
                    ->where(function ($query) {
                        $query->where('role_id', '!=', 5)
                            ->orWhere('role_id', '!=', 6)
                            ->orWhere('role_id', '!=', 7)
                            ->orWhere('role_id', '!=', 8)
                            ->orWhere('role_id', '!=', 9)
                            ->orWhere('role_id', '!=', 11);
                    })
                    ->pluck('role_id')->first();
                $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();
                $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('year', $year_selected)->get();

                return view('budget_preparation.budget_proposals.division_tabs')
                    ->with(compact('title'), $title)
                    ->with(compact('data'), $data)
                    ->with(compact('data'), $data)
                    ->with(compact('username'), $username)
                    ->with(compact('user_id'), $user_id)
                    ->with(compact('user_role'))
                    ->with(compact('user_role_id'))
                    ->with(compact('user_roles'))
                    ->with(compact('user_roles_data'))
                    ->with(compact('user_division_id'), $user_division_id)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('user_fullname'), $user_fullname)
                    ->with(compact('divisions'), $divisions)
                    ->with(compact('divisions_wofad'))
                    ->with(compact('getLibraryPAP'), $getLibraryPAP)
                    ->with(compact('getLibraryActivities'), $getLibraryActivities)
                    ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
                    ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
                    ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
                    ->with(compact('year_selected'), $year_selected)
                    ->with(compact('years'), $years)
                    ->with(compact('active_status_id'))
                    ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
                    ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical)
                    ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
            } elseif (auth()->user()->hasAnyRole('BPAC Chair|Executive Director|BPAC')) {
                $title = 'Division Budget Proposals';
                $user_role = ViewUsersHasRolesModel::where('id', $user_id)
                    ->where(function ($query) {
                        $query->where('role_id', '=', 9)
                            ->orWhere('role_id', '=', 10)
                            ->orWhere('role_id', '=', 8);
                    })
                    ->pluck('user_role')->first();
                $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
                    ->where(function ($query) {
                        $query->where('role_id', '=', 9)
                            ->orWhere('role_id', '=', 10)
                            ->orWhere('role_id', '=', 8);
                    })
                    ->pluck('role_id')->first();
                // dd($user_role);
                $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();
                $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('year', $year_selected)->get();

                return view('budget_preparation.budget_proposals.division_tabs')
                    ->with(compact('title'), $title)
                    ->with(compact('data'), $data)
                    ->with(compact('data'), $data)
                    ->with(compact('username'), $username)
                    ->with(compact('user_id'), $user_id)
                    ->with(compact('user_role'))
                    ->with(compact('user_role_id'))
                    ->with(compact('user_roles'))
                    ->with(compact('user_roles_data'))
                    ->with(compact('user_division_id'), $user_division_id)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('user_fullname'), $user_fullname)
                    ->with(compact('divisions'), $divisions)
                    ->with(compact('divisions_wofad'))
                    ->with(compact('getLibraryPAP'), $getLibraryPAP)
                    ->with(compact('getLibraryActivities'), $getLibraryActivities)
                    ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
                    ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
                    ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
                    ->with(compact('year_selected'), $year_selected)
                    ->with(compact('years'), $years)
                    ->with(compact('active_status_id'))
                    ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
                    ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical)
                    ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
            }
            // Specific divisions under their cluster only
            elseif (auth()->user()->hasAnyRole('Cluster Budget Controller')) {
                // dd('Division Budget Proposals');
                $title = 'Division Budget Proposals';
                $user_role = ViewUsersHasRolesModel::where('id', $user_id)
                    ->where(function ($query) {
                        $query->where('role_id', '=', 5);
                    })
                    ->pluck('user_role')->first();
                $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
                    ->where(function ($query) {
                        $query->where('role_id', '!=', 5);
                    })
                    ->pluck('role_id')->first();
                // dd($user_role);
                $divisions = DivisionsModel::where('cluster_id', $user_division_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();
                $view_budget_proposal_items_byyear = ViewBudgetProposalsModel::where('division_id', $user_division_id)->where('year', $year_selected)->get();

                return view('budget_preparation.budget_proposals.division_tabs')
                    ->with(compact('title'), $title)
                    ->with(compact('data'), $data)
                    ->with(compact('username'), $username)
                    ->with(compact('user_id'), $user_id)
                    ->with(compact('user_role'))
                    ->with(compact('user_role_id'))
                    ->with(compact('user_roles'))
                    ->with(compact('user_roles_data'))
                    ->with(compact('user_role_id'), $user_role_id)
                    ->with(compact('user_division_id'), $user_division_id)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('user_fullname'), $user_fullname)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('divisions'), $divisions)
                    ->with(compact('divisions_wofad'))
                    ->with(compact('getLibraryPAP'), $getLibraryPAP)
                    ->with(compact('getLibraryActivities'), $getLibraryActivities)
                    ->with(compact('getLibrarySubactivities'), $getLibrarySubactivities)
                    ->with(compact('getLibraryExpenseAccounts'), $getLibraryExpenseAccounts)
                    ->with(compact('getLibraryObjectExpenditures'), $getLibraryObjectExpenditures)
                    ->with(compact('year_selected'), $year_selected)
                    ->with(compact('years'), $years)
                    ->with(compact('active_status_id'))
                    ->with(compact('fiscal_years_horizontal'), $fiscal_years_horizontal)
                    ->with(compact('fiscal_years_vertical'), $fiscal_years_vertical)
                    ->with(compact('view_budget_proposal_items_byyear'), $view_budget_proposal_items_byyear);
            }
        }
    }

    public function generatePDF(Request $request, $division_id, $year)
    {
        if ($request->ajax()) {
            $year = $request->year;
            view()->share('year', $year);
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('division_proposals.division_pdf')
                ->set_paper('letter', 'portait');

            return $pdf->stream();
        } else {
            return view('budget_preparation.budget_proposals.division_pdf')
                ->with('division_id', $division_id)
                ->with('year', $year);
        }
    }

    public function postAction(Request $request, User $user)
    {
        if ($request->ajax()) {
            $now = Carbon::now()->timezone('Asia/Manila')->format('Ymd.His');
            $created_at = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');
            $comment_by = $request->comment_by;
            $user_id = auth()->user()->id;
            $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
            $user_parent_division_id = ViewUsersModel::where('id', $user_id)->pluck('parent_division_id')->first();
            $status_id = $request->status_id;
            $user_role_id = $request->user_role_id;
            $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();
            if ($emp_code == 'PS1286' || $emp_code == 'MOL001') {
                $user_division_id = '9';
                $user_division_acronym = 'FAD-DO';
                $division_acronym = 'FAD-DO';
            }
            if ($request->add_budget_proposal == 1) { // adding budget proposal item
                $message = [
                    'pap_id.required' => 'Please select PAP.',
                    'activity_id.required' => 'Please select activity.',
                    'expense_account_id.required' => 'Please select expense account.',
                    'object_expenditure_id.required' => 'Please select object expenditure.',
                ];
                $validator = Validator::make($request->all(), [
                    'pap_id' => 'required',
                    'activity_id' => 'required',
                    'expense_account_id' => 'required',
                    'object_expenditure_id' => 'required',
                ], $message);

                $input = $request->all();
                if ($validator->passes()) {
                    $data = new BudgetProposalsModel([
                        'division_id' => $request->get('division_id'),
                        'year' => $request->get('year'),
                        'pap_id' => $request->get('pap_id'),
                        'activity_id' => $request->get('activity_id'),
                        'subactivity_id' => $request->get('subactivity_id'),
                        'expense_account_id' => $request->get('expense_account_id'),
                        'object_expenditure_id' => $request->get('object_expenditure_id'),
                        'object_specific_id' => $request->get('object_specific_id'),
                        'pooled_at_division_id' => $request->get('pooled_at_division_id'),
                        'fy1_amount' => $request->get('fy1_amount'),
                        'fy2_amount' => $request->get('fy2_amount'),
                        'fy3_amount' => $request->get('fy3_amount'),
                    ]);
                    $data->save();

                    return Response::json(['success' => '1']);
                }

                return Response::json(['errors' => $validator->errors()]);
                // return response()->json(array('success' => true), 200);
                // return Response::json(['errors' => $validator->errors()])->
                //    redirect()->route('division_proposals.index')->with(['submitted' => true]);
            } elseif ($status_id != '') {  // forward, receive, forward comment      status to
                $message = $request->message;
                $division_id = $request->division_id;
                $year = $request->year;
                // dd($status_id);
                // dd($division_acronym);

                // get user role id
                if ($status_id == 3) {
                    $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
                        ->where(function ($query) {
                            $query->where('role_id', '=', 6)
                                ->orWhere('role_id', '=', 11);
                        })
                        ->pluck('role_id')->first();
                } elseif ($status_id == 11 || $status_id == 12 || $status_id == 14) {
                    $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)
                        ->where(function ($query) {
                            $query->where('role_id', '=', 9);
                        })
                        ->pluck('role_id')->first();
                } else {
                    $user_role_id = ViewUsersHasRolesModel::where('id', $user_id)->pluck('role_id')->first();
                }

                // dd($user_role_id);

                // update comment to is_resolve=1
                if ($status_id == 2) {
                    $get_director_comments = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year)
                        ->where('is_active', 1)->where('is_deleted', 0)->where('is_resolved', 0)
                        ->where('comment_by', 'Division Director')->get();
                    $count_director_comments = $get_director_comments->count();
                    if ($count_director_comments > 0) {
                        foreach ($get_director_comments as $value) {
                            BpCommentsModel::where('budget_proposal_id', $value->budget_proposal_id)
                                ->update([
                                    'is_resolved' => '1',
                                ]);
                        }
                    }

                    $get_sectionhead_comments = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year)
                        ->where('is_active', 1)->where('is_deleted', 0)->where('is_resolved', 0)
                        ->where('comment_by', 'Section Head')->get();
                    $count_get_sectionhead_comments = $get_sectionhead_comments->count();
                    if ($count_get_sectionhead_comments > 0) {
                        foreach ($get_sectionhead_comments as $value) {
                            BpCommentsModel::where('budget_proposal_id', $value->budget_proposal_id)
                                ->update([
                                    'is_resolved' => '1',
                                ]);
                        }
                    }

                    $get_fad_budget_comments = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year)
                        ->where('is_active', 1)->where('is_deleted', 0)->where('is_resolved', 0)
                        ->where('comment_by', 'FAD-Budget')->get();
                    $count_fad_budget_comments = $get_fad_budget_comments->count();
                    if ($count_fad_budget_comments > 0) {
                        foreach ($get_fad_budget_comments as $value) {
                            BpCommentsModel::where('budget_proposal_id', $value->budget_proposal_id)
                                ->update([
                                    'is_resolved' => '1',
                                ]);
                        }
                    }

                    $get_bpac_comments = ViewBpCommentsModel::where('division_id', $division_id)->where('year', $year)
                        ->where('is_active', 1)->where('is_deleted', 0)->where('is_resolved', 0)
                        ->where('comment_by', 'BPAC')->get();
                    $count_bpac_comments = $get_bpac_comments->count();
                    if ($count_bpac_comments > 0) {
                        foreach ($get_bpac_comments as $value) {
                            BpCommentsModel::where('budget_proposal_id', $value->budget_proposal_id)
                                ->update([
                                    'is_resolved' => '1',
                                ]);
                        }
                    }
                }
                // notification for bpac chair
                if ($status_id == 10) {
                    $get_bpac_chair_user_id = ViewUsersHasRolesModel::where('role_id', 9)
                        ->where('id', '!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('id')->first();
                    $get_bpac_chair_division_id = ViewUsersHasRolesModel::where('role_id', 9)
                        ->where('id', '!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('division_id')->first();
                    if (isset($get_bpac_chair_user_id)) {
                        $notification_bpac_chair = new NotificationsModel([
                            'module_id' => '1',
                            'year' => $year,
                            'message' => $request->get('message'),
                            'link' => 'budget_preparation/budget_proposals/divisions/',
                            'division_id' => $division_id,
                            'division_id_from' => $user_division_id,
                            'division_id_to' => $get_bpac_chair_division_id,
                            'user_id_from' => $user_id,
                            'user_id_to' => $get_bpac_chair_user_id,
                            'user_role_id_from' => $user_role_id,
                            'user_role_id_to' => '9',
                        ]);
                        // dd($notification_bpac_chair);
                        $notification_bpac_chair->save();
                    }
                }
                // send email to bpac chair
                if ($status_id == 22) {
                    $get_bpac_chair_fullname = ViewUsersHasRolesModel::where('role_id', 9)->where('is_active', 1)->where('is_deleted', 0)->pluck('fullname_first')->first();
                    $get_bpac_chair_email = ViewUsersHasRolesModel::where('role_id', 9)->where('is_active', 1)->where('is_deleted', 0)->pluck('email')->first();
                    // dd($get_bpac_chair_email);
                    $bpac_data = [
                        'fullname' => $get_bpac_chair_fullname,
                        'internal_url' => url('http://192.168.0.11/fms/budget_preparation/budget_proposal/divisions/'.$year.'/'),
                        'external_url' => url('http://192.168.0.11/fms/budget_preparation/budget_proposal/divisions/'.$year.'/'),
                    ];
                    // dd($bpac_data);
                    Mail::to($get_bpac_chair_email)->send(new NotificationMail($bpac_data));
                }
                // notification for budget officer after bpac approval
                // if($status_id==12){
                //    $get_executive_director_user_id = ViewUsersHasRolesModel::where('role_id', 10)
                //       ->where('id','!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('id')->first();
                //    $get_executive_director_division_id = ViewUsersHasRolesModel::where('role_id', 10)
                //       ->where('id','!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('division_id')->first();
                //    if(isset($get_executive_director_user_id)){
                //       $notification_executive_director = new NotificationsModel([
                //          'module_id' => '2',
                //          'year' => $year,
                //          'message' => $message,
                //          'link' => 'budget_preparation/budget_proposals/divisions/',
                //          'division_id' => $division_id,
                //          'division_id_from' => $user_division_id,
                //          'division_id_to' => $get_executive_director_division_id,
                //          'user_id_from' => $user_id,
                //          'user_id_to' => $get_executive_director_user_id,
                //          'user_role_id_from' => $user_role_id ?? null,
                //          'user_role_id_to' => '10',
                //       ]);
                //       // dd($notification_executive_director);
                //       $notification_executive_director->save();
                //    }
                // }
                if (($status_id) == 21) {
                    // if (BpStatusModel::where('division_id', $division_id)->where('year', $year)->count() > 0) {
                    //    BpStatusModel::where('division_id', $division_id)->where('year', $year)->where('is_active', '1')
                    //    ->update([
                    //       'is_active' => '0'
                    //    ]);
                    // }

                    // $bp_status = new BpStatusModel([
                    //    'division_id' => $division_id,
                    //    'year' => $year,
                    //    'status_id' => '21',
                    //    'status_by_user_id' => $user_id,
                    //    'status_by_user_role_id' => $user_role_id ?? null,
                    //    'status_by_user_division_id' => $user_division_id,
                    //    'is_active' => '1',
                    // ]);
                    // $bp_status->save();

                    $allotment_status = new AllotmentStatusModel([
                        'division_id' => $division_id,
                        'year' => $year,
                        'status_id' => '22',
                        'status_by_user_id' => $user_id,
                        'status_by_user_role_id' => $user_role_id ?? null,
                        'status_by_user_division_id' => $user_division_id,
                        'is_active' => '1',
                    ]);
                    // dd($allotment_status);
                    $allotment_status->save();

                    //    $get_bp_ref = ViewBudgetProposalsModel::where('division_id', $division_id)
                    //       ->where('year', $year)->where('is_active',1)->where('is_deleted',0)->get();
                    //    foreach($get_bp_ref as $value){
                    //       $bp_data[] =[
                    //          'reference_bp_id' => $value->id,
                    //          'division_id' => $value->division_id,
                    //          'year' => $value->year,
                    //          'pap_id' => $value->pap_id,
                    //          'activity_id' => $value->activity_id,
                    //          'subactivity_id' => $value->subactivity_id ?? null,
                    //          'expense_account_id' => $value->expense_account_id,
                    //          'object_expenditure_id' => $value->object_expenditure_id,
                    //          'object_specific_id' => $value->object_specific_id ?? null,
                    //          'pooled_at_division_id' => $value->pooled_at_division_id ?? null,
                    //          'annual_amount' => $value->fy1_amount ?? null,
                    //       ];
                    //       // dd($bp_data);
                    //    }
                    //    ApprovedBudgetModel::insert($bp_data);
                }

                // notification for budget officer
                if ($status_id != 1 && $status_id != 2 && $status_id != 3 && $status_id != 4 && $status_id != 5) {
                    $get_budget_officer = ViewUsersHasRolesModel::where('role_id', 3)
                        ->where('id', '!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->get();
                    if ($get_budget_officer->count() != 0) {
                        foreach ($get_budget_officer as $value) {
                            $notification_budget_officer[] = [
                                'module_id' => '1',
                                'year' => $year,
                                'message' => $message,
                                'link' => 'budget_preparation/budget_proposals/divisions/',
                                'division_id' => $division_id,
                                'division_id_from' => $user_division_id,
                                'division_id_to' => $value->division_id,
                                'user_id_from' => $user_id,
                                'user_id_to' => $value->id,
                                'user_role_id_from' => $user_role_id ?? null,
                                'user_role_id_to' => '3',
                            ];
                        }
                        NotificationsModel::insert($notification_budget_officer);
                    }
                }

                // notification for division director or section head
                // dd($status_id!=1 || $status_id!=2 || $status_id!=3 || $status_id!=4||  $status_id!=5);
                if ($status_id != 1 || $status_id != 2 || $status_id != 3 || $status_id != 4 || $status_id != 5) {
                    // dd($user_parent_division_id == 5 && ($status_id==8 || $status_id==9) && $user_role_id!=3);
                    if ($user_parent_division_id == 5 && ($status_id == 8 || $status_id == 9) && $user_role_id != 3) {
                        $get_division_director = ViewUsersHasRolesModel::where('role_id', 6)->where('parent_division_id', $user_parent_division_id)
                            ->where('id', '!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('id')->first();
                    } else {
                        $get_division_director = ViewUsersHasRolesModel::where('role_id', 6)->where('division_id', $division_id)
                            ->where('id', '!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('id')->first();
                    }
                    // dd($get_division_director);
                    if (isset($get_division_director)) {
                        $notification_director = new NotificationsModel([
                            'module_id' => '2',
                            'year' => $year,
                            'message' => $message,
                            'link' => 'budget_preparation/budget_proposals/division/',
                            'division_id' => $division_id,
                            'division_id_from' => $user_division_id,
                            'division_id_to' => $division_id,
                            'user_id_from' => $user_id,
                            'user_id_to' => $get_division_director,
                            'user_role_id_from' => $user_role_id ?? null,
                            'user_role_id_to' => '6',
                        ]);
                        $notification_director->save();
                    }
                }

                if ($status_id != 21) {
                    // notification for division budget controller
                    $get_division_budget_controller = ViewUsersHasRolesModel::where('role_id', 7)->where('division_id', $division_id)
                        ->where('id', '!=', $user_id)->where('is_active', 1)->where('is_deleted', 0)->get();
                    if ($get_division_budget_controller->count() > 0) {
                        foreach ($get_division_budget_controller as $value) {
                            $notification_budget_controller[] = [
                                'module_id' => '2',
                                'year' => $year,
                                'message' => $message,
                                'link' => 'budget_preparation/budget_proposals/division/',
                                'division_id' => $division_id,
                                'division_id_from' => $user_division_id,
                                'division_id_to' => $value->division_id,
                                'user_id_from' => $user_id,
                                'user_id_to' => $value->id,
                                'user_role_id_from' => $user_role_id ?? null,
                                'user_role_id_to' => '7',
                            ];
                        }
                        NotificationsModel::insert($notification_budget_controller);
                    }

                    // for updating status
                    if (BpStatusModel::where('division_id', $division_id)->where('year', $year)->count() > 0) {
                        BpStatusModel::where('division_id', $division_id)->where('year', $year)->where('is_active', '1')
                            ->update([
                                'is_active' => '0',
                            ]);
                    }
                }

                $bp_status_data = new BpStatusModel([
                    'division_id' => $division_id,
                    'year' => $year,
                    'status_id' => $request->status_id,
                    'status_by_user_id' => $user_id,
                    'status_by_user_role_id' => $user_role_id,
                    'status_by_user_division_id' => $user_division_id,
                    'is_active' => '1',
                ]);
                $bp_status_data->save();

                return Response::json(['success' => '1']);
            } elseif ($comment_by != '') { // adding comments
                $data = new BpCommentsModel([
                    'division_id' => $request->comment_division_id,
                    'year' => $request->comment_year,
                    'budget_proposal_id' => $request->budget_proposal_id,
                    'comment' => $request->comment,
                    'comment_by' => $comment_by,
                    'comment_by_user_id' => $user_id,
                ]);
                // dd($data);
                $data->save();
                $data->id;

                return response()->json(['success' => 1, 'comment_id' => $data->id], 200);
            }
        }
    }

    public function show($id)
    {
        $data = ViewBudgetProposalsModel::find($id);
        if ($data->count()) {
            return Response::json([
                'status' => '1',
                'budget_proposals' => $data,
            ]);
        } else {
            return Response::json([
                'status' => '0',
            ]);
        }
    }

    public function update(Request $request, User $user)
    {
        if ($request->ajax()) {
            $comment_by = $request->comment_by;
            $comment_by_division_director = $request->comment_by_division_director;
            $comment_by_fad_budget = $request->comment_by_fad_budget;
            $comment_by_bpac = $request->comment_by_bpac;
            if ($request->edit_budget_proposal == 1) { // updating budget proposal item
                $message = [
                    'pap_id.required' => 'Please select PAP.',
                    'activity_id.required' => 'Please select activity.',
                    'expense_account_id.required' => 'Please select expense account.',
                    'object_expenditure_id.required' => 'Please select object expenditure.',
                ];
                $validator = Validator::make($request->all(), [
                    'pap_id' => 'required',
                    'activity_id' => 'required',
                    'expense_account_id' => 'required',
                    'object_expenditure_id' => 'required',
                ], $message);

                if ($validator->passes()) {
                    BudgetProposalsModel::find($request->get('id'))
                        ->update([
                            'pap_id' => $request->get('pap_id'),
                            'activity_id' => $request->get('activity_id'),
                            'subactivity_id' => $request->get('subactivity_id'),
                            'expense_account_id' => $request->get('expense_account_id'),
                            'object_expenditure_id' => $request->get('object_expenditure_id'),
                            'object_specific_id' => $request->get('object_specific_id'),
                            'pooled_at_division_id' => $request->get('pooled_at_division_id'),
                            'fy1_amount' => $request->get('fy1_amount'),
                            'fy2_amount' => $request->get('fy2_amount'),
                            'fy3_amount' => $request->get('fy3_amount'),
                        ]);

                    return Response::json([
                        'success' => '1',
                        'status' => '0',
                    ]);
                }

                return Response::json(['errors' => $validator->errors()]);
            } elseif ($comment_by != '') {
                // dd($request->comment_id);
                // dd(isset($comment_by_fad_budget));
                // dd(isset($comment_by_division_director));
                // dd(isset($comment_by_bpac));
                if (isset($comment_by_division_director)) {
                    $count = count($comment_by_division_director);
                    // dd($comment_by_division_director);
                    for ($i = 0; $i < $count; $i++) {
                        $data = [
                            'comment_by_division_director' => $comment_by_division_director[$i],
                        ];
                    }
                    $messages = [
                        'comment_by_division_director.required' => 'Please input comment.',
                    ];
                    $validator = Validator::make($data, [
                        'comment_by_division_director' => 'required',
                    ], $messages);
                    // dd($data);
                    if ($validator->passes()) {
                        // dd($request->comment_id);
                        $count = count($request->comment_id);
                        // dd($request->comment_id);
                        for ($i = 0; $i < $count; $i++) {
                            BpCommentsModel::find($request->comment_id[$i])
                                ->update([
                                    'comment' => $request->comment_by_division_director[$i],
                                ]);
                        }

                        return response()->json(['success' => 1, 200]);
                    }

                    return Response::json(['errors' => $validator->errors()]);
                } elseif (isset($comment_by_fad_budget)) {
                    $count = count($comment_by_fad_budget);
                    for ($i = 0; $i < $count; $i++) {
                        $data = [
                            'comment_by_fad_budget' => $comment_by_fad_budget[$i],
                        ];
                    }
                    $messages = [
                        'comment_by_fad_budget.required' => 'Please input comment.',
                    ];
                    $validator = Validator::make($data, [
                        'comment_by_fad_budget' => 'required',
                    ], $messages);
                    // dd($data);
                    if ($validator->passes()) {
                        $count = count($request->comment_id);
                        // dd($request->comment_id);
                        // dd($request->comment_by_fad_budget);
                        for ($i = 0; $i < $count; $i++) {
                            // dd($request->comment_id[$i]);
                            BpCommentsModel::find($request->comment_id[$i])
                                ->update([
                                    'comment' => $request->comment_by_fad_budget[$i],
                                ]);
                        }

                        return response()->json(['success' => 1, 200]);
                    }

                    return Response::json(['errors' => $validator->errors()]);
                } elseif (isset($comment_by_bpac)) {
                    $count = count($comment_by_bpac);
                    for ($i = 0; $i < $count; $i++) {
                        $data = [
                            'comment_by_bpac' => $comment_by_bpac[$i],
                        ];
                    }
                    $messages = [
                        'comment_by_bpac.required' => 'Please input comment.',
                    ];
                    $validator = Validator::make($data, [
                        'comment_by_bpac' => 'required',
                    ], $messages);
                    // dd($data);
                    if ($validator->passes()) {
                        $count = count($request->comment_id);
                        // dd($request->comment_id);
                        // dd($request->comment_by_fad_budget);
                        for ($i = 0; $i < $count; $i++) {
                            // dd($request->comment_id[$i]);
                            BpCommentsModel::find($request->comment_id[$i])
                                ->update([
                                    'comment' => $request->comment_by_bpac[$i],
                                ]);
                        }

                        return response()->json(['success' => 1, 200]);
                    }

                    return Response::json(['errors' => $validator->errors()]);
                } else {
                    return response()->json(['success' => 1, 200]);
                }
            }
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            if ($request->delete_budget_proposal == 1) { // updating budget proposal delete 1
                try {
                    BudgetProposalsModel::find($request->id)
                        ->update([
                            'is_deleted' => '1',
                        ]);
                } catch (\Exception $e) {
                    return Response::json([
                        'status' => '0',
                    ]);
                }
            } elseif ($request->delete_comment == 1) { // updating budget proposal comment delete 1
                try {
                    BpCommentsModel::find($request->id)
                        ->update([
                            'is_deleted' => '1',
                        ]);
                } catch (\Exception $e) {
                    return Response::json([
                        'status' => '0',
                    ]);
                }
            }
        }
    }

    public function update_comment(Request $request)
    {
        if ($request->ajax()) {
        }
    }

    public function show_comment($id)
    {
        $data = ViewBpCommentsModel::where('budget_proposal_id', $id)
            ->where('is_active', '1')->where('is_deleted', '0')->get();
        // dd($data);
        if ($data->count()) {
            return Response::json([
                'status' => '1',
                'comment' => $data,
                'rowCount' => $data->count(),
            ]);
        } else {
            return Response::json([
                'status' => '0',
            ]);
        }
    }
}
