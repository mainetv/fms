<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utility\PayeeStoreUpdateRequest;
use App\Models\LibraryPayeesModel;
use App\Models\ViewUsersModel;
use App\Services\UtilityService;
use Illuminate\Http\Request;

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
            $this->utilityService->createPayee($request->all());
            return response()->json(['message' => 'Payee added successfully.'], 200);
         } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
         }
      }
   }

   public function show($id)
   {
      $data = LibraryPayeesModel::with(['parentPayee', 'bank'])->findOrFail($id);
      return $data;
   }

   public function update(Request $request, $id)
   {
      if (!$request->ajax()) {
         abort(400, 'Invalid request.');
      }

      $action = $request->input('action');
      if ($action === 'toggleStatus') {
         return $this->handleToggleStatus($request, $id);
      }
      return $this->handleValidatedUpdate($request, $id);
   }

   protected function handleToggleStatus(Request $request, $id)
   {
      try {
         $request->validate([
            'is_active' => 'required|boolean',
         ]);

         $result = $this->utilityService->updatePayee($request->all(), $id);

         return response()->json([
            'message' => 'Payee status updated successfully.',
         ]);
      } catch (\Exception $e) {
         return response()->json(['error' => $e->getMessage()], 500);
      }
   }

   protected function handleValidatedUpdate(Request $request, $id)
   {
      $request['action'] = 'update';
      try {
         $result = $this->utilityService->updatePayee($request, $id);

         return response()->json([
            'message' => 'Payee updated successfully.',
         ]);
      } catch (\Exception $e) {
         return response()->json(['error' => $e->getMessage()], 500);
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
