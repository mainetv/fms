<?php

namespace App\Http\Controllers;

use App\Models\RCIModel;
use App\Models\ViewCheckDVModel;
use App\Models\ViewChecksIssuedModel;
use App\Models\ViewLibraryBankAccountsModel;
use App\Models\ViewRCIModel;
use App\Models\ViewUsersModel;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;

class RCIController extends Controller
{
    public function index(Request $request, $month_selected, $year_selected)
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
            'month_selected' => $month_selected,
            'year_selected' => $year_selected,
        ];
        if (isset(request()->url)) {
            return redirect(request()->url);
        } else {
            $title = 'RCI';

            return view('funds_utilization.rci.all')
                ->with(compact('title'), $title)
                ->with(compact('data'), $data)
                ->with(compact('username'), $username)
                ->with(compact('user_id'), $user_id)
                ->with(compact('user_role'), $user_role)
                ->with(compact('user_role_id'), $user_role_id)
                ->with(compact('user_division_id'), $user_division_id)
                ->with(compact('user_division_acronym'), $user_division_acronym)
                ->with(compact('user_fullname'), $user_fullname);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $message = [
                'bank_account_id.required' => 'Please select bank account no.',
                'rci_date.required' => 'Please select date.',
            ];
            $validator = Validator::make($request->all(), [
                'bank_account_id' => 'required',
                'rci_date' => 'required',
            ], $message);

            if ($validator->passes()) {
                $fund_id = ViewLibraryBankAccountsModel::where('id', $request->bank_account_id)
                    ->where('is_active', 1)->where('is_deleted', 0)->pluck('fund_id')->first();

                $month = $request->month;
                $year = $request->year;
                $bank_account_id = $request->bank_account_id;
                $suffix = DB::table('rci')
                    ->select(DB::raw('LPAD(SUBSTR(rci_no,9,2)+1,2,0) as rci_suffix_no'))->where('bank_account_id', $bank_account_id)
                    ->whereYear('rci_date', $year)->where('is_active', 1)->where('is_deleted', 0)
                    ->orderBY('rci_no', 'DESC')->orderBY('rci_suffix_no', 'DESC')->pluck('rci_suffix_no')->first();
                if ($suffix == 0 || $suffix == null) {
                    $suffix = '01';
                }
                $rci_no = $year.'-'.$month.'-'.$suffix;
                // dd($rci_no);
                $data = new RCIModel([
                    'rci_date' => $request->rci_date,
                    'rci_no' => $rci_no,
                    'fund_id' => $fund_id,
                    'bank_account_id' => $bank_account_id,
                ]);
                $data->save();
                $data->id;

                return Response::json(['success' => '1']);
            }

            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function show_rci_by_month_year(Request $request)
    {
        // dd($request->all());
        $month_selected = $request->month_selected;
        $year_selected = $request->year_selected;
        $search = $request->search;
        if ($request->ajax() && ($search == null || $search == '')) {
            $data = ViewRCIModel::whereMonth('rci_date', $month_selected)->whereYear('rci_date', $year_selected)
                ->where('is_active', 1)->where('is_deleted', 0)->orderBy('rci_date', 'ASC')->get();
        } elseif ($request->ajax() && ($search != null || $search != '')) {
            $data = ViewRCIModel::where('is_active', 1)->where('is_deleted', 0)
                ->where(function ($query) use ($search) {
                    $query->where('rci_no', 'like', '%'.$search.'%')
                        ->orWhere('id', 'like', '%'.$search.'%')
                        ->orWhere('rci_date', 'like', '%'.$search.'%')
                        ->orWhere('bank_account_no', 'like', '%'.$search.'%');
                })
                ->orderBy('rci_date', 'ASC')->get();
        }

        return DataTables::of($data)
            ->setRowAttr([
                'data-id' => function ($rci) {
                    return $rci->id;
                },
            ])
            ->addColumn('rci_no', function ($row) {
                $btn =
                   "<div>
                  <a data-id='".$row->id."' data-no='".$row->rci_no."' href='#' class='btn_load_checks'>
               ".$row->rci_no.'</a>
               </div>';

                return $btn;
            })
            ->addColumn('action', function ($row) {
                //   $btn =
                //      "<div>
                //         <button data-id='". $row->id ."' class='btn-xs btn_edit btn'
                //             type='button' data-toggle='tooltip' data-placement='left' title='Edit RCI'>
                //             <i class='fa-solid fa-edit green fa-lg'></i>
                //         </button>
                //         <button data-id='". $row->id ."' class='btn-xs btn_delete btn btn-outline-danger'
                //             type='button' data-toggle='tooltip' data-placement='left' title='Delete RCI'>
                //             <i class='fa-solid fa-trash-can fa-lg'></i>
                //         </button>
                //      </div>
                //      ";
                //   return $btn;
            })
            ->rawColumns(['rci_no'], ['action'])
            ->make(true);
    }

    public function show_check_dvs_by_rci(Request $request)
    {
        // dd($request->all());
        $rci_id = $request->rci_id;
        $search = $request->search;
        $rci_date = RCIModel::where('id', $rci_id)->pluck('rci_date')->first();
        $bank_account_id = RCIModel::where('id', $rci_id)->pluck('bank_account_id')->first();
        if ($request->ajax() && ($search == null || $search == '')) {
            $data = ViewCheckDVModel::where('check_date', $rci_date)
                ->where('bank_account_id', $bank_account_id)
                ->where('is_active', 1)->where('is_deleted', 0)->orderBy('check_no', 'ASC')->get();
        } elseif ($request->ajax() && ($search != null || $search != '')) {
            $data = ViewCheckDVModel::where('is_active', 1)->where('is_deleted', 0)
                ->where(function ($query) use ($search) {
                    $query->where('rci_no', 'like', '%'.$search.'%')
                        ->orWhere('id', 'like', '%'.$search.'%')
                        ->orWhere('rci_date', 'like', '%'.$search.'%')
                        ->orWhere('fund', 'like', '%'.$search.'%')
                        ->orWhere('bank_account_no', 'like', '%'.$search.'%');
                })
                ->orderBy('rci_no', 'ASC')->get();
        }

        return DataTables::of($data)
            ->setRowAttr([
                'data-id' => function ($checks) {
                    return $checks->id;
                },
            ])
            ->make(true);
    }

    public function print_rci(Request $request, $rci_id)
    {
        $rci_no = RCIModel::where('id', $rci_id)->pluck('rci_no')->first();
        $rci_date = RCIModel::where('id', $rci_id)->pluck('rci_date')->first();
        $fund_id = RCIModel::where('id', $rci_id)->pluck('fund_id')->first();
        $bank_account_id = RCIModel::where('id', $rci_id)->pluck('bank_account_id')->first();
        $rci_data = ViewChecksIssuedModel::where('check_date', $rci_date)
            ->where('fund_id', $fund_id)->where('bank_account_id', $bank_account_id)->get();

        // dd($rci_data);
        return \View::make('funds_utilization.rci.print_rci')
            ->with('rci_data', $rci_data)
            ->with('rci_no', $rci_no);
    }
}
