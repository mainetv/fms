<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\ViewUsersModel;

class AdministrationController extends Controller
{
   public function index()
   {
      $user_id = auth()->user()->id;
      $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
      $title = 'Administration';
      return view('administration.index')
         ->with(compact('title'), $title)
         ->with(compact('user_division_id'), $user_division_id)
         ->with(compact('user_id'), $user_id);
   }
}
