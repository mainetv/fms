<?php

namespace App\Http\Controllers;

use App\Models\LibraryObjectExpenditureModel;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use Response;
use Redirect;
use Session;
use View;
class LibraryObjectExpenditureController extends Controller
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
         $data = LibraryObjectExpenditureModel::where('is_deleted', 0)->latest();
         return DataTables::of($data)
            ->addIndexColumn()
            ->setRowAttr([
            'data-id' => function($library_object_expenditure) {
            return $library_object_expenditure->id;
            }
            ])
            ->addColumn('action', function($row){
            $btn =
            "<div>
               <button class='actionbtn view-library-expenditure' type='button'> 
               <i class='fas fa-eye'></i></a>                    
               </button>
               <button class='actionbtn update-library-expenditure' type='button'>
               <i class='fas fa-edit blue'></i>
               </button>
               <button class='actionbtn delete-library-expenditure red' type='button'>
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
        if ($request->ajax()) {
            $message = array(    
                'object_expenditure.required' => 'Object of expenditure field is required.',      
                'account_code.required' => 'Account Code field is required.',    
                'description.required' => 'Description field is required.',      
                'obligation_type.required' => 'Obligation type field is required.', 
            );
            $validator =  Validator::make($request->all(), [
                'object_expenditure' => 'required',
                'account_code' => 'required',
                'description' => 'required',
                'obligation_type' => 'required',
            ], $message);

            $input = $request->all();
            if ($validator->passes()) {
                $data = new LibraryObjectExpenditureModel([
                'object_expenditure' => $request->get('object_expenditure'),
                'account_code' => $request->get('account_code'),
                'description' => $request->get('description'),
                'expense' => $request->get('expense'),
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
     * @param  \App\Models\LibraryObjectExpenditureModel  $libraryActivityModel
     * @return \Illuminate\Http\Response
     */
   public function show(Request $request)
   {
      if($request->ajax()){
         $data = LibraryObjectExpenditureModel::find($request->get('id'));
         if($data->count()) {
            return Response::json([
            'status' => '1',
            'library_object_expenditure' => $data
            ]);
         } 
         else {
            return Response::json([
            'status' => '0'
            ]);
         } 
      }
   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LibraryObjectExpenditureModel  $libraryActivityModel
     * @return \Illuminate\Http\Response
     */
    public function edit(LibraryObjectExpenditureModel $libraryActivityModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LibraryObjectExpenditureModel  $libraryActivityModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $message = array(    
                'object_expenditure.required' => 'Object of expenditure field is required.',      
                'account_code.required' => 'Account Code field is required.',    
                'description.required' => 'Description field is required.',      
                'obligation_type.required' => 'Obligation type field is required.', 
            );
            $validator =  Validator::make($request->all(), [
                'object_expenditure' => 'required',
                'account_code' => 'required',
                'description' => 'required',
                'obligation_type' => 'required',
            ], $message);
            
            $input = $request->all();
            
            if ($validator->passes()) {
                LibraryPAPModel::find($request->get('id'))
                ->update([                  
                    'object_expenditure' => $request->get('object_expenditure'),
                    'account_code' => $request->get('account_code'),
                    'description' => $request->get('description'),
                    'expense' => $request->get('expense'),
                    'is_continuing' => $request->get('is_continuing'),
                    'remarks' => $request->get('remarks'),
                    'is_active' => $request->get('is_active'),
                ]);             
                return Response::json([
                'success' => '1',          
                'status' => '0'
                ]);
            }     
        return Response::json(['errors' => $validator->errors()]);
      }
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LibraryObjectExpenditureModel  $libraryActivityModel
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if($request->ajax()) {
            try {     
                LibraryObjectExpenditureModel::find($request->get('id'))
                ->update([
                'is_deleted' => '1'
            ]);
            }catch (\Exception $e) {
            return Response::json([
                'status'=>'0'
            ]);
            }
            return Response::json([
            'status'=>'1'
            ]);
        }
    }
}
