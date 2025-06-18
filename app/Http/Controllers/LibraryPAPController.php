<?php

namespace App\Http\Controllers;

use App\Models\LibraryPAPModel;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;

class LibraryPAPController extends Controller
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
            $data = DB::Table('view_library_pap')->where('is_deleted', 0)->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->setRowAttr([
                    'data-id' => function ($library_pap) {
                        return $library_pap->id;
                    },
                ])
                ->addColumn('action', function ($row) {
                    $btn =
                    "<div>
               <button class='actionbtn view-library-pap' type='button'> 
               <i class='fas fa-eye'></i></a>                    
               </button>
               <button class='actionbtn update-library-pap' type='button'>
               <i class='fas fa-edit blue'></i>
               </button>
               <button class='actionbtn delete-library-pap red' type='button'>
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
                'pap_code.required' => 'PAP Code field is required.',
                'pap.required' => 'PAP field is required.',
                'obligation_type.required' => 'Obligation type field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'pap_code' => 'required',
                'pap' => 'required',
                'obligation_type' => 'required',
            ], $message);

            $input = $request->all();
            if ($validator->passes()) {
                $data = new LibraryPAPModel([
                    'pap_code' => $request->get('pap_code'),
                    'pap' => $request->get('pap'),
                    'description' => $request->get('description'),
                    'obligation_type' => $request->get('obligation_type'),
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
     * @param  \App\Models\LibraryPAPModel  $libraryPAPModel
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = LibraryPAPModel::find($request->get('id'));
            if ($data->count()) {
                return Response::json([
                    'status' => '1',
                    'library_pap' => $data,
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
    public function edit(LibraryPAPModel $libraryPAPModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\LibraryPAPModel  $libraryPAPModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $message = [
                'pap_code.required' => 'PAP Code field is required.',
                'pap.required' => 'PAP field is required.',
                'obligation_type.required' => 'Obligation type field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'pap_code' => 'required',
                'pap' => 'required',
                'obligation_type' => 'required',
            ], $message);

            $input = $request->all();

            if ($validator->passes()) {
                LibraryPAPModel::find($request->get('id'))
                    ->update([
                        'pap_code' => $request->get('pap_code'),
                        'pap' => $request->get('pap'),
                        'description' => $request->get('description'),
                        'obligation_type' => $request->get('obligation_type'),
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
     * @param  \App\Models\LibraryPAPModel  $libraryPAPModel
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($request->ajax()) {
            try {
                LibraryPAPModel::find($request->get('id'))
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
