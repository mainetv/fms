<?php

namespace App\Services;

use App\Models\Proposal\ProposalLIBCOItem;

class ReportService
{
    public function viewFAR1($request, $id)
    {
        $amount = preg_replace('/,/', '', $request['amount']);
        ProposalLIBCOItem::find($id)
            ->update([
                'cost_type_id' => $request['cost_type_id'],
                'implementing_monitoring_agency_id' => $request['implementing_monitoring_agency_id'],
                'quantity' => $request['quantity'],
                'description' => $request['description'],
                'funding_agency_id' => $request['funding_agency_id'] ?? null,
                'dost_funding_agency_id' => $request['dost_funding_agency_id'] ?? null,
                'amount' => $amount ?? 0,
            ]);
        $lib_id = ProposalLIBCOItem::whereId($id)->pluck('lib_id')->first();
        $this->updateProposalLib($lib_id);

        return true;
    }
}
