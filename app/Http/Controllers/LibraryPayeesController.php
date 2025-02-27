<?php

namespace App\Http\Controllers;

use App\Models\LibraryPayeesModel;
use App\Models\ViewLibraryPayeesModel;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Response;

class LibraryPayeesController extends Controller
{
   public function table(Request $request)
   {
      if ($request->ajax()) {
         $data = ViewLibraryPayeesModel::where('is_deleted', 0)->orderBy('id', 'DESC')->get();
         return DataTables::of($data)
            ->addIndexColumn()
            ->setRowAttr([
               'data-id' => function ($library_payees) {
                  return $library_payees->id;
               }
            ])
            // ->addColumn('payee', function($row){
            //     $btn =
            //        "<a data-id='". $row->id ."' href='".url("funds_utilization/rs/budget/edit/".$row->id)."'>". $row->payee ."</a>";
            //     return $btn;
            //  })
            ->addColumn('action', function ($row) {
               $btn =
                  "<div>
                  <button class='actionbtn btn_edit_payee' type='button'>
                  <i class='fas fa-edit blue'></i>
                  </button>
               </div>
               ";
               return $btn;
            })
            // ->rawColumns(['payee'],['action'])
            ->rawColumns(['action'])
            ->make(true);
      }
   }

   public function show_rs_by_month_year(Request $request)
   {
      // dd($request->all());
      $rs_type_id = $request->rs_type_id;
      $month_selected = $request->month_selected;
      $year_selected = $request->year_selected;
      $search = $request->search;
      if ($request->ajax() && isset($month_selected) && $month_selected != null && ($search == null || $search == '')) {
         $data = ViewRSModel::where('rs_type_id', $rs_type_id)->whereMonth('rs_date', $month_selected)->whereYear('rs_date', $year_selected)
            ->where('id', '!=', 39857)->where('id', '!=', 39875)->where('id', '!=', 39876)
            ->where('id', '!=', 40177)->where('id', '!=', 40178)->where('id', '!=', 40179)
            ->where('id', '!=', 40376)->where('id', '!=', 40377)->where('id', '!=', 40378)
            ->where('is_active', 1)->where('is_deleted', 0)->orderBy('rs_no', 'ASC')->get();
      } else if ($request->ajax() && isset($search) && $search != null) {
         $data = ViewRSModel::where(function ($query) use ($search) {
               $query->where('payee', 'like', '%' . $search . '%')
                  ->orWhere('id', 'like', '%' . $search . '%')
                  ->orWhere('rs_no', 'like', '%' . $search . '%');
            })
            ->where('id', '!=', 39857)->where('id', '!=', 39875)->where('id', '!=', 39876)
            ->where('rs_type_id', $rs_type_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('rs_no', 'ASC')->get();
      }
      return DataTables::of($data)
         ->setRowAttr([
            'data-id' => function ($rs) {
               return $rs->id;
            }
         ])
         ->addColumn('payee', function ($row) {
            $btn =
               "<a data-id='" . $row->id . "' href='" . url('funds_utilization/rs/budget/edit/' . $row->id) . "'>
             " . $row->payee . "</a>";
            return $btn;
         })
         ->rawColumns(['payee'])
         ->make(true);
   }

   public function store(Request $request)
   {
      // dd($request->all());      
      if ($request->ajax()) {
         $payee_type_id = $request->payee_type_id;
         $parent_id = $request->parent_id;
         // dd($request->bank_id);
         if ($payee_type_id == 1) {
            $message = array(
               'first_name.required' => 'First name field is required.',
               'last_name.required' => 'Last name field is required.',
            );
            $validator =  Validator::make($request->all(), [
               'first_name' => 'required',
               'last_name' => 'required',
            ], $message);
            $first_name = $request->first_name;
            $middle_initial = $request->middle_initial;
            $last_name = $request->last_name;
            $suffix = $request->suffix;
            if (isset($middle_initial) && isset($suffix)) {
               $payee = $first_name . ' ' . $middle_initial . ' ' . $last_name . ' ' . $suffix;
            } elseif (isset($middle_initial) && !isset($suffix)) {
               $payee = $first_name . ' ' . $middle_initial . ' ' . $last_name;
            } elseif (!isset($middle_initial) && !isset($suffix)) {
               $payee = $first_name . ' ' . $last_name;
            } elseif (!isset($middle_initial) && isset($suffix)) {
               $payee = $first_name . ' ' . $last_name . ' ' . $suffix;
            }
         } else {
            $message = array(
               'organization_name.required' => 'Organization name field is required.',
            );
            $validator =  Validator::make($request->all(), [
               'organization_name' => 'required',
            ], $message);
            $organization_name = $request->organization_name;
            $organization_acronym = $request->organization_acronym;
            if (isset($organization_acronym)) {
               $payee = $organization_name . ' (' . $organization_acronym . ')';
            } else {
               $payee = $organization_name;
            }
         }
         if ($validator->passes()) {
            // dd($payee);          
            $data = new LibraryPayeesModel([
               'parent_id' => $parent_id,
               'payee_type_id' => $payee_type_id,
               'payee' => $payee,
               'organization_name' => $organization_name ?? null,
               'organization_acronym' => $organization_acronym ?? null,
               'title' => $request->title ?? null,
               'first_name' => $first_name ?? null,
               'middle_initial' => $middle_initial ?? null,
               'last_name' => $last_name ?? null,
               'suffix' => $suffix ?? null,
               'tin' => $request->tin ?? null,
               'bank_id' => $request->bank_id,
               'bank_branch' => $request->bank_branch ?? null,
               'bank_account_name' => $request->bank_account_name ?? null,
               'bank_account_no' => $request->bank_account_no ?? null,
               'address' => $request->address ?? null,
               'office_address' => $request->office_address ?? null,
               'email_address' => $request->email_address ?? null,
               'contact_no' => $request->contact_no ?? null,
               'is_lbp_enrolled' => $request->is_lbp_enrolled,
               'is_active' => $request->is_active,
            ]);
            // dd($data);
            $data->save();
            if ($parent_id == 0) {
               LibraryPayeesModel::find($data->id)
                  ->update([
                     'parent_id' => $data->id,
                  ]);
            }
            return Response::json(['success' => '1']);
         }
         return Response::json(['errors' => $validator->errors()]);
      }
   }

   public function show(Request $request)
   {
      // if($request->ajax()){
      // dd($request->all());
      $data = LibraryPayeesModel::find($request->get('id'));
      // dd($data);
      if ($data->count()) {
         return Response::json([
            'status' => '1',
            'library_payees' => $data
         ]);
      } else {
         return Response::json([
            'status' => '0'
         ]);
      }
      // }
   }

   public function edit(LibraryPAPModel $libraryPAPModel)
   {
      //
   }

   public function update(Request $request)
   {
      // dd('test');  
      // dd($request->all());    
      if ($request->ajax()) {
         $payee_type_id = $request->payee_type_id;
         // dd($request->bank_id);
         if ($payee_type_id == 1) {
            $message = array(
               'first_name.required' => 'First name field is required.',
               'last_name.required' => 'Last name field is required.',
            );
            $validator =  Validator::make($request->all(), [
               'first_name' => 'required',
               'last_name' => 'required',
            ], $message);
            $first_name = $request->first_name;
            $middle_initial = $request->middle_initial;
            $last_name = $request->last_name;
            $suffix = $request->suffix;
            if (isset($middle_initial) && isset($suffix)) {
               $payee = $first_name . ' ' . $middle_initial . ' ' . $last_name . ' ' . $suffix;
            } elseif (isset($middle_initial) && !isset($suffix)) {
               $payee = $first_name . ' ' . $middle_initial . ' ' . $last_name;
            } elseif (!isset($middle_initial) && !isset($suffix)) {
               $payee = $first_name . ' ' . $last_name;
            } elseif (!isset($middle_initial) && isset($suffix)) {
               $payee = $first_name . ' ' . $last_name . ' ' . $suffix;
            }
         } else {
            $message = array(
               'organization_name.required' => 'Organization name field is required.',
            );
            $validator =  Validator::make($request->all(), [
               'organization_name' => 'required',
            ], $message);
            $organization_name = $request->organization_name;
            $organization_acronym = $request->organization_acronym;
            if (isset($organization_acronym)) {
               $payee = $organization_name . ' (' . $organization_acronym . ')';
            } else {
               $payee = $organization_name;
            }
         }

         if ($validator->passes()) {
            LibraryPayeesModel::find($request->get('id'))
               ->update([
                  'payee' => $payee,
                  'organization_name' => $organization_name ?? null,
                  'organization_acronym' => $organization_acronym ?? null,
                  'title' => $request->title ?? null,
                  'first_name' => $first_name ?? null,
                  'middle_initial' => $middle_initial ?? null,
                  'last_name' => $last_name ?? null,
                  'suffix' => $suffix ?? null,
                  'tin' => $request->tin ?? null,
                  'bank_id' => $request->bank_id,
                  'bank_branch' => $request->bank_branch ?? null,
                  'bank_account_name' => $request->bank_account_name ?? null,
                  'bank_account_no' => $request->bank_account_no ?? null,
                  'address' => $request->address ?? null,
                  'office_address' => $request->office_address ?? null,
                  'email_address' => $request->email_address ?? null,
                  'contact_no' => $request->contact_no ?? null,
                  'is_lbp_enrolled' => $request->is_lbp_enrolled,
                  'is_active' => $request->is_active,
               ]);
            return Response::json([
               'success' => '1',
               'status' => '0'
            ]);
         }
         return Response::json(['errors' => $validator->errors()]);
      }
   }

   public function delete(Request $request)
   {
      if ($request->ajax()) {
         try {
            LibraryPAPModel::find($request->get('id'))
               ->update([
                  'is_deleted' => '1'
               ]);
         } catch (\Exception $e) {
            return Response::json([
               'status' => '0'
            ]);
         }
         return Response::json([
            'status' => '1'
         ]);
      }
   }
}
