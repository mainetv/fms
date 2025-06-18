<?php

namespace App\Services;

use App\Models\LibraryPayeesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UtilityService
{
    public function __construct(
        private GlobalService $globalService,
    ) {}

    public function createPayee($request)
    {
        // dd($request);
        dd($request['parent_id']);
        if ($request['payee_type_id'] == 1) {
            $first_name = $request['first_name'];
            $middle_initial = $request['middle_initial'];
            $last_name = $request['last_name'];
            $payee = trim($first_name.' '.$middle_initial.' '.$last_name);
        } else {
            $organization_name = trim($request['organization_name']);
            $organization_acronym = trim($request['organization_acronym']);
            $payee = $organization_acronym ? "$organization_name ($organization_acronym)" : $organization_name;
        }

        $data = new LibraryPayeesModel([
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

        $module_id = 10;
        $message = 'Created new payee:'.$payee;
        $link = 'utilities/';
        $this->globalService->createNotification($module_id, $message, $link);
    }

    public function updatePayee($request, $id)
    {
        $action = $request['action'] ?? null;
        $payee = null;
        if ($action == 'update') {
            if ($request['payee_type_id'] == 1) {
                $first_name = $request['first_name'];
                $middle_initial = $request['middle_initial'];
                $last_name = $request['last_name'];
                $payee = trim($first_name.' '.$middle_initial.' '.$last_name);
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

            return 'updated';
        } elseif ($action == 'verify') {
            LibraryPayeesModel::find($id)->update([
                'is_verified' => 1,
            ]);

            return 'verified';
        }
    }

    public function deletePayee($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return true;
    }

    public function changePassword($request)
    {
        $user = Auth::user();

        if (! $user) {
            throw new \Exception('User not found.');
        }

        $user->password = Hash::make($request['new_password']);
        $user->save();
    }
}
