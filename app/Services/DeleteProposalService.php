<?php

namespace App\Services;

use App\Models\Proposal;
use Exception;

class DeleteProposalService
{
    public function deleteProposal($id)
    {
        $proposal = Proposal::find($id);
        if (! $proposal) {
            throw new Exception('Proposal not found');
        }
        $proposal->delete();
    }
}
