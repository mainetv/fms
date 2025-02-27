<?php

namespace App\Services;

use App\Models\Library\LibraryHonorariaRole;
use App\Models\Library\LibraryPosition;
use App\Models\Library\LibrarySalaryGradeRate;
use App\Models\Proposal\ProposalLIB;
use App\Models\Proposal\ProposalLIBCOItem;
use App\Models\Proposal\ProposalLIBMOOEItem;
use App\Models\Proposal\ProposalLIBPSItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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
