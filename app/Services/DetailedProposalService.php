<?php

namespace App\Services;

use App\Models\Library\LibraryProposalCodePrefix;
use App\Models\Proposal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DetailedProposalService
{
    protected $proposalService;

    public function __construct(ProposalService $proposalService)
    {
        $this->proposalService = $proposalService;
    }

    // create new detailed proposal
    public function createProposal($request)
    {
        $user = Auth::user();

        $proposal_type_id = $request['proposal_type_id'];
        $proposal = new Proposal([
            'call_proposal_id' => $request['call_proposal_id'],
            'proposal_type_id' => $proposal_type_id,
            'proposal_category_id' => 2,
            'resume_part' => 2,
            'by_user_id' => $user->id,
        ]);
        $proposal->save();

        $this->proposalService->createFirstProposalStatus($proposal->id);
        $this->proposalService->updateOrCreateProposalPersonnel($request, $proposal->id);

        return $proposal;
        // return ['success' => true,'redirect_url' => route('proposal.detailed.resume', [
        //    'type' => $proposal_type_id,
        //    'part' => 2,
        //    'id' => $id
        // ])];
    }

    public function updatePart1($request)
    {
        $proposal_id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        Proposal::find($proposal_id)
            ->update([
                'call_proposal_id' => $request['call_proposal_id'],
                'proposal_type_id' => $proposal_type_id,
                'proposal_classification_id' => $request['proposal_classification_id'],
                'resume_part' => 2,
            ]);

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => 2,
            'id' => $proposal_id,
        ])];
    }

    public function updatePart2($request)
    {
        $id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        if ($proposal_type_id == 1) {
            Proposal::find($id)->update([
                'title' => $request['title'] ?? $request['program_title'],
                'resume_part' => 3,
            ]);
            $this->proposalService->updateOrCreateProposalDuration($request, $id);
            $this->proposalService->updateOrCreateProposalImplementingAgency($request, $id);
            $this->proposalService->updateOrCreateProposalBudgetSummary($id);
            $this->proposalService->updateOrCreatePersonnelRequirement($request, $id);
        } elseif ($proposal_type_id == 2) {
            Proposal::find($id)->update([
                'program_id' => $request['program_id'],
                'title' => $request['title'],
                'socio_economic_agenda_id' => $request['socio_economic_agenda_id'],
                'resume_part' => 3,
            ]);
            $this->proposalService->updateOrCreateProposalDuration($request, $id);
            $this->proposalService->updateOrCreateProposalImplementingAgency($request, $id);
            $this->proposalService->updateOrCreateProposalCoImplementingAgencies($request, $id);
            $this->proposalService->updateOrCreateProposalRDPrograms($request, $id);
            $this->proposalService->updateOrCreateProposalPillars($request, $id);
            $this->proposalService->updateOrCreateProposalThematicAreas($request, $id);
            $this->proposalService->updateOrCreateProposalSDGs($request, $id);
            $this->proposalService->updateOrCreateProposalLIB($request, $id);
        } elseif ($proposal_type_id == 3 || $proposal_type_id == 4) {
            Proposal::find($id)->update([
                'program_id' => $request['program_id'],
                'title' => $request['title'],
                'resume_part' => 3,
            ]);
            $this->proposalService->updateOrCreateProposalDuration($request, $id);
            $this->proposalService->updateOrCreateProposalImplementingAgency($request, $id);
            $this->proposalService->updateOrCreateSDGs($request, $id);
            $this->proposalService->updateOrCreateBudgetSummary($id);
            $this->proposalService->updateOrCreateFirstLIB($request, $id);
        }

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => 3,
            'id' => $id,
        ])];
    }

    public function updatePart3($request)
    {
        $proposal_id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        if ($proposal_type_id == 1) {
            Proposal::find($proposal_id)->update([
                'general_objectives' => $request['general_objectives'],
                'specific_objectives' => $request['specific_objectives'],
                'significance' => $request['significance'],
                'methodology' => $request['methodology'],
                'conceptual_framework' => $request['conceptual_framework'],
                'project_utilization' => $request['project_utilization'],
                'resume_part' => 4,
            ]);
        } elseif ($proposal_type_id == 2) {
            Proposal::find($proposal_id)->update([
                'executive_summary' => $request['executive_summary'],
                'introduction' => $request['introduction'],
                'rationale' => $request['rationale'],
                'scientific_basis' => $request['scientific_basis'],
                'general_objectives' => $request['general_objectives'],
                'review_of_literature' => $request['review_of_literature'],
                'technology_roadmap' => $request['technology_roadmap'],
                'target_beneficiaries' => $request['target_beneficiaries'],
                'sustainability_plan' => $request['sustainability_plan'],
                'limitations' => $request['limitations'],
                'risk_management' => $request['risk_management'],
                'literature_cited' => $request['literature_cited'],
                'methodology' => $request['methodology'],
                'resume_part' => 4,
            ]);
            // dd($request);
            $this->proposalService->updateOrCreateExpectedOutputs($request, $proposal_id);
        } elseif ($proposal_type_id == 3 || $proposal_type_id == 4) {
            Proposal::find($proposal_id)->update([
                'executive_summary' => $request['executive_summary'],
                'rationale' => $request['rationale'],
                'general_objectives' => $request['general_objectives'],
                'specific_objectives' => $request['specific_objectives'],
                'methodology' => $request['methodology'],
                'technology_roadmap' => $request['technology_roadmap'],
                'potential_outcomes' => $request['potential_outcomes'],
                'potential_impacts' => $request['potential_impacts'],
                'project_utilization' => $request['discussion'],
                'target_beneficiaries' => $request['target_beneficiaries'],
                'sustainability_plan' => $request['sustainability_plan'],
                'limitations' => $request['limitations'],
                'risk_management' => $request['risk_management'],
                'literature_cited' => $request['literature_cited'],
                'resume_part' => 4,
            ]);
            $this->proposalService->updateOrCreateExpectedOutputs($request, $proposal_id);
        }

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => 4,
            'id' => $proposal_id,
        ])];
    }

    public function updatePart4($request)
    {
        $proposal_id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        Proposal::find($proposal_id)->update([
            'resume_part' => 5,
        ]);

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => 5,
            'id' => $proposal_id,
        ])];
    }

    public function updatePart5($request)
    {
        $proposal_id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        Proposal::find($proposal_id)->update([
            'resume_part' => 6,
        ]);

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => 6,
            'id' => $proposal_id,
        ])];
    }

    public function updatePart6($request)
    {
        $proposal_id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        // $scores = $request->input('scores', []);
        // $comments = $request->input('comments', []);
        Proposal::find($proposal_id)->update([
            'resume_part' => 7,
        ]);
        // $this->updateOrCreateGADScore($proposal_id, $scores, $comments);

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => 7,
            'id' => $proposal_id,
        ])];
    }

    public function updatePart7($request)
    {
        $proposal_id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        Proposal::find($proposal_id)->update([
            'resume_part' => 8,
        ]);

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => 8,
            'id' => $proposal_id,
        ])];
    }

    public function updatePart8($request)
    {
        $proposal_id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        Proposal::find($proposal_id)->update([
            'resume_part' => 9,
        ]);

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => 9,
            'id' => $proposal_id,
        ])];
    }

    public function updatePart9($request)
    {
        $proposal_id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        Proposal::find($proposal_id)->update([
            'resume_part' => 10,
        ]);

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => 10,
            'id' => $proposal_id,
        ])];
    }

    public function submit($request)
    {
        $now = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');
        $year_now = Carbon::now()->timezone('Asia/Manila')->format('Y');
        $id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        $padding = 4;
        $count = Proposal::whereYear('submitted_at', $year_now)->withTrashed()->count() + 1;
        if ($count > 9999) {
            $padding = 5;
        }
        $formatted_count = str_pad($count, $padding, '0', STR_PAD_LEFT);
        $proposal_code_prefix = LibraryProposalCodePrefix::whereProposalTypeId($proposal_type_id)->whereProposalCategoryId(2)->pluck('prefix')->first();
        $proposal_code = $proposal_code_prefix.'-'.$year_now.'-'.$formatted_count;

        // with component projects
        Proposal::find($id)->update([
            'proposal_code' => $proposal_code,
            'submitted_at' => $now,
        ]);

        $getComponentProjects = Proposal::whereProgramId($id)->get(); // Use get() to retrieve the collection
        if ($getComponentProjects->isNotEmpty()) {
            foreach ($getComponentProjects as $project) {
                $padding = 4;
                $count = Proposal::whereYear('submitted_at', $year_now)->withTrashed()->count() + 1;
                if ($count > 9999) {
                    $padding = 5;
                }
                $formatted_count = str_pad($count, $padding, '0', STR_PAD_LEFT);
                $proposal_code_prefix = LibraryProposalCodePrefix::whereProposalTypeId(9)->whereProposalCategoryId(1)->pluck('prefix')->first();
                $proposal_code = $proposal_code_prefix.'-'.$year_now.'-'.$formatted_count;
                Proposal::find($project->id)->update([
                    'proposal_code' => $proposal_code,
                    'submitted_at' => $now,
                ]);
                Proposal::find($project->id)->update([
                    'proposal_code' => $proposal_code,
                    'submitted_at' => $now,
                ]);
                $this->proposalService->updateAndCreateProposalStatus($request, $project->id);
            }
        }
        $this->proposalService->updateAndCreateProposalStatus($request, $id);

        return ['success' => true, 'redirect_url' => route('proposal.detailed.submitted')];

    }

    public function previous($request)
    {
        $proposal_id = $request['proposal_id'];
        $proposal_type_id = $request['proposal_type_id'];
        $part = $request['part'];
        Proposal::find($proposal_id)->update([
            'resume_part' => $part,
        ]);

        return ['success' => true, 'redirect_url' => route('proposal.detailed.resume', [
            'type' => $proposal_type_id,
            'part' => $part,
            'id' => $proposal_id,
        ])];
    }
}
