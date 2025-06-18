<?php

namespace App\Http\Controllers;

use App\Models\DivisionsModel;
use App\Models\DVModel;
use App\Models\FiscalYearsModel;
use App\Models\FundsModel;
use App\Models\LDDAPDVModel;
use App\Models\LDDAPModel;
use App\Models\LibraryBankAccountsModel;
use App\Models\NcaModel;
use App\Models\PaymentModesModel;
use App\Models\PrefixNumberModel;
use App\Models\ViewCheckDVModel;
use App\Models\ViewDVModel;
use App\Models\ViewLDDAPDVModel;
use App\Models\ViewLDDAPModel;
use App\Models\ViewLibrarySignatoriesModel;
use App\Models\ViewUsersModel;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;

class LDDAPController extends Controller
{
    public function index(Request $request, $fund_selected, $month_selected, $year_selected)
    {
        $user_role_id = auth()->user()->user_role_id;
        $username = auth()->user()->username;
        $user_id = auth()->user()->id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $user_division_acronym = ViewUsersModel::where('id', $user_id)->pluck('division_acronym')->first();
        $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
        $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
        $emp_code = ViewUsersModel::where('id', $user_id)->pluck('emp_code')->first();
        $data = [
            'fund_selected' => $fund_selected,
            'month_selected' => $month_selected,
            'year_selected' => $year_selected,
        ];
        $divisions = DivisionsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('division_acronym', 'asc')->get();
        $years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'ASC')->get();
        $getFunds = FundsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('fund')->get();
        $getNCA = NcaModel::where('fund_id', $fund_selected)->where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();
        if (isset(request()->url)) {
            return redirect(request()->url);
        } else {
            if (auth()->user()->hasAnyRole('Super Administrator|Administrator|Accounting Officer')) {
                $title = 'List of Due and Demandable Accounts Payable (LDDAP)';

                return view('funds_utilization.lddap.all')
                    ->with(compact('title'), $title)
                    ->with(compact('data'), $data)
                    ->with(compact('username'), $username)
                    ->with(compact('user_id'), $user_id)
                    ->with(compact('user_role'), $user_role)
                    ->with(compact('user_role_id'), $user_role_id)
                    ->with(compact('user_division_id'), $user_division_id)
                    ->with(compact('user_division_acronym'), $user_division_acronym)
                    ->with(compact('user_fullname'), $user_fullname)
                    ->with(compact('divisions'), $divisions)
                    ->with(compact('getFunds'), $getFunds)
                    ->with(compact('year_selected'), $year_selected)
                    ->with(compact('getNCA'), $getNCA)
                    ->with(compact('years'), $years);
            }
        }
    }

    public function add(Request $request)
    {
        $user_id = auth()->user()->id;
        $user_role_id = auth()->user()->user_role_id;
        $getFunds = FundsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('fund')->get();
        // $getFund = FundsModel::where('id', $fund_id)->where("is_active", 1)->where("is_deleted", 0)->pluck('fund')->first();
        $getLDDAP1Signatories = ViewLibrarySignatoriesModel::where('module_id', 7)
            ->where('signatory_no', 1)->where('is_active', 1)->where('is_deleted', 0)->orderBy('fullname_first')->get();
        $getLDDAP2Signatories = ViewLibrarySignatoriesModel::where('module_id', 7)
            ->where('signatory_no', 2)->where('is_active', 1)->where('is_deleted', 0)->orderBy('fullname_first')->get();
        $getLDDAPSignatories = ViewLibrarySignatoriesModel::where('module_id', 7)
            ->whereNull('signatory_no')->where('is_active', 1)->where('is_deleted', 0)->orderBy('fullname_first')->get();
        $getLDDAPSignatoriesD = ViewLibrarySignatoriesModel::where('module_id', 7)->where('is_active', 1)->where('is_deleted', 0)->orderBy('fullname_first')->get();
        $getPaymentModes = PaymentModesModel::where('is_active', 1)->where('is_deleted', 0)->get();
        $title = 'Add LDDAP';

        return view('funds_utilization.lddap.add')
            ->with(compact('user_id'))
            ->with(compact('user_role_id'))
            ->with(compact('title'))
           // ->with(compact('fund_id'))
           // ->with(compact('getFund'))
            ->with(compact('getLDDAP1Signatories'))
            ->with(compact('getLDDAP2Signatories'))
            ->with(compact('getLDDAPSignatories'))
            ->with(compact('getLDDAPSignatoriesD'))
            ->with(compact('getPaymentModes'))
            ->with(compact('getFunds'));
    }

    public function edit(Request $request)
    {
        $user_id = auth()->user()->id;
        $user_role_id = auth()->user()->user_role_id;
        $lddap_id = $request->id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $getLDDAPDetails = ViewLDDAPModel::where('id', $lddap_id)->where('is_active', 1)->where('is_deleted', 0)->get();
        $getFunds = FundsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('fund')->get();
        $getBankAccounts = LibraryBankAccountsModel::where('is_active', 1)->where('is_deleted', 0)->get();
        $getLDDAP1Signatories = ViewLibrarySignatoriesModel::where('module_id', 7)
            ->where('signatory_no', 1)->where('is_active', 1)->where('is_deleted', 0)->orderBy('fullname_first')->get();
        $getLDDAP2Signatories = ViewLibrarySignatoriesModel::where('module_id', 7)
            ->where('signatory_no', 2)->where('is_active', 1)->where('is_deleted', 0)->orderBy('fullname_first')->get();
        $getLDDAPSignatories = ViewLibrarySignatoriesModel::where('module_id', 7)
            ->whereNull('signatory_no')->where('is_active', 1)->where('is_deleted', 0)->orderBy('fullname_first')->get();
        $getLDDAPSignatoriesD = ViewLibrarySignatoriesModel::where('module_id', 7)->where('is_active', 1)->where('is_deleted', 0)->orderBy('fullname_first')->get();
        $getAttachedDVbyLDDAP = ViewLDDAPDVModel::where('lddap_id', $lddap_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'asc')->get();
        $title = 'Edit LDDAP';

        // dd($getAttachedDVbyLDDAP);
        return view('funds_utilization.lddap.edit')
            ->with(compact('user_id'))
            ->with(compact('user_role_id'))
            ->with(compact('title'))
            ->with(compact('getLDDAPDetails'))
            ->with(compact('getLDDAP1Signatories'))
            ->with(compact('getLDDAPSignatories'))
            ->with(compact('getLDDAPSignatoriesD'))
            ->with(compact('getLDDAP2Signatories'))
            ->with(compact('getFunds'))
            ->with(compact('getAttachedDVbyLDDAP'))
            ->with(compact('getBankAccounts'))
            ->with(compact('user_division_id'));
    }

    public function view_check(Request $request)
    {
        $user_id = auth()->user()->id;
        $user_role_id = auth()->user()->user_role_id;
        $check_id = $request->id;
        $getCheckDV = ViewCheckDVModel::where('id', $check_id)->where('is_active', 1)->where('is_deleted', 0)->get();
        $title = 'View Check';

        return view('funds_utilization.checks.view')
            ->with(compact('user_id'))
            ->with(compact('user_role_id'))
            ->with(compact('title'))
            ->with(compact('getCheckDV'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $signatory1 = $request->signatory1;
            $signatory2 = $request->signatory2;
            $signatory3 = $request->signatory3;
            $signatory4 = $request->signatory4;
            $signatory5 = $request->signatory5;
            $get_signatory1_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory1)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            $get_signatory2_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory2)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            $get_signatory3_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory3)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            $get_signatory4_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory4)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            $get_signatory5_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory5)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            if ($request->add_lddap == 1) {
                $message = [
                    'lddap_date.required' => 'Please select lddap date.',
                    'payment_mode_id.required' => 'Please select payment mode.',
                    'fund_id.required' => 'Please select fund.',
                    'bank_account_id.required' => 'Please select bank account no.',
                ];
                $validator = Validator::make($request->all(), [
                    'lddap_date' => 'required',
                    'payment_mode_id' => 'required',
                    'fund_id' => 'required',
                    'bank_account_id' => 'required',
                ], $message);

                if ($validator->passes()) {
                    $data = new LDDAPModel([
                        'lddap_date' => $request->get('lddap_date'),
                        'lddap_no' => $request->get('lddap_no'),
                        'payment_mode_id' => $request->get('payment_mode_id'),
                        'fund_id' => $request->get('fund_id'),
                        'nca_no' => $request->get('nca_no'),
                        'bank_account_id' => $request->get('bank_account_id'),
                        // 'check_no' => $request->get('check_no'),
                        'acic_no' => $request->get('acic_no'),
                        'total_lddap_amount' => $request->get('total_lddap_amount'),
                        'signatory1' => $signatory1,
                        'signatory1_position' => $get_signatory1_position,
                        'signatory2' => $signatory2,
                        'signatory2_position' => $get_signatory2_position,
                        'signatory3' => $signatory3,
                        'signatory3_position' => $get_signatory3_position,
                        'signatory4' => $signatory4,
                        'signatory4_position' => $get_signatory4_position,
                        'signatory5' => $signatory5,
                        'signatory5_position' => $get_signatory5_position,
                    ]);
                    $data->save();
                    $data->id;

                    return response()->json(['success' => 1, 'redirect_url' => route('lddap.edit', [$data->id])], 200);
                }

                return Response::json(['errors' => $validator->errors()]);
            }
        }
    }

    public function show(Request $request)
    {
        $data = ViewDVModel::find($request->id);
        // dd($data);
        if ($data->count()) {
            return Response::json([
                'status' => '1',
                'dv' => $data,
            ]);
        } else {
            return Response::json([
                'status' => '0',
            ]);
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $dv_id = $request->dv_id;
            $lddap_id = $request->lddap_id;
            $payee_id = $request->payee_id;
            $total_lddap_amount = removeComma($request->total_lddap_amount);
            $signatory1 = $request->signatory1;
            $signatory2 = $request->signatory2;
            $signatory3 = $request->signatory3;
            $signatory4 = $request->signatory4;
            $signatory5 = $request->signatory5;
            $get_signatory1_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory1)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            $get_signatory2_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory2)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            $get_signatory3_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory3)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            $get_signatory4_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory4)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            $get_signatory5_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory5)
                ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
            if ($request->edit_lddap == 1) {
                $message = [
                    'lddap_date.required' => 'Please select lddap date.',
                    'fund_id.required' => 'Please select fund.',
                    'bank_account_id.required' => 'Please select bank account no.',
                ];
                $validator = Validator::make($request->all(), [
                    'lddap_date' => 'required',
                    'fund_id' => 'required',
                    'bank_account_id' => 'required',
                ], $message);

                if ($validator->passes()) {
                    LDDAPModel::find($lddap_id)
                        ->update([
                            'lddap_date' => $request->get('lddap_date'),
                            'lddap_no' => $request->get('lddap_no'),
                            'fund_id' => $request->get('fund_id'),
                            'nca_no' => $request->get('nca_no'),
                            'bank_account_id' => $request->get('bank_account_id'),
                            'check_no' => $request->get('check_no'),
                            'acic_no' => $request->get('acic_no'),
                            'total_lddap_amount' => $total_lddap_amount,
                            'signatory1' => $signatory1,
                            'signatory1_position' => $get_signatory1_position,
                            'signatory2' => $signatory2,
                            'signatory2_position' => $get_signatory2_position,
                            'signatory3' => $signatory3,
                            'signatory3_position' => $get_signatory3_position,
                            'signatory4' => $signatory4,
                            'signatory4_position' => $get_signatory4_position,
                            'signatory5' => $signatory5,
                            'signatory5_position' => $get_signatory5_position,
                        ]);
                    $get_total_lddap_gross_amount = ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                        ->where('is_active', 1)->where('is_deleted', 0)->sum('total_dv_gross_amount');
                    $get_total_lddap_net_amount = ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                        ->where('is_active', 1)->where('is_deleted', 0)->sum('total_dv_net_amount');
                    // dd($get_total_lddap_net_amount);
                    LDDAPModel::find($lddap_id)
                        ->update([
                            'total_lddap_gross_amount' => $get_total_lddap_gross_amount,
                            'total_lddap_net_amount' => $get_total_lddap_net_amount,
                        ]);

                    return response()->json(['success' => 1, 200]);
                }

                return Response::json(['errors' => $validator->errors()]);
            } elseif ($request->attach_update_dv == 1) {
                if (isset($dv_id)) {
                    // dd($request->all());
                    DVModel::find($dv_id)
                        ->update([
                            'lddap_id' => $lddap_id,
                        ]);

                    $data = new LDDAPDVModel([
                        'lddap_id' => $lddap_id,
                        'dv_id' => $dv_id,
                    ]);
                    $data->save();

                    $get_total_lddap_gross_amount = ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                        ->where('is_active', 1)->where('is_deleted', 0)->sum('total_dv_gross_amount');
                    $get_total_lddap_net_amount = ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                        ->where('is_active', 1)->where('is_deleted', 0)->sum('total_dv_net_amount');
                    // dd($get_total_lddap_gross_amount);

                    LDDAPModel::find($lddap_id)
                        ->update([
                            'total_lddap_gross_amount' => $get_total_lddap_gross_amount,
                            'total_lddap_net_amount' => $get_total_lddap_net_amount,
                        ]);
                }

                return response()->json(['success' => 1, 200]);
            } elseif ($request->replace_payee_bank_account == 1) {
                if (isset($dv_id)) {
                    DVModel::find($dv_id)
                        ->update([
                            'payee_id' => $payee_id,
                        ]);
                }

                return response()->json(['success' => 1, 200]);
            }
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $id = $request->id;
            $dv_id = $request->dv_id;
            $lddap_id = $request->lddap_id;
            if ($request->delete_lddap == 1) {
                try {
                    LDDAPModel::find($id)
                        ->update([
                            'is_deleted' => '1',
                        ]);
                } catch (\Exception $e) {
                    return Response::json([
                        'status' => '0',
                    ]);
                }
            } elseif ($request->remove_attached_dv == 1) {
                try {
                    DVModel::find($dv_id)
                        ->update([
                            'lddap_id' => null,
                        ]);

                    LDDAPDVModel::find($id)
                        ->update([
                            'is_deleted' => 1,
                        ]);

                    $get_total_lddap_gross_amount = ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                        ->where('is_active', 1)->where('is_deleted', 0)->sum('total_dv_gross_amount');
                    $get_total_lddap_net_amount = ViewLDDAPDVModel::where('lddap_id', $lddap_id)
                        ->where('is_active', 1)->where('is_deleted', 0)->sum('total_dv_net_amount');

                    LDDAPModel::find($lddap_id)
                        ->update([
                            'total_lddap_gross_amount' => $get_total_lddap_gross_amount,
                            'total_lddap_net_amount' => $get_total_lddap_net_amount,
                        ]);

                } catch (\Exception $e) {
                    return Response::json([
                        'status' => '0',
                    ]);
                }
            }
        }
    }

    public function show_lddap_by_fund_month_year(Request $request)
    {
        $fund_selected = $request->fund_selected;
        $month_selected = $request->month_selected;
        $year_selected = $request->year_selected;
        $search = $request->search;
        if ($request->ajax() && ($search == null || $search == '')) {
            $data = ViewLDDAPModel::where('fund_id', $fund_selected)->whereMonth('lddap_date', $month_selected)->whereYear('lddap_date', $year_selected)
                ->where('is_active', 1)->where('is_deleted', 0)->orderBy('lddap_no', 'ASC')->get();
        } elseif ($request->ajax() && ($search != null || $search != '')) {
            $data = ViewLDDAPModel::where(function ($query) use ($search) {
                $query->where('ada_no', 'like', '%'.$search.'%')
                    ->orWhere('id', 'like', '%'.$search.'%')
                    ->orWhere('lddap_date', 'like', '%'.$search.'%')
                    ->orWhere('lddap_no', 'like', '%'.$search.'%');
            })
                ->where('fund_id', $fund_selected)->where('is_active', 1)->where('is_deleted', 0)->orderBy('lddap_no', 'ASC')->get();
        }

        return DataTables::of($data)
            ->setRowAttr([
                'data-id' => function ($lddap) {
                    return $lddap->id;
                },
            ])
            ->addColumn('lddap_no', function ($row) {
                $btn =
                   "<a data-id='".$row->id."' href='".url('funds_utilization/lddap/edit/'.$row->id)."'>
               ".$row->lddap_no.'</a>';

                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn =
                   "<div>               
                  <button data-id='".$row->id."' class='btn-xs btn_delete btn btn-outline-danger' 
                     type='button' data-toggle='tooltip' data-placement='left' title='Delete LDDAP'>
                     <i class='fa-solid fa-trash-can fa-lg'></i>
                  </button>
               </div>
               ";

                return $btn;
            })
            ->rawColumns(['lddap_no'], ['action'])
            ->make(true);
    }

    public function generate_lddap_no(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $now = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');
            $lddap_id = $request->lddap_id;
            $month = $request->month;
            $year = $request->year;
            $fund_id = $request->fund_id;
            $add_lddap = $request->add_lddap;
            $prefix_code = PrefixNumberModel::where('fund_id', $fund_id)->where('is_active', 1)->where('is_deleted', 0)->pluck('prefix_code')->first();
            $suffix = DB::table('view_lddap')
                ->select(DB::raw('LPAD(CONVERT(SUBSTR(lddap_no,13,10),UNSIGNED INTEGER)+1,4,0) AS lddap_suffix_no'))
                ->whereRaw('LENGTH(lddap_no) > 17')->whereYear('lddap_date', $year)
                ->where('fund_id', $fund_id)->where('is_active', 1)->where('is_deleted', 0)
                ->orderBY('lddap_suffix_no', 'DESC')->pluck('lddap_suffix_no')->first();
            if ($suffix == 0 || $suffix == null) {
                $suffix = '0001';
            }
            $lddap_no = $prefix_code.'-'.$month.'-'.$suffix.'-'.$year;
            // dd($lddap_no);
            if ($add_lddap == 1) {
                $signatory1 = $request->signatory1;
                $signatory2 = $request->signatory2;
                $signatory3 = $request->signatory3;
                $signatory4 = $request->signatory4;
                $signatory5 = $request->signatory5;
                $get_signatory1_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory1)
                    ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
                $get_signatory2_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory2)
                    ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
                $get_signatory3_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory3)
                    ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
                $get_signatory4_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory4)
                    ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
                $get_signatory5_position = ViewLibrarySignatoriesModel::where('fullname_first', $signatory5)
                    ->where('is_active', 1)->where('is_deleted', 0)->pluck('position')->first();
                $data = new LDDAPModel([
                    'lddap_date' => $request->get('lddap_date'),
                    'lddap_no' => $lddap_no,
                    'payment_mode_id' => $request->get('payment_mode_id'),
                    'fund_id' => $request->get('fund_id'),
                    'nca_no' => $request->get('nca_no'),
                    'bank_account_id' => $request->get('bank_account_id'),
                    'acic_no' => $request->get('acic_no'),
                    'total_lddap_amount' => $request->get('total_lddap_amount'),
                    'signatory1' => $signatory1,
                    'signatory1_position' => $get_signatory1_position,
                    'signatory2' => $signatory2,
                    'signatory2_position' => $get_signatory2_position,
                    'signatory3' => $signatory3,
                    'signatory3_position' => $get_signatory3_position,
                    'signatory4' => $signatory4,
                    'signatory4_position' => $get_signatory4_position,
                    'signatory5' => $signatory5,
                    'signatory5_position' => $get_signatory5_position,
                ]);
                // dd($data);
                $data->save();
                $data->id;

                return response()->json(['success' => 1, 'redirect_url' => route('lddap.edit', [$data->id])], 200);
            } else {
                LDDAPModel::find($lddap_id)
                    ->update([
                        'lddap_no' => $lddap_no,
                        'is_locked' => 1,
                        'locked_at' => $now,
                    ]);

                return response()->json(['success' => 1, 200]);
            }
        }
    }

    public function print_lddap($lddap_id)
    {
        $lddap_data = ViewLDDAPModel::where('id', $lddap_id)->get();
        $lddap_dv = ViewLDDAPDVModel::where('lddap_id', $lddap_id)->where('is_active', 1)->where('is_deleted', 0)->orderBY('id', 'asc')->get();
        $now = Carbon::now()->setTimezone('Asia/Manila')->format('l jS \of F Y h:i:s A');

        return \View::make('funds_utilization.lddap.print_lddap')
            ->with('now', $now)
            ->with('lddap_data', $lddap_data)
            ->with('lddap_dv', $lddap_dv);
    }

    public function print_lddap_ada_summary($lddap_id)
    {
        $lddap_data = ViewLDDAPModel::where('id', $lddap_id)->get();
        $lddap_dv = ViewDVModel::where('lddap_id', $lddap_id)->where('is_active', 1)->where('is_deleted', 0)->get();

        return \View::make('funds_utilization.lddap.print_lddap_ada_summary')
            ->with('lddap_data', $lddap_data)
            ->with('lddap_dv', $lddap_dv);
    }
}
