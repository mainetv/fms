<?php

namespace App\Http\Controllers;

use App\Models\ChartAccount;

class DVController extends Controller
{
   public function showChartAccounts(Request $request)
      {
      $accounts = ChartAccount::all();
      $tree = $this->buildHierarchy($accounts);
      $flat = $this->flattenHierarchy($tree);

      return response()->json(['data' => $flat]);
      }

      private function buildHierarchy($accounts, $parentId = null)
      {
         $branch = [];

         foreach ($accounts->where('parent_id', $parentId) as $account) {
            $children = $this->buildHierarchy($accounts, $account->id);
            $account->children = $children;
            $branch[] = $account;
         }

         return $branch;
      }

      private function flattenHierarchy($accounts, $prefix = '')
      {
         $flat = [];

         foreach ($accounts as $account) {
            $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $account->level_id - 1);
            $flat[] = [
               'name' => $indent . $account->name,
               'uacs' => $account->uacs ?? '', // or replace with actual column if available
            ];

            if ($account->children->isNotEmpty()) {
               $flat = array_merge($flat, $this->flattenHierarchy($account->children, $prefix));
            }
         }

         return $flat;
      }
}