<?php

namespace App\Http\Controllers;

use App\Models\NcaModel;
use Illuminate\Http\Request;
use Response;

class NcaController extends Controller
{
    public function index($fund_selected, $year_selected)
    {
        $user_id = auth()->user()->id;
        $nca = NcaModel::where('fund_id', $fund_selected)->where('year', $year_selected)->where('is_active', 1)->where('is_deleted', 0)->get();
        if (isset(request()->url)) {
            return redirect(request()->url);
        } else {
            if (auth()->user()->hasAnyRole('Accounting Officer|Cash Officer')) {
                $title = 'NCA';

                return view('programming_allocation.nca.index')
                    ->with(compact('user_id'))
                    ->with(compact('title'))
                    ->with(compact('fund_selected'))
                    ->with(compact('year_selected'))
                    ->with(compact('nca'));
            }
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = new NcaModel([
                'fund_id' => $request->fund_id,
                'year' => $request->year,
                'jan_nca' => $request->jan_nca ?? 0,
                'feb_nca' => $request->feb_nca ?? 0,
                'mar_nca' => $request->mar_nca ?? 0,
                'apr_nca' => $request->apr_nca ?? 0,
                'may_nca' => $request->may_nca ?? 0,
                'jun_nca' => $request->jun_nca ?? 0,
                'jul_nca' => $request->jul_nca ?? 0,
                'sep_nca' => $request->sep_nca ?? 0,
                'oct_nca' => $request->oct_nca ?? 0,
                'nov_nca' => $request->nov_nca ?? 0,
                'dec_nca' => $request->dec_nca ?? 0,
            ]);
            $data->save();

            return Response::json(['success' => '1']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(NcaModel $ncaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(NcaModel $ncaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NcaModel $ncaModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(NcaModel $ncaModel)
    {
        //
    }
}
