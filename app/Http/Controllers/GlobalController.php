<?php

namespace App\Http\Controllers;

use App\Models\DivisionsModel;
use App\Models\BpForm3Model;
use App\Models\BpForm4Model;
use App\Models\BpForm5Model;
use App\Models\EmployeesModel;
use App\Models\FiscalYearsModel;
use App\Models\LibraryActivityModel;
use App\Models\LibraryBankAccountsModel;
use App\Models\LibraryExpenseAccountModel;
use App\Models\LibraryObjectExpenditureModel;
use App\Models\LibraryObjectSpecificModel;
use App\Models\LibraryPAPModel;
use App\Models\LibraryPayeesModel;
use App\Models\LibrarySubactivityModel;
use App\Models\NotificationsModel;
use App\Models\RSModel;
use App\Models\User;
use App\Models\UserRolesModel;
use App\Models\ViewAudit;
use App\Models\ViewEmployeePositionModel;
use App\Models\ViewLibraryBankAccountsModel;
use App\Models\ViewLibraryPayeesBankAccountsModel;
use App\Models\ViewLibraryPayeesModel;
use App\Models\ViewLibrarySignatoriesModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewRSModel;
use App\Models\ViewRsPapModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Response;
use DataTables;

class GlobalController extends Controller
{
   public function listPayees(Request $request)
   {
      if ($request->ajax()) {
         $data = LibraryPayeesModel::with([
            'payeeType',
            'bank',
         ])
            ->get()
            ->map(function ($payee) {
               $payee->payeeWasUsed = $payee->rsRecords()->exists() || $payee->dvRecords()->exists();
               return $payee;
            });
      } else {
         $data = collect();
      }

      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function ($row) {
               return $row->id;
            }
         ])
         ->make(true);
   }

   public function searchPayeeFirstName(Request $request)
   {
      $searchTerm = trim($request->input('term'));

      $matches = LibraryPayeesModel::where('payee', 'LIKE', $searchTerm . '%')
         ->where('payee_type_id', 1)->where('is_verified', 1)->where('is_deleted', 0)
         ->selectRaw('payee, MIN(parent_id) as parent_id, first_name, middle_initial, last_name, tin,
            address, office_address, email_address, contact_no')
         ->groupBy('payee')
         ->distinct()
         ->limit(10)
         ->get();

      $response = $matches->map(function ($payee) {
         return [
            'first_name' => $payee->first_name,
            'middle_initial' => $payee->middle_initial,
            'last_name' => $payee->last_name,
            // 'tin' => $payee->tin,
            // 'address' => $payee->address,
            // 'office_address' => $payee->office_address,
            // 'email_address' => $payee->email_address,
            // 'contact_no' => $payee->contact_no,
            'label' => $payee->payee,
            'value' => $payee->payee,
            'parent_id' => $payee->parent_id
         ];
      });

      return response()->json($response);
   }

   public function searchPayeeOrganization(Request $request)
   {
      $searchTerm = trim($request->input('term'));

      $matches = LibraryPayeesModel::where('payee', 'LIKE', $searchTerm . '%')
         ->where('payee_type_id', 2)->where('is_verified', 1)->where('is_deleted', 0)
         ->selectRaw('payee, MIN(parent_id) as parent_id, organization_name, organization_acronym')
         ->groupBy('payee')
         ->distinct()
         ->limit(10) // Limit results to 10
         ->get();

      $response = $matches->map(function ($payee) {
         return [
            'organization_name' => $payee->organization_name,
            'organization_acronym' => $payee->organization_acronym,
            'label' => $payee->payee,
            'value' => $payee->payee,
            'parent_id' => $payee->parent_id
         ];
      });

      return response()->json($response);
   }

   public function searchPayee(Request $request)
   {
      if ($request->ajax()) {
         $action = $request->action ?? 'clear';
         $query = LibraryPayeesModel::with(['payeeType', 'bank']);

         if($action == 'all'){
            $results = $query->get();
         }           
         elseif ($action == 'unverified') {
            $results = $query->where('is_verified', 0)->get();              
         }
         elseif ($action == 'search') {
            $searchTerm = trim($request->search);
            if (empty($searchTerm)) {
               return DataTables::of(collect([]))->make(true);
            }
            $numericSearch = preg_replace('/[^0-9]/', '', $searchTerm);

            $query = LibraryPayeesModel::with(['payeeType', 'bank']);
            if (is_numeric($numericSearch) && !empty($numericSearch)) {
               $query->where(function ($q) use ($numericSearch) {
                  $q->whereRaw("REPLACE(tin, '-', '') LIKE ?", ["%{$numericSearch}%"])
                     ->orWhereRaw("REPLACE(bank_account_no, '-', '') LIKE ?", ["%{$numericSearch}%"]);
               });
            }
            else {
               $query->where(function ($q) use ($searchTerm) {
                  $q->where('payee', 'LIKE', "%{$searchTerm}%")
                     ->orWhere('bank_account_name', 'LIKE', "%{$searchTerm}%");
               });
            }
            $results = $query->get();
         }
         elseif ($action === 'clear') {
            return DataTables::of(collect([]))->make(true);
         } 
         else {
            return DataTables::of(collect([]))->make(true);
         }

         if (in_array($action, ['search', 'unverified']) && $results->isNotEmpty()) {
            if ($results->isNotEmpty()) {
               $parentIds = $results->pluck('parent_id')->filter()->unique()->toArray();

               if (!empty($parentIds)) {
                  $relatedPayees = LibraryPayeesModel::with(['payeeType', 'bank'])
                     ->whereIn('parent_id', $parentIds)
                     ->get()
                     ->map(function ($payee) {
                        $payee->payeeWasUsed = $payee->rsRecords()->exists() || $payee->dvRecords()->exists();
                        return $payee;
                     });

                  return DataTables::of($relatedPayees)
                     ->setRowAttr([
                        'data-id' => function ($row) {
                           return $row->id;
                        }
                     ])
                     ->make(true);
               }
            }
         }         

         return DataTables::of($results)
            ->setRowAttr([
               'data-id' => function ($row) {
                  return $row->id;
               }
            ])
            ->make(true);
      }
   }

   public function listUserAccounts(Request $request)
   {
      if ($request->ajax()) {
         if ($request->ajax()) {
            $users = User::with(['roles', 'userDetails'])->get();

            return DataTables::of($users)
               ->addColumn('user_roles', fn($u) => $u->roles->pluck('name')->join(', '))
               ->addColumn('full_name', fn($u) => $u->userDetails ? "{$u->userDetails->lname}, {$u->userDetails->fname} {$u->userDetails->mname}" : '')
               ->addColumn('division', fn($u) => $u->userDetails->division_acro ?? '')
               ->addColumn('email', fn($u) => $u->email ?? '')
               ->addColumn('username', fn($u) => $u->username ?? '')
               ->setRowAttr([
                  'data-id' => fn($u) => $u->id
               ])
               ->make(true);
         }
      }
   }

   public function listPayeesByBankAccountNo(Request $request)
   {
      $bank_account_number = preg_replace('/[^0-9]/', '', $request->bank_account_number);
      if ($request->ajax() && isset($bank_account_number)) {
         // Find the record with the matching bank account number
         $matchedRecord = LibraryPayeesModel::whereRaw("REPLACE(bank_account_no, '-', '') = ?", [$bank_account_number])->first();

         if ($matchedRecord) {
            // Get all records that share the same parent_id as the matched record
            $data = LibraryPayeesModel::with([
               'payeeType',
               'bank',
            ])
               ->where('parent_id', $matchedRecord->parent_id)
               ->orWhereRaw("REPLACE(bank_account_no, '-', '') = ?", [$bank_account_number])
               ->get()
               ->map(function ($payee) {
                  // Check if the payee was used in RSModel or DVModel
                  $payee->payeeWasUsed = $payee->rsRecords()->exists() || $payee->dvRecords()->exists();
                  return $payee;
               });
         } else {
            $data = collect(); // Return an empty collection if no match is found
         }

         return DataTables::of($data)
            ->setRowAttr([
               'data-id' => function ($row) {
                  return $row->id;
               }
            ])
            ->make(true);
      }
   }

   public function audit_trail(Request $request)
   {
      $user_id = auth()->user()->id;
      $user_role_id = $request->user_role_id;
      $title = 'audit_trail';
      return view('audit_trail')
         ->with(compact('user_role_id'))
         ->with(compact('user_id'))
         ->with(compact('title'));
   }

   public function show_audits_by_filter(Request $request)
   {
      $query = ViewAudit::whereBetween('created_at', [$request->start_date, $request->end_date]);
      if ($request->type !== 'All') {
         $query->where('auditable_type', $request->type);
      }

      $data = $query->get();
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function ($audit) {
               return $audit->id;
            }
         ])
         ->make(true);
   }

   public function timeline(Request $request)
   {
      $user_id = auth()->user()->id;
      $user_role_id = $request->user_role_id;
      $title = 'timeline';
      return view('timeline')
         ->with(compact('user_role_id'))
         ->with(compact('user_id'))
         ->with(compact('title'));
   }

   public function show_timeline_by_filter(Request $request)
   {
      $query = ViewAudit::whereBetween('created_at', [$request->start_date, $request->end_date]);
      if ($request->type !== 'All') {
         $query->where('auditable_type', $request->type);
      }

      $data = $query->get();
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function ($audit) {
               return $audit->id;
            }
         ])
         ->make(true);
   }

   public function show_sidemenu_by_user_role(Request $request)
   {
      $user_id = auth()->user()->id;
      $user_role_id = $request->user_role_id;
      Session::put('set_user_role_id', $user_role_id);
      if ($user_role_id == 3) {
         $title = "";
         return view('layouts.side_navigations.budget')
            ->with(compact('title'))
            ->with(compact('user_role_id'))
            ->with(compact('user_id'));
      } else if ($user_role_id == 6) {
         $title = "";
         return view('layouts.side_navigations.division_director')
            ->with(compact('title'))
            ->with(compact('user_role_id'))
            ->with(compact('user_id'));
      } else if ($user_role_id == 7) {
         $title = "";
         return view('layouts.side_navigations.division_budget_controller')
            ->with(compact('title'))
            ->with(compact('user_role_id'))
            ->with(compact('user_id'));
      }
   }

   public function administration(Request $request)
   {
      // dd('administration');
      $title = "Administration";
      $username = auth()->user()->username;
      $user_id = auth()->user()->id;
      $user_role_id = auth()->user()->user_role_id;
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();
      foreach ($user_roles as $row) {
         $user_roles_data[] = [
            "user_role" => $row->user_role,
            "user_role_id" => $row->role_id,
         ];
      }
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
      $user_roles = UserRolesModel::where('is_active', '1')->where('is_deleted', '0')->get();
      $view_users = ViewUsersModel::where('is_active', '1')->where('is_deleted', '0')->get();
      $employees = EmployeesModel::whereNotIn('employment_id', [9, 10, 12, 16])->orderBy('lname', 'ASC')->get();
      $employeesperdiv = EmployeesModel::where('division', $user_division_id)
         ->whereNotIn('employment_id', [9, 10, 12, 16])->orderBy('lname', 'ASC')->get();
      // dd($view_users);
      return view('administration.index')
         ->with(compact('title'), $title)
         ->with(compact('username'), $username)
         ->with(compact('user_id'), $user_id)
         ->with(compact('user_role'), $user_role)
         ->with(compact('user_roles'))
         ->with(compact('user_role_id'), $user_role_id)
         ->with(compact('user_roles'), $user_roles)
         ->with(compact('user_division_id'), $user_division_id)
         ->with(compact('user_fullname'), $user_fullname)
         ->with(compact('view_users'), $view_users)
         ->with(compact('employees'), $employees)
         ->with(compact('employeesperdiv'), $employeesperdiv);
   }

   public function libraries(Request $request)
   {
      $title = "Libraries";
      $username = auth()->user()->username;
      $user_id = auth()->user()->id;
      $user_role_id = auth()->user()->user_role_id;
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();
      foreach ($user_roles as $row) {
         $user_roles_data[] = [
            "user_role" => $row->user_role,
            "user_role_id" => $row->role_id,
         ];
      }
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
      $library_paps = LibraryPAPModel::where('is_deleted', 0)->get();
      $library_activities = LibraryActivityModel::where('is_deleted', 0)->get();
      $library_subactivities = LibrarySubactivityModel::where('is_deleted', 0)->get();
      $library_expense_accounts = LibraryExpenseAccountModel::where('is_deleted', 0)->get();
      $library_expenditures = LibraryObjectExpenditureModel::where('is_deleted', 0)->get();
      $library_specifics = LibraryObjectSpecificModel::where('is_deleted', 0)->get();
      // $view_users = ViewUsersModel::where('is_active', '1')->where('is_deleted', '0')->get();
      // dd($view_users);
      return view('libraries.index')
         ->with(compact('title'), $title)
         ->with(compact('username'), $username)
         ->with(compact('user_id'), $user_id)
         ->with(compact('user_role'), $user_role)
         ->with(compact('user_roles'))
         ->with(compact('user_role_id'), $user_role_id)
         ->with(compact('user_fullname'), $user_division_id)
         ->with(compact('user_division_id'), $user_fullname)
         ->with(compact('library_paps'), $library_paps)
         ->with(compact('library_activities'), $library_activities)
         ->with(compact('library_subactivities'), $library_subactivities)
         ->with(compact('library_expense_accounts'), $library_expense_accounts)
         ->with(compact('library_expenditures'), $library_expenditures)
         ->with(compact('library_specifics'), $library_specifics);
   }

   public function budget_maintenance(Request $request)
   {
      $title = "Maintenance";
      $username = auth()->user()->username;
      $user_id = auth()->user()->id;
      $user_role_id = auth()->user()->user_role_id;
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();
      foreach ($user_roles as $row) {
         $user_roles_data[] = [
            "user_role" => $row->user_role,
            "user_role_id" => $row->role_id,
         ];
      }
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
      $view_users = ViewUsersModel::where('is_active', '1')->where('is_deleted', '0')->get();
      $divisions = DivisionsModel::where("is_active", 1)->where("is_deleted", 0)->where("is_section", 0)->orderBy('division_acronym', 'asc')->get();
      $fiscal_years = FiscalYearsModel::where("is_active", 1)->where("is_deleted", 0)->orderBy('id', 'DESC')->get();
      // dd($view_users);
      return view('budget.maintenance.index')
         ->with(compact('title'), $title)
         ->with(compact('username'), $username)
         ->with(compact('user_id'), $user_id)
         ->with(compact('user_role'), $user_role)
         ->with(compact('user_roles'))
         ->with(compact('user_role_id'), $user_role_id)
         ->with(compact('user_division_id'), $user_division_id)
         ->with(compact('user_fullname'), $user_fullname)
         ->with(compact('divisions'), $divisions)
         ->with(compact('view_users'), $view_users)
         ->with(compact('fiscal_years'), $fiscal_years);
   }

   public function bp_forms_byYear($year_selected)
   {
      $title = "BP Forms";
      $subtitle = "BP Forms";
      $username = auth()->user()->username;
      $user_id = auth()->user()->id;
      $user_role_id = auth()->user()->user_role_id;
      $user_roles = ViewUsersHasRolesModel::where('id', $user_id)->get();
      foreach ($user_roles as $row) {
         $user_roles_data[] = [
            "user_role" => $row->user_role,
            "user_role_id" => $row->role_id,
         ];
      }
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $user_fullname = ViewUsersModel::where('id', $user_id)->pluck('fullname_last')->first();
      $user_role = ViewUsersModel::where('id', $user_id)->pluck('user_role')->first();
      $years = FiscalYearsModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('year', 'ASC')->get();
      $data = [
         "year_selected" => $year_selected,
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
      // dd($data);
      if ($user_id == 149 || $user_id == 117) {
         $user_division_id = 3;
         $division_acronym = 'COA';
      }
      if (isset(request()->url)) {
         return redirect(request()->url);
      } else {
         return view('budget_preparation.bp_forms.index')
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
            ->with(compact('years'), $years);
      }
   }

   public function show_bank_account_by_fund(Request $request)
   {
      if ($request->ajax()) {
         $fund_id = $request->fund_id;
         try {
            if (isset($request->all()['fund_id'])) {
               $bank_accounts = LibraryBankAccountsModel::where('is_default', '1')
                  ->where(function ($query) use ($fund_id) {
                     $query->where('fund_id', $fund_id)
                        ->orWhere('fund_id', '=', 0);
                  })
                  ->where('is_active', '1')->where('is_deleted', 0)
                  ->orderBy('bank_account_no')
                  ->get();
            } else {
               $bank_accounts = "";
            }
         } catch (\Exception $e) {
            dd($e);
         }
         return Response::json([
            'bank_accounts' => $bank_accounts
         ]);
      }
   }

   public function show_bank_accounts_by_payee(Request $request)
   {
      $payee_parent_id = $request->payee_parent_id;
      // dd($payee_id);
      $data = ViewLibraryPayeesModel::where('parent_id', $payee_parent_id)
         ->where('is_active', '1')->where('is_deleted', 0)
         ->get();
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function ($payee) {
               return $payee->id;
            }
         ])
         ->addColumn('bank_account_no', function ($row) {
            $btn =
               "     
            <a href='#' data-id='" . $row->id . "' class='replace_payee_bank_account_no'>" . $row->bank_account_no . "</a>                  
            ";
            return $btn;
         })
         ->rawColumns(['bank_account_no'])
         ->make(true);
   }

   public function show_activity_by_division($user_division_id)
   {
      // if ($request->ajax()) {
      // try {
      if (isset($user_division_id)) {
         $activities = LibrarySubactivityModel::where('division_id', $user_division_id)
            ->where('is_active', '1')->where('is_deleted', 0)
            ->orderBy('activity')
            ->get();
      } else {
         $activities = "";
      }
      // } catch (\Exception $e) {
      //   dd($e);
      // }   
      return Response::json([
         'activities' => $activities
      ]);
      //  }  
   }

   public function show_subactivity_by_activity_id(Request $request)
   {
      if ($request->ajax()) {
         try {
            if (isset($request->all()['activity_id'])) {
               $subactivities = LibrarySubactivityModel::where('activity_id', $request->all()['activity_id'])
                  ->where('is_active', '1')->where('is_deleted', 0)
                  ->orderBy('subactivity')
                  ->get();
            } else {
               $subactivities = "";
            }
         } catch (\Exception $e) {
            dd($e);
         }
         return Response::json([
            'subactivities' => $subactivities
         ]);
      }
   }

   public function show_object_expenditure_by_expense_account_id(Request $request)
   {
      if ($request->ajax()) {
         try {
            if (isset($request->all()['expense_account_id'])) {
               $object_expenditures = LibraryObjectExpenditureModel::where('expense_account_id', $request->all()['expense_account_id'])
                  ->where('is_active', '1')->where('is_deleted', 0)
                  ->orderBy('object_expenditure')
                  ->get();
            } else {
               $object_expenditures = "";
            }
         } catch (\Exception $e) {
            dd($e);
         }
         return Response::json([
            'object_expenditures' => $object_expenditures
         ]);
      }
   }

   public function show_object_specific_by_object_expenditure_id(Request $request)
   {
      if ($request->ajax()) {
         try {
            if (isset($request->all()['object_expenditure_id'])) {
               $object_specifics = LibraryObjectSpecificModel::where('object_expenditure_id', $request->all()['object_expenditure_id'])
                  ->where('is_active', '1')->where('is_deleted', 0)
                  ->orderBy('object_specific')
                  ->get();
            } else {
               $object_specifics = "";
            }
         } catch (\Exception $e) {
            dd($e);
         }
         return Response::json([
            'object_specifics' => $object_specifics
         ]);
      }
   }

   public function show_position_by_emp_code(Request $request)
   {
      if ($request->ajax()) {
         try {
            if (isset($request->all()['emp_code'])) {
               $positions = ViewEmployeePositionModel::where('emp_code', $request->all()['emp_code'])
                  ->orderBy('position_desc')->groupBy('position_id')->get();
            } else {
               $positions = "";
            }
         } catch (\Exception $e) {
            dd($e);
         }
         return Response::json([
            'positions' => $positions
         ]);
      }
   }

   public function show_obligations_by_allotment_id(Request $request)
   {
      if ($request->ajax() && isset($request->all()['allotment_id']) && $request->all()['allotment_id'] != null) {
         if (isset($request->all()['allotment_id'])) {
            $data = ViewRsPapModel::where('allotment_id', $request->allotment_id)->where('is_active', 1)->where('is_deleted', 0)->get();
         }
         return DataTables::of($data)
            ->setRowAttr([
               'data-id' => function ($obligation) {
                  return $obligation->id;
               }
            ])
            ->make(true);
      }
   }

   public function show_bank_account_no(Request $request)
   {
      $data = ViewLibraryBankAccountsModel::where('is_active', 1)->where('is_deleted', 0)->get();
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function ($bank) {
               return $bank->id;
            }
         ])
         ->addColumn('bank_account_no', function ($row) {
            $btn =
               "     
            <a href='#' data-id='" . $row->id . "' class='update_bank_account_no'>" . $row->bank_account_no . "</a>                  
            ";
            return $btn;
         })
         ->rawColumns(['bank_account_no'])
         ->make(true);
   }
}
