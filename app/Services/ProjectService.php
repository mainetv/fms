<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Project\ProjectAgency;
use App\Models\Project\ProjectDuration;
use App\Models\Project\ProjectLIB;
use App\Models\Project\ProjectLIBCOItem;
use App\Models\Project\ProjectLIBMOOEItem;
use App\Models\Project\ProjectLIBPSItem;
use App\Models\Project\ProjectStatus;
use App\Models\Proposal;
use App\Models\Proposal\ProposalAgency;
use App\Models\Proposal\ProposalDOSTPillar;
use App\Models\Proposal\ProposalDOSTStrategicProgram;
use App\Models\Proposal\ProposalDOSTThematicArea;
use App\Models\Proposal\ProposalDuration;
use App\Models\Proposal\ProposalLIB;
use App\Models\Proposal\ProposalLIBCOItem;
use App\Models\Proposal\ProposalLIBMOOEItem;
use App\Models\Proposal\ProposalLIBPSItem;
use App\Models\Proposal\ProposalPersonnel;
use App\Models\Proposal\ProposalRDProgram;
use App\Models\Proposal\ProposalSDG;
use App\Models\Proposal\ProposalSite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProjectService
{
   public function createProject($id)
   {
      $user = Auth::user();
      $getProposalDetail = Proposal::whereId($id)->first();
      $getProposalDuration = ProposalDuration::whereProposalId($id)->get();
      $getProposalImplementingAgency = ProposalAgency::whereProposalId($id)->whereAgencyRoleId(1)->get();
      $getProposalCoImplementingAgency = ProposalAgency::whereProposalId($id)->whereAgencyRoleId(2)->get();
      $getProposalCooperatingAgency = ProposalAgency::whereProposalId($id)->whereAgencyRoleId(3)->get();
      $getProposalLIB = ProposalLIB::whereProposalId($id)->get();
      $lib_id = ProposalLIB::whereProposalId($id)->pluck('id')->first();
      $getProposalLIBPsItem = ProposalLIBPSItem::whereLibId($lib_id)->get();
      $getProposalLIBMooeItem = ProposalLIBMOOEItem::whereLibId($lib_id)->get();
      $getProposalLIBCoItem = ProposalLIBCOItem::whereLibId($lib_id)->get();
      $getProposalSDG = ProposalSDG::whereProposalId($id)->get();
      $getProposalDOSTPillar = ProposalDOSTPillar::whereProposalId($id)->get();
      $getProposalDOSTStrategicProgram = ProposalDOSTStrategicProgram::whereProposalId($id)->get();
      $getProposalDOSTThematicArea = ProposalDOSTThematicArea::whereProposalId($id)->get();
      $getProposalPersonnel = ProposalPersonnel::whereProposalId($id)->get();
      $getProposalRDProgram = ProposalRDProgram::whereProposalId($id)->get();
      $getProposalSite = ProposalSite::whereProposalId($id)->get();
      $project = new Project([
         'proposal_id' => $id,
         'title' => $getProposalDetail->title,
         'socio_economic_agenda_id' => $getProposalDetail->socio_economic_agenda_id,
         'executive_summary' => $getProposalDetail->executive_summary,
         'introduction' => $getProposalDetail->introduction,
         'rationale' => $getProposalDetail->rationale,
         'scientific_basis' => $getProposalDetail->scientific_basis,
         'general_objectives' => $getProposalDetail->general_objectives,
         'specific_objectives' => $getProposalDetail->specific_objectives,
         'significance' => $getProposalDetail->significance,
         'review_of_literature' => $getProposalDetail->review_of_literature,
         'methodology' => $getProposalDetail->methodology,
         'conceptual_framework' => $getProposalDetail->conceptual_framework,
         'project_utilization' => $getProposalDetail->project_utilization,
         'technology_roadmap' => $getProposalDetail->technology_roadmap,
         'expected_outputs' => $getProposalDetail->expected_outputs,
         'potential_outcomes' => $getProposalDetail->potential_outcomes,
         'potential_impacts' => $getProposalDetail->potential_impacts,
         'target_beneficiaries' => $getProposalDetail->target_beneficiaries,
         'sustainability_plan' => $getProposalDetail->sustainability_plan,
         'limitations' => $getProposalDetail->limitations,
         'risk_management' => $getProposalDetail->risk_management,
         'literature_cited' => $getProposalDetail->literature_cited,
         'is_component_project' => $getProposalDetail->is_component_project,
         'by_user_id' => $getProposalDetail->by_user_id
      ]);
      $project->save();

      $this->createFirstProjectStatus($project->id);
      $this->createProjectDurationFromProposal($getProposalDuration, $project->id);
      $this->createProjectImplementingAgencyFromProposal($getProposalImplementingAgency, $project->id);
      $this->createProjectlCoImplementingAgencyFromProposal($getProposalCoImplementingAgency, $project->id);
      $this->createProjectCooperatingAgencyFromProposal($getProposalCooperatingAgency, $project->id);
      $this->createProjectLIBFromProposal($getProposalLIB, $getProposalLIBPsItem, $getProposalLIBMooeItem, $getProposalLIBCoItem, $project->id);
   }

   public function createFirstProjectStatus($id)
   {
      $user = Auth::user();
      $data = new ProjectStatus([
         'project_id' => $id,
         'status_id' => 1,
         'by_user_id' => $user->id,
      ]);
      $data->save();
   }

   public function createProjectDurationFromProposal($getProposalDuration, $id)
   {
      foreach ($getProposalDuration as $duration) {
         $data = new ProjectDuration([
            'project_id' => $id,
            'start_date' => $duration->start_date,
            'end_date' => $duration->end_date,
         ]);
         $data->save();
      }
   }

   public function createProjectImplementingAgencyFromProposal($getProposalImplementingAgency, $id)
   {
      foreach ($getProposalImplementingAgency as $implementing_agency) {
         $data = new ProjectAgency([
            'project_id' => $id,
            'agency_id' => $implementing_agency->agency_id,
            'smallest_unit_id' => $implementing_agency->smallest_unit_id ?? null,
            'agency_role_id' => 1,
            'is_lead' => $implementing_agency->is_lead ?? 0,
         ]);
         $data->save();
      }
   }

   public function createProjectlCoImplementingAgencyFromProposal($getProposalCoImplementingAgency, $id)
   {
      foreach ($getProposalCoImplementingAgency as $cooperating_agency) {
         $data = new ProjectAgency([
            'project_id' => $id,
            'agency_id' => $cooperating_agency->agency_id,
            'agency_role_id' => 2,
         ]);
         $data->save();
      }
   }

   public function createProjectCooperatingAgencyFromProposal($getProposalCooperatingAgency, $id)
   {
      foreach ($getProposalCooperatingAgency as $cooperating_agency) {
         $data = new ProjectAgency([
            'project_id' => $id,
            'agency_id' => $cooperating_agency->agency_id,
            'agency_role_id' => 3,
            'cooperating_role_id' => $cooperating_agency->cooperating_role_id,
         ]);
         $data->save();
      }
   }

   public function createProjectLIBFromProposal($getProposalLIB, $getProposalLIBPsItem, $getProposalLIBMooeItem, $getProposalLIBCoItem, $id)
   {
      foreach ($getProposalLIB as $lib) {
         $data = new ProjectLIB([
            'project_id' => $id,
            'project_year' => $lib->project_year,
            'dost_fund_agency_id' => $lib->dost_fund_agency_id,
            'counterpart_fund_agency_id' => $lib->counterpart_fund_agency_id,
            'dost_fund_amount' => $lib->dost_fund_amount,
            'counterpart_fund_amount' => $lib->counterpart_fund_amount,
         ]);
         $data->save();

         $this->createProjectLIBPs($getProposalLIBPsItem, $lib->id);
         $this->createProjectLIBMooe($getProposalLIBMooeItem, $lib->id);
         $this->createProjectLIBCo($getProposalLIBCoItem, $lib->id);
      }
   }

   public function createProjectLIBPs($getProposalLIBPsItem, $id)
   {
      foreach ($getProposalLIBPsItem as $lib_ps) {
         $data = new ProjectLIBPSItem([
            'lib_id' => $id,
            'cost_type_id' => $lib_ps->cost_type_id,
            'implementing_monitoring_agency_id' => $lib_ps->implementing_monitoring_agency_id,
            'ps_type_id' => $lib_ps->ps_type_id,
            'position_role_id' => $lib_ps->position_role_id,
            'quantity' => $lib_ps->quantity,
            'funding_agency_id' => $lib_ps->funding_agency_id,
            'dost_funding_agency_id' => $lib_ps->dost_funding_agency_id,
            'months' => $lib_ps->months,
            'amount' => $lib_ps->amount,
            'percentage_time' => $lib_ps->percentage_time,
            'responsibilities' => $lib_ps->responsibilities,
         ]);
         $data->save();
      }
   }

   public function createProjectLIBMooe($getProposalLIBMooeItem, $id)
   {
      foreach ($getProposalLIBMooeItem as $lib_mooe) {
         $data = new ProjectLIBMOOEItem([
            'lib_id' => $id,
            'cost_type_id' => $lib_mooe->cost_type_id,
            'implementing_monitoring_agency_id' => $lib_mooe->implementing_monitoring_agency_id,
            'expense_account_id' => $lib_mooe->expense_account_id,
            'object_expenditure_id' => $lib_mooe->object_expenditure_id,
            'object_specific_id' => $lib_mooe->object_specific_id,
            'funding_agency_id' => $lib_mooe->funding_agency_id,
            'dost_funding_agency_id' => $lib_mooe->dost_funding_agency_id,
            'amount' => $lib_mooe->amount,
         ]);
         $data->save();
      }
   }

   public function createProjectLIBCo($getProposalLIBCoItem, $id)
   {
      foreach ($getProposalLIBCoItem as $lib_co) {
         $data = new ProjectLIBCOItem([
            'lib_id' => $id,
            'cost_type_id' => $lib_co->cost_type_id,
         ]);
         $data->save();
      }
   }
}
