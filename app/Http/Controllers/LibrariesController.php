<?php

namespace App\Http\Controllers;

use App\Models\BpForm3Model;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Response;
use Validator;

class LibrariesController extends Controller
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
        $year = Carbon::now()->format('Y');
        if ($request->ajax()) {
            if (! empty($request->year_selected)) {
                $data = BpForm3Model::where('year', $request->year_selected)
                    ->where('is_active', 1)->where('is_deleted', 0)->latest();
            } else {
                $data = BpForm3Model::where('year', $year)
                    ->where('is_active', 1)->where('is_deleted', 0)->latest();
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->setRowAttr([
                    'data-id' => function ($bp_form3) {
                        return $bp_form3->id;
                    },
                ])
                ->addColumn('action', function ($row) {
                    $btn =
                    "<div>
                  <button class='actionbtn view-bp-form3' type='button'> 
                  <i class='fas fa-eye'></i></a>                    
                  </button>
                  <button class='actionbtn update-bp-form3' type='button'>
                  <i class='fas fa-edit blue'></i>
                  </button>
                  <button class='actionbtn delete-bp-form3 red' type='button'>
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
            // dd($request);
            $message = [
                'description.required' => 'Description field is required.',
                'area_sqm.required' => 'Area/SQM field is required and should be a number.',
                'location.required' => 'Location field is required.',
                'amount.required' => 'Amount field is required and should be a number.',
                'justification.required' => 'Justification field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'description' => 'required',
                'area_sqm' => 'required', 'integer',
                'location' => 'required',
                'amount' => 'required', 'integer',
                'justification' => 'required',
            ], $message);

            $input = $request->all();
            if ($validator->passes()) {
                $data = new BpForm3Model([
                    'division_id' => $request->get('division_id'),
                    'year' => $request->get('year'),
                    'description' => $request->get('description'),
                    'area_sqm' => $request->get('area_sqm'),
                    'location' => $request->get('location'),
                    'amount' => $request->get('amount'),
                    'justification' => $request->get('justification'),
                    'remarks' => $request->get('remarks'),
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
     * @param  \App\Models\BpForm3Model  $dOSTForm3Model
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = BpForm3Model::find($request->get('id'));
            if ($data->count()) {
                return Response::json([
                    'status' => '1',
                    'bp_form3' => $data,
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
     * @param  \App\Models\BpForm3Model  $dOSTForm3Model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all()); exit();
            $message = [
                'description.required' => 'Description field is required.',
                'area_sqm.required' => 'Area/SQM field is require and should be a number',
                'location.required' => 'Location field is required.',
                'amount.required' => 'Amount field is required and should be a number.',
                'justification.required' => 'Justification field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'description' => 'required',
                'area_sqm' => 'required', 'integer',
                'location' => 'required',
                'amount' => 'required', 'integer',
                'justification' => 'required',
            ], $message);

            $input = $request->all();

            if ($validator->passes()) {
                BpForm3Model::find($request->get('id'))
                    ->update([
                        'description' => $request->get('description'),
                        'area_sqm' => $request->get('area_sqm'),
                        'location' => $request->get('location'),
                        'amount' => $request->get('amount'),
                        'justification' => $request->get('justification'),
                        'remarks' => $request->get('remarks'),
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
    public function delete(Request $request, BpForm3Model $dOSTForm3Model)
    {
        if ($request->ajax()) {
            try {
                BpForm3Model::find($request->get('id'))
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
