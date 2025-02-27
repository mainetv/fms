{{-- modal start --}}
	$('#bp_form4_modal').on('hide.bs.modal', function(){     
		init_view_bp_form4();
		clear_attributes();
		clearFields
 	}); 
	
	$('#bp_form4_modal').on('shown.bs.modal', function () {
		$('#bp_form4_description').focus();
	})  

{{-- modal end --}}

{{-- view start --}}   
	function init_view_bp_form4(){
		$('.bp-form4-field')
		.val('')
		.attr('disabled', true);

		$('.save-buttons')
		.removeClass('d-inline')
		.addClass('d-none')
		.attr('disabled', true);
	}

	function view_bp_form4(bp_form4_id){
		var request = $.ajax({
		method: "GET",
		url: "{{ route('bp_form4.show') }}",
		data: {
			'_token': '{{ csrf_token() }}',
			'id' : bp_form4_id
		}
		});
		return request;
	}

	$('.btn_view_bp_form4').on('click', function(e){     
		$('#bp_form4_modal_header').html("View BP Form No. 4");     
		bp_form4_id = $(this).data('id');
		init_view_bp_form4();   
		var request = view_bp_form4(bp_form4_id);   
		request.then(function(data) {
		if(data['status'] == 1){
			$('#bp_form4_tier').val(data['bp_form4']['tier']) 
			$('#bp_form4_description').val(data['bp_form4']['description']) 
			$('#bp_form4_num_years_completion').val(data['bp_form4']['num_years_completion']) 
			$('#bp_form4_total_cost').val(data['bp_form4']['total_cost']) 
			$('#bp_form4_amount').val(data['bp_form4']['amount']) 
			$('#bp_form4_justification').val(data['bp_form4']['justification']) 
			$('#bp_form4_remarks').val(data['bp_form4']['remarks'])
		}                          
		})
		$('#bp_form4_modal').modal('toggle');
	})  
{{-- view end --}}

{{-- add start --}}
	function init_add_bp_form4(){
		$('.bp-form4-field')
			.attr('disabled', false);
			
		$('.add_bp_form4.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);      
	}

	$('.btn_add_bp_form4').on('click', function(){    
		init_add_bp_form4();
		var division_id=$(this).data('division-id');      
		var year=$(this).data('year');      
		var fiscal_year=$(this).data('fy');  
		$('#bp_form4_year').val(year);
		$('#bp_form4_fiscal_year').val(fiscal_year);
		$('#bp_form4_modal_header').html("Add BP Form No. 4");
		$('#bp_form4_modal').modal('toggle')       
	})

	$('.add_bp_form4').on('click', function(e){        
		e.prevenDefault;  
		clear_attributes();
		$.ajax({
			method: "POST",
			url: "{{ route('bp_form4.store') }}",
			data: {
			'_token': '{{ csrf_token() }}',
			'division_id' : $('#bp_form4_division_id').val(),
         'year' : $('#bp_form4_year').val(),
         'tier' : $('#bp_form4_tier').val(),
         'fiscal_year' : $('#bp_form4_fiscal_year').val(),
			'description' : $('#bp_form4_description').val(),
			'amount' : $('#bp_form4_amount').val(),
			'num_years_completion' : $('#bp_form4_num_years_completion').val(),
			'date_started' : $('#bp_form4_date_started').val(),
			'total_cost' : $('#bp_form4_total_cost').val(),
			'justification' : $('#bp_form4_justification').val(),
			'remarks' : $('#bp_form4_remarks').val(),
			},
			success:function(data) {
			console.log(data);
			if(data.errors) {         
				if(data.errors.description){
					$('#bp_form4_description').addClass('is-invalid');
					$('#bp-form4-description-error').html(data.errors.description[0]);
				}   
				if(data.errors.amount){
					$('#bp_form4_amount').addClass('is-invalid');
					$('#bp-form4-amount-error').html(data.errors.amount[0]);
				} 
				if(data.errors.num_years_completion){
					$('#bp_form4_num_years_completion').addClass('is-invalid');
					$('#bp-form4-num-years-completion-error').html(data.errors.num_years_completion[0]);
				} 
				if(data.errors.date_started){
					$('#bp_form4_date_started').addClass('is-invalid');
					$('#bp-form4-date-started-error').html(data.errors.date_started[0]);
				} 
				if(data.errors.total_cost){
					$('#bp_form4_total_cost').addClass('is-invalid');
					$('#bp-form4-total-cost-error').html(data.errors.total_cost[0]);
				} 
				if(data.errors.justification){
					$('#bp_form4_justification').addClass('is-invalid');
					$('#bp-form4-justification-error').html(data.errors.justification[0]);
				}                                
			}
			if(data.success) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'BP Form No. 4 has been successfully added.',
					showConfirmButton: false,
					timer: 1500
				}) 
				$('#bp_form4_modal').modal('toggle');
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
	function init_edit_bp_form4(){
		init_view_bp_form4()
		$('.bp-form4-field')
			.attr('disabled', false);

		$('.edit_bp_form4.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);
	}

	$('.btn_edit_bp_form4').on('click', function(e){  
      init_edit_bp_form4();
      bp_form4_id = $(this).data('id');
      $('#bp_form4_modal_header').html("Edit BP Form No. 4");     
      var request = view_bp_form4(bp_form4_id);
      request.then(function(data) {
         if(data['status'] == 1){     
				$('#bp_form4_tier').val(data['bp_form4']['tier']) 
				$('#bp_form4_description').val(data['bp_form4']['description']) 
				$('#bp_form4_amount').val(data['bp_form4']['amount']) 
				$('#bp_form4_num_years_completion').val(data['bp_form4']['num_years_completion']) 
				$('#bp_form4_total_cost').val(data['bp_form4']['total_cost']) 
				$('#bp_form4_date_started').val(data['bp_form4']['date_started']) 
				$('#bp_form4_justification').val(data['bp_form4']['justification']) 
				$('#bp_form4_remarks').val(data['bp_form4']['remarks'])
         }           
      })
      $('#bp_form4_modal').modal('toggle')            
   })

	$('.edit_bp_form4').on('click', function(e){
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
               url: "{{ route('bp_form4.update') }}",
               data: {
                  '_token': '{{ csrf_token() }}',
                  'id' : bp_form4_id,
                  'tier' : $('#bp_form4_tier').val(),
                  'description' : $('#bp_form4_description').val(),
						'amount' : $('#bp_form4_amount').val(),
						'num_years_completion' : $('#bp_form4_num_years_completion').val(),
						'date_started' : $('#bp_form4_date_started').val(),
						'total_cost' : $('#bp_form4_total_cost').val(),
						'justification' : $('#bp_form4_justification').val(),
						'remarks' : $('#bp_form4_remarks').val(),
               },
               success:function(data) {
                  console.log(data);
                  if(data.errors) {         
                     if(data.errors.description){
								$('#bp_form4_description').addClass('is-invalid');
								$('#bp-form4-description-error').html(data.errors.description[0]);
							}   
							if(data.errors.amount){
								$('#bp_form4_amount').addClass('is-invalid');
								$('#bp-form4-amount-error').html(data.errors.amount[0]);
							} 
							if(data.errors.num_years_completion){
								$('#bp_form4_num_years_completion').addClass('is-invalid');
								$('#bp-form4-num-years-completion-error').html(data.errors.num_years_completion[0]);
							} 
							if(data.errors.date_started){
								$('#bp_form4_date_started').addClass('is-invalid');
								$('#bp-form4-date-started-error').html(data.errors.date_started[0]);
							} 
							if(data.errors.total_cost){
								$('#bp_form4_total_cost').addClass('is-invalid');
								$('#bp-form4-total-cost-error').html(data.errors.total_cost[0]);
							} 
							if(data.errors.justification){
								$('#bp_form4_justification').addClass('is-invalid');
								$('#bp-form4-justification-error').html(data.errors.justification[0]);
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
                     $('#bp_form4_modal').modal('toggle')
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
	$('.btn_delete_bp_form4').on('click', function(e){
		bp_form4_id = $(this).data('id');
		delete_bp_form4(bp_form4_id);
	})

	function delete_bp_form4(bp_form4_id){
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
				url: "{{ route('bp_form4.delete') }}",
				data: {
					'_token': '{{ csrf_token() }}',
					'id' : bp_form4_id
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