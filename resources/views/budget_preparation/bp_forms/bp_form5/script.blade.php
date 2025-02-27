{{-- modal start --}}	
	$('#bp_form5_modal').on('hide.bs.modal', function(){  
      init_view_bp_form5();   
      clear_attributes();
      clearFields
   });  
   $('#bp_form5_modal').on('shown.bs.modal', function () {
      $('#bp_form5_description').focus();
   })  
{{-- modal end --}}

{{-- view start --}}   
	function init_view_bp_form5(){
		$('.bp-form5-field')
			.val('')
			.attr('disabled', true);

		$('.save-buttons')
			.removeClass('d-inline')
			.addClass('d-none')
			.attr('disabled', true);
	}

	function view_bp_form5(bp_form5_id){
		var request = $.ajax({
			method: "GET",
			url: "{{ route('bp_form5.show') }}",
			data: {
			'_token': '{{ csrf_token() }}',
			'id' : bp_form5_id
			}
		});
		return request;
	}

	$('.btn_view_bp_form5').on('click', function(e){    
      $('#bp_form5_modal_header').html("View BP Form No. 5"); 
      bp_form5_id = $(this).data('id');
      init_view_bp_form5();   
      var request = view_bp_form5(bp_form5_id);   
      request.then(function(data) {
         if(data['status'] == 1){
				$('#bp_form5_tier').val(data['bp_form5']['tier']) 
				$('#bp_form5_description').val(data['bp_form5']['description']) 
				$('#bp_form5_area_sqm').val(data['bp_form5']['area_sqm']) 
				$('#bp_form5_location').val(data['bp_form5']['location']) 
				$('#bp_form5_amount').val(data['bp_form5']['amount']) 
				$('#bp_form5_justification').val(data['bp_form5']['justification']) 
				$('#bp_form5_remarks').val(data['bp_form5']['remarks'])
         }                          
      })
      $('#bp_form5_modal').modal('toggle');
   }) 
{{-- view end --}}

{{-- add start --}}
	function init_add_bp_form5(){
		$('.bp-form5-field')
			.attr('disabled', false);
			
		$('.add_bp_form5.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);      
	}

	$('.btn_add_bp_form5').on('click', function(){    
      init_add_bp_form5();
      var division_id=$(this).data('division-id');      
      var year=$(this).data('year');      
      var fiscal_year=$(this).data('fy');  
      $('#bp_form5_year').val(year);
      $('#bp_form5_fiscal_year').val(fiscal_year);
      $('#bp_form5_modal_header').html("Add BP Form No. 5");
      $('#bp_form5_modal').modal('toggle')       
   })

	$('.add_bp_form5').on('click', function(e){        
      e.prevenDefault;  
      clear_attributes();
      $.ajax({
         method: "POST",
         url: "{{ route('bp_form5.store') }}",
         data: {
				'_token': '{{ csrf_token() }}',
				'division_id' : $('#bp_form5_division_id').val(),
				'year' : $('#bp_form5_year').val(),
				'tier' : $('#bp_form5_tier').val(),
				'fiscal_year' : $('#bp_form5_fiscal_year').val(),
				'description' : $('#bp_form5_description').val(),
				'quantity' : $('#bp_form5_quantity').val(),
				'unit_cost' : $('#bp_form5_unit_cost').val(),
				'total_cost' : $('#bp_form5_total_cost').val(),
				'organizational_deployment' : $('#bp_form5_organizational_deployment').val(),
				'justification' : $('#bp_form5_justification').val(),
				'remarks' : $('#bp_form5_remarks').val(),
         },
         success:function(data) {
            console.log(data);
            if(data.errors) {         
               if(data.errors.description){
						$('#bp_form5_description').addClass('is-invalid');
						$('#bp-form5-description-error').html(data.errors.description[0]);
					}   
					if(data.errors.description){
						$('#bp_form5_description').addClass('is-invalid');
						$('#bp-form5-description-error').html(data.errors.description[0]);
					} 
					if(data.errors.quantity){
						$('#bp_form5_quantity').addClass('is-invalid');
						$('#bp-form5-quantity-error').html(data.errors.quantity[0]);
					} 
					if(data.errors.unit_cost){
						$('#bp_form5_unit_cost').addClass('is-invalid');
						$('#bp-form5-unit-cost-error').html(data.errors.unit_cost[0]);
					} 
					if(data.errors.organizational_deployment){
						$('#bp_form5_organizational_deployment').addClass('is-invalid');
						$('#bp-form5-organizational-deployment-error').html(data.errors.organizational_deployment[0]);
					} 
					if(data.errors.justification){
						$('#bp_form5_justification').addClass('is-invalid');
						$('#bp-form5-justification-error').html(data.errors.justification[0]);
					}                                
            }
            if(data.success) {
               Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'BP Form No. 5 has been successfully added.',
                  showConfirmButton: false,
                  timer: 1500
               }) 
               $('#bp_form5_modal').modal('toggle');  
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
	function init_edit_bp_form5(){
		init_view_bp_form5()
		$('.bp-form5-field')
			.attr('disabled', false);

		$('.edit_bp_form5.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);
	}

	$('.btn_edit_bp_form5').on('click', function(e){  
		init_edit_bp_form5();
		bp_form5_id = $(this).data('id');
		$('#bp_form5_modal_header').html("Edit BP Form No. 5");     
		var request = view_bp_form5(bp_form5_id);
		request.then(function(data) {
			if(data['status'] == 1){     
				$('#bp_form5_tier').val(data['bp_form5']['tier']) 
				$('#bp_form5_description').val(data['bp_form5']['description']) 
				$('#bp_form5_quantity').val(data['bp_form5']['quantity']) 
				$('#bp_form5_unit_cost').val(data['bp_form5']['unit_cost']) 
				$('#bp_form5_total_cost').val(data['bp_form5']['total_cost']) 
				$('#bp_form5_organizational_deployment').val(data['bp_form5']['organizational_deployment']) 
				$('#bp_form5_justification').val(data['bp_form5']['justification']) 
				$('#bp_form5_remarks').val(data['bp_form5']['remarks'])
			}           
		})
		$('#bp_form5_modal').modal('toggle')            
	})

	$('.edit_bp_form5').on('click', function(e){
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
					url: "{{ route('bp_form5.update') }}",
					data: {
						'_token': '{{ csrf_token() }}',
						'id' : bp_form5_id,
						'tier' : $('#bp_form5_tier').val(),
						'description' : $('#bp_form5_description').val(),
						'quantity' : $('#bp_form5_quantity').val(),
						'unit_cost' : $('#bp_form5_unit_cost').val(),
						'total_cost' : $('#bp_form5_total_cost').val(),
						'organizational_deployment' : $('#bp_form5_organizational_deployment').val(),
						'justification' : $('#bp_form5_justification').val(),
						'remarks' : $('#bp_form5_remarks').val(),
					},
					success:function(data) {
						console.log(data);
						if(data.errors) {         
							if(data.errors.description){
								$('#bp_form5_description').addClass('is-invalid');
								$('#bp-form5-description-error').html(data.errors.description[0]);
							}
							if(data.errors.quantity){
								$('#bp_form5_quantity').addClass('is-invalid');
								$('#bp-form5-quantity-error').html(data.errors.quantity[0]);
							} 
							if(data.errors.unit_cost){
								$('#bp_form5_unit_cost').addClass('is-invalid');
								$('#bp-form5-unit-cost-error').html(data.errors.unit_cost[0]);
							} 
							if(data.errors.organizational_deployment){
								$('#bp_form5_organizational_deployment').addClass('is-invalid');
								$('#bp-form5-organizational-deployment-error').html(data.errors.organizational_deployment[0]);
							} 
							if(data.errors.justification){
								$('#bp_form5_justification').addClass('is-invalid');
								$('#bp-form5-justification-error').html(data.errors.justification[0]);
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
							$('#bp_form5_modal').modal('toggle')
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
	$('.btn_delete_bp_form5').on('click', function(e){
		bp_form5_id = $(this).data('id');
		delete_bp_form5(bp_form5_id);
	})

	function delete_bp_form5(bp_form5_id){
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
				url: "{{ route('bp_form5.delete') }}",
				data: {
					'_token': '{{ csrf_token() }}',
					'id' : bp_form5_id
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