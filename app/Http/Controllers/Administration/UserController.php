<?php

namespace App\Http\Controllers\Administration;;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\UserStoreUpdateRequest;
use App\Http\Requests\Utility\PasswordUpdateRequest;
use App\Http\Requests\Utility\ProfileStoreUpdateRequest;
use App\Models\User;
use App\Models\ViewUsersModel;
use App\Services\AdministrationService;
use App\Services\UtilityService;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function __construct(
      private AdministrationService $administrationService,
   ) {}

   public function index(Request $request)
   {
      $user_id = auth()->user()->id;
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $title = 'profile';
      return view('utilities.profile.index')
         ->with(compact('title'), $title)
         ->with(compact('user_division_id'), $user_division_id)
         ->with(compact('user_id'), $user_id);
   }

   public function store(UserStoreUpdateRequest $request)
   {
      if ($request->ajax()) {
         try {
            $this->administrationService->createUserAccount($request->validated());
            return response()->json(['message' => 'User account added successfully.'], 200);
         } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
         }
      }
   }

   public function show($id)
   {
      $user = User::with('roles')->findOrFail($id);

      return response()->json([
         'emp_code' => $user->emp_code,
         'user_role_ids' => $user->roles->pluck('id'),
      ]);
   }


   public function update(UserStoreUpdateRequest $request, $id)
   {
      if ($request->ajax()) {
         try {
            $this->administrationService->updateUserAccount($request->validated());
            return response()->json(['message' => 'User account updated successfully.'], 200);
         } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
         }
      }
   }
}
