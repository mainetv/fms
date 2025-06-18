<?php

namespace App\Services;

use App\Models\Library\LibraryProposalCodePrefix;
use App\Models\Proposal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConceptProposalService
{
    protected $proposalService;

    public function __construct(ProposalService $proposalService)
    {
        $this->proposalService = $proposalService;
    }

    public function createProgramProposal()
    {
        $user = Auth::user();
        $proposal = new Proposal([
            'proposal_category_id' => 1,
            'proposal_type_id' => 8,
            'by_user_id' => $user->id,
        ]);
        $proposal->save();

        $this->proposalService->createFirstProposalStatus($proposal->id);
        $this->proposalService->createProposalPersonnel($proposal->id);

        return $proposal->id;
    }

    public function createProjectProposal()
    {
        $user = Auth::user();
        $proposal = new Proposal([
            'proposal_category_id' => 1,
            'proposal_type_id' => 9,
            'by_user_id' => $user->id,
        ]);
        $proposal->save();

        $this->proposalService->createFirstProposalStatus($proposal->id);
        $this->proposalService->createProposalPersonnel($proposal->id);

        return $proposal->id;
    }

    public function createComponentProjectProposal($request)
    {
        $user = Auth::user();
        $estimated_budget = preg_replace('/,/', '', $request['estimated_budget']);
        $proposal = new Proposal([
            'program_id' => $request['program_id'] ?? '',
            'call_proposal_id' => $request['call_proposal_id'] ?? '',
            'title' => $request['title'],
            'proposal_category_id' => 1,
            'proposal_type_id' => 9,
            'estimated_budget' => $estimated_budget,
            'principal_research_question' => $request['principal_research_question'],
            'executive_summary' => $request['executive_summary'],
            'is_component_project' => $request['is_component_project'],
            'by_user_id' => $user->id,
        ]);
        $proposal->save();
        $this->proposalService->createFirstProposalStatus($proposal->id);
        $this->proposalService->updateOrCreateProposalDuration($request, $proposal->id);
        $this->proposalService->updateOrCreateProposalPersonnel($request, $proposal->id);
        $this->proposalService->updateOrCreateProposalLeaderOngoingProjects($request, $proposal->id);
        $this->proposalService->updateOrCreateProposalImplementingAgency($request, $proposal->id);
        $this->proposalService->updateOrCreateProposalCooperatingAgencies($request, $proposal->id);
        $this->proposalService->updateOrCreateProposalImplementationSites($request, $proposal->id);
        $this->proposalService->updateOrCreateProposalRDPrograms($request, $proposal->id);
        $this->proposalService->updateOrCreateProposalPillars($request, $proposal->id);
        $this->proposalService->updateOrCreateProposalThematicAreas($request, $proposal->id);

        return true;
    }

    public function updateProgramProposal($request, $id)
    {
        $id = $request['id'];
        $estimated_budget = preg_replace('/,/', '', $request['program_estimated_budget']);
        Proposal::find($id)->update([
            'call_proposal_id' => $request['call_proposal_id'] ?? '',
            'title' => $request['program_title'],
            'estimated_budget' => $estimated_budget,
            'principal_research_question' => $request['program_principal_research_question'],
            'executive_summary' => $request['program_summary'],
        ]);
        $this->proposalService->updateOrCreateProposalDuration($request, $id);
        $this->proposalService->updateOrCreateProposalPersonnel($request, $id);
    }

    public function updateProjectProposal($request, $id)
    {
        $estimated_budget = preg_replace('/,/', '', $request['estimated_budget']);
        Proposal::find($id)->update([
            'title' => $request['title'],
            'estimated_budget' => $estimated_budget,
            'principal_research_question' => $request['principal_research_question'],
            'executive_summary' => $request['executive_summary'],
        ]);
        $this->proposalService->updateOrCreateProposalDuration($request, $id);
        $this->proposalService->updateOrCreateProposalPersonnel($request, $id);
        $this->proposalService->updateOrCreateProposalLeaderOngoingProjects($request, $id);
        $this->proposalService->updateOrCreateProposalImplementingAgency($request, $id);
        $this->proposalService->updateOrCreateProposalCooperatingAgencies($request, $id);
        $this->proposalService->updateOrCreateProposalImplementationSites($request, $id);
        $this->proposalService->updateOrCreateProposalRDPrograms($request, $id);
        $this->proposalService->updateOrCreateProposalPillars($request, $id);
        $this->proposalService->updateOrCreateProposalThematicAreas($request, $id);

        return true;
    }

    public function submit($request)
    {
        $now = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');
        $year_now = Carbon::now()->timezone('Asia/Manila')->format('Y');
        $id = $request['id'];
        $proposal_type_id = $request['proposal_type_id'];
        $padding = 4;
        $count = Proposal::whereYear('submitted_at', $year_now)->withTrashed()->count() + 1;
        if ($count > 9999) {
            $padding = 5;
        }

        $formatted_count = str_pad($count, $padding, '0', STR_PAD_LEFT);
        $proposal_code_prefix = LibraryProposalCodePrefix::whereProposalTypeId($proposal_type_id)->whereProposalCategoryId(1)->pluck('prefix')->first();
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

                $this->proposalService->updateAndCreateProposalStatus($request, $project->id);
            }
        }
        $this->proposalService->updateAndCreateProposalStatus($request, $id);

        return ['success' => true, 'redirect_url' => route('proposal.concept.submitted')];
    }
}
