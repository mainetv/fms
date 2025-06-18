<?php

namespace App\Http\Controllers;

use DataTables;
use DB;
use Illuminate\Http\Request;

class LibraryExpenseAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('view_library_expense_account')->where('is_deleted', 0)->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->setRowAttr([
                    'data-id' => function ($library_expense_account) {
                        return $library_expense_account->id;
                    },
                ])
                ->addColumn('action', function ($row) {
                    $btn =
                    "<div>
                <button class='actionbtn view-library-expense' type='button'> 
                <i class='fas fa-eye'></i></a>                    
                </button>
                <button class='actionbtn update-library-expense' type='button'>
                <i class='fas fa-edit blue'></i>
                </button>
                <button class='actionbtn delete-library-expense red' type='button'>
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LibraryExpenseTitleModel  $libraryExpenseTitleModel
     * @return \Illuminate\Http\Response
     */
    public function show(LibraryExpenseTitleModel $libraryExpenseTitleModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LibraryExpenseTitleModel  $libraryExpenseTitleModel
     * @return \Illuminate\Http\Response
     */
    public function edit(LibraryExpenseTitleModel $libraryExpenseTitleModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\LibraryExpenseTitleModel  $libraryExpenseTitleModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibraryExpenseTitleModel $libraryExpenseTitleModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LibraryExpenseTitleModel  $libraryExpenseTitleModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibraryExpenseTitleModel $libraryExpenseTitleModel)
    {
        //
    }
}
