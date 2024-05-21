<?php

namespace App\Http\Controllers;

use App\Models\NotificationsModel;
use App\Models\ViewUsersModel;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Response;

class NotificationsController extends Controller
{  
   public function index(Request $request)
   {
      $user_id = auth()->user()->id;  
      $user_role_id = auth()->user()->user_role_id;     
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();    
      $title = "Notifications";
      return view('notifications')       
         ->with(compact('title'), $title)
         ->with(compact('user_id'), $user_id)
         ->with(compact('user_division_id'), $user_division_id)
         ->with(compact('user_role_id'));
   }

   public function update(Request $request)
   {
      if ($request->ajax()) {
         // dd($request->all());
         NotificationsModel::find($request->id)
            ->update([                  
               'is_read' => 1,
            ]);             
         return Response::json(['success' => '1', ]);
      }
   }
}
