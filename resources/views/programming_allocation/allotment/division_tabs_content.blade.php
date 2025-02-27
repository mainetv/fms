<h4>{{ $value->division_acronym }}</h4><?php
	$division_id=$value->id;	
	$division_acronym=$value->division_acronym;?>
<div class="content">
  <div class="row">
    <div class="col-7">
		{{-- <span class='badge badge-success' style='font-size:15px'>{{ $status ?? ""}}</span> --}}
    </div>
	 <div class="col-5">
		
	 </div>
  </div>
</div>
<div class="row py-3">
  	<div class="col table-responsive">
		<table id="allotment_table" class="table-bordered table-hover" style="width: 100%;">
			<thead class="text-center">
				<th>ACTIVITY / Object of Expenditures</th>
				<th>Allotment</th>
				<th>Total Adjustment</th>
				<th>Total Obligation</th>
				<th>Total Balance</th>
				@role('Budget Officer|Super Administrator')
					@if($division_id!=5)
					<td class="text-center" style="width:140px">										
						<button id="btn_add" type="button" class="btn-xs btn_add" data-division-id="{{ $division_id }}"
							data-year="@if($year_selected=="all") {{ date('Y') }} @else {{ $year_selected }} @endif" data-rstype-id="{{ $rstype_id_selected }}" 
							data-toggle="modal" data-target="#allotment_modal" data-toggle="tooltip" 
							data-placement='auto' title='Add Allotment'><i class="fa-solid fa-plus fa-lg blue"></i>
						</button>&nbsp;																			 
					</td>
					@endif
				@endrole
			</thead>			
			<tbody><?php			
				// if($year_selected=='all'){
				// 	$data = DB::table('view_allotment')->where('rs_type_id', $rstype_id_selected)
				// 		->where('division_id', $division_id)
				// 		->where('is_active', 1)->where('is_deleted', 0)
				// 		->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
				// 		->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
				// 		->orderByRaw('(object_specific_id is not null) ASC')
				// 		->orderBy('pooled_at_division_id','ASC')
				// 		->groupBy('id')->get();
				// }
				// else{
				// 	if($division_id==5){
				// 		$data = DB::table('view_allotment')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
				// 			->where('is_active', 1)->where('is_deleted', 0)->where('parent_division_id', $division_id)->whereNull('pooled_at_division_id')
				// 			->orderBy('allotment_class_id', 'ASC')->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
				// 			->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
				// 			->groupBy('id')->get();

				// 		$data1 = DB::table('view_allotment')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
				// 			->where('is_active', 1)->where('is_deleted', 0)->where('parent_division_id','!=', $division_id)
				// 			->where('parent_pooled_at_division_id', $division_id)
				// 			->orderBy('allotment_class_id', 'ASC')->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
				// 			->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
				// 			->groupBy('id')->get();
						
				// 		$data2 = DB::table('view_allotment')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
				// 			->where('is_active', 1)->where('is_deleted', 0)
				// 			->where(function ($query) use ($division_id){
				// 				$query->where(function ($query) use ($division_id){
				// 						$query->where('parent_division_id','=',$division_id)
				// 							->whereNull('pooled_at_division_id');
				// 					})
				// 					->orWhere(function ($query) use ($division_id){
				// 						$query->where('parent_division_id','!=',$division_id)
				// 							->where('parent_pooled_at_division_id','=',$division_id);
				// 					});
				// 			})
				// 			->orderBy('allotment_class_id', 'ASC')->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
				// 			->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
				// 			->groupBy('id')->get();
				// 	}
				// 	else{
				// 		$data = DB::table('view_allotment')->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
				// 			->where('division_id', $division_id)
				// 			->where('is_active', 1)->where('is_deleted', 0)
				// 			->orderBy('allotment_class_id', 'ASC')->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
				// 			->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
				// 			->orderByRaw('(object_specific_id is not null) ASC')
				// 			->orderBy('pooled_at_division_id','ASC')
				// 			->groupBy('id')->get();
				// 			// ->orderBy('allotment_class_id', 'ASC')->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')
				// 			// ->orderBy('expense_account_code','ASC')->groupBy('id')->get();
							
				// 		// $data1 = DB::table('view_allotment')->where('year', $year_selected)->where('division_id',$division_id)
				// 		// ->where('rs_type_id', $rstype_id_selected)
				// 		// 	->where(function ($query) use ($division_id){
				// 		// 		$query->whereNotNull('pooled_at_division_id')
				// 		// 			->where('pooled_at_division_id','!=',$division_id);
				// 		// 	})
				// 		// 	->where('is_active', 1)->where('is_deleted', 0)
				// 		// 	->orderBy('pap_code', 'ASC')->orderBy('allotment_class_id') ->orderBy('activity','ASC')
				// 		// 	->orderBy('expense_account_code','ASC')->groupBy('id')->get();	
				// 	}
				// }
				if($rstype_id_selected==1 && $division_id==5){
					//All FAD and FAD pooled under FAD
					$data = DB::table("view_allotment")->select("view_allotment.*",
						DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
						)									
						->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
						->where('parent_division_id', $division_id)
						->where(function ($query) use ($division_id) {
							$query->where('parent_pooled_at_division_id','=',$division_id)
								->orWhereNull('pooled_at_division_id')
								->orWhere('pooled_at_division_id','=',$division_id);
						})	
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_code','ASC')->orderBy('object_expenditure','ASC')
						->orderBy('object_specific','ASC')->orderByRaw('(object_specific_id is not null) ASC')
						->orderBy('pooled_at_division_id','ASC')
						->groupBy('id')->get();

					//All pooled at FAD even under FAD division										
					$data1 = DB::table("view_allotment")->select("view_allotment.*",
						DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
						)									
						->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
						->where(function ($query) {
								$query->where('pooled_at_division_id','=',5)
									->orWhere('parent_pooled_at_division_id','=',5);
							})
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
						->orderByRaw('(object_specific_id is not null) ASC')
						->orderBy('pooled_at_division_id','ASC')
						->groupBy('id')->get();
					
					//Grand total of all FAD and FAD pooled under FAD										
					$data2 = DB::table("view_allotment")->select("view_allotment.*",
						DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
						)									
						->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
						->where(function ($query) use ($division_id){
							$query->where(function ($query) use ($division_id){
								$query->where('parent_pooled_at_division_id','=',$division_id)
										->orWhereNull('pooled_at_division_id')
										->orWhere('pooled_at_division_id','=',$division_id);
								});
						})
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
						->orderByRaw('(object_specific_id is not null) ASC')
						->orderBy('pooled_at_division_id','ASC')
						->groupBy('id')->get();
				}		
				elseif($rstype_id_selected==1 && $division_id=='all'){
					$data = DB::table("view_allotment")->select("view_allotment.*",
						DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
						)
						->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
						->orderByRaw('(object_specific_id is not null) ASC')
						->orderBy('pooled_at_division_id','ASC')
						->groupBy('id')->get();
				}
				elseif($rstype_id_selected==1 && $division_id!='all'){	
					$data = DB::table("view_allotment")->select("view_allotment.*",
						DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
						)
						->where('year', $year_selected)->where('rs_type_id', $rstype_id_selected)->where('division_id', $division_id)
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
						->orderByRaw('(object_specific_id is not null) ASC')
						->orderBy('pooled_at_division_id','ASC')
						->groupBy('id')->get();
				}
				elseif($rstype_id_selected==1 && $year_selected=='all'){				
					$data = DB::table("view_allotment")->select("view_allotment.*",
						DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
							AND YEAR(rs_date) = YEAR AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
						)
						->where('rs_type_id', $rstype_id_selected)->where('division_id', $division_id)
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
						->orderByRaw('(object_specific_id is not null) ASC')
						->orderBy('pooled_at_division_id','ASC')
						->groupBy('id')->get();
				}
				elseif($rstype_id_selected!=1 && $year_selected=='all'){
					$data = DB::table("view_allotment")->select("view_allotment.*",
						DB::raw("(SELECT sum(view_adjustment.q1_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q1_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q2_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q2_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q3_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q3_adjustment"),
						DB::raw("(SELECT sum(view_adjustment.q4_adjustment) FROM view_adjustment WHERE view_adjustment.allotment_id=view_allotment.id
							AND view_adjustment.is_active=1 AND view_adjustment.is_deleted=0) AS q4_adjustment"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(1, 2, 3) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(1, 2, 3)) 
							AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q1_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(4, 5, 6) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(4, 5, 6)) 
							AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q2_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(7,8,9) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(7,8,9)) 
							AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q3_obligation"),
						DB::raw("(SELECT SUM(amount) FROM rs_pap
							LEFT JOIN request_status rs ON rs_pap.rs_id = rs.id
							WHERE ((MONTH(rs_date) IN(10,11,12) AND notice_adjustment_date IS NULL) OR MONTH(notice_adjustment_date) IN(10,11,12)) 
							AND rs_pap.allotment_id = view_allotment.id AND rs.rs_type_id = view_allotment.rs_type_id
							AND rs_pap.is_active = 1 AND rs_pap.is_deleted = 0) AS q4_obligation"),
						)
						->where('rs_type_id', $rstype_id_selected)->where('division_id', $division_id)
						->where('is_active', 1)->where('is_deleted', 0)
						->orderBy('pap_code', 'ASC')->orderBy('activity','ASC')->orderBy('subactivity','ASC')
						->orderBy('expense_account_code','ASC')->orderBy('object_expenditure','ASC')->orderBy('object_specific','ASC')
						->orderByRaw('(object_specific_id is not null) ASC')
						->orderBy('pooled_at_division_id','ASC')
						->groupBy('id')->get();
				}
				
				if($rstype_id_selected==1){
					foreach($data->groupBY('allotment_class_id') as $key=>$row){			
						foreach($row as $item) {} //item?>
						<tr>
							<td class="font-weight-bold" colspan="5">{{ $item->allotment_class }} ({{ $item->allotment_class_acronym }})</td>													
						</tr><?php
						foreach($data->where('allotment_class_id', $item->allotment_class_id)->groupBY('pap_code') as $key1=>$row1){
							foreach($row1 as $item1) {} //item 1?>
							<tr>
								<td class="pap font-weight-bold gray1-bg" colspan="5">{{ $item1->pap }} - {{ $item1->pap_code }}</td>										
							</tr><?php 	
							foreach($data->where('allotment_class_id', $item->allotment_class_id)
							->where('pap_id', $item1->pap_id)
							->groupBY('activity_id') as $key2=>$row2){
								foreach($row2 as $item2) {} //item 2?>
								<tr>
									<td class="activity1 font-weight-bold" colspan="5">{{ $item2->activity }}</td>													
								</tr><?php 
								foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
								->where('activity_id', $item2->activity_id)
								->groupBY('subactivity_id') as $key3=>$row3){
									foreach($row3 as $item3) {} 
									if(isset($item3->subactivity)){//item 3?>
										<tr>
											<td class="subactivity1 font-weight-bold" colspan="5">{{ $item3->subactivity }}</td>													
										</tr><?php 
									}												
									foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
									->where('activity_id', $item2->activity_id)
									->where('subactivity_id', $item3->subactivity_id)
									->groupBY('expense_account_id') as $key4=>$row4){
										foreach($row4 as $item4) {}//item 4
										$q1_allotment = $item4->q1_allotment;
										$q2_allotment = $item4->q2_allotment;
										$q3_allotment = $item4->q3_allotment;
										$q4_allotment = $item4->q4_allotment;
										$q1_adjustment = $item4->q1_adjustment;
										$q2_adjustment = $item4->q2_adjustment;
										$q3_adjustment = $item4->q3_adjustment;
										$q4_adjustment = $item4->q4_adjustment;
										$q1_obligation = $item4->q1_obligation;
										$q2_obligation = $item4->q2_obligation;
										$q3_obligation = $item4->q3_obligation;
										$q4_obligation = $item4->q4_obligation;
										$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
										$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
										$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
										$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
										$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
										$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
										$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
										$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;?>
										<tr>
											<td class="expense1 font-weight-bold" colspan="5">{{ $item4->expense_account }}</td>														
										</tr>
										<?php
										if($division_id==5){ //fad
											foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
											->where('activity_id', $item2->activity_id)
											->where('subactivity_id', $item3->subactivity_id)
											->where('expense_account_id', $item4->expense_account_id)
											->whereNull('object_specific_id')
											->groupBY('object_expenditure_id') as $key5=>$row5){
												foreach($row5 as $item5) {}//item 4
												$q1_allotment=$row5->sum('q1_allotment'); 
												$q2_allotment=$row5->sum('q2_allotment'); 
												$q3_allotment=$row5->sum('q3_allotment'); 
												$q4_allotment=$row5->sum('q4_allotment'); 
												$q1_adjustment=$row5->sum('q1_adjustment'); 	
												$q2_adjustment=$row5->sum('q2_adjustment'); 	
												$q3_adjustment=$row5->sum('q3_adjustment'); 	
												$q4_adjustment=$row5->sum('q4_adjustment'); 	
												$q1_obligation=$row5->sum('q1_obligation'); 	
												$q2_obligation=$row5->sum('q2_obligation');	
												$q3_obligation=$row5->sum('q3_obligation');	
												$q4_obligation=$row5->sum('q4_obligation');	
												$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
												$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
												$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
												$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
												$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
												$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
												$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
												$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;?>
												<tr class="text-right">
													<td class="objexp1">{{ $item5->object_code }}: {{ $item5->object_expenditure }}
														@if($item5->pooled_at_division_id != NULL) 
														- Pooled at {{ $item5->pooled_at_division_acronym }} ({{ $item5->division_acronym }})@endif
													</td>		
													@if($view_selected == 'annual')
														<td class="yellow-bg">{{ number_format($total_allotment, 2) }}</td>													
														<td class="lightred-bg">{{ number_format($total_adjustment, 2) }}</td>														
														<td class="lightgreen-bg">{{ number_format($total_obligation, 2) }}</td>													
														<td>{{ number_format($total_balance, 2) }}</td>		
													@elseif($view_selected == 'q1')		
														<td class="yellow-bg">{{ number_format($q1_allotment, 2) }}</td>													
														<td class="lightred-bg">{{ number_format($q1_adjustment, 2) }}</td>													
														<td class="lightgreen-bg">{{ number_format($q1_obligation, 2) }}</td>													
														<td>{{ number_format($q1_balance, 2) }}</td>		
													@elseif($view_selected == 'q2')		
														<td class="yellow-bg">{{ number_format($q2_allotment, 2) }}</td>													
														<td class="lightred-bg">{{ number_format($q2_adjustment, 2) }}</td>													
														<td class="lightgreen-bg">{{ number_format($q2_obligation, 2) }}</td>													
														<td>{{ number_format($q2_balance, 2) }}</td>	
													@elseif($view_selected == 'q3')		
														<td class="yellow-bg">{{ number_format($q3_allotment, 2) }}</td>													
														<td class="lightred-bg">{{ number_format($q3_adjustment, 2) }}</td>													
														<td class="lightgreen-bg">{{ number_format($q3_obligation, 2) }}</td>													
														<td>{{ number_format($q3_balance, 2) }}</td>	
													@elseif($view_selected == 'q4')		
														<td class="yellow-bg">{{ number_format($q4_allotment, 2) }}</td>													
														<td class="lightred-bg">{{ number_format($q4_adjustment, 2) }}</td>													
														<td class="lightgreen-bg">{{ number_format($q4_obligation, 2) }}</td>													
														<td>{{ number_format($q4_balance, 2) }}</td>		
													@endif										
												</tr><?php
											}
											foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
											->where('activity_id', $item2->activity_id)
											->where('subactivity_id', $item3->subactivity_id)
											->where('expense_account_id', $item4->expense_account_id)
											->whereNotNull('object_specific_id')
											->groupBY('object_expenditure_id') as $key5=>$row5){
												foreach($row5 as $item5) {}//item 4
												$q1_allotment=$row5->sum('q1_allotment'); 
												$q2_allotment=$row5->sum('q2_allotment'); 
												$q3_allotment=$row5->sum('q3_allotment'); 
												$q4_allotment=$row5->sum('q4_allotment'); 
												$q1_adjustment=$row5->sum('q1_adjustment'); 	
												$q2_adjustment=$row5->sum('q2_adjustment'); 	
												$q3_adjustment=$row5->sum('q3_adjustment'); 	
												$q4_adjustment=$row5->sum('q4_adjustment'); 	
												$q1_obligation=$row5->sum('q1_obligation'); 	
												$q2_obligation=$row5->sum('q2_obligation');	
												$q3_obligation=$row5->sum('q3_obligation');	
												$q4_obligation=$row5->sum('q4_obligation');	
												$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
												$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
												$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
												$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
												$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
												$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
												$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
												$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;
												if($item5->object_specific_id != NULL){?>
													<tr>
														<td class="objexp1" colspan="5">{{ $item5->object_code }}: {{ $item5->object_expenditure }}</td>														
													</tr><?php
													foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
													->where('activity_id', $item2->activity_id)
													->where('subactivity_id', $item3->subactivity_id)
													->where('expense_account_id', $item4->expense_account_id)
													->where('object_expenditure_id', $item5->object_expenditure_id)
													->whereNotNull('object_specific_id')
													->groupBY('object_specific_id') as $key6=>$row6){
														foreach($row6 as $item6) {}//item 4
														$q1_allotment=$row6->sum('q1_allotment'); 
														$q2_allotment=$row6->sum('q2_allotment'); 
														$q3_allotment=$row6->sum('q3_allotment'); 
														$q4_allotment=$row6->sum('q4_allotment'); 
														$q1_adjustment=$row6->sum('q1_adjustment'); 	
														$q2_adjustment=$row6->sum('q2_adjustment'); 	
														$q3_adjustment=$row6->sum('q3_adjustment'); 	
														$q4_adjustment=$row6->sum('q4_adjustment'); 	
														$q1_obligation=$row6->sum('q1_obligation'); 	
														$q2_obligation=$row6->sum('q2_obligation');	
														$q3_obligation=$row6->sum('q3_obligation');	
														$q4_obligation=$row6->sum('q4_obligation');	
														$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
														$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
														$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
														$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
														$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
														$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
														$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
														$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;?>
														<tr class="text-right">
															<td class="objspe1 font-italic">{{ $item6->object_specific }}
																@if($item6->pooled_at_division_id != NULL) 
																- Pooled at {{ $item6->pooled_at_division_acronym }} ({{ $item6->division_acronym }})@endif
															</td>		
															@if($view_selected == 'annual')
																<td class="yellow-bg ">{{ number_format($total_allotment, 2) }}</td>													
																<td class="lightred-bg">{{ number_format($total_adjustment, 2) }}</td>														
																<td class="lightgreen-bg">{{ number_format($total_obligation, 2) }}</td>													
																<td>{{ number_format($total_balance, 2) }}</td>		
															@elseif($view_selected == 'q1')		
																<td class="yellow-bg">{{ number_format($q1_allotment, 2) }}</td>													
																<td class="lightred-bg">{{ number_format($q1_adjustment, 2) }}</td>													
																<td class="lightgreen-bg">{{ number_format($q1_obligation, 2) }}</td>													
																<td>{{ number_format($q1_balance, 2) }}</td>		
															@elseif($view_selected == 'q2')		
																<td class="yellow-bg">{{ number_format($q2_allotment, 2) }}</td>													
																<td class="lightred-bg">{{ number_format($q2_adjustment, 2) }}</td>													
																<td class="lightgreen-bg">{{ number_format($q2_obligation, 2) }}</td>													
																<td>{{ number_format($q2_balance, 2) }}</td>	
															@elseif($view_selected == 'q3')		
																<td class="yellow-bg">{{ number_format($q3_allotment, 2) }}</td>													
																<td class="lightred-bg">{{ number_format($q3_adjustment, 2) }}</td>													
																<td class="lightgreen-bg">{{ number_format($q3_obligation, 2) }}</td>													
																<td>{{ number_format($q3_balance, 2) }}</td>	
															@elseif($view_selected == 'q4')		
																<td class="yellow-bg">{{ number_format($q4_allotment, 2) }}</td>													
																<td class="lightred-bg">{{ number_format($q4_adjustment, 2) }}</td>													
																<td class="lightgreen-bg">{{ number_format($q4_obligation, 2) }}</td>													
																<td>{{ number_format($q4_balance, 2) }}</td>		
															@endif	
														</tr><?php
													}
												}
											}
										}
										else{
											foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
											->where('activity_id', $item2->activity_id)
											->where('subactivity_id', $item3->subactivity_id)
											->where('expense_account_id', $item4->expense_account_id)
											->whereNull('object_specific_id')
											->groupBY('id') as $key5=>$row5){
												foreach($row5 as $item5) {}//item 4
												$q1_allotment = $item5->q1_allotment;
												$q2_allotment = $item5->q2_allotment;
												$q3_allotment = $item5->q3_allotment;
												$q4_allotment = $item5->q4_allotment;
												$q1_adjustment = $item5->q1_adjustment;
												$q2_adjustment = $item5->q2_adjustment;
												$q3_adjustment = $item5->q3_adjustment;
												$q4_adjustment = $item5->q4_adjustment;
												$q1_obligation = $item5->q1_obligation;
												$q2_obligation = $item5->q2_obligation;
												$q3_obligation = $item5->q3_obligation;
												$q4_obligation = $item5->q4_obligation;
												$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
												$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
												$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
												$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
												$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
												$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
												$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
												$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;?>
												<tr class="text-right">
													<td class="objexp1">{{ $item5->object_code }}: {{ $item5->object_expenditure }}
														@if($item5->pooled_at_division_id != NULL) 
														- Pooled at {{ $item5->pooled_at_division_acronym }} ({{ $item5->division_acronym }})@endif
													</td>		
													@if($view_selected == 'annual')
														<td class="yellow-bg">{{ number_format($total_allotment, 2) }}</td>													
														<td class="lightred-bg">
															<a class="btn_adjustment" data-id="{{ $item5->id }}" data-toggle="modal" data-target="#adjustment_modal"
																data-toggle="tooltip" data-placement='auto' title='Allotment Adjustment '>
																{{ number_format($total_adjustment, 2) }}</a>
														</td>														
														<td class="lightgreen-bg">{{ number_format($total_obligation, 2) }}</td>													
														<td>{{ number_format($total_balance, 2) }}</td>		
													@elseif($view_selected == 'q1')		
														<td class="yellow-bg">{{ number_format($q1_allotment, 2) }}</td>													
														<td class="lightred-bg">{{ number_format($q1_adjustment, 2) }}</td>													
														<td class="lightgreen-bg">{{ number_format($q1_obligation, 2) }}</td>													
														<td>{{ number_format($q1_balance, 2) }}</td>		
													@elseif($view_selected == 'q2')		
														<td class="yellow-bg">{{ number_format($q2_allotment, 2) }}</td>													
														<td class="lightred-bg">{{ number_format($q2_adjustment, 2) }}</td>													
														<td class="lightgreen-bg">{{ number_format($q2_obligation, 2) }}</td>													
														<td>{{ number_format($q2_balance, 2) }}</td>	
													@elseif($view_selected == 'q3')		
														<td class="yellow-bg">{{ number_format($q3_allotment, 2) }}</td>													
														<td class="lightred-bg">{{ number_format($q3_adjustment, 2) }}</td>													
														<td class="lightgreen-bg">{{ number_format($q3_obligation, 2) }}</td>													
														<td>{{ number_format($q3_balance, 2) }}</td>	
													@elseif($view_selected == 'q4')		
														<td class="yellow-bg">{{ number_format($q4_allotment, 2) }}</td>													
														<td class="lightred-bg">{{ number_format($q4_adjustment, 2) }}</td>													
														<td class="lightgreen-bg">{{ number_format($q4_obligation, 2) }}</td>													
														<td>{{ number_format($q4_balance, 2) }}</td>		
													@endif			
													@role('Budget Officer|Super Administrator')		
														@if($division_id!=5)	
														<td class="text-center">
															<button type="button" data-id="{{ $item5->id }}"
																data-toggle="modal" data-target="#allotment_modal" data-toggle="tooltip" 
																data-placement='auto' title='View'class="btn-xs btn_view">
																<i class="fa-solid fa-eye"></i>																				
															</button>		
															<button type="button" class="btn-xs btn_edit" data-id="{{ $item5->id }}" 
																data-toggle="modal" data-target="#allotment_modal" data-toggle="tooltip" 
																data-placement='auto' title='Edit'>
																<i class="fa-solid fa-edit green fa-lg"></i>																				
															</button>																																	
															<button type="button" class="btn-xs btn_delete" data-id="{{ $item5->id }}" 
																data-toggle="tooltip" data-placement='auto'title='Delete'>
																<i class="fa-solid fa-trash-can fa-lg red"></i>
															</button>																																					 
														</td>
														@endif
													@endrole													
												</tr><?php
											}
											foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
											->where('activity_id', $item2->activity_id)
											->where('subactivity_id', $item3->subactivity_id)
											->where('expense_account_id', $item4->expense_account_id)
											->whereNotNull('object_specific_id')
											->groupBY('object_expenditure_id') as $key5=>$row5){
												foreach($row5 as $item5) {}//item 4
												$q1_allotment = $item5->q1_allotment;
												$q2_allotment = $item5->q2_allotment;
												$q3_allotment = $item5->q3_allotment;
												$q4_allotment = $item5->q4_allotment;
												$q1_adjustment = $item5->q1_adjustment;
												$q2_adjustment = $item5->q2_adjustment;
												$q3_adjustment = $item5->q3_adjustment;
												$q4_adjustment = $item5->q4_adjustment;
												$q1_obligation = $item5->q1_obligation;
												$q2_obligation = $item5->q2_obligation;
												$q3_obligation = $item5->q3_obligation;
												$q4_obligation = $item5->q4_obligation;
												$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
												$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
												$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
												$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
												$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
												$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
												$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
												$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;
												if($item5->object_specific_id != NULL){?>
													<tr>
														<td class="objexp1" colspan="5">{{ $item5->object_code }}: {{ $item5->object_expenditure }}</td>														
													</tr><?php
													foreach($data->where('allotment_class_id', $item->allotment_class_id)->where('pap_id', $item1->pap_id)
													->where('activity_id', $item2->activity_id)
													->where('subactivity_id', $item3->subactivity_id)
													->where('expense_account_id', $item4->expense_account_id)
													->where('object_expenditure_id', $item5->object_expenditure_id)
													->whereNotNull('object_specific_id')
													->groupBY('id') as $key6=>$row6){
														foreach($row6 as $item6) {}//item 4
														$q1_allotment = $item6->q1_allotment;
														$q2_allotment = $item6->q2_allotment;
														$q3_allotment = $item6->q3_allotment;
														$q4_allotment = $item6->q4_allotment;
														$q1_adjustment = $item6->q1_adjustment;
														$q2_adjustment = $item6->q2_adjustment;
														$q3_adjustment = $item6->q3_adjustment;
														$q4_adjustment = $item6->q4_adjustment;
														$q1_obligation = $item6->q1_obligation;
														$q2_obligation = $item6->q2_obligation;
														$q3_obligation = $item6->q3_obligation;
														$q4_obligation = $item6->q4_obligation;
														$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
														$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
														$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
														$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
														$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
														$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
														$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
														$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;?>
														<tr class="text-right">
															<td class="objspe1 font-italic">{{ $item6->object_specific }}
																@if($item6->pooled_at_division_id != NULL) 
																- Pooled at {{ $item6->pooled_at_division_acronym }} ({{ $item6->division_acronym }})@endif
															</td>		
															@if($view_selected == 'annual')
																<td class="yellow-bg ">{{ number_format($total_allotment, 2) }}</td>													
																<td class="lightred-bg">
																	<a class="btn_adjustment" data-id="{{ $item6->id }}" data-toggle="modal" data-target="#adjustment_modal"
																		data-toggle="tooltip" data-placement='auto' title='Adjust Allotment'>
																		{{ number_format($total_adjustment, 2) }}</a>
																</td>														
																<td class="lightgreen-bg">{{ number_format($total_obligation, 2) }}</td>													
																<td>{{ number_format($total_balance, 2) }}</td>		
															@elseif($view_selected == 'q1')		
																<td class="yellow-bg">{{ number_format($q1_allotment, 2) }}</td>													
																<td class="lightred-bg">{{ number_format($q1_adjustment, 2) }}</td>													
																<td class="lightgreen-bg">{{ number_format($q1_obligation, 2) }}</td>													
																<td>{{ number_format($q1_balance, 2) }}</td>		
															@elseif($view_selected == 'q2')		
																<td class="yellow-bg">{{ number_format($q2_allotment, 2) }}</td>													
																<td class="lightred-bg">{{ number_format($q2_adjustment, 2) }}</td>													
																<td class="lightgreen-bg">{{ number_format($q2_obligation, 2) }}</td>													
																<td>{{ number_format($q2_balance, 2) }}</td>	
															@elseif($view_selected == 'q3')		
																<td class="yellow-bg">{{ number_format($q3_allotment, 2) }}</td>													
																<td class="lightred-bg">{{ number_format($q3_adjustment, 2) }}</td>													
																<td class="lightgreen-bg">{{ number_format($q3_obligation, 2) }}</td>													
																<td>{{ number_format($q3_balance, 2) }}</td>	
															@elseif($view_selected == 'q4')		
																<td class="yellow-bg">{{ number_format($q4_allotment, 2) }}</td>													
																<td class="lightred-bg">{{ number_format($q4_adjustment, 2) }}</td>													
																<td class="lightgreen-bg">{{ number_format($q4_obligation, 2) }}</td>													
																<td>{{ number_format($q4_balance, 2) }}</td>		
															@endif			
															@role('Budget Officer|Super Administrator')		
																@if($division_id!=5)	
																<td class="text-center">
																	<button type="button" data-id="{{ $item6->id }}"
																		data-toggle="modal" data-target="#allotment_modal" data-toggle="tooltip" 
																		data-placement='auto' title='View'class="btn-xs btn_view">
																		<i class="fa-solid fa-eye"></i>																				
																	</button>		
																	<button type="button" class="btn-xs btn_edit" data-id="{{ $item6->id }}" 
																		data-toggle="modal" data-target="#allotment_modal" data-toggle="tooltip" 
																		data-placement='auto' title='Edit'>
																		<i class="fa-solid fa-edit green fa-lg"></i>																				
																	</button>																																	
																	<button type="button" class="btn-xs btn_delete" data-id="{{ $item6->id }}" 
																		data-toggle="tooltip" data-placement='auto'title='Delete'>
																		<i class="fa-solid fa-trash-can fa-lg red"></i>
																	</button>																																					 
																</td>
																@endif
															@endrole	
														</tr><?php
													}
												}
											}
										}
									}					
								}
								if(isset($item2->activity) && $item->allotment_class_id!=1){
									$q1_allotment_activity = $row2->sum('q1_allotment');
									$q2_allotment_activity = $row2->sum('q2_allotment');
									$q3_allotment_activity = $row2->sum('q3_allotment');
									$q4_allotment_activity = $row2->sum('q4_allotment');
									$q1_adjustment_activity = $row2->sum('q1_adjustment');
									$q2_adjustment_activity = $row2->sum('q2_adjustment');
									$q3_adjustment_activity = $row2->sum('q3_adjustment');
									$q4_adjustment_activity = $row2->sum('q4_adjustment');
									$q1_obligation_activity = $row2->sum('q1_obligation');
									$q2_obligation_activity = $row2->sum('q2_obligation');
									$q3_obligation_activity = $row2->sum('q3_obligation');
									$q4_obligation_activity = $row2->sum('q4_obligation');
									$q1_balance_activity = ($q1_allotment_activity + $q1_adjustment_activity) - $q1_obligation_activity;
									$q2_balance_activity = ($q2_allotment_activity + $q2_adjustment_activity) - $q2_obligation_activity;
									$q3_balance_activity = ($q3_allotment_activity + $q3_adjustment_activity) - $q3_obligation_activity;
									$q4_balance_activity = ($q4_allotment_activity + $q4_adjustment_activity) - $q4_obligation_activity;
									$total_allotment_activity = $q1_allotment_activity + $q2_allotment_activity + $q3_allotment_activity + $q4_allotment_activity;
									$total_adjustment_activity = $q1_adjustment_activity + $q2_adjustment_activity + $q3_adjustment_activity + $q4_adjustment_activity;
									$total_obligation_activity = $q1_obligation_activity + $q2_obligation_activity + $q3_obligation_activity + $q4_obligation_activity;
									$total_balance_activity = ($total_allotment_activity + $total_adjustment_activity) - $total_obligation_activity;?>
									<tr class="text-right font-weight-bold gray-bg">
										<td>Total Activity, {{ $item2->activity }}</td>
										@if($view_selected == 'annual')
											<td>&nbsp;&nbsp;{{ number_format($total_allotment_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($total_adjustment_activity, 2) }}</td>														
											<td>&nbsp;&nbsp;{{ number_format($total_obligation_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($total_balance_activity, 2) }}</td>		
										@elseif($view_selected == 'q1')		
											<td>&nbsp;&nbsp;{{ number_format($q1_allotment_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q1_adjustment_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q1_obligation_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q1_balance_activity, 2) }}</td>		
										@elseif($view_selected == 'q2')		
											<td>&nbsp;&nbsp;{{ number_format($q2_allotment_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q2_adjustment_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q2_obligation_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q2_balance_activity, 2) }}</td>	
										@elseif($view_selected == 'q3')		
											<td>&nbsp;&nbsp;{{ number_format($q3_allotment_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q3_adjustment_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q3_obligation_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q3_balance_activity, 2) }}</td>	
										@elseif($view_selected == 'q4')		
											<td>&nbsp;&nbsp;{{ number_format($q4_allotment_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q4_adjustment_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q4_obligation_activity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q4_balance_activity, 2) }}</td>		
										@endif	
									</tr>
									<?php
								}
							}							
							if(isset($item1->pap)){
								$q1_allotment_pap = $row1->sum('q1_allotment');
								$q2_allotment_pap = $row1->sum('q2_allotment');
								$q3_allotment_pap = $row1->sum('q3_allotment');
								$q4_allotment_pap = $row1->sum('q4_allotment');
								$q1_adjustment_pap = $row1->sum('q1_adjustment');
								$q2_adjustment_pap = $row1->sum('q2_adjustment');
								$q3_adjustment_pap = $row1->sum('q3_adjustment');
								$q4_adjustment_pap = $row1->sum('q4_adjustment');
								$q1_obligation_pap = $row1->sum('q1_obligation');
								$q2_obligation_pap = $row1->sum('q2_obligation');
								$q3_obligation_pap = $row1->sum('q3_obligation');
								$q4_obligation_pap = $row1->sum('q4_obligation');
								$q1_balance_pap = ($q1_allotment_pap + $q1_adjustment_pap) - $q1_obligation_pap;
								$q2_balance_pap = ($q2_allotment_pap + $q2_adjustment_pap) - $q2_obligation_pap;
								$q3_balance_pap = ($q3_allotment_pap + $q3_adjustment_pap) - $q3_obligation_pap;
								$q4_balance_pap = ($q4_allotment_pap + $q4_adjustment_pap) - $q4_obligation_pap;
								$total_allotment_pap = $q1_allotment_pap + $q2_allotment_pap + $q3_allotment_pap + $q4_allotment_pap;
								$total_adjustment_pap = $q1_adjustment_pap + $q2_adjustment_pap + $q3_adjustment_pap + $q4_adjustment_pap;
								$total_obligation_pap = $q1_obligation_pap + $q2_obligation_pap + $q3_obligation_pap + $q4_obligation_pap;
								$total_balance_pap = ($total_allotment_pap + $total_adjustment_pap) - $total_obligation_pap;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td>Total PAP, {{ $item1->pap }}</td>
									@if($view_selected == 'annual')
										<td>&nbsp;&nbsp;{{ number_format($total_allotment_pap, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($total_adjustment_pap, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($total_obligation_pap, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($total_balance_pap, 2) }}</td>		
									@elseif($view_selected == 'q1')		
										<td>&nbsp;&nbsp;{{ number_format($q1_allotment_pap, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q1_adjustment_pap, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q1_obligation_pap, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q1_balance_pap, 2) }}</td>		
									@elseif($view_selected == 'q2')		
										<td>&nbsp;&nbsp;{{ number_format($q2_allotment_pap, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q2_adjustment_pap, 2) }}</td>													
										<td>{{ number_format($q2_obligation_pap, 2) }}</td>													
										<td>{{ number_format($q2_balance_pap, 2) }}</td>	
									@elseif($view_selected == 'q3')		
										<td>{{ number_format($q3_allotment_pap, 2) }}</td>													
										<td>{{ number_format($q3_adjustment_pap, 2) }}</td>													
										<td>{{ number_format($q3_obligation_pap, 2) }}</td>													
										<td>{{ number_format($q3_balance_pap, 2) }}</td>	
									@elseif($view_selected == 'q4')		
										<td>{{ number_format($q4_allotment_pap, 2) }}</td>													
										<td>{{ number_format($q4_adjustment_pap, 2) }}</td>													
										<td>{{ number_format($q4_obligation_pap, 2) }}</td>													
										<td>{{ number_format($q4_balance_pap, 2) }}</td>		
									@endif	
								<?php 
							}
						}
						if(isset($item->allotment_class_id)){
							$q1_allotment_aclass = $row->sum('q1_allotment');
							$q2_allotment_aclass = $row->sum('q2_allotment');
							$q3_allotment_aclass = $row->sum('q3_allotment');
							$q4_allotment_aclass = $row->sum('q4_allotment');
							$q1_adjustment_aclass = $row->sum('q1_adjustment');
							$q2_adjustment_aclass = $row->sum('q2_adjustment');
							$q3_adjustment_aclass = $row->sum('q3_adjustment');
							$q4_adjustment_aclass = $row->sum('q4_adjustment');
							$q1_obligation_aclass = $row->sum('q1_obligation');
							$q2_obligation_aclass = $row->sum('q2_obligation');
							$q3_obligation_aclass = $row->sum('q3_obligation');
							$q4_obligation_aclass = $row->sum('q4_obligation');
							$q1_balance_aclass = ($q1_allotment_aclass + $q1_adjustment_aclass) - $q1_obligation_aclass;
							$q2_balance_aclass = ($q2_allotment_aclass + $q2_adjustment_aclass) - $q2_obligation_aclass;
							$q3_balance_aclass = ($q3_allotment_aclass + $q3_adjustment_aclass) - $q3_obligation_aclass;
							$q4_balance_aclass = ($q4_allotment_aclass + $q4_adjustment_aclass) - $q4_obligation_aclass;
							$total_allotment_aclass = $q1_allotment_aclass + $q2_allotment_aclass + $q3_allotment_aclass + $q4_allotment_aclass;
							$total_adjustment_aclass = $q1_adjustment_aclass + $q2_adjustment_aclass + $q3_adjustment_aclass + $q4_adjustment_aclass;
							$total_obligation_aclass = $q1_obligation_aclass + $q2_obligation_aclass + $q3_obligation_aclass + $q4_obligation_aclass;
							$total_balance_aclass = ($total_allotment_aclass + $total_adjustment_aclass) - $total_obligation_aclass;?>
							<tr class="text-right font-weight-bold gray-bg">
								<td>TOTAL {{ $item->allotment_class_acronym }}</td>
								@if($view_selected == 'annual')
									<td>{{ number_format($total_allotment_aclass, 2) }}</td>													
									<td>{{ number_format($total_adjustment_aclass, 2) }}</td>														
									<td>{{ number_format($total_obligation_aclass, 2) }}</td>													
									<td>{{ number_format($total_balance_aclass, 2) }}</td>		
								@elseif($view_selected == 'q1')		
									<td>{{ number_format($q1_allotment_aclass, 2) }}</td>													
									<td>{{ number_format($q1_adjustment_aclass, 2) }}</td>													
									<td>{{ number_format($q1_obligation_aclass, 2) }}</td>													
									<td>{{ number_format($q1_balance_aclass, 2) }}</td>		
								@elseif($view_selected == 'q2')		
									<td>{{ number_format($q2_allotment_aclass, 2) }}</td>													
									<td>{{ number_format($q2_adjustment_aclass, 2) }}</td>													
									<td>{{ number_format($q2_obligation_aclass, 2) }}</td>													
									<td>{{ number_format($q2_balance_aclass, 2) }}</td>	
								@elseif($view_selected == 'q3')		
									<td>{{ number_format($q3_allotment_aclass, 2) }}</td>													
									<td>{{ number_format($q3_adjustment_aclass, 2) }}</td>													
									<td>{{ number_format($q3_obligation_aclass, 2) }}</td>													
									<td>{{ number_format($q3_balance_aclass, 2) }}</td>	
								@elseif($view_selected == 'q4')		
									<td>{{ number_format($q4_allotment_aclass, 2) }}</td>													
									<td>{{ number_format($q4_adjustment_aclass, 2) }}</td>													
									<td>{{ number_format($q4_obligation_aclass, 2) }}</td>													
									<td>{{ number_format($q4_balance_aclass, 2) }}</td>		
								@endif	
							<?php 
						}
					}
					if($division_id!=5){
						if($view_selected=='annual'){
							foreach($data->groupBy('parent_division_id') as $keySum=>$rowSum){
								foreach($rowSum as $itemSum){}
									$total_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
									$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
									$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
									$total_balance = ($total_adjustment + $total_allotment) - $total_obligation;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td>GRAND TOTAL</td>
									<td>&nbsp;&nbsp;{{ number_format($total_allotment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($total_adjustment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($total_obligation, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($total_balance, 2) }}</td>
								</tr><?php
							}
						}
						elseif($view_selected=='q1'){
							foreach($data->groupBy('division_id') as $keySum=>$rowSum){
								foreach($rowSum as $itemSum){}
									$q1_allotment = $rowSum->sum('q1_allotment') ;
									$q1_adjustment = $rowSum->sum('q1_adjustment');
									$q1_obligation = $rowSum->sum('q1_obligation');
									$q1_balance = ($q1_adjustment + $q1_allotment) - $q1_obligation;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td class="text-left">GRAND TOTAL</td>
									<td>&nbsp;&nbsp;{{ number_format($q1_allotment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q1_adjustment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q1_obligation, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q1_balance, 2) }}</td>
								</tr><?php
							}
						}
						elseif($view_selected=='q2'){
							foreach($data->groupBy('division_id') as $keySum=>$rowSum){
								foreach($rowSum as $itemSum){}
									$q2_allotment = $rowSum->sum('q2_allotment') ;
									$q2_adjustment = $rowSum->sum('q2_adjustment');
									$q2_obligation = $rowSum->sum('q2_obligation');
									$q2_balance = ($q2_adjustment + $q2_allotment) - $q2_obligation;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td class="text-left">GRAND TOTAL</td>
									<td>&nbsp;&nbsp;{{ number_format($q2_allotment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q2_adjustment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q2_obligation, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q2_balance, 2) }}</td>
								</tr><?php
							}
						}
						elseif($view_selected=='q3'){
							foreach($data->groupBy('division_id') as $keySum=>$rowSum){
								foreach($rowSum as $itemSum){}
									$q3_allotment = $rowSum->sum('q3_allotment') ;
									$q3_adjustment = $rowSum->sum('q3_adjustment');
									$q3_obligation = $rowSum->sum('q3_obligation');
									$q3_balance = ($q3_adjustment + $q3_allotment) - $q3_obligation;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td class="text-left">GRAND TOTAL</td>
									<td>&nbsp;&nbsp;{{ number_format($q3_allotment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q3_adjustment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q3_obligation, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q3_balance, 2) }}</td>
								</tr><?php
							}
						}
						elseif($view_selected=='q4'){
							foreach($data->groupBy('division_id') as $keySum=>$rowSum){
								foreach($rowSum as $itemSum){}
									$q4_allotment = $rowSum->sum('q4_allotment') ;
									$q4_adjustment = $rowSum->sum('q4_adjustment');
									$q4_obligation = $rowSum->sum('q4_obligation');
									$q4_balance = ($q4_adjustment + $q4_allotment) - $q4_obligation;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td class="text-left">GRAND TOTAL</td>
									<td>&nbsp;&nbsp;{{ number_format($q4_allotment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q4_adjustment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q4_obligation, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($q4_balance, 2) }}</td>
								</tr><?php
							}
						}
					}
					elseif($division_id==5){?>
						<tr>
							<td class="font-weight-bold">POOLED AMOUNT</td>
						</tr><?php	
						foreach($data1->groupBY('object_expenditure_id') as $key=>$row){
							foreach($row as $item) {}?>
							<tr>
								<td class="expense font-weight-bold">{{ $item1->object_code }}: {{ $item->object_expenditure }}</td>
							</tr>
							<?php
							foreach($data1->where('object_expenditure_id', $item->object_expenditure_id)
							->groupBY('division_id')as $key1=>$row1){							
								foreach($row1 as $item1) {}
								$q1_allotment=$row1->sum('q1_allotment'); 
								$q2_allotment=$row1->sum('q2_allotment'); 
								$q3_allotment=$row1->sum('q3_allotment'); 
								$q4_allotment=$row1->sum('q4_allotment'); 
								$q1_adjustment=$row1->sum('q1_adjustment'); 	
								$q2_adjustment=$row1->sum('q2_adjustment'); 	
								$q3_adjustment=$row1->sum('q3_adjustment'); 	
								$q4_adjustment=$row1->sum('q4_adjustment'); 	
								$q1_obligation=$row1->sum('q1_obligation'); 	
								$q2_obligation=$row1->sum('q2_obligation');	
								$q3_obligation=$row1->sum('q3_obligation');	
								$q4_obligation=$row1->sum('q4_obligation');	
								$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
								$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
								$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
								$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
								$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
								$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
								$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
								$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;?>
								<tr class="text-right">
									<td class="objspe1 font-italic">{{ $item1->division_acronym }}</td>		
									@if($view_selected == 'annual')
										<td class="yellow-bg">{{ number_format($total_allotment, 2) }}</td>													
										<td class="lightred-bg">{{ number_format($total_adjustment, 2) }}</td>														
										<td class="lightgreen-bg">{{ number_format($total_obligation, 2) }}</td>													
										<td>{{ number_format($total_balance, 2) }}</td>		
									@elseif($view_selected == 'q1')		
										<td class="yellow-bg">{{ number_format($q1_allotment, 2) }}</td>													
										<td class="lightred-bg">{{ number_format($q1_adjustment, 2) }}</td>													
										<td class="lightgreen-bg">{{ number_format($q1_obligation, 2) }}</td>													
										<td>{{ number_format($q1_balance, 2) }}</td>		
									@elseif($view_selected == 'q2')		
										<td class="yellow-bg">{{ number_format($q2_allotment, 2) }}</td>													
										<td class="lightred-bg">{{ number_format($q2_adjustment, 2) }}</td>													
										<td class="lightgreen-bg">{{ number_format($q2_obligation, 2) }}</td>													
										<td>{{ number_format($q2_balance, 2) }}</td>	
									@elseif($view_selected == 'q3')		
										<td class="yellow-bg">{{ number_format($q3_allotment, 2) }}</td>													
										<td class="lightred-bg">{{ number_format($q3_adjustment, 2) }}</td>													
										<td class="lightgreen-bg">{{ number_format($q3_obligation, 2) }}</td>													
										<td>{{ number_format($q3_balance, 2) }}</td>	
									@elseif($view_selected == 'q4')		
										<td class="yellow-bg">{{ number_format($q4_allotment, 2) }}</td>													
										<td class="lightred-bg">{{ number_format($q4_adjustment, 2) }}</td>													
										<td class="lightgreen-bg">{{ number_format($q4_obligation, 2) }}</td>													
										<td>{{ number_format($q4_balance, 2) }}</td>		
									@endif										
								</tr><?php
							}
						}	
						if($view_selected=='annual'){
							foreach($data1->groupBy('year') as $keySum=>$rowSum){
								foreach($rowSum as $itemSum){}
									$total_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
									$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
									$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
									$total_balance = ($total_adjustment + $total_allotment) - $total_obligation;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td>POOLED TOTAL</td>
									<td>&emsp;{{ number_format($total_allotment, 2) }}</td>
									<td>&emsp;{{ number_format($total_adjustment, 2) }}</td>
									<td>&emsp;{{ number_format($total_obligation, 2) }}</td>
									<td>&emsp;{{ number_format($total_balance, 2) }}</td>
								</tr><?php
							}
							foreach($data2->groupBy('year') as $keySum=>$rowSum){
								foreach($rowSum as $itemSum){}
									$total_allotment = $rowSum->sum('q1_allotment') + $rowSum->sum('q2_allotment') + $rowSum->sum('q3_allotment') + $rowSum->sum('q4_allotment');
									$total_adjustment = $rowSum->sum('q1_adjustment') + $rowSum->sum('q2_adjustment') + $rowSum->sum('q3_adjustment') + $rowSum->sum('q4_adjustment');
									$total_obligation = $rowSum->sum('q1_obligation') + $rowSum->sum('q2_obligation') + $rowSum->sum('q3_obligation') + $rowSum->sum('q4_obligation');
									$total_balance = ($total_adjustment + $total_allotment) - $total_obligation;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td>GRAND TOTAL</td>
									<td>&nbsp;&nbsp;{{ number_format($total_allotment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($total_adjustment, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($total_obligation, 2) }}</td>
									<td>&nbsp;&nbsp;{{ number_format($total_balance, 2) }}</td>
								</tr><?php
							}
						}
					}					
				}
				else{					
					foreach($data->groupBY('pap_code') as $key1=>$row1){
						foreach($row1 as $item1) {} //item 1?>
						<tr>
							<td class="pap font-weight-bold gray1-bg" colspan="5">{{ $item1->pap }}</td>										
						</tr><?php 	
						foreach($data->where('pap_id', $item1->pap_id)->groupBY('activity_id') as $key2=>$row2){
							foreach($row2 as $item2) {} //item 2?>
							<tr>
								<td class="activity1 font-weight-bold" colspan="5">{{ $item2->activity }}</td>													
							</tr><?php 
							foreach($data->where('pap_id', $item1->pap_id)->where('activity_id', $item2->activity_id)
								->groupBY('subactivity_id') as $key3=>$row3){
								foreach($row3 as $item3) {} 
								if(isset($item3->subactivity)){//item 3?>
									<tr class="text-right font-weight-bold gray3-bg">
										<td colspan="5" class="subactivity1">{{ $item3->subactivity }}</td>																					
									</tr><?php 
								}												
								foreach($data->where('pap_id', $item1->pap_id)
									->where('activity_id', $item2->activity_id)
									->where('subactivity_id', $item3->subactivity_id)
									->groupBY('cost_type_id') as $key4=>$row4){
									foreach($row4 as $item4) {} ?>
										<tr>
											<td class="costtype font-weight-bold">
												@if($item4->cost_type_id==1) Direct Cost
												@elseif($item4->cost_type_id==2) Indirect Cost
												@endif
											</td>			
										</tr>
										<?php								
									foreach($data->where('pap_id', $item1->pap_id)
										->where('activity_id', $item2->activity_id)
										->where('subactivity_id', $item3->subactivity_id)
										->where('cost_type_id', $item4->cost_type_id)
										->groupBY('expense_account_id') as $key5=>$row5){
										foreach($row5 as $item5) {}
										foreach($data->where('pap_id', $item1->pap_id)
											->where('activity_id', $item2->activity_id)
											->where('subactivity_id', $item3->subactivity_id)
											->where('cost_type_id', $item4->cost_type_id)
											->where('expense_account_id', $item5->expense_account_id)
											->groupBY('id') as $key6=>$row6){
											foreach($row6 as $item6) {}//item 4
											$q1_allotment = $item6->q1_allotment;
											$q2_allotment = $item6->q2_allotment;
											$q3_allotment = $item6->q3_allotment;
											$q4_allotment = $item6->q4_allotment;
											$q1_adjustment = $item6->q1_adjustment;
											$q2_adjustment = $item6->q2_adjustment;
											$q3_adjustment = $item6->q3_adjustment;
											$q4_adjustment = $item6->q4_adjustment;
											$q1_obligation = $item6->q1_obligation;
											$q2_obligation = $item6->q2_obligation;
											$q3_obligation = $item6->q3_obligation;
											$q4_obligation = $item6->q4_obligation;
											$q1_balance = ($q1_allotment + $q1_adjustment) - $q1_obligation;
											$q2_balance = ($q2_allotment + $q2_adjustment) - $q2_obligation;
											$q3_balance = ($q3_allotment + $q3_adjustment) - $q3_obligation;
											$q4_balance = ($q4_allotment + $q4_adjustment) - $q4_obligation;
											$total_allotment = $q1_allotment + $q2_allotment + $q3_allotment + $q4_allotment;
											$total_adjustment = $q1_adjustment + $q2_adjustment + $q3_adjustment + $q4_adjustment;
											$total_obligation = $q1_obligation + $q2_obligation + $q3_obligation + $q4_obligation;
											$total_balance = ($total_allotment + $total_adjustment) - $total_obligation;?>											
											<tr>
												<td class="expense1">
													@if($item6->object_expenditure!=NULL) {{ $item6->object_code }}: {{ $item6->object_expenditure }} 
													@else {{ $item6->expense_account_code }}: {{ $item6->expense_account }}
													@endif
												</td>												
												@if($view_selected == 'annual')
													<td class="yellow-bg ">{{ number_format($total_allotment, 2) }}</td>													
													<td class="lightred-bg">
														<a class="btn_adjustment" data-id="{{ $item6->id }}" data-toggle="modal" data-target="#adjustment_modal"
															data-toggle="tooltip" data-placement='auto' title='Adjust Allotment'>
															{{ number_format($total_adjustment, 2) }}</a>
													</td>														
													<td class="lightgreen-bg">{{ number_format($total_obligation, 2) }}</td>													
													<td>{{ number_format($total_balance, 2) }}</td>		
												@elseif($view_selected == 'q1')		
													<td class="yellow-bg">{{ number_format($q1_allotment, 2) }}</td>													
													<td class="lightred-bg">{{ number_format($q1_adjustment, 2) }}</td>													
													<td class="lightgreen-bg">{{ number_format($q1_obligation, 2) }}</td>													
													<td>{{ number_format($q1_balance, 2) }}</td>		
												@elseif($view_selected == 'q2')		
													<td class="yellow-bg">{{ number_format($q2_allotment, 2) }}</td>													
													<td class="lightred-bg">{{ number_format($q2_adjustment, 2) }}</td>													
													<td class="lightgreen-bg">{{ number_format($q2_obligation, 2) }}</td>													
													<td>{{ number_format($q2_balance, 2) }}</td>	
												@elseif($view_selected == 'q3')		
													<td class="yellow-bg">{{ number_format($q3_allotment, 2) }}</td>													
													<td class="lightred-bg">{{ number_format($q3_adjustment, 2) }}</td>													
													<td class="lightgreen-bg">{{ number_format($q3_obligation, 2) }}</td>													
													<td>{{ number_format($q3_balance, 2) }}</td>	
												@elseif($view_selected == 'q4')		
													<td class="yellow-bg">{{ number_format($q4_allotment, 2) }}</td>													
													<td class="lightred-bg">{{ number_format($q4_adjustment, 2) }}</td>													
													<td class="lightgreen-bg">{{ number_format($q4_obligation, 2) }}</td>													
													<td>{{ number_format($q4_balance, 2) }}</td>		
												@endif			
												@role('Budget Officer|Super Administrator')		
													@if($division_id!=5)	
													<td class="text-center">
														<button type="button" data-id="{{ $item6->id }}"
															data-toggle="modal" data-target="#allotment_modal" data-toggle="tooltip" 
															data-placement='auto' title='View'class="btn-xs btn_view">
															<i class="fa-solid fa-eye"></i>																				
														</button>		
														<button type="button" class="btn-xs btn_edit" data-id="{{ $item6->id }}" 
															data-toggle="modal" data-target="#allotment_modal" data-toggle="tooltip" 
															data-placement='auto' title='Edit'>
															<i class="fa-solid fa-edit green fa-lg"></i>																				
														</button>																																	
														<button type="button" class="btn-xs btn_delete" data-id="{{ $item6->id }}" 
															data-toggle="tooltip" data-placement='auto'title='Delete'>
															<i class="fa-solid fa-trash-can fa-lg red"></i>
														</button>																																					 
													</td>
													@endif
												@endrole	
											</tr><?php	
										}										
									}	
								}
								if(isset($item3->subactivity)){
									$q1_allotment_subactivity = $row3->sum('q1_allotment');
									$q2_allotment_subactivity = $row3->sum('q2_allotment');
									$q3_allotment_subactivity = $row3->sum('q3_allotment');
									$q4_allotment_subactivity = $row3->sum('q4_allotment');
									$q1_adjustment_subactivity = $row3->sum('q1_adjustment');
									$q2_adjustment_subactivity = $row3->sum('q2_adjustment');
									$q3_adjustment_subactivity = $row3->sum('q3_adjustment');
									$q4_adjustment_subactivity = $row3->sum('q4_adjustment');
									$q1_obligation_subactivity = $row3->sum('q1_obligation');
									$q2_obligation_subactivity = $row3->sum('q2_obligation');
									$q3_obligation_subactivity = $row3->sum('q3_obligation');
									$q4_obligation_subactivity = $row3->sum('q4_obligation');
									$q1_balance_subactivity = ($q1_allotment_subactivity + $q1_adjustment_subactivity) - $q1_obligation_subactivity;
									$q2_balance_subactivity = ($q2_allotment_subactivity + $q2_adjustment_subactivity) - $q2_obligation_subactivity;
									$q3_balance_subactivity = ($q3_allotment_subactivity + $q3_adjustment_subactivity) - $q3_obligation_subactivity;
									$q4_balance_subactivity = ($q4_allotment_subactivity + $q4_adjustment_subactivity) - $q4_obligation_subactivity;
									$total_allotment_subactivity = $q1_allotment_subactivity + $q2_allotment_subactivity + $q3_allotment_subactivity + $q4_allotment_subactivity;
									$total_adjustment_subactivity = $q1_adjustment_subactivity + $q2_adjustment_subactivity + $q3_adjustment_subactivity + $q4_adjustment_subactivity;
									$total_obligation_subactivity = $q1_obligation_subactivity + $q2_obligation_subactivity + $q3_obligation_subactivity + $q4_obligation_subactivity;
									$total_balance_subactivity = ($total_allotment_subactivity + $total_adjustment_subactivity) - $total_obligation_subactivity;?>
									<tr class="text-right font-weight-bold gray-bg">
										<td>Total Subactivity, {{ $item3->subactivity }}</td>
										@if($view_selected == 'annual')
											<td>&nbsp;&nbsp;{{ number_format($total_allotment_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($total_adjustment_subactivity, 2) }}</td>														
											<td>&nbsp;&nbsp;{{ number_format($total_obligation_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($total_balance_subactivity, 2) }}</td>		
										@elseif($view_selected == 'q1')		
											<td>&nbsp;&nbsp;{{ number_format($q1_allotment_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q1_adjustment_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q1_obligation_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q1_balance_subactivity, 2) }}</td>		
										@elseif($view_selected == 'q2')		
											<td>&nbsp;&nbsp;{{ number_format($q2_allotment_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q2_adjustment_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q2_obligation_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q2_balance_subactivity, 2) }}</td>	
										@elseif($view_selected == 'q3')		
											<td>&nbsp;&nbsp;{{ number_format($q3_allotment_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q3_adjustment_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q3_obligation_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q3_balance_subactivity, 2) }}</td>	
										@elseif($view_selected == 'q4')		
											<td>&nbsp;&nbsp;{{ number_format($q4_allotment_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q4_adjustment_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q4_obligation_subactivity, 2) }}</td>													
											<td>&nbsp;&nbsp;{{ number_format($q4_balance_subactivity, 2) }}</td>		
										@endif	
									</tr>
									<?php
								}				
							}
							if(isset($item2->activity)){
								$q1_allotment_activity = $row2->sum('q1_allotment');
								$q2_allotment_activity = $row2->sum('q2_allotment');
								$q3_allotment_activity = $row2->sum('q3_allotment');
								$q4_allotment_activity = $row2->sum('q4_allotment');
								$q1_adjustment_activity = $row2->sum('q1_adjustment');
								$q2_adjustment_activity = $row2->sum('q2_adjustment');
								$q3_adjustment_activity = $row2->sum('q3_adjustment');
								$q4_adjustment_activity = $row2->sum('q4_adjustment');
								$q1_obligation_activity = $row2->sum('q1_obligation');
								$q2_obligation_activity = $row2->sum('q2_obligation');
								$q3_obligation_activity = $row2->sum('q3_obligation');
								$q4_obligation_activity = $row2->sum('q4_obligation');
								$q1_balance_activity = ($q1_allotment_activity + $q1_adjustment_activity) - $q1_obligation_activity;
								$q2_balance_activity = ($q2_allotment_activity + $q2_adjustment_activity) - $q2_obligation_activity;
								$q3_balance_activity = ($q3_allotment_activity + $q3_adjustment_activity) - $q3_obligation_activity;
								$q4_balance_activity = ($q4_allotment_activity + $q4_adjustment_activity) - $q4_obligation_activity;
								$total_allotment_activity = $q1_allotment_activity + $q2_allotment_activity + $q3_allotment_activity + $q4_allotment_activity;
								$total_adjustment_activity = $q1_adjustment_activity + $q2_adjustment_activity + $q3_adjustment_activity + $q4_adjustment_activity;
								$total_obligation_activity = $q1_obligation_activity + $q2_obligation_activity + $q3_obligation_activity + $q4_obligation_activity;
								$total_balance_activity = ($total_allotment_activity + $total_adjustment_activity) - $total_obligation_activity;?>
								<tr class="text-right font-weight-bold gray-bg">
									<td>Total Activity, {{ $item2->activity }}</td>
									@if($view_selected == 'annual')
										<td>&nbsp;&nbsp;{{ number_format($total_allotment_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($total_adjustment_activity, 2) }}</td>														
										<td>&nbsp;&nbsp;{{ number_format($total_obligation_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($total_balance_activity, 2) }}</td>		
									@elseif($view_selected == 'q1')		
										<td>&nbsp;&nbsp;{{ number_format($q1_allotment_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q1_adjustment_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q1_obligation_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q1_balance_activity, 2) }}</td>		
									@elseif($view_selected == 'q2')		
										<td>&nbsp;&nbsp;{{ number_format($q2_allotment_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q2_adjustment_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q2_obligation_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q2_balance_activity, 2) }}</td>	
									@elseif($view_selected == 'q3')		
										<td>&nbsp;&nbsp;{{ number_format($q3_allotment_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q3_adjustment_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q3_obligation_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q3_balance_activity, 2) }}</td>	
									@elseif($view_selected == 'q4')		
										<td>&nbsp;&nbsp;{{ number_format($q4_allotment_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q4_adjustment_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q4_obligation_activity, 2) }}</td>													
										<td>&nbsp;&nbsp;{{ number_format($q4_balance_activity, 2) }}</td>		
									@endif	
								</tr>
								<?php
							}
						}							
						if(isset($item1->pap)){
							$q1_allotment_pap = $row1->sum('q1_allotment');
							$q2_allotment_pap = $row1->sum('q2_allotment');
							$q3_allotment_pap = $row1->sum('q3_allotment');
							$q4_allotment_pap = $row1->sum('q4_allotment');
							$q1_adjustment_pap = $row1->sum('q1_adjustment');
							$q2_adjustment_pap = $row1->sum('q2_adjustment');
							$q3_adjustment_pap = $row1->sum('q3_adjustment');
							$q4_adjustment_pap = $row1->sum('q4_adjustment');
							$q1_obligation_pap = $row1->sum('q1_obligation');
							$q2_obligation_pap = $row1->sum('q2_obligation');
							$q3_obligation_pap = $row1->sum('q3_obligation');
							$q4_obligation_pap = $row1->sum('q4_obligation');
							$q1_balance_pap = ($q1_allotment_pap + $q1_adjustment_pap) - $q1_obligation_pap;
							$q2_balance_pap = ($q2_allotment_pap + $q2_adjustment_pap) - $q2_obligation_pap;
							$q3_balance_pap = ($q3_allotment_pap + $q3_adjustment_pap) - $q3_obligation_pap;
							$q4_balance_pap = ($q4_allotment_pap + $q4_adjustment_pap) - $q4_obligation_pap;
							$total_allotment_pap = $q1_allotment_pap + $q2_allotment_pap + $q3_allotment_pap + $q4_allotment_pap;
							$total_adjustment_pap = $q1_adjustment_pap + $q2_adjustment_pap + $q3_adjustment_pap + $q4_adjustment_pap;
							$total_obligation_pap = $q1_obligation_pap + $q2_obligation_pap + $q3_obligation_pap + $q4_obligation_pap;
							$total_balance_pap = ($total_allotment_pap + $total_adjustment_pap) - $total_obligation_pap;?>
							<tr class="text-right font-weight-bold gray-bg">
								<td>Total PAP, {{ $item1->pap }}</td>
								@if($view_selected == 'annual')
									<td>&nbsp;&nbsp;{{ number_format($total_allotment_pap, 2) }}</td>													
									<td>&nbsp;&nbsp;{{ number_format($total_adjustment_pap, 2) }}</td>														
									<td>&nbsp;&nbsp;{{ number_format($total_obligation_pap, 2) }}</td>													
									<td>&nbsp;&nbsp;{{ number_format($total_balance_pap, 2) }}</td>		
								@elseif($view_selected == 'q1')		
									<td>&nbsp;&nbsp;{{ number_format($q1_allotment_pap, 2) }}</td>													
									<td>&nbsp;&nbsp;{{ number_format($q1_adjustment_pap, 2) }}</td>													
									<td>&nbsp;&nbsp;{{ number_format($q1_obligation_pap, 2) }}</td>													
									<td>&nbsp;&nbsp;{{ number_format($q1_balance_pap, 2) }}</td>		
								@elseif($view_selected == 'q2')		
									<td>&nbsp;&nbsp;{{ number_format($q2_allotment_pap, 2) }}</td>													
									<td>&nbsp;&nbsp;{{ number_format($q2_adjustment_pap, 2) }}</td>													
									<td>{{ number_format($q2_obligation_pap, 2) }}</td>													
									<td>{{ number_format($q2_balance_pap, 2) }}</td>	
								@elseif($view_selected == 'q3')		
									<td>{{ number_format($q3_allotment_pap, 2) }}</td>													
									<td>{{ number_format($q3_adjustment_pap, 2) }}</td>													
									<td>{{ number_format($q3_obligation_pap, 2) }}</td>													
									<td>{{ number_format($q3_balance_pap, 2) }}</td>	
								@elseif($view_selected == 'q4')		
									<td>{{ number_format($q4_allotment_pap, 2) }}</td>													
									<td>{{ number_format($q4_adjustment_pap, 2) }}</td>													
									<td>{{ number_format($q4_obligation_pap, 2) }}</td>													
									<td>{{ number_format($q4_balance_pap, 2) }}</td>		
								@endif	
							<?php 
						}
					}
				}
				?>
			</tbody>
		</table>	 	 
  </div>    
</div>

