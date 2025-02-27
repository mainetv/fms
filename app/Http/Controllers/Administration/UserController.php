<?php

namespace App\Http\Controllers\Administration;;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utility\PasswordUpdateRequest;
use App\Http\Requests\Utility\ProfileStoreUpdateRequest;
use App\Models\User;
use App\Models\ViewUsersModel;
use App\Services\UtilityService;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function __construct(
      private UtilityService $utilityService,
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

   public function store(ProfileStoreUpdateRequest $request)
   {
      if ($request->ajax()) {
         // try {
         //    $this->utilityService->createPayee($request->validated());
         //    return response()->json(['message' => 'Payee added successfully.'], 200);
         // } catch (\Exception $e) {
         //    return response()->json(['error' => $e->getMessage()], 500);
         // }
      }
   }

   public function show($id)
   {
      $data = User::findOrFail($id);
      return $data;
   }

   public function update(ProfileStoreUpdateRequest $request, $id)
   {
      if ($request->ajax()) {
         try {

            return response()->json(['message' => 'Password saved successfully.'], 200);
         } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
         }
      }
   }

   public function change_password(PasswordUpdateRequest $request)
   {
      dd($request->all());
      // if ($request->ajax()) {
      //    try {
      //       dd($request->validated());
      //       $this->utilityService->changePassword($request->validated());
      //       return response()->json(['message' => 'Password saved successfully.'], 200);
      //    } catch (\Exception $e) {
      //       return response()->json(['error' => $e->getMessage()], 500);
      //    }
      // }
   }

   public function destroy($id)
   {
      // try {
      //    $this->utilityService->deletePayee($id);
      //    return response()->json(['message' => 'Payee deleted successfully.'], 200);
      // } catch (ModelNotFoundException $e) {
      //    return response()->json(['error' => 'Payee not found.'], 404);
      // } catch (Exception $e) {
      //    return response()->json(['error' => $e->getMessage()], 500);
      // }
   }
}
