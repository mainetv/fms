<?php

namespace App\Services;

use App\Models\Evaluation\Library\Comment;
use App\Models\Evaluation\ProposalComment;
use Exception;
use Illuminate\Support\Facades\Auth;

class CommentProposalService
{
   public function updateOrCreate($request)
   {

      $commentsection = Comment::get();

      foreach ($commentsection as $key => $value) {

         if(isset($request[$value->label]))
         {

            $proposalcomment = ProposalComment::updateOrCreate(
               [
                  'proposal_id' => $request['proposal_id'],
                  'user_id' => Auth::user()->id,
                  'library_comment_section_id' => $value->id
               ],
               [
                  'proposal_id' => $request['proposal_id'],
                  'user_id' => Auth::user()->id,
                  'library_comment_section_id' => $value->id,
                  'description' => $request[$value->label],
               ]
           );
         }
         
      }

   }

   public function create($request)
   {
      
      $commentsection = Comment::get();

      foreach ($commentsection as $key => $value) {

         if(isset($request[$value->label]))
         {
            $proposalcomment = new ProposalComment();
            $proposalcomment->proposal_id = $request['proposal_id'];
            $proposalcomment->user_id = Auth::user()->id;
            $proposalcomment->library_comment_section_id = $value->id;
            $proposalcomment->description = $request[$value->label];
            $proposalcomment->save();
         }
         
      }

   }
}
