<?php

namespace App\Http\Controllers;

use App\Models\BudgetProposalsModel;
use App\Models\NotificationsModel;
use App\Models\ViewUsersHasRolesModel;
use App\Models\ViewNotificationsModel;
use App\Models\ViewUsersModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $title = "Dashboard";
        return view('dashboard')
            ->with(compact('title'))
            ->with(compact('user_id'))
            ->with(compact('current_year'))
            ->with(compact('user_division_id'));
    }
}
