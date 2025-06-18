<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ViewUsersModel;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;
use Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function table(Request $request)
    {
        $data = ViewUsersModel::where('is_deleted', 0)->orderBy('lname', 'ASC')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->setRowAttr([
                    'data-id' => function ($user) {
                        return $user->id;
                    },
                ])
                ->addColumn('action', function ($row) {
                    $btn =
                    "<div>
						<button class='actionbtn view-user' type='button'> 
							<i class='fas fa-eye'></i></a>                    
						</button>
						<button class='actionbtn update-user' type='button'>
							<i class='fas fa-edit blue'></i>
						</button>
						<button class='actionbtn delete-user' type='button'>
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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $message = [
                'emp_code.required' => 'Please select employee.',
                'user_role_id.required' => 'Please select user role.',
                // 'username.required' => 'Username field is required.',
                // 'password.required' => 'Password field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'emp_code' => 'required', 'unique',
                'user_role_id' => 'required',
                // 'username' => 'required',
                // 'password' => 'required',
            ], $message);

            $input = $request->all();
            if ($validator->passes()) {
                // $data = new User([
                $input = $request->all();
                // 'emp_code' => $request->get('emp_code'),
                // 'user_role_id' => $request->get('user_role_id'),
                $input['username'] = $input['emp_code'];
                $input['password'] = Hash::make($input['emp_code']);
                // 'password' => Hash::make($request->get('password')),
                // 'is_active' => $request->get('is_active'),
                // ]);
                // $data->save();

                $user = User::create($input);
                $user->assignRole($request->input('roles'));

                return Response::json(['success' => '1']);
            }

            return Response::json(['errors' => $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = User::find($request->get('id'));
            if ($data->count()) {
                return Response::json([
                    'status' => '1',
                    'user' => $data,
                ]);
            } else {
                return Response::json([
                    'status' => '0',
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all()); exit();
            $message = [
                'emp_code.required' => 'Please select employee.',
                'user_role_id.required' => 'Please select user role.',
                'username.required' => 'Username field is required.',
                // 'password.required' => 'Password field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'emp_code' => 'required', 'unique',
                'user_role_id' => 'required',
                'username' => 'required',
                // 'password' => 'required',
            ], $message);
            $input = $request->all();
            if ($validator->passes()) {
                User::find($request->get('id'))
                    ->update([
                        'emp_code' => $request->get('emp_code'),
                        'user_role_id' => $request->get('user_role_id'),
                        'username' => $request->get('username'),
                        'is_active' => $request->get('is_active'),
                    ]);

                return Response::json([
                    'success' => '1',
                    'status' => '0',
                ]);
            }

            return Response::json(['errors' => $validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, User $User)
    {
        if ($request->ajax()) {
            try {
                User::find($request->get('id'))
                    ->update([
                        'is_deleted' => '1',
                    ]);
            } catch (\Exception $e) {
                return Response::json([
                    'status' => '0',
                ]);
            }

            return Response::json([
                'status' => '1',
            ]);
        }
    }
}
