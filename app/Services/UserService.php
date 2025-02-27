<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserService
{
   public function createUser($request)
   {
      dd($request);
      $emp_code = $request['emp_code'];
      $data = new User([
         'emp_code' => $emp_code,
         'username' => $emp_code,
         'password' => Hash::make($emp_code),
         'is_active' => 1,
      ]);
      $data->save();
      $this->addUserRoletoUser($request, $data->id);
   }

   public function addUserRoletoUser($request, $id)
   {
      $roles = $request['roles'];
      $user = User::find($id);
      if ($user && !empty($roles)) {
         // Assign multiple roles
         $user->syncRoles($roles);  // Replaces existing roles with the new ones
         // OR
         // $user->assignRole($roles); // Adds new roles without removing existing ones
      }
      // $user->assignRole($role);
   }




   public function determineProposalTypeId($program_type_id)
   {
      $proposal_type_id = 2;
      if ($program_type_id == 1) {
         $proposal_type_id = 2;
      } elseif ($program_type_id == 3) {
         $proposal_type_id = 4;
      } elseif ($program_type_id == 5) {
         $proposal_type_id = 6;
      }
      return $proposal_type_id;
   }

   // One row per function
   public function createFirstProposalStatus($id)
   {
      $user = Auth::user();
      $data = new ProposalStatus([
         'proposal_id' => $id,
         'status_id' => 1,
         'by_user_id' => $user->id,
      ]);
      $data->save();
   }

   public function createFirstProposalDuration($request, $id)
   {
      $data = new ProposalDuration([
         'proposal_id' => $id,
         'start_date' => $request['start_date'],
         'end_date' => $request['end_date'],
      ]);
      $data->save();
   }

   public function createFirstProposalPersonnels($request, $id)
   {
      foreach ($request as $personnel) {
         $data = new ProposalPersonnel([
            'proposal_id' => $id,
            'user_id' => $personnel->user_id,
            'role_id' => $personnel->role_id,
         ]);

         // Save each proposal site
         $data->save();
      }
   }

   public function createProposalPersonnel($id)
   {
      $user = Auth::user();
      $data = new ProposalPersonnel([
         'proposal_id' => $id,
         'user_id' => $user->id,
         'role_id' => 53,
      ]);
      $data->save();
   }

   public function createProposalImplementingAgency($request, $id)
   {
      // dd($request);
      $agency_id = $request['agency_id'] ?? $request['implementing_agency_id'] ?? null;
      $data = new ProposalAgency([
         'proposal_id' => $id,
         'agency_id' => $agency_id,
         'agency_role_id' => 1,
         'is_lead' => 1,
      ]);
      $data->save();
   }

   public function createComponentProject($request)
   {
      $user = Auth::user();
      $getProgramDetails = Proposal::whereId($request['proposal_id'])->first();
      $proposal_type_id = $this->determineProposalTypeId($request['proposal_type_id']);
      $proposal = new Proposal([
         'call_proposal_id' => $getProgramDetails->call_proposal_id,
         'proposal_type_id' => $proposal_type_id,
         'proposal_classification_id' => $getProgramDetails->proposal_classification_id,
         'proposal_category_id' => $getProgramDetails->proposal_category_id,
         'program_id' => $request['proposal_id'],
         'title' => $request['title'],
         'is_component_project' => 1,
         'resume_part' => 2,
         'by_user_id' => $user->id,
      ]);
      $proposal->save();
      $this->createFirstProposalStatus($proposal->id);
      $this->createProposalPersonnel($proposal->id);
      $this->updateOrCreateComponentProjectDuration($request, $proposal->id);
      $this->updateOrCreateProposalLIB($request, $proposal->id);

      return ['success' => true];
   }

   public function updateComponentProject($request, $id)
   {
      Proposal::find($id)->update([
         'title' => $request['title'],
      ]);
      $this->updateOrCreateComponentProjectDuration($request, $id);
   }

   public function updateOrCreateProposalPersonnel($request, $id)
   {
      //$role_id (53 = Program Leader, 24 = Project Leader)      
      $user = Auth::user();
      $role_id = $request['role_id'] ?? 53;
      $user_id = $request['user_id'] ?? $request['leader_user_id'] ?? $request['program_leader_user_id'] ?? $user->id;
      $contact_no = $request['contact_no'] ?? null;
      $email = $request['email'] ?? null;
      $data = ProposalPersonnel::updateOrCreate(
         ['proposal_id' => $id],
         [
            'user_id' => $user_id,
            'role_id' => $role_id,
            'contact_no' => $contact_no,
            'email' => $email,
         ]
      );
      return $data;
   }

   public function updateOrCreateProposalDuration(array $request, string $id)
   {
      $start_date = $request['start_date'] ?? $request['program_start_date'] ?? null;
      $end_date = $request['end_date'] ?? $request['program_end_date'] ?? null;
      $data = [
         'proposal_id' => $id,
         'start_date' => $start_date,
         'end_date' => $end_date,
      ];
      ProposalDuration::updateOrCreate(['proposal_id' => $id], $data);
   }

   public function updateOrCreateComponentProjectDuration($request, $id)
   {
      $start_date = $request['start_date'];
      $end_date = $request['end_date'];
      $data = [
         'proposal_id' => $id,
         'start_date' => $start_date,
         'end_date' => $end_date,
      ];
      ProposalDuration::updateOrCreate(['proposal_id' => $id], $data);
   }

   public function updateOrCreateProposalImplementingAgency($request, $id)
   {
      $agency_id = $request['implementing_agency_id'] ?? $request['program_implementing_agency_id'] ?? null;
      $smallest_unit_id = $request['unit_id'] ?? $request['program_unit_id'] ?? null;
      ProposalAgency::updateOrCreate(['proposal_id' => $id, 'agency_role_id' => 1, 'is_lead' => 1], [
         'proposal_id' => $id,
         'agency_id' => $agency_id,
         'smallest_unit_id' => $smallest_unit_id,
         'agency_role_id' => 1,
         'is_lead' => 1,
      ]);
   }

   public function updateOrCreateProposalLIB($request, $id)
   {
      $counterpart_fund_amount = $request['counterpart_fund_amount'] ?? 0;
      $dost_fund_amount = $request['dost_fund_amount'] ?? 0;

      $existingDataLIB = ProposalLIB::whereProposalId($id)->whereProjectYear(1)->first();

      if (!$existingDataLIB) {
         $dataLIB = new ProposalLIB();
         $dataLIB->proposal_id = $id;
         $dataLIB->project_year = 1;
         $dataLIB->counterpart_fund_amount = $counterpart_fund_amount;
         $dataLIB->dost_fund_amount = $dost_fund_amount;
         $dataLIB->save();
      }
   }

   public function updateOrCreateUserAssignedProposal($request, $id)
   {
      $status_id = $request['status_id'];

      if ($status_id == 7) {
         $role_id = 5;
         $lead_division_id = $request['lead_division_id'];
         $lead_user_ids = User::whereHas('roles', function ($query) use ($role_id) {
               $query->where('id', $role_id);
            })
            ->whereDivisionId($lead_division_id)
            ->pluck('id')
            ->toArray();
         $current_lead_user_ids = UserAssignedProposal::whereProposalId($id)
            ->whereRoleId($role_id)
            ->whereIsLead(1)
            ->pluck('user_id')
            ->toArray();

         if (count($lead_user_ids) > 0) {
            $lead_user_ids_to_delete = array_diff($current_lead_user_ids, $lead_user_ids);
            if (count($lead_user_ids_to_delete) > 0) {
               UserAssignedProposal::whereProposalId($id)
                  ->whereRoleId($role_id)
                  ->whereIsLead(1)
                  ->whereIn('user_id', $lead_user_ids_to_delete)
                  ->delete();
            }
            foreach ($lead_user_ids as $lead_user_id) {
               UserAssignedProposal::updateOrCreate(
                  ['proposal_id' => $id, 'user_id' => $lead_user_id],
                  ['is_lead' => 1, 'role_id' => $role_id]
               );
            }
         } else {
            UserAssignedProposal::whereProposalId($id)->whereRoleId($role_id)->whereIsLead(1)->delete();
         }

         $non_lead_division_ids = $request['non_lead_division_id'] ?? [];
         if (!is_array($non_lead_division_ids)) {
            $non_lead_division_ids = [$non_lead_division_ids];
         }
         $non_lead_user_ids = User::whereHas('roles', function ($query) use ($role_id) {
               $query->where('id', $role_id);
            })
            ->whereIn('division_id', $non_lead_division_ids) // Use whereIn for multiple division IDs
            ->pluck('id')
            ->toArray();
         $current_non_lead_user_ids = UserAssignedProposal::whereProposalId($id)
            ->whereRoleId($role_id)
            ->whereIsLead(0)
            ->pluck('user_id')
            ->toArray();;

         if (count($non_lead_user_ids) > 0) {
            $non_lead_user_ids_to_delete = array_diff($current_non_lead_user_ids, $non_lead_user_ids);
            if (count($non_lead_user_ids_to_delete) > 0) {
               UserAssignedProposal::whereProposalId($id)
                  ->whereRoleId($role_id)
                  ->whereIsLead(0)
                  ->whereIn('user_id', $non_lead_user_ids_to_delete)
                  ->delete();
            }
            foreach ($non_lead_user_ids as $non_lead_user_id) {
               UserAssignedProposal::updateOrCreate(
                  ['proposal_id' => $id, 'user_id' => $non_lead_user_id],
                  ['is_lead' => 0, 'role_id' => $role_id]
               );
            }
         } else {
            UserAssignedProposal::whereProposalId($id)->whereRoleId($role_id)->whereIsLead(0)->delete();
         }
      } else if ($status_id == 14) {
         $role_id = 4;
         $lead_user_id = $request['lead_user_id'];
         $current_lead_user_id = UserAssignedProposal::whereProposalId($id)
            ->whereRoleId($role_id)
            ->whereIsLead(1)
            ->pluck('user_id')
            ->first();

         if (!empty($lead_user_id) && $lead_user_id != $current_lead_user_id) {
            UserAssignedProposal::whereProposalId($id)
               ->whereRoleId($role_id)
               ->whereIsLead(1)
               ->where('user_id', $current_lead_user_id)
               ->delete();

            UserAssignedProposal::updateOrCreate(
               ['proposal_id' => $id, 'user_id' => $lead_user_id],
               ['is_lead' => 1, 'role_id' => $role_id]
            );
         } elseif (empty($lead_user_id)) {
            UserAssignedProposal::whereProposalId($id)
               ->whereRoleId($role_id)
               ->whereIsLead(1)
               ->delete();
         }

         $non_lead_user_ids = $request['non_lead_user_id'] ?? [];
         $current_non_lead_user_ids = UserAssignedProposal::whereProposalId($id)
            ->whereRoleId($role_id)
            ->whereIsLead(0)
            ->pluck('user_id')
            ->toArray();
         if (count($non_lead_user_ids) > 0) {
            $non_lead_user_ids_to_delete = array_diff($current_non_lead_user_ids, $non_lead_user_ids);
            if (count($non_lead_user_ids_to_delete) > 0) {
               UserAssignedProposal::whereProposalId($id)
                  ->whereRoleId($role_id)
                  ->whereIsLead(0)
                  ->whereIn('user_id', $non_lead_user_ids_to_delete)
                  ->delete();
            }
            foreach ($non_lead_user_ids as $non_lead_user_id) {
               UserAssignedProposal::updateOrCreate(
                  ['proposal_id' => $id, 'user_id' => $non_lead_user_id],
                  ['is_lead' => 0, 'role_id' => $role_id]
               );
            }
         } else {
            UserAssignedProposal::whereProposalId($id)
               ->whereRoleId($role_id)
               ->whereIsLead(0)->delete();
         }

         $this->addToEvaluation($id);
         $this->addToAuditTrail($id, 'Assigned Project Manager for Evaluation');
      }
   }

   public function addToEvaluation($proposal_id)
   {
      $audit = new ProposalTracking();
      $audit->proposal_id = $proposal_id;
      $audit->proposal_tracking_status_id  = 2;
      $audit->status = 'active';
      $audit->save();
   }

   public function addToAuditTrail($proposal_id, $desc)
   {
      $audit = new ProposalAuditTrail();
      $audit->proposal_id = $proposal_id;
      $audit->description = $desc;
      $audit->user_id = Auth::user()->id;
      $audit->save();
   }

   public function updateAndCreateProposalStatus($request, $id)
   {
      // dd($request);
      $user = Auth::user();
      $status_id = $request['status_id'];
      $reason_id = $request['reason_id'] ?? null;
      // $lead_division_id = $request['lead_division_id'] ?? null;     
      // $non_lead_division_id  = $request['non_lead_division_id'] ?? [];     
      $proposal_category_id = $request['proposal_category_id'];
      $remarks = $request['remarks'] ?? null;
      ProposalStatus::whereIsActive(1)->whereProposalId($id)->update([
         'is_active' => 0,
      ]);

      $data = new ProposalStatus([
         'proposal_id' => $id,
         'status_id' => $status_id,
         'reason_id' => $reason_id,
         'by_user_id' => $user->id,
         'remarks' => $remarks ?? null,
      ]);
      $data->save();

      if ($status_id == 7 || 14) {
         $this->updateOrCreateUserAssignedProposal($request, $id);
      }

      if ($status_id == 40 && $proposal_category_id == 2) {
         $this->projectService->createProject($id);
         return ['success' => true, 'redirect_url' => route('inception.proposals.index')];
      }

      if (($status_id == 38 || $status_id == 39) && $proposal_category_id == 2) {
         $this->projectService->createProject($id);
         return ['success' => true, 'redirect_url' => route('project.monitoring.index')];
      }
   }

   public function createProposalEquipment($request)
   {
      $data = new ProposalEquipment([
         'proposal_id' => $request['proposal_id'],
         'equipment' => $request['equipment'],
         'quantity_existing_equipment_implementing' => $request['quantity_existing_equipment_implementing'] ?? 0,
         'quantity_existing_equipment_collaborating' => $request['quantity_existing_equipment_collaborating'] ?? 0,
         'quantity_to_be_purchased' => $request['quantity_to_be_purchased'] ?? 0,
         'justification_purchase' => $request['justification_purchase'],
      ]);
      $data->save();
   }

   public function updateProposalEquipment($request, $id)
   {
      ProposalEquipment::find($id)->update([
         'equipment' => $request['equipment'],
         'quantity_existing_equipment_implementing' => $request['quantity_existing_equipment_implementing'] ?? 0,
         'quantity_existing_equipment_collaborating' => $request['quantity_existing_equipment_collaborating'] ?? 0,
         'quantity_to_be_purchased' => $request['quantity_to_be_purchased'] ?? 0,
         'justification_purchase' => $request['justification_purchase'],
      ]);
   }

   public function createProposalSite($request)
   {
      $data = new ProposalSite([
         'proposal_id' => $request['proposal_id'],
         'country_id' => $request['country_id'] ?? null,
         'region_id' => $request['region_id'] ?? null,
         'province_id' => $request['province_id'] ?? null,
         'municipality_id' => $request['municipality_id'] ?? null,
         'barangay_id' => $request['barangay_id'] ?? null,
         'address' => $request['address'] ?? null,
      ]);
      $data->save();
   }

   public function createFirstProposalSites($request, $id)
   {
      foreach ($request as $site) {
         $data = new ProposalSite([
            'proposal_id' => $id,
            'country_id' => $site->country_id ?? null,
            'region_id' => $site->region_id ?? null,
            'province_id' => $site->province_id ?? null,
            'municipality_id' => $site->municipality_id ?? null,
            'barangay_id' => $site->barangay_id ?? null,
            'address' => $site->address ?? null,
         ]);

         // Save each proposal site
         $data->save();
      }
   }

   public function updateProposalSite($request, $id)
   {
      $data = [
         'country_id' => $request['country_id'] ?? null,
         'address' => $request['address'] ?? null,
      ];
      if ($request['country_id'] == 175) {
         $data['region_id'] = $request['region_id'] ?? null;
         $data['province_id'] = $request['province_id'] ?? null;
         $data['municipality_id'] = $request['municipality_id'] ?? null;
         $data['barangay_id'] = $request['barangay_id'] ?? null;
      } else {
         $data['region_id'] = NULL;
         $data['province_id'] = NULL;
         $data['municipality_id'] = NULL;
         $data['barangay_id'] = NULL;
      }

      ProposalSite::find($id)->update($data);
   }

   public function createProposalCooperatingAgency($request)
   {
      $data = new ProposalAgency([
         'proposal_id' => $request['proposal_id'],
         'agency_id' => $request['cooperating_agency_id'],
         'agency_role_id' => 3,
         'cooperating_role_id' => $request['cooperating_role_id'],
      ]);
      $data->save();
   }

   public function updateProposalCooperatingAgency($request, $id)
   {
      ProposalAgency::find($id)->update([
         'agency_id' => $request['cooperating_agency_id'],
         'cooperating_role_id' => $request['cooperating_role_id'],
      ]);
   }

   public function createProposalSpecificObjective($request)
   {
      $data = new ProposalSpecificObjective([
         'proposal_id' => $request['proposal_id'],
         'specific_objective' => $request['specific_objective'],
      ]);
      $data->save();
   }

   public function updateProposalSpecificObjective($request, $id)
   {
      ProposalSpecificObjective::find($id)->update([
         'proposal_id' => $request['proposal_id'],
         'specific_objective' => $request['specific_objective'],
      ]);
   }

   public function createProposalTargetActivity($request)
   {
      $data = new ProposalTargetActivity([
         'specific_objective_id' => $request['specific_objective_id'],
         'target_activity' => $request['target_activity'],
      ]);
      $data->save();
   }

   public function createProposalTargetAccomplishment($request)
   {
      $data = new ProposalTargetAccomplishment([
         'target_activity_id' => $request['target_activity_id'],
         'target_accomplishment' => $request['target_accomplishment'],
         'target_accomplishment' => $request['target_accomplishment'],
      ]);
      $data->save();
   }

   public function updateProposalTargetAccomplishment($request, $id)
   {
      ProposalTargetAccomplishment::find($id)->update([
         'target_accomplishment' => $request['target_accomplishment'],
      ]);

      return true;
   }

   //Multiple row per function 
   public function updateOrCreateProposalCoImplementingAgencies($request, $id)
   {
      $coimplementing_agency_id = $request['coimplementing_agency_id'] ?? [];
      $current_coimplementing_agencies = ProposalAgency::whereProposalId($id)
         ->whereAgencyRoleId(2)
         ->whereIsLead(0)
         ->pluck('agency_id')
         ->toArray();
      if (count($coimplementing_agency_id) > 0) {
         $selected_agencies = is_array($coimplementing_agency_id) ? $coimplementing_agency_id : [$coimplementing_agency_id];
         $agencies_to_delete = array_diff($current_coimplementing_agencies, $selected_agencies);
         ProposalAgency::whereProposalId($id)
            ->whereAgencyRoleId(2)
            ->whereIsLead(0)
            ->whereIn('agency_id', $agencies_to_delete)
            ->delete();
         foreach ($selected_agencies as $agency_id) {
            ProposalAgency::updateOrCreate(
               ['proposal_id' => $id, 'agency_id' => $agency_id],
               ['agency_role_id' => 2, 'is_lead' => 0]
            );
         }
      } else {
         ProposalAgency::whereProposalId($id)->whereAgencyRoleId(2)->whereIsLead(0)->delete();
      }
   }

   public function updateOrCreateProposalCooperatingAgencies($request, $id)
   {
      $cooperating_agencies = $request['cooperating_agencies'] ?? [];
      $current_project_ids = ProposalAgency::whereProposalId($id)->whereAgencyRoleId(3)->pluck('id')->toArray();
      if (isset($cooperating_agencies)) {
         $selected_project_ids = array_column($cooperating_agencies, 'id');
         $agencies_to_delete = array_diff($current_project_ids, $selected_project_ids);
         ProposalAgency::whereProposalId($id)
            ->whereAgencyRoleId(3)
            ->whereIn('id', $agencies_to_delete)
            ->delete();
         foreach ($cooperating_agencies as $key => $agency) {
            $data = [
               'proposal_id' => $id,
               'agency_id' => $agency['agency_id'] ?? $agency['cooperating_agency_id'],
               'agency_role_id' => 3,
               'cooperating_role_id' => $agency['cooperating_role_id'],
            ];
            ProposalAgency::updateOrCreate(
               ['id' => $agency['id'] ?? null, 'proposal_id' => $id],
               $data
            );
         }
      } else {
         ProposalAgency::whereProposalId($id)->whereAgencyRoleId(3)->delete();
      }
   }

   public function updateOrCreateProposalImplementationSites($request, $id)
   {
      $implementation_sites = $request['implementation_sites'] ?? [];
      $current_project_ids = ProposalSite::whereProposalId($id)->pluck('id')->toArray();
      if (isset($implementation_sites)) {
         $selected_project_ids = array_column($implementation_sites, 'id');
         $implementation_sites_to_delete = array_diff($current_project_ids, $selected_project_ids);
         ProposalSite::whereProposalId($id)
            ->whereIn('id', $implementation_sites_to_delete)
            ->delete();
         foreach ($implementation_sites as $key => $implementation_site) {
            $data = [
               'proposal_id' => $id,
               'country_id' => $implementation_site['country_id'],
               'region_id' => $implementation_site['region_id'] ?? null,
               'province_id' => $implementation_site['province_id'] ?? null,
               'municipality_id' => $implementation_site['municipality_id'] ?? null,
               'address' => $implementation_site['address'] ?? null,
               'barangay_id' => $implementation_site['barangay_id'] ?? null,
               'is_base' => $implementation_site['is_base'] ?? 0,
            ];
            ProposalSite::updateOrCreate(
               ['id' => $implementation_site['id'] ?? null, 'proposal_id' => $id],
               $data
            );
         }
      } else {
         ProposalSite::whereProposalId($id)->delete();
      }
   }

   public function updateOrCreatePersonnelRequirement($request, $id)
   {
      $quantity_full_time = $request['quantity_full_time'] ?? 0;
      $quantity_part_time = $request['quantity_part_time'] ?? 0;
      $data = ProposalPersonnelRequirement::firstOrNew(['id' => $id]);
      $data->quantity_full_time = $quantity_full_time;
      $data->quantity_part_time = $quantity_part_time;
      $data->save();
   }

   public function updateOrCreateProposalBudgetSummary($id)
   {
      $getNumberofProjectYears = getNumberofProjectYears($id);
      $getFundSourceTypes = getFundSourceTypes();
      for ($year = 1; $year <= $getNumberofProjectYears; $year++) {
         foreach ($getFundSourceTypes as $fundSource) {
            ProposalBudgetSummary::firstOrNew([
               'proposal_id' => $id,
               'project_year' => $year,
               'fund_source_type_id' => $fundSource->id,
            ])->save();
         }
      }
   }

   public function updateOrCreateProposalRDPrograms($request, $id)
   {
      $current_rd_programs = ProposalRDProgram::whereProposalId($id)->pluck('type_id', 'rd_program_id')->toArray();
      $rd_programs = json_decode($request['rd_programs'] ?? '[]', true);
      if (count($rd_programs) > 0) {
         foreach ($rd_programs as $rd_program) {
            $rd_program_id = $rd_program['id'];  // Get the program ID           
            $type_id = $rd_program['type'];     // Get the program's type

            $monitoring_agency_id = LibraryRDProgram::whereId($rd_program_id)->pluck('monitoring_agency_id')->first();

            if (!$monitoring_agency_id) {
               continue;  // Skip this iteration if there's no valid monitoring agency ID
            }

            ProposalRDProgram::updateOrCreate(
               ['proposal_id' => $id, 'rd_program_id' => $rd_program_id],
               ['type_id' => $type_id]
            );

            $existing_monitoring_agencies = ProposalAgency::whereProposalId($id)
               ->whereAgencyRoleId(5)  // For monitoring agency role (role ID 5)
               ->whereIsLead(0)        // For non-lead agencies (is_lead = 0)
               ->pluck('agency_id')    // Get the existing agency IDs
               ->toArray();           // Convert to an array for comparison

            if (!in_array($monitoring_agency_id, $existing_monitoring_agencies)) {
               // Insert or update the monitoring agency if it doesn't exist
               ProposalAgency::updateOrCreate(
                  ['proposal_id' => $id, 'agency_id' => $monitoring_agency_id, 'agency_role_id' => 5, 'is_lead' => 0],
                  [
                     'proposal_id' => $id,
                     'agency_id' => $monitoring_agency_id,
                     'agency_role_id' => 5,  // Role ID for monitoring agency
                     'is_lead' => 0,         // Not a lead agency
                  ]
               );
            }

            $monitoring_agencies_to_keep = array_map(function ($program) {
               return LibraryRDProgram::whereId($program['id'])->pluck('monitoring_agency_id')->first();
            }, $rd_programs); // Get all selected monitoring agencies from rd_programs

            // Remove any null values (if monitoring_agency_id was missing in any rd_program)
            $monitoring_agencies_to_keep = array_filter($monitoring_agencies_to_keep);

            // Find agencies to delete by comparing the existing monitoring agencies with the selected ones
            $monitoring_agency_ids_to_delete = array_diff($existing_monitoring_agencies, $monitoring_agencies_to_keep);

            // Delete any agencies that are no longer in the selected RD programs
            if (!empty($monitoring_agency_ids_to_delete)) {
               ProposalAgency::whereProposalId($id)
                  ->whereIn('agency_id', $monitoring_agency_ids_to_delete)
                  ->whereAgencyRoleId(5)  // Ensure the role is monitoring agency (role 5)
                  ->whereIsLead(0)        // Ensure it's not a lead agency
                  ->delete();
            }

            unset($current_rd_programs[$rd_program_id]);
         }

         if (!empty($current_rd_programs)) {
            ProposalRDProgram::whereProposalId($id)
               ->whereIn('rd_program_id', array_keys($current_rd_programs))
               ->delete();
         }
      } else {
         ProposalRDProgram::whereProposalId($id)->delete();
      }
   }

   public function updateOrCreateProposalSDGs($request, $id)
   {
      $sdg_id = $request['sdg_id'] ?? [];
      $current_sdgs = ProposalSDG::whereProposalId($id)->pluck('sdg_id')->toArray();
      if (count($sdg_id) > 0) {
         $selected_sdgs = is_array($sdg_id) ? $sdg_id : [$sdg_id];
         $sdgs_to_delete = array_diff($current_sdgs, $selected_sdgs);
         ProposalSDG::whereProposalId($id)
            ->whereIn('sdg_id', $sdgs_to_delete)
            ->delete();
         foreach ($selected_sdgs as $key => $value) {
            $input['proposal_id'] = $id;
            $input['sdg_id'] = $value;
            ProposalSDG::updateOrCreate(
               ['proposal_id' => $id, 'sdg_id' => $value],
               $input
            );
         }
      } else {
         ProposalSDG::whereProposalId($id)->delete();
      }
   }

   public function updateOrCreateProposalPillars($request, $id)
   {
      $pillars = $request['pillars'] ?? [];
      $current_pillars = ProposalDOSTPillar::whereProposalId($id)->pluck('dost_pillar_id')->toArray();
      if (count($pillars) > 0) {
         $selected_pillars = is_array($pillars) ? $pillars : [$pillars];
         $pillars_to_delete = array_diff($current_pillars, $selected_pillars);
         ProposalDOSTPillar::whereProposalId($id)
            ->whereIn('dost_pillar_id', $pillars_to_delete)
            ->delete();
         foreach ($selected_pillars as $key => $value) {
            $input['proposal_id'] = $id;
            $input['dost_pillar_id'] = $value;
            ProposalDOSTPillar::updateOrCreate(
               ['proposal_id' => $id, 'dost_pillar_id' => $value],
               $input
            );
         }
      } else {
         ProposalDOSTPillar::whereProposalId($id)->delete();
      }
   }

   public function updateOrCreateProposalThematicAreas($request, $id)
   {
      $thematic_areas = $request['thematic_areas'] ?? [];
      $other_thematic_area = $request['other_thematic_area'] ?? '';
      $current_thematic_areas = ProposalDOSTThematicArea::whereProposalId($id)->pluck('thematic_area_id')->toArray();
      if (count($thematic_areas) > 0) {
         $selected_thematic_areas = is_array($thematic_areas) ? $thematic_areas : [$thematic_areas];
         $thematic_areas_to_delete = array_diff($current_thematic_areas, $selected_thematic_areas);
         ProposalDOSTThematicArea::whereProposalId($id)
            ->whereIn('thematic_area_id', $thematic_areas_to_delete)
            ->delete();
         foreach ($selected_thematic_areas as $key => $value) {
            $input['proposal_id'] = $id;
            $input['thematic_area_id'] = $value;
            if ($value == '10' && !empty($other_thematic_area)) {
               $input['other'] = $other_thematic_area;
            } else {
               $input['other'] = null;
            }

            ProposalDOSTThematicArea::updateOrCreate(
               ['proposal_id' => $id, 'thematic_area_id' => $value],
               $input
            );
         }
      } else {
         ProposalDOSTThematicArea::whereProposalId($id)->delete();
      }
   }

   public function updateOrCreateProposalStrategicPrograms($request, $id)
   {
      $strategic_programs = $request['strategic_programs'] ?? [];
      $current_strategic_programs = ProposalDOSTStrategicProgram::whereProposalId($id)->pluck('strategic_program_id')->toArray();
      if (count($strategic_programs) > 0) {
         $selected_strategic_programs = is_array($strategic_programs) ? $strategic_programs : [$strategic_programs];
         $strategic_programs_to_delete = array_diff($current_strategic_programs, $selected_strategic_programs);
         ProposalDOSTStrategicProgram::whereProposalId($id)
            ->whereIn('strategic_program_id', $strategic_programs_to_delete)
            ->delete();
         foreach ($selected_strategic_programs as $key => $value) {
            $input['proposal_id'] = $id;
            $input['strategic_program_id'] = $value;
            ProposalDOSTStrategicProgram::updateOrCreate(
               ['proposal_id' => $id, 'strategic_program_id' => $value],
               $input
            );
         }
      } else {
         ProposalDOSTStrategicProgram::whereProposalId($id)->delete();
      }
   }

   public function updateOrCreateProposalLeaderOngoingProjects($request, $id)
   {
      $user = Auth::user();
      $ongoing_projects = $request['ongoing_projects'] ?? [];
      $current_project_ids = ProposalProjectLeaderOngoingProject::whereProposalId($id)->pluck('id')->toArray();
      if (count($ongoing_projects) > 0) {
         $selected_project_ids = array_column($ongoing_projects, 'id');
         $projects_to_delete = array_diff($current_project_ids, $selected_project_ids);
         ProposalProjectLeaderOngoingProject::whereProposalId($id)
            ->whereIn('id', $projects_to_delete)
            ->delete();
         foreach ($ongoing_projects as $key => $project) {
            $data = [
               'title' => $project['title'],
               'user_id' => $project['user_id'] ?? $request['leader_user_id'] ?? $project['program_user_id'] ?? $request['program_leader_user_id'] ?? $user->id ?? null,
               'funding_agency_id' => $project['funding_agency_id'] ?? 0,
               'involvement' => $project['involvement'] ?? null,
               'proposal_id' => $id,
            ];
            ProposalProjectLeaderOngoingProject::updateOrCreate(
               ['id' => $project['id'] ?? null, 'proposal_id' => $id],
               $data
            );
         }
      } else {
         ProposalProjectLeaderOngoingProject::whereProposalId($id)->delete();
      }
   }

   public function updateOrCreateExpectedOutputs($request, $proposal_id)
   {
      $expected_outputs = $request['expected_outputs'] ?? [];
      $otherTexts  = $request['expected_output_others'] ?? [];

      $current_expected_outputs = ProposalExpectedOutput::whereProposalId($proposal_id)->pluck('expected_output_id')->toArray();
      if (count($expected_outputs) > 0) {
         $selected_expected_outputs = is_array($expected_outputs) ? $expected_outputs : [$expected_outputs];
         $expected_outputs_to_delete = array_diff($current_expected_outputs, $selected_expected_outputs);

         ProposalExpectedOutput::whereProposalId($proposal_id)
            ->whereIn('expected_output_id', $expected_outputs_to_delete)
            ->delete();

         foreach ($selected_expected_outputs as $outputId) {
            $otherText = isset($otherTexts[$outputId]) ? $otherTexts[$outputId] : null;
            ProposalExpectedOutput::updateOrCreate(
               ['proposal_id' => $proposal_id, 'expected_output_id' => $outputId],
               ['other' => $otherText]
            );
         }
      } else {
         ProposalExpectedOutput::whereProposalId($proposal_id)->delete();
      }
   }

   private function updateOrCreateGADScore($proposal_id, array $scores, array $comments)
   {
      foreach ($scores as $elementId => $score) {
         ProposalGADScore::updateOrCreate(
            ['proposal_id' => $proposal_id, 'element_item_id' => $elementId],
            ['score' => $score, 'comment' => $comments[$elementId] ?? '']
         );
      }
   }
}
