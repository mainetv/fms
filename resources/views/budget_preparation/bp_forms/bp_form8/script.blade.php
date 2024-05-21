{{-- modal start --}}
	$('#bp_form8_modal').on('hide.bs.modal', function(){     
		clear_attributes();
		clear_fields();
 	});  
{{-- modal end --}}

{{-- view start --}}   
	function init_view_bp_form8(){
		$('.bp-form8-field')
			.val('')
			.attr('disabled', true);

		$('.save-buttons')
			.removeClass('d-inline')
			.addClass('d-none')
			.attr('disabled', true);
	}

	function view_bp_form8(bp_form8_id){
		var request = $.ajax({
			method: "GET",
			url: "{{ route('bp_form8.show') }}",
			data: {
			'_token': '{{ csrf_token() }}',
			'id' : bp_form8_id
			}
		});
		return request;
	}

	$('.btn_view_bp_form8').on('click', function(e){    
      $('#bp_form8_modal_header').html("View BP Form No. 8"); 
      bp_form8_id = $(this).data('id');
      init_view_bp_form8();   
      var request = view_bp_form8(bp_form8_id);   
      request.then(function(data) {
         if(data['status'] == 1){            
            $('#bp_form8_name').val(data['bp_form8']['name']) 
				$('#bp_form8_proposed_date').val(data['bp_form8']['proposed_date']) 
				$('#bp_form8_destination').val(data['bp_form8']['destination']) 
				$('#bp_form8_amount').val(data['bp_form8']['amount']) 
				$('#bp_form8_purpose_travel').val(data['bp_form8']['purpose_travel']) 
				$('#bp_form8_remarks').val(data['bp_form8']['remarks'])
         }                          
      })
      $('#bp_form8_modal').modal('toggle');
   }) 
{{-- view end --}}

{{-- add start --}}
	function init_add_bp_form8(){
		$('.bp-form8-field')
			.attr('disabled', false);
			
		$('.add_bp_form8.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);      
	}

	$('.btn_add_bp_form8').on('click', function(){    
		init_add_bp_form8();
		var division_id=$(this).data('division-id');      
		var year=$(this).data('year');      
		var fiscal_year=$(this).data('fy');  
		$('#bp_form8_year').val(year);
		$('#bp_form8_fiscal_year').val(fiscal_year);
		$('#bp_form8_modal_header').html("Add BP Form No. 3");
		$('#bp_form8_modal').modal('toggle')       
	})

	$('.add_bp_form8').on('click', function(e){        
		e.prevenDefault;  
		clear_attributes();
		$.ajax({
			method: "POST",
			url: "{{ route('bp_form8.store') }}",
			data: {
				'_token': '{{ csrf_token() }}',
				'division_id' : $('#bp_form8_division_id').val(),
				'year' : $('#bp_form8_year').val(),
				'fiscal_year' : $('#bp_form8_fiscal_year').val(),
				'name' : $('#bp_form8_name').val(),
				'proposed_date' : $('#bp_form8_proposed_date').val(),
				'destination' : $('#bp_form8_destination').val(),
				'amount' : $('#bp_form8_amount').val(),
				'purpose_travel' : $('#bp_form8_purpose_travel').val(),
				'remarks' : $('#bp_form8_remarks').val(),
			},
			success:function(data) {
				console.log(data);
				if(data.errors) {         
					if(data.errors.name){
						$('#bp_form8_name').addClass('is-invalid');
						$('#bp-form8-name-error').html(data.errors.name[0]);
					}   
					if(data.errors.proposed_date){
						$('#bp_form8_proposed_date').addClass('is-invalid');
						$('#bp-form8-proposed-date-error').html(data.errors.proposed_date[0]);
					} 
					if(data.errors.destination){
						$('#bp_form8_destination').addClass('is-invalid');
						$('#bp-form8-destination-error').html(data.errors.destination[0]);
					} 
					if(data.errors.amount){
						$('#bp_form8_amount').addClass('is-invalid');
						$('#bp-form8-amount-error').html(data.errors.amount[0]);
					} 
					if(data.errors.purpose_travel){
						$('#bp_form8_purpose_travel').addClass('is-invalid');
						$('#bp-form8-purpose-travel-error').html(data.errors.purpose_travel[0]);
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
					$('#bp_form8_modal').modal('toggle');  
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
	function init_edit_bp_form8(){
		init_view_bp_form8()
		$('.bp-form8-field')
			.attr('disabled', false);

		$('.edit_bp_form8.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);
	}

	$('.btn_edit_bp_form8').on('click', function(e){  
		init_edit_bp_form8();
		bp_form8_id = $(this).data('id');
		$('#bp_form8_modal_header').html("Edit BP Form No. 8");     
		var request = view_bp_form8(bp_form8_id);
		request.then(function(data) {
			if(data['status'] == 1){                 
				$('#bp_form8_name').val(data['bp_form8']['name']) 
				$('#bp_form8_proposed_date').val(data['bp_form8']['proposed_date']) 
				$('#bp_form8_destination').val(data['bp_form8']['destination']) 
				$('#bp_form8_amount').val(data['bp_form8']['amount']) 
				$('#bp_form8_purpose_travel').val(data['bp_form8']['purpose_travel']) 
				$('#bp_form8_remarks').val(data['bp_form8']['remarks'])
			}           
		})
		$('#bp_form8_modal').modal('toggle')            
	})

	$('.edit_bp_form8').on('click', function(e){
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
					url: "{{ route('bp_form8.update') }}",
					data: {
						'_token': '{{ csrf_token() }}',
						'id' : bp_form8_id,
						'name' : $('#bp_form8_name').val(),
						'proposed_date' : $('#bp_form8_proposed_date').val(),
						'destination' : $('#bp_form8_destination').val(),
						'amount' : $('#bp_form8_amount').val(),
						'purpose_travel' : $('#bp_form8_purpose_travel').val(),
						'remarks' : $('#bp_form8_remarks').val(),
					},
					success:function(data) {
						console.log(data);
						if(data.errors) {         
							if(data.errors.name){
								$('#bp_form8_name').addClass('is-invalid');
								$('#bp-form8-name-error').html(data.errors.name[0]);
							}   
							if(data.errors.proposed_date){
								$('#bp_form8_proposed_date').addClass('is-invalid');
								$('#bp-form8-proposed-date-error').html(data.errors.proposed_date[0]);
							} 
							if(data.errors.destination){
								$('#bp_form8_destination').addClass('is-invalid');
								$('#bp-form8-destination-error').html(data.errors.destination[0]);
							} 
							if(data.errors.amount){
								$('#bp_form8_amount').addClass('is-invalid');
								$('#bp-form8-amount-error').html(data.errors.amount[0]);
							} 
							if(data.errors.purpose_travel){
								$('#bp_form8_purpose_travel').addClass('is-invalid');
								$('#bp-form8-purpose-travel-error').html(data.errors.purpose_travel[0]);
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
							$('#bp_form8_modal').modal('toggle')
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
{{-- update end--}}

{{-- delete start --}}
	$('.btn_delete_bp_form8').on('click', function(e){
		bp_form8_id = $(this).data('id');
		delete_bp_form8(bp_form8_id);
	})

	function delete_bp_form8(bp_form8_id){
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
				url: "{{ route('bp_form8.delete') }}",
				data: {
					'_token': '{{ csrf_token() }}',
					'id' : bp_form8_id
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