<?php

namespace App\Services;

use App\Http\Controllers\Administration\UserController;
use App\Models\LibraryPayeesModel;
use App\Models\NotificationsModel;
use App\Models\User;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministrationService
{
   protected $globalService;

   public function __construct(GlobalService $globalService)
   {
      $this->globalService = $globalService;
   }

   public function createUserAccount($request)
   {
      $primaryRoleId = $request['users_user_role_id'][0];
      
      $data = new User([
         'emp_code' => $request['users_employee_code'],
         'user_role_id' => $primaryRoleId,
         'username' => $request['users_employee_code'],
         'password' => Hash::make($request['users_employee_code']),         
      ]);
      $data->save();

      $data->assignRole($request['users_user_role_id']);
   }

   public function updateUserAccount($request)
   {
      dd($request);
      $primaryRoleId = $request['users_user_role_id'][0];

      $data = new User([
         'emp_code' => $request['users_employee_code'],
         'user_role_id' => $primaryRoleId,
         'username' => $request['users_employee_code'],
         'password' => Hash::make($request['users_employee_code']),
      ]);
      $data->save();

      $data->assignRole($request['users_user_role_id']);
   }
}
