<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utility\PayeeStoreUpdateRequest;
use App\Models\LibraryPayeesModel;
use App\Models\ViewUsersModel;
use App\Services\UtilityService;

class PayeeController extends Controller
{
   public function __construct(
      private UtilityService $utilityService,
   ) {}

   public function index()
   {
      $user_id = auth()->user()->id;
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $title = 'payees';
      return view('utilities.payee.index_division')
         ->with(compact('title'), $title)
         ->with(compact('user_division_id'), $user_division_id)
         ->with(compact('user_id'), $user_id);
   }

   public function store(PayeeStoreUpdateRequest $request)
   {
      if ($request->ajax()) {
         try {
            $this->utilityService->createPayee($request->validated());
            return response()->json(['message' => 'Payee added successfully.'], 200);
         } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
         }
      }
   }

   public function show($id)
   {
      $data = LibraryPayeesModel::findOrFail($id);
      return $data;
   }

   public function update(PayeeStoreUpdateRequest $request, $id)
   {
      if ($request->ajax()) {
         try {
            $result = $this->utilityService->updatePayee($request->all(), $id);

            return response()->json([
               'message' => $result === 'updated'
                  ? 'Payee updated successfully.'
                  : 'Payee verified successfully.'
            ], 200);
         } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
         }
      }
   }

   public function destroy($id)
   {
      try {
         $this->utilityService->deletePayee($id);
         return response()->json(['message' => 'Payee deleted successfully.'], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json(['error' => 'Payee not found.'], 404);
      } catch (Exception $e) {
         return response()->json(['error' => $e->getMessage()], 500);
      }
   }
}
