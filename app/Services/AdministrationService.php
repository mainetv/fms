<?php

namespace App\Services;

use App\Http\Controllers\Administration\UsersController;
use App\Models\LibraryPayeesModel;
use App\Models\NotificationsModel;
use App\Models\User;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Support\Facades\Auth;

class AdministrationService
{
   protected $globalService;

   public function __construct(GlobalService $globalService)
   {
      $this->globalService = $globalService;
   }

   public function createUser($request)
   {
      dd($request);
      // dd($request['parent_id']==null);
      if ($request['payee_type_id'] == 1) {
         $first_name = $request['first_name'];
         $middle_initial = $request['middle_initial'];
         $last_name = $request['last_name'];
         $payee = trim($first_name . ' ' . $middle_initial . ' ' . $last_name);
      } else {
         $organization_name = trim($request['organization_name']);
         $organization_acronym = trim($request['organization_acronym']);
         $payee = $organization_acronym ? "$organization_name ($organization_acronym)" : $organization_name;
      }

      $data = new UsersController([
         'parent_id' => $request['parent_id'],
         'payee_type_id' => $request['payee_type_id'],
         'payee' => $payee,
         'organization_name' => $organization_name ?? null,
         'organization_acronym' => $organization_acronym ?? null,
         'title' => $request['title'] ?? null,
         'first_name' => $first_name ?? null,
         'middle_initial' => $middle_initial ?? null,
         'last_name' => $last_name ?? null,
         'suffix' => $request['suffix'] ?? null,
         'tin' => $request['tin'] ?? null,
         'bank_id' => $request['bank_id'] ?? null,
         'bank_branch' => $request['bank_branch'] ?? null,
         'bank_account_name' => $request['bank_account_name'] ?? null,
         'bank_account_no' => $request['bank_account_no'] ?? null,
         'address' => $request['address'] ?? null,
         'office_address' => $request['office_address'] ?? null,
         'email_address' => $request['email_address'] ?? null,
         'contact_no' => $request['contact_no'] ?? null,
         'is_active' => isset($request['is_active']) ? 1 : 0,
      ]);
      $data->save();
      if ($request['parent_id'] == null) {
         $data->update(['parent_id' => $data->id]);
      }

      $this->createNotification($payee);
   }

   public function updateUser($request, $id)
   {
      $action = $request['action'] ?? null;
      if ($action == 'update') {
         if ($request['payee_type_id'] == 1) {
            $first_name = $request['first_name'];
            $middle_initial = $request['middle_initial'];
            $last_name = $request['last_name'];
            $payee = trim($first_name . ' ' . $middle_initial . ' ' . $last_name);
         } else {
            $organization_name = $request['organization_name'];
            $organization_acronym = $request['organization_acronym'];
            $payee = $organization_acronym ? "$organization_name ($organization_acronym)" : $organization_name;
         }
         LibraryPayeesModel::find($id)->update([
            'payee' => $payee,
            'organization_name' => $organization_name ?? null,
            'organization_acronym' => $organization_acronym ?? null,
            'title' => $request['title'] ?? null,
            'first_name' => $first_name ?? null,
            'middle_initial' => $middle_initial ?? null,
            'last_name' => $last_name ?? null,
            'suffix' => $request['suffix'] ?? null,
            'tin' => $request['tin'] ?? null,
            'bank_id' => $request['bank_id'] ?? null,
            'bank_branch' => $request['bank_branch'] ?? null,
            'bank_account_name' => $request['bank_account_name'] ?? null,
            'bank_account_no' => $request['bank_account_no'] ?? null,
            'address' => $request['address'] ?? null,
            'office_address' => $request['office_address'] ?? null,
            'email_address' => $request['email_address'] ?? null,
            'contact_no' => $request['contact_no'] ?? null,
            'is_active' => isset($request['is_active']) ? 1 : 0,
         ]);

         return response()->json(['message' => 'Payee saved successfully.'], 200);
      } else if ($action == 'verify') {
         LibraryPayeesModel::find($id)->update([
            'is_verified' => 1,
         ]);
         return response()->json(['message' => 'Payee verified successfully.'], 200);
      }
   }
}
