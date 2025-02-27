<?php

namespace App\Services;

use App\Models\Evaluation\DCComment;
use Exception;
use Illuminate\Support\Facades\Auth;

use App\Models\Evaluation\ListForDC;
use App\Models\Evaluation\ProposalTracking;
use Illuminate\Http\Request;

class ForDCPresentationService
{
   public function updateOrCreate(Request $request,$id)
   {
      $proposal = ListForDC::updateOrCreate(
         ['id' => $id],
         [
             'status' => $request->dc_status,
         ]
     );
   }

   public function createComment(Request $request)
   {
      //SAVE TRACKING HISTORY
      $dcComment = new DCComment();
      $dcComment->proposal_id = $request->proposal_id;
      $dcComment->description = $request->dc_comment;
      $dcComment->user_id = Auth::user()->id;
      $dcComment->save();
   }
   
}
