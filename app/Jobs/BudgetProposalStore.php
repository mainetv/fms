<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Response;
use Validator;

class BudgetProposalStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        if ($request->ajax()) {
            $message = [
                'pap_code.required' => 'Please select PAP.',
            ];
            $validator = Validator::make($request->all(), [
                'pap_code' => 'required',
            ], $message);

            $input = $request->all();
            if ($validator->passes()) {
                $data = new ViewBpPAPModel([
                    'budget_proposal_id' => $request->get('budget_proposal_id'),
                    'pap_code' => $request->get('pap_code'),
                ]);
                $data->save();

                return Response::json(['success' => '1']);
            }

            return Response::json(['errors' => $validator->errors()]);
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
