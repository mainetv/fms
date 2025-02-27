{{-- modal start --}}
	$('#bp_form6_modal').on('hide.bs.modal', function(){     
		clear_attributes();
		clearFields
 	});  
{{-- modal end --}}

{{-- view start --}}   
	function init_view_bp_form6(){
		$('.bp-form6-field')
			.val('')
			.attr('disabled', true);

		$('.save-buttons')
			.removeClass('d-inline')
			.addClass('d-none')
			.attr('disabled', true);
	}

	function view_bp_form6(bp_form6_id){
		var request = $.ajax({
			method: "GET",
			url: "{{ route('bp_form6.show') }}",
			data: {
			'_token': '{{ csrf_token() }}',
			'id' : bp_form6_id
			}
		});
		return request;
	}

	$('.btn_view_bp_form6').on('click', function(e){    
		$('#bp_form6_modal_header').html("View BP Form No. 6"); 
		bp_form6_id = $(this).data('id');
		init_view_bp_form6();   
		var request = view_bp_form6(bp_form6_id);   
		request.then(function(data) {
			if(data['status'] == 1){            
				$('#bp_form6_tier').val(data['bp_form6']['tier']) 
				$('#bp_form6_description').val(data['bp_form6']['description']) 
				$('#bp_form6_quantity').val(data['bp_form6']['quantity']) 
				$('#bp_form6_unit_cost').val(data['bp_form6']['unit_cost']) 
				$('#bp_form6_total_cost').val(data['bp_form6']['total_cost']) 
				$('#bp_form6_organizational_deployment').val(data['bp_form6']['organizational_deployment']) 
				$('#bp_form6_justification').val(data['bp_form6']['justification']) 
				$('#bp_form6_remarks').val(data['bp_form6']['remarks'])
			}                          
		})
		$('#bp_form6_modal').modal('toggle');
	})  
{{-- view end --}}

{{-- add start --}}
	function init_add_bp_form6(){
		$('.bp-form6-field')
			.attr('disabled', false);
			
		$('.add_bp_form6.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);      
	}

	$('.btn_add_bp_form6').on('click', function(){    
		init_add_bp_form6();
		var division_id=$(this).data('division-id');      
		var year=$(this).data('year');      
		var fiscal_year=$(this).data('fy');  
		$('#bp_form6_year').val(year);
		$('#bp_form6_fiscal_year').val(fiscal_year);
		$('#bp_form6_modal_header').html("Add BP Form No. 3");
		$('#bp_form6_modal').modal('toggle')       
	})

	$('.add_bp_form6').on('click', function(e){        
		e.prevenDefault;  
		clear_attributes();
		$.ajax({
			method: "POST",
			url: "{{ route('bp_form6.store') }}",
			data: {
			'_token': '{{ csrf_token() }}',
			'division_id' : $('#bp_form6_division_id').val(),
			'year' : $('#bp_form6_year').val(),
			'tier' : $('#bp_form6_tier').val(),
			'fiscal_year' : $('#bp_form6_fiscal_year').val(),
			'description' : $('#bp_form6_description').val(),
			'quantity' : $('#bp_form6_quantity').val(),
			'unit_cost' : $('#bp_form6_unit_cost').val(),
			'total_cost' : $('#bp_form6_total_cost').val(),
			'organizational_deployment' : $('#bp_form6_organizational_deployment').val(),
			'justification' : $('#bp_form6_justification').val(),
			'remarks' : $('#bp_form6_remarks').val(),
			},
			success:function(data) {
				console.log(data);
				if(data.errors) {         
					if(data.errors.description){
						$('#bp_form6_description').addClass('is-invalid');
						$('#bp-form6-description-error').html(data.errors.description[0]);
					}   
					if(data.errors.quantity){
						$('#bp_form6_quantity').addClass('is-invalid');
						$('#bp-form6-quantity-error').html(data.errors.quantity[0]);
					} 
					if(data.errors.unit_cost){
						$('#bp_form6_unit_cost').addClass('is-invalid');
						$('#bp-form6-unit-cost-error').html(data.errors.unit_cost[0]);
					} 
					if(data.errors.total_cost){
						$('#bp_form6_total_cost').addClass('is-invalid');
						$('#bp-form6-total-cost-error').html(data.errors.total_cost[0]);
					} 
					if(data.errors.organizational_deployment){
						$('#bp_form6_organizational_deployment').addClass('is-invalid');
						$('#bp-form6-organizational-deployment-error').html(data.errors.organizational_deployment[0]);
					} 
					if(data.errors.justification){
						$('#bp_form6_justification').addClass('is-invalid');
						$('#bp-form6-justification-error').html(data.errors.justification[0]);
					}                                 
				}
				if(data.success) {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'BP Form No. 3 has been successfully added.',
						showConfirmButton: false,
						timer: 1500
					}) 
					$('#bp_form6_modal').modal('toggle');  
					window.location.reload();
					$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
						var id = $(e.target).attr("href").substr(1);
						window.location.hash = id;
					});
					var hash = window.location.hash;
					$('#fy_tabs a[href="' + hash + '"]').tab('show');
				}
			},
		});
	})
{{-- add end--}}

{{-- update start --}}
	function init_edit_bp_form6(){
		init_view_bp_form6()
		$('.bp-form6-field')
			.attr('disabled', false);

		$('.edit_bp_form6.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);
	}

	$('.btn_edit_bp_form6').on('click', function(e){  
		init_edit_bp_form6();
		bp_form6_id = $(this).data('id');
		$('#bp_form6_modal_header').html("Edit BP Form No. 6");     
		var request = view_bp_form6(bp_form6_id);
		request.then(function(data) {
			if(data['status'] == 1){                 
				$('#bp_form6_tier').val(data['bp_form6']['tier']) 
				$('#bp_form6_description').val(data['bp_form6']['description']) 
				$('#bp_form6_quantity').val(data['bp_form6']['quantity']) 
				$('#bp_form6_unit_cost').val(data['bp_form6']['unit_cost']) 
				$('#bp_form6_total_cost').val(data['bp_form6']['total_cost']) 
				$('#bp_form6_organizational_deployment').val(data['bp_form6']['organizational_deployment']) 
				$('#bp_form6_justification').val(data['bp_form6']['justification']) 
				$('#bp_form6_remarks').val(data['bp_form6']['remarks'])
			}           
		})
		$('#bp_form6_modal').modal('toggle')            
	})

	$('.edit_bp_form6').on('click', function(e){
		e.preventDefault();
		clear_attributes()
		Swal.fire({
			title: 'Are you sure you want to save changes?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes'
		})
		.then((result) => {
			if (result.value) {
				var request = $.ajax({
					method: "PATCH",
					url: "{{ route('bp_form6.update') }}",
					data: {
						'_token': '{{ csrf_token() }}',
						'id' : bp_form6_id,
						'tier' : $('#bp_form6_tier').val(),
						'description' : $('#bp_form6_description').val(),
						'quantity' : $('#bp_form6_quantity').val(),
						'unit_cost' : $('#bp_form6_unit_cost').val(),
						'total_cost' : $('#bp_form6_total_cost').val(),
						'organizational_deployment' : $('#bp_form6_organizational_deployment').val(),
						'justification' : $('#bp_form6_justification').val(),
						'remarks' : $('#bp_form6_remarks').val(),
					},
					success:function(data) {
						console.log(data);
						if(data.errors) {         
							if(data.errors.description){
								$('#bp_form6_description').addClass('is-invalid');
								$('#bp-form6-description-error').html(data.errors.description[0]);
							}   
							if(data.errors.quantity){
								$('#bp_form6_quantity').addClass('is-invalid');
								$('#bp-form6-quantity-error').html(data.errors.quantity[0]);
							} 
							if(data.errors.unit_cost){
								$('#bp_form6_unit_cost').addClass('is-invalid');
								$('#bp-form6-unit-cost-error').html(data.errors.unit_cost[0]);
							} 
							if(data.errors.total_cost){
								$('#bp_form6_total_cost').addClass('is-invalid');
								$('#bp-form6-total-cost-error').html(data.errors.total_cost[0]);
							} 
							if(data.errors.organizational_deployment){
								$('#bp_form6_organizational_deployment').addClass('is-invalid');
								$('#bp-form6-organizational-deployment-error').html(data.errors.organizational_deployment[0]);
							} 
							if(data.errors.justification){
								$('#bp_form6_justification').addClass('is-invalid');
								$('#bp-form6-justification-error').html(data.errors.justification[0]);
							}                                   
						}
						if(data.success) {            
							Swal.fire({
								position: 'top-end',
								icon: 'success',
								title: 'Record has been successfully edited.',
								showConfirmButton: false,
								timer: 1500
							}) 
							$('#bp_form6_modal').modal('toggle')
							window.location.reload();
							$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
								var id = $(e.target).attr("href").substr(1);
								window.location.hash = id;
							});
							var hash = window.location.hash;
							$('#fy_tabs a[href="' + hash + '"]').tab('show');
						}                      
					}                             
				});                                
			}       
		})   
	}) 

	$('#update_bp_form6').on('click', function(event){
		event.preventDefault();
		clear_attributes()
		Swal.fire({
			title: 'Are you sure you want to save changes?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes'
		})
		.then((result) => {
			if (result.value) {
			var request = $.ajax({
				method: "PATCH",
			url: "{{ route('bp_form6.update') }}",
			data: {
			'_token': '{{ csrf_token() }}',
			'id' : bp_form6_id,
			'division_id' : $('#bp_form6_division_id').val(),
			'year' : $('#year_selected').val(),
			'tier' : $('#bp_form6_tier').val(),
			'description' : $('#bp_form6_description').val(),
			'quantity' : $('#bp_form6_quantity').val(),
			'unit_cost' : $('#bp_form6_unit_cost').val(),
			'total_cost' : $('#bp_form6_total_cost').val(),
			'organizational_deployment' : $('#bp_form6_organizational_deployment').val(),
			'justification' : $('#bp_form6_justification').val(),
			'remarks' : $('#bp_form6_remarks').val(),
			},
			success:function(data) {
			console.log(data);
			if(data.errors) {         
				if(data.errors.description){
					$('#bp_form6_description').addClass('is-invalid');
					$('#bp-form6-description-error').html(data.errors.description[0]);
				}   
				if(data.errors.quantity){
					$('#bp_form6_quantity').addClass('is-invalid');
					$('#bp-form6-quantity-error').html(data.errors.quantity[0]);
				} 
				if(data.errors.unit_cost){
					$('#bp_form6_unit_cost').addClass('is-invalid');
					$('#bp-form6-unit-cost-error').html(data.errors.unit_cost[0]);
				} 
				if(data.errors.total_cost){
					$('#bp_form6_total_cost').addClass('is-invalid');
					$('#bp-form6-total-cost-error').html(data.errors.total_cost[0]);
				} 
				if(data.errors.organizational_deployment){
					$('#bp_form6_organizational_deployment').addClass('is-invalid');
					$('#bp-form6-organizational-deployment-error').html(data.errors.organizational_deployment[0]);
				} 
				if(data.errors.justification){
					$('#bp_form6_justification').addClass('is-invalid');
					$('#bp-form6-justification-error').html(data.errors.justification[0]);
				}                              
			}
			if(data.success) {            
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Record has been successfully edited.',
					showConfirmButton: false,
					timer: 1500
				}) 
				$('#bp_form6_modal').modal('toggle')
				$('#bp_form6_table').DataTable().ajax.reload();
			}                      
			}                             
			});                                
			}       
		})   
	}) 
{{-- update end--}}

{{-- delete start --}}
	$('.btn_delete_bp_form6').on('click', function(e){
		bp_form6_id = $(this).data('id');
		delete_bp_form6(bp_form6_id);
	})

	function delete_bp_form6(bp_form6_id){
		Swal.fire({
			title: 'Are you sure you want to delete?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes'
		})
		.then((result) => {
			if (result.value) {
			$.ajax({
				method: "PATCH",
				url: "{{ route('bp_form6.delete') }}",
				data: {
					'_token': '{{ csrf_token() }}',
					'id' : bp_form6_id
				},
				success: function(data) {      
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Record has been successfully deleted.',
						showConfirmButton: false,
						timer: 1500
					}) 
					window.location.reload();
					$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
						var id = $(e.target).attr("href").substr(1);
						window.location.hash = id;
					});
					var hash = window.location.hash;
					$('#fy_tabs a[href="' + hash + '"]').tab('show');   
				}             
			})    
			}       
		})
	}
{{-- delete end --}} 