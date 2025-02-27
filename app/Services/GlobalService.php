<?php

namespace App\Services;

use App\Models\NotificationsModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewUsersModel;
use Illuminate\Support\Facades\Auth;

class GlobalService
{

   public function createNotification($module_id, $message, $link)
   {
      $user_id = Auth::user()->id;
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();

      if ($module_id == 10) {
         $administrators = ViewUsersHasRolesModel::where('id', '!=', $user_id)->where('role_id', '=', 0)
            ->where('is_active', 1)->where('is_deleted', 0)->get();
         if ($administrators->count() != 0) {
            foreach ($administrators as $value) {
               $notification[] = [
                  'module_id' => $module_id,
                  'message' => $message,
                  'link' => $link,
                  'division_id' => $user_division_id,
                  'division_id_from' => $user_division_id,
                  'division_id_to' => $value->division_id,
                  'user_id_from' => $user_id,
                  'user_id_to' => $value->id,
                  'user_role_id_from' => 7,
                  'user_role_id_to' => 1,
               ];
            }
            NotificationsModel::insert($notification);
         }
      }
   }
}
