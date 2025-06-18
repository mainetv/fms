<?php

namespace App\Http\Controllers;

use App\Models\ViewUsersModel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // session(['set_user_role_id' => $user_role_id]);
        $current_year = Carbon::now()->timezone('Asia/Manila')->format('Y');
        $user_id = auth()->user()->id;
        $user_division_id = ViewUsersModel::where('id', $user_id)->pluck('division_id')->first();
        $title = 'Dashboard';
        if ($user_id == 149 || $user_id == 117) {
            $user_division_id = 3;
            $division_acronym = 'COA';
        }

        return view('dashboard')
            ->with(compact('title'))
            ->with(compact('user_id'))
            ->with(compact('current_year'))
            ->with(compact('user_division_id'));
    }
}
