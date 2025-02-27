<?php

namespace App\Services;

use App\Models\Evaluation\Library\Comment;
use App\Models\Evaluation\ProposalComment;
use App\Models\Evaluation\ProposalTracking;
use App\Models\Proposal;
use Exception;
use Illuminate\Support\Facades\Auth;

use App\Mail\TestEmail;
use App\Models\Evaluation\ListForDC;
use App\Models\Library\ProposalTrackingStatus;
use App\Models\Proposal\ProposalStatus;
use Illuminate\Support\Facades\Mail;

class EvaluationService
{
   public function create($request)
   {
      //return response($request,500);
      $failedstatus = [5,8,11,5]; 

      if(in_array($request['status'], $failedstatus)) {
            $statuspass = 'failed';
         }else {
            $statuspass = 'active';
         }

      //GET LAST STATUS
         $lastStatus = ProposalTracking::where('proposal_id',$request['proposal_id'])->orderBy('id','desc')->first();
         $proposalTracking = ProposalTracking::where('proposal_id',$request['proposal_id'])
         ->where('proposal_tracking_status_id',$lastStatus['proposal_tracking_status_id'])
         ->update([
            'status' => 'passed'
         ]);

      

      //SAVE TRACKING HISTORY
      $proposalTracking = new ProposalTracking();
      $proposalTracking->proposal_id = $request['proposal_id'];
      $proposalTracking->proposal_tracking_status_id = $request['status'];
      $proposalTracking->status = $statuspass;
      $proposalTracking->save();

      if($request['status'] == 6)
      {
         $forDC = new ListForDC();
         $forDC->proposal_id = $request['proposal_id'];
         $forDC->user_id = Auth::user()->id;
         $forDC->save();
      }
      
      $desc = ProposalTrackingStatus::where('id',$request['status'])->first();
      addToAuditTrail($request['proposal_id'],$desc['description']);
      
   }

   public function create2($request)
   {
      return response($request,500);

      //IF TREP SEND EMAIL FIRST
      if($request['status'] == 3)
      {
         Mail::send(new TestEmail('diaz.mark.anthony@gmail.com'));
      }
      
      
      $remarks = "";
      // $statuspass = $request['status_pass'];
      $statuspass = 'passed';
      if($statuspass == 'failed')
      {
         $remarks = $request['remarks'];
      }
      else
      {
         //GET LAST STATUS
         $lastStatus = ProposalTracking::where('proposal_id',$request['proposal_id'])->orderBy('id','desc')->first();
         $proposalTracking = ProposalTracking::where('proposal_id',$request['proposal_id'])
         ->where('proposal_tracking_status_id',$lastStatus['proposal_tracking_status_id'])
         ->update([
            'status' => 'passed'
         ]);
      }
         
      //SAVE TRACKING HISTORY
      $proposalTracking = new ProposalTracking();
      $proposalTracking->proposal_id = $request['proposal_id'];
      $proposalTracking->proposal_tracking_status_id = $request['status'];
      $proposalTracking->status = $statuspass;
      $proposalTracking->remarks = $remarks;
      $proposalTracking->save();


      $desc = 'N/A';
      switch ($request['status']) {
         case 3:
               $desc = "Sent to TREP";
            break;
         
         case 4:
               $desc = "Endorsed to DC";
               // if($statuspass == 'failed')
               //    $desc = "DC Disapprove : ".$remarks;

               //MAKE A LIST FOR DC Presentation
               $forDC = new ListForDC();
               $forDC->proposal_id = $request['proposal_id'];
               $forDC->user_id = Auth::user()->id;
               $forDC->save();

            break;

         case 5:
               $desc = "Endorsed to GC";
               if($statuspass == 'failed')
                  $desc = "GC Disapprove : ".$remarks;
            break;

         case 6:
               $desc = "Approve";
            break;

         case 7:
               $desc = "Disapprove : ".$request['remarks'];
            break;
      }

      addToAuditTrail($request['proposal_id'],$desc);
      

   }
}
