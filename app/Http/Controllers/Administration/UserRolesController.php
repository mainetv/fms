<?php

namespace App\Http\Controllers\Administration;;

use App\Http\Controllers\Controller;
use App\Models\UserRolesModel;
use Illuminate\Http\Request;
use DataTables;

class UserRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function table(Request $request)
	{
		$data = UserRolesModel::where('is_deleted', 0)->get();		
		if ($request->ajax()) {
			return DataTables::of($data)
				->addIndexColumn()
				->setRowAttr([
					'data-id' => function($user_role) {
					return $user_role->id;
				}
				])
				->addColumn('action', function($row){
						$btn =
						"<div>
						<button class='actionbtn view-user-role' type='button'> 
							<i class='fas fa-eye'></i></a>                    
						</button>
						<button class='actionbtn update-user-role' type='button'>
							<i class='fas fa-edit blue'></i>
						</button>
						<button class='actionbtn delete-user-role' type='button'>
							<i class='fas fa-trash-alt red'></i>
						</button>
						</div>
						";
						return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}         
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRolesMo  $userRolesMo
     * @return \Illuminate\Http\Response
     */
    public function show(UserRolesMo $userRolesMo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRolesMo  $userRolesMo
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRolesMo $userRolesMo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserRolesMo  $userRolesMo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRolesMo $userRolesMo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRolesMo  $userRolesMo
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRolesMo $userRolesMo)
    {
        //
    }
}
