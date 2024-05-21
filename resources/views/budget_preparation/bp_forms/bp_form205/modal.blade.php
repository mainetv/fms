<!-- Modal -->
@php $getRetirees = getRetirees(); @endphp
<div class="modal fade" id="bp_form205_modal" tabindex="-1" role="dialog" aria-labelledby="user_label" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="bp_form205_modal_header"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>            
			<div class="modal-body">
				<input type="hidden" id="bp_form205_year" name="year" readonly>
				<input type="hidden" id="bp_form205_fiscal_year" name="fiscal_year" readonly>
				<input type="hidden" id="bp_form205_division_id" name="division_id" value="{{ $user_division_id }}" readonly> 
				<div class="form-group">
					<label for="description">Retirement Law</label>
					<select name="retirement_law_id" id="retirement_law_id" class="bp-form205-field form-control bp-forms-field select2bs4">
						<option value="">Select Retirement Law</option>
						@php $sqlRetirementLaw = getRetirementLaw(); @endphp
						@foreach ($sqlRetirementLaw as $row)
							<option value="{{ $row->id }}" data-id="{{ $row->id }}">{{ $row->ra_no }}</option>
						@endforeach
					</select>
					<span class="text-danger"><small id="bp-form205-retirement-law-error" class="error"></small></span>
				</div> 
				<div class="form-group">
					<label for="description">Name of Retiree</label>
					<select name="retiree_emp_code" id="retiree_emp_code" class="bp-form205-field form-control bp-forms-field select2bs4">
						<option value="">Select Retiree</option>						
						@foreach ($getRetirees as $row)
							<option value="{{ $row->emp_code }}" data-id="{{ $row->emp_code }}">{{ $row->fullname_last }}</option>
						@endforeach
					</select>
					<span class="text-danger"><small id="bp-form205-name-error" class="error"></small></span>
				</div>            
				<div class="form-group">
					<label for="area_sqm">Position at Retirement Date</label>
					<select name="position_id_at_retirement_date" id="position_id_at_retirement_date" class="select2bs4 bp-form205-field form-control bp-forms-field">
						<option value="">Select Position</option>						
					</select>
					<span class="text-danger"><small id="bp-form205-position-error" class="error"></small></span>
				</div> 
				<div class="form-group">
					<label for="location">Highest Monthly Salary</label>
					<input type="text" id="highest_monthly_salary" name="highest_monthly_salary" class="bp-form205-field form-control bp-forms-field">
					<span class="text-danger"><small id="bp-form205-salary-error" class="error"></small></span>
				</div>    
				<hr>
				<div class="row text-center">
					<div class="form-group col">                
					  <label for="allotment" >TERMINAL LEAVE</label>           
					</div> 
				</div>				
				<div class="row"> 	
					<div class="form-group col">
						<label for="amount">No. of VL Credits Earned</label>
						<input type="number" id="vl_credits_earned" name="vl_credits_earned" class="bp-form205-field form-control bp-forms-field">
						<span class="text-danger"><small id="bp-form205-vl-error" class="error"></small></span>
					</div>
					<div class="form-group col">
						<label for="amount">No. of SL Credits Earned</label>
						<input type="number" id="sl_credits_earned" name="sl_credits_earned" class="bp-form205-field form-control bp-forms-field">
						<span class="text-danger"><small id="bp-form205-sl-error" class="error"></small></span>
					</div>
					<div class="form-group col">
						<label for="amount">Amount</label>
						<input type="number" id="leave_amount" name="leave_amount" class="bp-form205-field form-control bp-forms-field">
						<span class="text-danger"><small id="bp-form205-leave-amount-error" class="error"></small></span>
					</div>
				</div>
				<hr>
				<div class="row text-center">
					<div class="form-group col">                
					  <label for="allotment" >RETIREMENT GRATUITY</label>           
					</div> 
				 </div>
				 <div class="row"> 				
					<div class="form-group col">
						<label for="amount">Total Creditable Service</label>
						<input type="number" id="total_creditable_service" name="total_creditable_service" class="bp-form205-field form-control bp-forms-field">
						<span class="text-danger"><small id="bp-form205-gratuity-service-error" class="error"></small></span>
					</div>  
					<div class="form-group col">
						<label for="amount">No. of Gratuity Months</label>
						<input type="number" id="num_gratuity_months" name="num_gratuity_months" class="bp-form205-field form-control bp-forms-field">
						<span class="text-danger"><small id="bp-form205-gratuity-months-error" class="error"></small></span>
					</div> 
					<div class="form-group col">
						<label for="amount">Amount</label>
						<input type="number" id="gratuity_amount" name="gratuity_amount" class="bp-form205-field form-control bp-forms-field">
						<span class="text-danger"><small id="bp-form205-gratuity-amount-error" class="error"></small></span>
					</div>  
				</div>
			</div>      
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary save-buttons d-none add_bp_form205">Save</button>
				<button type="button" class="update btn btn-primary save-buttons d-none edit_bp_form205">Save changes</button>
			</div>
		</div>
	</div>
</div>