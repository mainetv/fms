<?php

namespace App\Http\Controllers;

use App\Models\LibrarySubactivityModel;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;

class LibrarySubactivityController extends Controller
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
        if ($request->ajax()) {
            $data = DB::Table('view_library_subactivity')->where('is_deleted', 0)->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->setRowAttr([
                    'data-id' => function ($library_subactivity) {
                        return $library_subactivity->id;
                    },
                ])
                ->addColumn('action', function ($row) {
                    $btn =
                    "<div>
               <button class='actionbtn view-library-subactivity' type='button'> 
               <i class='fas fa-eye'></i></a>                    
               </button>
               <button class='actionbtn update-library-subactivity' type='button'>
               <i class='fas fa-edit blue'></i>
               </button>
               <button class='actionbtn delete-library-subactivity red' type='button'>
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $message = [
                'subactivity.required' => 'Subactivity field is required.',
                'description.required' => 'Description field is required.',
                'request_status_type_id.required' => 'Please select request and status type.',
            ];
            $validator = Validator::make($request->all(), [
                'subactivity' => 'required',
                'description' => 'required',
                'request_status_type_id' => 'required',
            ], $message);

            $input = $request->all();
            if ($validator->passes()) {
                $data = new LibrarySubactivityModel([
                    'subactivity' => $request->get('subactivity'),
                    'description' => $request->get('description'),
                    'request_status_type_id' => $request->get('request_status_type_id'),
                    'is_continuing' => $request->get('is_continuing'),
                    'remarks' => $request->get('remarks'),
                    'is_active' => $request->get('is_active'),
                ]);
                $data->save();

                return Response::json(['success' => '1']);
            }

            return Response::json(['errors' => $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LibrarySubactivityModel  $libraryActivityModel
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = LibrarySubactivityModel::find($request->get('id'));
            if ($data->count()) {
                return Response::json([
                    'status' => '1',
                    'library_subactivity' => $data,
                ]);
            } else {
                return Response::json([
                    'status' => '0',
                ]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(LibrarySubactivityModel $libraryActivityModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\LibrarySubactivityModel  $libraryActivityModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $message = [
                'subactivity.required' => 'Activity field is required.',
                'description.required' => 'Description field is required.',
                'request_status_type_id.required' => 'Please select request and status type.',
            ];
            $validator = Validator::make($request->all(), [
                'subactivity' => 'required',
                'description' => 'required',
                'request_status_type_id' => 'required',
            ], $message);

            $input = $request->all();

            if ($validator->passes()) {
                LibraryPAPModel::find($request->get('id'))
                    ->update([
                        'subactivity' => $request->get('subactivity'),
                        'description' => $request->get('description'),
                        'request_status_type_id' => $request->get('request_status_type_id'),
                        'is_continuing' => $request->get('is_continuing'),
                        'remarks' => $request->get('remarks'),
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
     * @param  \App\Models\LibrarySubactivityModel  $libraryActivityModel
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($request->ajax()) {
            try {
                LibrarySubactivityModel::find($request->get('id'))
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
