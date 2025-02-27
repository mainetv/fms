<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Models\ViewUsersModel;

class UtilityController extends Controller
{   
   public function index(){
      $user_id = auth()->user()->id;  
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $title = 'Utilities';
      return view('utilities.index')
         ->with(compact('title'), $title)
         ->with(compact('user_division_id'), $user_division_id)
         ->with(compact('user_id'), $user_id);
   }
}
